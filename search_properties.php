<?php 
include 'db_connect.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Luxury | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
        
        body { 
            background-color: #f0f4f8; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            overflow-x: hidden;
        }

        /* Hero Background ya Hatari */
        .hero-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
            background-size: cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            position: relative;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
        }

        /* Glassmorphism Navbar */
        .glass-nav {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding: 15px 0;
        }

        /* Mbwembwe za Search Box */
        .search-wrapper {
            background: white;
            padding: 10px;
            border-radius: 100px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            max-width: 800px;
            width: 90%;
            margin-top: -50px;
            display: flex;
            transition: 0.4s;
            border: 5px solid rgba(255, 255, 255, 0.5);
        }
        
        .search-wrapper:focus-within { transform: scale(1.05); }

        .search-wrapper input { 
            border: none; padding: 15px 30px; width: 100%; border-radius: 100px; outline: none; font-size: 1.1rem;
        }

        .btn-search { 
            background: linear-gradient(45deg, #ff385c, #bd1e59); /* Airbnb Color */
            color: white; border: none; padding: 0 40px; border-radius: 100px; font-weight: 700;
        }

        /* Property Cards za Mbwembwe */
        .house-card {
            background: white;
            border-radius: 30px;
            border: none;
            transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            height: 100%;
        }

        .house-card:hover { 
            transform: scale(1.03) translateY(-10px);
            box-shadow: 0 30px 60px rgba(0,0,0,0.15);
        }

        .img-zoom-container { overflow: hidden; height: 260px; position: relative; }
        .house-card img { transition: 0.8s; width: 100%; height: 100%; object-fit: cover; }
        .house-card:hover img { transform: scale(1.1); }

        .price-badge {
            position: absolute;
            top: 20px; right: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: 8px 18px;
            border-radius: 15px;
            font-weight: 800;
            color: #ff385c;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-book {
            background: #0f172a; color: white; border-radius: 15px; padding: 12px;
            font-weight: 700; width: 100%; text-decoration: none; display: block;
            text-align: center; transition: 0.3s;
        }
        
        .btn-book:hover { background: #ff385c; color: white; letter-spacing: 1px; }

        .location-text { color: #64748b; font-size: 0.9rem; }
    </style>
</head>
<body>

<nav class="navbar glass-nav sticky-top">
    <div class="container">
        <a class="navbar-brand fw-800" href="#"><span style="color: #ff385c;">AIR</span>ESTATE</a>
        <div class="ms-auto">
            <a href="tenant_dashboard.php" class="btn btn-dark rounded-pill px-4 shadow-sm animate__animated animate__fadeInRight">
                <i class="fas fa-th-large me-2"></i> Dashboard Yangu
            </a>
        </div>
    </div>
</nav>

<div class="hero-banner animate__animated animate__fadeIn">
    <h1 class="display-3 fw-800 animate__animated animate__zoomIn">Find Your Dream Stay</h1>
    <p class="lead opacity-75 animate__animated animate__fadeInUp animate__delay-1s">Nyumba za kifahari mkononi mwako.</p>
</div>

<div class="container d-flex justify-content-center">
    <form action="" method="GET" class="search-wrapper animate__animated animate__slideInUp">
        <input type="text" name="query" placeholder="Unataka kwenda wapi? (Mfano: Masaki, Kinondoni...)">
        <button type="submit" class="btn-search">Search</button>
    </form>
</div>

<div class="container py-5 mt-4">
    <div class="row g-4">
        <?php 
        $sql = "SELECT * FROM properties WHERE status = 'Available'";
        $stmt = $pdo->query($sql);
        
        while($row = $stmt->fetch()): ?>
        <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp">
            <div class="card house-card shadow-sm">
                <div class="img-zoom-container">
                    <img src="uploads/<?php echo $row['image_name']; ?>" alt="Nyumba">
                    <div class="price-badge">TZS <?php echo number_format($row['price']); ?></div>
                </div>
                <div class="card-body p-4 text-start">
                    <h5 class="fw-bold mb-1 text-dark"><?php echo $row['title']; ?></h5>
                    <p class="location-text mb-3"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo $row['location']; ?></p>
                    <div class="d-flex mb-3 gap-3 text-muted small">
                        <span><i class="fas fa-bed"></i> 3 Beds</span>
                        <span><i class="fas fa-bath"></i> 2 Baths</span>
                        <span><i class="fas fa-expand"></i> 120sqm</span>
                    </div>
                    <a href="checkout.php?id=<?php echo $row['property_id']; ?>" class="btn-book">
                        Reserve Now
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>