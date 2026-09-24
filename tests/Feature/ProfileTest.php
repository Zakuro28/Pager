<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('guests cannot see the profile page', function () {
    $this->get('/profile')->assertRedirect('/login');
});

test('the profile page shows the current parent type', function () {
    $user = User::factory()->create(['parent_type' => 'expecting']);

    $this->actingAs($user)->get('/profile')
        ->assertOk()
        ->assertSee('Your stage')
        ->assertSee('value="expecting" checked', false);
});

test('a user can change their name, parent type and child date', function () {
    $user = User::factory()->create(['parent_type' => 'expecting']);

    $this->actingAs($user)->patch('/profile', [
        'name'        => 'Maria Santos',
        'parent_type' => 'new_parent',
        'child_date'  => '2026-06-14',
    ])->assertRedirect('/profile');

    $user->refresh();
    expect($user->name)->toBe('Maria Santos')
        ->and($user->parent_type)->toBe('new_parent')
        ->and($user->child_date->toDateString())->toBe('2026-06-14');
});

test('profile update rejects an unknown parent type', function () {
    $user = User::factory()->create(['parent_type' => 'expecting']);

    $this->actingAs($user)->patch('/profile', [
        'name'        => 'Maria',
        'parent_type' => 'astronaut',
    ])->assertSessionHasErrors('parent_type');

    expect($user->refresh()->parent_type)->toBe('expecting');
});

test('deleting the account requires the correct password', function () {
    $user = User::factory()->create(['password' => Hash::make('secret-pass')]);

    $this->actingAs($user)->delete('/profile', ['password' => 'wrong'])
        ->assertSessionHasErrors('password');
    $this->assertModelExists($user);

    $this->actingAs($user)->delete('/profile', ['password' => 'secret-pass'])
        ->assertRedirect('/');
    $this->assertModelMissing($user);
    $this->assertGuest();
});
