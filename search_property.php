<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Tafuta Mali | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .zillow-card { border: none; border-radius: 20px; transition: 0.3s; overflow: hidden; }
        .zillow-card:hover { transform: scale(1.02); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .price-badge { background: #0f172a; color: #38bdf8; padding: 8px 15px; border-radius: 10px; font-weight: 800; font-size: 1.1rem; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="fw-bold">Gundua Nyumba Bora 🏘️</h1>
            <a href="user_add_property.php" class="btn btn-outline-primary fw-bold rounded-pill">Weka Mali Yako</a>
        </div>
        
        <div class="row g-4">
            <?php 
            // MUHIMU: Tunavuta tu zilizoidhinishwa
            $stmt = $pdo->query("SELECT * FROM properties WHERE status = 'Available' ORDER BY property_id DESC");
            while($row = $stmt->fetch()): ?>
            <div class="col-md-4">
                <div class="card zillow-card h-100 shadow-sm">
                    <img src="uploads/<?php echo $row['image_name']; ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <div class="price-badge mb-3">TZS <?php echo number_format($row['price']); ?></div>
                        <h5 class="fw-bold mb-1"><?php echo $row['title']; ?></h5>
                        <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt"></i> <?php echo $row['location']; ?></p>
                        <a href="view_property.php?id=<?php echo $row['property_id']; ?>" class="btn btn-primary w-100 rounded-pill">View Details</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>