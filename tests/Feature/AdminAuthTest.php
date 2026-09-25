<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function makeAdmin(array $attributes = []): User
{
    $admin = User::factory()->create($attributes + ['password' => Hash::make('admin-pass-123')]);
    $admin->forceFill(['is_admin' => true])->save();

    return $admin;
}

test('guests are sent to the admin login page', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});

test('a logged-in non-admin cannot open the admin panel', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/admin')->assertForbidden();
});

test('an admin can log in with email and password', function () {
    $admin = makeAdmin(['email' => 'owner@pager.test']);

    $this->post('/admin/login', ['email' => 'owner@pager.test', 'password' => 'admin-pass-123'])
        ->assertRedirect('/admin');

    $this->assertAuthenticatedAs($admin);
    $this->get('/admin')->assertOk();
});

test('admin login goes to the admin panel even if a user page was remembered', function () {
    makeAdmin(['email' => 'owner@pager.test']);

    $this->get('/dashboard'); // guest visit stores /dashboard as the "intended" URL

    $this->post('/admin/login', ['email' => 'owner@pager.test', 'password' => 'admin-pass-123'])
        ->assertRedirect('/admin');
});

test('a regular user cannot log in through the admin login', function () {
    User::factory()->create(['email' => 'parent@pager.test', 'password' => Hash::make('parent-pass-1')]);

    $this->post('/admin/login', ['email' => 'parent@pager.test', 'password' => 'parent-pass-1'])
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('the old hard-coded admin credentials no longer work', function () {
    $this->post('/admin/login', ['email' => 'admin', 'password' => 'admin123'])
        ->assertSessionHasErrors();

    $this->assertGuest();
});

test('is_admin cannot be set through registration', function () {
    $this->post('/register', [
        'name'                  => 'Sneaky',
        'email'                 => 'sneaky@pager.test',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
        'parent_type'           => 'new_parent',
        'is_admin'              => 1,
    ]);

    expect(User::where('email', 'sneaky@pager.test')->first()->is_admin)->toBeFalse();
});

test('non-admins cannot delete users', function () {
    $user   = User::factory()->create();
    $victim = User::factory()->create();

    $this->actingAs($user)->delete("/admin/users/{$victim->id}")->assertForbidden();
    $this->assertModelExists($victim);
});

test('an admin cannot delete their own account from the panel', function () {
    $admin = makeAdmin();

    $this->actingAs($admin)->delete("/admin/users/{$admin->id}")
        ->assertSessionHasErrors();
    $this->assertModelExists($admin);
});

test('the create-admin command makes a new admin account', function () {
    $this->artisan('pager:create-admin', [
        'email'      => 'boss@pager.test',
        '--name'     => 'Boss',
        '--password' => 'long-enough-pass',
    ])->assertSuccessful();

    $admin = User::where('email', 'boss@pager.test')->first();
    expect($admin->is_admin)->toBeTrue()
        ->and(Hash::check('long-enough-pass', $admin->password))->toBeTrue();
});

test('the create-admin command promotes an existing user', function () {
    $user = User::factory()->create(['email' => 'existing@pager.test']);

    $this->artisan('pager:create-admin', ['email' => 'existing@pager.test'])->assertSuccessful();

    expect($user->refresh()->is_admin)->toBeTrue();
});
