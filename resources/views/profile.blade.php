<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Profile — PAGER</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @include('partials.tokens')
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; }
        body {
            font-family: "Inter", system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }

        .topnav { background: rgba(255,255,255,0.92); border-bottom: 1px solid var(--border); }
        .nav-inner { max-width: 720px; margin: 0 auto; padding: 0 1.25rem; height: 58px; display: flex; align-items: center; justify-content: space-between; }
        .nav-brand { display: flex; align-items: center; gap: 0.5rem; font-weight: 800; font-size: 0.95rem; letter-spacing: -0.02em; }
        .nav-brand img { height: 28px; width: auto; }
        .back { display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.85rem; color: var(--sub); transition: color 0.15s; }
        .back:hover { color: var(--ink); }

        .page { max-width: 720px; margin: 0 auto; padding: 2rem 1.25rem 4rem; }
        .page h1 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 0.25rem; }
        .page-sub { font-size: 0.9rem; color: var(--sub); margin-bottom: 1.75rem; }

        .card { background: var(--white); border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem; margin-bottom: 1.25rem; }
        .card h2 { font-size: 1rem; font-weight: 700; margin-bottom: 0.25rem; }
        .card-sub { font-size: 0.825rem; color: var(--sub); margin-bottom: 1rem; }

        .toast { display: flex; align-items: center; gap: 0.5rem; background: var(--ok-bg); border: 1px solid var(--ok-bdr); color: var(--ok); border-radius: 8px; padding: 0.7rem 1rem; font-size: 0.875rem; font-weight: 500; margin-bottom: 1.25rem; }
        .errors { background: var(--danger-bg); border: 1px solid var(--danger-bdr); color: var(--danger); border-radius: 8px; padding: 0.75rem 1rem; font-size: 0.875rem; margin-bottom: 1rem; }
        .errors ul { padding-left: 1.1rem; }

        .field { margin-bottom: 1rem; }
        .field label, .field-label { display: block; font-size: 0.8125rem; font-weight: 600; margin-bottom: 0.35rem; }
        .field input[type="text"], .field input[type="date"], .field input[type="password"] {
            width: 100%; max-width: 360px; padding: 0.625rem 0.875rem;
            border: 1px solid var(--border); border-radius: 7px;
            font-family: inherit; font-size: 0.9rem; color: var(--ink); background: var(--white);
            outline: none; transition: border-color 0.15s, box-shadow 0.15s;
        }
        .field input:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1); }
        .field-hint { font-size: 0.775rem; color: var(--sub); margin-top: 0.3rem; }
        .static-value { font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; }
        .pill { font-size: 0.7rem; font-weight: 700; border-radius: 999px; padding: 0.15rem 0.55rem; }
        .pill-ok { background: var(--ok-bg); color: var(--ok); }
        .pill-warn { background: var(--amber-bg); color: var(--amber); }

        /* Same selectable cards as the register page */
        .type-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; max-width: 480px; }
        .type-opt input { position: absolute; opacity: 0; pointer-events: none; }
        .type-card { display: block; padding: 0.75rem; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; background: var(--white); transition: border-color 0.15s, background 0.15s; }
        .type-card:hover { border-color: #d8b4fe; background: var(--purple-bg); }
        .type-opt input:checked + .type-card { border-color: var(--purple); background: var(--purple-bg); }
        .type-opt input:focus-visible + .type-card { box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.25); }
        .t-icon { color: var(--purple); margin-bottom: 0.2rem; display: block; }
        .t-name { font-size: 0.8125rem; font-weight: 600; display: block; }
        .t-desc { font-size: 0.75rem; color: var(--sub); margin-top: 0.1rem; display: block; }

        .actions { display: flex; justify-content: flex-end; margin-top: 1.25rem; }
        .btn-primary { font-family: inherit; font-size: 0.9rem; font-weight: 600; color: var(--white); background: var(--purple); border: none; border-radius: 7px; padding: 0.65rem 1.25rem; cursor: pointer; transition: background 0.15s; }
        .btn-primary:hover { background: var(--purple-dim); }

        .danger { border-color: var(--danger-bdr); }
        .danger h2 { color: var(--danger); }
        .btn-danger { font-family: inherit; font-size: 0.85rem; font-weight: 600; color: var(--danger); background: none; border: 1px solid var(--danger-bdr); border-radius: 7px; padding: 0.55rem 1rem; cursor: pointer; transition: background 0.15s; }
        .btn-danger:hover { background: var(--danger-bg); }
        .danger-row { display: flex; align-items: flex-end; gap: 0.75rem; flex-wrap: wrap; }
        .danger-row .field { margin-bottom: 0; }

        :focus-visible { outline: 2px solid var(--purple); outline-offset: 2px; }
        @media (max-width: 480px) { .type-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<nav class="topnav">
    <div class="nav-inner">
        <a class="nav-brand" href="/"><img src="{{ asset('logo.png') }}" alt="Pager"> PAGER</a>
        <a class="back" href="{{ route('dashboard') }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to dashboard
        </a>
    </div>
</nav>

<main class="page">
    <h1>Your profile</h1>
    <p class="page-sub">Keep your details up to date so PAGER stays relevant to you.</p>

    @if (session('profile_saved'))
        <div class="toast" role="status">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            Profile saved. Your tips and milestones are updated.
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        @if ($errors->hasAny(['name', 'parent_type', 'child_date']))
            <div class="errors">
                <ul>
                    @foreach ($errors->only(['name', 'parent_type', 'child_date']) as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card">
            <h2>Details</h2>
            <p class="card-sub">How we greet you and how we contact you.</p>

            <div class="field">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="255">
            </div>

            <div class="field">
                <span class="field-label">Email</span>
                <span class="static-value">
                    {{ $user->email }}
                    @if ($user->email_verified_at)
                        <span class="pill pill-ok">Verified</span>
                    @else
                        <span class="pill pill-warn">Not verified</span>
                    @endif
                </span>
            </div>
        </section>

        <section class="card">
            <h2>Your stage</h2>
            <p class="card-sub">This changes your tips, milestones and resources.</p>

            @php
                $types = [
                    'expecting'      => ['heart', 'Expecting', 'Currently pregnant'],
                    'new_parent'     => ['baby', 'New Parent', 'Baby 0–12 months'],
                    'working_parent' => ['briefcase', 'Working Parent', 'Balancing work & family'],
                    'solo_parent'    => ['sparkles', 'Solo Parent', 'Doing it on your own'],
                ];
                $current = old('parent_type', $user->parent_type);
            @endphp

            <div class="type-grid" role="radiogroup" aria-label="Your stage">
                @foreach ($types as $value => [$icon, $name, $desc])
                    <label class="type-opt">
                        <input type="radio" name="parent_type" value="{{ $value }}" {{ $current === $value ? 'checked' : '' }} required>
                        <span class="type-card">
                            <span class="t-icon"><x-icon :name="$icon" :size="20" /></span>
                            <span class="t-name">{{ $name }}</span>
                            <span class="t-desc">{{ $desc }}</span>
                        </span>
                    </label>
                @endforeach
            </div>

            <div class="field" style="margin-top:1.25rem;">
                <label for="child_date" id="childDateLabel">
                    {{ $current === 'expecting' ? 'Due date' : "Baby's date of birth" }}
                </label>
                <input type="date" id="child_date" name="child_date" value="{{ old('child_date', $user->child_date?->toDateString()) }}">
                <p class="field-hint" id="childDateHint">
                    {{ $current === 'expecting' ? 'Used to show your pregnancy week and ask when your baby arrives.' : 'Optional. Helps us show the right milestones.' }}
                </p>
            </div>
        </section>

        <div class="actions">
            <button type="submit" class="btn-primary">Save changes</button>
        </div>
    </form>

    <section class="card danger" style="margin-top:2rem;">
        <h2>Delete account</h2>
        <p class="card-sub">This permanently deletes your account, journal entries and milestones. It can't be undone.</p>

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Delete your account and all your journal entries? This cannot be undone.');">
            @csrf
            @method('DELETE')

            @error('password')
                <div class="errors">{{ $message }}</div>
            @enderror

            <div class="danger-row">
                <div class="field">
                    <label for="delete_password">Confirm with your password</label>
                    <input type="password" id="delete_password" name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn-danger">Delete my account</button>
            </div>
        </form>
    </section>
</main>

<script>
    // Relabel the date field when the stage changes.
    document.querySelectorAll('input[name="parent_type"]').forEach(radio => {
        radio.addEventListener('change', () => {
            const expecting = radio.value === 'expecting';
            document.getElementById('childDateLabel').textContent = expecting ? 'Due date' : "Baby's date of birth";
            document.getElementById('childDateHint').textContent = expecting
                ? 'Used to show your pregnancy week and ask when your baby arrives.'
                : 'Optional. Helps us show the right milestones.';
        });
    });
</script>
</body>
</html>
