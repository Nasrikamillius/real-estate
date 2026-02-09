<?php 
include 'db_connect.php'; 
session_start();

// 1. Chota Takwimu Moja kwa Moja kutoka Database
$total_mali = $pdo->query("SELECT COUNT(*) FROM properties")->fetchColumn();
$maombi_mapya = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Pending'")->fetchColumn();
$pesa_iliyopatikana = $pdo->query("SELECT SUM(amount) FROM bookings WHERE status = 'Approved'")->fetchColumn();
$ujumbe_mpya = 5; // Hii unaweza kuilink na table ya messages baadae
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Smart Estate Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --accent: #38bdf8; --sidebar-bg: #0f172a; --glass: rgba(255, 255, 255, 0.8); }
        body { 
            background: url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover; font-family: 'Inter', sans-serif;
        }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(241, 245, 249, 0.9); z-index: -1; }
        
        /* Sidebar Design */
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); position: fixed; color: white; padding: 25px 15px; box-shadow: 10px 0 40px rgba(0,0,0,0.2); }
        .sidebar-brand { font-size: 1.6rem; font-weight: 800; color: var(--accent); margin-bottom: 35px; text-align: center; letter-spacing: 1px; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 15px; margin-bottom: 5px; display: flex; align-items: center; transition: 0.4s; text-decoration: none; }
        .nav-link i { width: 30px; font-size: 1.1rem; }
        .nav-link:hover, .nav-link.active { background: rgba(56, 189, 248, 0.15); color: var(--accent); font-weight: 600; }
        
        /* Main Content */
        .main-content { margin-left: 280px; padding: 40px; }
        .glass-card { background: var(--glass); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.5); border-radius: 30px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
        
        /* Stat Widgets */
        .stat-widget { background: white; border-radius: 25px; padding: 25px; display: flex; align-items: center; justify-content: space-between; transition: 0.3s; border: 1px solid #edf2f7; }
        .stat-widget:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .icon-circle { width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    </style>
</head>
<body>
<div class="overlay"></div>

<div class="sidebar">
    <div class="sidebar-brand">SMART ESTATE</div>
    <nav class="nav flex-column">
        <a class="nav-link active" href="dashboard.php"><i class="fas fa-grid-2"></i> Dashboard</a>
        <a class="nav-link" href="admin_add_property.php"><i class="fas fa-plus-circle"></i> Ongeza Mali</a>
        <a class="nav-link" href="admin_manage_properties.php"><i class="fas fa-home"></i> Simamia Mali</a>
        <a href="admin_approve_properties.php" class="nav-link">
    <i class="fas fa-check-double me-2"></i> Uhakiki wa Mali
    <?php 
        // Hii kodi itahesabu mali ngapi mpya zimetumwa na wateja
        $stmt = $pdo->query("SELECT COUNT(*) FROM properties WHERE status = 'Pending'");
        $p_count = $stmt->fetchColumn();
        if($p_count > 0) echo "<span class='badge bg-danger ms-auto'>$p_count</span>";
    ?>
</a>

<a href="admin_approve_bookings.php" class="nav-link">
    <i class="fas fa-calendar-check me-2"></i> Maombi ya Wateja
</a>
        <a class="nav-link" href="admin_payments.php"><i class="fas fa-wallet"></i> Ripoti ya Fedha</a>
        <a class="nav-link" href="admin_maintenance.php"><i class="fas fa-tools"></i> Matengenezo</a>
        <a class="nav-link" href="admin_messages.php"><i class="fas fa-comment-alt-lines"></i> Ujumbe</a>
        <a class="nav-link" href="admin_settings.php"><i class="fas fa-sliders-h"></i> Mipangilio</a>
        <a class="nav-link text-danger mt-5" href="logout.php"><i class="fas fa-power-off"></i> Toka Nje</a>
    </nav>
</div>

<div class="main-content">
    <header class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Karibu, Bosi! 👋</h2>
            <p class="text-muted">Hali ya biashara yako leo Feb 9, 2026.</p>
        </div>
        <div class="d-flex gap-3 align-items-center bg-white p-2 rounded-pill shadow-sm pe-4">
            <img src="https://ui-avatars.com/api/?name=Admin&background=0f172a&color=fff" class="rounded-circle" width="45">
            <span class="fw-bold">Admin Panel</span>
        </div>
    </header>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-widget">
                <div><small class="text-muted d-block mb-1">Jumla ya Mali</small><h3 class="fw-bold mb-0"><?php echo $total_mali; ?></h3></div>
                <div class="icon-circle bg-primary text-white bg-opacity-10" style="color: #0d6efd !important;"><i class="fas fa-home"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-widget">
                <div><small class="text-muted d-block mb-1">Maombi Mapya</small><h3 class="fw-bold mb-0 text-warning"><?php echo $maombi_mapya; ?></h3></div>
                <div class="icon-circle bg-warning text-white bg-opacity-10" style="color: #ffc107 !important;"><i class="fas fa-clock"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-widget">
                <div><small class="text-muted d-block mb-1">Mapato Leo</small><h3 class="fw-bold mb-0 text-success">TZS <?php echo number_format($pesa_iliyopatikana); ?></h3></div>
                <div class="icon-circle bg-success text-white bg-opacity-10" style="color: #198754 !important;"><i class="fas fa-hand-holding-usd"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-widget">
                <div><small class="text-muted d-block mb-1">Inbox</small><h3 class="fw-bold mb-0"><?php echo $ujumbe_mpya; ?></h3></div>
                <div class="icon-circle bg-info text-white bg-opacity-10" style="color: #0dcaf0 !important;"><i class="fas fa-envelope-open-text"></i></div>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Mali Zilizowekwa Hivi Karibuni</h5>
            <a href="admin_manage_properties.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">Ona Zote</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th>MALI</th>
                        <th>BEI</th>
                        <th>MAHALI</th>
                        <th>HALI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $recent = $pdo->query("SELECT * FROM properties ORDER BY property_id DESC LIMIT 4");
                    while($row = $recent->fetch()): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="uploads/<?php echo $row['image_name']; ?>" class="rounded-3 me-3 shadow-sm" width="55" height="45" style="object-fit:cover;">
                                <span class="fw-bold text-dark"><?php echo $row['title']; ?></span>
                            </div>
                        </td>
                        <td class="fw-bold">TZS <?php echo number_format($row['price']); ?></td>
                        <td><i class="fas fa-map-marker-alt text-danger me-1 small"></i> <?php echo $row['location']; ?></td>
                        <td><span class="badge rounded-pill <?php echo ($row['status']=='Available') ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger'; ?> px-3"><?php echo $row['status']; ?></span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>