<?php 
include 'db_connect.php'; 
session_start();

// LOGIC YA KUPOKEA DATA
if(isset($_POST['submit_property'])) {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    
    // 1. Shughulikia Picha Kuu (Main Cover)
    $main_image = $_FILES['main_image']['name'];
    $target_main = "uploads/" . basename($main_image);
    
    $sql = "INSERT INTO properties (title, location, price, property_type, description, image_name, status) VALUES (?, ?, ?, ?, ?, ?, 'Available')";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$title, $location, $price, $type, $description, $main_image])) {
        $last_id = $pdo->lastInsertId(); // ID ya mali tuliyotoka kusave sasa hivi
        move_uploaded_file($_FILES['main_image']['tmp_name'], $target_main);

        // 2. Shughulikia Picha za Gallery (Multiple Upload)
        if(!empty(array_filter($_FILES['gallery']['name']))) {
            foreach($_FILES['gallery']['name'] as $key => $val) {
                $extra_img_name = $_FILES['gallery']['name'][$key];
                $target_extra = "uploads/" . basename($extra_img_name);
                
                if(move_uploaded_file($_FILES['gallery']['tmp_name'][$key], $target_extra)) {
                    $sql_extra = "INSERT INTO property_images (property_id, image_path) VALUES (?, ?)";
                    $pdo->prepare($sql_extra)->execute([$last_id, $extra_img_name]);
                }
            }
        }
        echo "<script>alert('Mali na Album ya picha zimeongezwa kikamilifu!'); window.location='admin_manage_properties.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Weka Mali | Smart Admin Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --accent: #38bdf8; --sidebar-bg: #0f172a; }
        body { 
            background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover; font-family: 'Inter', sans-serif;
        }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(241, 245, 249, 0.92); z-index: -1; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); position: fixed; color: white; padding: 30px 15px; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 12px; margin-bottom: 8px; display: flex; align-items: center; text-decoration: none; transition: 0.3s; }
        .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); border-right: 4px solid var(--accent); }
        .main-content { margin-left: 280px; padding: 40px; }
        
        /* Glass Form Style */
        .glass-card { 
            background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(15px); 
            border-radius: 30px; padding: 40px; border: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        }
        .form-label { font-weight: 700; color: var(--sidebar-bg); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control, .form-select { 
            border-radius: 15px; padding: 12px 18px; border: 1px solid #e2e8f0; background: white;
            transition: 0.3s;
        }
        .form-control:focus { box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1); border-color: var(--accent); }
        .btn-upload { 
            background: var(--sidebar-bg); color: white; border-radius: 15px; 
            padding: 15px; font-weight: 800; width: 100%; border: none; 
            transition: 0.4s; margin-top: 20px;
        }
        .btn-upload:hover { background: var(--accent); transform: translateY(-3px); color: var(--sidebar-bg); }
        .type-icon { font-size: 1.2rem; margin-right: 10px; color: var(--accent); }
    </style>
</head>
<body>
<div class="overlay"></div>

<div class="sidebar">
    <div class="h4 fw-bold text-center mb-5" style="color: var(--accent);">SMART ADMIN</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-th-large me-2"></i> Dashboard</a>
        <a class="nav-link active" href="admin_add_property.php"><i class="fas fa-plus-circle me-2"></i> Ongeza Mali</a>
        <a class="nav-link" href="admin_manage_properties.php"><i class="fas fa-home me-2"></i> Simamia Mali</a>
        <a class="nav-link" href="admin_approve_bookings.php"><i class="fas fa-check-circle me-2"></i> Maombi</a>
        <a class="nav-link" href="admin_messages.php"><i class="fas fa-envelope me-2"></i> Ujumbe</a>
    </nav>
</div>

<div class="main-content">
    <div class="mb-5">
        <h2 class="fw-bold text-dark">Ongeza Mali Sokoni 🚀</h2>
        <p class="text-muted">Kama Airbnb, weka picha nyingi ili mteja ajionee kila kona ya nyumba.</p>
    </div>

    <div class="glass-card">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-4">
                <div class="col-md-12">
                    <label class="form-label">Jina la Mali / Kichwa cha Habari</label>
                    <input type="text" name="title" class="form-control" placeholder="Mf: Modern Apartment yenye View ya Bahari" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Mahali (Location)</label>
                    <input type="text" name="location" class="form-control" placeholder="Mf: Masaki, Dar es Salaam" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bei (TZS kwa Mwezi/Jumla)</label>
                    <input type="number" name="price" class="form-control" placeholder="Mf: 1,500,000" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Aina ya Mali</label>
                    <select name="type" class="form-select" required>
                        <option value="Nyumba Nzima">🏠 Nyumba Nzima</option>
                        <option value="Apartment">🏢 Apartment ya Kisasa</option>
                        <option value="Chumba">🛌 Chumba Kimoja (Master)</option>
                        <option value="Ofisi">💼 Eneo la Ofisi</option>
                        <option value="Hotel/Villa">🏝️ Hotel au Villa</option>
                        <option value="Kiwanja">📐 Kiwanja / Shamba</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-primary"><i class="fas fa-image me-1"></i> Picha ya Jalada (Main Cover)</label>
                    <input type="file" name="main_image" class="form-control" required>
                    <small class="text-muted">Hii ndio itatokea kwanza kwenye search.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-info"><i class="fas fa-images me-1"></i> Album ya Ndani (Gallery)</label>
                    <input type="file" name="gallery[]" class="form-control" multiple>
                    <small class="text-muted">Shikilia <b>Ctrl</b> kuchagua picha nyingi za vyumba.</small>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Maelezo ya Ziada & Sifa</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Elezea kuhusu umeme, maji, ulinzi, na sifa za vyumba..." required></textarea>
                </div>

                <div class="col-md-12">
                    <button type="submit" name="submit_property" class="btn-upload shadow-lg">
                        PANDISHA MALI SOKONI SASA <i class="fas fa-rocket ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>