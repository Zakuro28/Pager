@extends('layouts.auth-card')

@section('title', 'Choose a new password')

@section('form')
    <div class="form-head">
        <h1>Choose a new password</h1>
        <p>Use at least 8 characters. You'll use it to log in from now on.</p>
    </div>

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}"
                required autocomplete="email">
        </div>

        <div class="field">
            <label for="password">New password</label>
            <div class="pw-wrap">
                <input id="password" type="password" name="password" required autofocus
                    autocomplete="new-password" minlength="8" placeholder="At least 8 characters">
                <button type="button" class="pw-toggle" data-target="password" aria-label="Show password">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <div class="field">
            <label for="password_confirmation">Confirm new password</label>
            <div class="pw-wrap">
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" minlength="8" placeholder="Repeat your password">
                <button type="button" class="pw-toggle" data-target="password_confirmation" aria-label="Show password">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <button class="btn-submit" type="submit">Save new password</button>
    </form>
@endsection
