<?php 
include 'db_connect.php'; 
session_start();
// Hakikisha mteja amelogin
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit(); }

if(isset($_POST['submit_property'])) {
    $title = $_POST['title']; $location = $_POST['location'];
    $price = $_POST['price']; $type = $_POST['type'];
    $desc = $_POST['description'];
    
    $main_img = $_FILES['main_image']['name'];
    $target = "uploads/" . basename($main_img);
    
    // Status inakaa 'Pending'
    $sql = "INSERT INTO properties (title, location, price, property_type, description, image_name, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$title, $location, $price, $type, $desc, $main_img])) {
        move_uploaded_file($_FILES['main_image']['tmp_name'], $target);
        echo "<script>alert('Mali imetumwa! Itahakikiwa na Admin kabla ya kuonekana sokoni.'); window.location='index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Weka Mali Sokoni | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; font-family: 'Inter', sans-serif; }
        .glass-card { background: white; border-radius: 25px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: none; }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #dee2e6; }
        .btn-post { background: #0f172a; color: white; border-radius: 12px; padding: 15px; font-weight: bold; width: 100%; transition: 0.3s; }
        .btn-post:hover { background: #38bdf8; color: #0f172a; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-card">
                    <h2 class="fw-bold mb-4 text-center">Weka Nyumba/Kiwanja Sokoni 🏠</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3"><label class="form-label fw-bold">Jina la Mali</label><input type="text" name="title" class="form-control" placeholder="Mf: Villa ya kisasa Masaki" required></div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6"><label class="form-label fw-bold">Mahali (Location)</label><input type="text" name="location" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label fw-bold">Bei (TZS)</label><input type="number" name="price" class="form-control" required></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Aina ya Mali</label>
                            <select name="type" class="form-select">
                                <option>Nyumba</option><option>Apartment</option><option>Kiwanja</option><option>Ofisi</option>
                            </select>
                        </div>
                        <div class="mb-3"><label class="form-label fw-bold text-primary">Picha ya Jalada</label><input type="file" name="main_image" class="form-control" required></div>
                        <div class="mb-4"><label class="form-label fw-bold">Maelezo Kamili</label><textarea name="description" class="form-control" rows="4" required></textarea></div>
                        <button type="submit" name="submit_property" class="btn-post shadow">PANDISHA SOKONI SASA</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>