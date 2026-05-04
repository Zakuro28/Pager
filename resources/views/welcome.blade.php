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
            --green:      #059669;
            --green-bg:   #ecfdf5;
            --blue:       #2563eb;
            --blue-bg:    #eff6ff;
            --amber:      #d97706;
            --amber-bg:   #fffbeb;
            --pink:       #db2777;
            --pink-bg:    #fdf2f8;
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
            position: fixed; top: 0; left: 0;
            height: 2.5px;
            background: linear-gradient(90deg, #7c3aed, #a78bfa, #7c3aed);
            background-size: 200% 100%;
            z-index: 9999; width: 0%;
            animation: gradientShift 2s linear infinite;
        }
        @keyframes gradientShift { 0% { background-position: 0%; } 100% { background-position: 200%; } }

        /* ── Background ── */
        .bg-orbs { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.1; }
        .orb-1 { width: 600px; height: 600px; background: #7c3aed; top: -200px; right: -100px; animation: floatOrb 12s ease-in-out infinite; }
        .orb-2 { width: 400px; height: 400px; background: #a78bfa; bottom: 20%; left: -100px; animation: floatOrb 16s ease-in-out infinite reverse; }
        .orb-3 { width: 300px; height: 300px; background: #7c3aed; top: 60%; right: 10%; animation: floatOrb 10s ease-in-out infinite 4s; }
        @keyframes floatOrb { 0%,100% { transform: translate(0,0) scale(1); } 33% { transform: translate(30px,-30px) scale(1.05); } 66% { transform: translate(-20px,20px) scale(0.97); } }

        .dot-grid {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image: radial-gradient(circle, #7c3aed22 1px, transparent 1px);
            background-size: 32px 32px; opacity: 0.35;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black, transparent);
        }

        /* ── Layout ── */
        .wrap { width: min(1100px, 88vw); margin-inline: auto; position: relative; z-index: 1; }

        /* ── Nav ── */
        .site-nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(229,231,235,0.8);
        }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; height: 62px; gap: 2rem; }
        .nav-logo { font-size: 1rem; font-weight: 800; letter-spacing: -0.03em; color: var(--ink); display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }
        .nav-logo img { height: 34px; width: auto; transition: transform 0.3s; }
        .nav-logo:hover img { transform: rotate(-8deg) scale(1.1); }
        .nav-links { display: flex; list-style: none; gap: 0.25rem; }
        .nav-links a { font-size: 0.875rem; font-weight: 500; color: var(--sub); padding: 0.375rem 0.75rem; border-radius: 6px; transition: color 0.15s, background 0.15s; }
        .nav-links a:hover { color: var(--ink); background: var(--purple-bg); }
        .nav-actions { display: flex; align-items: center; gap: 0.625rem; flex-shrink: 0; }
        .btn-nav-ghost { font-size: 0.875rem; font-weight: 500; color: var(--sub); padding: 0.4rem 0.875rem; border: 1px solid var(--border); border-radius: 6px; transition: all 0.15s; }
        .btn-nav-ghost:hover { color: var(--ink); border-color: #d1d5db; background: #f9fafb; }
        .btn-nav-solid { font-size: 0.875rem; font-weight: 600; color: var(--white); background: var(--purple); padding: 0.4rem 0.875rem; border-radius: 6px; transition: background 0.15s, box-shadow 0.2s; }
        .btn-nav-solid:hover { background: var(--purple-dim); box-shadow: 0 0 16px rgba(124,58,237,0.35); }
        .nav-hamburger { display: none; background: none; border: none; cursor: pointer; padding: 0.25rem; color: var(--ink); }
        .nav-mobile { display: none; border-top: 1px solid var(--border); padding: 1rem 0; }
        .nav-mobile.open { display: block; }
        .nav-mobile a { display: block; font-size: 0.9rem; font-weight: 500; color: var(--sub); padding: 0.6rem 0; border-bottom: 1px solid var(--border); }
        .nav-mobile a:last-child { border-bottom: none; }
        .nav-mobile a:hover { color: var(--ink); }
        @media (max-width: 680px) { .nav-links, .nav-actions { display: none; } .nav-hamburger { display: flex; } }

        /* ── Buttons ── */
        .btn-solid {
            display: inline-flex; align-items: center; gap: 0.45rem;
            font-size: 0.9375rem; font-weight: 700; color: var(--white);
            background: var(--purple); padding: 0.75rem 1.625rem;
            border-radius: 8px; transition: background 0.15s, transform 0.15s, box-shadow 0.25s;
            position: relative; overflow: hidden;
        }
        .btn-solid:hover { background: var(--purple-dim); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(124,58,237,0.35); }
        .btn-solid-pulse { animation: glow-pulse 3s ease-in-out infinite; }
        @keyframes glow-pulse { 0%,100% { box-shadow: 0 0 0 0 rgba(124,58,237,0); } 50% { box-shadow: 0 0 20px 4px rgba(124,58,237,0.25); } }
        .btn-text { font-size: 0.9375rem; font-weight: 500; color: var(--sub); display: inline-flex; align-items: center; gap: 0.35rem; transition: color 0.15s, gap 0.15s; }
        .btn-text:hover { color: var(--ink); gap: 0.6rem; }

        /* ── Hero ── */
        .hero { padding: 6rem 0 5rem; border-bottom: 1px solid var(--border); position: relative; }
        .hero-label { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--purple); margin-bottom: 2rem; opacity: 0; }
        .hero-label-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--purple); animation: pulse-dot 2s ease-in-out infinite; }
        @keyframes pulse-dot { 0%,100% { box-shadow: 0 0 0 0 rgba(124,58,237,0.6); } 50% { box-shadow: 0 0 0 6px rgba(124,58,237,0); } }
        .hero h1 { font-size: clamp(2.6rem, 5.5vw, 4.25rem); font-weight: 800; line-height: 1.06; letter-spacing: -0.04em; color: var(--ink); max-width: 18ch; margin-bottom: 1.75rem; opacity: 0; }
        .hero h1 .highlight { color: var(--purple); }
        .hero-sub { font-size: 1.0625rem; color: var(--sub); max-width: 52ch; line-height: 1.75; margin-bottom: 2.75rem; opacity: 0; }
        .hero-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; opacity: 0; }
        .hero-chips { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 2.5rem; opacity: 0; }
        .hero-chip { display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.775rem; font-weight: 600; color: var(--sub); background: #f9fafb; border: 1px solid var(--border); border-radius: 999px; padding: 0.3rem 0.75rem; }

        /* ── Ticker ── */
        .ticker-wrap { overflow: hidden; border-top: 1px solid var(--border); margin-top: 3.5rem; padding: 0.9rem 0; mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent); -webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent); }
        .ticker-track { display: flex; white-space: nowrap; will-change: transform; }
        .ticker-item { font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--sub); padding: 0 1.75rem; flex-shrink: 0; }
        .ticker-sep { color: var(--purple); font-size: 0.78rem; flex-shrink: 0; padding: 0 0.25rem; }

        /* ── Stats ── */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); }
        .stat { padding: 2.5rem 0; padding-right: 2rem; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); transition: background 0.2s; }
        .stat:hover { background: var(--purple-bg); }
        .stat:first-child { padding-left: 0; }
        .stat:last-child { border-right: none; padding-right: 0; padding-left: 2rem; }
        .stat:nth-child(2), .stat:nth-child(3) { padding-left: 2rem; }
        .stat-num { font-size: 2rem; font-weight: 800; letter-spacing: -0.04em; color: var(--purple); margin-bottom: 0.35rem; font-variant-numeric: tabular-nums; }
        .stat-desc { font-size: 0.875rem; color: var(--sub); line-height: 1.5; }
        @media (max-width: 700px) {
            .stats { grid-template-columns: 1fr 1fr; }
            .stat:nth-child(2) { border-right: none; }
            .stat:nth-child(3) { border-right: 1px solid var(--border); padding-left: 0; }
            .stat:last-child { padding-left: 0; }
            .stat { padding: 1.75rem 0; padding-right: 1.5rem; }
            .stat:nth-child(2n) { padding-right: 0; padding-left: 1.5rem; }
        }

        /* ── Section base ── */
        .section { padding: 5.5rem 0; border-bottom: 1px solid var(--border); position: relative; }
        .eyebrow { font-size: 0.8rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--purple); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; }
        .eyebrow::before { content: ""; width: 20px; height: 1.5px; background: var(--purple); }
        .section-h { font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; letter-spacing: -0.035em; line-height: 1.12; color: var(--ink); max-width: 24ch; margin-bottom: 1rem; }
        .section-p { font-size: 1rem; color: var(--sub); max-width: 56ch; line-height: 1.75; margin-bottom: 3.5rem; }

        /* ── 5 Features grid ── */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }
        .features-grid .feat-wide { grid-column: span 2; }
        @media (max-width: 900px) { .features-grid { grid-template-columns: 1fr 1fr; } .features-grid .feat-wide { grid-column: span 1; } }
        @media (max-width: 580px) { .features-grid { grid-template-columns: 1fr; } }

        .feat-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 2rem;
            background: var(--white);
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
            cursor: default;
        }
        .feat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--accent, var(--purple));
            transform: scaleX(0); transform-origin: left; transition: transform 0.35s;
        }
        .feat-card:hover::before { transform: scaleX(1); }
        .feat-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.07); transform: translateY(-2px); }

        .feat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: grid; place-items: center;
            font-size: 1.4rem; margin-bottom: 1.25rem;
            background: var(--icon-bg, var(--purple-bg));
        }
        .feat-num { font-size: 0.68rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: var(--accent, var(--purple)); margin-bottom: 0.5rem; opacity: 0.8; }
        .feat-card h3 { font-size: 1.075rem; font-weight: 800; letter-spacing: -0.02em; color: var(--ink); margin-bottom: 0.625rem; }
        .feat-card p { font-size: 0.875rem; color: var(--sub); line-height: 1.65; margin-bottom: 1.25rem; }
        .feat-tags { display: flex; flex-wrap: wrap; gap: 0.375rem; }
        .feat-tag { font-size: 0.7rem; font-weight: 600; padding: 0.2rem 0.55rem; border-radius: 999px; background: var(--icon-bg, var(--purple-bg)); color: var(--accent, var(--purple)); border: 1px solid var(--border); }
        .feat-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.55rem; border-radius: 999px; background: var(--green-bg); color: var(--green); border: 1px solid #a7f3d0; margin-bottom: 0.5rem; }
        .feat-badge-soon { background: var(--amber-bg); color: var(--amber); border-color: #fde68a; }

        /* ── How it works ── */
        .flow-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            position: relative;
        }
        @media (max-width: 860px) { .flow-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 480px) { .flow-grid { grid-template-columns: 1fr; } }

        .flow-step {
            padding: 2rem 1.5rem 2rem 0;
            border-right: 1px solid var(--border);
            position: relative;
        }
        .flow-step:last-child { border-right: none; }
        .flow-step + .flow-step { padding-left: 1.5rem; }

        @media (max-width: 860px) {
            .flow-step { border-right: none; border-bottom: 1px solid var(--border); padding: 1.5rem 0; }
            .flow-step:last-child { border-bottom: none; }
            .flow-step + .flow-step { padding-left: 0; }
        }

        .flow-num {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--purple-bg); color: var(--purple);
            font-size: 0.825rem; font-weight: 800;
            display: grid; place-items: center;
            margin-bottom: 1rem;
            border: 1.5px solid var(--purple-mid);
        }
        .flow-step h4 { font-size: 0.9rem; font-weight: 700; color: var(--ink); margin-bottom: 0.35rem; letter-spacing: -0.01em; }
        .flow-step p { font-size: 0.825rem; color: var(--sub); line-height: 1.6; }

        /* ── Roadmap ── */
        .roadmap-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        @media (max-width: 900px) { .roadmap-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 480px) { .roadmap-grid { grid-template-columns: 1fr; } }

        .roadmap-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.625rem;
            background: var(--white);
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.2s;
        }
        .roadmap-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.06); }
        .roadmap-card.active { border-color: var(--purple-mid); background: var(--purple-bg); }

        .roadmap-phase {
            font-size: 0.68rem; font-weight: 800; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--purple);
            margin-bottom: 0.35rem;
        }
        .roadmap-timeline {
            font-size: 0.78rem; font-weight: 600; color: var(--sub);
            margin-bottom: 1rem;
            display: flex; align-items: center; gap: 0.35rem;
        }
        .roadmap-card h3 { font-size: 0.95rem; font-weight: 800; color: var(--ink); margin-bottom: 0.75rem; letter-spacing: -0.02em; }

        .roadmap-items { list-style: none; display: grid; gap: 0.4rem; }
        .roadmap-items li {
            display: flex; align-items: flex-start; gap: 0.5rem;
            font-size: 0.8rem; color: var(--sub); line-height: 1.45;
        }
        .roadmap-items li::before {
            content: ''; width: 5px; height: 5px; border-radius: 50%;
            background: var(--purple); flex-shrink: 0; margin-top: 6px; opacity: 0.6;
        }
        .roadmap-card.active .roadmap-items li::before { opacity: 1; }

        .now-badge {
            position: absolute; top: 1rem; right: 1rem;
            font-size: 0.65rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.06em; color: var(--green);
            background: var(--green-bg); border: 1px solid #a7f3d0;
            border-radius: 999px; padding: 0.15rem 0.55rem;
        }

        /* ── About / Values ── */
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: start; }
        @media (max-width: 740px) { .about-grid { grid-template-columns: 1fr; gap: 2.5rem; } }
        .about-text p { font-size: 0.9375rem; color: var(--sub); line-height: 1.8; margin-bottom: 1rem; }
        .about-ctas { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 2rem; }

        .values { list-style: none; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .value { display: flex; gap: 1rem; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); transition: background 0.15s; }
        .value:last-child { border-bottom: none; }
        .value:hover { background: var(--purple-bg); }
        .value-n { font-size: 0.72rem; font-weight: 800; color: var(--purple); min-width: 1.5rem; padding-top: 2px; }
        .value-body strong { display: block; font-size: 0.9rem; font-weight: 700; color: var(--ink); margin-bottom: 0.2rem; }
        .value-body span { font-size: 0.855rem; color: var(--sub); line-height: 1.55; }

        /* ── Expert section ── */
        .expert-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 3rem;
            align-items: center;
        }
        @media (max-width: 780px) { .expert-grid { grid-template-columns: 1fr; } }

        .expert-types {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-top: 1.75rem;
        }

        .expert-card {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1rem;
            background: var(--white);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: border-color 0.15s, background 0.15s;
        }
        .expert-card:hover { border-color: var(--purple-mid); background: var(--purple-bg); }
        .expert-card-icon { font-size: 1.5rem; flex-shrink: 0; }
        .expert-card h4 { font-size: 0.825rem; font-weight: 700; color: var(--ink); }
        .expert-card p { font-size: 0.75rem; color: var(--sub); line-height: 1.4; }

        .expert-capabilities { list-style: none; display: grid; gap: 0.75rem; }
        .expert-cap {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 1rem; border: 1px solid var(--border); border-radius: 10px;
            background: var(--white); transition: background 0.15s;
        }
        .expert-cap:hover { background: var(--purple-bg); }
        .cap-icon { font-size: 1.1rem; flex-shrink: 0; }
        .expert-cap h4 { font-size: 0.875rem; font-weight: 700; color: var(--ink); margin-bottom: 0.15rem; }
        .expert-cap p { font-size: 0.8rem; color: var(--sub); line-height: 1.45; }

        /* ── CTA Band ── */
        .cta-band { padding: 5.5rem 0; }
        .cta-inner {
            border: 1px solid var(--purple-mid); border-radius: 16px;
            padding: 4rem; display: flex; align-items: center;
            justify-content: space-between; gap: 2rem; flex-wrap: wrap;
            background: linear-gradient(135deg, var(--purple-bg), rgba(245,243,255,0.4));
            position: relative; overflow: hidden;
        }
        .cta-inner::before { content: ''; position: absolute; top: -50%; right: -50%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(124,58,237,0.07), transparent 70%); pointer-events: none; }
        .cta-inner h2 { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; letter-spacing: -0.03em; color: var(--ink); max-width: 30ch; line-height: 1.2; }
        .cta-inner h2 span { color: var(--purple); }

        /* ── Footer ── */
        .site-footer { border-top: 1px solid var(--border); padding: 2rem 0; }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; }
        .footer-logo { font-size: 0.9rem; font-weight: 800; color: var(--ink); display: flex; align-items: center; gap: 0.5rem; }
        .footer-logo img { height: 22px; width: auto; }
        .footer-links { display: flex; list-style: none; gap: 1.5rem; }
        .footer-links a { font-size: 0.875rem; color: var(--sub); transition: color 0.15s; }
        .footer-links a:hover { color: var(--ink); }
        .footer-copy { font-size: 0.8125rem; color: #9ca3af; }

        @media (max-width: 640px) {
            .footer-inner { flex-direction: column; align-items: flex-start; }
            .cta-inner { padding: 2.25rem 1.5rem; }
            .hero { padding: 3.5rem 0 3rem; }
            .section { padding: 3.5rem 0; }
            .cta-band { padding: 3.5rem 0; }
        }

        .anim-up  { opacity: 0; transform: translateY(28px); }
        .anim-left{ opacity: 0; transform: translateX(-24px); }
    </style>
</head>
<body>

<div id="scroll-progress"></div>
<div class="bg-orbs" aria-hidden="true"><div class="orb orb-1"></div><div class="orb orb-2"></div><div class="orb orb-3"></div></div>
<div class="dot-grid" aria-hidden="true"></div>

@php
    $loginUrl    = Route::has('login')    ? route('login')    : url('/login');
    $registerUrl = Route::has('register') ? route('register') : url('/register');
@endphp

<!-- Nav -->
<header class="site-nav" id="siteNav">
    <div class="wrap nav-inner">
        <a class="nav-logo" href="/"><img src="{{ asset('logo.png') }}" alt="Pager Logo">PAGER</a>
        <ul class="nav-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#how-it-works">How It Works</a></li>
            <li><a href="#roadmap">Roadmap</a></li>
            <li><a href="#experts">Experts</a></li>
            <li><a href="#about">About</a></li>
        </ul>
        <div class="nav-actions">
            @auth
                <a class="btn-nav-solid" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a class="btn-nav-ghost" href="{{ $loginUrl }}">Log in</a>
                <a class="btn-nav-solid" href="{{ $registerUrl }}">Get started free</a>
            @endauth
        </div>
        <button class="nav-hamburger" id="menuBtn" aria-label="Open menu" aria-expanded="false">
            <svg id="iconMenu" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <svg id="iconClose" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    <div class="wrap nav-mobile" id="mobileMenu">
        <a href="#features">Features</a><a href="#how-it-works">How It Works</a>
        <a href="#roadmap">Roadmap</a><a href="#experts">Experts</a><a href="#about">About</a>
        @auth <a href="{{ route('dashboard') }}">Dashboard</a>
        @else <a href="{{ $loginUrl }}">Log in</a><a href="{{ $registerUrl }}">Get started</a>
        @endauth
    </div>
</header>

<!-- Hero -->
<section class="hero" id="hero">
    <div class="wrap">
        <div class="hero-label"><span class="hero-label-dot"></span>The Parenting Manager</div>
        <h1 id="heroHeading">Everything a caregiver needs — journal, guidance, and <span class="highlight">expert support.</span></h1>
        <p class="hero-sub">PAGER is a unified caregiving platform with a smart journal, AI-driven advice, milestone tracking, a curated resource library, and access to licensed parenting professionals.</p>
        <div class="hero-actions">
            <a class="btn-solid btn-solid-pulse" href="{{ $registerUrl }}">Get started free
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a class="btn-text" href="#features">Explore features
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="hero-chips">
            <span class="hero-chip">📔 Journal</span>
            <span class="hero-chip">🤖 AI Advice</span>
            <span class="hero-chip">📚 Resources</span>
            <span class="hero-chip">🎯 Milestones</span>
            <span class="hero-chip">👨‍⚕️ Expert Guidance</span>
            <span class="hero-chip">🔒 Privacy-First</span>
        </div>
        <div class="ticker-wrap">
            <div class="ticker-track" id="tickerTrack">
                <span class="ticker-item">Parenting Journal</span><span class="ticker-sep">·</span>
                <span class="ticker-item">AI-Driven Advice</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Milestone Tracking</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Resource Library</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Expert Guidance</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Secure &amp; Private</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Phase 1 Live Now</span><span class="ticker-sep">·</span>
                <span class="ticker-item">Free Core Features</span><span class="ticker-sep">·</span>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<div class="wrap">
    <div class="stats" id="statsBar">
        <div class="stat"><div class="stat-num" data-to="5" data-suffix=" features">0</div><div class="stat-desc">Core modules live in the platform today</div></div>
        <div class="stat"><div class="stat-num" data-to="4" data-suffix=" phases">0</div><div class="stat-desc">Product roadmap from MVP to full scale</div></div>
        <div class="stat"><div class="stat-num">$0 upfront</div><div class="stat-desc">Free core journal &amp; milestone tracking always</div></div>
        <div class="stat"><div class="stat-num" data-to="4" data-suffix=" types">0</div><div class="stat-desc">Parent profiles — expecting, new, working, solo</div></div>
    </div>
</div>

<!-- Features -->
<section class="section" id="features">
    <div class="wrap">
        <div class="eyebrow anim-up">Core Features</div>
        <h2 class="section-h anim-up">Five modules. One caregiving platform.</h2>
        <p class="section-p anim-up">Built around the real needs of parents at every stage — from pregnancy to school age.</p>

        <div class="features-grid">
            <!-- Journal -->
            <div class="feat-card anim-up" style="--accent:#7c3aed; --icon-bg:#f5f3ff;">
                <span class="feat-badge">✓ Live in Phase 1</span>
                <div class="feat-icon">📔</div>
                <div class="feat-num">01</div>
                <h3>Parenting Journal</h3>
                <p>A multimedia diary for documenting your parenting journey — text entries with mood tracking, tags, and a growing timeline of your family's most important moments.</p>
                <div class="feat-tags">
                    <span class="feat-tag">Text entries</span>
                    <span class="feat-tag">Mood tracking</span>
                    <span class="feat-tag">Tagging system</span>
                    <span class="feat-tag">Timeline view</span>
                    <span class="feat-tag">AI summaries</span>
                </div>
            </div>

            <!-- AI Advice -->
            <div class="feat-card anim-up" style="--accent:#2563eb; --icon-bg:#eff6ff;">
                <span class="feat-badge">✓ Rule-based live · <span class="feat-badge-soon" style="display:inline-flex;margin:0;border:none;padding:0;background:none;font-size:inherit;font-weight:inherit;">AI in Phase 2</span></span>
                <div class="feat-icon" style="background:#eff6ff;">🤖</div>
                <div class="feat-num">02</div>
                <h3>AI-Driven Parenting Advice</h3>
                <p>Personalized recommendations based on your parent type and child's developmental stage. Context-aware guidance covering sleep, feeding, behaviour, and mood.</p>
                <div class="feat-tags">
                    <span class="feat-tag" style="background:#eff6ff;color:#2563eb;">Age-based guidance</span>
                    <span class="feat-tag" style="background:#eff6ff;color:#2563eb;">Smart alerts</span>
                    <span class="feat-tag" style="background:#eff6ff;color:#2563eb;">Behaviour insights</span>
                </div>
            </div>

            <!-- Resources -->
            <div class="feat-card anim-up" style="--accent:#059669; --icon-bg:#ecfdf5;">
                <span class="feat-badge">✓ Live in Phase 1</span>
                <div class="feat-icon" style="background:#ecfdf5;">📚</div>
                <div class="feat-num">03</div>
                <h3>Resource Library</h3>
                <p>A searchable, filterable database of expert-backed articles, videos, and guides — covering sleep, feeding, wellness, and development from pregnancy to school age.</p>
                <div class="feat-tags">
                    <span class="feat-tag" style="background:#ecfdf5;color:#059669;">Articles &amp; videos</span>
                    <span class="feat-tag" style="background:#ecfdf5;color:#059669;">Search &amp; filter</span>
                    <span class="feat-tag" style="background:#ecfdf5;color:#059669;">Expert content</span>
                </div>
            </div>

            <!-- Milestones -->
            <div class="feat-card feat-wide anim-up" style="--accent:#d97706; --icon-bg:#fffbeb;">
                <span class="feat-badge">✓ Live in Phase 1</span>
                <div class="feat-icon" style="background:#fffbeb;">🎯</div>
                <div class="feat-num">04</div>
                <h3>Milestone Tracking</h3>
                <p>Structured developmental checklists from 0–9 months, with a visual progress bar tracking how many milestones your child has reached. Alerts and reminders coming in Phase 2.</p>
                <div class="feat-tags">
                    <span class="feat-tag" style="background:#fffbeb;color:#d97706;">Developmental checklists</span>
                    <span class="feat-tag" style="background:#fffbeb;color:#d97706;">Progress dashboard</span>
                    <span class="feat-tag" style="background:#fffbeb;color:#d97706;">Alerts in Phase 2</span>
                    <span class="feat-tag" style="background:#fffbeb;color:#d97706;">Localization in Phase 3</span>
                </div>
            </div>

            <!-- Expert Guidance -->
            <div class="feat-card anim-up" style="--accent:#db2777; --icon-bg:#fdf2f8;">
                <span class="feat-badge feat-badge-soon">Coming Phase 2–3</span>
                <div class="feat-icon" style="background:#fdf2f8;">👨‍⚕️</div>
                <div class="feat-num">05</div>
                <h3>Expert Parenting Guidance</h3>
                <p>Access licensed psychologists, early childhood specialists, and occupational therapists via Ask-an-Expert and live 1:1 video consultations.</p>
                <div class="feat-tags">
                    <span class="feat-tag" style="background:#fdf2f8;color:#db2777;">1:1 consultations</span>
                    <span class="feat-tag" style="background:#fdf2f8;color:#db2777;">Ask-an-Expert</span>
                    <span class="feat-tag" style="background:#fdf2f8;color:#db2777;">Care plans</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="section" id="how-it-works">
    <div class="wrap">
        <div class="eyebrow anim-up">User Flow</div>
        <h2 class="section-h anim-up">How PAGER works for you.</h2>
        <p class="section-p anim-up">A continuous loop of logging, learning, and support — designed to grow alongside your family.</p>

        <div class="flow-grid" id="flowGrid">
            <div class="flow-step"><div class="flow-num">1</div><h4>Sign up &amp; profile</h4><p>Create your account and tell us your parent type so we can personalize everything.</p></div>
            <div class="flow-step"><div class="flow-num">2</div><h4>Log your journey</h4><p>Write journal entries with moods and tags. Track milestones as your child hits each one.</p></div>
            <div class="flow-step"><div class="flow-num">3</div><h4>AI analyzes &amp; guides</h4><p>The platform reads your data and delivers personalized advice and smart daily tips.</p></div>
            <div class="flow-step"><div class="flow-num">4</div><h4>Expert support</h4><p>If you need more, connect with a licensed professional who can build a care plan for your family.</p></div>
            <div class="flow-step"><div class="flow-num">5</div><h4>System adapts</h4><p>As your child grows and your entries evolve, PAGER continuously refines its recommendations.</p></div>
            <div class="flow-step"><div class="flow-num">6</div><h4>Access resources</h4><p>Browse expert-backed articles and videos filtered to your child's age and current concerns.</p></div>
            <div class="flow-step"><div class="flow-num">7</div><h4>Track progress</h4><p>Watch your milestone completion grow and celebrate your child's development visually.</p></div>
            <div class="flow-step"><div class="flow-num">8</div><h4>Loop continues</h4><p>The more you use PAGER, the smarter and more personalized your experience becomes.</p></div>
        </div>
    </div>
</section>

<!-- Roadmap -->
<section class="section" id="roadmap">
    <div class="wrap">
        <div class="eyebrow anim-up">Product Roadmap</div>
        <h2 class="section-h anim-up">From MVP to the world's most trusted parenting platform.</h2>
        <p class="section-p anim-up">A phased approach that ships value fast and scales to global caregiving support.</p>

        <div class="roadmap-grid">
            <div class="roadmap-card active anim-up">
                <span class="now-badge">Live Now</span>
                <div class="roadmap-phase">Phase 1</div>
                <div class="roadmap-timeline">⏱ 0–6 months · MVP</div>
                <h3>Core Platform</h3>
                <ul class="roadmap-items">
                    <li>Parenting Journal (text + tags + mood)</li>
                    <li>Milestone tracking with checklists</li>
                    <li>Static resource library</li>
                    <li>Basic AI tips (rule-based)</li>
                    <li>Parent type personalization</li>
                </ul>
            </div>
            <div class="roadmap-card anim-up">
                <div class="roadmap-phase">Phase 2</div>
                <div class="roadmap-timeline">⏱ 6–12 months · Growth</div>
                <h3>Intelligence Layer</h3>
                <ul class="roadmap-items">
                    <li>AI personalization (journal-based)</li>
                    <li>Smart notifications &amp; alerts</li>
                    <li>Advanced resource search/filter</li>
                    <li>Dashboard analytics</li>
                    <li>Ask-an-Expert (async messaging)</li>
                </ul>
            </div>
            <div class="roadmap-card anim-up">
                <div class="roadmap-phase">Phase 3</div>
                <div class="roadmap-timeline">⏱ 12–24 months · Expansion</div>
                <h3>Expert Ecosystem</h3>
                <ul class="roadmap-items">
                    <li>Live 1:1 video consultations</li>
                    <li>Community features</li>
                    <li>Parenting marketplace</li>
                    <li>Localization &amp; global rollout</li>
                    <li>Personalized care plans</li>
                </ul>
            </div>
            <div class="roadmap-card anim-up">
                <div class="roadmap-phase">Phase 4</div>
                <div class="roadmap-timeline">⏱ 2+ years · Scale</div>
                <h3>Full Ecosystem</h3>
                <ul class="roadmap-items">
                    <li>Predictive parenting insights</li>
                    <li>Full AI copilot for caregivers</li>
                    <li>Integrated expert ecosystem</li>
                    <li>Health device &amp; wearable sync</li>
                    <li>Full care plans platform</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Expert Section -->
<section class="section" id="experts">
    <div class="wrap">
        <div class="expert-grid">
            <div>
                <div class="eyebrow anim-up">Expert Guidance</div>
                <h2 class="section-h anim-up">Human-backed support, beyond AI.</h2>
                <p class="anim-up" style="font-size:0.9375rem;color:var(--sub);line-height:1.8;margin-bottom:1.5rem;">For complex situations, PAGER connects you with licensed professionals — the people who've dedicated their careers to child development and family wellbeing.</p>
                <div class="expert-types">
                    <div class="expert-card anim-up"><span class="expert-card-icon">🧠</span><div><h4>Psychologists</h4><p>Behavioural &amp; emotional support</p></div></div>
                    <div class="expert-card anim-up"><span class="expert-card-icon">👶</span><div><h4>ECD Specialists</h4><p>Early childhood development</p></div></div>
                    <div class="expert-card anim-up"><span class="expert-card-icon">🤲</span><div><h4>Occupational Therapists</h4><p>Sensory &amp; physical development</p></div></div>
                    <div class="expert-card anim-up"><span class="expert-card-icon">📋</span><div><h4>Care Plan Builders</h4><p>Tailored family strategies</p></div></div>
                </div>
            </div>

            <ul class="expert-capabilities anim-up">
                <li class="expert-cap"><span class="cap-icon">🎥</span><div><h4>1:1 Consultations</h4><p>Video, chat, or voice sessions with licensed specialists at your convenience.</p></div></li>
                <li class="expert-cap"><span class="cap-icon">💬</span><div><h4>Ask-an-Expert</h4><p>Submit questions and receive professional, thoughtful responses within 24 hours.</p></div></li>
                <li class="expert-cap"><span class="cap-icon">📄</span><div><h4>Personalized Care Plans</h4><p>Tailored strategies for development concerns, co-created with your assigned expert.</p></div></li>
                <li class="expert-cap"><span class="cap-icon">🔗</span><div><h4>Local Referrals</h4><p>Get connected to verified professionals near you when in-person care is needed.</p></div></li>
            </ul>
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
                    <a class="btn-text" href="#experts">Meet the experts →</a>
                </div>
            </div>
            <ul class="values">
                <li class="value anim-left"><span class="value-n">01</span><div class="value-body"><strong>Family First</strong><span>Every feature is designed around what families actually need, not what looks good on a pitch deck.</span></div></li>
                <li class="value anim-left"><span class="value-n">02</span><div class="value-body"><strong>Empowered Caregiving</strong><span>Informed caregivers raise confident children. We turn uncertainty into capability.</span></div></li>
                <li class="value anim-left"><span class="value-n">03</span><div class="value-body"><strong>Accessible for All</strong><span>Every caregiver deserves support regardless of background, device, or circumstance.</span></div></li>
                <li class="value anim-left"><span class="value-n">04</span><div class="value-body"><strong>Trust &amp; Privacy</strong><span>Families share their most intimate milestones with PAGER. We protect that completely.</span></div></li>
            </ul>
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
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="site-footer">
    <div class="wrap footer-inner">
        <div class="footer-logo"><img src="{{ asset('logo.png') }}" alt="Pager">PAGER</div>
        <ul class="footer-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#roadmap">Roadmap</a></li>
            <li><a href="#experts">Experts</a></li>
            <li><a href="#about">About</a></li>
            @auth <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @else <li><a href="{{ $loginUrl }}">Log in</a></li>
            @endauth
        </ul>
        <p class="footer-copy">© {{ date('Y') }} PAGER. All rights reserved.</p>
    </div>
</footer>

<script>
(() => {
    /* Scroll progress */
    const prog = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
        prog.style.width = Math.min(window.scrollY / (document.body.scrollHeight - window.innerHeight) * 100, 100) + '%';
    }, { passive: true });

    /* Nav shadow */
    const nav = document.querySelector('.site-nav');
    window.addEventListener('scroll', () => {
        nav.style.boxShadow = window.scrollY > 10 ? '0 1px 20px rgba(0,0,0,0.07)' : 'none';
    }, { passive: true });

    /* Hero entrance */
    anime.timeline({ easing: 'easeOutExpo' })
        .add({ targets: '.hero-label', opacity:[0,1], translateY:[-12,0], duration:600 })
        .add({ targets: '#heroHeading', opacity:[0,1], translateY:[32,0], duration:800 }, '-=300')
        .add({ targets: '.hero-sub', opacity:[0,1], translateY:[20,0], duration:700 }, '-=500')
        .add({ targets: '.hero-actions', opacity:[0,1], translateY:[16,0], duration:600 }, '-=450')
        .add({ targets: '.hero-chips', opacity:[0,1], translateY:[14,0], duration:600 }, '-=400');

    /* Ticker */
    const track = document.getElementById('tickerTrack');
    if (track) {
        track.innerHTML += track.innerHTML;
        const fw = track.scrollWidth / 2;
        let pos = 0;
        function tick() { pos -= 0.55; if (pos <= -fw) pos = 0; track.style.transform = 'translateX('+pos+'px)'; requestAnimationFrame(tick); }
        requestAnimationFrame(tick);
    }

    /* IntersectionObserver scroll animations */
    const seen = new WeakSet();
    const obs = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting || seen.has(entry.target)) return;
            seen.add(entry.target); obs.unobserve(entry.target);
            const el = entry.target;
            if (el.classList.contains('anim-up')) {
                anime({ targets: el, opacity:[0,1], translateY:[28,0], duration:750, easing:'easeOutExpo' });
            } else if (el.classList.contains('anim-left')) {
                anime({ targets: el, opacity:[0,1], translateX:[-24,0], duration:700, easing:'easeOutExpo' });
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.anim-up, .anim-left').forEach(el => obs.observe(el));

    /* Flow grid stagger */
    const flowObs = new IntersectionObserver(entries => {
        if (!entries[0].isIntersecting) return;
        flowObs.disconnect();
        anime({ targets: '#flowGrid .flow-step', opacity:[0,1], translateY:[20,0], duration:600, easing:'easeOutExpo', delay:anime.stagger(70) });
    }, { threshold: 0.1 });
    const flowGrid = document.getElementById('flowGrid');
    if (flowGrid) { flowGrid.querySelectorAll('.flow-step').forEach(s => { s.style.opacity = 0; }); flowObs.observe(flowGrid); }

    /* Stats count-up */
    const statsSection = document.getElementById('statsBar');
    if (statsSection) {
        const countObs = new IntersectionObserver(entries => {
            if (!entries[0].isIntersecting) return;
            countObs.disconnect();
            document.querySelectorAll('.stat-num[data-to]').forEach(el => {
                const obj = { val: 0 };
                anime({ targets: obj, val: +el.dataset.to, round: 1, duration: 1600, easing:'easeOutExpo',
                    update() { el.textContent = obj.val + (el.dataset.suffix || ''); }
                });
            });
        }, { threshold: 0.5 });
        countObs.observe(statsSection);
    }

    /* Card tilt */
    document.querySelectorAll('.feat-card, .roadmap-card, .expert-cap').forEach(card => {
        card.addEventListener('mousemove', e => {
            const r = card.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top)  / r.height - 0.5;
            card.style.transform = `perspective(700px) rotateY(${x*5}deg) rotateX(${-y*5}deg) translateY(-2px)`;
        });
        card.addEventListener('mouseleave', () => {
            anime({ targets: card, rotateX:0, rotateY:0, translateY:0, duration:400, easing:'easeOutExpo' });
        });
    });

    /* Mobile nav */
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const iconMenu = document.getElementById('iconMenu');
    const iconClose = document.getElementById('iconClose');
    menuBtn.addEventListener('click', () => {
        const open = mobileMenu.classList.toggle('open');
        menuBtn.setAttribute('aria-expanded', open);
        iconMenu.style.display = open ? 'none' : 'block';
        iconClose.style.display = open ? 'block' : 'none';
        if (open) anime({ targets: mobileMenu.querySelectorAll('a'), opacity:[0,1], translateX:[-12,0], duration:300, easing:'easeOutExpo', delay:anime.stagger(40) });
    });
    mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
        mobileMenu.classList.remove('open'); menuBtn.setAttribute('aria-expanded', 'false');
        iconMenu.style.display = 'block'; iconClose.style.display = 'none';
    }));

    /* Smooth scroll */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const t = document.querySelector(a.getAttribute('href'));
            if (!t) return;
            e.preventDefault();
            window.scrollTo({ top: t.getBoundingClientRect().top + scrollY - 70, behavior: 'smooth' });
        });
    });
})();
</script>
</body>
</html>
