<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAGER UI Kit</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @include('partials.favicon')
    @include('partials.tokens')
    {{-- Living style guide: every sample below uses the same tokens and patterns as the real pages. See docs/ux/02-design-system.md --}}
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Inter", system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .wrap { width: min(1100px, calc(100% - 2rem)); margin-inline: auto; }

        /* ── Header with the Orchid Bloom aura ── */
        .kit-hero { position: relative; overflow: hidden; padding: 3.5rem 0 3rem; border-bottom: 1px solid var(--border); }
        .kit-hero .wrap { position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: flex-end; gap: 1.5rem; flex-wrap: wrap; }
        .kit-hero h1 { font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 800; letter-spacing: -0.04em; line-height: 1.1; }
        .kit-hero p { color: var(--sub); max-width: 52ch; margin-top: 0.5rem; }

        .aura { position: absolute; inset: 0; background: #faf8f2; isolation: isolate; pointer-events: none; }
        .aura span { position: absolute; inset: -15% -10%; filter: blur(36px); }
        .aura .aura-1 { background: linear-gradient(110deg, rgba(0,0,0,0) 0%, rgba(242,61,224,0.12) 28%, rgb(255,255,255) 18%, rgb(139,92,246) 68%, rgb(61,139,255) 100%); mix-blend-mode: hard-light; }
        .aura .aura-2 { background: linear-gradient(130deg, rgba(0,0,0,0) 0%, rgba(242,61,224,0.22) 34%, rgb(255,255,255) 66%, rgb(139,92,246) 82%, rgb(61,139,255) 100%); mix-blend-mode: soft-light; }

        /* ── Layout ── */
        main { padding: 2rem 0 4rem; display: grid; gap: 1.125rem; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.125rem; }
        @media (max-width: 800px) { .grid-2 { grid-template-columns: 1fr; } }

        .block { background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 1.5rem; }
        .block h2 { font-size: 0.875rem; font-weight: 800; letter-spacing: -0.01em; margin-bottom: 0.25rem; }
        .block .note { font-size: 0.8rem; color: var(--sub); margin-bottom: 1.125rem; }
        .row { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
        code { font-size: 0.72rem; background: var(--purple-bg); color: var(--purple); border-radius: 4px; padding: 0.05rem 0.35rem; }

        /* ── Colors ── */
        .swatches { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 0.625rem; }
        .swatch { border: 1px solid var(--border); border-radius: 10px; overflow: hidden; font-size: 0.72rem; }
        .swatch-color { height: 56px; }
        .swatch-meta { padding: 0.45rem 0.6rem; }
        .swatch-meta strong { display: block; font-size: 0.75rem; }
        .swatch-meta span { color: var(--sub); font-family: ui-monospace, monospace; }

        /* ── Type ── */
        .type-row { display: flex; align-items: baseline; gap: 1rem; padding: 0.5rem 0; border-bottom: 1px solid var(--border); }
        .type-row:last-child { border-bottom: none; }
        .type-row small { width: 90px; flex-shrink: 0; font-size: 0.7rem; color: var(--sub); }

        /* ── Buttons (same as welcome/dashboard) ── */
        .btn-solid { display: inline-flex; align-items: center; gap: 0.45rem; font: inherit; font-size: 0.9375rem; font-weight: 700; color: var(--white); background: var(--purple); padding: 0.75rem 1.625rem; border: none; border-radius: 8px; cursor: pointer; transition: background 0.15s, transform 0.15s, box-shadow 0.25s; }
        .btn-solid:hover { background: var(--purple-dim); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(106,79,179,0.35); }
        .btn-save { font: inherit; font-size: 0.8125rem; font-weight: 700; color: var(--white); background: var(--purple); padding: 0.575rem 1.25rem; border: none; border-radius: 8px; cursor: pointer; transition: background 0.15s, transform 0.12s, box-shadow 0.2s; }
        .btn-save:hover { background: var(--purple-dim); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(106,79,179,0.3); }
        .btn-save:active, .btn-solid:active { transform: scale(0.96); }
        .btn-ghost { font: inherit; font-size: 0.875rem; font-weight: 500; color: var(--sub); background: var(--white); padding: 0.4rem 0.875rem; border: 1px solid var(--border); border-radius: 6px; cursor: pointer; transition: all 0.15s; }
        .btn-ghost:hover { color: var(--ink); border-color: #d1d5db; background: #f9fafb; }
        .btn-danger { font: inherit; font-size: 0.8125rem; font-weight: 700; color: var(--danger); background: var(--danger-bg); border: 1px solid var(--danger-bdr); padding: 0.55rem 1.1rem; border-radius: 8px; cursor: pointer; }
        .btn-del { display: inline-flex; align-items: center; background: none; border: none; color: #d1d5db; padding: 0.35rem 0.45rem; border-radius: 6px; cursor: pointer; font: inherit; transition: color 0.15s, background 0.15s; }
        .btn-del:hover, .btn-del.is-confirming { color: var(--danger); background: var(--danger-bg); }
        .btn-del span { display: none; margin-left: 0.3rem; font-size: 0.72rem; font-weight: 700; }
        .btn-del.is-confirming span { display: inline; }

        /* ── Pills & badges ── */
        .pill { padding: 0.3rem 0.75rem; border: 1.5px solid var(--border); border-radius: 999px; font: inherit; font-size: 0.8rem; font-weight: 600; color: var(--sub); background: var(--white); cursor: pointer; transition: border-color 0.15s, background 0.15s, color 0.15s, transform 0.15s; }
        .pill:hover { border-color: #c3b6e6; color: var(--ink); transform: translateY(-1px); }
        .pill.active { border-color: var(--purple); background: var(--purple-bg); color: var(--purple); }
        .badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 999px; }
        .badge-ok { background: var(--ok-bg); color: var(--ok); border: 1px solid var(--ok-bdr); }
        .badge-soon { background: var(--yellow-bg); color: var(--yellow-ink); border: 1px solid var(--yellow); }
        .badge-brand { background: var(--purple-bg); color: var(--purple); border: 1px solid var(--purple-mid); }
        .badge-now { background: var(--purple); color: var(--white); font-size: 0.6rem; letter-spacing: 0.06em; text-transform: uppercase; }

        /* ── Inputs ── */
        .field { display: grid; gap: 0.35rem; font-size: 0.8rem; font-weight: 600; }
        .input, .select { width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 0.55rem 0.75rem; font: inherit; font-size: 0.875rem; color: var(--ink); background: var(--white); outline: none; transition: border-color 0.18s, box-shadow 0.18s; }
        .input:focus, .select:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(106,79,179,0.08); }
        .input.is-error { border-color: var(--danger); }
        .error-text { font-size: 0.75rem; font-weight: 500; color: var(--danger); }
        .search { display: flex; align-items: center; gap: 0.45rem; padding: 0 0.75rem; border: 1.5px solid var(--border); border-radius: 8px; background: var(--white); color: #9ca3af; transition: border-color 0.18s, box-shadow 0.18s, color 0.18s; }
        .search:focus-within { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(106,79,179,0.08); color: var(--purple); }
        .search input { flex: 1; min-width: 0; border: none; outline: none; background: transparent; padding: 0.55rem 0; font: inherit; font-size: 0.875rem; color: var(--ink); }
        .inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
        @media (max-width: 560px) { .inputs { grid-template-columns: 1fr; } }

        /* ── Checkbox (milestone tick) ── */
        .ms-item { display: flex; align-items: center; gap: 0.55rem; padding: 0.45rem 0; border-bottom: 1px solid var(--border); font-size: 0.85rem; cursor: pointer; }
        .ms-item:last-child { border-bottom: none; }
        .ms-item input { appearance: none; -webkit-appearance: none; width: 18px; height: 18px; flex-shrink: 0; display: grid; place-items: center; border: 1.5px solid #d1d5db; border-radius: 5px; background: var(--white); cursor: pointer; transition: background 0.15s, border-color 0.15s, transform 0.12s; }
        .ms-item input::after { content: ''; width: 4px; height: 9px; margin-top: -2px; border: solid var(--white); border-width: 0 2px 2px 0; transform: rotate(45deg) scale(0); transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .ms-item input:hover { border-color: var(--purple); }
        .ms-item input:checked { background: var(--purple); border-color: var(--purple); }
        .ms-item input:checked::after { transform: rotate(45deg) scale(1); }
        .ms-item input:active { transform: scale(0.85); }
        .ms-item input:checked + span { text-decoration: line-through; color: var(--sub); }
        .progress { height: 5px; background: var(--border); border-radius: 999px; overflow: hidden; margin: 0.25rem 0 0.75rem; }
        .progress div { height: 100%; width: 40%; background: linear-gradient(90deg, var(--purple), #9d88d6); border-radius: 999px; transition: width 0.6s cubic-bezier(0.16, 1, 0.3, 1); }

        /* ── Reminder card ── */
        .reminder { border: 1px solid var(--purple-mid); background: linear-gradient(135deg, var(--purple-bg), var(--white)); border-radius: 10px; padding: 0.85rem; }
        .reminder-hd { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.65rem; }
        .reminder-hd strong { display: block; font-size: 0.8125rem; }
        .reminder-hd div span { font-size: 0.72rem; color: var(--sub); }
        .reminder-icon { width: 28px; height: 28px; border-radius: 8px; display: grid; place-items: center; background: var(--purple); color: var(--white); flex-shrink: 0; }
        .reminder-list { list-style: none; display: grid; gap: 0.3rem; }
        .reminder-list li { display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; padding: 0.35rem 0.35rem 0.35rem 0.65rem; background: var(--white); border: 1px solid var(--border); border-radius: 8px; font-size: 0.78rem; }
        .reminder-list li.is-overdue span { color: var(--amber); display: inline-flex; align-items: center; gap: 0.35rem; }
        .reminder-done { width: 28px; height: 28px; display: grid; place-items: center; border: 1.5px solid var(--border); border-radius: 7px; background: var(--white); color: var(--sub); cursor: pointer; }
        .reminder-done:hover { border-color: var(--purple); color: var(--purple); background: var(--purple-bg); }

        /* ── Timeline entry ── */
        .tl-items { margin-left: 0.3rem; padding-left: 1.25rem; border-left: 2px solid var(--purple-mid); }
        .entry { position: relative; padding: 0.6rem 0; }
        .tl-dot { position: absolute; left: calc(-1.25rem - 6px); top: 0.85rem; width: 10px; height: 10px; border-radius: 50%; border: 2px solid var(--green); background: var(--green-bg); }
        .entry-meta { display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: var(--sub); gap: 0.5rem; }
        .entry-text { font-size: 0.875rem; margin: 0.3rem 0; }
        .entry-text mark { background: var(--yellow-bg); box-shadow: inset 0 -2px 0 var(--yellow); color: inherit; border-radius: 3px; padding: 0 1px; }
        .entry-tag { font-size: 0.65rem; font-weight: 700; color: var(--sub); background: #f3f4f6; border-radius: 999px; padding: 0.1rem 0.45rem; }

        /* ── Toast ── */
        .toast { display: inline-flex; align-items: center; gap: 0.55rem; background: var(--ink); color: var(--white); border-radius: 10px; padding: 0.7rem 1rem; font-size: 0.8125rem; font-weight: 600; box-shadow: 0 12px 32px rgba(17,24,39,0.2); }
        .toast svg { color: #6ee7b7; }
        .toast.is-error svg { color: #fca5a5; }
        .toast-stack { position: fixed; right: 1.25rem; bottom: 1.25rem; display: grid; gap: 0.5rem; justify-items: end; z-index: 50; }
        .toast-stack .toast { animation: toastIn 0.45s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes toastIn { from { opacity: 0; transform: translateY(16px) scale(0.96); } }

        /* ── Icons ── */
        .icons { display: grid; grid-template-columns: repeat(auto-fill, minmax(92px, 1fr)); gap: 0.5rem; }
        .icon-cell { display: grid; justify-items: center; gap: 0.35rem; padding: 0.75rem 0.25rem; border: 1px solid var(--border); border-radius: 10px; font-size: 0.65rem; color: var(--sub); transition: border-color 0.15s, color 0.15s, background 0.15s; }
        .icon-cell svg { color: var(--ink); }
        .icon-cell:hover { border-color: var(--purple-mid); background: var(--purple-bg); }
        .icon-cell:hover svg { color: var(--purple); }

        /* ── Motion ── */
        .motion-list { list-style: none; display: grid; gap: 0.5rem; font-size: 0.85rem; }
        .motion-list li { display: flex; gap: 0.75rem; }
        .motion-list strong { width: 120px; flex-shrink: 0; font-size: 0.8rem; }
        .motion-list span { color: var(--sub); }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>

<header class="kit-hero">
    <div class="aura" aria-hidden="true"><span class="aura-1"></span><span class="aura-2"></span></div>
    <div class="wrap">
        <div>
            <h1>PAGER UI Kit</h1>
            <p>The colors, type and components used across PAGER. Everything here is live, so try clicking things.</p>
        </div>
        <a class="btn-ghost" href="{{ url('/') }}" style="text-decoration:none;">← Back to website</a>
    </div>
</header>

<main class="wrap">

    {{-- Colors --}}
    <section class="block">
        <h2>Colors</h2>
        <p class="note">Defined once in <code>partials/tokens.blade.php</code>. Purple is the brand; the accents color-code the five features.</p>
        @php
            $swatches = [
                ['Purple', '--purple', '#6a4fb3'], ['Purple dim', '--purple-dim', '#58409a'], ['Purple bg', '--purple-bg', '#f5f2fb'], ['Purple mid', '--purple-mid', '#ebe6f6'],
                ['Ink', '--ink', '#111827'], ['Sub', '--sub', '#6b7280'], ['Border', '--border', '#e5e7eb'], ['Background', '--bg', '#f8f7ff'],
                ['Green · Resources', '--green', '#059669'], ['Blue · Tips', '--blue', '#2563eb'], ['Amber · Milestones', '--amber', '#d97706'], ['Pink · Experts', '--pink', '#db2777'],
                ['Yellow · Accent', '--yellow', '#f4c542'], ['Danger', '--danger', '#dc2626'],
            ];
        @endphp
        <div class="swatches">
            @foreach ($swatches as [$name, $token, $hex])
                <div class="swatch">
                    <div class="swatch-color" style="background: var({{ $token }});"></div>
                    <div class="swatch-meta"><strong>{{ $name }}</strong><span>{{ $token }} · {{ $hex }}</span></div>
                </div>
            @endforeach
        </div>
    </section>

    <div class="grid-2">
        {{-- Type --}}
        <section class="block">
            <h2>Type</h2>
            <p class="note">Inter everywhere. Headings are 800 weight with tight letter-spacing.</p>
            <div class="type-row"><small>Hero · 800</small><span style="font-size:2rem;font-weight:800;letter-spacing:-0.04em;line-height:1.1;">Every caregiver</span></div>
            <div class="type-row"><small>Section · 800</small><span style="font-size:1.5rem;font-weight:800;letter-spacing:-0.035em;">Five modules</span></div>
            <div class="type-row"><small>Panel title</small><span style="font-size:0.875rem;font-weight:800;">Journal</span></div>
            <div class="type-row"><small>Body</small><span style="font-size:0.875rem;">How are you feeling today?</span></div>
            <div class="type-row"><small>Eyebrow</small><span style="font-size:0.72rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--purple);">Your timeline</span></div>
        </section>

        {{-- Buttons --}}
        <section class="block">
            <h2>Buttons</h2>
            <p class="note">They lift on hover and shrink slightly on press. There's one solid purple button per view.</p>
            <div class="row" style="margin-bottom:0.75rem;">
                <button class="btn-solid">Get started free <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                <button class="btn-save">Save entry</button>
            </div>
            <div class="row">
                <button class="btn-ghost">Log in</button>
                <button class="btn-danger">Delete account</button>
                <button class="btn-del" id="demoDelete" title="Delete entry"><x-icon name="trash-2" :size="14" /><span>Delete?</span></button>
                <small style="color:var(--sub);font-size:0.72rem;">← click twice: asks before deleting</small>
            </div>
        </section>
    </div>

    <div class="grid-2">
        {{-- Pills & badges --}}
        <section class="block">
            <h2>Pills &amp; badges</h2>
            <p class="note">Pills are choices you can toggle (mood, tags). Badges show a status.</p>
            <div class="row" style="margin-bottom:0.75rem;" id="demoPills">
                <button class="pill active">😊 Happy</button>
                <button class="pill">😌 Okay</button>
                <button class="pill">😴 Tired</button>
                <button class="pill">😰 Overwhelmed</button>
            </div>
            <div class="row">
                <span class="badge badge-ok">✓ Available now</span>
                <span class="badge badge-soon">Coming soon</span>
                <span class="badge badge-brand"><x-icon name="baby" :size="12" /> New Parent</span>
                <span class="badge badge-now">Now</span>
            </div>
        </section>

        {{-- Inputs --}}
        <section class="block">
            <h2>Inputs</h2>
            <p class="note">1.5px border, with a purple border and soft glow on focus. Errors sit under the field in red.</p>
            <div class="inputs">
                <label class="search" style="grid-column:1/-1;"><x-icon name="search" :size="15" /><input type="search" placeholder="Search your journal…"></label>
                <label class="field">Name<input class="input" type="text" value="Maria Santos"></label>
                <label class="field">Parent type
                    <select class="select"><option>New Parent</option><option>Expecting</option><option>Working Parent</option><option>Solo Parent</option></select>
                </label>
                <label class="field" style="grid-column:1/-1;">Email<input class="input is-error" type="email" value="maria@">
                    <span class="error-text">Please enter a valid email address.</span>
                </label>
            </div>
        </section>
    </div>

    <div class="grid-2">
        {{-- Milestones --}}
        <section class="block">
            <h2>Checklist &amp; progress</h2>
            <p class="note">The tick pops in, and the progress bar slides to the new value.</p>
            <div class="progress"><div id="demoProgress"></div></div>
            <div id="demoChecks">
                <label class="ms-item"><input type="checkbox" checked><span>First smile</span></label>
                <label class="ms-item"><input type="checkbox" checked><span>Holds head steady</span></label>
                <label class="ms-item"><input type="checkbox"><span>Coos and babbles</span></label>
                <label class="ms-item"><input type="checkbox"><span>Laughs out loud</span></label>
                <label class="ms-item"><input type="checkbox"><span>Rolls over</span></label>
            </div>
        </section>

        {{-- Reminder --}}
        <section class="block">
            <h2>Reminder card</h2>
            <p class="note">"Coming up" on the dashboard. Overdue items are amber; the bell rings twice on load.</p>
            <div class="reminder">
                <div class="reminder-hd">
                    <span class="reminder-icon"><x-icon name="bell" :size="15" /></span>
                    <div><strong>Coming up</strong><span>Your baby is 3 months old</span></div>
                </div>
                <ul class="reminder-list">
                    <li class="is-overdue"><span><x-icon name="circle-alert" :size="13" /> Follows moving objects</span><button class="reminder-done" aria-label="Mark done"><x-icon name="check" :size="13" :stroke-width="2.5" /></button></li>
                    <li><span>Holds head steady</span><button class="reminder-done" aria-label="Mark done"><x-icon name="check" :size="13" :stroke-width="2.5" /></button></li>
                </ul>
            </div>
        </section>
    </div>

    <div class="grid-2">
        {{-- Timeline entry --}}
        <section class="block">
            <h2>Journal timeline</h2>
            <p class="note">The dot color shows the mood. Search matches are highlighted.</p>
            <div class="tl-items">
                <article class="entry">
                    <span class="tl-dot"></span>
                    <div class="entry-meta"><span>Fri, Sep 25 · 6:58 PM</span><span class="badge badge-brand">😊 Happy</span></div>
                    <div class="entry-text">Baby <mark>slept</mark> five hours straight!</div>
                    <span class="entry-tag">#sleep</span>
                </article>
                <article class="entry">
                    <span class="tl-dot" style="border-color:var(--amber);background:var(--amber-bg);"></span>
                    <div class="entry-meta"><span>Tue, Sep 22 · 2:10 AM</span><span class="badge badge-brand">😴 Tired</span></div>
                    <div class="entry-text">Rough night of feeding.</div>
                    <span class="entry-tag">#feeding</span>
                </article>
            </div>
        </section>

        {{-- Toasts --}}
        <section class="block">
            <h2>Toasts</h2>
            <p class="note">Bottom-right (full width on phones). They hide themselves, and we use them instead of browser <code>alert()</code> pop-ups.</p>
            <div class="row" style="margin-bottom:1rem;">
                <span class="toast"><x-icon name="check" :size="15" :stroke-width="2.5" /> Entry saved to your journal.</span>
                <span class="toast is-error"><x-icon name="circle-alert" :size="15" :stroke-width="2.5" /> Couldn't save. Try again.</span>
            </div>
            <div class="row">
                <button class="btn-ghost" data-toast="Milestone saved.">Show success toast</button>
                <button class="btn-ghost" data-toast="Couldn't reach the server." data-error>Show error toast</button>
            </div>
        </section>
    </div>

    {{-- Icons --}}
    <section class="block">
        <h2>Icons</h2>
        <p class="note">Lucide, inlined server-side: <code>&lt;x-icon name="bell" :size="16" /&gt;</code>. Icons use <code>currentColor</code>, so they take the text color.</p>
        <div class="icons">
            @foreach (['book-open', 'notebook-pen', 'target', 'lightbulb', 'library', 'stethoscope', 'bell', 'search', 'calendar', 'check', 'x', 'circle-alert', 'trash-2', 'heart', 'baby', 'briefcase', 'sparkles', 'lock', 'brain', 'hand-heart', 'moon', 'milk', 'users', 'video'] as $icon)
                <div class="icon-cell"><x-icon :name="$icon" :size="20" />{{ $icon }}</div>
            @endforeach
        </div>
    </section>

    {{-- Motion --}}
    <section class="block">
        <h2>Motion</h2>
        <p class="note">Built with anime.js and CSS. Everything is turned down when the device asks for reduced motion.</p>
        <ul class="motion-list">
            <li><strong>Entrance</strong><span>Panels and cards fade up 20–28px, staggered 55–80ms, easeOutExpo.</span></li>
            <li><strong>Feedback</strong><span>Pills bounce (scale 0.88 → 1.06 → 1). Buttons shrink to 0.96 when pressed.</span></li>
            <li><strong>Milestones</strong><span>The tick pops in, the bar slides, and a finished group gets confetti and a toast.</span></li>
            <li><strong>Remove</strong><span>Deleted or completed rows slide right and fade out (260–280ms).</span></li>
            <li><strong>Ambient</strong><span>The Orchid Bloom aura in the landing hero drifts slowly (18–24s).</span></li>
        </ul>
    </section>
</main>

<div class="toast-stack" id="toasts" aria-live="polite"></div>

<script>
(() => {
    // Mood pills: one at a time
    document.querySelectorAll('#demoPills .pill').forEach(pill => pill.addEventListener('click', () => {
        document.querySelectorAll('#demoPills .pill').forEach(p => p.classList.toggle('active', p === pill && !pill.classList.contains('active')));
    }));

    // Checklist progress
    const checks = [...document.querySelectorAll('#demoChecks input')];
    const bar = document.getElementById('demoProgress');
    const update = () => { bar.style.width = (checks.filter(c => c.checked).length / checks.length * 100) + '%'; };
    checks.forEach(c => c.addEventListener('change', update));
    update();

    // Delete asks first
    const del = document.getElementById('demoDelete');
    del.addEventListener('click', () => {
        if (del.classList.contains('is-confirming')) { del.classList.remove('is-confirming'); showToast('Entry deleted.'); return; }
        del.classList.add('is-confirming');
        setTimeout(() => del.classList.remove('is-confirming'), 3000);
    });

    // Toasts
    const stack = document.getElementById('toasts');
    function showToast(message, isError) {
        const src = document.querySelector(isError ? '.toast.is-error svg' : '.toast:not(.is-error) svg');
        const toast = document.createElement('div');
        toast.className = 'toast' + (isError ? ' is-error' : '');
        toast.append(src.cloneNode(true), Object.assign(document.createElement('span'), { textContent: message }));
        stack.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
    document.querySelectorAll('[data-toast]').forEach(btn => btn.addEventListener('click', () => showToast(btn.dataset.toast, btn.hasAttribute('data-error'))));
})();
</script>
</body>
</html>
