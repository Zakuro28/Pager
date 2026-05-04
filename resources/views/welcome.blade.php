<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAGER — The Parenting Manager</title>

    <!-- Inter font — same family used by professional SaaS sites -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet">
    <!-- Anime.js — professional animation library -->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.2/lib/anime.min.js"></script>

    <style>
        /* ── Reset ─────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }

        /* ── Tokens ─────────────────────────────────────────── */
        :root {
            --white:      #ffffff;
            --ink:        #111827;
            --sub:        #6b7280;
            --border:     #e5e7eb;
            --purple:     #7c3aed;
            --purple-dim: #6d28d9;
            --purple-bg:  #f5f3ff;
            --purple-mid: #ede9fe;
        }

        /* ── Base ─────────────────────────────────────────── */
        body {
            font-family: "Inter", system-ui, -apple-system, sans-serif;
            background: var(--white);
            color: var(--ink);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a { color: inherit; text-decoration: none; }

        /* ── Layout ─────────────────────────────────────────── */
        .wrap {
            width: min(1100px, 88vw);
            margin-inline: auto;
        }

        /* ── Nav ─────────────────────────────────────────── */
        .site-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            gap: 2rem;
        }

        .nav-logo {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .logo-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--purple);
            display: inline-block;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 0.25rem;
        }

        .nav-links a {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--sub);
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            transition: color 0.15s, background 0.15s;
        }

        .nav-links a:hover {
            color: var(--ink);
            background: var(--purple-bg);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            flex-shrink: 0;
        }

        .btn-nav-ghost {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--sub);
            padding: 0.4rem 0.875rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            transition: color 0.15s, border-color 0.15s, background 0.15s;
        }

        .btn-nav-ghost:hover {
            color: var(--ink);
            border-color: #d1d5db;
            background: #f9fafb;
        }

        .btn-nav-solid {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--white);
            background: var(--purple);
            padding: 0.4rem 0.875rem;
            border-radius: 6px;
            border: 1px solid transparent;
            transition: background 0.15s;
        }

        .btn-nav-solid:hover { background: var(--purple-dim); }

        /* Mobile hamburger */
        .nav-hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            color: var(--ink);
        }

        .nav-mobile {
            display: none;
            border-top: 1px solid var(--border);
            padding: 1rem 0;
        }

        .nav-mobile.open { display: block; }

        .nav-mobile a {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--sub);
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border);
            transition: color 0.15s;
        }

        .nav-mobile a:last-child { border-bottom: none; }
        .nav-mobile a:hover { color: var(--ink); }

        @media (max-width: 680px) {
            .nav-links, .nav-actions { display: none; }
            .nav-hamburger { display: flex; }
        }

        /* ── Hero ─────────────────────────────────────────── */
        .hero {
            padding: 5.5rem 0 5rem;
            border-bottom: 1px solid var(--border);
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 1.75rem;
        }

        .hero-label::before {
            content: "";
            width: 20px;
            height: 1.5px;
            background: var(--purple);
            display: inline-block;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5.5vw, 4rem);
            font-weight: 700;
            line-height: 1.08;
            letter-spacing: -0.035em;
            color: var(--ink);
            max-width: 16ch;
            margin-bottom: 1.5rem;
        }

        .hero h1 span {
            color: var(--purple);
        }

        .hero-sub {
            font-size: 1.0625rem;
            color: var(--sub);
            max-width: 50ch;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-solid {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--white);
            background: var(--purple);
            padding: 0.7rem 1.5rem;
            border-radius: 7px;
            border: 1px solid transparent;
            transition: background 0.15s, transform 0.15s;
        }

        .btn-solid:hover { background: var(--purple-dim); transform: translateY(-1px); }

        .btn-text {
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--sub);
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.15s;
        }

        .btn-text:hover { color: var(--ink); }

        .arrow { transition: transform 0.15s; }
        .btn-text:hover .arrow { transform: translateX(3px); }

        /* ── Stats ─────────────────────────────────────────── */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        .stat {
            padding: 2.25rem 0;
            padding-right: 2rem;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .stat:first-child { padding-left: 0; }
        .stat:last-child { border-right: none; padding-right: 0; padding-left: 2rem; }
        .stat:nth-child(2), .stat:nth-child(3) { padding-left: 2rem; }

        .stat-num {
            font-size: 1.875rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--ink);
            margin-bottom: 0.3rem;
        }

        .stat-desc {
            font-size: 0.875rem;
            color: var(--sub);
            line-height: 1.5;
        }

        @media (max-width: 700px) {
            .stats { grid-template-columns: 1fr 1fr; }
            .stat:nth-child(2) { border-right: none; }
            .stat:nth-child(3) { border-right: 1px solid var(--border); padding-left: 0; }
            .stat:last-child { padding-left: 0; }
            .stat { padding: 1.75rem 0; padding-right: 1.5rem; }
            .stat:nth-child(2n) { padding-right: 0; padding-left: 1.5rem; }
        }

        @media (max-width: 400px) {
            .stats { grid-template-columns: 1fr; }
            .stat, .stat:last-child, .stat:nth-child(2), .stat:nth-child(3) {
                padding: 1.5rem 0;
                padding-right: 0;
                padding-left: 0;
                border-right: none;
            }
        }

        /* ── Sections ─────────────────────────────────────────── */
        .section {
            padding: 5.5rem 0;
            border-bottom: 1px solid var(--border);
        }

        .eyebrow {
            font-size: 0.8125rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .eyebrow::before {
            content: "";
            width: 20px;
            height: 1.5px;
            background: var(--purple);
        }

        .section-h {
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.15;
            color: var(--ink);
            max-width: 22ch;
            margin-bottom: 1rem;
        }

        .section-p {
            font-size: 1rem;
            color: var(--sub);
            max-width: 54ch;
            line-height: 1.7;
            margin-bottom: 3.5rem;
        }

        /* ── Feature cards ─────────────────────────────────────────── */
        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        @media (max-width: 780px) { .cards { grid-template-columns: 1fr; } }

        .card {
            padding: 2rem 1.875rem;
            border-right: 1px solid var(--border);
            transition: background 0.18s;
        }

        .card:last-child { border-right: none; }

        @media (max-width: 780px) {
            .card { border-right: none; border-bottom: 1px solid var(--border); }
            .card:last-child { border-bottom: none; }
        }

        .card:hover { background: var(--purple-bg); }

        .card-num {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 1.25rem;
        }

        .card h3 {
            font-size: 1.0625rem;
            font-weight: 600;
            letter-spacing: -0.01em;
            color: var(--ink);
            margin-bottom: 0.625rem;
        }

        .card p {
            font-size: 0.9rem;
            color: var(--sub);
            line-height: 1.65;
            margin-bottom: 1.5rem;
        }

        .link-arrow {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--purple);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: gap 0.15s;
        }

        .link-arrow:hover { gap: 0.5rem; }

        /* ── About / Mission ─────────────────────────────────────────── */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: start;
        }

        @media (max-width: 740px) { .about-grid { grid-template-columns: 1fr; gap: 2.5rem; } }

        .about-text p {
            font-size: 0.9375rem;
            color: var(--sub);
            line-height: 1.75;
            margin-bottom: 1rem;
        }

        .about-ctas {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .values {
            list-style: none;
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .value {
            display: flex;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        .value:last-child { border-bottom: none; }
        .value:hover { background: var(--purple-bg); }

        .value-n {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--purple);
            min-width: 1.5rem;
            padding-top: 2px;
        }

        .value-body strong {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 0.2rem;
        }

        .value-body span {
            font-size: 0.855rem;
            color: var(--sub);
            line-height: 1.55;
        }

        /* ── CTA Banner ─────────────────────────────────────────── */
        .cta-band {
            padding: 5.5rem 0;
        }

        .cta-inner {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 3.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
            background: var(--purple-bg);
        }

        .cta-inner h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            letter-spacing: -0.025em;
            color: var(--ink);
            max-width: 30ch;
            line-height: 1.2;
        }

        .cta-inner h2 span { color: var(--purple); }

        /* ── Footer ─────────────────────────────────────────── */
        .site-footer {
            border-top: 1px solid var(--border);
            padding: 2rem 0;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .footer-logo {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .footer-links {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        .footer-links a {
            font-size: 0.875rem;
            color: var(--sub);
            transition: color 0.15s;
        }

        .footer-links a:hover { color: var(--ink); }

        .footer-copy {
            font-size: 0.8125rem;
            color: #9ca3af;
        }

        @media (max-width: 640px) {
            .footer-inner { flex-direction: column; align-items: flex-start; }
            .cta-inner { padding: 2rem 1.5rem; }
            .hero { padding: 3.5rem 0 3rem; }
            .section { padding: 3.5rem 0; }
            .cta-band { padding: 3.5rem 0; }
        }

        /* ── Ticker ──────────────────────────────────────────── */
        .ticker-wrap {
            overflow: hidden;
            border-top: 1px solid var(--border);
            margin-top: 3rem;
            padding: 0.9rem 0;
            mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
        }

        .ticker-track {
            display: flex;
            gap: 0;
            white-space: nowrap;
            will-change: transform;
        }

        .ticker-item {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--sub);
            padding: 0 1.75rem;
            flex-shrink: 0;
        }

        .ticker-sep {
            color: var(--purple);
            font-size: 0.78rem;
            flex-shrink: 0;
            padding: 0 0.25rem;
            opacity: 0.5;
        }

        /* ── Hero elements start hidden for anime.js ── */
        .hero-label,
        .hero h1,
        .hero-sub,
        .hero-actions { opacity: 0; }

        /* ── Scroll-animated elements start hidden ── */
        .anim-up { opacity: 0; transform: translateY(24px); }
    </style>
</head>
<body>

@php
    $loginUrl    = Route::has('login')    ? route('login')    : url('/login');
    $registerUrl = Route::has('register') ? route('register') : url('/register');
@endphp

<!-- ── Nav ──────────────────────────────────────────────────── -->
<header class="site-nav" id="top">
    <div class="wrap nav-inner">
        <a class="nav-logo" href="/">
            <span class="logo-dot"></span>
            PAGER
        </a>

        <ul class="nav-links">
            <li><a href="#about">About</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#shop">Shop</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>

        <div class="nav-actions">
            @auth
                <a class="btn-nav-solid" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a class="btn-nav-ghost" href="{{ $loginUrl }}">Log in</a>
                <a class="btn-nav-solid" href="{{ $registerUrl }}">Get started</a>
            @endauth
        </div>

        <button class="nav-hamburger" id="menuBtn" aria-label="Open menu" aria-expanded="false">
            <svg id="iconMenu" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            <svg id="iconClose" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <div class="wrap nav-mobile" id="mobileMenu">
        <a href="#about">About</a>
        <a href="#features">Features</a>
        <a href="#shop">Shop</a>
        <a href="#contact">Contact</a>
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
        @else
            <a href="{{ $loginUrl }}">Log in</a>
            <a href="{{ $registerUrl }}">Get started</a>
        @endauth
    </div>
</header>

<!-- ── Hero ──────────────────────────────────────────────────── -->
<section class="hero">
    <div class="wrap">
        <div class="hero-label">The Parenting Manager</div>
        <h1>We support caregivers.<br>Because parenting<br>is <span>hard.</span></h1>
        <p class="hero-sub">
            PAGER is an all-in-one caregiving platform — a personalized journal,
            milestone guide, and resource library that grows alongside your family.
        </p>
        <div class="hero-actions">
            <a class="btn-solid" href="{{ $registerUrl }}">
                Get started free
                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a class="btn-text" href="#features">
                See what's included
                <svg class="arrow" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Scrolling trust ticker -->
        <div class="ticker-wrap">
            <div class="ticker-track" id="tickerTrack">
                <span class="ticker-item">Personalized Guidance</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Secure &amp; Private</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Expert-Backed Content</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Always Free Core</span><span class="ticker-sep">·</span>
                <span class="ticker-item">AI-Driven</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Mobile Ready</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Milestone Tracking</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Digital Journal</span><span class="ticker-sep">·</span>
            </div>
        </div>
    </div>
</section>

<!-- ── Stats ──────────────────────────────────────────────────── -->
<div class="wrap">
    <div class="stats">
        <div class="stat">
            <div class="stat-num">10-yr</div>
            <div class="stat-desc">Vision to be the trusted global<br>parenting companion</div>
        </div>
        <div class="stat">
            <div class="stat-num">4 types</div>
            <div class="stat-desc">Expecting, new, working,<br>and solo parents supported</div>
        </div>
        <div class="stat">
            <div class="stat-num">$0 upfront</div>
            <div class="stat-desc">Free core journal and<br>milestone tracking always</div>
        </div>
        <div class="stat">
            <div class="stat-num">1 platform</div>
            <div class="stat-desc">Web and mobile —<br>access anywhere, anytime</div>
        </div>
    </div>
</div>

<!-- ── Features ──────────────────────────────────────────────────── -->
<section class="section" id="features">
    <div class="wrap">
        <div class="eyebrow">What you'll get</div>
        <h2 class="section-h">Everything a caregiver needs, in one place.</h2>
        <p class="section-p">From tracking your baby's first smile to finding expert-backed advice at 3am — PAGER is built for real parenting moments.</p>

        <div class="cards">
            <div class="card anim-up">
                <div class="card-num">01</div>
                <h3>Parenting Journal</h3>
                <p>Document milestones, memories, and moments. A personal timeline that evolves as your child grows.</p>
                <a class="link-arrow" href="{{ $registerUrl }}">Start journaling <span>→</span></a>
            </div>
            <div class="card anim-up">
                <div class="card-num">02</div>
                <h3>Milestone Guide</h3>
                <p>Age-by-age checklists and activity suggestions backed by early childhood development research.</p>
                <a class="link-arrow" href="{{ $registerUrl }}">View milestones <span>→</span></a>
            </div>
            <div class="card anim-up">
                <div class="card-num">03</div>
                <h3>Resource Library</h3>
                <p>Curated articles, videos, and expert tips on sleep, feeding, and wellness from pregnancy onwards.</p>
                <a class="link-arrow" href="{{ $registerUrl }}">Browse resources <span>→</span></a>
            </div>
        </div>
    </div>
</section>

<!-- ── About ──────────────────────────────────────────────────── -->
<section class="section" id="about">
    <div class="wrap">
        <div class="about-grid">
            <div class="about-text">
                <div class="eyebrow">Our mission</div>
                <h2 class="section-h">Simplify and enrich the parenting experience.</h2>
                <p>PAGER was built for the caregivers who carry the weight of love and responsibility every single day. We believe every family deserves personalized support — not generic advice.</p>
                <p>Our platform combines a smart digital journal with professional-grade guidance to help you feel capable and confident in every stage of parenthood.</p>
                <div class="about-ctas">
                    <a class="btn-solid" href="{{ $registerUrl }}">Get started free</a>
                    <a class="btn-text" href="#contact">Talk to us <span class="arrow">→</span></a>
                </div>
            </div>

            <ul class="values">
                <li class="value anim-up">
                    <span class="value-n">01</span>
                    <div class="value-body">
                        <strong>Family First</strong>
                        <span>Every feature is designed around what families actually need, not what looks good on a pitch deck.</span>
                    </div>
                </li>
                <li class="value anim-up">
                    <span class="value-n">02</span>
                    <div class="value-body">
                        <strong>Empowered Caregiving</strong>
                        <span>Informed caregivers raise confident children. We turn uncertainty into capability.</span>
                    </div>
                </li>
                <li class="value anim-up">
                    <span class="value-n">03</span>
                    <div class="value-body">
                        <strong>Accessible for All</strong>
                        <span>Every caregiver deserves support regardless of background, device, or circumstance.</span>
                    </div>
                </li>
                <li class="value anim-up">
                    <span class="value-n">04</span>
                    <div class="value-body">
                        <strong>Trust &amp; Privacy</strong>
                        <span>Families share their most intimate milestones with PAGER. We protect that completely.</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- ── Shop ──────────────────────────────────────────────────── -->
<section class="section" id="shop">
    <div class="wrap">
        <div class="eyebrow">Shop</div>
        <h2 class="section-h">Parenting resources, curated for you.</h2>
        <p class="section-p">Books, tools, and expert-recommended products to support every stage of your caregiving journey.</p>

        <div class="cards">
            <div class="card">
                <div class="card-num">Expecting</div>
                <h3>For Expecting Parents</h3>
                <p>Pregnancy journals, prenatal guides, and preparation tools for the journey ahead of you.</p>
                <a class="link-arrow" href="#">Notify me <span>→</span></a>
            </div>
            <div class="card">
                <div class="card-num">0–12 months</div>
                <h3>For New Parents</h3>
                <p>Newborn essentials, sleep aids, and guidance for navigating the precious first year.</p>
                <a class="link-arrow" href="#">Notify me <span>→</span></a>
            </div>
            <div class="card">
                <div class="card-num">Growing up</div>
                <h3>For Growing Families</h3>
                <p>Development tools, activity kits, and expert resources as your child continues to grow.</p>
                <a class="link-arrow" href="#">Notify me <span>→</span></a>
            </div>
        </div>
    </div>
</section>

<!-- ── CTA ──────────────────────────────────────────────────── -->
<section class="cta-band" id="contact">
    <div class="wrap">
        <div class="cta-inner">
            <h2>Ready to start your parenting journey with <span>confidence?</span></h2>
            <a class="btn-solid" href="{{ $registerUrl }}">
                Create a free account
                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- ── Footer ──────────────────────────────────────────────────── -->
<footer class="site-footer">
    <div class="wrap footer-inner">
        <div class="footer-logo">
            <span class="logo-dot"></span>
            PAGER
        </div>

        <ul class="footer-links">
            <li><a href="#about">About</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#shop">Shop</a></li>
            <li><a href="#contact">Contact</a></li>
            @auth
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @else
                <li><a href="{{ $loginUrl }}">Log in</a></li>
            @endauth
        </ul>

        <p class="footer-copy">© {{ date('Y') }} PAGER. All rights reserved.</p>
    </div>
</footer>

<script>
(() => {
    /* ─────────────────────────────────────────────────────────
       1. HERO ENTRANCE — staggered timeline on page load
    ───────────────────────────────────────────────────────── */
    const heroTl = anime.timeline({ easing: 'easeOutExpo' });

    heroTl
        .add({
            targets: '.hero-label',
            opacity: [0, 1],
            translateY: [-16, 0],
            duration: 600
        })
        .add({
            targets: '.hero h1',
            opacity: [0, 1],
            translateY: [32, 0],
            duration: 800
        }, '-=300')
        .add({
            targets: '.hero-sub',
            opacity: [0, 1],
            translateY: [20, 0],
            duration: 700
        }, '-=400')
        .add({
            targets: '.hero-actions',
            opacity: [0, 1],
            translateY: [16, 0],
            duration: 600
        }, '-=400');

    /* ─────────────────────────────────────────────────────────
       2. TICKER — continuous loop using setInterval (W3Schools
          frame technique) to move the track left indefinitely
    ───────────────────────────────────────────────────────── */
    const track = document.getElementById('tickerTrack');
    if (track) {
        /* Duplicate content so the seam is invisible */
        track.innerHTML += track.innerHTML;
        const fullWidth = track.scrollWidth / 2;
        let pos = 0;
        const speed = 0.5; /* px per frame — tune for desired pace */

        function tickerFrame() {
            pos -= speed;
            if (pos <= -fullWidth) pos = 0;
            track.style.transform = 'translateX(' + pos + 'px)';
            requestAnimationFrame(tickerFrame);
        }
        requestAnimationFrame(tickerFrame);
    }

    /* ─────────────────────────────────────────────────────────
       3. SCROLL-TRIGGERED ANIMATIONS — anime.js + IntersectionObserver
          Cards, values, stats and section headers fade + slide up
          with a stagger when they enter the viewport
    ───────────────────────────────────────────────────────── */
    const seen = new WeakSet();

    const scrollObs = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting || seen.has(entry.target)) return;
            seen.add(entry.target);
            scrollObs.unobserve(entry.target);

            const el = entry.target;

            /* Groups — animate all children together with stagger */
            if (el.classList.contains('cards') || el.classList.contains('stats')) {
                anime({
                    targets: el.querySelectorAll('.anim-up, .stat'),
                    opacity: [0, 1],
                    translateY: [28, 0],
                    duration: 700,
                    easing: 'easeOutExpo',
                    delay: anime.stagger(90)
                });
                return;
            }

            if (el.classList.contains('values')) {
                anime({
                    targets: el.querySelectorAll('.anim-up'),
                    opacity: [0, 1],
                    translateX: [-20, 0],
                    duration: 600,
                    easing: 'easeOutExpo',
                    delay: anime.stagger(80)
                });
                return;
            }

            /* Section headings */
            if (el.classList.contains('section-h') || el.classList.contains('eyebrow')) {
                anime({
                    targets: el,
                    opacity: [0, 1],
                    translateY: [18, 0],
                    duration: 650,
                    easing: 'easeOutExpo'
                });
                return;
            }

            /* Generic .anim-up elements */
            anime({
                targets: el,
                opacity: [0, 1],
                translateY: [24, 0],
                duration: 650,
                easing: 'easeOutExpo'
            });
        });
    }, { threshold: 0.1 });

    /* Observe containers so stagger fires all children at once */
    document.querySelectorAll('.cards, .values, .stats').forEach(el => scrollObs.observe(el));
    /* Observe individual headings */
    document.querySelectorAll('.section-h, .eyebrow, .section-p, .about-ctas, .cta-inner').forEach(el => {
        el.style.opacity = '0';
        scrollObs.observe(el);
    });

    /* ─────────────────────────────────────────────────────────
       4. STAT NUMBERS — count-up using anime's number tweening
          Fires once when the stats bar scrolls into view
    ───────────────────────────────────────────────────────── */
    const statData = [
        { el: null, from: 0, to: 10, suffix: '-yr' },
        { el: null, from: 0, to: 4,  suffix: ' types' },
        { el: null, from: 0, to: 0,  prefix: '$', suffix: ' upfront' },
        { el: null, from: 0, to: 1,  suffix: ' platform' },
    ];

    document.querySelectorAll('.stat-num').forEach((el, i) => {
        if (statData[i]) statData[i].el = el;
    });

    const statsSection = document.querySelector('.stats');
    if (statsSection) {
        const countObs = new IntersectionObserver(entries => {
            if (!entries[0].isIntersecting) return;
            countObs.disconnect();

            statData.forEach(({ el, from, to, prefix = '', suffix = '' }) => {
                if (!el || to === 0) return;
                const obj = { val: from };
                anime({
                    targets: obj,
                    val: to,
                    round: 1,
                    duration: 1400,
                    easing: 'easeOutExpo',
                    update() {
                        el.textContent = prefix + obj.val + suffix;
                    }
                });
            });
        }, { threshold: 0.5 });
        countObs.observe(statsSection);
    }

    /* ─────────────────────────────────────────────────────────
       5. MOBILE NAV TOGGLE
    ───────────────────────────────────────────────────────── */
    const menuBtn   = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const iconMenu   = document.getElementById('iconMenu');
    const iconClose  = document.getElementById('iconClose');

    menuBtn.addEventListener('click', () => {
        const open = mobileMenu.classList.toggle('open');
        menuBtn.setAttribute('aria-expanded', open);
        iconMenu.style.display  = open ? 'none'  : 'block';
        iconClose.style.display = open ? 'block' : 'none';

        if (open) {
            anime({
                targets: mobileMenu.querySelectorAll('a'),
                opacity: [0, 1],
                translateX: [-12, 0],
                duration: 300,
                easing: 'easeOutExpo',
                delay: anime.stagger(40)
            });
        }
    });

    mobileMenu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
            menuBtn.setAttribute('aria-expanded', 'false');
            iconMenu.style.display  = 'block';
            iconClose.style.display = 'none';
        });
    });

    /* ─────────────────────────────────────────────────────────
       6. SMOOTH SCROLL with nav offset
    ───────────────────────────────────────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (!target) return;
            e.preventDefault();
            const top = target.getBoundingClientRect().top + window.scrollY - 68;
            window.scrollTo({ top, behavior: 'smooth' });
        });
    });

    /* ─────────────────────────────────────────────────────────
       7. NAV SCROLL SHADOW — subtle depth when page scrolled
    ───────────────────────────────────────────────────────── */
    const nav = document.querySelector('.site-nav');
    window.addEventListener('scroll', () => {
        nav.style.boxShadow = window.scrollY > 10
            ? '0 1px 16px rgba(0,0,0,0.06)'
            : 'none';
    }, { passive: true });

})();
</script>

</body>
</html>
