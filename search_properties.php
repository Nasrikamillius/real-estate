<?php 
include 'db_connect.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soko la Mali | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --main-blue: #38bdf8; --dark-navy: #0f172a; --soft-bg: #f8fafc; }
        body { background: var(--soft-bg); font-family: 'Poppins', sans-serif; margin: 0; }

        /* Sidebar ya Kijanja */
        .sidebar { width: 280px; height: 100vh; background: var(--dark-navy); position: fixed; color: white; padding: 25px 0; z-index: 1000; }
        .sidebar-brand { padding: 0 30px 40px; color: var(--main-blue); font-weight: 800; font-size: 1.6rem; letter-spacing: 1px; }
        .sidebar a { color: #94a3b8; padding: 14px 30px; display: block; text-decoration: none; transition: 0.4s; font-weight: 500; margin-bottom: 5px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(56, 189, 248, 0.1); color: var(--main-blue); border-right: 4px solid var(--main-blue); }

        .main-content { margin-left: 280px; padding: 40px; }

        /* Search Bar ya Kimataifa (Glassmorphism Effect) */
        .search-wrapper { 
            background: white; 
            padding: 30px; 
            border-radius: 25px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.04); 
            margin-bottom: 45px;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .search-input { border: none; background: #f1f5f9; padding: 15px 25px; border-radius: 15px; width: 100%; font-size: 0.95rem; }
        .search-input:focus { outline: 2px solid var(--main-blue); background: white; }

        /* Smart Property Cards */
        .smart-card { 
            background: white; 
            border-radius: 30px; 
            overflow: hidden; 
            border: none; 
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); 
            height: 100%;
            position: relative;
        }
        .smart-card:hover { transform: translateY(-15px); box-shadow: 0 30px 60px rgba(15, 23, 42, 0.15); }
        
        .img-wrapper { position: relative; height: 260px; overflow: hidden; }
        .img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s; }
        .smart-card:hover .img-wrapper img { transform: scale(1.15); }

        .status-badge { position: absolute; top: 20px; right: 20px; background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(5px); color: white; padding: 6px 18px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; z-index: 10; }
        .price-overlay { position: absolute; bottom: 20px; left: 20px; background: var(--main-blue); color: var(--dark-navy); padding: 8px 20px; border-radius: 15px; font-weight: 800; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3); }

        .card-body { padding: 30px; }
        .prop-title { font-size: 1.25rem; font-weight: 700; color: var(--dark-navy); margin-bottom: 8px; }
        .prop-loc { color: #64748b; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
        
        .btn-discover { 
            background: var(--dark-navy); 
            color: white; 
            width: 100%; 
            padding: 14px; 
            border-radius: 18px; 
            font-weight: 700; 
            text-decoration: none; 
            display: block; 
            text-align: center; 
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-discover:hover { background: var(--main-blue); color: var(--dark-navy); transform: scale(1.02); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">SMART ESTATE</div>
    <a href="search_property.php" class="active"><i class="fas fa-th-large me-2"></i> Gundua Mali</a>
    <a href="my_bookings.php"><i class="fas fa-heart me-2"></i> Bookings Zangu</a>
    <a href="client_maintenance.php"><i class="fas fa-tools me-2"></i> Matengenezo</a>
    <a href="logout.php" class="text-danger mt-5"><i class="fas fa-power-off me-2"></i> Ondoka</a>
</div>

<div class="main-content">
    <div class="search-wrapper">
        <form action="" method="GET" class="row g-3">
            <div class="col-md-9">
                <input type="text" name="q" class="search-input" placeholder="Tafuta mahali, aina ya nyumba, au mtaa..." value="<?php echo $_GET['q'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn-discover m-0" style="padding: 12px;"><i class="fas fa-search me-2"></i> TAFUTA</button>
            </div>
        </form>
    </div>

    <h2 class="fw-bold text-dark mb-4">Mali Mpya Sokoni</h2>

    <div class="row g-4">
        <?php
        // LINK NA ADMIN: Chota data zote alizoweka Admin
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        $sql = "SELECT * FROM properties WHERE status = 'Available' AND (title LIKE ? OR location LIKE ?) ORDER BY property_id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$q%", "%$q%"]);
        $results = $stmt->fetchAll();

        if(count($results) > 0) {
            foreach($results as $row):
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="smart-card">
                <div class="img-wrapper">
                    <div class="status-badge"><?php echo strtoupper($row['property_type']); ?></div>
                    <img src="uploads/<?php echo $row['image_name']; ?>" alt="Property Image">
                    <div class="price-overlay">TZS <?php echo number_format($row['price']); ?></div>
                </div>
                <div class="card-body">
                    <h5 class="prop-title"><?php echo $row['title']; ?></h5>
                    <div class="prop-loc">
                        <i class="fas fa-map-marker-alt text-danger"></i> <?php echo $row['location']; ?>
                    </div>
                    <hr class="my-3 opacity-25">
                    <div class="d-flex justify-content-between text-muted small mb-4">
                        <span><i class="fas fa-bed me-1"></i> 3 Beds</span>
                        <span><i class="fas fa-bath me-1"></i> 2 Baths</span>
                        <span><i class="fas fa-vector-square me-1"></i> 1200 sqft</span>
                    </div>
                    <a href="view_property.php?id=<?php echo $row['property_id']; ?>" class="btn-discover">
                        ANGALIA ZAIDI
                    </a>
                </div>
            </div>
        </div>
        <?php 
            endforeach; 
        } else {
            echo "<div class='col-12 text-center py-5'><h4 class='text-muted'>Pole! Hakuna mali inayofanana na utafutaji wako.</h4></div>";
        }
        ?>
    </div>
</div>

</body>
</html>