<?php
session_start();
require 'db_connect.php';

// Logic ya kubadili hali ya tatizo (Kutoka Pending kwenda Fixed)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $stmt = $pdo->prepare("UPDATE maintenance_requests SET status = 'Fixed' WHERE request_id = ?");
    $stmt->execute([$_GET['id']]);
    header("Location: manage_maintenance.php?msg=Tatizo Limetatuliwa");
    exit();
}

// Vuta kero zote zilizolink na majina ya wapangaji na nyumba zao
$requests = $pdo->query("SELECT m.*, u.full_name, u.phone, p.title 
                         FROM maintenance_requests m 
                         JOIN users u ON m.user_id = u.user_id 
                         JOIN properties p ON m.property_id = p.property_id 
                         ORDER BY CASE WHEN m.status = 'Pending' THEN 1 ELSE 2 END, m.request_id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Matengenezo | Elite Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --accent-blue: #38bdf8;
            --main-bg: #f8fafc;
            --warning: #f59e0b;
            --success: #10b981;
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
        
        .header-box { margin-bottom: 40px; }
        .header-box h1 { font-weight: 800; font-size: 2.2rem; color: var(--sidebar-bg); margin: 0; }
        
        .m-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 25px; }
        
        .m-card { 
            background: white; border-radius: 30px; padding: 25px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.02); border-left: 6px solid #e2e8f0;
            transition: 0.3s; position: relative;
        }
        .m-card.Pending { border-left-color: var(--warning); }
        .m-card.Fixed { border-left-color: var(--success); opacity: 0.8; }

        .m-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
        .m-header strong { font-size: 1.1rem; color: var(--sidebar-bg); }
        
        .issue-text { 
            background: #f8fafc; padding: 15px; border-radius: 15px; 
            font-size: 0.9rem; color: #475569; margin-bottom: 20px; border: 1px dashed #cbd5e1;
        }

        .m-footer { display: flex; justify-content: space-between; align-items: center; }
        .phone-link { color: var(--accent-blue); text-decoration: none; font-weight: 700; font-size: 0.85rem; }

        .btn-fix { 
            background: var(--sidebar-bg); color: white; padding: 10px 18px; border-radius: 12px; 
            text-decoration: none; font-weight: 800; font-size: 0.75rem; transition: 0.3s;
        }
        .btn-fix:hover { background: var(--success); transform: scale(1.05); }

        .status-tag { padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 900; text-transform: uppercase; }
        .tag-pending { background: #fffbeb; color: #9a3412; }
        .tag-fixed { background: #f0fdf4; color: #166534; }
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
        <a href="manage_maintenance.php" class="nav-link active"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-chart-line"></i> Mapato</a>
        <a href="settings.php" class="nav-link"><i class="fas fa-sliders"></i> Mipangilio</a>
        <div style="height: 100px;"></div>
        <a href="logout.php" class="nav-link" style="color: #fb7185;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="header-box">
            <h1>Kero za Wapangaji</h1>
            <p style="color: #64748b; font-weight: 500;">Tatua matatizo ya nyumba kwa haraka ili kuweka heshima ya kampuni.</p>
        </div>

        <div class="m-grid">
            <?php foreach($requests as $r): ?>
            <div class="m-card <?php echo $r['status']; ?>">
                <div class="m-header">
                    <div>
                        <strong><?php echo $r['full_name']; ?></strong><br>
                        <small style="color: #64748b;"><i class="fas fa-home"></i> <?php echo $r['title']; ?></small>
                    </div>
                    <span class="status-tag tag-<?php echo strtolower($r['status']); ?>"><?php echo $r['status']; ?></span>
                </div>

                <div class="issue-text">
                    <i class="fas fa-quote-left" style="color: #cbd5e1; margin-right: 5px;"></i>
                    <?php echo $r['issue_description']; ?>
                </div>

                <div class="m-footer">
                    <a href="tel:<?php echo $r['phone']; ?>" class="phone-link"><i class="fas fa-phone-alt"></i> <?php echo $r['phone']; ?></a>
                    <?php if($r['status'] == 'Pending'): ?>
                        <a href="?action=fix&id=<?php echo $r['request_id']; ?>" class="btn-fix">WEKA FIXED</a>
                    <?php else: ?>
                        <span style="color: var(--success); font-weight: 800; font-size: 0.8rem;"><i class="fas fa-check-double"></i> IMEISHA</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>