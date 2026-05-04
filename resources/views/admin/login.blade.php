<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — PAGER</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
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
            --danger:     #dc2626;
            --danger-bg:  #fef2f2;
            --danger-bdr: #fecaca;
        }

        body {
            font-family: "Inter", system-ui, sans-serif;
            background: #f8f7ff;
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
            padding: 1.5rem;
        }

        /* ── Background orbs ── */
        .bg-orbs { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.1;
        }
        .orb-1 { width: 500px; height: 500px; background: #7c3aed; top: -150px; right: -100px; animation: floatOrb 12s ease-in-out infinite; }
        .orb-2 { width: 350px; height: 350px; background: #a78bfa; bottom: -100px; left: -80px; animation: floatOrb 16s ease-in-out infinite reverse; }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0); }
            50%       { transform: translate(20px, -20px); }
        }

        /* ── Card ── */
        .login-card {
            position: relative;
            z-index: 1;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 40px rgba(0,0,0,0.06);
            opacity: 0;
        }

        /* ── Header ── */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .login-logo img { height: 40px; width: auto; }

        .login-logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--ink);
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--purple);
            background: var(--purple-bg);
            border: 1px solid var(--purple-mid);
            border-radius: 999px;
            padding: 0.25rem 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.875rem;
        }

        .login-header h1 {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.35rem;
        }

        .login-header p {
            font-size: 0.875rem;
            color: var(--sub);
        }

        /* ── Form ── */
        .login-form { display: grid; gap: 1rem; }

        .form-field label {
            display: block;
            font-size: 0.775rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.35rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .form-field input {
            width: 100%;
            padding: 0.6rem 0.875rem 0.6rem 2.375rem;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-family: "Inter", sans-serif;
            font-size: 0.9rem;
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .form-field input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
        }

        .form-field input::placeholder { color: #9ca3af; }

        /* ── Error ── */
        .error-box {
            background: var(--danger-bg);
            border: 1px solid var(--danger-bdr);
            color: var(--danger);
            border-radius: 8px;
            padding: 0.7rem 0.875rem;
            font-size: 0.8125rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ── Submit ── */
        .btn-login {
            width: 100%;
            padding: 0.7rem 1rem;
            background: var(--purple);
            color: var(--white);
            border: none;
            border-radius: 9px;
            font-family: "Inter", sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s, transform 0.12s, box-shadow 0.2s;
            margin-top: 0.25rem;
        }

        .btn-login:hover {
            background: var(--purple-dim);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(124,58,237,0.3);
        }

        .btn-login:active { transform: scale(0.97); }

        /* ── Footer ── */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-footer a {
            font-size: 0.8125rem;
            color: var(--sub);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.15s;
        }

        .login-footer a:hover { color: var(--ink); }

        /* ── Show password toggle ── */
        .toggle-pw {
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
            transition: color 0.15s;
        }

        .toggle-pw:hover { color: var(--sub); }
    </style>
</head>
<body>

<div class="bg-orbs" aria-hidden="true">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
</div>

<div class="login-card" id="loginCard">

    <div class="login-header">
        <div class="login-logo">
            <img src="{{ asset('logo.png') }}" alt="Pager Logo">
            <span class="login-logo-text">PAGER</span>
        </div>
        <div class="login-badge">Admin Panel</div>
        <h1>Welcome back</h1>
        <p>Sign in to access the admin dashboard.</p>
    </div>

    @if ($errors->any())
        <div class="error-box" style="margin-bottom:1rem;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form class="login-form" method="POST" action="{{ route('admin.login.post') }}" id="loginForm">
        @csrf

        <div class="form-field">
            <label for="username">Username</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </span>
                <input type="text" id="username" name="username"
                    placeholder="Enter username"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    required autofocus>
            </div>
        </div>

        <div class="form-field">
            <label for="password">Password</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </span>
                <input type="password" id="password" name="password"
                    placeholder="Enter password"
                    autocomplete="current-password"
                    required>
                <button type="button" class="toggle-pw" id="togglePw" aria-label="Show password">
                    <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <button class="btn-login" type="submit" id="loginBtn">Sign in</button>
    </form>

    <div class="login-footer">
        <a href="{{ url('/') }}">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to website
        </a>
    </div>

</div>

<script>
    /* ── Card entrance ── */
    anime({
        targets: '#loginCard',
        opacity: [0, 1],
        translateY: [24, 0],
        duration: 700,
        easing: 'easeOutExpo'
    });

    /* ── Error shake ── */
    @if ($errors->any())
    anime({
        targets: '#loginCard',
        translateX: [-8, 8, -6, 6, -4, 4, 0],
        duration: 500,
        easing: 'easeInOutQuad',
        delay: 200
    });
    @endif

    /* ── Submit button animation ── */
    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('loginBtn');
        btn.textContent = 'Signing in…';
        btn.disabled = true;
        anime({ targets: btn, opacity: [1, 0.7], duration: 200 });
    });

    /* ── Show/hide password ── */
    document.getElementById('togglePw').addEventListener('click', function () {
        const pw = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            pw.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    });
</script>
</body>
</html>
