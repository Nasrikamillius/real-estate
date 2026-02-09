<?php 
include 'db_connect.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Ujumbe | Smart Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --accent: #38bdf8; --sidebar-bg: #0f172a; }
        body { background: #f1f5f9; font-family: 'Inter', sans-serif; }
        
        /* Sidebar Styles */
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); position: fixed; color: white; padding: 25px 15px; z-index: 1000; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 800; color: var(--accent); margin-bottom: 35px; text-align: center; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 12px; margin-bottom: 5px; display: flex; align-items: center; text-decoration: none; transition: 0.3s; }
        .nav-link i { width: 25px; }
        .nav-link:hover, .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); font-weight: 600; }
        
        .main-content { margin-left: 280px; padding: 40px; }
        .msg-card { background: white; border-radius: 20px; padding: 20px; border-left: 5px solid var(--accent); margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">SMART ESTATE</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a class="nav-link" href="admin_add_property.php"><i class="fas fa-plus-circle"></i> Ongeza Mali</a>
        <a class="nav-link" href="admin_manage_properties.php"><i class="fas fa-tasks"></i> Simamia Mali</a>
        <a class="nav-link" href="admin_approve_bookings.php"><i class="fas fa-file-check"></i> Maombi ya Booking</a>
        <a class="nav-link" href="admin_tenants.php"><i class="fas fa-users"></i> Wapangaji Active</a>
        <a class="nav-link" href="admin_payments.php"><i class="fas fa-wallet"></i> Ripoti ya Malipo</a>
        <a class="nav-link" href="admin_maintenance.php"><i class="fas fa-tools"></i> Matengenezo</a>
        <a class="nav-link active" href="admin_messages.php"><i class="fas fa-envelope"></i> Ujumbe / Inbox</a>
        <a class="nav-link" href="admin_settings.php"><i class="fas fa-cog"></i> Mipangilio</a>
        
        <hr class="text-secondary">
        <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Toka Nje</a>
    </nav>
</div>

<div class="main-content">
    <h2 class="fw-bold mb-4">Ujumbe wa Wateja 📩</h2>
    
    <div class="msg-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-1">Musa Hashim</h6>
            <span class="badge bg-light text-dark rounded-pill">Dakika 5 zilizopita</span>
        </div>
        <p class="text-muted small">"Nimevutiwa na ile nyumba ya Tabata, naomba kujua kama naweza kuja kuiona kesho saa 4 asubuhi?"</p>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-primary rounded-pill px-3">Jibu</button>
            <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Futa</button>
        </div>
    </div>
</div>

</body>
</html>