<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('it creates a verified participant account for a usability session', function () {
    $this->artisan('pager:participant', ['code' => 'P1', '--type' => 'new_parent'])
        ->expectsOutputToContain('p1@test.pager')
        ->assertSuccessful();

    $user = User::where('email', 'p1@test.pager')->first();
    expect($user->parent_type)->toBe('new_parent')
        ->and($user->hasVerifiedEmail())->toBeTrue()
        ->and(Hash::check('pager-p1', $user->password))->toBeTrue()
        ->and($user->is_admin)->toBeFalse();
});

test('expecting participants get a due date so the pregnancy view works', function () {
    $this->artisan('pager:participant', ['code' => 'P3', '--type' => 'expecting'])->assertSuccessful();

    expect(User::where('email', 'p3@test.pager')->first()->pregnancyWeek())->toBe(28);
});

test('running it again resets the account to a clean state', function () {
    $this->artisan('pager:participant', ['code' => 'P2', '--type' => 'new_parent']);
    $user = User::where('email', 'p2@test.pager')->first();
    $user->journalEntries()->create(['content' => 'left over from last session']);

    $this->artisan('pager:participant', ['code' => 'P2', '--type' => 'solo_parent'])->assertSuccessful();

    $fresh = User::where('email', 'p2@test.pager')->first();
    expect($fresh->parent_type)->toBe('solo_parent')
        ->and($fresh->journalEntries()->count())->toBe(0);
});

test('it rejects an unknown parent type', function () {
    $this->artisan('pager:participant', ['code' => 'P9', '--type' => 'astronaut'])->assertFailed();
});
