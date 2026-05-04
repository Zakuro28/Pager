<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — PAGER</title>
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
            --surface:    #f8f7ff;
            --purple:     #7c3aed;
            --purple-dim: #6d28d9;
            --purple-bg:  #f5f3ff;
            --purple-mid: #ede9fe;
            --ok:         #059669;
            --ok-bg:      #ecfdf5;
        }

        body {
            font-family: "Inter", system-ui, sans-serif;
            background: var(--surface);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ── Scroll progress ── */
        #scroll-progress {
            position: fixed;
            top: 0; left: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--purple), #a78bfa);
            z-index: 9999;
            width: 0%;
        }

        /* ── Nav ── */
        .topnav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            width: min(1160px, 92vw);
            margin-inline: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            gap: 1rem;
        }

        .nav-brand {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            letter-spacing: -0.02em;
            flex-shrink: 0;
        }

        .nav-brand img { height: 28px; width: auto; transition: transform 0.3s; }
        .nav-brand:hover img { transform: rotate(-8deg) scale(1.1); }

        .nav-links {
            display: flex;
            gap: 0.125rem;
        }

        .nav-link {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--sub);
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            transition: color 0.15s, background 0.15s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--ink);
            background: var(--purple-bg);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            flex-shrink: 0;
        }

        .nav-user {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--sub);
        }

        .btn-logout {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--sub);
            background: none;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.35rem 0.75rem;
            cursor: pointer;
            font-family: "Inter", sans-serif;
            transition: color 0.15s, border-color 0.15s, background 0.15s;
        }

        .btn-logout:hover { color: var(--ink); border-color: #d1d5db; background: #f9fafb; }

        @media (max-width: 640px) { .nav-user, .nav-links { display: none; } }

        /* ── Main ── */
        .main {
            width: min(1160px, 92vw);
            margin-inline: auto;
            padding: 2rem 0 4rem;
        }

        /* ── Welcome ── */
        .welcome {
            margin-bottom: 2rem;
            opacity: 0;
        }

        .welcome-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .welcome h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
        }

        .welcome-sub { font-size: 0.875rem; color: var(--sub); }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
            background: var(--purple-bg);
            border: 1px solid var(--purple-mid);
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--purple);
            margin-top: 0.5rem;
        }

        .greeting-time {
            font-size: 0.8rem;
            color: var(--sub);
            font-weight: 500;
            margin-top: 0.25rem;
        }

        /* ── Toast ── */
        .toast {
            background: var(--ok-bg);
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ok);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ── Grid layout ── */
        .grid-dash {
            display: grid;
            grid-template-columns: 1.35fr 0.65fr;
            gap: 1.125rem;
            margin-bottom: 1.125rem;
        }

        @media (max-width: 800px) { .grid-dash { grid-template-columns: 1fr; } }

        /* ── Panel ── */
        .panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            opacity: 0;
            transition: box-shadow 0.2s;
        }

        .panel:hover { box-shadow: 0 4px 24px rgba(0,0,0,0.04); }

        .panel-title {
            font-size: 0.875rem;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 1.125rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.01em;
        }

        .panel-title .tag {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--purple);
            background: var(--purple-bg);
            border-radius: 999px;
            padding: 0.15rem 0.55rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ── Mood pills ── */
        .mood-row {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
            margin-bottom: 0.875rem;
        }

        .mood-pill {
            padding: 0.3rem 0.75rem;
            border: 1.5px solid var(--border);
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--sub);
            background: var(--white);
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s, color 0.15s, transform 0.15s;
            user-select: none;
        }

        .mood-pill:hover { border-color: #c4b5fd; color: var(--ink); transform: translateY(-1px); }

        .mood-pill.active {
            border-color: var(--purple);
            background: var(--purple-bg);
            color: var(--purple);
        }

        #mood-val { display: none; }

        .journal-area {
            width: 100%;
            min-height: 110px;
            padding: 0.8rem 0.9rem;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-family: "Inter", sans-serif;
            font-size: 0.875rem;
            color: var(--ink);
            resize: vertical;
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
            margin-bottom: 0.875rem;
            background: var(--white);
            line-height: 1.6;
        }

        .journal-area:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(124,58,237,0.08);
        }

        .journal-area::placeholder { color: #9ca3af; }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .char-count {
            font-size: 0.75rem;
            color: #9ca3af;
            font-variant-numeric: tabular-nums;
        }

        .char-count.near-limit { color: var(--purple); }

        .btn-save {
            padding: 0.575rem 1.25rem;
            background: var(--purple);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-family: "Inter", sans-serif;
            font-size: 0.8125rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s, transform 0.12s, box-shadow 0.2s;
        }

        .btn-save:hover {
            background: var(--purple-dim);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(124,58,237,0.3);
        }

        /* ── Entries ── */
        .entries { margin-top: 1.375rem; }

        .entries-hd {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--sub);
            margin-bottom: 0.75rem;
        }

        .entry {
            padding: 0.9rem 0;
            border-top: 1px solid var(--border);
            transition: background 0.15s;
            border-radius: 6px;
        }

        .entry:first-child { border-top: none; }

        .entry-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.375rem;
        }

        .entry-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--sub);
        }

        .entry-mood {
            padding: 0.1rem 0.5rem;
            border-radius: 999px;
            background: var(--purple-bg);
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--purple);
            border: 1px solid var(--purple-mid);
            text-transform: capitalize;
        }

        .entry-text {
            font-size: 0.875rem;
            color: var(--ink);
            line-height: 1.6;
        }

        .btn-del {
            background: none;
            border: none;
            font-size: 0.75rem;
            color: #d1d5db;
            cursor: pointer;
            padding: 0.2rem 0.35rem;
            border-radius: 4px;
            transition: color 0.15s, background 0.15s;
            line-height: 1;
        }

        .btn-del:hover { color: #ef4444; background: #fef2f2; }

        .empty {
            text-align: center;
            padding: 2rem 0;
            font-size: 0.875rem;
            color: var(--sub);
        }

        .empty-icon { font-size: 2rem; margin-bottom: 0.5rem; }

        /* ── Milestones ── */
        .ms-progress {
            background: var(--border);
            border-radius: 999px;
            height: 5px;
            margin-bottom: 1.125rem;
            overflow: hidden;
        }

        .ms-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--purple), #a78bfa);
            border-radius: 999px;
            width: 0%;
            transition: width 0.6s ease;
        }

        .ms-group { margin-bottom: 1.125rem; }

        .ms-group-label {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--purple);
            margin-bottom: 0.5rem;
        }

        .ms-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.4rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.8125rem;
            transition: background 0.12s;
        }

        .ms-item:last-child { border-bottom: none; }

        .ms-item input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: var(--purple);
            margin-top: 2px;
            flex-shrink: 0;
            cursor: pointer;
        }

        .ms-item label { cursor: pointer; line-height: 1.45; color: var(--ink); transition: color 0.15s; }
        .ms-item input:checked + label { text-decoration: line-through; color: var(--sub); }

        /* ── Resources ── */
        .sec-hd {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .sec-hd h2 {
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .sec-hd span { font-size: 0.75rem; color: var(--sub); }

        .res-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.875rem;
        }

        @media (max-width: 860px) { .res-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 520px)  { .res-grid { grid-template-columns: 1fr; } }

        .res-card {
            padding: 1.125rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: var(--white);
            text-decoration: none;
            color: inherit;
            transition: border-color 0.18s, background 0.18s, transform 0.18s, box-shadow 0.18s;
            display: block;
            opacity: 0;
            position: relative;
            overflow: hidden;
        }

        .res-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--purple), #a78bfa);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }

        .res-card:hover {
            border-color: #c4b5fd;
            background: var(--purple-bg);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124,58,237,0.1);
        }

        .res-card:hover::before { transform: scaleX(1); }

        .res-type {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 0.4rem;
        }

        .res-card h3 {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.35rem;
            letter-spacing: -0.01em;
        }

        .res-card p { font-size: 0.8rem; color: var(--sub); line-height: 1.55; }

        /* ── CTA strip ── */
        .cta-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 1.5rem;
            border: 1.5px solid var(--purple-mid);
            border-radius: 12px;
            background: linear-gradient(135deg, var(--purple-bg), #faf5ff);
            margin-top: 1.125rem;
            opacity: 0;
            position: relative;
            overflow: hidden;
        }

        .cta-strip::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(124,58,237,0.08), transparent 70%);
            pointer-events: none;
        }

        .cta-strip h3 { font-size: 0.9375rem; font-weight: 800; letter-spacing: -0.02em; }
        .cta-strip p  { font-size: 0.8125rem; color: var(--sub); margin-top: 0.25rem; }

        .btn-cta {
            padding: 0.6rem 1.25rem;
            background: var(--purple);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-family: "Inter", sans-serif;
            font-size: 0.8125rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s, transform 0.12s, box-shadow 0.2s;
            flex-shrink: 0;
        }

        .btn-cta:hover {
            background: var(--purple-dim);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(124,58,237,0.3);
        }
    </style>
</head>
<body>

<div id="scroll-progress"></div>

<nav class="topnav" id="topNav">
    <div class="nav-inner">
        <a class="nav-brand" href="/"><img src="{{ asset('logo.png') }}" alt="Pager"> PAGER</a>

        <div class="nav-links">
            <a class="nav-link active" href="#journal">Journal</a>
            <a class="nav-link" href="#milestones">Milestones</a>
            <a class="nav-link" href="#resources">Resources</a>
        </div>

        <div class="nav-right">
            <span class="nav-user">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-logout" type="submit">Log out</button>
            </form>
        </div>
    </div>
</nav>

<main class="main">

    @php
        $typeMap = [
            'expecting'      => '🤰 Expecting Parent',
            'new_parent'     => '👶 New Parent',
            'working_parent' => '💼 Working Parent',
            'solo_parent'    => '⭐ Solo Parent',
        ];
        $typeLabel = $typeMap[auth()->user()->parent_type ?? ''] ?? '👋 Parent';

        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
    @endphp

    <div class="welcome" id="welcome">
        <div class="welcome-top">
            <div>
                <h1>{{ $greeting }}, {{ auth()->user()->name }} 👋</h1>
                <p class="welcome-sub">Your parenting dashboard — everything in one place.</p>
                <span class="badge">{{ $typeLabel }}</span>
            </div>
        </div>
    </div>

    @if (session('journal_saved'))
        <div class="toast">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            Entry saved successfully.
        </div>
    @endif

    <div class="grid-dash">

        <!-- Journal -->
        <div class="panel" id="journal">
            <div class="panel-title">
                Journal
                <span class="tag">Private</span>
            </div>

            <form method="POST" action="{{ route('journal.store') }}" id="journalForm">
                @csrf
                <input type="hidden" name="mood" id="mood-val">

                <div class="mood-row">
                    @foreach(['😊 Happy' => 'happy', '😌 Okay' => 'okay', '😴 Tired' => 'tired', '😰 Overwhelmed' => 'overwhelmed'] as $label => $value)
                        <button type="button" class="mood-pill" data-mood="{{ $value }}">{{ $label }}</button>
                    @endforeach
                </div>

                <textarea class="journal-area" name="content" id="journalText"
                    placeholder="How are you feeling today? Write about a milestone, a moment, or anything on your mind…"
                    maxlength="2000"
                    required></textarea>

                <div class="form-footer">
                    <span class="char-count" id="charCount">0 / 2000</span>
                    <button class="btn-save" type="submit">Save entry</button>
                </div>
            </form>

            <div class="entries">
                @if ($entries->count())
                    <div class="entries-hd">Recent entries</div>
                @endif

                @forelse ($entries as $entry)
                    <div class="entry" style="opacity:0;" data-entry>
                        <div class="entry-meta">
                            <div class="entry-info">
                                <span>{{ $entry->created_at->format('M j, Y') }}</span>
                                @if ($entry->mood)
                                    <span class="entry-mood">{{ $entry->mood }}</span>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('journal.destroy', $entry) }}">
                                @csrf @method('DELETE')
                                <button class="btn-del" type="submit" title="Delete">✕</button>
                            </form>
                        </div>
                        <div class="entry-text">{{ $entry->content }}</div>
                    </div>
                @empty
                    <div class="empty">
                        <div class="empty-icon">📝</div>
                        No entries yet. Write your first one above.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Milestones -->
        <div class="panel" id="milestones">
            <div class="panel-title">Milestones</div>

            <div class="ms-progress">
                <div class="ms-progress-fill" id="msProgress"></div>
            </div>

            @php
                $milestones = [
                    '0–2 months'  => ['Responds to sounds','Focuses on faces','Follows moving objects','First smile'],
                    '2–4 months'  => ['Holds head steady','Pushes up (tummy time)','Coos and babbles','Laughs out loud'],
                    '4–6 months'  => ['Rolls over','Sits with support','Reaches for objects','Recognizes familiar faces'],
                    '6–9 months'  => ['Sits without support','Says "mama" or "dada"','Picks up small objects','Crawls or scoots'],
                ];
            @endphp

            @foreach ($milestones as $group => $items)
                <div class="ms-group">
                    <div class="ms-group-label">{{ $group }}</div>
                    @foreach ($items as $i => $item)
                        @php $id = 'ms-' . Str::slug($group) . '-' . $i; @endphp
                        <div class="ms-item">
                            <input type="checkbox" id="{{ $id }}" class="ms-check">
                            <label for="{{ $id }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <!-- Resources -->
    <div id="resources">
        <div class="sec-hd">
            <h2>Caregiving Resources</h2>
            <span>Expert-backed content</span>
        </div>

        <div class="res-grid">
            @php
                $resources = [
                    ['Article',   'Newborn Sleep Guide',    'Evidence-based strategies to help your baby (and you) sleep better in the first months.'],
                    ['Article',   'Responsive Feeding',      'Understanding hunger cues and building a healthy feeding relationship with your baby.'],
                    ['Video',     'Tummy Time Tips',         'Short exercises to help strengthen your baby\'s neck and shoulder muscles safely.'],
                    ['Checklist', 'Well-Baby Checkup Prep', 'Questions to ask your pediatrician at every routine visit from birth to 12 months.'],
                    ['Article',   'Caregiver Self-Care',    'Why caring for yourself is one of the best things you can do for your child.'],
                    ['Guide',     'Baby-Proofing Your Home','Room-by-room safety checklist as your baby starts to move and explore.'],
                ];
            @endphp
            @foreach ($resources as $res)
                <a class="res-card" href="#">
                    <div class="res-type">{{ $res[0] }}</div>
                    <h3>{{ $res[1] }}</h3>
                    <p>{{ $res[2] }}</p>
                </a>
            @endforeach
        </div>

        <div class="cta-strip" id="ctaStrip">
            <div>
                <h3>Talk to a Parenting Expert</h3>
                <p>Book a one-on-one consultation with a certified child development specialist.</p>
            </div>
            <a class="btn-cta" href="#">Book a Consultation</a>
        </div>
    </div>

</main>

<script>
(() => {
    /* ── Scroll progress ── */
    const prog = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
        const pct = window.scrollY / (document.body.scrollHeight - window.innerHeight) * 100;
        prog.style.width = Math.min(pct, 100) + '%';
    }, { passive: true });

    /* ── Nav scroll shadow ── */
    const nav = document.querySelector('.topnav');
    window.addEventListener('scroll', () => {
        nav.style.boxShadow = window.scrollY > 4 ? '0 1px 16px rgba(0,0,0,0.06)' : 'none';
    }, { passive: true });

    /* ── Page entrance ── */
    const tl = anime.timeline({ easing: 'easeOutExpo' });
    tl.add({ targets: '#welcome',    opacity:[0,1], translateY:[20,0], duration:700 })
      .add({ targets: '#journal',    opacity:[0,1], translateY:[24,0], duration:650 }, '-=400')
      .add({ targets: '#milestones', opacity:[0,1], translateY:[24,0], duration:650 }, '-=500');

    /* ── Journal entry stagger ── */
    const entries = document.querySelectorAll('[data-entry]');
    anime({
        targets: entries,
        opacity: [0, 1],
        translateY: [14, 0],
        duration: 500,
        delay: anime.stagger(70, { start: 600 }),
        easing: 'easeOutExpo'
    });

    /* ── Scroll-triggered ── */
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            obs.unobserve(e.target);
            if (e.target.classList.contains('res-grid')) {
                anime({ targets: e.target.querySelectorAll('.res-card'), opacity:[0,1], translateY:[20,0], duration:550, easing:'easeOutExpo', delay:anime.stagger(80) });
            } else {
                anime({ targets: e.target, opacity:[0,1], translateY:[18,0], duration:550, easing:'easeOutExpo' });
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.res-grid, #ctaStrip').forEach(el => obs.observe(el));

    /* ── Mood pills with bounce ── */
    const moodVal = document.getElementById('mood-val');
    document.querySelectorAll('.mood-pill').forEach(btn => {
        btn.addEventListener('click', () => {
            const wasActive = btn.classList.contains('active');
            document.querySelectorAll('.mood-pill').forEach(b => b.classList.remove('active'));
            if (!wasActive) {
                btn.classList.add('active');
                moodVal.value = btn.dataset.mood;
                anime({ targets: btn, scale:[0.88,1.06,1], duration:350, easing:'easeOutBack' });
            } else {
                moodVal.value = '';
            }
        });
    });

    /* ── Character counter ── */
    const journalText = document.getElementById('journalText');
    const charCount   = document.getElementById('charCount');
    journalText.addEventListener('input', () => {
        const len = journalText.value.length;
        charCount.textContent = len + ' / 2000';
        charCount.classList.toggle('near-limit', len > 1800);
    });

    /* ── Save button animation ── */
    document.getElementById('journalForm').addEventListener('submit', function() {
        const btn = this.querySelector('.btn-save');
        anime({ targets: btn, scale:[1,0.93,1], duration:200, easing:'easeOutQuad' });
    });

    /* ── Milestones: persist + progress bar ── */
    const checks = document.querySelectorAll('.ms-check');
    const progressBar = document.getElementById('msProgress');

    function updateProgress() {
        const total   = checks.length;
        const checked = [...checks].filter(c => c.checked).length;
        const pct = total > 0 ? (checked / total) * 100 : 0;
        progressBar.style.width = pct + '%';
    }

    checks.forEach(cb => {
        const key = 'pager-ms-' + cb.id;
        if (localStorage.getItem(key) === '1') cb.checked = true;
        cb.addEventListener('change', () => {
            localStorage.setItem(key, cb.checked ? '1' : '0');
            anime({ targets: cb.parentElement, backgroundColor:['rgba(124,58,237,0.06)','transparent'], duration:400, easing:'easeOutQuad' });
            updateProgress();
        });
    });
    updateProgress();

    /* Animate progress bar on load */
    setTimeout(() => {
        const total   = checks.length;
        const checked = [...checks].filter(c => c.checked).length;
        const pct = total > 0 ? (checked / total) * 100 : 0;
        anime({ targets: progressBar, width: pct + '%', duration: 1000, easing: 'easeOutExpo', delay: 500 });
    }, 0);

    /* ── Smooth scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const t = document.querySelector(a.getAttribute('href'));
            if (!t) return;
            e.preventDefault();
            window.scrollTo({ top: t.getBoundingClientRect().top + scrollY - 68, behavior: 'smooth' });
        });
    });
})();
</script>
</body>
</html>
