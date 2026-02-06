<?php
session_start();
require 'db_connect.php';

// Ulinzi: Hakikisha mtumiaji ameingia
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tenant') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];

// Vuta Data za Nyumba anazopanga (Rentals)
$rentals = $pdo->prepare("SELECT * FROM properties p JOIN bookings b ON p.property_id = b.property_id WHERE b.client_id = ?");
$rentals->execute([$user_id]);
$my_rentals = $rentals->fetchAll();

// Vuta Data za Mali anazouza/pangisha yeye mwenyewe (My Listings)
$listings = $pdo->prepare("SELECT * FROM properties WHERE owner_id = ?");
$listings->execute([$user_id]);
$my_listings = $listings->fetchAll();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Elite Estates | Smart Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #1e293b;
            --main-bg: #f1f5f9;
            --accent-green: #22c55e;
            --accent-red: #ef4444;
            --gold: #fbbf24;
            --white: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--main-bg); display: flex; height: 100vh; overflow: hidden; }

        /* --- SIDEBAR --- */
        .sidebar { width: 280px; background: var(--sidebar-bg); padding: 30px 20px; display: flex; flex-direction: column; height: 100vh; }
        .brand { color: white; font-size: 1.5rem; font-weight: 800; margin-bottom: 40px; display: flex; align-items: center; gap: 12px; }
        .brand i { color: var(--gold); }

        .nav-link {
            display: flex; align-items: center; gap: 15px; padding: 14px 18px;
            color: #94a3b8; text-decoration: none; border-radius: 12px;
            font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.05); color: white; }

        .btn-sell {
            background: var(--accent-green); color: white; text-decoration: none;
            padding: 15px; border-radius: 12px; text-align: center; font-weight: 700;
            margin-top: auto; display: flex; align-items: center; justify-content: center; gap: 10px;
        }

        /* --- MAIN CONTENT --- */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        
        .top-header {
            background: white; padding: 20px 30px; border-radius: 20px;
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }

        /* WELCOME CARD (Ile yenye picha ya kishua) */
        .welcome-card {
            background: white; border-radius: 25px; padding: 30px;
            display: grid; grid-template-columns: 350px 1fr; gap: 30px;
            margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            align-items: center;
        }
        .welcome-card img { width: 100%; border-radius: 20px; height: 200px; object-fit: cover; }
        .welcome-card h2 { font-size: 2.2rem; color: #1e293b; font-weight: 800; line-height: 1.2; }

        /* TABLES GRID: Hapa ndipo zinakaa side-by-side */
        .tables-container { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        
        .data-section { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.02); }
        .section-title { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 20px; font-weight: 800; color: #1e293b; font-size: 0.95rem;
            border-bottom: 2px solid #f8fafc; padding-bottom: 10px;
        }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; }
        td { padding: 15px 12px; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem; color: #475569; }

        .btn-mini { padding: 8px 15px; border-radius: 10px; font-size: 0.8rem; text-decoration: none; font-weight: 700; transition: 0.3s; }
        .btn-red { background: #fef2f2; color: #ef4444; }
        
        .badge { padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; }
        .bg-green { background: #dcfce7; color: #16a34a; }
        .bg-blue { background: #dbeafe; color: #1e40af; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="brand"><i class="fas fa-crown"></i> Elite Estates</div>
        <nav>
            <a href="tenant_home.php" class="nav-link"><i class="fas fa-house-user"></i> Tenant Home</a>
            
            <a href="tenant_dashboard.php" class="nav-link active"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="search_properties.php" class="nav-link"><i class="fas fa-magnifying-glass"></i> Tafuta Mali</a>
            <a href="my_listings.php" class="nav-link"><i class="fas fa-list-check"></i> Mali Zangu</a>
            <a href="maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
            <a href="billing.php" class="nav-link"><i class="fas fa-wallet"></i> Bili & Malipo</a>
            
            <a href="logout.php" class="nav-link" style="margin-top: 20px; color: #f87171;"><i class="fas fa-power-off"></i> Toka Nje</a>
        </nav>

        <a href="upload_property.php" class="btn-sell">
            <i class="fas fa-plus-circle"></i> Uza / Pakia Mali
        </a>
    </aside>

    <main class="main-content">
        
        <div class="top-header">
            <div>
                <h3 style="font-weight: 800;">Panel ya Udhibiti</h3>
                <small>Karibu, <b style="color:var(--accent-blue);"><?php echo $full_name; ?></b></small>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="maintenance.php" class="btn-mini btn-red"><i class="fas fa-triangle-exclamation"></i> Ripoti Tatizo</a>
                <a href="billing.php" class="btn-mini" style="background: var(--accent-green); color: white;"><i class="fas fa-credit-card"></i> Lipa Bili</a>
            </div>
        </div>

        <div class="welcome-card">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Home">
            <div>
                <h2>Mazingira Bora ya <br> Kuishi na Biashara.</h2>
                <p style="color: #64748b; margin-top: 15px;">Dhibiti malipo yako, ripoti matengenezo, na uza mali zako zote katika sehemu moja salama.</p>
            </div>
        </div>

        <div class="tables-container">
            
            <div class="data-section">
                <div class="section-title">
                    <span>NYUMBA UNAZOPANGA</span>
                    <i class="fas fa-key" style="color:var(--gold);"></i>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>MALI</th>
                            <th>KODI</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($my_rentals as $r): ?>
                        <tr>
                            <td><strong><?php echo $r['title']; ?></strong><br><small><?php echo $r['location']; ?></small></td>
                            <td><b><?php echo number_format($r['price']); ?></b></td>
                            <td><span class="badge bg-green">Active</span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($my_rentals)) echo "<tr><td colspan='3' style='text-align:center; padding:20px;'>Huna nyumba unayopanga.</td></tr>"; ?>
                    </tbody>
                </table>
            </div>

            <div class="data-section">
                <div class="section-title">
                    <span>MALI ZAKO SOKONI</span>
                    <i class="fas fa-tags" style="color:var(--accent-green);"></i>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>TITLE</th>
                            <th>BEI (TZS)</th>
                            <th>SIMAMIA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($my_listings as $l): ?>
                        <tr>
                            <td><strong><?php echo $l['title']; ?></strong><br><small><?php echo $l['property_type']; ?></small></td>
                            <td><b><?php echo number_format($l['price']); ?></b></td>
                            <td><a href="my_listings.php" style="color: var(--accent-blue); text-decoration:none; font-weight:700;">Edit</a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($my_listings)) echo "<tr><td colspan='3' style='text-align:center; padding:20px;'>Hujaweka mali sokoni.</td></tr>"; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </main>
</body>
</html>