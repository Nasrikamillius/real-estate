<?php
session_start();
require 'db_connect.php';

$success_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $desc = $_POST['description'];
    
    // Upload Picha
    $image = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];
    $folder = "uploads/" . $image;
    
    $stmt = $pdo->prepare("INSERT INTO properties (title, price, location, category, description, image_name, status) VALUES (?, ?, ?, ?, ?, ?, 'Active')");
    if ($stmt->execute([$title, $price, $location, $category, $desc, $image])) {
        move_uploaded_file($temp_name, $folder);
        $success_msg = "Mali imepandishwa sokoni kwa kishindo!";
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Ongeza Mali | Elite Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --accent-blue: #38bdf8;
            --main-bg: #f8fafc;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--main-bg);
            display: flex;
        }

        /* --- SIDEBAR YA KUDUMU (Zile 9) --- */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            height: 100vh;
            position: fixed;
            padding: 30px 20px;
            box-sizing: border-box;
            color: white;
            box-shadow: 10px 0 30px rgba(0,0,0,0.1);
        }

        .sidebar h2 { font-size: 1.8rem; font-weight: 800; color: var(--accent-blue); margin-bottom: 40px; }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            transition: 0.4s;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--accent-blue);
            transform: translateX(8px);
        }

        .nav-link.active { background: var(--accent-blue); color: var(--sidebar-bg); }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: 280px;
            padding: 50px;
            width: calc(100% - 280px);
        }

        .glass-form {
            background: white;
            padding: 45px;
            border-radius: 40px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.05);
            max-width: 900px;
            margin: 0 auto;
            border: 1px solid rgba(255,255,255,0.8);
        }

        .form-header { text-align: center; margin-bottom: 40px; }
        .form-header h1 { font-weight: 800; font-size: 2rem; color: var(--sidebar-bg); margin: 0; }
        .form-header p { color: #64748b; font-weight: 500; }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .input-box { display: flex; flex-direction: column; gap: 8px; }
        .input-box.full { grid-column: span 2; }

        label { font-weight: 700; color: #334155; font-size: 0.9rem; }
        
        input, select, textarea {
            padding: 16px;
            border: 2px solid #f1f5f9;
            border-radius: 18px;
            font-family: inherit;
            font-size: 1rem;
            transition: 0.3s;
            background: #f8fafc;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--accent-blue);
            background: white;
            outline: none;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }

        .btn-upload {
            grid-column: span 2;
            background: var(--sidebar-bg);
            color: white;
            padding: 20px;
            border: none;
            border-radius: 20px;
            font-weight: 800;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.4s;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-upload:hover {
            background: var(--accent-blue);
            color: var(--sidebar-bg);
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(56, 189, 248, 0.2);
        }

        .success-toast {
            background: #dcfce7;
            color: #15803d;
            padding: 20px;
            border-radius: 20px;
            text-align: center;
            font-weight: 800;
            margin-bottom: 30px;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fas fa-gem"></i> ELITE</h2>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link active"><i class="fas fa-plus-square"></i> Ongeza Mali</a>
        <a href="admin_manage_properties.php" class="nav-link"><i class="fas fa-building"></i> Dhibiti Mali</a>
        <a href="admin_approve_bookings.php" class="nav-link"><i class="fas fa-check-double"></i> Bookings</a>
        <a href="tenants_list.php" class="nav-link"><i class="fas fa-users-gear"></i> Wapangaji</a>
        <a href="manage_maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Mapato</a>
        <a href="settings.php" class="nav-link"><i class="fas fa-sliders"></i> Mipangilio</a>
        <div style="height: 100px;"></div>
        <a href="logout.php" class="nav-link" style="color: #fb7185;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <?php if($success_msg) echo "<div class='success-toast'>$success_msg</div>"; ?>

        <div class="glass-form">
            <div class="form-header">
                <h1>Sajili Mali Mpya</h1>
                <p>Jaza taarifa hapa chini ili kupandisha mali yako kwenye soko la Kimataifa.</p>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="input-box">
                        <label>Jina la Mali</label>
                        <input type="text" name="title" placeholder="Mfano: Royal Palm Villa" required>
                    </div>
                    <div class="input-box">
                        <label>Kundi (Category)</label>
                        <select name="category" required>
                            <option value="Apartment">Apartment</option>
                            <option value="House">Nyumba Kamili</option>
                            <option value="Office">Ofisi</option>
                            <option value="Land">Kiwanja</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label>Bei ya Kukodisha/Kuuza (TZS)</label>
                        <input type="number" name="price" placeholder="Mfano: 1,500,000" required>
                    </div>
                    <div class="input-box">
                        <label>Eneo (Location)</label>
                        <input type="text" name="location" placeholder="Mfano: Oysterbay, Dar es Salaam" required>
                    </div>
                    <div class="input-box full">
                        <label>Picha Kuu ya Mali</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                    <div class="input-box full">
                        <label>Maelezo Mafupi (Description)</label>
                        <textarea name="description" placeholder="Elezea sifa za mali hii kwa undani..."></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn-upload">
                    <i class="fas fa-cloud-upload-alt"></i> PANDISHA MALI SASA
                </button>
            </form>
        </div>
    </div>

</body>
</html>