<?php
session_start();
require 'db_connect.php';

// 1. Kamata ID ya nyumba
if (!isset($_GET['id'])) {
    header("Location: search_properties.php");
    exit();
}

$prop_id = $_GET['id'];

// 2. Vuta maelezo ya nyumba na jina la mmiliki
$stmt = $pdo->prepare("SELECT p.*, u.full_name, u.phone FROM properties p JOIN users u ON p.owner_id = u.user_id WHERE p.property_id = ?");
$stmt->execute([$prop_id]);
$property = $stmt->fetch();

if (!$property) {
    die("Samahani, mali hii haijapatikana.");
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title><?php echo $property['title']; ?> | Elite Estates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #3b82f6; --dark: #0f172a; --gold: #fbbf24; --text-light: #64748b; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #fff; color: var(--dark); line-height: 1.6; }

        .container { max-width: 1200px; margin: 0 auto; padding: 30px 20px; }
        
        /* GALLERY SECTION */
        .gallery { display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 30px; border-radius: 25px; overflow: hidden; height: 500px; }
        .main-img { width: 100%; height: 100%; object-fit: cover; cursor: pointer; transition: 0.3s; }
        .side-imgs { display: grid; grid-template-rows: 1fr 1fr; gap: 15px; }
        .side-img { width: 100%; height: 100%; object-fit: cover; }
        .main-img:hover { opacity: 0.9; }

        /* CONTENT GRID */
        .details-grid { display: grid; grid-template-columns: 1.8fr 1fr; gap: 40px; }
        
        .title-section h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 10px; }
        .loc-badge { display: inline-flex; align-items: center; gap: 8px; color: var(--text-light); margin-bottom: 20px; }
        
        .features { display: flex; gap: 20px; padding: 25px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; margin: 20px 0; }
        .feature-item { display: flex; align-items: center; gap: 10px; font-weight: 600; color: #475569; }
        .feature-item i { color: var(--primary); font-size: 1.2rem; }

        .description { margin-bottom: 30px; color: #475569; font-size: 1.1rem; }

        /* BOOKING CARD */
        .booking-card { 
            background: white; border-radius: 25px; padding: 30px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.1); border: 1px solid #f1f5f9;
            position: sticky; top: 30px;
        }
        .price-box { margin-bottom: 20px; }
        .price-box span { font-size: 2rem; font-weight: 800; color: var(--dark); }
        .btn-book { 
            display: block; width: 100%; background: var(--primary); color: white; 
            text-align: center; padding: 18px; border-radius: 15px; text-decoration: none; 
            font-weight: 800; margin-bottom: 15px; transition: 0.3s;
        }
        .btn-book:hover { background: #2563eb; transform: translateY(-3px); }
        .btn-contact { 
            display: block; width: 100%; background: #f8fafc; color: var(--dark); 
            text-align: center; padding: 15px; border-radius: 15px; text-decoration: none; 
            font-weight: 700; border: 2px solid #e2e8f0; transition: 0.3s;
        }

        .owner-info { display: flex; align-items: center; gap: 15px; margin-top: 25px; padding-top: 25px; border-top: 1px solid #eee; }
        .owner-avatar { width: 50px; height: 50px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary); }
    </style>
</head>
<body>

    <div class="container">
        <a href="search_properties.php" style="text-decoration:none; color:var(--text-light); font-weight:700; display:inline-block; margin-bottom:20px;">
            <i class="fas fa-arrow-left"></i> Rudi kwenye utafutaji
        </a>

        <div class="gallery">
            <img src="https://images.unsplash.com/photo-1600585154340-be6199f7c096?auto=format&fit=crop&w=1200&q=80" class="main-img" alt="Main View">
            <div class="side-imgs">
                <img src="https://images.unsplash.com/photo-1600607687940-4e524cb35a36?auto=format&fit=crop&w=600&q=80" class="side-img" alt="Room 1">
                <img src="https://images.unsplash.com/photo-1600566753190-17f0bb2a6c3e?auto=format&fit=crop&w=600&q=80" class="side-img" alt="Kitchen">
            </div>
        </div>

        <div class="details-grid">
            <div class="info-side">
                <div class="title-section">
                    <h1><?php echo $property['title']; ?></h1>
                    <div class="loc-badge"><i class="fas fa-location-dot"></i> <?php echo $property['location']; ?></div>
                </div>

                <div class="features">
                    <div class="feature-item"><i class="fas fa-bed"></i> 3 Bedrooms</div>
                    <div class="feature-item"><i class="fas fa-bath"></i> 2 Bathrooms</div>
                    <div class="feature-item"><i class="fas fa-expand"></i> 1200 sqft</div>
                    <div class="feature-item"><i class="fas fa-wifi"></i> Free WiFi</div>
                </div>

                <div class="description">
                    <h3 style="margin-bottom:15px; font-weight:800;">Maelezo ya Nyumba</h3>
                    <p><?php echo nl2br($property['description']); ?></p>
                </div>

                <div class="amenities">
                    <h3 style="margin-bottom:15px; font-weight:800;">Vitu Vilivyopo (Amenities)</h3>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                        <p><i class="fas fa-check-circle" style="color:var(--primary);"></i> Usalama saa 24/7</p>
                        <p><i class="fas fa-check-circle" style="color:var(--primary);"></i> Maegesho ya Gari</p>
                        <p><i class="fas fa-check-circle" style="color:var(--primary);"></i> Huduma ya Maji Safi</p>
                        <p><i class="fas fa-check-circle" style="color:var(--primary);"></i> Garden / Uwanja</p>
                    </div>
                </div>
            </div>

            <div class="booking-side">
                <div class="booking-card">
                    <div class="price-box">
                        <small style="color:var(--text-light); font-weight:700;">Bei ya kuanzia</small><br>
                        <span>TZS <?php echo number_format($property['price']); ?></span>
                    </div>

                    <a href="booking_process.php?id=<?php echo $prop_id; ?>" class="btn-book">Weka Ahadi (Book Now)</a>
                    <a href="https://wa.me/<?php echo $property['phone']; ?>" class="btn-contact"><i class="fab fa-whatsapp"></i> Chat na Wakala</a>

                    <div class="owner-info">
                        <div class="owner-avatar"><?php echo substr($property['full_name'], 0, 1); ?></div>
                        <div>
                            <p style="font-weight:800; font-size:0.9rem;"><?php echo $property['full_name']; ?></p>
                            <p style="font-size:0.8rem; color:var(--text-light);">Miliki aliyethibitishwa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>