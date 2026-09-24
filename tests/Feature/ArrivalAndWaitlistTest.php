<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('expecting parents past their due date see the arrival banner', function () {
    $user = User::factory()->create([
        'parent_type' => 'expecting',
        'child_date'  => now()->subDay()->toDateString(),
    ]);

    $this->actingAs($user)->get('/dashboard')->assertSee('Has your baby arrived?');
});

test('the arrival banner is hidden before the due date', function () {
    $user = User::factory()->create([
        'parent_type' => 'expecting',
        'child_date'  => now()->addWeek()->toDateString(),
    ]);

    $this->actingAs($user)->get('/dashboard')->assertDontSee('Has your baby arrived?');
});

test('confirming arrival switches the user to new parent', function () {
    $user = User::factory()->create([
        'parent_type' => 'expecting',
        'child_date'  => now()->subDay()->toDateString(),
    ]);

    $this->actingAs($user)->post('/arrival')->assertRedirect('/dashboard');

    expect($user->refresh()->parent_type)->toBe('new_parent');
});

test('snoozing hides the arrival banner for a week', function () {
    $user = User::factory()->create([
        'parent_type' => 'expecting',
        'child_date'  => now()->subDay()->toDateString(),
    ]);

    $this->actingAs($user)->post('/arrival/snooze')->assertRedirect('/dashboard');

    $this->actingAs($user)->get('/dashboard')->assertDontSee('Has your baby arrived?');
    expect($user->refresh()->parent_type)->toBe('expecting');
});

test('a user can join the expert waitlist with topics', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson('/waitlist', ['topics' => ['sleep', 'feeding']])
        ->assertOk()
        ->assertJson(['joined' => true]);

    expect($user->waitlistSignup->topics)->toBe(['sleep', 'feeding']);
});

test('joining the waitlist again updates topics instead of duplicating', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->postJson('/waitlist', ['topics' => ['sleep']]);
    $this->actingAs($user)->postJson('/waitlist', ['topics' => ['behaviour']]);

    expect($user->waitlistSignup()->count())->toBe(1)
        ->and($user->refresh()->waitlistSignup->topics)->toBe(['behaviour']);
});

test('waitlist rejects unknown topics', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson('/waitlist', ['topics' => ['astrology']])
        ->assertStatus(422);
});

test('the dashboard shows the waitlist confirmation once joined', function () {
    $user = User::factory()->create();
    $user->waitlistSignup()->create(['topics' => ['sleep']]);

    $this->actingAs($user)->get('/dashboard')->assertSee("You're on the list");
});
