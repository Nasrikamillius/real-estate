<?php
include 'db_connect.php';
session_start();

// Kama user haja-login, unaweza kumrudisha login
$user_id = $_SESSION['user_id'] ?? 1; 

if (isset($_POST['submit_property'])) {
    $title = $_POST['title'];
    $category = $_POST['category']; 
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $status = 'Pending'; // Inakaa 'Pending' ili Admin aende ku-approve

    $sql = "INSERT INTO properties (title, category, price, location, description, status, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$title, $category, $price, $location, $description, $status, $user_id])) {
        $success = "Hongera! Ombi lako limetumwa kwa Admin kwa uhakiki.";
    } else {
        $error = "Imeshindikana kutuma ombi. Jaribu tena.";
    }
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weka Mali Sokoni | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* WHITE BACKGROUND WITH SOFT GRADIENT */
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #333;
            font-family: 'Poppins', sans-serif;
            padding-bottom: 50px;
        }

        /* GLASSMORPHISM STYLE */
        .glass-card {
            background: rgba(255, 255, 255, 0.7); /* White with transparency */
            backdrop-filter: blur(15px); /* Frosty effect */
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        .navbar-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 30px;
        }

        .form-label { font-weight: 600; color: #444; }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 12px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.9);
            border-color: #0d6efd;
            box-shadow: none;
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: scale(1.02);
            background: #0b5ed7;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-glass py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">SMART ESTATE</a>
        <div class="ms-auto">
            <a href="tenant_dashboard.php" class="btn btn-dark btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-2"></i> Tenant Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card shadow-lg">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Ongeza Mali Mpya 🏠</h2>
                    <p class="text-muted">Jaza fomu hii ili kuituma mali yako kwa Admin kwa uhakiki.</p>
                </div>

                <?php if(isset($success)): ?>
                    <div class="alert alert-success border-0 shadow-sm mb-4"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label">Kichwa cha Habari (Title)</label>
                            <input type="text" name="title" class="form-control" placeholder="Mfano: Apartment ya Kisasa" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Aina ya Mali (Category)</label>
                            <select name="category" class="form-select" required>
                                <option value="">-- Chagua Aina --</option>
                                <option value="Apartment">Apartment</option>
                                <option value="House">Nyumba Kamili</option>
                                <option value="Office">Ofisi</option>
                                <option value="Plot">Kiwanja</option>
                                <option value="Shop">Fremu ya Biashara</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Bei (TZS)</label>
                            <input type="number" name="price" class="form-control" placeholder="Bei kwa mwezi/jumla" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Mahali (Location)</label>
                            <input type="text" name="location" class="form-control" placeholder="Mbezi Beach, Dar es Salaam" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Maelezo ya Ziada</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Elezea sifa za mali yako..."></textarea>
                        </div>

                        <div class="col-md-12 mt-5">
                            <button type="submit" name="submit_property" class="btn btn-primary w-100 py-3 shadow">
                                <i class="fas fa-cloud-upload-alt me-2"></i> Tuma Ombi kwa Uhakiki
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>