<?php
session_start();
require 'db_connect.php';

// Vuta wapangaji wote (Wale ambao booking zao ziko 'Confirmed')
$tenants = $pdo->query("SELECT b.booking_id, u.full_name, u.phone, u.email, p.title, p.price, p.location, b.status 
                        FROM bookings b 
                        JOIN users u ON b.client_id = u.user_id 
                        JOIN properties p ON b.property_id = p.property_id 
                        WHERE b.status = 'Confirmed' 
                        ORDER BY b.booking_id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Wapangaji Rasmi | Elite Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --accent-blue: #38bdf8;
            --main-bg: #f8fafc;
            --gold: #fbbf24;
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
        
        .tenant-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; }
        
        .t-card { 
            background: white; border-radius: 35px; padding: 30px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.03);
            position: relative; overflow: hidden; transition: 0.4s;
        }
        .t-card:hover { transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.06); }
        
        .t-card::before {
            content: ''; position: absolute; top: 0; right: 0; width: 80px; height: 80px;
            background: rgba(56, 189, 248, 0.1); border-radius: 0 0 0 100%;
        }

        .t-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .t-avatar { 
            width: 60px; height: 60px; background: var(--sidebar-bg); border-radius: 20px; 
            display: flex; align-items: center; justify-content: center; color: var(--accent-blue); font-size: 1.5rem;
        }
        
        .t-info h3 { margin: 0; font-weight: 800; color: var(--sidebar-bg); }
        .t-info p { margin: 2px 0; font-size: 0.85rem; color: #64748b; font-weight: 600; }

        .prop-box { 
            background: #f1f5f9; padding: 15px; border-radius: 20px; margin: 20px 0;
            display: flex; justify-content: space-between; align-items: center;
        }
        .prop-box span { font-size: 0.8rem; font-weight: 700; color: #475569; }

        .btn-receipt { 
            display: block; width: 100%; padding: 15px; border-radius: 18px; 
            background: var(--sidebar-bg); color: white; text-decoration: none; 
            text-align: center; font-weight: 800; font-size: 0.9rem; transition: 0.3s;
        }
        .btn-receipt:hover { background: var(--accent-blue); color: var(--sidebar-bg); }

        .badge-verified {
            position: absolute; top: 20px; right: 20px; color: var(--accent-blue); font-size: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fas fa-gem"></i> ELITE</h2>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-square"></i> Ongeza Mali</a>
        <a href="admin_manage_properties.php" class="nav-link"><i class="fas fa-building"></i> Dhibiti Mali</a>
        <a href="admin_approve_bookings.php" class="nav-link"><i class="fas fa-check-double"></i> Bookings</a>
        <a href="tenants_list.php" class="nav-link active"><i class="fas fa-users-gear"></i> Wapangaji</a>
        <a href="manage_maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Mapato</a>
        <a href="settings.php" class="nav-link"><i class="fas fa-sliders"></i> Mipangilio</a>
        <div style="height: 100px;"></div>
        <a href="logout.php" class="nav-link" style="color: #fb7185;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1 style="font-weight: 800; font-size: 2.2rem; color: var(--sidebar-bg); margin-bottom: 5px;">Wapangaji Wako Rasmi</h1>
        <p style="color: #64748b; font-weight: 500; margin-bottom: 40px;">Orodha ya wateja wenye mikataba hai na waliohakikiwa.</p>

        <div class="tenant-grid">
            <?php foreach($tenants as $t): ?>
            <div class="t-card">
                <i class="fas fa-certificate badge-verified"></i>
                <div class="t-header">
                    <div class="t-avatar"><i class="fas fa-user-tie"></i></div>
                    <div class="t-info">
                        <h3><?php echo $t['full_name']; ?></h3>
                        <p><i class="fas fa-phone"></i> <?php echo $t['phone']; ?></p>
                    </div>
                </div>

                <div class="prop-box">
                    <div>
                        <span>ANAPOISHI</span>
                        <div style="font-weight: 800; color: var(--sidebar-bg);"><?php echo $t['title']; ?></div>
                    </div>
                    <div style="text-align: right;">
                        <span>KODI</span>
                        <div style="font-weight: 800; color: #10b981;">TZS <?php echo number_format($t['price']); ?></div>
                    </div>
                </div>

                <p style="font-size: 0.8rem; color: #94a3b8; text-align: center; margin-bottom: 15px;">
                    <i class="fas fa-map-marker-alt"></i> <?php echo $t['location']; ?>
                </p>

                <a href="print_receipt.php?id=<?php echo $t['booking_id']; ?>" class="btn-receipt">
                    <i class="fas fa-file-invoice"></i> TOA RISITI RASMI
                </a>
            </div>
            <?php endforeach; ?>

            <?php if(empty($tenants)) echo "<p style='color: #94a3b8;'>Hakuna mpangaji aliyethibitishwa bado.</p>"; ?>
        </div>
    </div>

</body>
</html>