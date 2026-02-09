<?php 
include 'db_connect.php'; 
session_start();

// 1. Pata ID ya mali inayotakiwa kufanyiwa marekebisho
if(!isset($_GET['id'])) { header("Location: admin_manage_properties.php"); exit(); }
$id = $_GET['id'];

// 2. Vuta data za hiyo mali kutoka database
$stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ?");
$stmt->execute([$id]);
$prop = $stmt->fetch();

// 3. Logic ya Ku-update (Baada ya Admin kubonyeza "Update")
if(isset($_POST['update_property'])) {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    
    $sql = "UPDATE properties SET title=?, location=?, price=?, status=?, description=? WHERE property_id=?";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$title, $location, $price, $status, $description, $id])) {
        echo "<script>alert('Marekebisho yamehifadhiwa!'); window.location='admin_manage_properties.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Edit Mali | Smart Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --accent: #38bdf8; --sidebar-bg: #0f172a; }
        body { 
            background: url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover; font-family: 'Inter', sans-serif;
        }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(241, 245, 249, 0.96); z-index: -1; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); position: fixed; color: white; padding: 30px 15px; }
        .main-content { margin-left: 280px; padding: 40px; }
        .edit-card { background: white; border-radius: 30px; padding: 40px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.05); }
        .form-control, .form-select { border-radius: 12px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; }
        .current-img { width: 100%; height: 200px; object-fit: cover; border-radius: 20px; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="overlay"></div>

<div class="sidebar">
    <div class="sidebar-brand text-center h4 fw-bold mb-5" style="color: var(--accent);">SMART ADMIN</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-grid-2 me-2"></i> Dashboard</a>
        <a class="nav-link" href="admin_add_property.php"><i class="fas fa-plus-circle me-2"></i> Ongeza</a>
        <a class="nav-link active" href="admin_manage_properties.php"><i class="fas fa-home me-2"></i> Simamia</a>
        </nav>
</div>

<div class="main-content">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="admin_manage_properties.php" class="btn btn-light rounded-circle"><i class="fas fa-arrow-left"></i></a>
        <h2 class="fw-bold mb-0">Hariri Maelezo ya Mali</h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="edit-card">
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="small fw-bold mb-1">Kichwa cha Mali</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $prop['title']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-1">Mahali</label>
                            <input type="text" name="location" class="form-control" value="<?php echo $prop['location']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-1">Bei (TZS)</label>
                            <input type="number" name="price" class="form-control" value="<?php echo $prop['price']; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="small fw-bold mb-1">Hali ya Mali (Status)</label>
                            <select name="status" class="form-select">
                                <option value="Available" <?php if($prop['status']=='Available') echo 'selected'; ?>>Ipo Wazi (Available)</option>
                                <option value="Reserved" <?php if($prop['status']=='Reserved') echo 'selected'; ?>>Imewekwa Akiba (Reserved)</option>
                                <option value="Sold" <?php if($prop['status']=='Sold') echo 'selected'; ?>>Imeuzwa (Sold)</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="small fw-bold mb-1">Maelezo</label>
                            <textarea name="description" class="form-control" rows="5"><?php echo $prop['description']; ?></textarea>
                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" name="update_property" class="btn btn-primary w-100 p-3 fw-bold rounded-3 shadow">HIFADHI MABADILIKO</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="edit-card text-center">
                <h6 class="fw-bold mb-3">Picha ya Sasa</h6>
                <img src="uploads/<?php echo $prop['image_name']; ?>" class="current-img shadow">
                <p class="small text-muted italic">Ili kubadilisha picha, futa hii mali na uweke upya kwa sasa.</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>