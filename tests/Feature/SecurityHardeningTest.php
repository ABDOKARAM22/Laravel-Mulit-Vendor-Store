<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->store = Store::factory()->create();
    $this->vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $this->store->id,
    ]);
    $this->category = Category::factory()->create();
});

function securityProductPayload(): array
{
    return [
        'name' => 'Secure Product',
        'category_id' => test()->category->id,
        'description' => 'Description',
        'price' => 10,
        'featured' => 0,
        'status' => 'Draft',
    ];
}

test('product uploads reject SVG and oversized files', function () {
    $this->actingAs($this->vendor, 'admin');

    $this->post(route('dashboard.products.store'), [
        ...securityProductPayload(),
        'image' => UploadedFile::fake()->create('product.svg', 1, 'image/svg+xml'),
    ])->assertSessionHasErrors('image');

    $this->post(route('dashboard.products.store'), [
        ...securityProductPayload(),
        'image' => UploadedFile::fake()->create('product.jpg', 2049, 'image/jpeg'),
    ])->assertSessionHasErrors('image');
});

test('product ownership fields cannot be assigned by the client', function () {
    $otherStore = Store::factory()->create();

    $this->actingAs($this->vendor, 'admin')
        ->post(route('dashboard.products.store'), [
            ...securityProductPayload(),
            'store_id' => $otherStore->id,
            'image' => UploadedFile::fake()->create('product.jpg', 10, 'image/jpeg'),
        ])
        ->assertRedirect(route('dashboard.products.index'));

    expect(Product::latest('id')->first()->store_id)->toBe($this->store->id);
});

test('order ownership fields are not mass assignable', function () {
    expect((new Order)->getFillable())
        ->not->toContain('store_id')
        ->not->toContain('user_id');
});

test('state-changing cart requests require CSRF protection', function () {
    $middleware = app('router')->getRoutes()->getByName('cart.store')->gatherMiddleware();

    expect($middleware)->toContain('web');
});

test('cart exposes only implemented actions', function () {
    expect(app('router')->getRoutes()->getByName('cart.create'))->toBeNull()
        ->and(app('router')->getRoutes()->getByName('cart.show'))->toBeNull()
        ->and(app('router')->getRoutes()->getByName('cart.edit'))->toBeNull();
});
