<?php
session_start();
require 'db_connect.php';


if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = ($_GET['action'] == 'approve') ? 'Active' : 'Rejected';
    
    $stmt = $pdo->prepare("UPDATE properties SET status = ? WHERE property_id = ?");
    $stmt->execute([$status, $id]);
    header("Location: approve_items.php?msg=Mabadiliko yamehifadhiwa!");
    exit();
}


$pending_stmt = $pdo->query("SELECT p.*, u.full_name FROM properties p 
                             JOIN users u ON p.owner_id = u.user_id 
                             WHERE p.status = 'Pending'");
$pending_items = $pending_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Approve Items | Elite Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --sb-width: 260px; --primary: #0f172a; --accent: #38bdf8; --success: #10b981; --danger: #ef4444; }
        body { margin: 0; background: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; }
        
        
        .sidebar { width: var(--sb-width); background: var(--primary); height: 100vh; position: fixed; color: white; padding: 30px 20px; box-sizing: border-box; z-index: 1000; }
        .sidebar h2 { color: var(--accent); font-weight: 800; margin-bottom: 40px; display: flex; align-items: center; gap: 10px; }
        .nav-link { display: flex; align-items: center; gap: 15px; padding: 15px; color: #94a3b8; text-decoration: none; border-radius: 12px; margin-bottom: 8px; font-weight: 600; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); }

        
        .main-content { margin-left: var(--sb-width); width: calc(100% - var(--sb-width)); padding: 40px; box-sizing: border-box; }
        
        
        .table-card { background: white; padding: 30px; border-radius: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #f8fafc; }
        td { padding: 20px 15px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
        
        .property-img { width: 80px; height: 80px; border-radius: 15px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        
        .action-btns { display: flex; gap: 10px; }
        .btn-approve { background: var(--success); color: white; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 0.8rem; transition: 0.2s; }
        .btn-reject { background: var(--danger); color: white; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 0.8rem; transition: 0.2s; }
        .btn-approve:hover, .btn-reject:hover { opacity: 0.8; transform: translateY(-2px); }
        
        .empty-msg { text-align: center; padding: 50px; color: #94a3b8; font-weight: 600; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><i class="fas fa-city"></i> ELITE</h2>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-circle"></i> Ongeza Mali</a>
        <a href="approve_items.php" class="nav-link active"><i class="fas fa-check-circle"></i> Idhinisha</a>
        <a href="settings.php" class="nav-link"><i class="fas fa-cog"></i> Mipangilio</a>
        <a href="logout.php" class="nav-link" style="margin-top:50px; color:#f87171;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1 style="font-weight: 800; margin-bottom: 10px;">Idhini ya Mali Mpya</h1>
        <p style="color: #64748b; margin-bottom: 30px;">Kagua na uidhinishe mali zilizopakiwa na wateja/mawakala.</p>

        <div class="table-card">
            <?php if (count($pending_items) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Picha</th>
                        <th>Maelezo ya Mali</th>
                        <th>Miliki/Mpakiaji</th>
                        <th>Bei (TZS)</th>
                        <th>Kitendo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_items as $item): ?>
                    <tr>
                        <td>
                            <img src="uploads/<?php echo $item['image_name']; ?>" class="property-img" alt="Mali">
                        </td>
                        <td>
                            <strong style="display: block; font-size: 1rem; color: var(--primary);"><?php echo $item['title']; ?></strong>
                            <small style="color: #64748b;"><i class="fas fa-map-marker-alt"></i> <?php echo $item['location']; ?></small>
                        </td>
                        <td>
                            <span style="font-weight: 600;"><?php echo $item['full_name']; ?></span>
                        </td>
                        <td>
                            <span style="font-weight: 800; color: var(--primary);"><?php echo number_format($item['price']); ?></span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="?action=approve&id=<?php echo $item['property_id']; ?>" class="btn-approve">KUBALI</a>
                                <a href="?action=reject&id=<?php echo $item['property_id']; ?>" class="btn-reject">KATAA</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-msg">
                <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 15px; display: block; color: var(--success);"></i>
                Kila kitu kimeshapitiwa! Hakuna mali inayosubiri idhini kwa sasa.
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>