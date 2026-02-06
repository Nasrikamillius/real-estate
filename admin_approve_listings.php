<?php require 'db_connect.php';
if(isset($_GET['app_id'])) {
    $pdo->prepare("UPDATE properties SET status = 'Active' WHERE property_id = ?")->execute([$_GET['app_id']]);
    header("Location: admin_approve_listings.php");
}
$pending = $pdo->query("SELECT p.*, u.full_name FROM properties p JOIN users u ON p.owner_id = u.user_id WHERE p.status = 'Pending'")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><?php include 'sidebar.php'; ?></head>
<body>
    <main class="main-content">
        <h1>Mali Zinazosubiri Idhini</h1>
        <div style="display: grid; gap: 20px; margin-top: 20px;">
            <?php foreach($pending as $p): ?>
            <div style="background:white; padding:20px; border-radius:20px; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:20px;">
                    <img src="uploads/<?php echo $p['image_name']; ?>" style="width:80px; height:80px; border-radius:10px; object-fit:cover;">
                    <div>
                        <h3 style="margin:0;"><?php echo $p['title']; ?></h3>
                        <small>Mteja: <?php echo $p['full_name']; ?> | Bei: <?php echo number_format($p['price']); ?></small>
                    </div>
                </div>
                <a href="?app_id=<?php echo $p['property_id']; ?>" style="background:#10b981; color:white; padding:10px 20px; border-radius:10px; text-decoration:none; font-weight:700;">APPROVE</a>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>