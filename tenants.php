<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: login.php"); exit(); }

$tenants = $pdo->query("SELECT * FROM users WHERE role = 'tenant' ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Wapangaji | Elite Estates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #0f172a; --secondary: #3b82f6; --bg: #f8fafc; --sidebar-width: 280px; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); display: flex; }

        /* SIDEBAR UNIFORM STYLE */
        .sidebar { width: var(--sidebar-width); background: var(--primary); color: white; position: fixed; height: 100vh; padding: 30px 20px; display: flex; flex-direction: column; }
        .brand { display: flex; align-items: center; gap: 12px; font-size: 1.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 50px; }
        .nav-link { display: flex; align-items: center; gap: 15px; padding: 14px 18px; color: #94a3b8; text-decoration: none; border-radius: 14px; margin-bottom: 8px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(59, 130, 246, 0.1); color: white; }
        .nav-link.active { background: var(--secondary); color: white; }

        /* MAIN CONTENT */
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 40px; }
        .table-card { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #64748b; font-size: 0.85rem; border-bottom: 2px solid #f8fafc; }
        td { padding: 15px; border-bottom: 1px solid #f8fafc; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: bold; color: var(--primary); }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-city"></i> <span>Elite Estates</span></div>
        <ul style="list-style:none;">
            <li><a href="dashboard.php" class="nav-link"><i class="fas fa-th-large"></i> Dashibodi</a></li>
            <li><a href="add_property.php" class="nav-link"><i class="fas fa-plus-circle"></i> Sajili Nyumba</a></li>
            <li><a href="admin_properties.php" class="nav-link"><i class="fas fa-building-user"></i> Nyumba Zote</a></li>
            <li><a href="tenants.php" class="nav-link active"><i class="fas fa-users"></i> Wapangaji</a></li>
            <li><a href="payments.php" class="nav-link"><i class="fas fa-credit-card"></i> Malipo</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="table-card">
            <h2 style="margin-bottom: 25px;">Orodha ya Wapangaji</h2>
            <table>
                <thead>
                    <tr>
                        <th>Jina kamili</th>
                        <th>Email</th>
                        <th>Tarehe ya Kujiunga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tenants as $t): ?>
                    <tr>
                        <td style="display:flex; align-items:center; gap:10px;">
                            <div class="user-avatar"><?php echo substr($t['full_name'], 0, 1); ?></div>
                            <strong><?php echo $t['full_name']; ?></strong>
                        </td>
                        <td><?php echo $t['email']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($t['created_at'])); ?></td>
                        <td><a href="#" style="color:var(--secondary); text-decoration:none; font-weight:600;">Details</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>