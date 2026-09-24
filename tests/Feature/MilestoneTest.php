<?php

use App\Models\User;
use App\Support\Milestones;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user can check and uncheck a milestone and it is saved to their account', function () {
    $user = User::factory()->create(['parent_type' => 'new_parent']);
    $key  = Milestones::keysFor('new_parent')[0];

    $this->actingAs($user)
        ->postJson('/milestones', ['key' => $key, 'checked' => true])
        ->assertOk()
        ->assertJson(['checked' => true]);

    expect($user->milestoneChecks()->pluck('milestone_key')->all())->toBe([$key]);

    $this->actingAs($user)
        ->postJson('/milestones', ['key' => $key, 'checked' => false])
        ->assertOk();

    expect($user->milestoneChecks()->count())->toBe(0);
});

test('checking the same milestone twice does not duplicate it', function () {
    $user = User::factory()->create(['parent_type' => 'new_parent']);
    $key  = Milestones::keysFor('new_parent')[0];

    $this->actingAs($user)->postJson('/milestones', ['key' => $key, 'checked' => true]);
    $this->actingAs($user)->postJson('/milestones', ['key' => $key, 'checked' => true]);

    expect($user->milestoneChecks()->count())->toBe(1);
});

test('unknown milestone keys are rejected', function () {
    $user = User::factory()->create(['parent_type' => 'new_parent']);

    $this->actingAs($user)
        ->postJson('/milestones', ['key' => 'made-up-key', 'checked' => true])
        ->assertStatus(422);
});

test('expecting parents see the pregnancy checklist, not baby milestones', function () {
    $user = User::factory()->create([
        'parent_type' => 'expecting',
        'child_date'  => now()->addWeeks(12)->toDateString(),
    ]);

    $this->actingAs($user)->get('/dashboard')
        ->assertOk()
        ->assertSee('Week 28 of 40')
        ->assertSee('Pack hospital bag')
        ->assertDontSee('Rolls over');
});

test('other parents see baby milestones with their saved checks', function () {
    $user = User::factory()->create(['parent_type' => 'new_parent']);
    $key  = Milestones::keysFor('new_parent')[0];
    $user->milestoneChecks()->create(['milestone_key' => $key]);

    $this->actingAs($user)->get('/dashboard')
        ->assertOk()
        ->assertSee('Rolls over')
        ->assertSee('data-key="' . $key . '" checked', false);
});
