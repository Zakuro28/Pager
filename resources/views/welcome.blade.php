<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAGER | Business Website</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=mali:400,500,600,700|manjari:400,700" rel="stylesheet" />
    <style>
        :root {
            --sun: #ffdd8b;
            --cream: #f5f0e6;
            --lavender: #d4bcff;
            --ink: #2e2242;
            --muted: #5f4f7f;
            --card: rgba(255, 255, 255, 0.72);
            --line: rgba(124, 96, 179, 0.2);
            --shadow: 0 20px 55px rgba(70, 45, 118, 0.2);
            --bg-start: #fffcf7;
            --bg-end: #f5f0e6;
            --glow-a: rgba(255, 221, 139, 0.55);
            --glow-b: rgba(212, 188, 255, 0.6);
            --surface-soft: rgba(255, 255, 255, 0.76);
            --surface-muted: rgba(255, 255, 255, 0.7);
            --cta-grad-a: #8b67c7;
            --cta-grad-b: #c6a6ff;
            --cta-text: #f5f0e6;
        }

        [data-theme="dark"] {
            --sun: #a892d4;
            --cream: #151221;
            --lavender: #8166b8;
            --ink: #f2edff;
            --muted: #c4b4e6;
            --card: rgba(31, 26, 46, 0.78);
            --line: rgba(212, 188, 255, 0.28);
            --shadow: 0 20px 55px rgba(0, 0, 0, 0.35);
            --bg-start: #1c162d;
            --bg-end: #0f0c18;
            --glow-a: rgba(168, 146, 212, 0.25);
            --glow-b: rgba(129, 102, 184, 0.3);
            --surface-soft: rgba(41, 34, 61, 0.8);
            --surface-muted: rgba(47, 39, 70, 0.82);
            --cta-grad-a: #6f56a3;
            --cta-grad-b: #8d73c2;
            --cta-text: #e9dcff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Manjari", sans-serif;
            color: var(--ink);
            min-height: 100vh;
            overflow-x: hidden;
            background:
                radial-gradient(circle at 10% 8%, var(--glow-a), transparent 30%),
                radial-gradient(circle at 90% 15%, var(--glow-b), transparent 35%),
                linear-gradient(180deg, var(--bg-start) 0%, var(--bg-end) 100%);
            transition: background 0.35s ease, color 0.35s ease;
        }

        .ambient {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .orb {
            position: absolute;
            border-radius: 999px;
            filter: blur(12px);
            opacity: 0.5;
            animation: float 8s ease-in-out infinite;
        }

        .orb-one {
            width: 220px;
            height: 220px;
            background: var(--sun);
            left: -40px;
            top: 120px;
        }

        .orb-two {
            width: 280px;
            height: 280px;
            background: var(--lavender);
            right: -70px;
            top: 210px;
            animation-delay: 1.8s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-18px); }
        }

        .container {
            width: min(1120px, 92vw);
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .topbar {
            padding: 1.2rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-family: "Mali", sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 0.04em;
        }

        .logo-mark {
            width: 54px;
            height: 54px;
            display: block;
            flex-shrink: 0;
            filter: drop-shadow(0 6px 12px rgba(92, 64, 145, 0.2));
        }

        .logo-mark text {
            font-family: "Mali", sans-serif;
            font-weight: 700;
        }

        .nav {
            display: flex;
            gap: 0.55rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .chip {
            text-decoration: none;
            color: var(--ink);
            border: 1px solid var(--line);
            background: var(--surface-soft);
            padding: 0.48rem 0.95rem;
            border-radius: 999px;
            font-weight: 700;
            backdrop-filter: blur(6px);
        }

        .hero {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 1rem;
            margin-top: 1.1rem;
        }

        .panel {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 1.25rem;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }

        h1, h2, h3 {
            font-family: "Mali", sans-serif;
            line-height: 1.2;
        }

        h1 {
            font-size: clamp(2rem, 5vw, 3.6rem);
            margin-bottom: 0.7rem;
        }

        .kicker {
            text-transform: uppercase;
            letter-spacing: 0.07em;
            font-size: 0.8rem;
            font-weight: 700;
            color: #7b56ba;
        }

        .lead {
            color: var(--muted);
            margin: 0.8rem 0 1rem;
            max-width: 60ch;
        }

        .hero-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.5rem;
            color: #7b56ba;
            font-weight: 700;
        }

        .hero-actions {
            display: flex;
            gap: 0.65rem;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 1rem;
        }

        .uiverse-btn {
            position: relative;
            border: 0;
            border-radius: 14px;
            padding: 0.75rem 1.15rem;
            font-weight: 700;
            color: #2e2242;
            background: linear-gradient(120deg, #c6a6ff, #ffdd8b);
            box-shadow: 0 10px 20px rgba(117, 86, 176, 0.25);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
            text-decoration: none;
        }

        .uiverse-btn:before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(255,255,255,0.65), rgba(255,255,255,0));
            transform: translateX(-120%);
            transition: transform 0.45s ease;
        }

        .uiverse-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(117, 86, 176, 0.3);
        }

        .uiverse-btn:hover:before {
            transform: translateX(120%);
        }

        .ghost-btn {
            text-decoration: none;
            border: 1px solid var(--line);
            color: var(--ink);
            background: var(--surface-muted);
            border-radius: 12px;
            padding: 0.7rem 1rem;
            font-weight: 700;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .stat {
            background: var(--surface-muted);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 0.75rem;
        }

        .stat strong {
            display: block;
            font-family: "Mali", sans-serif;
            font-size: 1.15rem;
        }

        .section {
            margin-top: 1rem;
            padding-bottom: 0.5rem;
        }

        .section-title {
            margin-bottom: 0.7rem;
            font-size: clamp(1.45rem, 2.6vw, 2rem);
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 1rem;
            backdrop-filter: blur(9px);
            box-shadow: 0 10px 22px rgba(93, 66, 142, 0.12);
            transition: transform 0.22s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card p {
            color: var(--muted);
            margin-top: 0.35rem;
        }

        .footer-cta {
            margin: 1.1rem 0 2.2rem;
            border-radius: 22px;
            padding: 1.2rem;
            background: linear-gradient(140deg, var(--cta-grad-a), var(--cta-grad-b));
            color: #fff;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .footer-cta p {
            color: var(--cta-text);
        }

        .settings-corner {
            position: fixed;
            top: 14px;
            right: 14px;
            z-index: 30;
        }

        .settings-trigger {
            width: 48px;
            height: 48px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--surface-soft);
            color: var(--ink);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 12px 22px rgba(72, 49, 121, 0.2);
            backdrop-filter: blur(8px);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .settings-trigger:hover {
            transform: translateY(-2px) rotate(12deg);
            box-shadow: 0 16px 28px rgba(72, 49, 121, 0.25);
        }

        .settings-popover {
            position: absolute;
            top: 58px;
            right: 0;
            width: min(280px, 86vw);
            border: 1px solid var(--line);
            background: var(--card);
            border-radius: 16px;
            padding: 0.9rem;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }

        .settings-popover[hidden] {
            display: none;
        }

        .settings-head {
            font-family: "Mali", sans-serif;
            font-size: 1rem;
            margin-bottom: 0.15rem;
        }

        .settings-note {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 0.7rem;
        }

        .toggle-wrap {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--ink);
            font-weight: 700;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch #themeToggle {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #2196f3;
            transition: 0.4s;
            z-index: 0;
            overflow: hidden;
        }

        .sun-moon {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: yellow;
            transition: 0.4s;
        }

        .switch #themeToggle:checked + .slider {
            background-color: black;
        }

        .switch #themeToggle:focus + .slider {
            box-shadow: 0 0 1px #2196f3;
        }

        .switch #themeToggle:checked + .slider .sun-moon {
            transform: translateX(26px);
            background-color: white;
            animation: rotate-center 0.6s ease-in-out both;
        }

        @keyframes rotate-center {
            0% { transform: translateX(26px) rotate(0); }
            100% { transform: translateX(26px) rotate(360deg); }
        }

        .moon-dot {
            opacity: 0;
            transition: 0.4s;
            fill: gray;
        }

        .switch #themeToggle:checked + .slider .sun-moon .moon-dot {
            opacity: 1;
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round .sun-moon {
            border-radius: 50%;
        }

        #moon-dot-1 {
            left: 10px;
            top: 3px;
            position: absolute;
            width: 6px;
            height: 6px;
            z-index: 4;
        }

        #moon-dot-2 {
            left: 2px;
            top: 10px;
            position: absolute;
            width: 10px;
            height: 10px;
            z-index: 4;
        }

        #moon-dot-3 {
            left: 16px;
            top: 18px;
            position: absolute;
            width: 3px;
            height: 3px;
            z-index: 4;
        }

        #light-ray-1 {
            left: -8px;
            top: -8px;
            position: absolute;
            width: 43px;
            height: 43px;
            z-index: -1;
            fill: white;
            opacity: 10%;
        }

        #light-ray-2 {
            left: -50%;
            top: -50%;
            position: absolute;
            width: 55px;
            height: 55px;
            z-index: -1;
            fill: white;
            opacity: 10%;
        }

        #light-ray-3 {
            left: -18px;
            top: -18px;
            position: absolute;
            width: 60px;
            height: 60px;
            z-index: -1;
            fill: white;
            opacity: 10%;
        }

        .cloud-light {
            position: absolute;
            fill: #eee;
            animation-name: cloud-move;
            animation-duration: 6s;
            animation-iteration-count: infinite;
        }

        .cloud-dark {
            position: absolute;
            fill: #ccc;
            animation-name: cloud-move;
            animation-duration: 6s;
            animation-iteration-count: infinite;
            animation-delay: 1s;
        }

        #cloud-1 {
            left: 30px;
            top: 15px;
            width: 40px;
        }

        #cloud-2 {
            left: 44px;
            top: 10px;
            width: 20px;
        }

        #cloud-3 {
            left: 18px;
            top: 24px;
            width: 30px;
        }

        #cloud-4 {
            left: 36px;
            top: 18px;
            width: 40px;
        }

        #cloud-5 {
            left: 48px;
            top: 14px;
            width: 20px;
        }

        #cloud-6 {
            left: 22px;
            top: 26px;
            width: 30px;
        }

        @keyframes cloud-move {
            0% { transform: translateX(0px); }
            40% { transform: translateX(4px); }
            80% { transform: translateX(-4px); }
            100% { transform: translateX(0px); }
        }

        .stars {
            transform: translateY(-32px);
            opacity: 0;
            transition: 0.4s;
        }

        .star {
            fill: white;
            position: absolute;
            transition: 0.4s;
            animation-name: star-twinkle;
            animation-duration: 2s;
            animation-iteration-count: infinite;
        }

        .switch #themeToggle:checked + .slider .stars {
            transform: translateY(0);
            opacity: 1;
        }

        #star-1 {
            width: 20px;
            top: 2px;
            left: 3px;
            animation-delay: 0.3s;
        }

        #star-2 {
            width: 6px;
            top: 16px;
            left: 3px;
        }

        #star-3 {
            width: 12px;
            top: 20px;
            left: 10px;
            animation-delay: 0.6s;
        }

        #star-4 {
            width: 18px;
            top: 0px;
            left: 18px;
            animation-delay: 1.3s;
        }

        @keyframes star-twinkle {
            0% { transform: scale(1); }
            40% { transform: scale(1.2); }
            80% { transform: scale(0.8); }
            100% { transform: scale(1); }
        }

        .theme-toggle {
            position: relative;
            width: 56px;
            height: 32px;
            background: var(--surface-muted);
            border: 1px solid var(--line);
            border-radius: 999px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        #themeToggle {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        @media (max-width: 960px) {
            .hero,
            .grid-3,
            .stats {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding-top: 4.1rem;
            }

            .nav {
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 640px) {
            .container {
                width: min(1120px, 94vw);
            }

            .brand {
                width: 100%;
                font-size: 1rem;
            }

            .logo-mark {
                width: 44px;
                height: 44px;
            }

            .nav {
                gap: 0.45rem;
            }

            .chip,
            .uiverse-btn,
            .ghost-btn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }

            .panel {
                padding: 1rem;
            }

            .hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .settings-corner {
                top: auto;
                right: 12px;
                bottom: 12px;
            }

            .settings-popover {
                top: auto;
                bottom: 58px;
            }
        }
    </style>
</head>
<body>
@php
    $loginUrl = Route::has('login') ? route('login') : url('/login');
    $registerUrl = Route::has('register') ? route('register') : url('/register');
@endphp

<div class="ambient" aria-hidden="true">
    <div class="orb orb-one"></div>
    <div class="orb orb-two"></div>
</div>

<div class="settings-corner">
    <button id="settingsTrigger" class="settings-trigger" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="settingsPanel" aria-label="Open settings">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 8.25a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5Z" stroke="currentColor" stroke-width="1.8"/>
            <path d="M19.5 13.5v-3l-2.03-.34a6.95 6.95 0 0 0-.6-1.45l1.2-1.68l-2.12-2.12l-1.68 1.2c-.46-.25-.95-.45-1.45-.6L12.5 3h-3l-.34 2.03c-.5.15-.99.35-1.45.6L6.03 4.43L3.9 6.55l1.2 1.68c-.25.46-.45.95-.6 1.45L2.5 10.5v3l2.03.34c.15.5.35.99.6 1.45l-1.2 1.68l2.12 2.12l1.68-1.2c.46.25.95.45 1.45.6L9.5 21h3l.34-2.03c.5-.15.99-.35 1.45-.6l1.68 1.2l2.12-2.12l-1.2-1.68c.25-.46.45-.95.6-1.45L19.5 13.5Z" stroke="currentColor" stroke-width="1.2"/>
        </svg>
    </button>
    <div id="settingsPanel" class="settings-popover" hidden>
        <p class="settings-head">Settings</p>
        <p class="settings-note">Choose your preferred appearance.</p>
        <div class="toggle-wrap">
            <span>Dark Mode</span>
            <label class="switch">
                <input id="themeToggle" type="checkbox" aria-label="Toggle dark mode">
                <div class="slider round">
                    <div class="sun-moon">
                        <svg id="moon-dot-1" class="moon-dot" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="moon-dot-2" class="moon-dot" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="moon-dot-3" class="moon-dot" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="light-ray-1" class="light-ray" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="light-ray-2" class="light-ray" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="light-ray-3" class="light-ray" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="cloud-1" class="cloud-dark" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="cloud-2" class="cloud-dark" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="cloud-3" class="cloud-dark" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="cloud-4" class="cloud-light" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="cloud-5" class="cloud-light" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                        <svg id="cloud-6" class="cloud-light" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                    </div>
                    <div class="stars">
                        <svg id="star-1" class="star" viewBox="0 0 20 20"><path d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"></path></svg>
                        <svg id="star-2" class="star" viewBox="0 0 20 20"><path d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"></path></svg>
                        <svg id="star-3" class="star" viewBox="0 0 20 20"><path d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"></path></svg>
                        <svg id="star-4" class="star" viewBox="0 0 20 20"><path d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"></path></svg>
                    </div>
                </div>
            </label>
        </div>
    </div>
</div>

<header class="container topbar">
    <div class="brand">
        <svg class="logo-mark" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="PAGER logo">
            <ellipse cx="60" cy="57" rx="53" ry="41" fill="none" stroke="#d4bcff" stroke-width="6"/>
            <path d="M18 78c14 3 29 2 40-2 3-1 5-1 8 0 12 4 27 5 41 2" fill="none" stroke="#d4bcff" stroke-width="5" stroke-linecap="round"/>
            <path d="M53 80l-10 13m12-12l-11 14m24-14l11 14m-12-13l10 13" fill="none" stroke="#d4bcff" stroke-width="5" stroke-linecap="round"/>
            <text x="60" y="63" text-anchor="middle" font-size="24" fill="#ffdd8b">PAGER</text>
        </svg>
        <span>PAGER | Parenting Manager</span>
    </div>
    <nav class="nav">
        <a class="chip" href="#features">Features</a>
        <a class="chip" href="#plan">Business Plan</a>
        @auth
            <a class="uiverse-btn" href="{{ url('/dashboard') }}">Dashboard</a>
        @else
            <a class="chip" href="{{ $loginUrl }}">Login</a>
            <a class="uiverse-btn" href="{{ $registerUrl }}">Register</a>
        @endauth
    </nav>
</header>

<main class="container">
    <section class="hero">
        <article class="panel">
            <p class="kicker">Uiverse-inspired Business UI</p>
            <div class="hero-brand">
                <svg class="logo-mark" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                    <ellipse cx="60" cy="57" rx="53" ry="41" fill="none" stroke="#d4bcff" stroke-width="6"/>
                    <path d="M18 78c14 3 29 2 40-2 3-1 5-1 8 0 12 4 27 5 41 2" fill="none" stroke="#d4bcff" stroke-width="5" stroke-linecap="round"/>
                    <path d="M53 80l-10 13m12-12l-11 14m24-14l11 14m-12-13l10 13" fill="none" stroke="#d4bcff" stroke-width="5" stroke-linecap="round"/>
                    <text x="60" y="63" text-anchor="middle" font-size="24" fill="#ffdd8b">PAGER</text>
                </svg>
                <span>Official PAGER Brand</span>
            </div>
            <h1>Build PAGER into a trusted parenting business brand.</h1>
            <p class="lead">A premium and responsive website experience designed to convert visitors into users, with strong identity, modern interactions, and clear access to Login/Register.</p>
            <div class="hero-actions">
                <a class="uiverse-btn" href="{{ $registerUrl }}">Start Free</a>
                <a class="ghost-btn" href="#plan">View Strategy</a>
            </div>
            <div class="stats">
                <div class="stat"><strong>10-Year Vision</strong>Trusted global companion</div>
                <div class="stat"><strong>AI Guidance</strong>Personalized parenting support</div>
                <div class="stat"><strong>Platforms</strong>Mobile and desktop ready</div>
            </div>
        </article>

        <aside class="panel" id="plan">
            <h2>Business Direction</h2>
            <p style="color: var(--muted); margin-top: .35rem;">PAGER combines practical parenting tools, guided insights, and a digital journey tracker to support modern families.</p>
            <div class="grid-3" style="margin-top: .9rem; grid-template-columns: 1fr;">
                <article class="card">
                    <h3>Mission</h3>
                    <p>Simplify and enrich parenting through personalized guidance and secure tools.</p>
                </article>
                <article class="card">
                    <h3>Growth</h3>
                    <p>Professional partnerships, stronger retention loops, and scalable global rollout.</p>
                </article>
                <article class="card">
                    <h3>Monetization</h3>
                    <p>Balance affordability and premium value without harming core user trust.</p>
                </article>
            </div>
        </aside>
    </section>

    <section class="section" id="features">
        <h2 class="section-title">Product Highlights</h2>
        <div class="grid-3">
            <article class="card">
                <h3>Personalized Parenting Support</h3>
                <p>AI-driven guidance tailored to unique family needs across parenting stages.</p>
            </article>
            <article class="card">
                <h3>Interactive Digital Journal</h3>
                <p>Track milestones, challenges, and progress in one clear timeline.</p>
            </article>
            <article class="card">
                <h3>Privacy and Security</h3>
                <p>Built with strong safeguards to protect sensitive caregiver and child data.</p>
            </article>
            <article class="card">
                <h3>Caregiving Toolbox</h3>
                <p>Expert resources from pregnancy through adolescence in a single library.</p>
            </article>
            <article class="card">
                <h3>Community and Partnerships</h3>
                <p>Guided by experts and councils to maintain credibility and quality.</p>
            </article>
            <article class="card">
                <h3>Data-Driven Improvements</h3>
                <p>Continuous product refinement based on real usage and family feedback.</p>
            </article>
        </div>
    </section>

    <section class="footer-cta">
        <div>
            <h2>Launch-ready, conversion-focused business UI.</h2>
            <p>Use the new auth actions now to onboard users quickly.</p>
        </div>
        <a class="uiverse-btn" href="{{ $registerUrl }}">Create Account</a>
    </section>
</main>
<script>
(() => {
    const storageKey = "pager-theme";
    const root = document.documentElement;
    const toggle = document.getElementById("themeToggle");
    const settingsTrigger = document.getElementById("settingsTrigger");
    const settingsPanel = document.getElementById("settingsPanel");
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    const savedTheme = localStorage.getItem(storageKey);
    const initialTheme = savedTheme || (prefersDark ? "dark" : "light");

    root.setAttribute("data-theme", initialTheme);

    if (toggle) {
        toggle.checked = initialTheme === "dark";
        toggle.addEventListener("change", () => {
            const nextTheme = toggle.checked ? "dark" : "light";
            root.setAttribute("data-theme", nextTheme);
            localStorage.setItem(storageKey, nextTheme);
        });
    }

    if (settingsTrigger && settingsPanel) {
        const closePanel = () => {
            settingsPanel.hidden = true;
            settingsTrigger.setAttribute("aria-expanded", "false");
        };

        settingsTrigger.addEventListener("click", (event) => {
            event.stopPropagation();
            const willOpen = settingsPanel.hidden;
            settingsPanel.hidden = !willOpen;
            settingsTrigger.setAttribute("aria-expanded", willOpen ? "true" : "false");
        });

        settingsPanel.addEventListener("click", (event) => {
            event.stopPropagation();
        });

        document.addEventListener("click", closePanel);

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                closePanel();
            }
        });
    }
})();
</script>
</body>
</html>
