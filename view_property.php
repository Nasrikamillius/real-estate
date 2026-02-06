<?php
session_start();
require 'db_connect.php';

// 1. Hakikisha ID ya nyumba ipo kwenye URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$prop_id = $_GET['id'];

try {
    // 2. Vuta maelezo ya nyumba (Pamoja na owner_id kama ulivyosema ipo huko)
    $stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ?");
    $stmt->execute([$prop_id]);
    $property = $stmt->fetch();

    if (!$property) {
        die("<h1 style='text-align:center; margin-top:50px;'>Samahani! Nyumba hii haipo kwenye mfumo wetu.</h1>");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($property['title']); ?> | Elite Estates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #0f172a; --secondary: #3b82f6; --gold: #c5a059; --bg: #f1f5f9; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); color: var(--primary); line-height: 1.6; }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        /* --- IMAGE SHOWCASE --- */
        .property-hero {
            position: relative; width: 100%; height: 550px; 
            border-radius: 40px; overflow: hidden; margin-bottom: 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
        }
        .property-hero img { width: 100%; height: 100%; object-fit: cover; }
        .back-btn {
            position: absolute; top: 30px; left: 30px; background: white;
            padding: 12px 25px; border-radius: 15px; text-decoration: none;
            color: var(--primary); font-weight: 700; box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: 0.3s; z-index: 10;
        }
        .back-btn:hover { background: var(--secondary); color: white; }

        /* --- CONTENT GRID --- */
        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }

        /* Left Side: Details */
        .info-section { background: white; padding: 50px; border-radius: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .price-badge { color: var(--secondary); font-size: 2.2rem; font-weight: 800; margin-bottom: 10px; display: block; }
        .title { font-size: 2.8rem; font-weight: 800; margin-bottom: 15px; letter-spacing: -1px; }
        .loc { display: flex; align-items: center; gap: 8px; color: #64748b; font-size: 1.1rem; margin-bottom: 40px; }

        .specs { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        .spec-box { background: var(--bg); padding: 20px; border-radius: 20px; text-align: center; }
        .spec-box i { font-size: 1.4rem; color: var(--secondary); margin-bottom: 8px; display: block; }
        .spec-box b { font-size: 1rem; color: var(--primary); }

        .desc-text { color: #475569; font-size: 1.1rem; border-top: 1px solid #f1f5f9; padding-top: 30px; }

        /* Right Side: Action Card */
        .action-card {
            background: var(--primary); color: white; padding: 40px; border-radius: 40px;
            height: fit-content; position: sticky; top: 30px;
            box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.3);
        }
        .action-card h3 { font-size: 1.6rem; margin-bottom: 20px; }
        .owner-tag { background: rgba(255,255,255,0.1); padding: 10px 20px; border-radius: 50px; font-size: 0.8rem; margin-bottom: 30px; display: inline-block; }

        /* --- HIKI NDICHO KITUFE CHA KUPANGA --- */
        .booking-button {
            display: flex; justify-content: center; align-items: center; gap: 12px;
            background: var(--secondary); color: white; text-decoration: none;
            padding: 22px; border-radius: 20px; font-weight: 800; font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
        }
        .booking-button:hover {
            transform: translateY(-8px);
            background: #2563eb;
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.5);
        }

        .login-warning {
            background: rgba(251, 191, 36, 0.1); border: 1px solid #fbbf24;
            color: #fbbf24; padding: 15px; border-radius: 15px; text-align: center;
            font-size: 0.9rem; margin-top: 20px;
        }

        @media (max-width: 900px) {
            .main-grid { grid-template-columns: 1fr; }
            .property-hero { height: 350px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="property-hero">
            <a href="index.php" class="back-btn"><i class="fas fa-chevron-left"></i> Rudi Nyuma</a>
            <img src="<?php echo htmlspecialchars($property['image_path']); ?>" alt="Luxury Property">
        </div>

        <div class="main-grid">
            <div class="info-section">
                <span class="price-badge">TZS <?php echo number_format($property['price']); ?> <small style="font-size: 0.9rem; font-weight: 400; color: #94a3b8;">/mwezi</small></span>
                <h1 class="title"><?php echo htmlspecialchars($property['title']); ?></h1>
                <div class="loc"><i class="fas fa-location-arrow" style="color: var(--secondary);"></i> <?php echo htmlspecialchars($property['location']); ?></div>

                <div class="specs">
                    <div class="spec-box"><i class="fas fa-bed"></i><b>3 Vyumba</b></div>
                    <div class="spec-box"><i class="fas fa-bath"></i><b>2 Choo</b></div>
                    <div class="spec-box"><i class="fas fa-shield-halved"></i><b>Ulinzi</b></div>
                    <div class="spec-box"><i class="fas fa-wifi"></i><b>WiFi</b></div>
                </div>

                <div class="desc-text">
                    <h3 style="margin-bottom: 15px;">Kuhusu Nyumba Hii</h3>
                    <p>Nyumba hii ya kifahari imejengwa kwa kufuata miongozo ya kisasa. Inatoa mazingira tulivu yenye ulinzi wa kutosha kwa ajili yako na familia yako. Nyumba ipo karibu na barabara kuu na huduma muhimu kama hospitali na maduka makubwa.</p>
                </div>
            </div>

            <aside class="action-card">
                <div class="owner-tag"><i class="fas fa-user-tie"></i> Owner ID: #<?php echo $property['owner_id']; ?></div>
                <h3>Anza Mchakato wa Kupanga</h3>
                <p style="opacity: 0.8; margin-bottom: 30px; font-size: 0.95rem;">Maombi yako yatatumwa moja kwa moja kwa usimamizi na utajibiwa ndani ya muda mfupi.</p>

                <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'tenant'): ?>
                    <a href="booking_process.php?property_id=<?php echo $property['property_id']; ?>" class="booking-button">
                        OMBA KUPANGA SASA <i class="fas fa-arrow-right"></i>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="booking-button" style="background: var(--gold); box-shadow: none;">
                        INGIA ILI UOMBE <i class="fas fa-lock"></i>
                    </a>
                    <div class="login-warning">Unapaswa kuwa na akaunti ya mteja ili uweze kutuma ombi la kupanga.</div>
                <?php endif; ?>

                <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.9rem;">
                    <p style="margin-bottom: 10px;"><i class="fas fa-phone-volume" style="margin-right:10px;"></i> +255 7XX XXX XXX</p>
                    <p><i class="fas fa-headset" style="margin-right:10px;"></i> Huduma kwa Wateja 24/7</p>
                </div>
            </aside>
        </div>
    </div>

</body>
</html>