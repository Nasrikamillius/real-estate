<?php
session_start();
require 'db_connect.php';

// 1. Mahesabu ya Mapato (Revenue Analytics)
$total_revenue = $pdo->query("SELECT SUM(p.price) FROM bookings b JOIN properties p ON b.property_id = p.property_id WHERE b.status = 'Confirmed'")->fetchColumn() ?: 0;
$monthly_revenue = $pdo->query("SELECT SUM(p.price) FROM bookings b JOIN properties p ON b.property_id = p.property_id WHERE b.status = 'Confirmed' AND MONTH(b.booking_date) = MONTH(CURRENT_DATE)")->fetchColumn() ?: 0;
$total_transactions = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Confirmed'")->fetchColumn();

// 2. Orodha ya Miamala ya Fedha
$transactions = $pdo->query("SELECT b.booking_id, u.full_name, p.title, p.price, b.booking_date 
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
    <title>Ripoti za Mapato | Elite Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --accent-blue: #38bdf8;
            --main-bg: #f8fafc;
            --emerald: #10b981;
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
        
        .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .report-header h1 { font-weight: 800; font-size: 2.2rem; color: var(--sidebar-bg); margin: 0; }

        /* --- BIG STAT CARDS --- */
        .revenue-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 25px; margin-bottom: 40px; }
        
        .rev-card { 
            background: white; padding: 35px; border-radius: 40px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.03);
            position: relative; overflow: hidden;
        }
        .rev-card.main { background: var(--sidebar-bg); color: white; }
        .rev-card h4 { margin: 0; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.7; }
        .rev-card h2 { margin: 10px 0; font-size: 2.5rem; font-weight: 800; }
        
        .trend { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 10px; font-size: 0.8rem; font-weight: 700; background: rgba(16, 185, 129, 0.1); color: var(--emerald); }

        /* --- TRANSACTION TABLE --- */
        .table-box { background: white; border-radius: 35px; padding: 35px; box-shadow: 0 20px 50px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 20px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; border-bottom: 2px solid #f1f5f9; }
        td { padding: 22px 20px; border-bottom: 1px solid #f8fafc; font-weight: 600; font-size: 0.95rem; }
        
        .amount-tag { color: var(--emerald); font-weight: 800; }
        .date-tag { color: #64748b; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fas fa-gem"></i> ELITE</h2>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-square"></i> Ongeza Mali</a>
        <a href="admin_manage_properties.php" class="nav-link"><i class="fas fa-building"></i> Dhibiti Mali</a>
        <a href="admin_approve_bookings.php" class="nav-link"><i class="fas fa-check-double"></i> Bookings</a>
        <a href="tenants_list.php" class="nav-link"><i class="fas fa-users-gear"></i> Wapangaji</a>
        <a href="manage_maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
        <a href="reports.php" class="nav-link active"><i class="fas fa-chart-line"></i> Mapato</a>
        <a href="settings.php" class="nav-link"><i class="fas fa-sliders"></i> Mipangilio</a>
        <div style="height: 100px;"></div>
        <a href="logout.php" class="nav-link" style="color: #fb7185;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="report-header">
            <h1>Ripoti ya Mapato</h1>
            <button onclick="window.print()" style="background: white; border: 2px solid #e2e8f0; padding: 12px 20px; border-radius: 15px; font-weight: 800; cursor: pointer;">
                <i class="fas fa-download"></i> Pakua Ripoti
            </button>
        </div>

        <div class="revenue-grid">
            <div class="rev-card main">
                <h4>Jumla ya Mapato Yote</h4>
                <h2>TZS <?php echo number_format($total_revenue); ?></h2>
                <div class="trend" style="background: rgba(255,255,255,0.1); color: var(--accent-blue);">
                    <i class="fas fa-chart-line"></i> Lifetime Earnings
                </div>
            </div>
            <div class="rev-card">
                <h4>Mwezi Huu</h4>
                <h2 style="color: var(--sidebar-bg);"><?php echo number_format($monthly_revenue); ?></h2>
                <div class="trend"><i class="fas fa-arrow-up"></i> +12%</div>
            </div>
            <div class="rev-card">
                <h4>Miamala</h4>
                <h2 style="color: var(--sidebar-bg);"><?php echo $total_transactions; ?></h2>
                <p style="color: #64748b; font-size: 0.8rem; font-weight: 700;">Paid Bookings</p>
            </div>
        </div>

        <div class="table-box">
            <h3 style="font-weight: 800; margin-bottom: 25px;">Miamala ya Hivi Karibuni</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mteja</th>
                        <th>Maelezo ya Mali</th>
                        <th>Tarehe</th>
                        <th>Kiasi kilicholipwa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($transactions as $tr): ?>
                    <tr>
                        <td style="color: var(--sidebar-bg); font-weight: 700;"><?php echo $tr['full_name']; ?></td>
                        <td><?php echo $tr['title']; ?></td>
                        <td class="date-tag"><?php echo date('d M, Y', strtotime($tr['booking_date'])); ?></td>
                        <td class="amount-tag">TZS <?php echo number_format($tr['price']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>