<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: login.php"); exit(); }
$props = $pdo->query("SELECT * FROM properties ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Orodha ya Nyumba | Elite Estates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #0f172a; --secondary: #3b82f6; --bg: #f8fafc; --sidebar-width: 280px; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); display: flex; }
        .sidebar { width: var(--sidebar-width); background: var(--primary); height: 100vh; position: fixed; padding: 30px 20px; color: white; }
        .brand { display: flex; align-items: center; gap: 12px; font-size: 1.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 50px; }
        .nav-link { display: flex; align-items: center; gap: 15px; padding: 14px 18px; color: #94a3b8; text-decoration: none; border-radius: 14px; margin-bottom: 8px; }
        .nav-link.active { background: var(--secondary); color: white; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 40px; }
        .card { background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #64748b; border-bottom: 2px solid #f8fafc; }
        td { padding: 15px; border-bottom: 1px solid #f8fafc; }
        .img-box { width: 70px; height: 50px; border-radius: 10px; object-fit: cover; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-city"></i> <span>Elite Estates</span></div>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-th-large"></i> Dashibodi</a>
        <a href="add_property.php" class="nav-link"><i class="fas fa-plus-circle"></i> Sajili Nyumba</a>
        <a href="admin_properties.php" class="nav-link active"><i class="fas fa-building-user"></i> Nyumba Zote</a>
        <a href="tenants.php" class="nav-link"><i class="fas fa-users"></i> Wapangaji</a>
        <a href="payments.php" class="nav-link"><i class="fas fa-credit-card"></i> Malipo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-chart-pie"></i> Ripoti</a>
    </aside>
    <main class="main-content">
        <div class="card">
            <h2 style="margin-bottom: 25px;">Nyumba Zilizosajiliwa</h2>
            <table>
                <thead>
                    <tr><th>Picha</th><th>Nyumba</th><th>Bei</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php foreach($props as $p): ?>
                    <tr>
                        <td><img src="<?php echo $p['image_path']; ?>" class="img-box"></td>
                        <td><strong><?php echo $p['title']; ?></strong><br><small><?php echo $p['location']; ?></small></td>
                        <td style="color:var(--secondary); font-weight:700;">TZS <?php echo number_format($p['price']); ?></td>
                        <td>
                            <a href="#" style="color:var(--secondary); margin-right:15px;"><i class="fas fa-edit"></i></a>
                            <a href="#" style="color:red;"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>