<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAGER Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=mali:500,600,700|manjari:400,700" rel="stylesheet" />
    <style>
        :root {
            --bg: #f5f0e6;
            --surface: #ffffff;
            --surface-soft: #f7f9fd;
            --line: #e6eaf3;
            --ink: #1f2740;
            --muted: #7a859f;
            --brand: #2f80ed;
            --brand-2: #d4bcff;
            --ok: #22a06b;
            --warn: #f08b32;
            --danger: #d64562;
            --shadow: 0 16px 34px rgba(19, 41, 74, 0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Manjari", sans-serif;
            color: var(--ink);
            overflow-x: hidden;
            background:
                radial-gradient(circle at 8% 10%, rgba(212, 188, 255, 0.35), transparent 26%),
                radial-gradient(circle at 92% 8%, rgba(47, 128, 237, 0.16), transparent 22%),
                linear-gradient(180deg, #faf8f2 0%, var(--bg) 100%);
            min-height: 100vh;
            padding: 1rem;
        }

        .dashboard {
            width: min(1320px, 100%);
            margin: 0 auto;
            padding: 0.9rem;
            border: 1px solid #eceff6;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.62);
            box-shadow: var(--shadow);
            display: grid;
            grid-template-columns: 224px 1fr 300px;
            gap: 0.85rem;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(22, 43, 71, 0.04);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .panel:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(22, 43, 71, 0.08);
            border-color: #dce4f3;
        }

        .sidebar {
            padding: 0.85rem;
            display: flex;
            flex-direction: column;
            min-height: 780px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            margin-bottom: 1rem;
            font-family: "Mali", sans-serif;
            font-weight: 700;
        }

        .logo-dot {
            width: 11px;
            height: 11px;
            border-radius: 999px;
            background: radial-gradient(circle at 30% 30%, #88b7ff, var(--brand));
            box-shadow: 9px 0 0 #bdd8ff, 4px 8px 0 #5ea2ff;
        }

        .menu { display: grid; gap: 0.45rem; }

        .menu a {
            text-decoration: none;
            color: var(--muted);
            font-weight: 700;
            font-size: 0.94rem;
            padding: 0.62rem 0.72rem;
            border-radius: 10px;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .menu a:hover { transform: translateX(3px); }

        .menu a.active {
            background: var(--brand);
            color: #fff;
        }

        .menu-title {
            margin: 0.95rem 0 0.45rem;
            font-family: "Mali", sans-serif;
            font-size: 0.95rem;
        }

        .sidebar-bottom { margin-top: auto; }

        .main {
            display: grid;
            gap: 0.85rem;
            align-content: start;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.65rem;
        }

        .kpi {
            padding: 0.78rem;
            position: relative;
            overflow: hidden;
        }

        .kpi::before {
            content: "";
            position: absolute;
            inset: auto -18px -18px auto;
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212, 188, 255, 0.42), transparent 66%);
        }

        .kpi strong {
            display: block;
            font-family: "Mali", sans-serif;
            font-size: 1.42rem;
            line-height: 1.05;
        }

        .kpi small { color: var(--muted); font-weight: 700; }

        .kpi-row {
            margin-top: 0.48rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-mini {
            text-decoration: none;
            border-radius: 8px;
            background: var(--brand);
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 0.28rem 0.55rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-mini:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(47, 128, 237, 0.3);
        }

        .up { color: var(--ok); font-weight: 700; font-size: 0.82rem; }
        .down { color: var(--danger); font-weight: 700; font-size: 0.82rem; }

        .card { padding: 0.9rem; }

        .title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.45rem;
            margin-bottom: 0.75rem;
        }

        .title-row h2, .title-row h3 {
            font-family: "Mali", sans-serif;
            font-size: 1.06rem;
        }

        .legend {
            display: inline-flex;
            gap: 0.6rem;
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 700;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 3px;
            display: inline-block;
            margin-right: 0.25rem;
        }

        .bars {
            display: grid;
            grid-template-columns: repeat(8, minmax(0, 1fr));
            align-items: end;
            gap: 0.45rem;
            height: 225px;
            padding: 0.55rem 0.35rem 0.25rem;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: linear-gradient(180deg, #fbfcff, #f6f8fd);
        }

        .month { display: grid; justify-items: center; gap: 0.3rem; }

        .pair {
            width: 30px;
            height: 176px;
            display: flex;
            align-items: flex-end;
            gap: 4px;
        }

        .bar-v, .bar-s {
            width: 12px;
            border-radius: 5px 5px 3px 3px;
            transform-origin: bottom;
            animation: rise 0.8s ease both;
        }

        .bar-v { background: linear-gradient(180deg, #63abff, #2f80ed); height: var(--v); }
        .bar-s { background: linear-gradient(180deg, #ffac74, #ff8b57); height: var(--s); animation-delay: 0.08s; }

        @keyframes rise {
            from { transform: scaleY(0.1); opacity: 0.3; }
            to { transform: scaleY(1); opacity: 1; }
        }

        .month label { color: var(--muted); font-size: 0.76rem; font-weight: 700; }

        .analytics-grid {
            display: grid;
            grid-template-columns: 1.25fr 0.9fr;
            gap: 0.75rem;
        }

        .progress-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.6rem;
        }

        .progress {
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--surface-soft);
            padding: 0.65rem;
            display: grid;
            grid-template-columns: 68px 1fr;
            gap: 0.55rem;
            align-items: center;
        }

        .ring {
            width: 58px;
            height: 58px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: conic-gradient(var(--brand) calc(var(--pct) * 1%), #e9edf6 0);
        }

        .ring span {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            background: #fff;
            display: grid;
            place-items: center;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--ink);
        }

        .progress h4 {
            font-family: "Mali", sans-serif;
            font-size: 0.92rem;
            margin-bottom: 0.08rem;
        }

        .progress p { color: var(--muted); font-size: 0.8rem; }

        .mini-map {
            border: 1px solid var(--line);
            border-radius: 10px;
            background: linear-gradient(180deg, #f7f9ff, #f3f6fc);
            min-height: 146px;
            position: relative;
            overflow: hidden;
        }

        .mini-map::before,
        .mini-map::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            background: rgba(47, 128, 237, 0.15);
        }

        .mini-map::before { width: 220px; height: 120px; left: -40px; top: 28px; }
        .mini-map::after { width: 180px; height: 90px; right: -30px; bottom: 20px; }

        .map-chip {
            position: absolute;
            right: 12px;
            top: 14px;
            border-radius: 10px;
            background: var(--brand);
            color: #fff;
            padding: 0.52rem 0.62rem;
            font-weight: 700;
            font-size: 0.82rem;
            box-shadow: 0 10px 18px rgba(47, 128, 237, 0.32);
        }

        .manage {
            display: grid;
            grid-template-columns: 1fr 1.35fr;
            gap: 0.75rem;
        }

        .box {
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--surface-soft);
            padding: 0.65rem;
        }

        .box form { display: grid; gap: 0.5rem; }

        input {
            width: 100%;
            border: 1px solid #dce3f0;
            border-radius: 8px;
            padding: 0.54rem 0.6rem;
            font-family: inherit;
        }

        .btn {
            border: 0;
            border-radius: 8px;
            background: var(--brand);
            color: #fff;
            font-weight: 700;
            padding: 0.55rem 0.7rem;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover { transform: translateY(-1px); box-shadow: 0 8px 16px rgba(47, 128, 237, 0.3); }

        .btn-danger {
            border: 1px solid rgba(214, 69, 98, 0.28);
            border-radius: 7px;
            background: rgba(214, 69, 98, 0.12);
            color: #8f2d42;
            padding: 0.34rem 0.58rem;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .btn-danger:hover { transform: translateY(-1px); }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }

        th, td {
            text-align: left;
            padding: 0.42rem;
            border-bottom: 1px solid #e5ebf6;
            vertical-align: middle;
        }

        th {
            color: var(--muted);
            font-family: "Mali", sans-serif;
            font-size: 0.82rem;
        }

        .badge {
            display: inline-flex;
            padding: 0.16rem 0.45rem;
            border-radius: 999px;
            font-size: 0.74rem;
            font-weight: 700;
        }

        .ok { background: rgba(34, 160, 107, 0.14); color: var(--ok); }
        .no { background: rgba(214, 69, 98, 0.14); color: var(--danger); }

        .right {
            display: grid;
            gap: 0.75rem;
            align-content: start;
        }

        .widget { padding: 0.8rem; }

        .profile {
            text-align: center;
            padding-top: 1rem;
        }

        .avatar {
            width: 58px;
            height: 58px;
            margin: 0 auto 0.48rem;
            border-radius: 999px;
            border: 3px solid #fff;
            background: linear-gradient(120deg, #ffd88a, #d4bcff);
            box-shadow: 0 10px 20px rgba(50, 62, 96, 0.16);
        }

        .profile h3 { font-family: "Mali", sans-serif; }
        .profile p { color: var(--muted); font-size: 0.86rem; }

        .list {
            margin-top: 0.55rem;
            display: grid;
            gap: 0.55rem;
        }

        .user-row {
            display: grid;
            grid-template-columns: 34px 1fr;
            gap: 0.5rem;
            align-items: center;
        }

        .dot-avatar {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: linear-gradient(120deg, #b5d2ff, #d4bcff);
        }

        .user-row strong { display: block; font-size: 0.9rem; }
        .user-row span { color: var(--muted); font-size: 0.78rem; }

        .spark {
            margin-top: 0.65rem;
            height: 62px;
            border: 1px solid var(--line);
            border-radius: 9px;
            background:
                linear-gradient(180deg, rgba(47, 128, 237, 0.14), rgba(47, 128, 237, 0.02)),
                repeating-linear-gradient(90deg, transparent 0 18px, rgba(47, 128, 237, 0.07) 18px 20px);
            position: relative;
            overflow: hidden;
        }

        .spark::after {
            content: "";
            position: absolute;
            left: -10%;
            top: 52%;
            width: 120%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #2f80ed, transparent);
            transform: rotate(-8deg);
            animation: sweep 3s linear infinite;
        }

        @keyframes sweep {
            from { transform: translateX(-14%) rotate(-8deg); }
            to { transform: translateX(14%) rotate(-8deg); }
        }

        .flash {
            border: 1px solid rgba(34, 160, 107, 0.3);
            background: rgba(34, 160, 107, 0.1);
            color: #1b7150;
            border-radius: 9px;
            padding: 0.5rem 0.62rem;
            font-size: 0.88rem;
            font-weight: 700;
        }

        .errors {
            border: 1px solid rgba(214, 69, 98, 0.3);
            background: rgba(214, 69, 98, 0.1);
            color: #8f2d42;
            border-radius: 9px;
            padding: 0.5rem 0.62rem;
            font-size: 0.84rem;
        }

        .errors ul { padding-left: 1rem; }

        .stagger {
            opacity: 0;
            transform: translateY(8px);
            animation: reveal 0.55s ease forwards;
        }

        @keyframes reveal {
            to { opacity: 1; transform: translateY(0); }
        }

        .d1 { animation-delay: 0.04s; }
        .d2 { animation-delay: 0.08s; }
        .d3 { animation-delay: 0.12s; }
        .d4 { animation-delay: 0.16s; }

        @media (max-width: 1240px) {
            .dashboard { grid-template-columns: 208px 1fr; }
            .right { grid-column: 1 / -1; grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }

        @media (max-width: 992px) {
            .dashboard { grid-template-columns: 1fr; }
            .dashboard { padding: 0.65rem; }
            .sidebar {
                min-height: auto;
                gap: 0.6rem;
            }
            .sidebar .menu {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .sidebar-bottom {
                margin-top: 0.35rem;
            }
            .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .analytics-grid { grid-template-columns: 1fr; }
            .manage { grid-template-columns: 1fr; }
            .right { grid-template-columns: 1fr; }
        }

        @media (max-width: 700px) {
            body { padding: 0.6rem; }
            .dashboard { padding: 0.5rem; }
            .card { padding: 0.7rem; }
            .sidebar .menu {
                grid-template-columns: 1fr;
            }
            .kpi-grid { grid-template-columns: 1fr; }
            .kpi-row {
                gap: 0.4rem;
                flex-wrap: wrap;
            }
            .bars { overflow-x: auto; display: flex; gap: 0.72rem; }
            .month { min-width: 44px; }
            .box { overflow-x: auto; }
            table { min-width: 520px; }
            .progress-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="dashboard">
    <aside class="panel sidebar stagger d1">
        <div class="brand"><span class="logo-dot"></span><span>Adminin</span></div>

        <nav class="menu">
            <a class="active" href="{{ route('admin.index') }}">Dashboard</a>
            <a href="#">Products</a>
            <a href="#">Users</a>
            <a href="#">Reports</a>
        </nav>

        <p class="menu-title">Products</p>
        <nav class="menu">
            <a href="#">Calendar</a>
            <a href="#">Gallery</a>
            <a href="#">Mailbox</a>
            <a href="#">Pages</a>
            <a href="#">Extras</a>
        </nav>

        <div class="sidebar-bottom menu">
            <a href="{{ url('/') }}">Website</a>
            <a href="#">Settings</a>
        </div>
    </aside>

    <section class="main">
        @if (session('status'))
            <div class="flash stagger d1">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors stagger d1">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="kpi-grid">
            <article class="panel kpi stagger d1">
                <strong>{{ $stats['total_users'] }}</strong>
                <small>Total Accounts</small>
                <div class="kpi-row"><a class="btn-mini" href="#manage">View</a><span class="up">+6.5%</span></div>
            </article>
            <article class="panel kpi stagger d2">
                <strong>{{ $stats['new_users_7d'] }}</strong>
                <small>New Users</small>
                <div class="kpi-row"><a class="btn-mini" href="#manage">View</a><span class="down">-1.2%</span></div>
            </article>
            <article class="panel kpi stagger d3">
                <strong>{{ $stats['unverified_users'] }}</strong>
                <small>Unverified</small>
                <div class="kpi-row"><a class="btn-mini" href="#manage">View</a><span class="up">+2.1%</span></div>
            </article>
            <article class="panel kpi stagger d4">
                <strong>{{ $stats['verified_users'] }}</strong>
                <small>Verified</small>
                <div class="kpi-row"><a class="btn-mini" href="#manage">View</a><span class="down">-0.8%</span></div>
            </article>
        </div>

        <article class="panel card stagger d2">
            <div class="title-row">
                <h2>Sales Analytics</h2>
                <div class="legend">
                    <span><i class="dot" style="background:#4a94ff;"></i>Visitors</span>
                    <span><i class="dot" style="background:#ff8b57;"></i>Sales</span>
                </div>
            </div>

            <div class="bars">
                <div class="month"><div class="pair" style="--v:60%; --s:40%;"><span class="bar-v"></span><span class="bar-s"></span></div><label>Jan</label></div>
                <div class="month"><div class="pair" style="--v:68%; --s:52%;"><span class="bar-v"></span><span class="bar-s"></span></div><label>Feb</label></div>
                <div class="month"><div class="pair" style="--v:88%; --s:60%;"><span class="bar-v"></span><span class="bar-s"></span></div><label>Mar</label></div>
                <div class="month"><div class="pair" style="--v:50%; --s:38%;"><span class="bar-v"></span><span class="bar-s"></span></div><label>Apr</label></div>
                <div class="month"><div class="pair" style="--v:47%; --s:52%;"><span class="bar-v"></span><span class="bar-s"></span></div><label>May</label></div>
                <div class="month"><div class="pair" style="--v:69%; --s:56%;"><span class="bar-v"></span><span class="bar-s"></span></div><label>Jun</label></div>
                <div class="month"><div class="pair" style="--v:64%; --s:48%;"><span class="bar-v"></span><span class="bar-s"></span></div><label>Jul</label></div>
                <div class="month"><div class="pair" style="--v:73%; --s:57%;"><span class="bar-v"></span><span class="bar-s"></span></div><label>Aug</label></div>
            </div>
        </article>

        <div class="analytics-grid">
            <article class="panel card stagger d3">
                <div class="title-row">
                    <h3>Performance Breakdown</h3>
                    <span style="color:var(--muted); font-weight:700; font-size:0.84rem;">Auto-updated</span>
                </div>
                <div class="progress-grid">
                    <div class="progress">
                        <div class="ring" style="--pct: {{ $stats['verified_rate'] }};"><span>{{ $stats['verified_rate'] }}%</span></div>
                        <div><h4>Verified Rate</h4><p>Account trust health</p></div>
                    </div>
                    <div class="progress">
                        <div class="ring" style="--pct: {{ $stats['new_user_rate'] }};"><span>{{ $stats['new_user_rate'] }}%</span></div>
                        <div><h4>New User Share</h4><p>Last 7 days growth</p></div>
                    </div>
                    <div class="progress">
                        <div class="ring" style="--pct: {{ $stats['unverified_rate'] }};"><span>{{ $stats['unverified_rate'] }}%</span></div>
                        <div><h4>Unverified Share</h4><p>Needs activation</p></div>
                    </div>
                    <div class="progress">
                        <div class="ring" style="--pct: {{ 100 - $stats['unverified_rate'] }};"><span>{{ 100 - $stats['unverified_rate'] }}%</span></div>
                        <div><h4>Active Footprint</h4><p>Overall engagement</p></div>
                    </div>
                </div>
            </article>

            <article class="panel card stagger d4">
                <div class="title-row">
                    <h3>Visitor Region Snapshot</h3>
                    <span style="color:var(--muted); font-weight:700; font-size:0.84rem;">This month</span>
                </div>
                <div class="mini-map">
                    <span class="map-chip">USA 43.2k</span>
                </div>
            </article>
        </div>

        <article class="panel card stagger d4" id="manage">
            <div class="title-row">
                <h3>Account Management</h3>
                <span style="color:var(--muted); font-weight:700;">Add and remove users</span>
            </div>

            <div class="manage">
                <div class="box">
                    <h3 style="margin-bottom:.45rem; font-size:1rem; font-family:'Mali',sans-serif;">Add Account</h3>
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <input type="text" name="name" placeholder="Full name" value="{{ old('name') }}" required>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        <input type="password" name="password" placeholder="Password (min 8)" required minlength="8">
                        <button class="btn" type="submit">Add Account</button>
                    </form>
                </div>

                <div class="box">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="badge ok">Verified</span>
                                        @else
                                            <span class="badge no">Unverified</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Remove this account?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger" type="submit">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="color:var(--muted);">No accounts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </section>

    <aside class="right">
        <article class="panel widget profile stagger d2">
            <div class="avatar"></div>
            <h3>Admin User</h3>
            <p>@pageradmin</p>
        </article>

        <article class="panel widget stagger d3">
            <h3 style="font-family:'Mali',sans-serif;">New Customers</h3>
            <div class="list">
                @foreach ($users->take(5) as $user)
                    <div class="user-row">
                        <span class="dot-avatar"></span>
                        <div>
                            <strong>{{ $user->name }}</strong>
                            <span>{{ '@' . explode('@', $user->email)[0] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="btn-mini" href="#manage" style="display:inline-block; margin-top:.7rem;">View More</a>
        </article>

        <article class="panel widget stagger d4">
            <h3 style="font-family:'Mali',sans-serif;">Store Visit</h3>
            <div style="margin-top:.45rem; display:grid; gap:.38rem; color:var(--ink); font-weight:700;">
                <div style="display:flex; justify-content:space-between;"><span>America</span><span>{{ $stats['total_users'] + 120 }}</span></div>
                <div style="display:flex; justify-content:space-between;"><span>Europe</span><span>{{ $stats['verified_users'] + 80 }}</span></div>
                <div style="display:flex; justify-content:space-between;"><span>Asia</span><span>{{ $stats['new_users_7d'] + 60 }}</span></div>
            </div>
            <div class="spark"></div>
        </article>
    </aside>
</div>
</body>
</html>
