<?php
session_start();
require 'db_connect.php';


if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];
$msg = "";


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $stmt = $pdo->prepare("INSERT INTO maintenance_requests (user_id, property_id, issue_description, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->execute([$user_id, $_POST['property_id'], $_POST['issue']]);
    $msg = "Ripoti imetumwa kikamilifu!";
}


$props = $pdo->prepare("SELECT p.property_id, p.title FROM bookings b JOIN properties p ON b.property_id = p.property_id WHERE b.client_id = ? AND b.status = 'Confirmed'");
$props->execute([$user_id]);
$my_properties = $props->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Ripoti Tatizo | Client</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; justify-content: center; padding: 50px; }
        .form-box { background: white; padding: 40px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); width: 100%; max-width: 500px; }
        h2 { font-weight: 800; color: #0f172a; }
        label { display: block; margin: 15px 0 5px; font-weight: 700; color: #475569; }
        select, textarea { width: 100%; padding: 15px; border-radius: 12px; border: 2px solid #f1f5f9; font-family: inherit; }
        textarea { height: 100px; }
        .btn { background: #0f172a; color: white; padding: 15px; width: 100%; border: none; border-radius: 12px; font-weight: 800; cursor: pointer; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Ripoti Tatizo la Nyumba</h2>
        <?php if($msg) echo "<p style='color:green; font-weight:800;'>$msg</p>"; ?>
        <form method="POST">
            <label>Nyumba Unayokaa</label>
            <select name="property_id" required>
                <?php foreach($my_properties as $p): ?>
                    <option value="<?php echo $p['property_id']; ?>"><?php echo $p['title']; ?></option>
                <?php endforeach; ?>
            </select>
            
            <label>Elezea Tatizo</label>
            <textarea name="issue" placeholder="Mfano: Bomba linavuja, Taa haiwaki..." required></textarea>
            
            <button type="submit" class="btn">TUMA RIPOTI</button>
        </form>
    </div>
</body>
</html>