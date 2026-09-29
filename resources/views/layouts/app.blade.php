<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --top-a: #065f46;
            --top-b: #10b981;
            --side-a: #047857;
            --side-b: #064e3b;
            --tab: #b45309;
            --primary: #059669;
            --primary-dark: #047857;
            --thead-bg: #d1fae5;
            --thead-text: #065f46;
            --heading: #1e293b;
        }

        body { background: #f1f5f9; font-family: "Poppins", "Segoe UI", Arial, sans-serif; color: #1f2937; }

        .topbar { background: linear-gradient(90deg, var(--top-a), var(--top-b)); color: #fff; height: 56px; display: flex; align-items: center; padding: 0 16px; box-shadow: 0 2px 8px rgba(0,0,0,.18); position: sticky; top: 0; z-index: 10; }
        .topbar .brand { background: rgba(0,0,0,.22); height: 100%; display: flex; align-items: center; padding: 0 22px; font-size: 1.3rem; font-weight: 600; margin-left: -16px; }
        .topbar .instansi { margin-left: 20px; font-weight: 500; letter-spacing: 1px; font-size: .9rem; }

        .layout { display: flex; min-height: calc(100vh - 56px); }

        .sidebar { width: 230px; background: linear-gradient(180deg, var(--side-a), var(--side-b)); flex-shrink: 0; }
        .sidebar a { display: block; color: #fff; text-decoration: none; padding: 13px 18px; font-weight: 500; font-size: .82rem; letter-spacing: .5px; border-bottom: 1px solid rgba(255,255,255,.12); transition: background .15s, padding-left .15s; }
        .sidebar a:hover { background: rgba(255,255,255,.12); padding-left: 22px; }
        .sidebar a.active { background: rgba(255,255,255,.2); border-left: 4px solid #fff; }
        .sidebar .toggle { display: flex; justify-content: space-between; align-items: center; }
        .sidebar .toggle::after { content: "\F282"; font-family: "bootstrap-icons"; font-size: .7rem; transition: transform .2s; }
        .sidebar .toggle:not(.collapsed)::after { transform: rotate(180deg); }
        .sidebar .sub { background: rgba(0,0,0,.2); }
        .sidebar .sub a { font-weight: 400; font-size: .8rem; padding-left: 32px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .sidebar .sub a:hover { padding-left: 36px; }

        .content { flex: 1; min-width: 0; }
        .tabbar { background: var(--tab); padding: 0 24px; min-height: 46px; }
        .tabbar a { color: #fff; text-decoration: none; display: inline-block; padding: 13px 18px; font-weight: 500; font-size: .85rem; opacity: .85; }
        .tabbar a:hover { opacity: 1; }
        .tabbar a.active { border-bottom: 3px solid #fff; opacity: 1; }

        .page { padding: 26px 32px; }
        .page h1 { font-weight: 600; font-size: 1.6rem; color: var(--heading); margin-bottom: 20px; }

        .card-box { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(15,23,42,.07); padding: 22px; }

        .table { background: #fff; border-radius: 10px; overflow: hidden; }
        .table thead th { background: var(--thead-bg); color: var(--thead-text); font-size: .82rem; font-weight: 600; border-bottom: 0; padding: 12px; }
        .table tbody tr:nth-child(odd) { background: #f8fafc; }
        .table tbody tr:hover { background: #ecfdf5; }
        .table td { padding: 12px; vertical-align: middle; }

        .btn-oren { background: var(--primary); color: #fff; font-weight: 500; font-size: .8rem; border-radius: 8px; padding: 6px 14px; border: 0; }
        .btn-oren:hover { background: var(--primary-dark); color: #fff; }
        .pill { background: var(--thead-bg); color: var(--thead-text); padding: 3px 10px; border-radius: 12px; font-size: .75rem; font-weight: 500; }

        .form-control, .form-select { border-radius: 8px; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="brand">Simkari<span class="ms-1">BB</span></div>
        <div class="instansi">TRACKING BARANG BUKTI</div>
        <div class="ms-auto dropdown">
            <a href="#" class="text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-fill"></i> {{ strtoupper(auth()->user()->name) }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="layout">
        <nav class="sidebar">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">BERANDA</a>

            <a href="#menuMaster" data-bs-toggle="collapse"
               class="toggle {{ request()->is('master/*') ? '' : 'collapsed' }}">MASTER</a>
            <div class="collapse sub {{ request()->is('master/*') ? 'show' : '' }}" id="menuMaster">
                <a href="{{ route('gudang.index') }}" class="{{ request()->is('master/gudang*') ? 'active' : '' }}">Gudang</a>
                <a href="{{ route('rak.index') }}" class="{{ request()->is('master/rak*') ? 'active' : '' }}">Rak</a>
            </div>

            <a href="#menuPerkara" data-bs-toggle="collapse"
               class="toggle {{ request()->is('perkara*') ? '' : 'collapsed' }}">PERKARA</a>
            <div class="collapse sub {{ request()->is('perkara*') ? 'show' : '' }}" id="menuPerkara">
                <a href="{{ route('perkara.index') }}" class="{{ request()->routeIs('perkara.index') ? 'active' : '' }}">Data Perkara</a>
                <a href="{{ route('perkara.create') }}" class="{{ request()->routeIs('perkara.create') ? 'active' : '' }}">Tambah Perkara</a>
            </div>

            <a href="#menuBB" data-bs-toggle="collapse"
               class="toggle {{ request()->is('barang-bukti*') ? '' : 'collapsed' }}">BARANG BUKTI</a>
            <div class="collapse sub {{ request()->is('barang-bukti*') ? 'show' : '' }}" id="menuBB">
                <a href="{{ route('barang-bukti.index') }}" class="{{ request()->routeIs('barang-bukti.index') ? 'active' : '' }}">Data Barang Bukti</a>
                <a href="{{ route('barang-bukti.create') }}" class="{{ request()->routeIs('barang-bukti.create') ? 'active' : '' }}">Tambah Barang Bukti</a>
            </div>

            <a href="{{ route('riwayat-lokasi.index') }}" class="{{ request()->routeIs('riwayat-lokasi.index') ? 'active' : '' }}">RIWAYAT LOKASI</a>
        </nav>

        <main class="content">
            <div class="tabbar">
                @yield('tabs')
            </div>
            <div class="page">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>