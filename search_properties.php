<?php
session_start();
require 'db_connect.php';

$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Vuta mali Approved pekee
$sql = "SELECT * FROM properties WHERE status = 'Approved'";
if (!empty($search_query)) {
    $sql .= " AND (title LIKE :search OR location LIKE :search)";
}

$stmt = $pdo->prepare($sql);
if (!empty($search_query)) {
    $stmt->execute(['search' => "%$search_query%"]);
} else {
    $stmt->execute();
}
$properties = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Elite Estates | Tafuta Nyumba</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --primary: #3b82f6; 
            --dark: #0f172a; 
            --sidebar: #1e293b;
            --light-bg: #f1f5f9;
            --gold: #fbbf24;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--light-bg); display: flex; height: 100vh; overflow: hidden; }

        /* SIDEBAR (Consistent with Dashboard) */
        .sidebar { width: 280px; background: var(--sidebar); padding: 30px 20px; display: flex; flex-direction: column; flex-shrink: 0; }
        .brand { color: white; font-size: 1.5rem; font-weight: 800; margin-bottom: 40px; display: flex; align-items: center; gap: 10px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 15px; color: #94a3b8; text-decoration: none; border-radius: 12px; font-weight: 600; margin-bottom: 5px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.05); color: white; }

        /* MAIN AREA */
        .main-content { flex: 1; overflow-y: auto; padding: 30px; }
        
        /* MODERN SEARCH HEADER */
        .hero-search { 
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%); 
            padding: 60px 40px; 
            border-radius: 30px; 
            color: white; 
            margin-bottom: 40px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        .hero-search h1 { font-size: 2.2rem; font-weight: 800; margin-bottom: 10px; }
        .search-form { display: flex; gap: 10px; margin-top: 25px; max-width: 700px; }
        .search-form input { 
            flex: 1; padding: 18px 25px; border-radius: 15px; border: none; 
            font-size: 1rem; box-shadow: 0 10px 15px rgba(0,0,0,0.1); outline: none;
        }
        .search-form button { 
            background: var(--primary); color: white; border: none; padding: 0 30px; 
            border-radius: 15px; font-weight: 700; cursor: pointer; transition: 0.3s;
        }
        .search-form button:hover { transform: scale(1.05); background: #2563eb; }

        /* PROPERTY GRID */
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; }
        .card { 
            background: white; border-radius: 25px; overflow: hidden; 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            position: relative;
        }
        .card:hover { transform: translateY(-12px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
        
        .card-img-wrapper { position: relative; height: 230px; overflow: hidden; }
        .card-img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .card:hover .card-img { transform: scale(1.1); }
        
        .price-tag { 
            position: absolute; bottom: 15px; left: 15px; 
            background: rgba(255,255,255,0.9); backdrop-filter: blur(5px);
            padding: 8px 15px; border-radius: 12px; font-weight: 800; color: var(--dark);
        }
        .status-badge {
            position: absolute; top: 15px; right: 15px;
            background: var(--gold); color: var(--dark);
            padding: 5px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;
        }

        .card-body { padding: 25px; }
        .card-title { font-size: 1.2rem; font-weight: 800; color: var(--dark); margin-bottom: 8px; }
        .card-loc { color: #64748b; font-size: 0.9rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        
        .card-footer { 
            display: flex; justify-content: space-between; align-items: center; 
            padding-top: 15px; border-top: 1px solid #f1f5f9; 
        }
        .btn-details { 
            background: var(--dark); color: white; padding: 10px 20px; 
            border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 0.85rem; 
            transition: 0.3s;
        }
        .btn-details:hover { background: var(--primary); }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="brand"><i class="fas fa-crown" style="color:var(--gold);"></i> Elite Estates</div>
        <nav>
            <a href="tenant_home.php" class="nav-link"><i class="fas fa-house-user"></i> Nyumbani</a>
            <a href="tenant_dashboard.php" class="nav-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="search_properties.php" class="nav-link active"><i class="fas fa-search"></i> Tafuta Nyumba</a>
            <a href="maintenance.php" class="nav-link"><i class="fas fa-screwdriver-wrench"></i> Matengenezo</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="hero-search">
            <h1>Gundua Makazi Bora</h1>
            <p style="opacity: 0.8;">Mali zilizochaguliwa kwa ajili ya usalama na faraja yako.</p>
            
            <form class="search-form" method="GET">
                <input type="text" name="search" placeholder="Tafuta eneo au aina ya nyumba..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Tafuta Sasa</button>
            </form>
        </div>

        <div class="grid">
            <?php foreach ($properties as $p): ?>
            <div class="card">
                <div class="card-img-wrapper">
                    <div class="status-badge">New Listing</div>
                    <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=600&q=80" class="card-img" alt="Nyumba">
                    <div class="price-tag">TZS <?php echo number_format($p['price']); ?></div>
                </div>
                <div class="card-body">
                    <div class="card-title"><?php echo $p['title']; ?></div>
                    <div class="card-loc"><i class="fas fa-location-dot" style="color:var(--primary);"></i> <?php echo $p['location']; ?></div>
                    
                    <div class="card-footer">
                        <span style="font-size: 0.8rem; color: #94a3b8;"><i class="fas fa-bed"></i> 3 Rooms</span>
                        <a href="property_details.php?id=<?php echo $p['property_id']; ?>" class="btn-details">Angalia</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($properties)): ?>
            <div style="text-align:center; padding:100px; color:#94a3b8;">
                <i class="fas fa-house-circle-xmark" style="font-size: 4rem; margin-bottom: 20px;"></i>
                <p>Hakuna nyumba iliyopatikana kwa sasa.</p>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>