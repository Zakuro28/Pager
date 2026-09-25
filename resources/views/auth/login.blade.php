@extends('layouts.auth-card')

@section('title', 'Log in')

@section('form')
    <a class="back" href="/">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Back to home
    </a>

    <div class="form-head">
        <h1>Welcome back</h1>
        <p>Don't have an account? <a href="{{ route('register') }}">Create one free</a></p>
    </div>

    @if (session('status'))
        <div class="status" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="field">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autofocus autocomplete="email" placeholder="you@example.com">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <div class="pw-wrap">
                <input id="password" type="password" name="password"
                    required autocomplete="current-password" placeholder="••••••••">
                <button type="button" class="pw-toggle" data-target="password" aria-label="Show password">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <div class="row-between">
            <label class="check-label">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <a class="text-link" href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button class="btn-submit" type="submit">
            Log in
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
    </form>
@endsection
