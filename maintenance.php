<?php
include 'db_connect.php';
session_start();

// Hakikisha user_id inatoka kwenye session ya mteja aliye-login
$user_id = $_SESSION['user_id'] ?? 1; 

if (isset($_POST['send_request'])) {
    $issue_type = $_POST['issue_type'];
    $description = $_POST['description'];
    $status = 'Pending';

    // Query ya kuingiza ombi kwenye database
    $sql = "INSERT INTO maintenance (user_id, issue_type, description, status) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$user_id, $issue_type, $description, $status])) {
        $success = "Ombi lako la matengenezo limetumwa kikamilifu!";
    } else {
        $error = "Samahani, imeshindikana kutuma ombi lako.";
    }
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ripoti Tatizo | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: #ffffff; /* Pure white background */
            background-image: radial-gradient(#dee2e6 0.5px, transparent 0.5px);
            background-size: 20px 20px; /* Subtle dot pattern for texture */
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
        }

        /* GLASSMORPHISM ON WHITE */
        .glass-card {
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(209, 213, 219, 0.3);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }

        .form-select, .form-control {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #e0e0e0;
            background: rgba(255, 255, 255, 0.9);
        }

        .btn-primary {
            background: #2563eb;
            border: none;
            padding: 13px;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .back-btn {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <a href="tenant_dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left me-1"></i> Rudi Tenant Dashboard
            </a>

            <div class="glass-card">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">Maintenance Request</h3>
                    <p class="text-muted small">Tuma maelezo ya marekebisho unayohitaji</p>
                </div>

                <?php if(isset($success)): ?>
                    <div class="alert alert-success border-0 rounded-3 small"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Aina ya Tatizo</label>
                        <select name="issue_type" class="form-select" required>
                            <option value="">-- Chagua Moja --</option>
                            <option value="Electrical">Umeme (Lights/Sockets)</option>
                            <option value="Plumbing">Maji (Pipes/Leaking)</option>
                            <option value="Carpentry">Mbao (Doors/Furniture)</option>
                            <option value="AC & Cooling">AC/Feni</option>
                            <option value="Painting">Rangi & Kuta</option>
                            <option value="Security">Security/Fensi</option>
                            <option value="Other">Mengineyo</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">Maelezo Kamili</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Elezea hapa tatizo liko wapi..." required></textarea>
                    </div>

                    <button type="submit" name="send_request" class="btn btn-primary w-100">
                        <i class="fas fa-tools me-2"></i> Tuma Ombi Sasa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>