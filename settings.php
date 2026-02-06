<?php
session_start();
require 'db_connect.php';

$update_msg = "";
// Hapa tunachukulia una table inaitwa 'system_settings' au tunaupdate User Admin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Logic ya kusasisha taarifa (Mfano: Password au Jina la Biashara)
    $new_name = $_POST['company_name'];
    $new_pass = $_POST['password'];
    
    // Kwa usalama, hapa tunaupdate password kama imejazwa
    if (!empty($new_pass)) {
        $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE role = 'Admin'");
        $stmt->execute([$hashed_pass]);
    }
    
    $update_msg = "Mipangilio imesasishwa kikamilifu!";
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Mipangilio | Elite Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --accent-blue: #38bdf8;
            --main-bg: #f8fafc;
        }

        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--main-bg); display: flex; }

        /* --- SIDEBAR YA KUDUMU (Zile 9) --- */
        .sidebar {
            width: 280px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            height: 100vh; position: fixed; padding: 30px 20px; box-sizing: border-box; color: white;
        }
        .sidebar h2 { font-size: 1.8rem; font-weight: 800; color: var(--accent-blue); margin-bottom: 40px; }
        .nav-link {
            display: flex; align-items: center; gap: 15px; padding: 14px 20px; color: #94a3b8;
            text-decoration: none; border-radius: 16px; font-weight: 600; margin-bottom: 5px; transition: 0.4s;
        }
        .nav-link:hover, .nav-link.active { background: rgba(255, 255, 255, 0.1); color: var(--accent-blue); transform: translateX(8px); }
        .nav-link.active { background: var(--accent-blue); color: var(--sidebar-bg); }

        /* --- CONTENT --- */
        .main-content { margin-left: 280px; padding: 50px; width: calc(100% - 280px); }
        
        .settings-card { 
            background: white; border-radius: 40px; padding: 45px; max-width: 800px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02);
        }

        .section-title { font-weight: 800; font-size: 1.8rem; color: var(--sidebar-bg); margin-bottom: 10px; }
        .sub-text { color: #64748b; margin-bottom: 35px; font-weight: 500; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .input-group { display: flex; flex-direction: column; gap: 8px; }
        .input-group.full { grid-column: span 2; }

        label { font-weight: 700; color: #334155; font-size: 0.9rem; }
        input { 
            padding: 16px; border: 2px solid #f1f5f9; border-radius: 18px; 
            background: #f8fafc; font-family: inherit; transition: 0.3s;
        }
        input:focus { border-color: var(--accent-blue); background: white; outline: none; }

        .btn-save { 
            background: var(--sidebar-bg); color: white; padding: 20px; border: none; 
            border-radius: 20px; font-weight: 800; font-size: 1rem; cursor: pointer; 
            transition: 0.4s; margin-top: 30px; width: 100%;
        }
        .btn-save:hover { background: var(--accent-blue); color: var(--sidebar-bg); transform: scale(1.02); }

        .toast { background: #dcfce7; color: #15803d; padding: 15px; border-radius: 15px; margin-bottom: 25px; text-align: center; font-weight: 700; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fas fa-gem"></i> ELITE</h2>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="admin_add_property.php" class="nav-link"><i class="fas fa-plus-square"></i> Ongeza Mali</a>
        <a href="admin_manage_properties.php" class="nav-link"><i class="fas fa-building"></i> Dhibiti Mali</a>
        <a href="admin_approve_bookings.php" class="nav-link"><i class="fas fa-check-double"></i> Bookings</a>
        <a href="tenants_list.php" class="nav-link"><i class="fas fa-users-gear"></i> Wapangaji</a>
        <a href="manage_maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-chart-line"></i> Mapato</a>
        <a href="settings.php" class="nav-link active"><i class="fas fa-sliders"></i> Mipangilio</a>
        <div style="height: 100px;"></div>
        <a href="logout.php" class="nav-link" style="color: #fb7185;"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="settings-card">
            <?php if($update_msg) echo "<div class='toast'>$update_msg</div>"; ?>
            
            <div class="section-title">Mipangilio ya Mfumo</div>
            <p class="sub-text">Badilisha jinsi mfumo wako unavyoonekana na kuimarisha ulinzi.</p>

            <form method="POST">
                <div class="form-grid">
                    <div class="input-group">
                        <label>Jina la Kampuni</label>
                        <input type="text" name="company_name" value="Elite Estates Management">
                    </div>
                    <div class="input-group">
                        <label>Namba ya Ofisi</label>
                        <input type="text" name="phone" value="+255 700 000 000">
                    </div>
                    <div class="input-group full">
                        <label>Email ya Ofisi</label>
                        <input type="email" name="email" value="info@eliteestates.co.tz">
                    </div>
                    <div class="input-group full">
                        <label>Neno la Siri Mpya (Acha wazi kama hutaki kubadili)</label>
                        <input type="password" name="password" placeholder="********">
                    </div>
                </div>
                
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> HIFADHI MABADILIKO
                </button>
            </form>
        </div>
    </div>

</body>
</html>