<?php 
include 'db_connect.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Wapangaji | Smart Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --accent: #38bdf8; --sidebar-bg: #0f172a; }
        body { background: #f8fafc; font-family: 'Inter', sans-serif; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); position: fixed; color: white; padding: 25px 15px; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 800; color: var(--accent); margin-bottom: 35px; text-align: center; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 12px; margin-bottom: 5px; display: flex; align-items: center; text-decoration: none; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); font-weight: 600; border-right: 4px solid var(--accent); }
        .main-content { margin-left: 280px; padding: 40px; }
        .tenant-card { background: white; border-radius: 20px; padding: 25px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">SMART ESTATE</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
        <a class="nav-link" href="admin_add_property.php"><i class="fas fa-plus-circle me-2"></i> Ongeza Mali</a>
        <a class="nav-link" href="admin_manage_properties.php"><i class="fas fa-tasks me-2"></i> Simamia Mali</a>
        <a class="nav-link" href="admin_approve_bookings.php"><i class="fas fa-check-circle me-2"></i> Maombi</a>
        <a class="nav-link active" href="admin_tenants.php"><i class="fas fa-users me-2"></i> Wapangaji</a>
        <a class="nav-link" href="admin_payments.php"><i class="fas fa-wallet me-2"></i> Malipo</a>
        <a class="nav-link" href="admin_maintenance.php"><i class="fas fa-tools me-2"></i> Matengenezo</a>
        <a class="nav-link" href="admin_messages.php"><i class="fas fa-envelope me-2"></i> Ujumbe</a>
        <a class="nav-link" href="admin_settings.php"><i class="fas fa-cog me-2"></i> Mipangilio</a>
    </nav>
</div>

<div class="main-content">
    <h2 class="fw-bold mb-4">Wapangaji Waliopo (Active) 🏘️</h2>
    <div class="tenant-card">
        <table class="table align-middle">
            <thead class="table-light">
                <tr><th>MTEJA</th><th>MALI ILIYOPANGWA</th><th>TAREHE YA KUINGIA</th><th>HALI</th><th>ACTION</th></tr>
            </thead>
            <tbody>
                <?php 
                // JOIN ili kupata jina la nyumba na data ya mpangaji
                $stmt = $pdo->query("SELECT b.*, p.title FROM bookings b JOIN properties p ON b.property_id = p.property_id WHERE b.status = 'Approved'");
                while($row = $stmt->fetch()): ?>
                <tr>
                    <td><div class="d-flex align-items-center"><i class="fas fa-user-circle fa-2x me-2 text-secondary"></i> ID #<?php echo $row['user_id']; ?></div></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td><span class="badge bg-success rounded-pill">Active</span></td>
                    <td><button class="btn btn-sm btn-outline-primary">View Profile</button></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>