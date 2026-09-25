<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function adminUser(): User
{
    $admin = User::factory()->create();
    $admin->forceFill(['is_admin' => true])->save();

    return $admin;
}

test('the admin panel shows who joined the expert waitlist and their topics', function () {
    $maria = User::factory()->create(['name' => 'Maria Santos', 'email' => 'maria@pager.test']);
    $joy   = User::factory()->create(['name' => 'Joy Cruz']);
    $maria->waitlistSignup()->create(['topics' => ['sleep', 'feeding']]);
    $joy->waitlistSignup()->create(['topics' => ['sleep']]);

    $this->actingAs(adminUser())->get('/admin')
        ->assertOk()
        ->assertSee('Expert waitlist')
        ->assertSee('2 parents waiting')
        ->assertSee('data-topic="sleep" data-count="2"', false)
        ->assertSee('data-topic="feeding" data-count="1"', false)
        ->assertSee('data-topic="behaviour" data-count="0"', false)
        ->assertSee('maria@pager.test');
});

test('the waitlist section has an empty state', function () {
    $this->actingAs(adminUser())->get('/admin')
        ->assertOk()
        ->assertSee('No one has joined the waitlist yet');
});
