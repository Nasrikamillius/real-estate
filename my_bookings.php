<?php 
include 'db_connect.php'; 
session_start();

// Hakikisha mteja amelogin
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>My Bookings | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: url('uploads/luxury.jpg') no-repeat center center fixed; 
            background-size: cover;
            min-height: 100vh;
            position: relative;
        }

        /* Overlay ya giza kidogo ili maandishi yaonekane */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.7); /* Dark blue overlay */
            z-index: -1;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            margin-bottom: 40px;
        }

        .booking-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            transition: 0.4s;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .booking-card:hover {
            transform: translateY(-10px);
        }

        .prop-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
        }

        .status-pending { background: #fef9c3; color: #854d0e; }
        .status-confirmed { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="glass-header text-center shadow">
        <h1 class="fw-800 display-4">Panga Makazi Yako 🏠</h1>
        <p class="lead opacity-75">Fuatilia hali ya malipo na booking zako zote hapa.</p>
    </div>

    <div class="row g-4">
        <?php 
        $sql = "SELECT b.*, p.title, p.image_name, p.location 
                FROM bookings b 
                JOIN properties p ON b.property_id = p.property_id 
                WHERE b.user_id = ? 
                ORDER BY b.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$u_id]);
        
        while($row = $stmt->fetch()): ?>
        <div class="col-md-4">
            <div class="card booking-card h-100 position-relative">
                <span class="status-badge shadow-sm <?php echo ($row['status'] == 'Pending') ? 'status-pending' : 'status-confirmed'; ?>">
                    <?php echo $row['status']; ?>
                </span>
                
                <img src="uploads/<?php echo $row['image_name']; ?>" class="prop-img" alt="Property">
                
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-1"><?php echo $row['title']; ?></h5>
                    <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i> <?php echo $row['location']; ?></p>
                    
                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-4">
                        <div>
                            <small class="text-muted d-block">Kiasi Kilicholipwa</small>
                            <span class="fw-800 text-primary">TZS <?php echo number_format($row['amount']); ?></span>
                        </div>
                        <i class="fas fa-receipt text-muted fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>