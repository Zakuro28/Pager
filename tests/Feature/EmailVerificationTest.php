<?php

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

test('registering sends a verification email', function () {
    Notification::fake();

    $this->post('/register', [
        'name'                  => 'Maria',
        'email'                 => 'maria@pager.test',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
        'parent_type'           => 'new_parent',
    ])->assertRedirect('/dashboard');

    Notification::assertSentTo(User::where('email', 'maria@pager.test')->first(), VerifyEmail::class);
});

test('unverified users can still use the dashboard but see a reminder', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->get('/dashboard')
        ->assertOk()
        ->assertSee('Please verify your email');
});

test('verified users do not see the reminder', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/dashboard')->assertDontSee('Please verify your email');
});

test('the verification link marks the email as verified', function () {
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute('verification.verify', now()->addHour(), [
        'id'   => $user->id,
        'hash' => sha1($user->getEmailForVerification()),
    ]);

    $this->actingAs($user)->get($url)->assertRedirect(route('dashboard') . '?verified=1');

    expect($user->refresh()->hasVerifiedEmail())->toBeTrue();
});

test('a tampered verification link is rejected', function () {
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute('verification.verify', now()->addHour(), [
        'id'   => $user->id,
        'hash' => sha1('someone-else@example.com'),
    ]);

    $this->actingAs($user)->get($url)->assertForbidden();
    expect($user->refresh()->hasVerifiedEmail())->toBeFalse();
});

test('users can ask for the verification email again', function () {
    Notification::fake();
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->post('/email/verification-notification')
        ->assertSessionHas('verification_sent');

    Notification::assertSentTo($user, VerifyEmail::class);
});
