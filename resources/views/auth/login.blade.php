<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in — PAGER</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.2/lib/anime.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; }

        :root {
            --white:      #ffffff;
            --ink:        #111827;
            --sub:        #6b7280;
            --border:     #e5e7eb;
            --purple:     #7c3aed;
            --purple-dim: #6d28d9;
            --purple-bg:  #f5f3ff;
            --error-bg:   #fef2f2;
            --error:      #dc2626;
            --error-bdr:  #fecaca;
        }

        body {
            font-family: "Inter", system-ui, sans-serif;
            background: var(--white);
            color: var(--ink);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Left panel ── */
        .left {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem 3rem;
            border-right: 1px solid var(--border);
            background: var(--purple-bg);
        }

        .left-brand {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }

        .logo-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--purple);
        }

        .left-quote {
            max-width: 380px;
        }

        .left-quote blockquote {
            font-size: 1.4rem;
            font-weight: 600;
            line-height: 1.4;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin-bottom: 1.25rem;
        }

        .left-quote blockquote span { color: var(--purple); }

        .left-quote p {
            font-size: 0.875rem;
            color: var(--sub);
            line-height: 1.6;
        }

        .left-bottom {
            font-size: 0.8rem;
            color: var(--sub);
        }

        /* ── Right panel ── */
        .right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 3rem;
            opacity: 0;
        }

        .form-wrap {
            width: 100%;
            max-width: 380px;
        }

        .form-head {
            margin-bottom: 2rem;
        }

        .form-head h1 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: var(--ink);
            margin-bottom: 0.375rem;
        }

        .form-head p {
            font-size: 0.875rem;
            color: var(--sub);
        }

        .form-head p a {
            color: var(--purple);
            font-weight: 500;
            text-decoration: none;
        }

        .form-head p a:hover { text-decoration: underline; }

        /* ── Error ── */
        .errors {
            background: var(--error-bg);
            border: 1px solid var(--error-bdr);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            color: var(--error);
        }

        .errors ul { padding-left: 1.1rem; }

        /* ── Fields ── */
        .field { margin-bottom: 1rem; }

        .field label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 0.375rem;
        }

        .field input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--border);
            border-radius: 7px;
            font-family: "Inter", sans-serif;
            font-size: 0.9rem;
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .field input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .field input::placeholder { color: #9ca3af; }

        /* ── Password toggle ── */
        .pw-wrap { position: relative; }

        .pw-wrap input { padding-right: 2.5rem; }

        .pw-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 0;
            line-height: 1;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }

        .pw-toggle:hover { color: var(--purple); }

        /* ── Remember row ── */
        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: var(--sub);
            cursor: pointer;
        }

        .check-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--purple);
        }

        /* ── Submit ── */
        .btn-submit {
            width: 100%;
            padding: 0.7rem 1rem;
            background: var(--purple);
            color: var(--white);
            border: none;
            border-radius: 7px;
            font-family: "Inter", sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s, transform 0.12s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-submit:hover { background: var(--purple-dim); transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }

        /* ── Back link ── */
        .back {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.8rem;
            color: var(--sub);
            text-decoration: none;
            margin-bottom: 2rem;
            transition: color 0.15s;
        }

        .back:hover { color: var(--ink); }

        /* ── Mobile ── */
        @media (max-width: 680px) {
            body { grid-template-columns: 1fr; }
            .left { display: none; }
            .right { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

<!-- Left decorative panel -->
<div class="left">
    <a class="left-brand" href="/"><span class="logo-dot"></span> PAGER</a>

    <div class="left-quote">
        <blockquote>"Parenting is the greatest work you'll ever do. You deserve <span>the right support.</span>"</blockquote>
        <p>PAGER gives caregivers a personalized journal, milestone tracker, and expert resource library — all in one place.</p>
    </div>

    <p class="left-bottom">© {{ date('Y') }} PAGER. All rights reserved.</p>
</div>

<!-- Right form panel -->
<div class="right" id="formPanel">
    <div class="form-wrap">
        <a class="back" href="/">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to home
        </a>

        <div class="form-head">
            <h1>Welcome back</h1>
            <p>Don't have an account? <a href="{{ route('register') }}">Create one free</a></p>
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
            </div>

            <button class="btn-submit" type="submit">
                Log in
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>
    </div>
</div>

<script>
anime({
    targets: '#formPanel',
    opacity: [0, 1],
    translateX: [24, 0],
    duration: 700,
    easing: 'easeOutExpo'
});

const EYE_OPEN = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
const EYE_SHUT = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';

document.querySelectorAll('.pw-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target);
        const showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        btn.querySelector('svg').innerHTML = showing ? EYE_OPEN : EYE_SHUT;
        btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
        anime({ targets: btn, scale: [0.8, 1], duration: 200, easing: 'easeOutBack' });
    });
});
</script>
</body>
</html>
