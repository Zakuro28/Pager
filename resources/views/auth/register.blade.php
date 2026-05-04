<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account — PAGER</title>
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
            --purple-mid: #ede9fe;
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

        .logo-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--purple); }

        .left-steps { max-width: 360px; }

        .left-steps h2 {
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }

        .left-steps h2 span { color: var(--purple); }

        .step {
            display: flex;
            gap: 0.875rem;
            padding: 0.875rem 0;
            border-bottom: 1px solid var(--border);
        }

        .step:last-child { border-bottom: none; }

        .step-num {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--purple);
            min-width: 1.4rem;
            padding-top: 1px;
        }

        .step-body strong {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 0.15rem;
        }

        .step-body span { font-size: 0.8rem; color: var(--sub); }

        .left-bottom { font-size: 0.8rem; color: var(--sub); }

        /* ── Right panel ── */
        .right {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 2.5rem 3rem;
            overflow-y: auto;
            opacity: 0;
        }

        .form-wrap { width: 100%; max-width: 400px; padding: 0.5rem 0; }

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

        .form-head { margin-bottom: 1.75rem; }

        .form-head h1 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 0.375rem;
        }

        .form-head p { font-size: 0.875rem; color: var(--sub); }
        .form-head p a { color: var(--purple); font-weight: 500; text-decoration: none; }
        .form-head p a:hover { text-decoration: underline; }

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

        .field { margin-bottom: 0.875rem; }

        .field label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 0.35rem;
        }

        .field input[type="text"],
        .field input[type="email"],
        .field input[type="password"] {
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

        /* ── Parent type grid ── */
        .type-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 0.6rem;
            margin-top: 0.25rem;
            display: block;
        }

        .type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .type-opt input { display: none; }

        .type-card {
            display: block;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            background: var(--white);
            transition: border-color 0.15s, background 0.15s;
        }

        .type-card:hover { border-color: #d8b4fe; background: var(--purple-bg); }

        .type-opt input:checked + .type-card {
            border-color: var(--purple);
            background: var(--purple-bg);
        }

        .type-card .t-icon { font-size: 1.1rem; margin-bottom: 0.2rem; display: block; }
        .type-card .t-name { font-size: 0.8125rem; font-weight: 600; color: var(--ink); display: block; }
        .type-card .t-desc { font-size: 0.75rem; color: var(--sub); margin-top: 0.1rem; display: block; }

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

        @media (max-width: 680px) {
            body { grid-template-columns: 1fr; }
            .left { display: none; }
            .right { padding: 2rem 1.5rem; align-items: flex-start; }
        }
    </style>
</head>
<body>

<div class="left">
    <a class="left-brand" href="/"><span class="logo-dot"></span> PAGER</a>

    <div class="left-steps">
        <h2>Start your parenting journey with <span>confidence.</span></h2>
        <div class="step">
            <span class="step-num">01</span>
            <div class="step-body">
                <strong>Create your profile</strong>
                <span>Tell us about your caregiving stage so we can personalize your experience.</span>
            </div>
        </div>
        <div class="step">
            <span class="step-num">02</span>
            <div class="step-body">
                <strong>Start your journal</strong>
                <span>Document milestones, memories, and moments as they happen.</span>
            </div>
        </div>
        <div class="step">
            <span class="step-num">03</span>
            <div class="step-body">
                <strong>Access expert resources</strong>
                <span>Get curated guidance from child development professionals.</span>
            </div>
        </div>
    </div>

    <p class="left-bottom">© {{ date('Y') }} PAGER. All rights reserved.</p>
</div>

<div class="right" id="formPanel">
    <div class="form-wrap">
        <a class="back" href="/">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to home
        </a>

        <div class="form-head">
            <h1>Create your account</h1>
            <p>Already have one? <a href="{{ route('login') }}">Log in</a></p>
        </div>

        @if ($errors->any())
            <div class="errors">
                <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="field">
                <label for="name">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                    required autofocus autocomplete="name" placeholder="Maria Santos">
            </div>

            <div class="field">
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    required autocomplete="email" placeholder="you@example.com">
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password"
                    required autocomplete="new-password" placeholder="At least 8 characters">
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    required autocomplete="new-password" placeholder="Repeat your password">
            </div>

            <span class="type-label">I am a…</span>
            <div class="type-grid">
                <label class="type-opt">
                    <input type="radio" name="parent_type" value="expecting" {{ old('parent_type') === 'expecting' ? 'checked' : '' }} required>
                    <span class="type-card">
                        <span class="t-icon">🤰</span>
                        <span class="t-name">Expecting</span>
                        <span class="t-desc">Currently pregnant</span>
                    </span>
                </label>
                <label class="type-opt">
                    <input type="radio" name="parent_type" value="new_parent" {{ old('parent_type') === 'new_parent' ? 'checked' : '' }}>
                    <span class="type-card">
                        <span class="t-icon">👶</span>
                        <span class="t-name">New Parent</span>
                        <span class="t-desc">Baby 0–12 months</span>
                    </span>
                </label>
                <label class="type-opt">
                    <input type="radio" name="parent_type" value="working_parent" {{ old('parent_type') === 'working_parent' ? 'checked' : '' }}>
                    <span class="type-card">
                        <span class="t-icon">💼</span>
                        <span class="t-name">Working Parent</span>
                        <span class="t-desc">Balancing work &amp; family</span>
                    </span>
                </label>
                <label class="type-opt">
                    <input type="radio" name="parent_type" value="solo_parent" {{ old('parent_type') === 'solo_parent' ? 'checked' : '' }}>
                    <span class="type-card">
                        <span class="t-icon">🌟</span>
                        <span class="t-name">Solo Parent</span>
                        <span class="t-desc">Doing it on your own</span>
                    </span>
                </label>
            </div>

            <button class="btn-submit" type="submit">
                Create my account
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
</script>
</body>
</html>
