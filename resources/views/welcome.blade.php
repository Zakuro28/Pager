<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'PAGER') }} | Parenting Manager</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=mali:400,500,600,700" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=manjari:100,400,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body { margin: 0; font-family: 'Mali', Arial, sans-serif; background: #f5f0e6; color: #3b2f57; }
                .fallback-wrap { width: min(1100px, 92vw); margin: 2rem auto; }
                .fallback-card { border: 1px solid #d4bcff; border-radius: 16px; background: #fff; padding: 1rem; margin-top: 1rem; }
                h1 { font-size: clamp(2rem, 7vw, 3.6rem); margin: .5rem 0; }
            </style>
        @endif
    </head>
    <body>
        <div class="site-bg" aria-hidden="true"></div>

        <div class="page-shell">
            <header class="top-nav">
                <a href="/" class="brand">PAGER</a>
                <nav class="nav-links" aria-label="Primary navigation">
                    <a href="#kits">Care kits</a>
                    <a href="#story">Our story</a>
                    <a href="#community">Community</a>
                </nav>
                @if (Route::has('login'))
                    <div class="auth-links">
                        @auth
                            <a class="btn btn-ghost" href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a class="btn btn-ghost" href="{{ route('login') }}">Log in</a>
                            @if (Route::has('register'))
                                <a class="btn btn-primary" href="{{ route('register') }}">Sign up</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </header>

            <main>
                <section class="hero">
                    <div class="hero-copy">
                        <span class="badge">A gentle sample style for PAGER</span>
                        <h1>Parenting support, beautifully organized.</h1>
                        <p>
                            Inspired by warm stationery-style branding, this sample homepage shows how PAGER can feel friendly,
                            premium, and easy to trust—without copying any specific site.
                        </p>
                        <div class="actions">
                            <a href="#kits" class="btn btn-primary">Browse care kits</a>
                            <a href="#story" class="btn btn-ghost">Read our story</a>
                        </div>
                    </div>
                    <aside class="hero-panel">
                        <p class="panel-title">Starter Parenting Kit</p>
                        <div class="panel-row"><span>Daily tracker</span><strong>Included</strong></div>
                        <div class="panel-row"><span>Milestone journal</span><strong>Included</strong></div>
                        <div class="panel-row"><span>Expert tips</span><strong>Weekly</strong></div>
                    </aside>
                </section>

                <section id="kits" class="feature-grid">
                    <article class="card card-highlight">
                        <h2>New Parent Essentials</h2>
                        <p>Step-by-step guidance for feeding, sleep, routines, and emotional support.</p>
                    </article>
                    <article class="card">
                        <h2>Growth Milestone Bundle</h2>
                        <p>Age-based checklists and activities from infancy to early childhood.</p>
                    </article>
                    <article class="card">
                        <h2>Caregiver Wellness Notes</h2>
                        <p>Simple prompts and reminders to care for your own well-being, too.</p>
                    </article>
                </section>

                <section id="story" class="audience">
                    <h2>Designed for real families</h2>
                    <p>
                        PAGER supports expecting parents, first-time caregivers, solo parents, and busy households with practical,
                        personalized guidance that evolves over time.
                    </p>
                </section>

                <section id="community" class="roadmap">
                    <h2>What’s next for PAGER</h2>
                    <ul>
                        <li>Partnerships with early childhood experts.</li>
                        <li>Community circles for shared learning and support.</li>
                        <li>Privacy-first data practices for every family.</li>
                        <li>Global-ready content for diverse parenting cultures.</li>
                    </ul>
                </section>
            </main>
        </div>
    </body>
</html>
