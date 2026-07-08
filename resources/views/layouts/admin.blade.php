<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Kain Tenun Sumba')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
    @stack('styles')
</head>
<body>

    @if(session('error'))
        <div class="alert-error-custom">{{ session('error') }}</div>
    @endif

    @if(!isset($hide_navbar))
        <nav class="admin-navbar">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                Kain Tenun Sumba
            </a>
            <ul class="admin-nav-links">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.jenis-motif.index') }}" class="{{ request()->routeIs('admin.jenis-motif.*') ? 'active' : '' }}">Kelola Jenis Motif</a></li>
                <li><a href="{{ route('admin.tarikan-visual.index') }}" class="{{ request()->routeIs('admin.tarikan-visual.*') ? 'active' : '' }}">Kelola Tarikan Visual</a></li>
                <li><a href="{{ route('admin.simetris.index') }}" class="{{ request()->routeIs('admin.simetris.*') ? 'active' : '' }}">Kelola Simetris</a></li>
            </ul>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="admin-logout">Logout</button>
            </form>
        </nav>
    @endif

    <main class="admin-main">
        @if(session('success'))
            <div class="alert-success-custom">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="admin-footer">
        <span>Kain Tenun Sumba &copy; {{ date('Y') }}</span>
        <span>Admin Panel</span>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>