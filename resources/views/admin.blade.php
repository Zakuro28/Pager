<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — PAGER</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.2/lib/anime.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; }

        :root {
            --white:       #ffffff;
            --bg:          #f8f7ff;
            --ink:         #111827;
            --sub:         #6b7280;
            --border:      #e5e7eb;
            --purple:      #7c3aed;
            --purple-dim:  #6d28d9;
            --purple-bg:   #f5f3ff;
            --purple-mid:  #ede9fe;
            --purple-lite: #ddd6fe;
            --ok:          #16a34a;
            --ok-bg:       #f0fdf4;
            --ok-bdr:      #bbf7d0;
            --danger:      #dc2626;
            --danger-bg:   #fef2f2;
            --danger-bdr:  #fecaca;
            --amber:       #d97706;
            --amber-bg:    #fffbeb;
        }

        body {
            font-family: "Inter", system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Nav ── */
        .nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            height: 58px;
            opacity: 0;
        }

        .nav-brand {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--ink);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.02em;
        }

        .nav-brand img { height: 28px; width: auto; }

        .nav-badge {
            font-size: 0.68rem;
            font-weight: 700;
            background: var(--purple-mid);
            color: var(--purple);
            border-radius: 999px;
            padding: 0.15rem 0.55rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-center a {
            font-size: 0.825rem;
            font-weight: 500;
            color: var(--sub);
            text-decoration: none;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            transition: background 0.15s, color 0.15s;
        }

        .nav-center a:hover { background: #f3f4f6; color: var(--ink); }
        .nav-center a.active { background: var(--purple-bg); color: var(--purple); font-weight: 600; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .live-clock {
            font-size: 0.775rem;
            font-weight: 600;
            color: var(--sub);
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.02em;
        }

        .pulse-dot {
            display: inline-block;
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--ok);
            animation: pulse-live 2s ease-in-out infinite;
            margin-right: 0.35rem;
            vertical-align: middle;
        }

        @keyframes pulse-live {
            0%, 100% { box-shadow: 0 0 0 0 rgba(22,163,74,0.5); }
            50%       { box-shadow: 0 0 0 5px rgba(22,163,74,0); }
        }

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

        @media (max-width: 640px) { .nav { padding: 0 1rem; } .nav-center, .live-clock { display: none; } }

        /* ── Page ── */
        .page {
            max-width: 1320px;
            margin: 0 auto;
            padding: 2rem 2rem 4rem;
        }

        @media (max-width: 640px) { .page { padding: 1.25rem 1rem 3rem; } }

        /* ── Page header ── */
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            opacity: 0;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
        }

        .page-header p { font-size: 0.875rem; color: var(--sub); }

        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--ok);
            background: var(--ok-bg);
            border: 1px solid var(--ok-bdr);
            border-radius: 999px;
            padding: 0.3rem 0.75rem;
        }

        /* ── Flash ── */
        .flash {
            background: var(--ok-bg);
            border: 1px solid var(--ok-bdr);
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
            border-radius: 14px;
            transition: box-shadow 0.2s;
        }

        .card:hover { box-shadow: 0 4px 24px rgba(0,0,0,0.05); }

        /* ── KPI grid ── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 1024px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 400px)  { .kpi-grid { grid-template-columns: 1fr; } }

        .kpi-card {
            padding: 1.375rem 1.375rem 1.125rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .kpi-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--purple), #a78bfa);
            border-radius: 14px 14px 0 0;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .kpi-card:hover::after { transform: scaleX(1); }

        .kpi-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--sub);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .kpi-value {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--purple);
            line-height: 1;
            font-variant-numeric: tabular-nums;
        }

        .kpi-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.625rem;
            border-top: 1px solid var(--border);
        }

        .kpi-tag {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
        }

        .kpi-tag.up      { background: var(--ok-bg);      color: var(--ok); }
        .kpi-tag.neutral { background: var(--purple-bg);  color: var(--purple); }
        .kpi-tag.warn    { background: var(--amber-bg);   color: var(--amber); }

        .kpi-link {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--purple);
            text-decoration: none;
            transition: opacity 0.15s;
        }

        .kpi-link:hover { opacity: 0.7; }

        /* ── Analytics row ── */
        .analytics-row {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 1024px) { .analytics-row { grid-template-columns: 1fr; } }

        .card-pad { padding: 1.375rem; }

        .section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.2rem;
            letter-spacing: -0.01em;
        }

        .section-sub {
            font-size: 0.775rem;
            color: var(--sub);
            margin-bottom: 1.25rem;
        }

        /* ── SVG Bar chart ── */
        .chart-container {
            position: relative;
            width: 100%;
            height: 200px;
            background: #fafafa;
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            padding: 1rem 1rem 2.5rem;
        }

        .chart-svg {
            width: 100%;
            height: 100%;
            overflow: visible;
        }

        .chart-grid-line {
            stroke: var(--border);
            stroke-width: 1;
            stroke-dasharray: 4 4;
        }

        .bar-signup { fill: var(--purple); rx: 3; }
        .bar-session { fill: #c4b5fd; rx: 3; }

        .bar-group rect {
            transform-origin: bottom;
            transform-box: fill-box;
        }

        .bar-label {
            font-family: "Inter", sans-serif;
            font-size: 10px;
            fill: var(--sub);
            text-anchor: middle;
        }

        .chart-legend {
            display: flex;
            gap: 1rem;
            margin-top: 0.875rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.775rem;
            color: var(--sub);
            font-weight: 500;
        }

        .legend-dot {
            width: 10px; height: 10px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        /* ── SVG Donut rings ── */
        .rings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem;
        }

        .ring-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            background: #fafafa;
            transition: background 0.15s, box-shadow 0.15s;
        }

        .ring-card:hover { background: var(--purple-bg); box-shadow: 0 2px 12px rgba(124,58,237,0.08); }

        .donut-wrap {
            position: relative;
            width: 54px;
            height: 54px;
            flex-shrink: 0;
        }

        .donut-svg { width: 54px; height: 54px; transform: rotate(-90deg); }

        .donut-bg   { fill: none; stroke: var(--border); stroke-width: 5; }
        .donut-fill { fill: none; stroke: var(--purple);  stroke-width: 5; stroke-linecap: round; transition: stroke-dashoffset 1s ease; }

        .donut-label {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            font-weight: 800;
            color: var(--purple);
        }

        .ring-info h4 { font-size: 0.8rem; font-weight: 700; color: var(--ink); margin-bottom: 0.15rem; }
        .ring-info p  { font-size: 0.72rem; color: var(--sub); }

        /* ── Manage row ── */
        .manage-row {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 1024px) { .manage-row { grid-template-columns: 1fr; } }

        .add-form { display: grid; gap: 0.875rem; }

        .form-field label {
            display: block;
            font-size: 0.775rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.3rem;
        }

        .form-field input {
            width: 100%;
            padding: 0.575rem 0.8rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: "Inter", sans-serif;
            font-size: 0.875rem;
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-field input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
        }

        .form-field input::placeholder { color: #9ca3af; }

        .btn-primary {
            width: 100%;
            padding: 0.65rem 1rem;
            background: var(--purple);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-family: "Inter", sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s, transform 0.12s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            background: var(--purple-dim);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(124,58,237,0.3);
        }

        /* ── Table ── */
        .table-header {
            padding: 1.125rem 1.375rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .table-search {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f9fafb;
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 0.35rem 0.7rem;
        }

        .table-search input {
            border: none;
            background: none;
            font-family: "Inter", sans-serif;
            font-size: 0.8rem;
            color: var(--ink);
            outline: none;
            width: 180px;
        }

        .table-search input::placeholder { color: #9ca3af; }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        th, td {
            text-align: left;
            padding: 0.7rem 1.375rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        th {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--sub);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            background: #f9fafb;
        }

        tbody tr {
            transition: background 0.12s;
        }

        tbody tr:hover { background: var(--purple-bg); }
        tr:last-child td { border-bottom: none; }

        td { color: var(--ink); }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .badge-ok { background: var(--ok-bg); color: var(--ok); border: 1px solid var(--ok-bdr); }
        .badge-no { background: var(--danger-bg); color: var(--danger); border: 1px solid var(--danger-bdr); }

        .btn-remove {
            background: none;
            border: 1px solid var(--danger-bdr);
            color: var(--danger);
            border-radius: 6px;
            padding: 0.3rem 0.65rem;
            font-family: "Inter", sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s, transform 0.12s;
        }

        .btn-remove:hover { background: var(--danger-bg); transform: scale(0.97); }

        .empty-row { color: var(--sub); font-style: italic; text-align: center; padding: 2rem; }

        /* ── Recent members ── */
        .members-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding: 1.25rem;
        }

        .member-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem 0.5rem 0.5rem;
            background: var(--purple-bg);
            border: 1px solid var(--purple-mid);
            border-radius: 999px;
            transition: background 0.15s, box-shadow 0.15s;
        }

        .member-chip:hover { background: var(--purple-mid); box-shadow: 0 2px 10px rgba(124,58,237,0.12); }

        .member-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple), #a78bfa);
            display: grid;
            place-items: center;
            font-size: 0.72rem;
            font-weight: 800;
            color: var(--white);
            flex-shrink: 0;
        }

        .member-name  { font-size: 0.8rem; font-weight: 700; color: var(--ink); }
        .member-email { font-size: 0.72rem; color: var(--sub); }

        /* ── Parent type breakdown ── */
        .breakdown-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 1024px) { .breakdown-grid { grid-template-columns: repeat(2,1fr); } }
        @media (max-width: 480px)  { .breakdown-grid { grid-template-columns: 1fr; } }

        .type-card {
            padding: 1.125rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .type-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .type-label { font-size: 0.78rem; font-weight: 600; color: var(--sub); margin-bottom: 0.15rem; }
        .type-count { font-size: 1.375rem; font-weight: 800; letter-spacing: -0.03em; color: var(--ink); }

        /* ── Tooltip ── */
        .tooltip-wrap { position: relative; display: inline-block; }

        .tooltip-wrap:hover .tooltip-box { opacity: 1; pointer-events: auto; transform: translateY(-4px); }

        .tooltip-box {
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%) translateY(0);
            background: var(--ink);
            color: var(--white);
            font-size: 0.72rem;
            font-weight: 500;
            padding: 0.3rem 0.6rem;
            border-radius: 5px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s, transform 0.2s;
            z-index: 10;
        }
    </style>
</head>
<body>

@php
    $parentTypeCounts = collect($users ?? [])->groupBy('parent_type')->map->count();
    $typeLabels = [
        'expecting'      => ['Expecting',     '🤰', '#fdf4ff', '#a855f7'],
        'new_parent'     => ['New Parent',     '👶', '#f0fdf4', '#16a34a'],
        'working_parent' => ['Working Parent', '💼', '#eff6ff', '#2563eb'],
        'solo_parent'    => ['Solo Parent',    '⭐', '#fff7ed', '#ea580c'],
    ];
@endphp

<!-- Nav -->
<nav class="nav" id="adminNav">
    <a class="nav-brand" href="/">
        <img src="{{ asset('logo.png') }}" alt="Pager">
        PAGER
        <span class="nav-badge">Admin</span>
    </a>

    <div class="nav-center">
        <a class="active" href="{{ route('admin.index') }}">Dashboard</a>
        <a href="#manage">Users</a>
    </div>

    <div class="nav-right">
        <span class="live-clock">
            <span class="pulse-dot"></span>
            <span id="liveClock">--:--:--</span>
        </span>
        <a class="nav-return" href="{{ url('/') }}">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to site
        </a>
    </div>
</nav>

<div class="page">

    <!-- Page header -->
    <div class="page-header" id="pageHeader">
        <div>
            <h1>Admin Dashboard</h1>
            <p>Manage accounts, monitor growth, and review platform health.</p>
        </div>
        <span class="header-badge">
            <span class="pulse-dot" style="width:6px;height:6px;margin:0;"></span>
            Live data
        </span>
    </div>

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
            <div class="kpi-value" id="kpi-total" data-to="{{ $stats['total_users'] }}">0</div>
            <div class="kpi-footer">
                <span class="kpi-tag up">All time</span>
                <a class="kpi-link" href="#manage">View →</a>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-label">New This Week</div>
            <div class="kpi-value" id="kpi-new" data-to="{{ $stats['new_users_7d'] }}">0</div>
            <div class="kpi-footer">
                <span class="kpi-tag neutral">Last 7 days</span>
                <a class="kpi-link" href="#manage">View →</a>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-label">Verified</div>
            <div class="kpi-value" id="kpi-verified" data-to="{{ $stats['verified_users'] }}">0</div>
            <div class="kpi-footer">
                <span class="kpi-tag up">{{ $stats['verified_rate'] }}% rate</span>
                <a class="kpi-link" href="#manage">View →</a>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-label">Unverified</div>
            <div class="kpi-value" id="kpi-unverified" data-to="{{ $stats['unverified_users'] }}">0</div>
            <div class="kpi-footer">
                <span class="kpi-tag warn">Pending</span>
                <a class="kpi-link" href="#manage">View →</a>
            </div>
        </div>
    </div>

    <!-- Parent type breakdown -->
    <div class="breakdown-grid" id="breakdownGrid">
        @foreach ($typeLabels as $key => [$label, $emoji, $bg, $color])
            <div class="card type-card" style="background:{{ $bg }};">
                <div class="type-icon" style="background:white;">{{ $emoji }}</div>
                <div>
                    <div class="type-label">{{ $label }}</div>
                    <div class="type-count" data-to="{{ $parentTypeCounts[$key] ?? 0 }}">0</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Analytics row -->
    <div class="analytics-row" id="analyticsRow">

        <!-- Animated SVG Bar Chart -->
        <div class="card card-pad">
            <div class="section-title">User Growth</div>
            <div class="section-sub">Monthly signups vs. sessions (simulated)</div>
            <div class="chart-container">
                <svg class="chart-svg" id="barSvg" viewBox="0 0 540 160" preserveAspectRatio="none"></svg>
            </div>
            <div class="chart-legend">
                <div class="legend-item"><span class="legend-dot" style="background:var(--purple);"></span> Signups</div>
                <div class="legend-item"><span class="legend-dot" style="background:#c4b5fd;"></span> Sessions</div>
            </div>
        </div>

        <!-- SVG Donut rings -->
        <div class="card card-pad">
            <div class="section-title">Performance Breakdown</div>
            <div class="section-sub">Account health metrics</div>
            <div class="rings-grid">
                @php
                    $rings = [
                        ['Verified Rate',      'Account trust health',   $stats['verified_rate']],
                        ['New User Share',     '7-day growth',           $stats['new_user_rate']],
                        ['Unverified Share',   'Needs activation',       $stats['unverified_rate']],
                        ['Active Footprint',   'Overall engagement',     100 - $stats['unverified_rate']],
                    ];
                    $r = 22; $circ = 2 * pi() * $r;
                @endphp
                @foreach ($rings as $ring)
                    @php $offset = $circ * (1 - $ring[2] / 100); @endphp
                    <div class="ring-card">
                        <div class="donut-wrap">
                            <svg class="donut-svg" viewBox="0 0 54 54">
                                <circle class="donut-bg"   cx="27" cy="27" r="{{ $r }}"/>
                                <circle class="donut-fill" cx="27" cy="27" r="{{ $r }}"
                                    stroke-dasharray="{{ $circ }}"
                                    stroke-dashoffset="{{ $circ }}"
                                    data-target="{{ $offset }}"
                                    data-circ="{{ $circ }}"/>
                            </svg>
                            <div class="donut-label">{{ $ring[2] }}%</div>
                        </div>
                        <div class="ring-info">
                            <h4>{{ $ring[0] }}</h4>
                            <p>{{ $ring[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Account management -->
    <div class="manage-row" id="manage">

        <!-- Add form -->
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
            <div class="table-header">
                <div>
                    <div class="section-title">All Accounts</div>
                    <div class="section-sub" style="margin-bottom:0;">{{ $stats['total_users'] }} users registered</div>
                </div>
                <div class="table-search">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" id="tableSearch" placeholder="Search users…">
                </div>
            </div>
            <div class="table-wrap">
                <table id="usersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="usersBody">
                        @forelse ($users as $user)
                            <tr>
                                <td style="font-weight:600;">{{ $user->name }}</td>
                                <td style="color:var(--sub);">{{ $user->email }}</td>
                                <td>
                                    @php $tl = $typeLabels[$user->parent_type ?? ''] ?? ['—','','',''] @endphp
                                    <span style="font-size:0.8rem;">{{ $tl[1] }} {{ $tl[0] }}</span>
                                </td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge badge-ok">Verified</span>
                                    @else
                                        <span class="badge badge-no">Unverified</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Remove this account?');">
                                        @csrf @method('DELETE')
                                        <button class="btn-remove" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty-row">No accounts found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent members -->
    @if ($users->count())
    <div class="card" id="membersCard">
        <div class="card-pad" style="padding-bottom:0.5rem; border-bottom:1px solid var(--border);">
            <div class="section-title">Recent Members</div>
            <div class="section-sub" style="margin-bottom:0;">Latest registrations</div>
        </div>
        <div class="members-grid">
            @foreach ($users->take(10) as $user)
                <div class="member-chip">
                    <div class="member-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                    <div>
                        <div class="member-name">{{ $user->name }}</div>
                        <div class="member-email">{{ $user->email }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script>
(() => {
    /* ── Live clock ── */
    const clockEl = document.getElementById('liveClock');
    function updateClock() {
        const now = new Date();
        clockEl.textContent = now.toLocaleTimeString('en-US', { hour12: false });
    }
    updateClock();
    setInterval(updateClock, 1000);

    /* ── Page entrance timeline ── */
    anime.timeline({ easing: 'easeOutExpo' })
        .add({ targets: '#adminNav',     opacity:[0,1], translateY:[-10,0], duration:500 })
        .add({ targets: '#pageHeader',   opacity:[0,1], translateY:[16,0],  duration:500 }, '-=300')
        .add({ targets: '#kpiGrid .card',opacity:[0,1], translateY:[20,0],  delay:anime.stagger(80), duration:550 }, '-=200')
        .add({ targets: '#breakdownGrid .card', opacity:[0,1], translateY:[16,0], delay:anime.stagger(70), duration:500 }, '-=200')
        .add({ targets: '#analyticsRow > .card', opacity:[0,1], translateY:[16,0], delay:anime.stagger(100), duration:500 }, '-=150')
        .add({ targets: '#manage > .card', opacity:[0,1], translateY:[16,0], delay:anime.stagger(100), duration:500 }, '-=100')
        .add({ targets: '#membersCard', opacity:[0,1], translateY:[12,0], duration:400 }, '-=100');

    /* ── KPI count-up ── */
    document.querySelectorAll('[id^="kpi-"]').forEach(el => {
        const to = +el.dataset.to;
        const obj = { v: 0 };
        anime({ targets: obj, v: to, round: 1, duration: 1600, easing: 'easeOutExpo', delay: 600,
            update() { el.textContent = obj.v; }
        });
    });

    /* ── Type card count-up ── */
    document.querySelectorAll('#breakdownGrid .type-count').forEach(el => {
        const to = +el.dataset.to;
        const obj = { v: 0 };
        anime({ targets: obj, v: to, round: 1, duration: 1400, easing: 'easeOutExpo', delay: 700,
            update() { el.textContent = obj.v; }
        });
    });

    /* ── SVG Bar chart ── */
    const svg = document.getElementById('barSvg');
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug'];
    const signups  = [60, 68, 88, 50, 47, 69, 64, 73];
    const sessions = [40, 52, 60, 38, 52, 56, 48, 57];
    const W = 540, H = 160, pad = 20, barW = 14, gap = 6;
    const slotW = (W - pad * 2) / months.length;
    const maxV = 100;

    /* Grid lines */
    [0, 0.25, 0.5, 0.75, 1].forEach(pct => {
        const y = pad + (1 - pct) * (H - pad - 20);
        const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        line.setAttribute('x1', pad); line.setAttribute('x2', W - pad);
        line.setAttribute('y1', y);   line.setAttribute('y2', y);
        line.setAttribute('class', 'chart-grid-line');
        svg.appendChild(line);
    });

    months.forEach((m, i) => {
        const cx = pad + slotW * i + slotW / 2;
        const chartH = H - pad - 22;

        const hS = (signups[i] / maxV) * chartH;
        const hSe = (sessions[i] / maxV) * chartH;

        const rS = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        rS.setAttribute('x', cx - barW - gap / 2);
        rS.setAttribute('y', H - 22 - hS);
        rS.setAttribute('width', barW);
        rS.setAttribute('height', hS);
        rS.setAttribute('rx', 3);
        rS.setAttribute('fill', 'var(--purple)');
        rS.setAttribute('transform-origin', `${cx - barW/2 - gap/2} ${H - 22}`);
        rS.style.transform = 'scaleY(0)';
        rS.style.transformBox = 'fill-box';
        svg.appendChild(rS);

        const rSe = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        rSe.setAttribute('x', cx + gap / 2);
        rSe.setAttribute('y', H - 22 - hSe);
        rSe.setAttribute('width', barW);
        rSe.setAttribute('height', hSe);
        rSe.setAttribute('rx', 3);
        rSe.setAttribute('fill', '#c4b5fd');
        rSe.setAttribute('transform-origin', `${cx + barW/2 + gap/2} ${H - 22}`);
        rSe.style.transform = 'scaleY(0)';
        rSe.style.transformBox = 'fill-box';
        svg.appendChild(rSe);

        const txt = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        txt.setAttribute('x', cx);
        txt.setAttribute('y', H - 4);
        txt.setAttribute('class', 'bar-label');
        txt.textContent = m;
        svg.appendChild(txt);
    });

    /* Animate bars with anime.js */
    setTimeout(() => {
        anime({
            targets: svg.querySelectorAll('rect'),
            scaleY: [0, 1],
            duration: 900,
            delay: anime.stagger(60),
            easing: 'easeOutBack'
        });
    }, 800);

    /* ── Donut ring animations ── */
    setTimeout(() => {
        document.querySelectorAll('.donut-fill').forEach(circle => {
            const target = +circle.dataset.target;
            const circ   = +circle.dataset.circ;
            anime({
                targets: circle,
                strokeDashoffset: [circ, target],
                duration: 1200,
                easing: 'easeOutExpo',
                delay: 200
            });
        });
    }, 900);

    /* ── Table search ── */
    document.getElementById('tableSearch').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#usersBody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    /* ── Member chips entrance ── */
    anime({
        targets: '.member-chip',
        opacity: [0, 1],
        translateX: [-12, 0],
        duration: 400,
        delay: anime.stagger(50, { start: 1200 }),
        easing: 'easeOutExpo'
    });

})();
</script>
</body>
</html>
