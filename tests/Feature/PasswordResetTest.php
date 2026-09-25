<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses(RefreshDatabase::class);

test('the login page links to forgot password', function () {
    $this->get('/login')->assertOk()->assertSee('Forgot password?');
});

test('the forgot password page renders', function () {
    $this->get('/forgot-password')->assertOk()->assertSee('Reset your password');
});

test('requesting a reset emails a link to an existing user', function () {
    Notification::fake();
    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email])
        ->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPassword::class);
});

test('unknown emails get the same message, so accounts cannot be discovered', function () {
    Notification::fake();

    $this->post('/forgot-password', ['email' => 'nobody@pager.test'])
        ->assertSessionHas('status')
        ->assertSessionHasNoErrors();

    Notification::assertNothingSent();
});

test('the reset page renders with a token', function () {
    $this->get('/reset-password/some-token?email=a@b.com')
        ->assertOk()
        ->assertSee('Choose a new password');
});

test('a valid token lets the user set a new password', function () {
    $user  = User::factory()->create();
    $token = Password::createToken($user);

    $this->post('/reset-password', [
        'token'                 => $token,
        'email'                 => $user->email,
        'password'              => 'brand-new-pass',
        'password_confirmation' => 'brand-new-pass',
    ])->assertRedirect('/login')->assertSessionHas('status');

    expect(Hash::check('brand-new-pass', $user->refresh()->password))->toBeTrue();
});

test('an invalid token does not change the password', function () {
    $user = User::factory()->create(['password' => Hash::make('original-pass')]);

    $this->post('/reset-password', [
        'token'                 => 'not-a-real-token',
        'email'                 => $user->email,
        'password'              => 'brand-new-pass',
        'password_confirmation' => 'brand-new-pass',
    ])->assertSessionHasErrors('email');

    expect(Hash::check('original-pass', $user->refresh()->password))->toBeTrue();
});
