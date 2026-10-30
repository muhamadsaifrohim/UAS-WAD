<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventaris Gudang')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --sidebar-bg: #0f172a;
            --page-bg: #f1f5f9;
            --bs-primary: #4f46e5;
            --bs-primary-rgb: 79, 70, 229;
            --bs-link-color: #4f46e5;
            --bs-link-hover-color: #4338ca;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: var(--page-bg);
            color: #1e293b;
        }

        /* ---------- Tombol & form ---------- */
        .btn { border-radius: 10px; font-weight: 500; }
        .btn-primary { --bs-btn-bg: var(--primary); --bs-btn-border-color: var(--primary);
            --bs-btn-hover-bg: var(--primary-dark); --bs-btn-hover-border-color: var(--primary-dark);
            --bs-btn-active-bg: var(--primary-dark); --bs-btn-active-border-color: var(--primary-dark); }
        .form-control, .form-select { border-radius: 10px; padding: .6rem .85rem; border-color: #cbd5e1; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 .2rem rgba(79,70,229,.15); }
        .form-label { font-weight: 500; font-size: .875rem; color: #334155; }

        /* ---------- Kartu & tabel ---------- */
        .card { border: 0; border-radius: 16px; box-shadow: 0 1px 3px rgba(15,23,42,.06), 0 4px 16px rgba(15,23,42,.04); }
        .card-header { background: #fff; border-bottom: 1px solid #eef2f7; border-radius: 16px 16px 0 0 !important; padding: 1rem 1.25rem; font-weight: 600; }
        .table { --bs-table-hover-bg: #f8fafc; }
        .table thead th, .table-light { background: #f8fafc !important; color: #64748b; font-size: .75rem; text-transform: uppercase; letter-spacing: .04em; font-weight: 600; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
        .table td, .table th { padding: .85rem 1rem; }
        .table > :not(caption) > * > * { border-bottom-color: #eef2f7; }
        .badge { font-weight: 500; padding: .4em .7em; border-radius: 8px; }
        .alert { border: 0; border-radius: 12px; }
        .pagination { --bs-pagination-active-bg: var(--primary); --bs-pagination-active-border-color: var(--primary); }

        /* ---------- Kerangka aplikasi (sidebar) ---------- */
        .app-shell { display: flex; min-height: 100vh; }
        .sidebar { --bs-offcanvas-width: 270px; }
        .sidebar-inner { background: var(--sidebar-bg); color: #94a3b8; height: 100%; display: flex; flex-direction: column; padding: 1.25rem 1rem; }
        .sidebar-brand { display: flex; align-items: center; gap: .75rem; padding: .25rem .5rem 1.5rem; color: #fff; text-decoration: none; }
        .sidebar-brand .logo { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #4f46e5); display: grid; place-items: center; font-size: 1.25rem; color: #fff; }
        .sidebar-brand .name { font-weight: 700; line-height: 1.1; }
        .sidebar-brand .name small { display: block; font-weight: 400; font-size: .72rem; color: #64748b; }
        .nav-label { font-size: .68rem; letter-spacing: .08em; text-transform: uppercase; color: #475569; padding: 1.1rem .75rem .4rem; font-weight: 600; }
        .side-link { display: flex; align-items: center; gap: .75rem; padding: .65rem .85rem; border-radius: 10px; color: #94a3b8; text-decoration: none; font-weight: 500; font-size: .92rem; margin-bottom: 2px; transition: background .15s, color .15s; }
        .side-link i { font-size: 1.1rem; }
        .side-link:hover { background: rgba(255,255,255,.06); color: #fff; }
        .side-link.active { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(79,70,229,.35); }
        .sidebar-user { margin-top: auto; background: rgba(255,255,255,.05); border-radius: 14px; padding: .85rem; }
        .sidebar-user .avatar { width: 38px; height: 38px; border-radius: 50%; background: #6366f1; color: #fff; display: grid; place-items: center; font-weight: 700; flex: 0 0 38px; }
        .sidebar-user .uname { color: #fff; font-weight: 600; font-size: .88rem; line-height: 1.2; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .role-pill { display: inline-block; font-size: .65rem; font-weight: 600; text-transform: uppercase; padding: .1rem .5rem; border-radius: 20px; letter-spacing: .04em; }
        .role-admin { background: rgba(239,68,68,.18); color: #fca5a5; }
        .role-staff { background: rgba(148,163,184,.2); color: #cbd5e1; }
        .btn-logout { width: 100%; margin-top: .75rem; background: rgba(255,255,255,.08); color: #e2e8f0; border: 0; border-radius: 10px; padding: .5rem; font-size: .85rem; }
        .btn-logout:hover { background: rgba(239,68,68,.25); color: #fff; }

        .content { flex: 1 1 auto; min-width: 0; }
        .content-inner { padding: 2rem; max-width: 1280px; margin: 0 auto; }
        .content-inner h3 { font-size: 1.4rem; font-weight: 700; letter-spacing: -.01em; }
        .topbar { position: sticky; top: 0; z-index: 1020; background: var(--sidebar-bg); color: #fff; display: flex; align-items: center; gap: .75rem; padding: .75rem 1rem; }
        .topbar .btn { color: #fff; border: 0; font-size: 1.4rem; padding: 0 .4rem; }

        @media (min-width: 992px) {
            .sidebar { flex: 0 0 270px; width: 270px !important; position: sticky !important; top: 0; height: 100vh !important; }
        }
        @media (max-width: 991.98px) {
            .app-shell { display: block; }
            .content-inner { padding: 1.25rem 1rem; }
        }

        /* ---------- Kartu statistik dashboard ---------- */
        .stat-card { display: flex; align-items: center; gap: 1rem; background: #fff; border-radius: 16px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(15,23,42,.06), 0 4px 16px rgba(15,23,42,.04); height: 100%; }
        .stat-icon { width: 52px; height: 52px; border-radius: 14px; display: grid; place-items: center; font-size: 1.5rem; flex: 0 0 52px; }
        .ic-indigo { background: #e0e7ff; color: #4338ca; }
        .ic-green  { background: #dcfce7; color: #15803d; }
        .ic-amber  { background: #fef3c7; color: #b45309; }
        .ic-sky    { background: #e0f2fe; color: #0369a1; }
        .stat-label { color: #64748b; font-size: .8rem; font-weight: 500; }
        .stat-value { font-size: 1.7rem; font-weight: 700; line-height: 1.2; }

        /* ---------- Halaman login / register ---------- */
        .auth-wrap { display: flex; min-height: 100vh; background: #fff; }
        .auth-hero { flex: 1 1 50%; background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 55%, #6366f1 100%); color: #fff; padding: 4rem; display: flex; flex-direction: column; justify-content: center; }
        .auth-hero .logo { width: 56px; height: 56px; border-radius: 16px; background: rgba(255,255,255,.16); display: grid; place-items: center; font-size: 1.8rem; margin-bottom: 1.5rem; }
        .auth-hero h1 { font-weight: 700; font-size: 2.2rem; letter-spacing: -.02em; }
        .auth-hero p { color: #c7d2fe; max-width: 420px; }
        .auth-hero ul { list-style: none; padding: 0; margin: 2rem 0 0; }
        .auth-hero li { display: flex; align-items: center; gap: .75rem; margin-bottom: .85rem; color: #e0e7ff; }
        .auth-hero li i { background: rgba(255,255,255,.15); border-radius: 8px; padding: .35rem .5rem; }
        .auth-form { flex: 1 1 50%; display: flex; align-items: center; justify-content: center; padding: 2rem 1.25rem; }
        .auth-box { width: 100%; max-width: 410px; }
        .auth-box h2 { font-weight: 700; letter-spacing: -.01em; }
    </style>
</head>
<body>

@auth
<div class="app-shell">

    {{-- Bar atas (khusus layar kecil) --}}
    <header class="topbar d-lg-none">
        <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-label="Menu">
            <i class="bi bi-list"></i>
        </button>
        <span class="fw-bold">📦 Inventaris Gudang</span>
    </header>

    {{-- Sidebar --}}
    <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar">
        <div class="sidebar-inner">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <span class="logo"><i class="bi bi-box-seam-fill"></i></span>
                <span class="name">Inventaris<small>Manajemen Gudang</small></span>
            </a>

            <nav>
                <div class="nav-label">Menu Utama</div>
                <a href="{{ route('dashboard') }}" class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="side-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Produk
                </a>
                <a href="{{ route('stock-transactions.index') }}" class="side-link {{ request()->routeIs('stock-transactions.*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i> Transaksi Stok
                </a>

                <div class="nav-label">Data Master</div>
                <a href="{{ route('categories.index') }}" class="side-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Kategori
                </a>
                <a href="{{ route('suppliers.index') }}" class="side-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i> Supplier
                </a>

                @if (auth()->user()->isAdmin())
                    <div class="nav-label">Administrasi</div>
                    <a href="{{ route('users.index') }}" class="side-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Pengguna
                    </a>
                @endif
            </nav>

            <div class="sidebar-user">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="overflow-hidden">
                        <div class="uname">{{ auth()->user()->name }}</div>
                        <span class="role-pill {{ auth()->user()->isAdmin() ? 'role-admin' : 'role-staff' }}">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-logout"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Konten --}}
    <main class="content">
        <div class="content-inner">
            @include('partials.flash')
            @yield('content')
        </div>
    </main>
</div>
@else
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3 px-3" style="z-index:1080; width:100%; max-width:460px;">
        @include('partials.flash')
    </div>
    @yield('content')
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
