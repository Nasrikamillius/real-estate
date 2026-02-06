<?php
session_start();
require 'db_connect.php';

// Logic ya kubadili status (Mbwembwe za hapa hapa)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $new_status = ($_GET['action'] == 'activate') ? 'Active' : 'Inactive';
    $stmt = $pdo->prepare("UPDATE properties SET status = ? WHERE property_id = ?");
    $stmt->execute([$new_status, $_GET['id']]);
    header("Location: admin_manage_properties.php?msg=Status Imesasishwa");
    exit();
}

// Vuta mali zote
$properties = $pdo->query("SELECT * FROM properties ORDER BY property_id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Dhibiti Mali | Elite Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --accent-blue: #38bdf8;
            --main-bg: #f8fafc;
            --success: #10b981;
            --danger: #f43f5e;
        }

        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--main-bg); display: flex; }

        /* --- SIDEBAR YA KUDUMU (Zile 9) --- */
        .sidebar {
            width: 280px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            height: 100vh; position: fixed; padding: 30px 20px; box-sizing: border-box; color: white;
        }
        .sidebar h2 { font-size: 1.8rem; font-weight: 800; color: var(--accent-blue); margin-bottom: 40px; }
        .nav-link {
            display: flex; align-items: center; gap: 15px; padding: 14px 20px; color: #94a3b8;
            text-decoration: none; border-radius: 16px; font-weight: 600; margin-bottom: 5px; transition: 0.4s;
        }
        .nav-link:hover, .nav-link.active { background: rgba(255, 255, 255, 0.1); color: var(--accent-blue); transform: translateX(8px); }
        .nav-link.active { background: var(--accent-blue); color: var(--sidebar-bg); }

        /* --- CONTENT --- */
        .main-content { margin-left: 280px; padding: 50px; width: calc(100% - 280px); }
        
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .header-flex h1 { font-weight: 800; font-size: 2.2rem; margin: 0; color: var(--sidebar-bg); }

        /* --- PROPERTY CARDS GRID --- */
        .property-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; }
        .p-card { 
            background: white; border-radius: 30px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.05); transition: 0.4s;
        }
        .p-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(0,0,0,0.08); }
        
        .p-img { width: 100%; height: 200px; object-fit: cover; }
        
        .p-body { padding: 25px; }
        .p-body h3 { margin: 0; font-weight: 800; font-size: 1.3rem; color: var(--sidebar-bg); }
        .p-body p { color: #64748b; font-size: 0.9rem; margin: 10px 0; }
        
        .p-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
        .price { font-weight: 800; color: var(--sidebar-bg); font-size: 1.1rem; }
        
        .status-badge { 
            padding: 6px 14px; border-radius: 12px; font-size: 0.75rem; font-weight: 800; 
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .Active { background: #dcfce7; color: #16a34a; }
        .Inactive { background: #fee2e2; color: #ef4444; }

        .btn-group { display: flex; gap: 10px; margin-top: 25px; }
        .btn-action { 
            flex: 1; padding: 12px; border-radius: 12px; text-decoration: none; 
            text-align: center; font-weight: 800; font-size: 0.8rem; transition: 0.3s;
        }
        .btn-activate { background: var(--success); color: white; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2); }
        .btn-deactivate { background: var(--danger); color: white; box-shadow: 0 4px 15px rgba(244, 63, 94, 0.2); }
        .btn-action:hover { opacity: 0.9; transform: scale(1.05); }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fas fa-gem"></i> ELITE</h2>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-square"></i> Ongeza Mali</a>
        <a href="admin_manage_properties.php" class="nav-link active"><i class="fas fa-building"></i> Dhibiti Mali</a>
        <a href="admin_approve_bookings.php" class="nav-link"><i class="fas fa-check-double"></i> Bookings</a>
        <a href="tenants_list.php" class="nav-link"><i class="fas fa-users-gear"></i> Wapangaji</a>
        <a href="manage_maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Mapato</a>
        <a href="settings.php" class="nav-link"><i class="fas fa-sliders"></i> Mipangilio</a>
        <div style="height: 100px;"></div>
        <a href="logout.php" class="nav-link" style="color: #fb7185;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="header-flex">
            <h1>Maktaba ya Mali</h1>
            <div style="background: white; padding: 10px 20px; border-radius: 15px; font-weight: 700;">
                Jumla: <span style="color: var(--accent-blue);"><?php echo count($properties); ?> Mali</span>
            </div>
        </div>

        <div class="property-grid">
            <?php foreach($properties as $p): ?>
            <div class="p-card">
                <img src="uploads/<?php echo $p['image_name']; ?>" class="p-img" onerror="this.src='https://via.placeholder.com/400x200?text=Picha+Itaonekana+Hapa'">
                <div class="p-body">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3><?php echo $p['title']; ?></h3>
                        <span class="status-badge <?php echo $p['status']; ?>"><?php echo $p['status']; ?></span>
                    </div>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo $p['location']; ?></p>
                    
                    <div class="p-meta">
                        <span class="price">TZS <?php echo number_format($p['price']); ?></span>
                    </div>

                    <div class="btn-group">
                        <?php if($p['status'] == 'Inactive'): ?>
                            <a href="?action=activate&id=<?php echo $p['property_id']; ?>" class="btn-action btn-activate">ACTIVATE</a>
                        <?php else: ?>
                            <a href="?action=deactivate&id=<?php echo $p['property_id']; ?>" class="btn-action btn-deactivate">DEACTIVATE</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>