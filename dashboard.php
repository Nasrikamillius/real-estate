<?php
session_start();
require 'db_connect.php';

// Takwimu za haraka
$total_mali = $pdo->query("SELECT COUNT(*) FROM properties WHERE status = 'Active'")->fetchColumn();
$pending_maint = $pdo->query("SELECT COUNT(*) FROM maintenance_requests WHERE status = 'Pending'")->fetchColumn();
$revenue = $pdo->query("SELECT SUM(p.price) FROM bookings b JOIN properties p ON b.property_id = p.property_id WHERE b.status = 'Confirmed'")->fetchColumn() ?: 0;
$pending_book = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Pending'")->fetchColumn();

// Recent Bookings
$recent_bookings = $pdo->query("SELECT b.*, u.full_name, p.title FROM bookings b 
                                JOIN users u ON b.client_id = u.user_id 
                                JOIN properties p ON b.property_id = p.property_id 
                                ORDER BY b.booking_id DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Premium Admin | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --accent-blue: #38bdf8;
            --main-bg: #f1f5f9;
            --glass: rgba(255, 255, 255, 0.9);
            --grad: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--main-bg);
            display: flex;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* --- SIDEBAR YA KISASA --- */
        .sidebar {
            width: 280px;
            background: var(--grad);
            height: 100vh;
            position: fixed;
            padding: 30px 20px;
            box-sizing: border-box;
            color: white;
            box-shadow: 10px 0 30px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--accent-blue);
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-shadow: 0 4px 10px rgba(56, 189, 248, 0.3);
        }

        .nav-menu { list-style: none; padding: 0; margin: 0; }
        
        .nav-item { margin-bottom: 5px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link i { font-size: 1.2rem; }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--accent-blue);
            transform: translateX(8px);
        }

        .nav-link.active {
            background: var(--accent-blue);
            color: var(--sidebar-bg);
            box-shadow: 0 10px 20px rgba(56, 189, 248, 0.2);
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: 280px;
            padding: 40px;
            width: calc(100% - 280px);
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .welcome-text h1 { font-weight: 800; font-size: 2.2rem; margin: 0; letter-spacing: -1px; }
        .welcome-text p { color: #64748b; margin: 5px 0 0; font-weight: 500; }

        /* --- GLASS CARDS --- */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--white);
            padding: 30px;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
            background: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(255,255,255,0.8);
            transition: 0.3s;
        }

        .stat-card:hover { transform: translateY(-10px); }

        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 20px;
        }

        .stat-card h3 { font-size: 2rem; font-weight: 800; margin: 0; color: var(--sidebar-bg); }
        .stat-card p { font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 5px; }

        /* --- TABLE AREA --- */
        .data-section {
            background: white;
            padding: 35px;
            border-radius: 35px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.02);
        }

        .data-section h2 { font-weight: 800; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 20px; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
        td { padding: 20px; border-top: 1px solid #f1f5f9; font-weight: 600; }
        
        .user-tag { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 35px; height: 35px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: var(--sidebar-bg); }

        .status { padding: 6px 14px; border-radius: 12px; font-size: 0.75rem; font-weight: 800; }
        .Pending { background: #fff7ed; color: #c2410c; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fas fa-crown"></i> ELITE</h2>
        <div class="nav-menu">
            <div class="nav-item"><a href="dashboard.php" class="nav-link active"><i class="fas fa-chart-pie"></i> Dashboard</a></div>
            <div class="nav-item"><a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-square"></i> Ongeza Mali</a></div>
            <div class="nav-item"><a href="admin_manage_properties.php" class="nav-link"><i class="fas fa-building"></i> Dhibiti Mali</a></div>
            <div class="nav-item"><a href="admin_approve_bookings.php" class="nav-link"><i class="fas fa-check-double"></i> Bookings</a></div>
            <div class="nav-item"><a href="tenants_list.php" class="nav-link"><i class="fas fa-users-gear"></i> Wapangaji</a></div>
            <div class="nav-item"><a href="manage_maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a></div>
            <div class="nav-item"><a href="reports.php" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Mapato</a></div>
            <div class="nav-item"><a href="settings.php" class="nav-link"><i class="fas fa-sliders"></i> Mipangilio</a></div>
            <div style="height: 100px;"></div>
            <div class="nav-item"><a href="logout.php" class="nav-link" style="color: #fb7185;"><i class="fas fa-power-off"></i> Logout</a></div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="welcome-text">
                <h1>Habari, Bosi! 👋</h1>
                <p>Hii ndiyo hali ya milki zako leo.</p>
            </div>
            <div class="date-chip" style="background: white; padding: 12px 20px; border-radius: 15px; font-weight: 800; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                <i class="far fa-calendar-alt text-primary"></i> <?php echo date('d M, Y'); ?>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="icon" style="background: #e0f2fe; color: #0ea5e9;"><i class="fas fa-home"></i></div>
                <h3><?php echo $total_mali; ?></h3>
                <p>Mali Sokoni</p>
            </div>
            <div class="stat-card">
                <div class="icon" style="background: #fef3c7; color: #d97706;"><i class="fas fa-wrench"></i></div>
                <h3><?php echo $pending_maint; ?></h3>
                <p>Kero Mpya</p>
            </div>
            <div class="stat-card">
                <div class="icon" style="background: #dcfce7; color: #15803d;"><i class="fas fa-coins"></i></div>
                <h3><?php echo number_format($revenue / 1000); ?>K</h3>
                <p>Pesa (Confirmed)</p>
            </div>
            <div class="stat-card">
                <div class="icon" style="background: #fee2e2; color: #b91c1c;"><i class="fas fa-bell"></i></div>
                <h3><?php echo $pending_book; ?></h3>
                <p>Wateja Wapya</p>
            </div>
        </div>

        <div class="data-section">
            <h2><i class="fas fa-bolt" style="color: #f59e0b;"></i> Bookings za Papo Hapo</h2>
            <table>
                <thead>
                    <tr>
                        <th>Mteja</th>
                        <th>Nyumba / Mali</th>
                        <th>Kiasi</th>
                        <th>Hali</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recent_bookings as $rb): ?>
                    <tr>
                        <td>
                            <div class="user-tag">
                                <div class="avatar"><i class="fas fa-user"></i></div>
                                <span><?php echo $rb['full_name']; ?></span>
                            </div>
                        </td>
                        <td><?php echo $rb['title']; ?></td>
                        <td><span style="font-weight: 800;">TZS <?php echo number_format($rb['price']); ?></span></td>
                        <td><span class="status <?php echo $rb['status']; ?>"><?php echo $rb['status']; ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>