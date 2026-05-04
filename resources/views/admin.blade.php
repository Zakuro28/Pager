<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — PAGER</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.2/lib/anime.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; }

        :root {
            --white:       #ffffff;
            --ink:         #111827;
            --sub:         #6b7280;
            --border:      #e5e7eb;
            --purple:      #7c3aed;
            --purple-dim:  #6d28d9;
            --purple-bg:   #f5f3ff;
            --purple-mid:  #ede9fe;
            --ok:          #16a34a;
            --ok-bg:       #f0fdf4;
            --danger:      #dc2626;
            --danger-bg:   #fef2f2;
            --danger-bdr:  #fecaca;
        }

        body {
            font-family: "Inter", system-ui, sans-serif;
            background: #f9fafb;
            color: var(--ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Nav ── */
        .nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            height: 56px;
        }

        .nav-brand {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .logo-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--purple); }

        .nav-badge {
            font-size: 0.7rem;
            font-weight: 600;
            background: var(--purple-mid);
            color: var(--purple);
            border-radius: 999px;
            padding: 0.15rem 0.5rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-links a {
            font-size: 0.825rem;
            font-weight: 500;
            color: var(--sub);
            text-decoration: none;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            transition: background 0.15s, color 0.15s;
        }

        .nav-links a:hover { background: #f3f4f6; color: var(--ink); }
        .nav-links a.active { background: var(--purple-bg); color: var(--purple); font-weight: 600; }

        .nav-return {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--sub);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.15s;
        }

        .nav-return:hover { color: var(--ink); }

        /* ── Page wrapper ── */
        .page {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 2rem 4rem;
        }

        /* ── Page header ── */
        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-header h1 {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .page-header p { font-size: 0.875rem; color: var(--sub); }

        /* ── Flash / errors ── */
        .flash {
            background: var(--ok-bg);
            border: 1px solid #bbf7d0;
            color: var(--ok);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
        }

        .errors {
            background: var(--danger-bg);
            border: 1px solid var(--danger-bdr);
            color: var(--danger);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }

        .errors ul { padding-left: 1.1rem; }

        /* ── Card base ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        /* ── KPI grid ── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .kpi-card {
            padding: 1.25rem 1.25rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .kpi-label {
            font-size: 0.775rem;
            font-weight: 600;
            color: var(--sub);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--ink);
            line-height: 1;
        }

        .kpi-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.5rem;
            border-top: 1px solid var(--border);
        }

        .kpi-tag {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
        }

        .kpi-tag.up { background: var(--ok-bg); color: var(--ok); }
        .kpi-tag.neutral { background: var(--purple-bg); color: var(--purple); }

        .kpi-link {
            font-size: 0.775rem;
            font-weight: 600;
            color: var(--purple);
            text-decoration: none;
        }

        .kpi-link:hover { text-decoration: underline; }

        /* ── Two-col analytics row ── */
        .analytics-row {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .card-pad { padding: 1.25rem; }

        .section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.25rem;
        }

        .section-sub {
            font-size: 0.775rem;
            color: var(--sub);
            margin-bottom: 1rem;
        }

        /* ── Bar chart ── */
        .bars {
            display: grid;
            grid-template-columns: repeat(8, minmax(0, 1fr));
            align-items: end;
            gap: 0.5rem;
            height: 200px;
            padding: 0.75rem 0 0.5rem;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fafafa;
        }

        .month { display: flex; flex-direction: column; align-items: center; gap: 0.3rem; }

        .pair {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 140px;
        }

        .bar-v, .bar-s {
            width: 10px;
            border-radius: 4px 4px 2px 2px;
            transform-origin: bottom;
            transform: scaleY(0);
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .bar-v { background: var(--purple); height: var(--v); }
        .bar-s { background: #d8b4fe; height: var(--s); }

        .bar-v.animated, .bar-s.animated { transform: scaleY(1); }

        .month label { color: var(--sub); font-size: 0.7rem; font-weight: 500; }

        .chart-legend {
            display: flex;
            gap: 1rem;
            margin-top: 0.75rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.775rem;
            color: var(--sub);
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 2px;
        }

        /* ── Performance rings ── */
        .rings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .ring-card {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #fafafa;
        }

        .ring {
            flex-shrink: 0;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: conic-gradient(var(--purple) calc(var(--pct) * 1%), var(--border) 0);
        }

        .ring-inner {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--white);
            display: grid;
            place-items: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--ink);
        }

        .ring-info h4 { font-size: 0.8rem; font-weight: 600; color: var(--ink); margin-bottom: 0.1rem; }
        .ring-info p { font-size: 0.725rem; color: var(--sub); }

        /* ── Account management ── */
        .manage-row {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .add-form { display: grid; gap: 0.75rem; }

        .form-field label {
            display: block;
            font-size: 0.775rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 0.3rem;
        }

        .form-field input {
            width: 100%;
            padding: 0.55rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 7px;
            font-family: "Inter", sans-serif;
            font-size: 0.875rem;
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-field input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .form-field input::placeholder { color: #9ca3af; }

        .btn-primary {
            width: 100%;
            padding: 0.625rem 1rem;
            background: var(--purple);
            color: var(--white);
            border: none;
            border-radius: 7px;
            font-family: "Inter", sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s, transform 0.12s;
        }

        .btn-primary:hover { background: var(--purple-dim); transform: translateY(-1px); }

        /* ── Users table ── */
        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        th, td {
            text-align: left;
            padding: 0.625rem 0.875rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        th {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--sub);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #f9fafb;
        }

        th:first-child { border-radius: 8px 0 0 0; }
        th:last-child { border-radius: 0 8px 0 0; }

        td { color: var(--ink); }

        tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            font-size: 0.725rem;
            font-weight: 600;
        }

        .badge-ok { background: var(--ok-bg); color: var(--ok); }
        .badge-no { background: var(--danger-bg); color: var(--danger); }

        .btn-remove {
            background: none;
            border: 1px solid var(--danger-bdr);
            color: var(--danger);
            border-radius: 6px;
            padding: 0.3rem 0.65rem;
            font-family: "Inter", sans-serif;
            font-size: 0.775rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-remove:hover { background: var(--danger-bg); }

        .empty-row { color: var(--sub); font-style: italic; }

        /* ── Recent users panel (bottom strip) ── */
        .users-strip {
            margin-bottom: 1.25rem;
        }

        .users-strip-inner {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem 0.5rem 0.5rem;
            background: var(--purple-bg);
            border: 1px solid var(--purple-mid);
            border-radius: 999px;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--purple-mid);
            display: grid;
            place-items: center;
            font-size: 0.725rem;
            font-weight: 700;
            color: var(--purple);
            flex-shrink: 0;
        }

        .user-chip-name { font-size: 0.8rem; font-weight: 600; color: var(--ink); }
        .user-chip-email { font-size: 0.725rem; color: var(--sub); }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .analytics-row { grid-template-columns: 1fr; }
            .manage-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .page { padding: 1.25rem 1rem 3rem; }
            .nav { padding: 0 1rem; }
            .nav-links { display: none; }
            .kpi-grid { grid-template-columns: 1fr 1fr; }
            .bars { overflow-x: auto; }
            .rings-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 400px) {
            .kpi-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- Nav -->
<nav class="nav" id="adminNav">
    <a class="nav-brand" href="/"><span class="logo-dot"></span> PAGER <span class="nav-badge">Admin</span></a>

    <div class="nav-links">
        <a class="active" href="{{ route('admin.index') }}">Dashboard</a>
        <a href="#manage">Users</a>
    </div>

    <a class="nav-return" href="{{ url('/') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Back to website
    </a>
</nav>

<div class="page">

    <!-- Header -->
    <div class="page-header" id="pageHeader">
        <h1>Admin Dashboard</h1>
        <p>Manage accounts, monitor growth, and review platform health.</p>
    </div>

    <!-- Flash / errors -->
    @if (session('status'))
        <div class="flash">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">
            <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <!-- KPI cards -->
    <div class="kpi-grid" id="kpiGrid">
        <div class="card kpi-card">
            <div class="kpi-label">Total Accounts</div>
            <div class="kpi-value">{{ $stats['total_users'] }}</div>
            <div class="kpi-footer">
                <span class="kpi-tag up">All time</span>
                <a class="kpi-link" href="#manage">View →</a>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-label">New This Week</div>
            <div class="kpi-value">{{ $stats['new_users_7d'] }}</div>
            <div class="kpi-footer">
                <span class="kpi-tag neutral">Last 7 days</span>
                <a class="kpi-link" href="#manage">View →</a>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-label">Verified</div>
            <div class="kpi-value">{{ $stats['verified_users'] }}</div>
            <div class="kpi-footer">
                <span class="kpi-tag up">{{ $stats['verified_rate'] }}% rate</span>
                <a class="kpi-link" href="#manage">View →</a>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-label">Unverified</div>
            <div class="kpi-value">{{ $stats['unverified_users'] }}</div>
            <div class="kpi-footer">
                <span class="kpi-tag neutral">Pending</span>
                <a class="kpi-link" href="#manage">View →</a>
            </div>
        </div>
    </div>

    <!-- Analytics row -->
    <div class="analytics-row" id="analyticsRow">
        <!-- Bar chart -->
        <div class="card card-pad">
            <div class="section-title">User Growth</div>
            <div class="section-sub">Monthly signups vs. active sessions (simulated)</div>
            <div class="bars" id="barChart">
                <div class="month"><div class="pair"><span class="bar-v" style="--v:60%;"></span><span class="bar-s" style="--s:40%;"></span></div><label>Jan</label></div>
                <div class="month"><div class="pair"><span class="bar-v" style="--v:68%;"></span><span class="bar-s" style="--s:52%;"></span></div><label>Feb</label></div>
                <div class="month"><div class="pair"><span class="bar-v" style="--v:88%;"></span><span class="bar-s" style="--s:60%;"></span></div><label>Mar</label></div>
                <div class="month"><div class="pair"><span class="bar-v" style="--v:50%;"></span><span class="bar-s" style="--s:38%;"></span></div><label>Apr</label></div>
                <div class="month"><div class="pair"><span class="bar-v" style="--v:47%;"></span><span class="bar-s" style="--s:52%;"></span></div><label>May</label></div>
                <div class="month"><div class="pair"><span class="bar-v" style="--v:69%;"></span><span class="bar-s" style="--s:56%;"></span></div><label>Jun</label></div>
                <div class="month"><div class="pair"><span class="bar-v" style="--v:64%;"></span><span class="bar-s" style="--s:48%;"></span></div><label>Jul</label></div>
                <div class="month"><div class="pair"><span class="bar-v" style="--v:73%;"></span><span class="bar-s" style="--s:57%;"></span></div><label>Aug</label></div>
            </div>
            <div class="chart-legend">
                <div class="legend-item"><span class="legend-dot" style="background:var(--purple);"></span> Signups</div>
                <div class="legend-item"><span class="legend-dot" style="background:#d8b4fe;"></span> Sessions</div>
            </div>
        </div>

        <!-- Performance rings -->
        <div class="card card-pad">
            <div class="section-title">Performance Breakdown</div>
            <div class="section-sub">Account health metrics</div>
            <div class="rings-grid">
                <div class="ring-card">
                    <div class="ring" style="--pct:{{ $stats['verified_rate'] }};"><div class="ring-inner">{{ $stats['verified_rate'] }}%</div></div>
                    <div class="ring-info"><h4>Verified Rate</h4><p>Account trust health</p></div>
                </div>
                <div class="ring-card">
                    <div class="ring" style="--pct:{{ $stats['new_user_rate'] }};"><div class="ring-inner">{{ $stats['new_user_rate'] }}%</div></div>
                    <div class="ring-info"><h4>New User Share</h4><p>7-day growth</p></div>
                </div>
                <div class="ring-card">
                    <div class="ring" style="--pct:{{ $stats['unverified_rate'] }};"><div class="ring-inner">{{ $stats['unverified_rate'] }}%</div></div>
                    <div class="ring-info"><h4>Unverified Share</h4><p>Needs activation</p></div>
                </div>
                <div class="ring-card">
                    <div class="ring" style="--pct:{{ 100 - $stats['unverified_rate'] }};"><div class="ring-inner">{{ 100 - $stats['unverified_rate'] }}%</div></div>
                    <div class="ring-info"><h4>Active Footprint</h4><p>Overall engagement</p></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account management -->
    <div class="manage-row" id="manage">
        <!-- Add account form -->
        <div class="card card-pad">
            <div class="section-title">Add Account</div>
            <div class="section-sub">Create a new user manually</div>
            <form class="add-form" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="form-field">
                    <label>Full name</label>
                    <input type="text" name="name" placeholder="Maria Santos" value="{{ old('name') }}" required>
                </div>
                <div class="form-field">
                    <label>Email address</label>
                    <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required>
                </div>
                <div class="form-field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="At least 8 characters" required minlength="8">
                </div>
                <button class="btn-primary" type="submit">Add Account</button>
            </form>
        </div>

        <!-- Users table -->
        <div class="card">
            <div class="card-pad" style="border-bottom:1px solid var(--border); padding-bottom:0.875rem;">
                <div class="section-title">All Accounts</div>
                <div class="section-sub" style="margin-bottom:0;">{{ $stats['total_users'] }} users registered</div>
            </div>
            <div class="table-wrap">
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
                                <td style="font-weight:500;">{{ $user->name }}</td>
                                <td style="color:var(--sub);">{{ $user->email }}</td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge badge-ok">Verified</span>
                                    @else
                                        <span class="badge badge-no">Unverified</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Remove this account?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-remove" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-row">No accounts found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent users strip -->
    @if ($users->count())
    <div class="users-strip card" id="usersStrip">
        <div class="card-pad" style="padding-bottom:0.5rem;">
            <div class="section-title">Recent Members</div>
        </div>
        <div class="users-strip-inner">
            @foreach ($users->take(8) as $user)
                <div class="user-chip">
                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div>
                        <div class="user-chip-name">{{ $user->name }}</div>
                        <div class="user-chip-email">{{ $user->email }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script>
// Page entrance
anime.timeline({ easing: 'easeOutExpo' })
    .add({ targets: '#adminNav', opacity: [0, 1], translateY: [-8, 0], duration: 500 })
    .add({ targets: '#pageHeader', opacity: [0, 1], translateY: [12, 0], duration: 500 }, '-=300')
    .add({ targets: '#kpiGrid .card', opacity: [0, 1], translateY: [16, 0], delay: anime.stagger(80), duration: 500 }, '-=200')
    .add({ targets: '#analyticsRow > .card', opacity: [0, 1], translateY: [16, 0], delay: anime.stagger(100), duration: 500 }, '-=200')
    .add({ targets: '#manage > .card', opacity: [0, 1], translateY: [16, 0], delay: anime.stagger(100), duration: 500 }, '-=100')
    .add({ targets: '#usersStrip', opacity: [0, 1], translateY: [12, 0], duration: 400 }, '-=100');

// Animate bars after load
setTimeout(function () {
    document.querySelectorAll('.bar-v, .bar-s').forEach(function(b, i) {
        setTimeout(function() { b.classList.add('animated'); }, i * 50);
    });
}, 600);
</script>
</body>
</html>
