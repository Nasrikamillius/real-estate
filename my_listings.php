<?php
session_start();
require 'db_connect.php';

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM properties WHERE owner_id = ? ORDER BY property_id DESC");
$stmt->execute([$user_id]);
$my_properties = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Mali Zangu</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; padding: 30px; }
        .listings-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .card img { width: 100%; height: 180px; object-fit: cover; }
        .card-body { padding: 15px; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 700; margin-bottom: 10px; }
        .pending { background: #fef3c7; color: #d97706; }
        .active { background: #dcfce7; color: #16a34a; }
    </style>
</head>
<body>
    <h1>Mali Zangu Walizoweka</h1>
    <div class="listings-grid">
        <?php foreach($my_properties as $p): ?>
        <div class="card">
            <img src="uploads/<?php echo $p['image_name']; ?>" alt="Property Image">
            <div class="card-body">
                <span class="status-badge <?php echo ($p['status'] == 'Pending') ? 'pending' : 'active'; ?>">
                    <?php echo ($p['status'] == 'Pending') ? 'Inasubiri Idhini' : 'Tayari Iko Sokoni'; ?>
                </span>
                <h3><?php echo $p['title']; ?></h3>
                <p>Bei: <?php echo number_format($p['price']); ?> TZS</p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>