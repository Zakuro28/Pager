@extends('layouts.auth-card')

@section('title', 'Forgot password')

@section('form')
    <a class="back" href="{{ route('login') }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Back to log in
    </a>

    <div class="form-head">
        <h1>Reset your password</h1>
        <p>Enter the email you signed up with and we'll send you a link to choose a new password.</p>
    </div>

    @if (session('status'))
        <div class="status" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="field">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autofocus autocomplete="email" placeholder="you@example.com">
        </div>

        <button class="btn-submit" type="submit">Send reset link</button>
    </form>
@endsection
