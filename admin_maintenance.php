<?php 
include 'db_connect.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Matengenezo | Smart Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --accent: #38bdf8; --sidebar-bg: #0f172a; }
        body { background: #f8fafc; font-family: 'Inter', sans-serif; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); position: fixed; color: white; padding: 25px 15px; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 800; color: var(--accent); margin-bottom: 35px; text-align: center; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 12px; margin-bottom: 5px; display: flex; align-items: center; text-decoration: none; }
        .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); font-weight: 600; }
        .main-content { margin-left: 280px; padding: 40px; }
        .work-order { background: white; border-radius: 15px; padding: 20px; margin-bottom: 15px; border-left: 5px solid #f59e0b; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">SMART ESTATE</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
        <a class="nav-link" href="admin_add_property.php"><i class="fas fa-plus-circle me-2"></i> Ongeza</a>
        <a class="nav-link" href="admin_manage_properties.php"><i class="fas fa-tasks me-2"></i> Simamia</a>
        <a class="nav-link" href="admin_approve_bookings.php"><i class="fas fa-check-circle me-2"></i> Maombi</a>
        <a class="nav-link" href="admin_tenants.php"><i class="fas fa-users me-2"></i> Wapangaji</a>
        <a class="nav-link" href="admin_payments.php"><i class="fas fa-wallet me-2"></i> Malipo</a>
        <a class="nav-link active" href="admin_maintenance.php"><i class="fas fa-tools me-2"></i> Matengenezo</a>
        <a class="nav-link" href="admin_messages.php"><i class="fas fa-envelope me-2"></i> Ujumbe</a>
        <a class="nav-link" href="admin_settings.php"><i class="fas fa-cog me-2"></i> Mipangilio</a>
    </nav>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Ripoti za Matengenezo 🛠️</h2>
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">3 New Issues</span>
    </div>

    <div class="work-order shadow-sm">
        <div class="d-flex justify-content-between">
            <h5 class="fw-bold text-dark">Bomba limepasuka - Jikoni</h5>
            <span class="text-muted small">Masaa 2 yaliyopita</span>
        </div>
        <p class="small text-secondary mb-2">Mpangaji: ID #402 | Masaki Heights, Room 3B</p>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-warning fw-bold px-4">Tuma Fundi</button>
            <button class="btn btn-sm btn-light px-4">Weka Pending</button>
        </div>
    </div>
</div>
</body>
</html>