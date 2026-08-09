<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ $siteSettings['site_name'] ?? 'LandMark' }} Admin</title>

    @if (!empty($siteSettings['site_favicon']))
        <link rel="icon" href="{{ asset($siteSettings['site_favicon']) }}" type="image/x-icon">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #1a2b4a;
            --primary-dark: #0f1d33;
            --accent: #b8962e;
            --accent-light: #d4af55;
            --sidebar-width: 260px;
            --topbar-height: 60px;
            --bg: #f4f6f9;
            --white: #fff;
            --border: #e2e8f0;
            --text: #2d3748;
            --text-muted: #718096;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--primary-dark);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.3rem;
        }

        .sidebar-brand img {
            height: 44px;
            width: auto;
            object-fit: contain;
        }

        .sidebar-badge {
            font-size: 0.6rem;
            background: var(--accent);
            color: #fff;
            padding: 2px 6px;
            border-radius: 10px;
            letter-spacing: 1px;
            vertical-align: middle;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-section-title {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            padding: 0.8rem 1.5rem 0.4rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s;
            position: relative;
        }

        .sidebar-link i {
            font-size: 1rem;
            width: 20px;
            flex-shrink: 0;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--accent);
        }

        .sidebar-link.active i {
            color: var(--accent-light);
        }

        .sidebar-link .badge {
            font-size: 0.68rem;
            margin-left: auto;
        }

        /* Topbar */
        .admin-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            z-index: 999;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        /* Main content */
        .admin-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 2rem;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* Cards */
        .admin-card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        .admin-card .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            background: transparent;
            font-weight: 600;
            color: var(--primary);
            font-size: 0.95rem;
        }

        .admin-card .card-body {
            padding: 1.5rem;
        }

        /* Stat cards */
        .stat-card {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Cormorant Garamond', serif;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }

        /* Table */
        .admin-table {
            font-size: 0.875rem;
        }

        .admin-table thead th {
            background: var(--bg);
            border-bottom: 2px solid var(--border);
            font-weight: 600;
            color: var(--text);
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
        }

        .admin-table tbody tr:hover {
            background: rgba(26, 43, 74, 0.02);
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* Forms */
        .form-control,
        .form-select {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 0.9rem;
            font-size: 0.88rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(184, 150, 46, 0.15);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.4rem;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-accent {
            background: var(--accent);
            border: none;
            color: #fff;
        }

        .btn-accent:hover {
            background: var(--accent-light);
            color: #fff;
        }

        /* Image preview */
        .img-preview-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .img-preview-item {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--border);
        }

        .img-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .img-preview-item .remove-img {
            position: absolute;
            top: 2px;
            right: 2px;
            background: rgba(220, 53, 69, 0.9);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        /* Alerts */
        .alert {
            font-size: 0.875rem;
            border-radius: 8px;
        }

        /* Page title */
        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            color: var(--primary);
            margin: 0;
        }

        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-topbar,
            .admin-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            @if (!empty($siteSettings['site_logo']))
                <img src="{{ asset($siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'LandMark' }}">
            @else
                <img src="{{ asset('logo.jpeg') }}" alt="Admin Logo" onerror="this.style.display='none'">
            @endif
            <div class="sidebar-badge">ADMIN PANEL</div>
        </div>

        @php
            $isAdmin = auth()->check() && auth()->user()->isAdmin();
            $canSee = function (string $key) use ($allowedMenus, $isAdmin): bool {
                return $isAdmin || in_array('*', $allowedMenus) || in_array($key, $allowedMenus);
            };
        @endphp

        <nav class="sidebar-nav">
            <div class="sidebar-section-title">Main</div>
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            @if ($canSee('properties') || $canSee('categories'))
                <div class="sidebar-section-title mt-2">Properties</div>
                @if ($canSee('properties'))
                    <a href="{{ route('admin.properties.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                        <i class="bi bi-houses"></i> All Properties
                    </a>
                    <a href="{{ route('admin.properties.create') }}"
                        class="sidebar-link {{ request()->routeIs('admin.properties.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-square"></i> Add Property
                    </a>
                @endif
                @if ($canSee('categories'))
                    <a href="{{ route('admin.categories.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Categories
                    </a>
                @endif
            @endif

            @if ($canSee('bookings'))
                <div class="sidebar-section-title mt-2">Bookings</div>
                <a href="{{ route('admin.bookings.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> All Bookings
                    @php
                        try {
                            $pendingCount = \App\Models\Booking::where('status', 'pending')->count();
                        } catch (\Throwable $e) {
                            $pendingCount = 0;
                        }
                    @endphp
                    @if ($pendingCount > 0)
                        <span class="badge bg-warning text-dark">{{ $pendingCount }}</span>
                    @endif
                </a>
            @endif

            @if ($canSee('testimonials') || $canSee('messages'))
                <div class="sidebar-section-title mt-2">Content</div>
                @if ($canSee('testimonials'))
                    <a href="{{ route('admin.testimonials.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-quote"></i> Testimonials
                    </a>
                @endif
                @if ($canSee('messages'))
                    <a href="{{ route('admin.messages.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope"></i> Messages
                        @php
                            try {
                                $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count();
                            } catch (\Throwable $e) {
                                $unreadCount = 0;
                            }
                        @endphp
                        @if ($unreadCount > 0)
                            <span class="badge bg-danger">{{ $unreadCount }}</span>
                        @endif
                    </a>
                @endif
            @endif

            @if ($canSee('settings') || $canSee('employees') || $canSee('permissions'))
                <div class="sidebar-section-title mt-2">Settings</div>
                @if ($canSee('settings'))
                    <a href="{{ route('admin.settings.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i> Website Settings
                    </a>
                @endif
                @if ($canSee('employees'))
                    <a href="{{ route('admin.employees.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Employees
                    </a>
                @endif
                @if ($canSee('permissions'))
                    <a href="{{ route('admin.permissions.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-check"></i> Permissions
                    </a>
                @endif
            @endif

            <div class="sidebar-section-title mt-2">Account</div>
            <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                <i class="bi bi-globe"></i> View Website
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-100 text-start border-0 bg-transparent"
                    style="color:rgba(255,255,255,0.7);">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    <!-- Topbar -->
    <header class="admin-topbar">
        <button class="btn btn-sm d-lg-none me-3" id="sidebarToggle" style="color:var(--primary);">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="flex-grow-1">
            <span style="font-size:0.9rem;color:var(--text-muted);">@yield('breadcrumb', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.profile.edit') }}"
                style="font-size:0.85rem;color:var(--text-muted);text-decoration:none;">
                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                <span class="badge ms-1"
                    style="background:var(--accent);font-size:0.65rem;">{{ ucfirst(auth()->user()->role) }}</span>
            </a>
        </div>
    </header>

    <!-- Content -->
    <div class="admin-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#sidebarToggle').on('click', function() {
            $('#adminSidebar').toggleClass('open');
        });

        // Delete confirmation
        $(document).on('submit', '.form-delete', function(e) {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
