<?php
include 'db_connect.php';
session_start();

// 1. PATA ID YA MALI
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$property_id = $_GET['id'];

// 2. FETCH DATA YA MALI (Bila kumlazimisha mteja ku-login hapa)
$stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ?");
$stmt->execute([$property_id]);
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
    <title><?php echo $property['title']; ?> | Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: #ffffff; 
            color: #333; 
            font-family: 'Poppins', sans-serif;
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.05), rgba(0,0,0,0.05)), url('uploads/property_bg.jpg');
            background-size: cover;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        /* GLASSMORPHISM CARD */
        .details-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 25px;
            padding: 40px;
            margin-top: -100px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .price-tag {
            font-size: 24px;
            font-weight: 700;
            color: #2563eb;
        }
        .btn-book {
            background: #2563eb;
            color: white;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-book:hover {
            background: #1d4ed8;
            transform: translateY(-3px);
            color: white;
        }
    </style>
</head>
<body>

<div class="hero-section">
    <h1 class="fw-bold"><?php echo htmlspecialchars($property['title']); ?></h1>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="details-card">
                <div class="row">
                    <div class="col-md-8">
                        <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($property['category'] ?? 'Real Estate'); ?></span>
                        <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($property['title']); ?></h2>
                        <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($property['location']); ?></p>
                        <hr>
                        <h5 class="fw-bold">Maelezo ya Mali</h5>
                        <p class="text-secondary"><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
                    </div>
                    <div class="col-md-4 text-center border-start">
                        <div class="p-3">
                            <p class="mb-1 text-muted">Bei ya Kupanga/Kununua</p>
                            <p class="price-tag">TZS <?php echo number_format($property['price']); ?></p>
                            
                            <?php if(!isset($_SESSION['user_id'])): ?>
                                <a href="login.php" class="btn btn-book w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login ili ku-Book
                                </a>
                            <?php else: ?>
                                <a href="book_property.php?id=<?php echo $property['property_id']; ?>" class="btn btn-book w-100">
                                    <i class="fas fa-calendar-check me-2"></i> Book Sasa
                                </a>
                            <?php endif; ?>
                            
                            <a href="index.php" class="d-block mt-3 text-decoration-none text-muted small">Rudi Kwenye Orodha</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>