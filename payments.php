<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: login.php"); exit(); }

$payments = $pdo->query("SELECT p.*, u.full_name, pr.title FROM payments p JOIN users u ON p.user_id = u.user_id JOIN properties pr ON p.property_id = pr.property_id ORDER BY p.payment_date DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Malipo | Elite Estates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS ILE ILE KWA AJILI YA UNIFORMITY */
        :root { --primary: #0f172a; --secondary: #3b82f6; --bg: #f8fafc; --sidebar-width: 280px; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); display: flex; }
        .sidebar { width: var(--sidebar-width); background: var(--primary); color: white; position: fixed; height: 100vh; padding: 30px 20px; display: flex; flex-direction: column; }
        .brand { display: flex; align-items: center; gap: 12px; font-size: 1.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 50px; }
        .nav-link { display: flex; align-items: center; gap: 15px; padding: 14px 18px; color: #94a3b8; text-decoration: none; border-radius: 14px; margin-bottom: 8px; }
        .nav-link.active { background: var(--secondary); color: white; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 40px; }
        .table-card { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #64748b; font-size: 0.85rem; border-bottom: 2px solid #f8fafc; }
        td { padding: 15px; border-bottom: 1px solid #f8fafc; }
        .badge { background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-city"></i> <span>Elite Estates</span></div>
        <ul style="list-style:none;">
            <li><a href="dashboard.php" class="nav-link"><i class="fas fa-th-large"></i> Dashibodi</a></li>
            <li><a href="add_property.php" class="nav-link"><i class="fas fa-plus-circle"></i> Sajili Nyumba</a></li>
            <li><a href="admin_properties.php" class="nav-link"><i class="fas fa-building-user"></i> Nyumba Zote</a></li>
            <li><a href="tenants.php" class="nav-link"><i class="fas fa-users"></i> Wapangaji</a></li>
            <li><a href="payments.php" class="nav-link active"><i class="fas fa-credit-card"></i> Malipo</a></li>
        </ul>
    </aside>
    <main class="main-content">
        <div class="table-card">
            <h2 style="margin-bottom: 25px;">Miamala ya Malipo</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nyumba</th>
                        <th>Mpangaji</th>
                        <th>Tarehe</th>
                        <th>Kiasi</th>
                        <th>Hali</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($payments as $p): ?>
                    <tr>
                        <td><strong><?php echo $p['title']; ?></strong></td>
                        <td><?php echo $p['full_name']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($p['payment_date'])); ?></td>
                        <td style="font-weight:700;">TZS <?php echo number_format($p['amount']); ?></td>
                        <td><span class="badge">IMELIPWA</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>