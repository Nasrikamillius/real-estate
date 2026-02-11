<?php 
include 'db_connect.php'; 
session_start();

// 1. Pata ID ya mali husika
if (!isset($_GET['id'])) {
    header("Location: search_properties.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ?");
$stmt->execute([$id]);
$property = $stmt->fetch();

if (!$property) {
    die("Mali haipatikani!");
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $property['title']; ?> | AIRESTATE Luxury</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
        
        body { background-color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif; color: #1a1a1a; }

        /* WhatsApp Style Gallery */
        .gallery-container { position: relative; border-radius: 30px; overflow: hidden; margin-top: 20px; }
        .main-img { width: 100%; height: 550px; object-fit: cover; cursor: pointer; transition: 0.5s; }
        .thumbnail-strip { 
            display: flex; gap: 15px; margin-top: 15px; padding: 10px; 
            overflow-x: auto; white-space: nowrap; 
        }
        .thumb-item { 
            width: 120px; height: 90px; object-fit: cover; border-radius: 15px; 
            cursor: pointer; transition: 0.3s; border: 3px solid transparent; 
        }
        .thumb-item:hover, .thumb-item.active { border-color: #ff385c; transform: translateY(-5px); }

        /* Airbnb Style Sidebar */
        .booking-card {
            position: sticky; top: 100px;
            background: white; border-radius: 25px; border: 1px solid #ebebeb;
            padding: 30px; box-shadow: 0 15px 45px rgba(0,0,0,0.08);
        }
        .price-text { font-size: 28px; font-weight: 800; color: #1a1a1a; }
        .reserve-btn {
            background: linear-gradient(to right, #e61e4d 0%, #e31c5f 50%, #d70466 100%);
            color: white; border: none; padding: 15px; width: 100%;
            border-radius: 15px; font-weight: 700; font-size: 1.1rem;
            transition: 0.3s; text-decoration: none; display: block; text-align: center;
        }
        .reserve-btn:hover { transform: scale(1.02); color: white; opacity: 0.9; }

        /* WhatsApp Float Button */
        .wa-contact {
            background: #25d366; color: white; padding: 12px 25px;
            border-radius: 100px; text-decoration: none; font-weight: 600;
            display: inline-flex; align-items: center; transition: 0.3s;
        }
        .wa-contact:hover { background: #128c7e; color: white; box-shadow: 0 10px 20px rgba(37,211,102,0.2); }

        .feature-icon { width: 50px; height: 50px; background: #f7f7f7; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #ff385c; font-size: 1.2rem; }
    </style>
</head>
<body>

<nav class="navbar py-3 border-bottom">
    <div class="container">
        <a href="search_properties.php" class="text-dark text-decoration-none fw-bold">
            <i class="fas fa-chevron-left me-2"></i> Rudi Kwenye Orodha
        </a>
        <div class="d-flex gap-3">
            <button class="btn btn-outline-dark rounded-pill px-4"><i class="far fa-heart me-2"></i> Save</button>
            <button class="btn btn-outline-dark rounded-pill px-4"><i class="fas fa-share-alt me-2"></i> Share</button>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row g-5">
        <div class="col-lg-8">
            <h2 class="fw-800 mb-2"><?php echo $property['title']; ?></h2>
            <p class="text-muted"><i class="fas fa-map-marker-alt text-danger me-2"></i> <?php echo $property['location']; ?></p>

            <div class="gallery-container shadow-lg">
                <img src="uploads/<?php echo $property['image_name']; ?>" class="main-img" id="imgDisplay">
            </div>
            <div class="thumbnail-strip">
                <img src="uploads/<?php echo $property['image_name']; ?>" class="thumb-item active" onclick="updateImg(this)">
                <img src="https://images.unsplash.com/photo-1600607687940-477a63bd39d8" class="thumb-item" onclick="updateImg(this)">
                <img src="https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3" class="thumb-item" onclick="updateImg(this)">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c" class="thumb-item" onclick="updateImg(this)">
            </div>

            

            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Sifa na Huduma</h4>
                    <a href="https://wa.me/255700000000?text=Habari, nahitaji kujua zaidi kuhusu: <?php echo $property['title']; ?>" class="wa-contact">
                        <i class="fab fa-whatsapp me-2 fa-lg"></i> Uliza WhatsApp
                    </a>
                </div>
                
                <div class="row g-4 mb-5">
                    <div class="col-md-3 col-6 text-center">
                        <div class="feature-icon mx-auto mb-2"><i class="fas fa-bed"></i></div>
                        <span class="small fw-bold">3 Vyumba</span>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="feature-icon mx-auto mb-2"><i class="fas fa-bath"></i></div>
                        <span class="small fw-bold">2 Bafu</span>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="feature-icon mx-auto mb-2"><i class="fas fa-wifi"></i></div>
                        <span class="small fw-bold">WiFi Bure</span>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="feature-icon mx-auto mb-2"><i class="fas fa-parking"></i></div>
                        <span class="small fw-bold">Parking Safi</span>
                    </div>
                </div>

                <hr>
                <h4 class="fw-bold mt-4">Maelezo Kamili</h4>
                <p class="text-secondary" style="line-height: 2;">
                    <?php echo nl2br($property['description']); ?>
                </p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="booking-card">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <span class="price-text">TZS <?php echo number_format($property['price']); ?></span>
                        <span class="text-muted small">/ mwezi</span>
                    </div>
                    <div class="small fw-bold"><i class="fas fa-star text-warning"></i> 4.9 (12 Reviews)</div>
                </div>

                <div class="border rounded-4 mb-3">
                    <div class="row g-0">
                        <div class="col-6 border-end p-3">
                            <label class="text-uppercase x-small fw-bold d-block" style="font-size: 0.6rem;">Check-in</label>
                            <input type="date" class="border-0 w-100 p-0" style="font-size: 0.9rem;">
                        </div>
                        <div class="col-6 p-3">
                            <label class="text-uppercase x-small fw-bold d-block" style="font-size: 0.6rem;">Checkout</label>
                            <input type="date" class="border-0 w-100 p-0" style="font-size: 0.9rem;">
                        </div>
                    </div>
                    <div class="border-top p-3">
                        <label class="text-uppercase x-small fw-bold d-block" style="font-size: 0.6rem;">Wapangaji</label>
                        <select class="border-0 w-100 p-0 bg-transparent" style="font-size: 0.9rem;">
                            <option>Mtu 1</option>
                            <option>Watu 2</option>
                        </select>
                    </div>
                </div>

                <a href="checkout.php?id=<?php echo $property['property_id']; ?>" class="reserve-btn">
                    Hifadhi Sasa (Reserve)
                </a>
                
                <p class="text-center text-muted small mt-3">Hukatwi hela mpaka Admin athibitishe</p>
                
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-decoration-underline">Kodi ya Mwezi</span>
                        <span>TZS <?php echo number_format($property['price']); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-decoration-underline">Service fee</span>
                        <span>TZS 20,000</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Jumla</span>
                        <span>TZS <?php echo number_format($property['price'] + 20000); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateImg(element) {
        // Badilisha picha kuu
        document.getElementById('imgDisplay').src = element.src;
        
        // Rekebisha active state ya thumbnails
        document.querySelectorAll('.thumb-item').forEach(img => img.classList.remove('active'));
        element.classList.add('active');
    }
</script>

</body>
</html>