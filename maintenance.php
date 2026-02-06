<?php
session_start();
require 'db_connect.php';

// 1. Update Hali ya Matengenezo (Mfano: Toka Pending kwenda Fixed)
if (isset($_GET['complete_id'])) {
    $stmt = $pdo->prepare("UPDATE maintenance_requests SET status = 'Fixed' WHERE request_id = ?");
    $stmt->execute([$_GET['complete_id']]);
    header("Location: maintenance.php?msg=Imeratibiwa kikamilifu");
}

// 2. Vuta taarifa za matengenezo zilizounganishwa na wateja na mali zao
$requests = $pdo->query("SELECT m.*, u.full_name, u.phone, p.title 
                         FROM maintenance_requests m 
                         JOIN users u ON m.user_id = u.user_id 
                         JOIN properties p ON m.property_id = p.property_id 
                         ORDER BY m.request_id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Matengenezo | Elite Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --sb-width: 260px; --primary: #0f172a; --accent: #38bdf8; --warning: #f59e0b; }
        body { margin: 0; background: #f4f7fe; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; }
        
        .sidebar { width: var(--sb-width); background: var(--primary); height: 100vh; position: fixed; color: white; padding: 30px 20px; box-sizing: border-box; }
        .sidebar h2 { color: var(--accent); font-weight: 800; margin-bottom: 40px; display: flex; align-items: center; gap: 10px; }
        .nav-link { display: flex; align-items: center; gap: 15px; padding: 15px; color: #94a3b8; text-decoration: none; border-radius: 12px; margin-bottom: 8px; font-weight: 600; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); }

        .main-content { margin-left: var(--sb-width); width: calc(100% - var(--sb-width)); padding: 40px; box-sizing: border-box; }
        
        .issue-card { background: white; padding: 25px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); margin-bottom: 20px; border-left: 6px solid var(--warning); display: flex; justify-content: space-between; align-items: center; }
        .issue-card.Fixed { border-left-color: #10b981; opacity: 0.8; }
        
        .info h3 { margin: 0 0 5px 0; font-size: 1.1rem; color: var(--primary); }
        .info p { margin: 0; color: #64748b; font-size: 0.9rem; }
        .status-pill { padding: 5px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .pill-pending { background: #fffbeb; color: #d97706; }
        .pill-fixed { background: #dcfce7; color: #16a34a; }
        
        .btn-done { background: var(--primary); color: white; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><i class="fas fa-city"></i> ELITE</h2>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-circle"></i> Ongeza Mali</a>
        <a href="approve_items.php" class="nav-link"><i class="fas fa-check-circle"></i> Idhinisha</a>
        <a href="maintenance.php" class="nav-link active"><i class="fas fa-tools"></i> Matengenezo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Miamala</a>
        <a href="logout.php" class="nav-link" style="margin-top:50px; color:#f87171;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1 style="font-weight: 800; margin-bottom: 30px;">Maombi ya Matengenezo</h1>

        <?php foreach($requests as $req): ?>
        <div class="issue-card <?php echo $req['status']; ?>">
            <div class="info">
                <div style="margin-bottom: 10px;">
                    <span class="status-pill <?php echo ($req['status'] == 'Pending') ? 'pill-pending' : 'pill-fixed'; ?>">
                        <?php echo $req['status']; ?>
                    </span>
                </div>
                <h3><?php echo $req['issue_description']; ?></h3>
                <p><i class="fas fa-home"></i> <strong>Nyumba:</strong> <?php echo $req['title']; ?></p>
                <p><i class="fas fa-user"></i> <strong>Mpangaji:</strong> <?php echo $req['full_name']; ?> (<?php echo $req['phone']; ?>)</p>
            </div>
            
            <?php if($req['status'] == 'Pending'): ?>
                <a href="?complete_id=<?php echo $req['request_id']; ?>" class="btn-done">WEKA "FIXED"</a>
            <?php else: ?>
                <span style="color: #10b981; font-weight: 800;"><i class="fas fa-check-double"></i> IMEKAMILIKA</span>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <?php if(empty($requests)) echo "<p style='text-align:center; color:#94a3b8;'>Hakuna ripoti za matengenezo kwa sasa.</p>"; ?>
    </div>
</body>
</html>