<?php
session_start();
require 'db_connect.php';

$user_id = $_SESSION['user_id'];
// Vuta booking zote za mteja huyu
$my_bookings = $pdo->prepare("SELECT b.*, p.title, p.location, p.image_name FROM bookings b 
                              JOIN properties p ON b.property_id = p.property_id 
                              WHERE b.client_id = ?");
$my_bookings->execute([$user_id]);
$results = $my_bookings->fetchAll();
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>My Portal | Elite Estates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; padding: 40px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; }
        .card { background: white; border-radius: 25px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; }
        .card img { width: 100%; height: 200px; object-fit: cover; }
        .card-content { padding: 20px; }
        .status { padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
        .Pending { background: #fef3c7; color: #d97706; }
        .Confirmed { background: #dcfce7; color: #16a34a; }
    </style>
</head>
<body>
    <h1 style="font-weight: 800; color: #0f172a; margin-bottom: 30px;">Maombi Yangu ya Nyumba</h1>
    <div class="grid">
        <?php foreach($results as $res): ?>
        <div class="card">
            <img src="uploads/<?php echo $res['image_name']; ?>">
            <div class="card-content">
                <span class="status <?php echo $res['status']; ?>"><?php echo $res['status']; ?></span>
                <h3 style="margin: 15px 0 5px;"><?php echo $res['title']; ?></h3>
                <p style="color: #64748b; font-size: 0.9rem;"><i class="fas fa-map-marker-alt"></i> <?php echo $res['location']; ?></p>
                <hr style="border:0; border-top:1px solid #f1f5f9; margin: 15px 0;">
                <p style="font-size: 0.8rem; color: #94a3b8;">Booking ID: #<?php echo $res['booking_id']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>