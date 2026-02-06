<?php 
require 'db_connect.php';

// Hapa tunatafuta wale tu ambao Booking yao ipo 'Confirmed'
$stmt = $pdo->query("SELECT b.*, u.full_name, u.email, p.title, p.location 
                     FROM bookings b 
                     JOIN users u ON b.client_id = u.user_id 
                     JOIN properties p ON b.property_id = p.property_id 
                     WHERE b.status = 'Confirmed'");
$tenants = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'sidebar.php'; ?>
    <style>
        .tenant-card { background: white; padding: 20px; border-radius: 15px; border-left: 5px solid #38bdf8; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        .tenant-info h3 { margin: 0; font-size: 1.1rem; }
        .badge-active { background: #dcfce7; color: #16a34a; padding: 5px 12px; border-radius: 10px; font-weight: 800; font-size: 0.7rem; }
    </style>
</head>
<body>
    <main class="main-content">
        <h1>Wapangaji Wako Active</h1>
        <p style="color: #64748b; margin-bottom: 30px;">Hawa ndio wateja ambao wameshakamilisha malipo na wako kwenye mfumo.</p>

        <?php foreach($tenants as $t): ?>
        <div class="tenant-card">
            <div class="tenant-info">
                <h3><?php echo $t['full_name']; ?></h3>
                <small><?php echo $t['email']; ?> | Anapanga: <strong><?php echo $t['title']; ?> (<?php echo $t['location']; ?>)</strong></small>
            </div>
            <span class="badge-active">ACTIVE TENANT</span>
        </div>
        <?php endforeach; ?>
    </main>
</body>
</html>