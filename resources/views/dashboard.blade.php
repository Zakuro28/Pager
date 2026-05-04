<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — PAGER</title>
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
            --surface:    #f9fafb;
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
        }

        /* ── Nav ── */
        .topnav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            width: min(1140px, 92vw);
            margin-inline: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 58px;
            gap: 1rem;
        }

        .nav-brand {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .logo-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--purple); }

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

        .nav-link:hover, .nav-link.active { color: var(--ink); background: var(--purple-bg); }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
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

        /* ── Main ── */
        .main {
            width: min(1140px, 92vw);
            margin-inline: auto;
            padding: 2rem 0 4rem;
        }

        /* ── Welcome ── */
        .welcome {
            margin-bottom: 1.75rem;
            opacity: 0;
        }

        .welcome h1 {
            font-size: 1.375rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .welcome p { font-size: 0.875rem; color: var(--sub); }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            background: var(--purple-bg);
            border: 1px solid var(--purple-mid);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--purple);
            margin-top: 0.5rem;
        }

        /* ── Toast ── */
        .toast {
            background: var(--ok-bg);
            border: 1px solid #a7f3d0;
            border-radius: 7px;
            padding: 0.625rem 0.875rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ok);
            margin-bottom: 1rem;
        }

        /* ── Grid layout ── */
        .grid-dash {
            display: grid;
            grid-template-columns: 1.3fr 0.7fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 780px) { .grid-dash { grid-template-columns: 1fr; } }

        /* ── Panel ── */
        .panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.375rem;
            opacity: 0;
        }

        .panel-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .panel-title .tag {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--purple);
            background: var(--purple-bg);
            border-radius: 999px;
            padding: 0.15rem 0.5rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        /* ── Journal ── */
        .mood-row {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
            margin-bottom: 0.75rem;
        }

        .mood-pill {
            padding: 0.3rem 0.7rem;
            border: 1px solid var(--border);
            border-radius: 999px;
            font-size: 0.775rem;
            font-weight: 500;
            color: var(--sub);
            background: var(--white);
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s, color 0.15s;
        }

        .mood-pill:hover { border-color: #c4b5fd; color: var(--ink); }
        .mood-pill.active { border-color: var(--purple); background: var(--purple-bg); color: var(--purple); }

        #mood-val { display: none; }

        .journal-area {
            width: 100%;
            min-height: 100px;
            padding: 0.75rem 0.875rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: "Inter", sans-serif;
            font-size: 0.875rem;
            color: var(--ink);
            resize: vertical;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            margin-bottom: 0.75rem;
            background: var(--white);
        }

        .journal-area:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(124,58,237,0.08);
        }

        .journal-area::placeholder { color: #9ca3af; }

        .btn-save {
            padding: 0.55rem 1.125rem;
            background: var(--purple);
            color: var(--white);
            border: none;
            border-radius: 7px;
            font-family: "Inter", sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s, transform 0.12s;
        }

        .btn-save:hover { background: var(--purple-dim); transform: translateY(-1px); }

        /* ── Entries ── */
        .entries { margin-top: 1.25rem; }

        .entry {
            padding: 0.875rem 0;
            border-top: 1px solid var(--border);
        }

        .entry-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.3rem;
        }

        .entry-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.775rem;
            color: var(--sub);
        }

        .entry-mood {
            padding: 0.1rem 0.45rem;
            border-radius: 999px;
            background: var(--purple-bg);
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--purple);
            border: 1px solid var(--purple-mid);
        }

        .entry-text {
            font-size: 0.875rem;
            color: var(--ink);
            line-height: 1.55;
        }

        .btn-del {
            background: none;
            border: none;
            font-size: 0.75rem;
            color: #d1d5db;
            cursor: pointer;
            padding: 0.15rem 0.3rem;
            border-radius: 4px;
            transition: color 0.15s, background 0.15s;
        }

        .btn-del:hover { color: #ef4444; background: #fef2f2; }

        .empty {
            text-align: center;
            padding: 1.5rem 0;
            font-size: 0.875rem;
            color: var(--sub);
        }

        /* ── Milestones ── */
        .ms-group { margin-bottom: 1rem; }

        .ms-group-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
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
        }

        .ms-item:last-child { border-bottom: none; }

        .ms-item input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: var(--purple);
            margin-top: 2px;
            flex-shrink: 0;
        }

        .ms-item label { cursor: pointer; line-height: 1.4; color: var(--ink); }
        .ms-item input:checked + label { text-decoration: line-through; color: var(--sub); }

        /* ── Resources ── */
        .res-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        @media (max-width: 860px) { .res-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 520px)  { .res-grid { grid-template-columns: 1fr; } }

        .res-card {
            padding: 1rem;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--white);
            text-decoration: none;
            color: inherit;
            transition: border-color 0.15s, background 0.15s;
            display: block;
            opacity: 0;
        }

        .res-card:hover { border-color: #c4b5fd; background: var(--purple-bg); }

        .res-type {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 0.4rem;
        }

        .res-card h3 {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 0.3rem;
            letter-spacing: -0.01em;
        }

        .res-card p { font-size: 0.8rem; color: var(--sub); line-height: 1.5; }

        /* ── CTA ── */
        .cta-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 1.375rem 1.5rem;
            border: 1px solid var(--purple-mid);
            border-radius: 10px;
            background: var(--purple-bg);
            margin-top: 1rem;
            opacity: 0;
        }

        .cta-strip h3 { font-size: 0.9375rem; font-weight: 700; letter-spacing: -0.01em; }
        .cta-strip p  { font-size: 0.8125rem; color: var(--sub); margin-top: 0.2rem; }

        .btn-cta {
            padding: 0.55rem 1.1rem;
            background: var(--purple);
            color: var(--white);
            border: none;
            border-radius: 7px;
            font-family: "Inter", sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s;
            flex-shrink: 0;
        }

        .btn-cta:hover { background: var(--purple-dim); }

        /* ── Section header ── */
        .sec-hd {
            display: flex;
            align-items: baseline;
            gap: 0.75rem;
            margin-bottom: 0.875rem;
        }

        .sec-hd h2 {
            font-size: 0.9375rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .sec-hd span {
            font-size: 0.75rem;
            color: var(--sub);
        }

        @media (max-width: 640px) {
            .nav-user { display: none; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

<nav class="topnav">
    <div class="nav-inner">
        <a class="nav-brand" href="/"><span class="logo-dot"></span> PAGER</a>

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
            'expecting'      => 'Expecting Parent',
            'new_parent'     => 'New Parent',
            'working_parent' => 'Working Parent',
            'solo_parent'    => 'Solo Parent',
        ];
        $typeLabel = $typeMap[auth()->user()->parent_type ?? ''] ?? 'Parent';
    @endphp

    <div class="welcome" id="welcome">
        <h1>Good to see you, {{ auth()->user()->name }}</h1>
        <p>Your parenting dashboard — everything in one place.</p>
        <span class="badge">{{ $typeLabel }}</span>
    </div>

    @if (session('journal_saved'))
        <div class="toast">Entry saved successfully.</div>
    @endif

    <div class="grid-dash">

        <!-- Journal -->
        <div class="panel" id="journal">
            <div class="panel-title">
                Journal
                <span class="tag">Private</span>
            </div>

            <form method="POST" action="{{ route('journal.store') }}">
                @csrf
                <input type="hidden" name="mood" id="mood-val">

                <div class="mood-row">
                    @foreach(['😊 Happy' => 'happy', '😌 Okay' => 'okay', '😴 Tired' => 'tired', '😰 Overwhelmed' => 'overwhelmed'] as $label => $value)
                        <button type="button" class="mood-pill" data-mood="{{ $value }}">{{ $label }}</button>
                    @endforeach
                </div>

                <textarea class="journal-area" name="content"
                    placeholder="How are you feeling today? Write about a milestone, a moment, or anything on your mind…"
                    required></textarea>

                <button class="btn-save" type="submit">Save entry</button>
            </form>

            <div class="entries">
                @forelse ($entries as $entry)
                    <div class="entry">
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
                    <div class="empty">No entries yet. Write your first one above.</div>
                @endforelse
            </div>
        </div>

        <!-- Milestones -->
        <div class="panel" id="milestones">
            <div class="panel-title">Milestones Checklist</div>

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
                            <input type="checkbox" id="{{ $id }}">
                            <label for="{{ $id }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>

    <!-- Resources -->
    <div id="resources" style="margin-top: 0.25rem;">
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
    /* ── Page entrance ── */
    anime.timeline({ easing: 'easeOutExpo' })
        .add({ targets: '#welcome',    opacity: [0,1], translateY: [16,0], duration: 600 })
        .add({ targets: '#journal',    opacity: [0,1], translateY: [20,0], duration: 600 }, '-=300')
        .add({ targets: '#milestones', opacity: [0,1], translateY: [20,0], duration: 600 }, '-=450');

    /* ── Scroll-triggered ── */
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            obs.unobserve(e.target);
            if (e.target.classList.contains('res-grid')) {
                anime({ targets: e.target.querySelectorAll('.res-card'), opacity:[0,1], translateY:[18,0], duration:550, easing:'easeOutExpo', delay: anime.stagger(70) });
            } else {
                anime({ targets: e.target, opacity:[0,1], translateY:[16,0], duration:550, easing:'easeOutExpo' });
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.res-grid, #ctaStrip').forEach(el => obs.observe(el));

    /* ── Mood pills ── */
    const moodVal = document.getElementById('mood-val');
    document.querySelectorAll('.mood-pill').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.mood-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            moodVal.value = btn.dataset.mood;
        });
    });

    /* ── Persist milestones ── */
    document.querySelectorAll('.ms-item input[type="checkbox"]').forEach(cb => {
        const key = 'pager-ms-' + cb.id;
        if (localStorage.getItem(key) === '1') cb.checked = true;
        cb.addEventListener('change', () => localStorage.setItem(key, cb.checked ? '1' : '0'));
    });

    /* ── Nav scroll shadow ── */
    const nav = document.querySelector('.topnav');
    window.addEventListener('scroll', () => {
        nav.style.boxShadow = window.scrollY > 4 ? '0 1px 14px rgba(0,0,0,0.06)' : 'none';
    }, { passive: true });

    /* ── Smooth scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const t = document.querySelector(a.getAttribute('href'));
            if (!t) return;
            e.preventDefault();
            window.scrollTo({ top: t.getBoundingClientRect().top + scrollY - 66, behavior: 'smooth' });
        });
    });
})();
</script>
</body>
</html>
