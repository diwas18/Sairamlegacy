@extends('layouts.app')

@section('content')

{{-- ── Fonts & Base ─────────────────────────────────────────────────── --}}
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

<style>
/* ── Reset & Base ─────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --cr:  #800020;
    --go:  #D4AF37;
    --es:  #4B2E0A;
    --sg:  #9fb8a8;
    --bg:  #f4f2ee;
    --surface: #ffffff;
    --border: rgba(0,0,0,.07);
    --text1: #1a1a1a;
    --text2: #6b6b6b;
    --text3: #b0b0b0;
    --success: #16a34a;
    --warning: #d97706;
    --danger:  #dc2626;
    --info:    #2563eb;
    --radius: 16px;
    --shadow: 0 2px 16px rgba(0,0,0,.06);
}

body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text1); }

/* ── Layout ───────────────────────────────────── */
.dash { max-width: 1400px; margin: 0 auto; padding: 0 0 40px; }

/* ── Topbar ───────────────────────────────────── */
.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.brand { flex-shrink: 0; }
.brand-title { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800; color: var(--cr); letter-spacing: -1px; line-height: 1; }
.brand-sub { font-size: .65rem; letter-spacing: .16em; text-transform: uppercase; color: var(--text3); margin-top: 4px; }
.brand-bar { height: 3px; width: 48px; background: linear-gradient(90deg,var(--cr),var(--go)); border-radius: 99px; margin-top: 8px; }

.topbar-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

/* ── Search ───────────────────────────────────── */
.search-wrap { position: relative; }
.search-input {
    width: 220px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px 12px 8px 34px;
    font-size: .78rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--text1);
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.search-input:focus { border-color: var(--cr); box-shadow: 0 0 0 3px rgba(128,0,32,.08); }
.search-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text3); font-size: 14px; pointer-events: none; }
.search-results {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    width: 300px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 12px 40px rgba(0,0,0,.12);
    z-index: 500;
    overflow: hidden;
    max-height: 320px;
    overflow-y: auto;
}
.search-results.open { display: block; animation: fadeSlide .15s ease; }
.sr-item { padding: 10px 14px; font-size: .78rem; color: var(--text1); border-bottom: 1px solid #f5f2ee; cursor: pointer; display: flex; align-items: center; gap: 8px; }
.sr-item:hover { background: #faf8f5; }
.sr-item:last-child { border-bottom: none; }
.sr-cat { font-size: .65rem; color: var(--text3); text-transform: uppercase; letter-spacing: .1em; padding: 8px 14px 4px; background: #faf8f5; }

/* ── Notif Bell ───────────────────────────────── */
.notif-wrap { position: relative; }
.icon-btn {
    width: 38px; height: 38px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    transition: transform .15s, box-shadow .15s;
    position: relative;
}
.icon-btn:hover { transform: scale(1.06); box-shadow: var(--shadow); }
.n-badge {
    position: absolute; top: -5px; right: -5px;
    background: var(--cr); color: #fff;
    font-size: .55rem; font-weight: 700;
    border-radius: 99px; padding: 1px 4px;
    border: 2px solid var(--bg);
    animation: pulse 2s infinite;
}
.notif-panel {
    display: none;
    position: absolute; top: 46px; right: 0;
    width: 310px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    box-shadow: 0 16px 48px rgba(0,0,0,.13);
    z-index: 600; overflow: hidden;
}
.notif-panel.open { display: block; animation: fadeSlide .18s ease; }
.n-head { padding: 13px 16px; font-family: 'Syne', sans-serif; font-size: .82rem; font-weight: 700; border-bottom: 1px solid #f0ede8; display: flex; justify-content: space-between; align-items: center; }
.n-clear { font-size: .65rem; color: var(--text3); font-family: 'DM Sans',sans-serif; cursor: pointer; }
.n-item { padding: 11px 16px; border-bottom: 1px solid #f9f7f4; display: flex; gap: 10px; align-items: flex-start; }
.n-item:last-child { border-bottom: none; }
.n-dot { width: 7px; height: 7px; border-radius: 50%; margin-top: 5px; flex-shrink: 0; }
.n-text { font-size: .76rem; color: var(--text2); line-height: 1.45; }
.n-time { font-size: .65rem; color: var(--text3); margin-top: 2px; }

/* ── Date Filter ─────────────────────────────── */
.filter-bar {
    display: flex; align-items: center; gap: 8px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 5px 8px;
}
.filter-btn {
    font-size: .72rem; font-family: 'DM Sans', sans-serif;
    padding: 5px 11px; border-radius: 7px;
    border: none; background: transparent;
    cursor: pointer; color: var(--text2);
    transition: background .15s, color .15s;
}
.filter-btn:hover, .filter-btn.active { background: var(--cr); color: #fff; }

/* ── Quick Actions ────────────────────────────── */
.quick-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 22px; }
.qa-btn {
    display: flex; align-items: center; gap: 7px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px 14px;
    font-size: .76rem; font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; color: var(--text1);
    transition: all .15s;
    text-decoration: none;
}
.qa-btn:hover { border-color: var(--cr); color: var(--cr); transform: translateY(-1px); box-shadow: var(--shadow); }
.qa-icon { font-size: 14px; }
.qa-btn.export-btn { border-color: var(--go); color: var(--es); }
.qa-btn.export-btn:hover { background: var(--go); color: var(--es); }

/* ── Section Label ────────────────────────────── */
.s-label { font-size: .62rem; letter-spacing: .18em; text-transform: uppercase; color: var(--text3); font-weight: 600; margin-bottom: 11px; margin-top: 4px; }

/* ── Grid helpers ─────────────────────────────── */
.g2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 12px; }
.g4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; }
.g3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
.g21 { display: grid; grid-template-columns: 2fr 1fr; gap: 12px; }
.g12 { display: grid; grid-template-columns: 1fr 2fr; gap: 12px; }
@media(max-width:900px) { .g4,.g3,.g21,.g12 { grid-template-columns: repeat(2,1fr); } }
@media(max-width:560px) { .g4,.g3,.g2,.g21,.g12 { grid-template-columns: 1fr; } }

.mb12 { margin-bottom: 12px; }
.mb20 { margin-bottom: 20px; }

/* ── Card Base ────────────────────────────────── */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 22px;
    box-shadow: var(--shadow);
    transition: transform .2s, box-shadow .2s;
}
.card:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,.09); }
.card-title { font-family: 'Syne', sans-serif; font-size: .88rem; font-weight: 700; color: var(--text1); margin-bottom: 14px; display: flex; align-items: center; gap: 6px; }

/* ── Stat Cards ───────────────────────────────── */
.stat { position: relative; overflow: hidden; }
.stat::before { content:''; position:absolute; left:0;top:0;bottom:0; width:3px; border-radius:3px 0 0 3px; }
.stat.cr::before { background:var(--cr); }
.stat.go::before { background:var(--go); }
.stat.es::before { background:var(--es); }
.stat.sg::before { background:var(--sg); }
.stat-icon { font-size: 1.3rem; margin-bottom: 7px; display: block; }
.stat-lbl { font-size: .62rem; text-transform: uppercase; letter-spacing: .1em; color: var(--text3); font-weight: 600; }
.stat-val { font-family: 'Syne', sans-serif; font-size: 1.75rem; font-weight: 800; color: var(--text1); line-height: 1.1; margin: 3px 0; }
.stat-sub { font-size: .68rem; color: var(--text3); }
.pill { display: inline-flex; align-items: center; gap: 3px; font-size: .66rem; font-weight: 700; padding: 2px 7px; border-radius: 99px; margin-top: 6px; }
.pill.up   { background:#e8f8ef; color:#15803d; }
.pill.dn   { background:#fef0f0; color:#dc2626; }
.pill.flat { background:#f0f0f0; color:#888; }

/* ── Status Pipeline ──────────────────────────── */
.status-lbl { font-size: .62rem; text-transform: uppercase; letter-spacing: .1em; color: var(--text3); font-weight: 600; margin-bottom: 5px; }
.status-val { font-family: 'Syne', sans-serif; font-size: 1.7rem; font-weight: 800; text-align: center; }
.pipeline-bar { height: 5px; border-radius: 99px; margin-top: 10px; overflow: hidden; background: #f3f0eb; }
.pipeline-fill { height: 100%; border-radius: 99px; }

/* ── Chip ─────────────────────────────────────── */
.chip { display:inline-block; font-size:.63rem; font-weight:600; padding:2px 8px; border-radius:99px; text-transform:capitalize; }
.chip-pending    { background:#fff8e1; color:#b45309; }
.chip-processing { background:#fef0f0; color:#b91c1c; }
.chip-shipping   { background:#eff6ff; color:#1d4ed8; }
.chip-delivered  { background:#f0fdf4; color:#16a34a; }
.chip-warning    { background:#fff8e1; color:#b45309; }
.chip-danger     { background:#fef0f0; color:#b91c1c; }
.chip-info       { background:#eff6ff; color:#1d4ed8; }

/* ── Table ────────────────────────────────────── */
.tbl { width:100%; border-collapse:collapse; font-size:.78rem; }
.tbl th { text-align:left; font-size:.6rem; text-transform:uppercase; letter-spacing:.1em; color:var(--text3); padding-bottom:8px; font-weight:600; }
.tbl td { padding:9px 0; border-top:1px solid #f3f0eb; color:var(--text2); vertical-align:middle; }

/* ── Progress bar inline ──────────────────────── */
.prog { display:flex; align-items:center; gap:8px; }
.prog-bar { flex:1; height:5px; background:#f0ede8; border-radius:99px; overflow:hidden; }
.prog-fill { height:100%; background:linear-gradient(90deg,var(--cr),var(--go)); border-radius:99px; }

/* ── Star Rating ──────────────────────────────── */
.stars { color: var(--go); font-size: 14px; letter-spacing: 1px; }
.big-rating { font-family:'Syne',sans-serif; font-size:3rem; font-weight:800; color:var(--cr); text-align:center; line-height:1; }
.rating-row { display:flex; align-items:center; gap:8px; margin:4px 0; font-size:.75rem; color:var(--text2); }
.rating-row .rbar { flex:1; height:5px; background:#f0ede8; border-radius:99px; overflow:hidden; }
.rating-row .rfill { height:100%; background:var(--go); border-radius:99px; }

/* ── Audit Log ────────────────────────────────── */
.audit-item { display:flex; gap:10px; padding:9px 0; border-bottom:1px solid #f3f0eb; font-size:.76rem; }
.audit-item:last-child { border-bottom:none; }
.audit-dot { width:7px;height:7px;border-radius:50%;background:var(--sg);margin-top:5px;flex-shrink:0; }
.audit-text { color:var(--text2); line-height:1.4; flex:1; }
.audit-time { color:var(--text3); font-size:.65rem; flex-shrink:0; }

/* ── Task list ────────────────────────────────── */
.task { display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid #f3f0eb; font-size:.78rem; }
.task:last-child { border-bottom:none; }
.task-icon { font-size:15px; }

/* ── Live badge ───────────────────────────────── */
.live { display:inline-flex;align-items:center;gap:5px;font-size:.62rem;color:var(--success);font-weight:600;letter-spacing:.08em;text-transform:uppercase; }
.live::before { content:'';display:block;width:6px;height:6px;border-radius:50%;background:var(--success);animation:pulse 1.5s infinite; }

/* ── Dark mode toggle ─────────────────────────── */
.dm-btn { font-size:16px; }
body.dark {
    --bg: #111;
    --surface: #1c1c1e;
    --border: rgba(255,255,255,.08);
    --text1: #f0ede8;
    --text2: #a8a8a8;
    --text3: #555;
    --shadow: 0 2px 16px rgba(0,0,0,.4);
}

/* ── Geo bars ─────────────────────────────────── */
.geo-row { display:flex;align-items:center;gap:8px;padding:7px 0;border-bottom:1px solid #f3f0eb;font-size:.78rem; }
.geo-row:last-child { border-bottom:none; }
.geo-city { width:90px;flex-shrink:0;color:var(--text2); }
.geo-bar { flex:1; height:6px; background:#f0ede8; border-radius:99px; overflow:hidden; }
.geo-fill { height:100%; background:linear-gradient(90deg,var(--es),var(--sg)); border-radius:99px; }
.geo-count { width:30px;text-align:right;color:var(--text3);flex-shrink:0; }

/* ── AOV / Acq ────────────────────────────────── */
.mini-metric { padding: 12px 0; border-bottom:1px solid #f3f0eb; display:flex;justify-content:space-between;align-items:center; }
.mini-metric:last-child { border-bottom:none; }
.mm-lbl { font-size:.68rem;color:var(--text3);text-transform:uppercase;letter-spacing:.08em; }
.mm-val { font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:700;color:var(--text1); }

/* ── Conv gauge ───────────────────────────────── */
.conv-num { font-family:'Syne',sans-serif;font-size:2.6rem;font-weight:800;color:var(--cr);text-align:center;margin:12px 0 4px; }
.conv-lbl { text-align:center;font-size:.65rem;color:var(--text3);text-transform:uppercase;letter-spacing:.12em;margin-bottom:14px; }
.fullbar { height:8px;background:#f3f0eb;border-radius:99px;overflow:hidden;margin-bottom:14px; }
.fullbar-fill { height:100%;background:linear-gradient(90deg,var(--cr),var(--go));border-radius:99px;transition:width 1.2s ease; }

/* ── Animations ───────────────────────────────── */
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.3)} }
@keyframes fadeSlide { from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)} }
@keyframes countUp { from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)} }
.stat-val { animation: countUp .45s ease both; }
.card:nth-child(1){animation-delay:.04s}.card:nth-child(2){animation-delay:.08s}.card:nth-child(3){animation-delay:.12s}.card:nth-child(4){animation-delay:.16s}
</style>

<div class="dash">

{{-- ══════════════════════════════════════════════════════════════
     TOPBAR
══════════════════════════════════════════════════════════════ --}}
<div class="topbar">
    <div class="brand">
        <div class="brand-title">Dashboard</div>
        <div class="brand-sub">{{ now()->format('l, d F Y') }} &nbsp;·&nbsp; <span class="live">Live</span></div>
        <div class="brand-bar"></div>
    </div>

    <div class="topbar-right">

        {{-- Global Search --}}
<div class="search-wrap">
    <span class="search-icon">🔍</span>
    <input class="search-input" id="globalSearch" type="text" placeholder="Search orders, products…" autocomplete="off">
    <div class="search-results" id="searchResults"></div>
</div>

        <form method="GET" action="{{ route('dashboard') }}" id="filterForm">
    <div class="filter-bar">
        @foreach(['today'=>'Today','7'=>'7d','30'=>'30d','90'=>'90d'] as $val=>$lbl)
            <button type="submit" name="range" value="{{ $val }}"
                class="filter-btn {{ $range == $val ? 'active' : '' }}">{{ $lbl }}</button>
        @endforeach

        {{-- Custom date range --}}
        <div style="display:flex;align-items:center;gap:4px;border-left:1px solid var(--border);padding-left:10px;margin-left:4px;">
            <span style="font-size:.68rem;color:var(--text2);">From</span>
            <input type="date" name="from" id="customFrom" value="{{ $from }}"
                style="border:none;background:transparent;font-size:.72rem;font-family:inherit;color:var(--text2);outline:none;width:100px"
                onchange="triggerCustomRange()">
            <span style="font-size:.68rem;color:var(--text2);">To</span>
            <input type="date" name="to" id="customTo" value="{{ $to ?? '' }}"
                style="border:none;background:transparent;font-size:.72rem;font-family:inherit;color:var(--text2);outline:none;width:100px"
                onchange="triggerCustomRange()">
            @if($from && isset($to) && $to)
                <a href="{{ route('dashboard') }}"
                   style="font-size:.68rem;color:var(--text2);text-decoration:none;opacity:0.5;margin-left:2px;"
                   title="Clear custom range">✕</a>
            @endif
        </div>
    </div>
</form>

        {{-- Dark mode --}}
        <button class="icon-btn dm-btn" onclick="toggleDark()" title="Toggle dark mode">🌙</button>

        {{-- Notifications --}}
        <div class="notif-wrap">
            <button class="icon-btn" onclick="toggleNotif()" id="notifBtn">
                🔔
                @php $notifCount = $lowStock->count() + ($pending > 0 ? 1 : 0) + count($adminTasks) @endphp
                @if($notifCount > 0)<span class="n-badge">{{ $notifCount }}</span>@endif
            </button>
            <div class="notif-panel" id="notifPanel">
                <div class="n-head">
                    Notifications
                    <span class="n-clear" onclick="clearNotifs()">Clear all</span>
                </div>
                @if($pending > 0)
                <div class="n-item"><span class="n-dot" style="background:var(--go)"></span><div><div class="n-text"><strong>{{ $pending }} orders</strong> waiting for confirmation</div><div class="n-time">Action needed</div></div></div>
                @endif
                @foreach($lowStock->take(4) as $item)
                <div class="n-item"><span class="n-dot" style="background:var(--danger)"></span><div><div class="n-text"><strong>{{ $item->name }}</strong> critically low ({{ $item->stock }} left)</div><div class="n-time">Stock alert</div></div></div>
                @endforeach
                @if($notifCount === 0)
                <div class="n-item"><span class="n-dot" style="background:var(--success)"></span><div><div class="n-text">All systems healthy 🎉</div></div></div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     QUICK ACTIONS
══════════════════════════════════════════════════════════════ --}}
<div class="quick-actions">
<a href="{{ route('product.create') }}" class="qa-btn"><span class="qa-icon">➕</span> Add Product</a>
<a href="{{ route('order.index', ['status'=>'pending']) }}" class="qa-btn"><span class="qa-icon">📦</span> Pending Orders</a>
<a href="{{ route('users.index') }}" class="qa-btn"><span class="qa-icon">👥</span> Manage Users</a>
<a href="{{ route('product.index') }}" class="qa-btn"><span class="qa-icon">🏷️</span> Products</a>
<a href="{{route('admin.booking.index')}}" class="qa-btn"><span class="qa-icon">📅</span> Bookings</a>
    <a href="{{ route('dashboard.export') }}" class="qa-btn export-btn"><span class="qa-icon">📤</span> Export CSV</a>
</div>

{{-- ══════════════════════════════════════════════════════════════
     OVERVIEW STATS
══════════════════════════════════════════════════════════════ --}}
<p class="s-label">Overview</p>
<div class="g4 mb12">

    <div class="card stat cr">
        <span class="stat-icon">💰</span>
        <div class="stat-lbl">Revenue</div>
        <div class="stat-val" data-prefix="Rs. " data-target="{{ $totalRevenue }}">Rs. 0</div>
        <div class="stat-sub">Delivered orders only</div>
        @if($revenueGrowth > 0)<span class="pill up">▲ {{ $revenueGrowth }}%</span>
        @elseif($revenueGrowth < 0)<span class="pill dn">▼ {{ abs($revenueGrowth) }}%</span>
        @else<span class="pill flat">─ No change</span>@endif
    </div>

    <div class="card stat go">
        <span class="stat-icon">📦</span>
        <div class="stat-lbl">Orders</div>
        <div class="stat-val counter" data-target="{{ $totalOrders }}">0</div>
        <div class="stat-sub">All time · {{ $periodOrders }} in period</div>
        @if($orderGrowth > 0)<span class="pill up">▲ {{ $orderGrowth }}%</span>
        @elseif($orderGrowth < 0)<span class="pill dn">▼ {{ abs($orderGrowth) }}%</span>
        @else<span class="pill flat">─ No change</span>@endif
    </div>

    <div class="card stat es">
        <span class="stat-icon">👤</span>
        <div class="stat-lbl">Users</div>
        <div class="stat-val counter" data-target="{{ $totalUsers }}">0</div>
        <div class="stat-sub">+{{ $periodUsers }} new in period</div>
        @if($userGrowth > 0)<span class="pill up">▲ {{ $userGrowth }}%</span>
        @elseif($userGrowth < 0)<span class="pill dn">▼ {{ abs($userGrowth) }}%</span>
        @else<span class="pill flat">─ No change</span>@endif
    </div>

    <div class="card stat sg">
        <span class="stat-icon">🏷️</span>
        <div class="stat-lbl">Products</div>
        <div class="stat-val counter" data-target="{{ $totalProducts }}">0</div>
        <div class="stat-sub">Total in catalog</div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════════
     ORDER PIPELINE
══════════════════════════════════════════════════════════════ --}}
<p class="s-label">Order Pipeline</p>
<div class="g4 mb20">
    @php $pipeData = ['Pending'=>[$pending,'#d97706','#fff8e1'],'Processing'=>[$processing,'#b91c1c','#fef0f0'],'Shipping'=>[$shipping,'#1d4ed8','#dbeafe'],'Delivered'=>[$delivered,'#16a34a','#dcfce7']]; @endphp
    @foreach($pipeData as $label => [$count, $color, $bg])
    <div class="card" style="text-align:center">
        <div class="status-lbl">{{ $label }}</div>
        <div class="status-val counter" data-target="{{ $count }}" style="color:{{ $color }}">0</div>
        <div class="pipeline-bar"><div class="pipeline-fill" style="width:{{ $totalOrders > 0 ? round($count/$totalOrders*100) : 0 }}%;background:{{ $color }}"></div></div>
        <div style="font-size:.62rem;color:var(--text3);margin-top:5px">{{ $totalOrders > 0 ? round($count/$totalOrders*100) : 0 }}% of total</div>
    </div>
    @endforeach
</div>

{{-- ══════════════════════════════════════════════════════════════
     SALES TREND (full width)
══════════════════════════════════════════════════════════════ --}}
<p class="s-label">Sales Trend</p>
<div class="card mb12">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
        <div class="card-title" style="margin:0">📈 Revenue — Selected Period</div>
        <span class="live">Updating</span>
    </div>
    <div style="height:220px"><canvas id="salesTrendChart"></canvas></div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     CUSTOMER ACQUISITION + AOV
══════════════════════════════════════════════════════════════ --}}
<div class="g2 mb20">
    <div class="card">
        <div class="card-title">👥 Customer Acquisition</div>
        <div style="height:180px"><canvas id="acquisitionChart"></canvas></div>
    </div>
    <div class="card">
        <div class="card-title">💎 Avg Order Value Trend</div>
        <div style="height:180px"><canvas id="aovChart"></canvas></div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     CATEGORY BAR + ORDER DOUGHNUT
══════════════════════════════════════════════════════════════ --}}
<div class="g21 mb20">
    <div class="card">
        <div class="card-title">🗂 Products by Category</div>
        <div style="height:200px"><canvas id="barChart"></canvas></div>
    </div>
    <div class="card">
        <div class="card-title">🍩 Order Status</div>
        <div style="height:160px"><canvas id="doughnutChart"></canvas></div>
        <div style="margin-top:10px;display:flex;flex-wrap:wrap;gap:8px;font-size:.66rem;color:var(--text2)" id="pie-legend"></div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     TOP PRODUCTS + REPEAT CUSTOMERS
══════════════════════════════════════════════════════════════ --}}
<div class="g21 mb20">

    {{-- Top Products --}}
    <div class="card">
        <div class="card-title">🏆 Top Selling Products</div>
        @if($topProducts->isEmpty())
            <p style="color:var(--text3);font-size:.8rem;text-align:center;padding:20px 0">No sales data for this period</p>
        @else
        <table class="tbl">
            <thead><tr><th>#</th><th>Product</th><th>Units</th><th>Revenue</th><th>Share</th></tr></thead>
            <tbody>
                @php $maxRev = $topProducts->max('revenue') ?: 1; @endphp
                @foreach($topProducts as $i => $p)
                <tr>
                    <td style="color:var(--text3);font-family:'Syne',sans-serif;font-weight:800">{{ $i+1 }}</td>
                    <td style="font-weight:500;color:var(--text1)">{{ $p->name }}</td>
                    <td>{{ number_format($p->units_sold) }}</td>
                    <td style="font-weight:600;color:var(--cr)">Rs. {{ number_format($p->revenue) }}</td>
                    <td style="min-width:80px">
                        <div class="prog"><div class="prog-bar"><div class="prog-fill" style="width:{{ round($p->revenue/$maxRev*100) }}%"></div></div></div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Repeat vs New + Conversion --}}
    <div class="card">
        <div class="card-title">🔁 Customer Loyalty</div>
        <div style="height:150px"><canvas id="loyaltyChart"></canvas></div>
        <div class="mini-metric" style="margin-top:12px">
            <div><div class="mm-lbl">Repeat Customers</div><div class="mm-val">{{ $repeatCustomers }}</div></div>
            <div style="text-align:right"><div class="mm-lbl">New Customers</div><div class="mm-val">{{ $newCustomers }}</div></div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════════
     ADVANCED ANALYTICS ROW
══════════════════════════════════════════════════════════════ --}}
<div class="g3 mb20">

    {{-- Conversion / Delivery Rate --}}
    <div class="card">
        <div class="card-title">📊 Delivery Rate</div>
        <div class="conv-num">{{ $deliveryRate }}%</div>
        <div class="conv-lbl">of all orders delivered</div>
        <div class="fullbar"><div class="fullbar-fill" style="width:{{ $deliveryRate }}%"></div></div>
        <div class="mini-metric"><div class="mm-lbl">Avg Order Value</div><div class="mm-val">Rs. {{ number_format($avgOrderValue) }}</div></div>
        <div class="mini-metric"><div class="mm-lbl">Total Delivered</div><div class="mm-val">{{ $delivered }}</div></div>
    </div>

    {{-- Geographic --}}
    <div class="card">
        <div class="card-title">🗺️ Top Cities</div>
        @if($geoData->isEmpty())
            <p style="color:var(--text3);font-size:.78rem;text-align:center;padding:20px 0">No location data available</p>
        @else
            @php $maxGeo = $geoData->max('count') ?: 1; @endphp
            @foreach($geoData as $geo)
            <div class="geo-row">
                <div class="geo-city">{{ $geo->city ?? 'Unknown' }}</div>
                <div class="geo-bar"><div class="geo-fill" style="width:{{ round($geo->count/$maxGeo*100) }}%"></div></div>
                <div class="geo-count">{{ $geo->count }}</div>
            </div>
            @endforeach
        @endif
    </div>

    {{-- Reviews Summary --}}
    <div class="card" id="reviews">
        <div class="card-title">⭐ Reviews</div>
        @if($totalReviews > 0)
            <div class="big-rating">{{ number_format($avgRating, 1) }}</div>
            <div style="text-align:center;margin:4px 0 12px">
                <span class="stars">{{ str_repeat('★', round($avgRating)) }}{{ str_repeat('☆', 5-round($avgRating)) }}</span>
                <div style="font-size:.65rem;color:var(--text3)">{{ $totalReviews }} reviews</div>
            </div>
            @foreach([5,4,3,2,1] as $star)
                @php $cnt = $ratingDist->firstWhere('rating',$star)->count ?? 0; @endphp
                <div class="rating-row">
                    <span style="width:14px;text-align:right">{{ $star }}</span>
                    <div class="rbar"><div class="rfill" style="width:{{ $totalReviews > 0 ? round($cnt/$totalReviews*100) : 0 }}%"></div></div>
                    <span style="width:24px;text-align:right;color:var(--text3)">{{ $cnt }}</span>
                </div>
            @endforeach
        @else
            <p style="color:var(--text3);font-size:.78rem;text-align:center;padding:20px 0">No reviews yet</p>
        @endif
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════════
     BOTTOM ROW — Recent Orders / Low Stock / Tasks / Audit Log
══════════════════════════════════════════════════════════════ --}}
<div class="g2 mb20">

    {{-- Recent Orders --}}
    <div class="card">
        <div class="card-title">🧾 Recent Orders</div>
        <table class="tbl">
            <thead><tr><th>ID</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td style="color:var(--text3)">#{{ $order->id }}</td>
                    <td style="font-weight:500">{{ $order->user->name ?? 'Guest' }}</td>
                    <td style="font-weight:600;color:var(--cr)">Rs. {{ number_format($order->price * ($order->qty ?? 1)) }}</td>
                    <td><span class="chip chip-{{ $order->status }}">{{ $order->status }}</span></td>
                    <td style="color:var(--text3)">{{ $order->created_at->format('d M') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--text3);padding:20px 0">No orders yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Low Stock + Admin Tasks --}}
    <div style="display:flex;flex-direction:column;gap:12px">

        <div class="card" style="flex:1">
            <div class="card-title">⚠️ Low Stock Alerts</div>
            @forelse($lowStock as $item)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f3f0eb;font-size:.78rem">
                <span style="color:var(--text2)">{{ $item->name }}</span>
                <span class="chip chip-danger">{{ $item->stock }} left</span>
            </div>
            @empty
            <p style="color:var(--text3);font-size:.78rem;text-align:center;padding:14px 0">All items well-stocked 🎉</p>
            @endforelse
        </div>

        <div class="card" style="flex:1">
            <div class="card-title">✅ Admin Tasks</div>
            @forelse($adminTasks as $task)
            <div class="task">
                <span class="task-icon">{{ $task['type'] === 'danger' ? '🔴' : ($task['type'] === 'warning' ? '🟡' : '🔵') }}</span>
                <a href="{{ $task['link'] }}" style="color:var(--text2);text-decoration:none;flex:1;font-size:.78rem">{{ $task['label'] }}</a>
                <span class="chip chip-{{ $task['type'] }}">{{ $task['type'] }}</span>
            </div>
            @empty
            <p style="color:var(--text3);font-size:.78rem;text-align:center;padding:14px 0">No tasks pending ✨</p>
            @endforelse
        </div>

    </div>

</div>


{{-- Payment Methods ──────────────────────────────────────────────────────── --}}
<p class="s-label" style="margin-top:20px">Payment Methods</p>
<div class="card mb20">
    <div class="card-title">💳 Payment Method Breakdown</div>
    @if($paymentMethods->isEmpty())
        <p style="color:var(--text3);font-size:.78rem;text-align:center;padding:14px 0">No payment data for this period</p>
    @else
    @php $maxPay = $paymentMethods->max('count') ?: 1; @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px">
        @foreach($paymentMethods as $pm)
        <div style="background:#faf8f5;border-radius:12px;padding:14px;text-align:center">
            <div style="font-size:1.4rem;margin-bottom:6px">{{ $pm->payment_method === 'cod' ? '💵' : ($pm->payment_method === 'esewa' ? '📱' : ($pm->payment_method === 'khalti' ? '💜' : '🏦')) }}</div>
            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text3);margin-bottom:4px">{{ ucfirst(str_replace('_',' ',$pm->payment_method)) }}</div>
            <div style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--cr)">{{ $pm->count }}</div>
            <div style="margin-top:8px;height:4px;background:#ece9e3;border-radius:99px;overflow:hidden">
                <div style="height:100%;width:{{ round($pm->count/$maxPay*100) }}%;background:linear-gradient(90deg,var(--cr),var(--go));border-radius:99px"></div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- ══════════════════════════════════════════════════════════════
     AUDIT LOG + RECENT REVIEWS
══════════════════════════════════════════════════════════════ --}}
<div class="g2">

    <div class="card">
        <div class="card-title">📋 Activity Log</div>
        @forelse($auditLog as $log)
        <div class="audit-item">
            <span class="audit-dot"></span>
            <div class="audit-text">{{ $log->description ?? $log->event ?? 'System event' }}</div>
            <div class="audit-time">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</div>
        </div>
        @empty
        <p style="color:var(--text3);font-size:.78rem;text-align:center;padding:20px 0">No recent activity to show.</p>
        @endforelse
    </div>

    <div class="card">
        <div class="card-title">💬 Latest Reviews</div>
        @forelse($recentReviews as $review)
        <div style="padding:10px 0;border-bottom:1px solid #f3f0eb">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px">
                <span style="font-size:.78rem;font-weight:500;color:var(--text1)">{{ $review->user->name ?? 'Anonymous' }}</span>
                <span class="stars" style="font-size:12px">{{ str_repeat('★',$review->rating) }}{{ str_repeat('☆',5-$review->rating) }}</span>
            </div>
            <div style="font-size:.73rem;color:var(--text2)">{{ $review->product->name ?? '' }}</div>
            <div style="font-size:.72rem;color:var(--text3);margin-top:3px">{{ Str::limit($review->feedback ?? '', 80) }}</div>
        </div>
        @empty
        <p style="color:var(--text3);font-size:.78rem;text-align:center;padding:20px 0">No reviews yet</p>
        @endforelse
    </div>

</div>

</div>{{-- end .dash --}}

{{-- ══════════════════════════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>


// ── Helper: fill date range ────────────────────────────────────
function buildDateLabels(data, dateKey, valueKey, startDate, days) {
    const map = {};
    data.forEach(d => { map[d[dateKey]] = parseFloat(d[valueKey]) || 0; });
    const labels = [], values = [];
    for (let i = days - 1; i >= 0; i--) {
        const d = new Date(); d.setDate(d.getDate() - i);
        const key = d.toISOString().split('T')[0];
        labels.push(d.toLocaleDateString('en-US',{month:'short',day:'numeric'}));
        values.push(map[key] ?? 0);
    }
    return { labels, values };
}

const DAYS = '{{ $range }}' === 'today' ? 1 : (parseInt('{{ $range }}') || 7);

// ── Animated Counters ──────────────────────────────────────────
document.querySelectorAll('[data-target]').forEach(el => {
    const target = parseInt(el.dataset.target) || 0;
    const prefix = el.dataset.prefix || '';
    let cur = 0;
    const dur = 1100, step = 14, inc = target / (dur / step);
    const t = setInterval(() => {
        cur = Math.min(cur + inc, target);
        el.textContent = prefix + Math.floor(cur).toLocaleString();
        if (cur >= target) clearInterval(t);
    }, step);
});

// ── Dark Mode ─────────────────────────────────────────────────
function toggleDark() {
    document.body.classList.toggle('dark');
    localStorage.setItem('dash_dark', document.body.classList.contains('dark') ? '1' : '0');
}
if (localStorage.getItem('dash_dark') === '1') document.body.classList.add('dark');

// ── Notifications ─────────────────────────────────────────────
function toggleNotif() {
    document.getElementById('notifPanel').classList.toggle('open');
}
function clearNotifs() {
    document.getElementById('notifPanel').innerHTML = '<div class="n-head">Notifications</div><div class="n-item"><span class="n-dot" style="background:var(--success)"></span><div class="n-text">Cleared!</div></div>';
}
document.addEventListener('click', e => {
    const btn = document.getElementById('notifBtn');
    const panel = document.getElementById('notifPanel');
    if (!btn.contains(e.target) && !panel.contains(e.target)) panel.classList.remove('open');
});

// ── Global Search (LIVE DATABASE) ─────────────────────────────
const searchInput = document.getElementById('globalSearch');
const searchResults = document.getElementById('searchResults');

searchInput.addEventListener('input', function () {
    const q = this.value.trim();

    if (q.length < 2) {
        searchResults.classList.remove('open');
        return;
    }

    fetch(`/admin/search?q=${q}`)
        .then(res => res.json())
        .then(data => {
            let html = '';

            // PRODUCTS
            if (data.products.length) {
                html += `<div class="sr-cat">Products</div>`;
                data.products.forEach(p => {
                    let stockStatus = p.stock < 5
                        ? `<span style="color:red">Low (${p.stock})</span>`
                        : `<span style="color:green">${p.stock} in stock</span>`;

                    html += `
                        <div class="sr-item" onclick="location.href='/product/${p.id}/edit'">
                            🏷️ ${p.name} — Rs.${p.price} <br>
                            ${stockStatus}
                        </div>`;
                });
            }

            // ORDERS
            if (data.orders.length) {
                html += `<div class="sr-cat">Orders</div>`;
                data.orders.forEach(o => {
                    html += `
                        <div class="sr-item" onclick="location.href='/admin/orders/${o.id}'">
                            📦 Order #${o.id} — ${o.name ?? 'Guest'}
                        </div>`;
                });
            }

            // USERS
            if (data.users.length) {
                html += `<div class="sr-cat">Users</div>`;
                data.users.forEach(u => {
                    html += `
                        <div class="sr-item">
                            👤 ${u.name} — ${u.email}
                        </div>`;
                });
            }

            if (!html) {
                html = `<div class="sr-item">No results found</div>`;
            }

            searchResults.innerHTML = html;
            searchResults.classList.add('open');
        });
});

// ── Chart defaults ─────────────────────────────────────────────
Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.font.size   = 11;
Chart.defaults.color       = '#9b9b9b';

// ── Sales Trend ───────────────────────────────────────────────
const salesRaw = @json($salesChart);
const salesMap = {}; salesRaw.forEach(d => { salesMap[d.date] = parseFloat(d.total) || 0; });
const salesLabels = [], salesTotals = [];
for (let i = DAYS - 1; i >= 0; i--) {
    const d = new Date(); d.setDate(d.getDate() - i);
    const key = d.toISOString().split('T')[0];
    salesLabels.push(d.toLocaleDateString('en-US',{month:'short',day:'numeric'}));
    salesTotals.push(salesMap[key] ?? 0);
}
const sc = document.getElementById('salesTrendChart').getContext('2d');
const sg = sc.createLinearGradient(0,0,0,220); sg.addColorStop(0,'rgba(128,0,32,.2)'); sg.addColorStop(1,'rgba(128,0,32,0)');
new Chart(sc, {
    type:'line', data:{ labels:salesLabels, datasets:[{ data:salesTotals, borderColor:'#800020', backgroundColor:sg, borderWidth:2.5, pointRadius:4, pointHoverRadius:7, tension:.42, fill:true }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false}, tooltip:{ callbacks:{ label: c => 'Rs. ' + c.parsed.y.toLocaleString() } } }, scales:{ x:{grid:{display:false}}, y:{beginAtZero:true, grid:{color:'#f3f0eb'}, ticks:{ callback: v => 'Rs. ' + v.toLocaleString() } } } }
});

// ── Acquisition Chart ──────────────────────────────────────────
const acqRaw = @json($acquisitionChart);
const acqMap = {}; acqRaw.forEach(d => { acqMap[d.date] = parseInt(d.count) || 0; });
const acqLabels = [], acqVals = [];
for (let i = DAYS - 1; i >= 0; i--) {
    const d = new Date(); d.setDate(d.getDate() - i);
    const key = d.toISOString().split('T')[0];
    acqLabels.push(d.toLocaleDateString('en-US',{month:'short',day:'numeric'}));
    acqVals.push(acqMap[key] ?? 0);
}
const ac = document.getElementById('acquisitionChart').getContext('2d');
const ag = ac.createLinearGradient(0,0,0,180); ag.addColorStop(0,'rgba(75,46,10,.18)'); ag.addColorStop(1,'rgba(75,46,10,0)');
new Chart(ac, {
    type:'line', data:{ labels:acqLabels, datasets:[{ data:acqVals, borderColor:'#4B2E0A', backgroundColor:ag, borderWidth:2, pointRadius:3, tension:.42, fill:true }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false} }, scales:{ x:{grid:{display:false}}, y:{beginAtZero:true, grid:{color:'#f3f0eb'}, ticks:{stepSize:1}} } }
});

// ── AOV Chart ──────────────────────────────────────────────────
const aovRaw = @json($aovChart);
const aovMap = {}; aovRaw.forEach(d => { aovMap[d.date] = parseFloat(d.avg_value) || 0; });
const aovLabels = [], aovVals = [];
for (let i = DAYS - 1; i >= 0; i--) {
    const d = new Date(); d.setDate(d.getDate() - i);
    const key = d.toISOString().split('T')[0];
    aovLabels.push(d.toLocaleDateString('en-US',{month:'short',day:'numeric'}));
    aovVals.push(Math.round(aovMap[key] ?? 0));
}
const oc = document.getElementById('aovChart').getContext('2d');
const og = oc.createLinearGradient(0,0,0,180); og.addColorStop(0,'rgba(212,175,55,.25)'); og.addColorStop(1,'rgba(212,175,55,0)');
new Chart(oc, {
    type:'line', data:{ labels:aovLabels, datasets:[{ data:aovVals, borderColor:'#D4AF37', backgroundColor:og, borderWidth:2, pointRadius:3, tension:.42, fill:true }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false}, tooltip:{ callbacks:{ label: c => 'Rs. ' + c.parsed.y.toLocaleString() } } }, scales:{ x:{grid:{display:false}}, y:{beginAtZero:true, grid:{color:'#f3f0eb'}, ticks:{ callback: v => 'Rs. ' + v.toLocaleString() } } } }
});

// ── Bar Chart ──────────────────────────────────────────────────
new Chart(document.getElementById('barChart'), {
    type:'bar', data:{ labels:@json($allcatNames), datasets:[{ data:@json($productcount), backgroundColor:['#800020','#D4AF37','#4B2E0A','#9fb8a8','#b34040','#c9a227'], borderRadius:8, borderSkipped:false }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false} }, scales:{ x:{grid:{display:false}}, y:{beginAtZero:true, grid:{color:'#f3f0eb'}, ticks:{stepSize:1}} } }
});

// ── Doughnut Chart ─────────────────────────────────────────────
const pieColors  = ['#D4AF37','#800020','#4B2E0A','#9fb8a8'];
const pieLabels  = ['Pending','Processing','Shipping','Delivered'];
const pieData    = [{{ $pending }},{{ $processing }},{{ $shipping }},{{ $delivered }}];
new Chart(document.getElementById('doughnutChart'), {
    type:'doughnut', data:{ labels:pieLabels, datasets:[{ data:pieData, backgroundColor:pieColors, borderWidth:0, hoverOffset:8 }] },
    options:{ responsive:true, maintainAspectRatio:false, cutout:'68%', plugins:{ legend:{display:false} } }
});
const leg = document.getElementById('pie-legend');
pieLabels.forEach((l,i) => { leg.innerHTML += `<span style="display:inline-flex;align-items:center;gap:4px"><span style="width:7px;height:7px;border-radius:50%;background:${pieColors[i]};display:inline-block"></span>${l} (${pieData[i]})</span>`; });

// ── Loyalty / Repeat Chart ─────────────────────────────────────
new Chart(document.getElementById('loyaltyChart'), {
    type:'doughnut', data:{ labels:['Repeat','New'], datasets:[{ data:[{{ $repeatCustomers }},{{ $newCustomers }}], backgroundColor:['#800020','#D4AF37'], borderWidth:0, hoverOffset:6 }] },
    options:{ responsive:true, maintainAspectRatio:false, cutout:'60%', plugins:{ legend:{ position:'bottom', labels:{ boxWidth:10, font:{size:11} } } } }
});

// ── Auto-refresh every 60s ─────────────────────────────────────
setTimeout(() => location.reload(), 60000);

</script>

@endsection
