<?php
session_start();
require 'db_connect.php';

// Logic ya Kuidhinisha au Kukataa Booking
if (isset($_GET['action']) && isset($_GET['id'])) {
    $new_status = ($_GET['action'] == 'confirm') ? 'Confirmed' : 'Rejected';
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
    $stmt->execute([$new_status, $_GET['id']]);
    header("Location: admin_approve_bookings.php?msg=Mteja Amethibitishwa");
    exit();
}

// Vuta bookings zote ambazo bado hazijathibitishwa (Pending)
$bookings = $pdo->query("SELECT b.booking_id, b.status, u.full_name, u.phone, p.title, p.price 
                         FROM bookings b 
                         JOIN users u ON b.client_id = u.user_id 
                         JOIN properties p ON b.property_id = p.property_id 
                         WHERE b.status = 'Pending' 
                         ORDER BY b.booking_id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Bookings Mpya | Elite Premium</title>
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
        
        .table-container {
            background: white; padding: 40px; border-radius: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02);
        }
        
        h1 { font-weight: 800; font-size: 2.2rem; margin-bottom: 10px; color: var(--sidebar-bg); }
        p.sub { color: #64748b; margin-bottom: 35px; font-weight: 500; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 20px; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #f1f5f9; }
        td { padding: 25px 20px; border-bottom: 1px solid #f8fafc; font-weight: 600; vertical-align: middle; }

        .client-info { display: flex; flex-direction: column; }
        .client-info span { font-size: 0.8rem; color: #94a3b8; }

        .btn-confirm { 
            background: var(--success); color: white; padding: 10px 20px; border-radius: 12px; 
            text-decoration: none; font-weight: 800; font-size: 0.75rem; transition: 0.3s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-reject { 
            background: #fff1f2; color: var(--danger); padding: 10px 20px; border-radius: 12px; 
            text-decoration: none; font-weight: 800; font-size: 0.75rem; margin-left: 10px;
        }
        .btn-confirm:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fas fa-gem"></i> ELITE</h2>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-square"></i> Ongeza Mali</a>
        <a href="admin_manage_properties.php" class="nav-link"><i class="fas fa-building"></i> Dhibiti Mali</a>
        <a href="admin_approve_bookings.php" class="nav-link active"><i class="fas fa-check-double"></i> Bookings</a>
        <a href="tenants_list.php" class="nav-link"><i class="fas fa-users-gear"></i> Wapangaji</a>
        <a href="manage_maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Mapato</a>
        <a href="settings.php" class="nav-link"><i class="fas fa-sliders"></i> Mipangilio</a>
        <div style="height: 100px;"></div>
        <a href="logout.php" class="nav-link" style="color: #fb7185;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1>Maombi Mapya (Bookings)</h1>
        <p class="sub">Hapa ndipo unaruhusu wateja waliofanya malipo kuingia kwenye nyumba.</p>

        <div class="table-container">
            <?php if(empty($bookings)): ?>
                <div style="text-align: center; padding: 50px; color: #94a3b8;">
                    <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 20px; color: #d1d5db;"></i>
                    <p>Safii! Hakuna booking inayokusubiri kwa sasa.</p>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Mteja & Mawasiliano</th>
                        <th>Mali Aliyoomba</th>
                        <th>Kiasi (TZS)</th>
                        <th>Maamuzi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $b): ?>
                    <tr>
                        <td>
                            <div class="client-info">
                                <strong><?php echo $b['full_name']; ?></strong>
                                <span><i class="fas fa-phone"></i> <?php echo $b['phone']; ?></span>
                            </div>
                        </td>
                        <td><i class="fas fa-home" style="color: var(--accent-blue);"></i> <?php echo $b['title']; ?></td>
                        <td style="font-weight: 800; color: var(--sidebar-bg);"><?php echo number_format($b['price']); ?></td>
                        <td>
                            <a href="?action=confirm&id=<?php echo $b['booking_id']; ?>" class="btn-confirm">
                                <i class="fas fa-check"></i> CONFIRM
                            </a>
                            <a href="?action=reject&id=<?php echo $b['booking_id']; ?>" class="btn-reject">
                                REJECT
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>