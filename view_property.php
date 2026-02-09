<?php 
include 'db_connect.php'; 
session_start();
$id = $_GET['id'];

// Vuta data ya nyumba
$stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ?");
$stmt->execute([$id]);
$prop = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $prop['title']; ?> | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
        
        body { background: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; }
        .hero-section { position: relative; border-radius: 30px; overflow: hidden; margin-top: 20px; }
        .main-img { width: 100%; height: 600px; object-fit: cover; }
        
        /* Floating Booking Card */
        .booking-card { 
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(10px);
            border-radius: 30px; 
            padding: 35px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: sticky;
            top: 20px;
        }

        .gallery-thumb { 
            width: 100%; 
            height: 100px; 
            object-fit: cover; 
            border-radius: 15px; 
            cursor: pointer; 
            transition: 0.3s;
        }
        .gallery-thumb:hover { transform: scale(1.05); }

        .btn-reserve { 
            background: #0f172a; 
            color: white; 
            border-radius: 18px; 
            padding: 18px; 
            font-weight: 700; 
            width: 100%; 
            border: none; 
            transition: 0.3s;
            letter-spacing: 0.5px;
        }
        .btn-reserve:hover { background: #334155; transform: translateY(-3px); }

        .whatsapp-float {
            background: #25d366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            text-decoration: none;
            transition: 0.3s;
        }
        .whatsapp-float:hover { background: #128c7e; transform: scale(1.1); }
        
        .feature-badge {
            background: #f8fafc;
            padding: 12px 20px;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            color: #475569;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-end mb-4 px-2">
        <div>
            <h1 class="fw-800 display-5"><?php echo strtoupper($prop['title']); ?></h1>
            <p class="text-muted fs-5"><i class="fas fa-map-marker-alt text-primary me-2"></i> <?php echo $prop['location']; ?></p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-light rounded-circle p-3 shadow-sm"><i class="far fa-heart"></i></button>
            <button class="btn btn-light rounded-circle p-3 shadow-sm"><i class="fas fa-share-alt"></i></button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="hero-section shadow-lg mb-4">
                <img src="uploads/<?php echo $prop['image_name']; ?>" class="main-img">
            </div>

            <div class="row g-3 mb-5">
                <div class="col-3"><img src="uploads/<?php echo $prop['image_name']; ?>" class="gallery-thumb shadow-sm"></div>
                <div class="col-3"><img src="https://images.unsplash.com/photo-1600566753190-17f0bb2a6c3e" class="gallery-thumb shadow-sm"></div>
                <div class="col-3"><img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d" class="gallery-thumb shadow-sm"></div>
                <div class="col-3"><img src="https://images.unsplash.com/photo-1600121848594-d8644e57abab" class="gallery-thumb shadow-sm"></div>
            </div>

            <div class="bg-white p-5 rounded-5 shadow-sm border mb-5">
                <h3 class="fw-bold mb-4">Maelezo ya Nyumba</h3>
                <div class="mb-4 d-flex flex-wrap">
                    <div class="feature-badge"><i class="fas fa-wifi me-2 text-primary"></i> Free Wi-Fi</div>
                    <div class="feature-badge"><i class="fas fa-swimming-pool me-2 text-primary"></i> Private Pool</div>
                    <div class="feature-badge"><i class="fas fa-car me-2 text-primary"></i> Parking Space</div>
                    <div class="feature-badge"><i class="fas fa-shield-alt me-2 text-primary"></i> 24/7 Security</div>
                </div>
                <p class="text-secondary fs-5" style="line-height: 1.8;">
                    <?php echo nl2br($prop['description']); ?>
                </p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="booking-card border">
                <div class="mb-4">
                    <span class="fs-4 fw-normal text-muted">Kuanzia</span>
                    <h2 class="display-6 fw-800 text-dark">TZS <?php echo number_format($prop['price']); ?></h2>
                    <span class="text-muted">/ kwa mwezi</span>
                </div>

                <hr class="my-4 opacity-10">

                <form action="checkout.php" method="POST">
                    <input type="hidden" name="property_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="amount" value="<?php echo $prop['price']; ?>">
                    
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">TAREHE YA KUHAMIA (CALENDAR)</label>
                        <input type="date" name="booking_date" class="form-control form-control-lg border-0 bg-light p-3 rounded-4" required>
                    </div>

                    <button type="submit" class="btn-reserve shadow-lg mb-3">
                        RESERVE NOW <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="d-flex align-items-center justify-content-center gap-3">
                    <span class="text-muted small">Wasiliana nasi:</span>
                    <a href="https://wa.me/255XXXXXXXXX?text=Habari, nahitaji kuona <?php echo $prop['title']; ?>" class="whatsapp-float shadow">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
                
                <p class="text-center mt-4 text-muted small">
                    <i class="fas fa-info-circle me-1"></i> Hautakatwa pesa mpaka utakapohakikiwa na Admin.
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>