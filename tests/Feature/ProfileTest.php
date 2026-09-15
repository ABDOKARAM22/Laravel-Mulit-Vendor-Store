<?php

use App\Models\User;
use App\Models\Admin;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('dashboard profiles use the admin guard and shared admin profile relation', function () {
    $admin = Admin::factory()->create(['role' => Admin::ROLE_ADMIN]);

    $this->actingAs($admin, 'admin')
        ->get(route('dashboard.profile.edit'))
        ->assertOk();

    $this->actingAs($admin, 'admin')
        ->patch(route('dashboard.profile.update'), [
            'first_name' => 'Platform',
            'last_name' => 'Admin',
            'phone_number' => '123456789',
            'birthday' => '1990-01-01',
            'gender' => 'female',
            'street_address' => '1 Main Street',
            'city' => 'New York',
            'postal_code' => '10001',
            'country' => 'US',
            'language' => 'en',
        ])
        ->assertRedirect(route('dashboard.profile.edit'));

    expect($admin->fresh()->profile->admin_id)->toBe($admin->id)
        ->and($admin->fresh()->profile->user_id)->toBeNull();
});
