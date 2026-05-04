<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAGER — The Parenting Manager</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.2/lib/anime.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }

        :root {
            --white:      #ffffff;
            --ink:        #0f0e17;
            --sub:        #6b7280;
            --border:     #e5e7eb;
            --purple:     #7c3aed;
            --purple-dim: #6d28d9;
            --purple-bg:  #f5f3ff;
            --purple-mid: #ede9fe;
            --purple-glow: rgba(124,58,237,0.18);
        }

        body {
            font-family: "Inter", system-ui, sans-serif;
            background: var(--white);
            color: var(--ink);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a { color: inherit; text-decoration: none; }

        /* ── Scroll progress ── */
        #scroll-progress {
            position: fixed;
            top: 0; left: 0;
            height: 2.5px;
            background: linear-gradient(90deg, #7c3aed, #a78bfa, #7c3aed);
            background-size: 200% 100%;
            z-index: 9999;
            width: 0%;
            transition: width 0.1s linear;
            animation: gradientShift 2s linear infinite;
        }

        @keyframes gradientShift {
            0%   { background-position: 0% 0%; }
            100% { background-position: 200% 0%; }
        }

        /* ── Background orbs ── */
        .bg-orbs {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.12;
        }

        .orb-1 {
            width: 600px; height: 600px;
            background: #7c3aed;
            top: -200px; right: -100px;
            animation: floatOrb 12s ease-in-out infinite;
        }

        .orb-2 {
            width: 400px; height: 400px;
            background: #a78bfa;
            bottom: 20%; left: -100px;
            animation: floatOrb 16s ease-in-out infinite reverse;
        }

        .orb-3 {
            width: 300px; height: 300px;
            background: #7c3aed;
            top: 60%; right: 10%;
            animation: floatOrb 10s ease-in-out infinite 4s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(30px, -30px) scale(1.05); }
            66%       { transform: translate(-20px, 20px) scale(0.97); }
        }

        /* ── Grid dot pattern ── */
        .dot-grid {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image: radial-gradient(circle, #7c3aed22 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.4;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black, transparent);
        }

        /* ── Layout ── */
        .wrap {
            width: min(1100px, 88vw);
            margin-inline: auto;
            position: relative;
            z-index: 1;
        }

        /* ── Nav ── */
        .site-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(229,231,235,0.8);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 62px;
            gap: 2rem;
        }

        .nav-logo {
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .nav-logo img {
            height: 34px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover img { transform: rotate(-8deg) scale(1.1); }

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

        .nav-links a:hover { color: var(--ink); background: var(--purple-bg); }

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

        .btn-nav-ghost:hover { color: var(--ink); border-color: #d1d5db; background: #f9fafb; }

        .btn-nav-solid {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--white);
            background: var(--purple);
            padding: 0.4rem 0.875rem;
            border-radius: 6px;
            border: 1px solid transparent;
            transition: background 0.15s, box-shadow 0.2s;
            box-shadow: 0 0 0 0 rgba(124,58,237,0);
        }

        .btn-nav-solid:hover {
            background: var(--purple-dim);
            box-shadow: 0 0 16px rgba(124,58,237,0.35);
        }

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

        /* ── Hero ── */
        .hero {
            padding: 6rem 0 5rem;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 2rem;
            opacity: 0;
        }

        .hero-label-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--purple);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 0 rgba(124,58,237,0.6); }
            50%       { box-shadow: 0 0 0 6px rgba(124,58,237,0); }
        }

        .hero h1 {
            font-size: clamp(2.6rem, 5.5vw, 4.25rem);
            font-weight: 800;
            line-height: 1.06;
            letter-spacing: -0.04em;
            color: var(--ink);
            max-width: 17ch;
            margin-bottom: 1.75rem;
            overflow: hidden;
        }

        .word { display: inline-block; overflow: hidden; }
        .word-inner { display: inline-block; transform: translateY(110%); }

        .hero h1 .highlight { color: var(--purple); position: relative; }

        .hero h1 .highlight::after {
            content: '';
            position: absolute;
            bottom: 2px; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--purple), #a78bfa);
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.6s ease;
        }

        .hero-sub {
            font-size: 1.0625rem;
            color: var(--sub);
            max-width: 50ch;
            line-height: 1.75;
            margin-bottom: 2.75rem;
            opacity: 0;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            opacity: 0;
        }

        .btn-solid {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.9375rem;
            font-weight: 700;
            color: var(--white);
            background: var(--purple);
            padding: 0.75rem 1.625rem;
            border-radius: 8px;
            border: 1px solid transparent;
            transition: background 0.15s, transform 0.15s, box-shadow 0.25s;
            position: relative;
            overflow: hidden;
        }

        .btn-solid::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .btn-solid:hover {
            background: var(--purple-dim);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(124,58,237,0.4);
        }

        .btn-solid:hover::before { opacity: 1; }

        .btn-solid-pulse {
            animation: glow-pulse 3s ease-in-out infinite;
        }

        @keyframes glow-pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(124,58,237,0); }
            50%       { box-shadow: 0 0 20px 4px rgba(124,58,237,0.3); }
        }

        .btn-text {
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--sub);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: color 0.15s, gap 0.15s;
        }

        .btn-text:hover { color: var(--ink); gap: 0.6rem; }

        .arrow { transition: transform 0.15s; }
        .btn-text:hover .arrow { transform: translateX(3px); }

        /* ── Ticker ── */
        .ticker-wrap {
            overflow: hidden;
            border-top: 1px solid var(--border);
            margin-top: 3.5rem;
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
            letter-spacing: 0.08em;
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
        }

        /* ── Stats ── */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        .stat {
            padding: 2.5rem 0;
            padding-right: 2rem;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            transition: background 0.2s;
        }

        .stat:hover { background: var(--purple-bg); }
        .stat:first-child { padding-left: 0; }
        .stat:last-child { border-right: none; padding-right: 0; padding-left: 2rem; }
        .stat:nth-child(2), .stat:nth-child(3) { padding-left: 2rem; }

        .stat-num {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--purple);
            margin-bottom: 0.35rem;
            font-variant-numeric: tabular-nums;
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
                padding: 1.5rem 0; padding-right: 0; padding-left: 0; border-right: none;
            }
        }

        /* ── Sections ── */
        .section {
            padding: 5.5rem 0;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .eyebrow {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .eyebrow::before {
            content: "";
            width: 20px; height: 1.5px;
            background: var(--purple);
        }

        .section-h {
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.035em;
            line-height: 1.12;
            color: var(--ink);
            max-width: 22ch;
            margin-bottom: 1rem;
        }

        .section-p {
            font-size: 1rem;
            color: var(--sub);
            max-width: 54ch;
            line-height: 1.75;
            margin-bottom: 3.5rem;
        }

        /* ── Feature cards ── */
        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        @media (max-width: 780px) { .cards { grid-template-columns: 1fr; } }

        .card {
            padding: 2.25rem 2rem;
            border-right: 1px solid var(--border);
            transition: background 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--purple), #a78bfa);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s ease;
        }

        .card:hover::before { transform: scaleX(1); }
        .card:last-child { border-right: none; }
        .card:hover { background: var(--purple-bg); box-shadow: inset 0 0 40px rgba(124,58,237,0.04); }

        @media (max-width: 780px) {
            .card { border-right: none; border-bottom: 1px solid var(--border); }
            .card:last-child { border-bottom: none; }
        }

        .card-num {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 1.25rem;
            opacity: 0.7;
        }

        .card h3 {
            font-size: 1.075rem;
            font-weight: 700;
            letter-spacing: -0.02em;
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
            gap: 0.3rem;
            transition: gap 0.18s;
        }

        .link-arrow:hover { gap: 0.55rem; }

        /* ── About ── */
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
            line-height: 1.8;
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
            border-radius: 12px;
            overflow: hidden;
        }

        .value {
            display: flex;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            transition: background 0.15s, transform 0.15s;
        }

        .value:last-child { border-bottom: none; }
        .value:hover { background: var(--purple-bg); }

        .value-n {
            font-size: 0.72rem;
            font-weight: 800;
            color: var(--purple);
            min-width: 1.5rem;
            padding-top: 2px;
        }

        .value-body strong {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.2rem;
        }

        .value-body span {
            font-size: 0.855rem;
            color: var(--sub);
            line-height: 1.55;
        }

        /* ── CTA Band ── */
        .cta-band { padding: 5.5rem 0; }

        .cta-inner {
            border: 1px solid var(--purple-mid);
            border-radius: 16px;
            padding: 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
            background: linear-gradient(135deg, var(--purple-bg), rgba(245,243,255,0.4));
            position: relative;
            overflow: hidden;
        }

        .cta-inner::before {
            content: '';
            position: absolute;
            top: -50%; right: -50%;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(124,58,237,0.08), transparent 70%);
            pointer-events: none;
        }

        .cta-inner h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--ink);
            max-width: 30ch;
            line-height: 1.2;
        }

        .cta-inner h2 span { color: var(--purple); }

        /* ── Footer ── */
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
            font-weight: 800;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-logo img { height: 22px; width: auto; }

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

        .footer-copy { font-size: 0.8125rem; color: #9ca3af; }

        @media (max-width: 640px) {
            .footer-inner { flex-direction: column; align-items: flex-start; }
            .cta-inner { padding: 2.25rem 1.5rem; }
            .hero { padding: 3.5rem 0 3rem; }
            .section { padding: 3.5rem 0; }
            .cta-band { padding: 3.5rem 0; }
        }

        /* ── Anim starters ── */
        .anim-up  { opacity: 0; transform: translateY(28px); }
        .anim-left{ opacity: 0; transform: translateX(-24px); }
    </style>
</head>
<body>

<div id="scroll-progress"></div>
<div class="bg-orbs" aria-hidden="true">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>
<div class="dot-grid" aria-hidden="true"></div>

@php
    $loginUrl    = Route::has('login')    ? route('login')    : url('/login');
    $registerUrl = Route::has('register') ? route('register') : url('/register');
@endphp

<!-- Nav -->
<header class="site-nav" id="siteNav">
    <div class="wrap nav-inner">
        <a class="nav-logo" href="/">
            <img src="{{ asset('logo.png') }}" alt="Pager Logo">
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

<!-- Hero -->
<section class="hero" id="hero">
    <div class="wrap">
        <div class="hero-label">
            <span class="hero-label-dot"></span>
            The Parenting Manager
        </div>

        <h1 id="heroHeading">We support caregivers.<br>Because parenting<br>is <span class="highlight">hard.</span></h1>

        <p class="hero-sub">
            PAGER is an all-in-one caregiving platform — a personalized journal,
            milestone guide, and resource library that grows alongside your family.
        </p>

        <div class="hero-actions">
            <a class="btn-solid btn-solid-pulse" href="{{ $registerUrl }}">
                Get started free
                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a class="btn-text" href="#features">
                See what's included
                <svg class="arrow" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

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

<!-- Stats -->
<div class="wrap">
    <div class="stats" id="statsBar">
        <div class="stat">
            <div class="stat-num" data-to="10" data-suffix="-yr">0</div>
            <div class="stat-desc">Vision to be the trusted global<br>parenting companion</div>
        </div>
        <div class="stat">
            <div class="stat-num" data-to="4" data-suffix=" types">0</div>
            <div class="stat-desc">Expecting, new, working,<br>and solo parents supported</div>
        </div>
        <div class="stat">
            <div class="stat-num">$0 upfront</div>
            <div class="stat-desc">Free core journal and<br>milestone tracking always</div>
        </div>
        <div class="stat">
            <div class="stat-num" data-to="1" data-suffix=" platform">0</div>
            <div class="stat-desc">Web and mobile —<br>access anywhere, anytime</div>
        </div>
    </div>
</div>

<!-- Features -->
<section class="section" id="features">
    <div class="wrap">
        <div class="eyebrow anim-up">What you'll get</div>
        <h2 class="section-h anim-up">Everything a caregiver needs, in one place.</h2>
        <p class="section-p anim-up">From tracking your baby's first smile to finding expert-backed advice at 3am — PAGER is built for real parenting moments.</p>

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

<!-- About -->
<section class="section" id="about">
    <div class="wrap">
        <div class="about-grid">
            <div class="about-text">
                <div class="eyebrow anim-up">Our mission</div>
                <h2 class="section-h anim-up">Simplify and enrich the parenting experience.</h2>
                <p class="anim-up">PAGER was built for the caregivers who carry the weight of love and responsibility every single day. We believe every family deserves personalized support — not generic advice.</p>
                <p class="anim-up">Our platform combines a smart digital journal with professional-grade guidance to help you feel capable and confident in every stage of parenthood.</p>
                <div class="about-ctas anim-up">
                    <a class="btn-solid" href="{{ $registerUrl }}">Get started free</a>
                    <a class="btn-text" href="#contact">Talk to us <span class="arrow">→</span></a>
                </div>
            </div>

            <ul class="values">
                <li class="value anim-left">
                    <span class="value-n">01</span>
                    <div class="value-body">
                        <strong>Family First</strong>
                        <span>Every feature is designed around what families actually need, not what looks good on a pitch deck.</span>
                    </div>
                </li>
                <li class="value anim-left">
                    <span class="value-n">02</span>
                    <div class="value-body">
                        <strong>Empowered Caregiving</strong>
                        <span>Informed caregivers raise confident children. We turn uncertainty into capability.</span>
                    </div>
                </li>
                <li class="value anim-left">
                    <span class="value-n">03</span>
                    <div class="value-body">
                        <strong>Accessible for All</strong>
                        <span>Every caregiver deserves support regardless of background, device, or circumstance.</span>
                    </div>
                </li>
                <li class="value anim-left">
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

<!-- Shop -->
<section class="section" id="shop">
    <div class="wrap">
        <div class="eyebrow anim-up">Shop</div>
        <h2 class="section-h anim-up">Parenting resources, curated for you.</h2>
        <p class="section-p anim-up">Books, tools, and expert-recommended products to support every stage of your caregiving journey.</p>

        <div class="cards">
            <div class="card anim-up">
                <div class="card-num">Expecting</div>
                <h3>For Expecting Parents</h3>
                <p>Pregnancy journals, prenatal guides, and preparation tools for the journey ahead of you.</p>
                <a class="link-arrow" href="#">Notify me <span>→</span></a>
            </div>
            <div class="card anim-up">
                <div class="card-num">0–12 months</div>
                <h3>For New Parents</h3>
                <p>Newborn essentials, sleep aids, and guidance for navigating the precious first year.</p>
                <a class="link-arrow" href="#">Notify me <span>→</span></a>
            </div>
            <div class="card anim-up">
                <div class="card-num">Growing up</div>
                <h3>For Growing Families</h3>
                <p>Development tools, activity kits, and expert resources as your child continues to grow.</p>
                <a class="link-arrow" href="#">Notify me <span>→</span></a>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-band" id="contact">
    <div class="wrap">
        <div class="cta-inner anim-up">
            <h2>Ready to start your parenting journey with <span>confidence?</span></h2>
            <a class="btn-solid btn-solid-pulse" href="{{ $registerUrl }}">
                Create a free account
                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="site-footer">
    <div class="wrap footer-inner">
        <div class="footer-logo">
            <img src="{{ asset('logo.png') }}" alt="Pager">
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
    /* ── 1. Scroll progress bar ── */
    const prog = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
        const pct = window.scrollY / (document.body.scrollHeight - window.innerHeight) * 100;
        prog.style.width = Math.min(pct, 100) + '%';
    }, { passive: true });

    /* ── 2. Nav shadow on scroll ── */
    const nav = document.querySelector('.site-nav');
    window.addEventListener('scroll', () => {
        nav.style.boxShadow = window.scrollY > 10 ? '0 1px 20px rgba(0,0,0,0.07)' : 'none';
    }, { passive: true });

    /* ── 3. Hero split-word entrance ── */
    const heading = document.getElementById('heroHeading');
    if (heading) {
        const html = heading.innerHTML;
        const wrapped = html.replace(/(\b\w+\b)/g, '<span class="word"><span class="word-inner">$1</span></span>');
        heading.innerHTML = wrapped;

        anime.timeline({ easing: 'easeOutExpo' })
            .add({
                targets: '.hero-label',
                opacity: [0, 1],
                translateY: [-12, 0],
                duration: 600
            })
            .add({
                targets: '.word-inner',
                translateY: ['110%', '0%'],
                opacity: [0, 1],
                duration: 900,
                delay: anime.stagger(60, { from: 'first' }),
                easing: 'easeOutExpo'
            }, '-=200')
            .add({
                targets: '.hero-sub',
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 700
            }, '-=500')
            .add({
                targets: '.hero-actions',
                opacity: [0, 1],
                translateY: [16, 0],
                duration: 600
            }, '-=450')
            .add({
                targets: '.hero h1 .highlight::after',
                scaleX: [0, 1],
                duration: 600,
                easing: 'easeOutQuart'
            }, '-=100');
    }

    /* ── 4. Ticker ── */
    const track = document.getElementById('tickerTrack');
    if (track) {
        track.innerHTML += track.innerHTML;
        const fullWidth = track.scrollWidth / 2;
        let pos = 0;
        function tick() {
            pos -= 0.55;
            if (pos <= -fullWidth) pos = 0;
            track.style.transform = 'translateX(' + pos + 'px)';
            requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    /* ── 5. Scroll-triggered IntersectionObserver ── */
    const seen = new WeakSet();
    const obs = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting || seen.has(entry.target)) return;
            seen.add(entry.target);
            obs.unobserve(entry.target);
            const el = entry.target;

            if (el.classList.contains('anim-up')) {
                anime({ targets: el, opacity: [0,1], translateY: [28,0], duration: 750, easing: 'easeOutExpo' });
            } else if (el.classList.contains('anim-left')) {
                anime({ targets: el, opacity: [0,1], translateX: [-24,0], duration: 700, easing: 'easeOutExpo' });
            } else if (el.classList.contains('cards')) {
                anime({ targets: el.querySelectorAll('.card'), opacity:[0,1], translateY:[30,0], duration:700, easing:'easeOutExpo', delay: anime.stagger(100) });
            } else if (el.classList.contains('values')) {
                anime({ targets: el.querySelectorAll('.value'), opacity:[0,1], translateX:[-20,0], duration:650, easing:'easeOutExpo', delay: anime.stagger(80) });
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.anim-up, .anim-left').forEach(el => obs.observe(el));
    document.querySelectorAll('.cards, .values').forEach(el => obs.observe(el));

    /* ── 6. Stats count-up ── */
    const statsSection = document.getElementById('statsBar');
    if (statsSection) {
        const countObs = new IntersectionObserver(entries => {
            if (!entries[0].isIntersecting) return;
            countObs.disconnect();
            document.querySelectorAll('.stat-num[data-to]').forEach(el => {
                const to = +el.dataset.to;
                const suffix = el.dataset.suffix || '';
                const obj = { val: 0 };
                anime({ targets: obj, val: to, round: 1, duration: 1600, easing: 'easeOutExpo',
                    update() { el.textContent = obj.val + suffix; }
                });
            });
        }, { threshold: 0.5 });
        countObs.observe(statsSection);
    }

    /* ── 7. Card 3D tilt ── */
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            card.style.transform = `perspective(600px) rotateY(${x * 6}deg) rotateX(${-y * 6}deg)`;
        });
        card.addEventListener('mouseleave', () => {
            anime({ targets: card, rotateX: 0, rotateY: 0, duration: 400, easing: 'easeOutExpo' });
        });
    });

    /* ── 8. Mobile nav ── */
    const menuBtn    = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const iconMenu   = document.getElementById('iconMenu');
    const iconClose  = document.getElementById('iconClose');

    menuBtn.addEventListener('click', () => {
        const open = mobileMenu.classList.toggle('open');
        menuBtn.setAttribute('aria-expanded', open);
        iconMenu.style.display  = open ? 'none'  : 'block';
        iconClose.style.display = open ? 'block' : 'none';
        if (open) {
            anime({ targets: mobileMenu.querySelectorAll('a'), opacity:[0,1], translateX:[-12,0], duration:300, easing:'easeOutExpo', delay: anime.stagger(40) });
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

    /* ── 9. Smooth scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (!target) return;
            e.preventDefault();
            window.scrollTo({ top: target.getBoundingClientRect().top + scrollY - 70, behavior: 'smooth' });
        });
    });
})();
</script>
</body>
</html>
