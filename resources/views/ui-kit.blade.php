<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAGER UI Kit</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=mali:500,600,700|manjari:400,700" rel="stylesheet" />
    <style>
        :root {
            --sun: #ffdd8b;
            --cream: #f5f0e6;
            --lav: #d4bcff;
            --ink: #2a2140;
            --muted: #6d6088;
            --surface: #ffffff;
            --line: #e8e2f3;
            --brand: #6f55c9;
            --brand-2: #9577e8;
            --ok: #18a66f;
            --danger: #d95874;
            --shadow: 0 16px 34px rgba(44, 31, 76, 0.12);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Manjari", sans-serif;
            color: var(--ink);
            overflow-x: hidden;
            background:
                radial-gradient(circle at 10% 8%, rgba(255, 221, 139, 0.45), transparent 30%),
                radial-gradient(circle at 90% 14%, rgba(212, 188, 255, 0.42), transparent 34%),
                linear-gradient(180deg, #fffdf9, var(--cream));
            min-height: 100vh;
            padding: 1rem;
        }

        .container {
            width: min(1180px, 100%);
            margin: 0 auto;
        }

        .hero {
            padding: 1rem;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.75);
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 0.8rem;
        }

        .hero h1 { font-family: "Mali", sans-serif; font-size: clamp(1.5rem, 4vw, 2.4rem); }
        .hero p { color: var(--muted); }

        .link-btn {
            text-decoration: none;
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--ink);
            font-weight: 700;
            border-radius: 999px;
            padding: 0.52rem 0.9rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.8rem;
        }

        .block {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.82);
            box-shadow: 0 10px 24px rgba(54, 34, 92, 0.08);
            padding: 0.85rem;
        }

        .block h2 {
            font-family: "Mali", sans-serif;
            font-size: 1.1rem;
            margin-bottom: 0.6rem;
        }

        .row { display: flex; gap: 0.55rem; flex-wrap: wrap; align-items: center; }

        .btn {
            border: 0;
            border-radius: 12px;
            padding: 0.58rem 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover { transform: translateY(-2px); }

        .btn-primary {
            color: #fff;
            background: linear-gradient(120deg, var(--brand), var(--brand-2));
            box-shadow: 0 10px 18px rgba(111, 85, 201, 0.28);
        }

        .btn-outline {
            color: var(--brand);
            border: 1px solid #d8cbf5;
            background: #f8f4ff;
        }

        .btn-soft {
            color: var(--ink);
            background: linear-gradient(120deg, var(--sun), #ffe9bc);
        }

        .btn-danger {
            color: #922d41;
            background: rgba(217, 88, 116, 0.14);
            border: 1px solid rgba(217, 88, 116, 0.35);
        }

        .check {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-weight: 700;
            color: var(--ink);
        }

        .check input {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 1px solid #ccbaf4;
            border-radius: 5px;
            background: #fff;
            position: relative;
            cursor: pointer;
        }

        .check input:checked {
            background: var(--brand);
            border-color: var(--brand);
        }

        .check input:checked::after {
            content: "";
            position: absolute;
            left: 5px;
            top: 2px;
            width: 4px;
            height: 8px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            font-weight: 700;
        }

        .toggle input { display: none; }

        .toggle-pill {
            width: 52px;
            height: 30px;
            border-radius: 999px;
            background: #e8defd;
            border: 1px solid #d5c7f6;
            position: relative;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .toggle-pill::after {
            content: "";
            width: 22px;
            height: 22px;
            border-radius: 999px;
            background: #fff;
            position: absolute;
            top: 3px;
            left: 4px;
            transition: transform 0.2s ease;
        }

        .toggle input:checked + .toggle-pill { background: #bda1fb; }
        .toggle input:checked + .toggle-pill::after { transform: translateX(22px); }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.55rem;
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: linear-gradient(180deg, #fff, #faf7ff);
            padding: 0.7rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(85, 62, 141, 0.12); }

        .card h3 { font-family: "Mali", sans-serif; font-size: 0.98rem; }
        .card p { color: var(--muted); font-size: 0.88rem; }

        .loader {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 3px solid #e4dbfb;
            border-top-color: var(--brand);
            animation: spin 0.9s linear infinite;
        }

        .loader-dots {
            display: inline-flex;
            gap: 6px;
        }

        .loader-dots span {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--brand);
            animation: bounce 0.8s infinite alternate;
        }

        .loader-dots span:nth-child(2) { animation-delay: 0.15s; }
        .loader-dots span:nth-child(3) { animation-delay: 0.3s; }

        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes bounce { to { transform: translateY(-6px); opacity: 0.5; } }

        .input-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.55rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            border: 1px solid #d9cefa;
            border-radius: 10px;
            padding: 0.56rem 0.66rem;
            font-family: inherit;
            background: #fff;
            color: var(--ink);
        }

        textarea { min-height: 86px; resize: vertical; }

        .radio {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 700;
            color: var(--ink);
        }

        .radio input {
            appearance: none;
            width: 16px;
            height: 16px;
            border: 2px solid #ccbaf4;
            border-radius: 999px;
            position: relative;
            cursor: pointer;
        }

        .radio input:checked::after {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--brand);
            position: absolute;
            left: 2px;
            top: 2px;
        }

        .form {
            display: grid;
            gap: 0.55rem;
        }

        .form .submit {
            justify-self: start;
        }

        .patterns {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.55rem;
        }

        .pattern {
            height: 84px;
            border-radius: 10px;
            border: 1px solid var(--line);
        }

        .p1 {
            background:
                radial-gradient(circle at 20% 20%, rgba(111, 85, 201, 0.3), transparent 30%),
                #fff;
        }

        .p2 {
            background:
                repeating-linear-gradient(45deg, #f4efff 0 10px, #fff 10px 20px);
        }

        .p3 {
            background:
                linear-gradient(120deg, rgba(255,221,139,.55), rgba(212,188,255,.65));
        }

        @media (max-width: 980px) {
            .grid { grid-template-columns: 1fr; }
            .card-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 620px) {
            body { padding: 0.65rem; }
            .hero {
                align-items: flex-start;
            }
            .link-btn {
                width: 100%;
                text-align: center;
            }
            .row {
                align-items: stretch;
            }
            .row .btn {
                width: 100%;
            }
            .row .check,
            .row .toggle,
            .row .radio {
                width: 100%;
            }
            .input-row { grid-template-columns: 1fr; }
            .card-grid,
            .patterns { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="container">
    <section class="hero">
        <div>
            <h1>PAGER UI Kit</h1>
            <p>Uiverse-inspired components for fast, modern UI building.</p>
        </div>
        <a class="link-btn" href="{{ url('/') }}">Back to Website</a>
    </section>

    <section class="grid">
        <article class="block">
            <h2>Buttons</h2>
            <div class="row">
                <button class="btn btn-primary">Primary</button>
                <button class="btn btn-outline">Outline</button>
                <button class="btn btn-soft">Soft</button>
                <button class="btn btn-danger">Danger</button>
            </div>
        </article>

        <article class="block">
            <h2>Checkboxes</h2>
            <div class="row">
                <label class="check"><input type="checkbox" checked><span>Email Alerts</span></label>
                <label class="check"><input type="checkbox"><span>Push Notifications</span></label>
                <label class="check"><input type="checkbox" checked><span>Marketing</span></label>
            </div>
        </article>

        <article class="block">
            <h2>Toggle Switches</h2>
            <div class="row">
                <label class="toggle">
                    <input type="checkbox" checked>
                    <span class="toggle-pill"></span>
                    <span>Dark Mode</span>
                </label>
                <label class="toggle">
                    <input type="checkbox">
                    <span class="toggle-pill"></span>
                    <span>Auto Save</span>
                </label>
            </div>
        </article>

        <article class="block">
            <h2>Cards</h2>
            <div class="card-grid">
                <div class="card"><h3>Starter</h3><p>Basic features for small teams.</p></div>
                <div class="card"><h3>Growth</h3><p>Advanced tools and analytics.</p></div>
                <div class="card"><h3>Enterprise</h3><p>Full support and integrations.</p></div>
            </div>
        </article>

        <article class="block">
            <h2>Loaders</h2>
            <div class="row">
                <div class="loader" aria-label="Loading"></div>
                <div class="loader-dots" aria-label="Loading"><span></span><span></span><span></span></div>
            </div>
        </article>

        <article class="block">
            <h2>Inputs</h2>
            <div class="input-row">
                <input type="text" placeholder="Full name">
                <input type="email" placeholder="Email address">
                <input type="password" placeholder="Password">
                <select>
                    <option>Choose role</option>
                    <option>Admin</option>
                    <option>Editor</option>
                    <option>Viewer</option>
                </select>
            </div>
        </article>

        <article class="block">
            <h2>Radio Buttons</h2>
            <div class="row">
                <label class="radio"><input type="radio" name="plan" checked><span>Monthly</span></label>
                <label class="radio"><input type="radio" name="plan"><span>Yearly</span></label>
                <label class="radio"><input type="radio" name="plan"><span>Lifetime</span></label>
            </div>
        </article>

        <article class="block">
            <h2>Forms</h2>
            <form class="form" action="#" method="post" onsubmit="return false;">
                <input type="text" placeholder="Project name">
                <input type="email" placeholder="Owner email">
                <textarea placeholder="Project notes"></textarea>
                <button class="btn btn-primary submit" type="submit">Create Project</button>
            </form>
        </article>

        <article class="block" style="grid-column: 1 / -1;">
            <h2>Patterns</h2>
            <div class="patterns">
                <div class="pattern p1"></div>
                <div class="pattern p2"></div>
                <div class="pattern p3"></div>
            </div>
        </article>
    </section>
</div>
</body>
</html>
