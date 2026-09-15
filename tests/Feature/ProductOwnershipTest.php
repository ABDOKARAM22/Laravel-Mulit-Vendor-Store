<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('uploads');
    $this->category = Category::factory()->create();
    $this->storeA = Store::factory()->create();
    $this->storeB = Store::factory()->create();
    $this->vendorA = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $this->storeA->id,
    ]);
    $this->vendorB = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $this->storeB->id,
    ]);
    $this->productA = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'slug' => 'store-a-product',
        'status' => 'Active',
    ]);
    $this->productB = Product::factory()->create([
        'store_id' => $this->storeB->id,
        'category_id' => $this->category->id,
        'slug' => 'store-b-product',
        'status' => 'Active',
    ]);
});

test('vendor product listings are scoped to the assigned store', function () {
    $this->actingAs($this->vendorA, 'admin')
        ->get(route('dashboard.products.index'))
        ->assertOk()
        ->assertSee($this->productA->name)
        ->assertDontSee($this->productB->name);
});

test('vendor cannot access another store product through product routes', function () {
    $this->actingAs($this->vendorA, 'admin')
        ->get(route('dashboard.products.edit', $this->productB))
        ->assertForbidden();

    $this->actingAs($this->vendorA, 'admin')
        ->get(route('dashboard.products.show', $this->productB))
        ->assertForbidden();
});

test('vendor cannot modify or delete another store product', function () {
    $payload = [
        'name' => 'Tampered Product',
        'category_id' => $this->category->id,
        'description' => 'Attempted cross-store update',
        'price' => 10,
        'featured' => 0,
        'status' => 'Active',
        'store_id' => $this->storeA->id,
        'slug' => 'tampered-product',
    ];

    $this->actingAs($this->vendorA, 'admin')
        ->put(route('dashboard.products.update', $this->productB), $payload)
        ->assertForbidden();

    $this->actingAs($this->vendorA, 'admin')
        ->delete(route('dashboard.products.destroy', $this->productB))
        ->assertForbidden();

    expect($this->productB->fresh()->name)->not->toBe('Tampered Product');
});

test('vendor cannot reassign an owned product to another store', function () {
    $this->actingAs($this->vendorA, 'admin')
        ->put(route('dashboard.products.update', $this->productA), [
            'name' => 'Updated Store A Product',
            'category_id' => $this->category->id,
            'description' => 'Ownership must remain unchanged',
            'price' => 15,
            'featured' => 0,
            'status' => 'Active',
            'store_id' => $this->storeB->id,
        ])
        ->assertRedirect();

    expect($this->productA->fresh()->store_id)->toBe($this->storeA->id);
});

test('vendor cannot restore or force delete another store soft deleted product', function () {
    $this->productB->delete();

    $this->actingAs($this->vendorA, 'admin')
        ->put(route('dashboard.products.restore', $this->productB->id))
        ->assertForbidden();

    $this->actingAs($this->vendorA, 'admin')
        ->delete(route('dashboard.products.forcedelete', $this->productB->id))
        ->assertForbidden();

    expect(Product::withTrashed()->find($this->productB->id))->not->toBeNull();
});

test('authorized product force delete removes the record and media', function () {
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'image' => 'products/deleted-product.jpg',
    ]);
    Storage::fake('uploads');
    Storage::disk('uploads')->put($product->image, 'image');
    $product->delete();

    $this->actingAs($this->vendorA, 'admin')
        ->delete(route('dashboard.products.forcedelete', $product->id))
        ->assertRedirect(route('dashboard.products.trash'));

    expect(Product::withTrashed()->find($product->id))->toBeNull()
        ->and(Storage::disk('uploads')->exists('products/deleted-product.jpg'))->toBeFalse();
});

test('vendor product creation derives store ownership from the authenticated vendor', function () {
    $this->actingAs($this->vendorA, 'admin')
        ->post(route('dashboard.products.store'), [
            'name' => 'New Store Product',
            'category_id' => $this->category->id,
            'description' => 'Created by vendor',
            'image' => UploadedFile::fake()->create('product.jpg', 10, 'image/jpeg'),
            'price' => 25,
            'featured' => 0,
            'status' => 'Active',
            'store_id' => $this->storeB->id,
        ])
        ->assertRedirect(route('dashboard.products.index'));

    $created = Product::where('name', 'New Store Product')->firstOrFail();
    expect($created->store_id)->toBe($this->storeA->id);
});

test('admins moderate products globally but are not treated as store owners', function () {
    $admin = Admin::factory()->create(['role' => Admin::ROLE_ADMIN]);

    expect(Gate::forUser($admin)->allows('view', $this->productA))->toBeTrue()
        ->and(Gate::forUser($admin)->allows('update', $this->productB))->toBeTrue()
        ->and(Gate::forUser($admin)->allows('create', Product::class))->toBeFalse();

    $this->actingAs($admin, 'admin')
        ->get(route('dashboard.products.index'))
        ->assertSee($this->productA->name)
        ->assertSee($this->productB->name);
});

test('super admins have global access to products', function () {
    $superAdmin = Admin::factory()->create(['role' => Admin::ROLE_SUPER_ADMIN]);

    expect(Gate::forUser($superAdmin)->allows('view', $this->productA))->toBeTrue()
        ->and(Gate::forUser($superAdmin)->allows('update', $this->productB))->toBeTrue()
        ->and(Gate::forUser($superAdmin)->allows('delete', $this->productB))->toBeTrue();
});

test('customers only see active products in the public storefront', function () {
    $draft = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'slug' => 'draft-product',
        'status' => 'Draft',
    ]);

    $this->get(route('products.index'))
        ->assertOk()
        ->assertSee($this->productA->name)
        ->assertDontSee($draft->name);

    $this->get(route('products.show', $draft->slug))
        ->assertNotFound();
});

test('product slugs are generated uniquely without accepting client slugs', function () {
    $this->actingAs($this->vendorA, 'admin')
        ->post(route('dashboard.products.store'), [
            'name' => 'Store A Product',
            'category_id' => $this->category->id,
            'description' => 'Duplicate name with generated slug',
            'image' => UploadedFile::fake()->create('product.jpg', 10, 'image/jpeg'),
            'price' => 30,
            'featured' => 0,
            'status' => 'Active',
        ])
        ->assertRedirect(route('dashboard.products.index'));

    $created = Product::where('name', 'Store A Product')->firstOrFail();
    expect($created->slug)->toBe('store-a-product-1');
});
