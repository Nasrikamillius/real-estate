<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Sajili Nyumba | Elite Estates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #0f172a; --secondary: #3b82f6; --bg: #f8fafc; --sidebar-width: 280px; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); display: flex; }
        .sidebar { width: var(--sidebar-width); background: var(--primary); height: 100vh; position: fixed; padding: 30px 20px; color: white; }
        .brand { display: flex; align-items: center; gap: 12px; font-size: 1.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 50px; }
        .nav-link { display: flex; align-items: center; gap: 15px; padding: 14px 18px; color: #94a3b8; text-decoration: none; border-radius: 14px; margin-bottom: 8px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(59, 130, 246, 0.1); color: white; }
        .nav-link.active { background: var(--secondary); box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3); }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 40px; }
        .card { background: white; padding: 40px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); max-width: 900px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; }
        input, select, textarea { width: 100%; padding: 14px; border: 2px solid #f1f5f9; border-radius: 12px; margin-bottom: 20px; outline: none; }
        input:focus { border-color: var(--secondary); }
        .btn { background: var(--secondary); color: white; border: none; padding: 16px; border-radius: 12px; width: 100%; font-weight: 700; cursor: pointer; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-city"></i> <span>Elite Estates</span></div>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-th-large"></i> Dashibodi</a>
        <a href="add_property.php" class="nav-link active"><i class="fas fa-plus-circle"></i> Sajili Nyumba</a>
        <a href="admin_properties.php" class="nav-link"><i class="fas fa-building-user"></i> Nyumba Zote</a>
        <a href="tenants.php" class="nav-link"><i class="fas fa-users"></i> Wapangaji</a>
        <a href="payments.php" class="nav-link"><i class="fas fa-credit-card"></i> Malipo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-chart-pie"></i> Ripoti</a>
    </aside>
    <main class="main-content">
        <div class="card">
            <h2 style="margin-bottom: 30px;">Sajili Nyumba Mpya</h2>
            <form action="property_process.php" method="POST" enctype="multipart/form-data">
                <label>Jina la Nyumba</label>
                <input type="text" name="title" required placeholder="Mfano: Luxury Villa">
                <div class="grid">
                    <div><label>Mahali</label><input type="text" name="location" required></div>
                    <div><label>Bei (TZS)</label><input type="number" name="price" required></div>
                </div>
                <label>Picha ya Nyumba</label>
                <input type="file" name="image" required>
                <button class="btn">Hifadhi Nyumba</button>
            </form>
        </div>
    </main>
</body>
</html>