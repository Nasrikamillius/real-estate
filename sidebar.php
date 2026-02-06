<style>
    :root { --sidebar-bg: #0f172a; --accent: #38bdf8; --text-gray: #94a3b8; }
    .sidebar { width: 280px; background: var(--sidebar-bg); height: 100vh; position: fixed; left: 0; top: 0; padding: 30px 20px; color: white; display: flex; flex-direction: column; z-index: 1000; }
    .sidebar h2 { color: var(--accent); font-weight: 800; font-size: 1.4rem; margin-bottom: 35px; display: flex; align-items: center; gap: 10px; }
    .nav-group { margin-bottom: 25px; }
    .nav-label { font-size: 0.65rem; text-transform: uppercase; color: #475569; letter-spacing: 1.5px; display: block; margin-bottom: 10px; padding-left: 10px; }
    .nav-link { display: flex; align-items: center; gap: 15px; padding: 12px 18px; color: var(--text-gray); text-decoration: none; border-radius: 12px; font-weight: 600; transition: 0.3s; margin-bottom: 5px; }
    .nav-link:hover, .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); }
    .nav-link i { width: 20px; }
</style>

<aside class="sidebar">
    <h2><i class="fas fa-gem"></i> ELITE ADMIN</h2>
    
    <div class="nav-group">
        <span class="nav-label">Main Control</span>
        <a href="dashboard.php" class="nav-link active"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-circle"></i> Pakia Mali Mpya</a>
    </div>

    <div class="nav-group">
        <span class="nav-label">Approvals</span>
        <a href="admin_approve_listings.php" class="nav-link"><i class="fas fa-home"></i> Idhinisha Mali</a>
        <a href="admin_approve_bookings.php" class="nav-link"><i class="fas fa-calendar-check"></i> Maombi ya Booking</a>
    </div>

    <div class="nav-group">
        <span class="nav-label">Management</span>
        <a href="tenants_list.php" class="nav-link"><i class="fas fa-users"></i> Wapangaji</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-chart-line"></i> Ripoti ya Mapato</a>
    </div>

    <a href="logout.php" class="nav-link" style="margin-top: auto; color: #f87171;"><i class="fas fa-power-off"></i> Logout</a>
</aside>