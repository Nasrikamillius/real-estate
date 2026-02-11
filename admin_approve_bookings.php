<?php 
include 'db_connect.php'; 
session_start();

// 1. LOGIC YA APPROVE / REJECT
if (isset($_GET['action']) && isset($_GET['id'])) {
    $b_id = $_GET['id'];
    $status = ($_GET['action'] == 'approve') ? 'Confirmed' : 'Cancelled';
    
    // Hapa tumetumia booking_id kama ilivyo kwenye database yako
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
    $stmt->execute([$status, $b_id]);
    header("Location: admin_approve_bookings.php");
    exit();
}

// 2. FETCH DATA (JOIN imerekebishwa kulingana na screenshot zako)
$sql = "SELECT b.*, p.title as property_title, p.price, u.full_name, u.phone 
        FROM bookings b 
        LEFT JOIN properties p ON b.property_id = p.property_id 
        LEFT JOIN users u ON b.user_id = u.id 
        ORDER BY b.created_at DESC";

try {
    $bookings = $pdo->query($sql)->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Usimamizi wa Maombi | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #ffffff; color: #333; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 250px; height: 100vh; background: #212529; position: fixed; padding: 25px; color: white; }
        .main-content { margin-left: 250px; padding: 40px; }
        .table-card { background: #fff; border: 1px solid #dee2e6; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .btn-app { background: #198754; color: white !important; padding: 5px 10px; border-radius: 5px; text-decoration: none; border: none; }
        .btn-rej { background: #dc3545; color: white !important; padding: 5px 10px; border-radius: 5px; text-decoration: none; border: none; margin-left: 5px; }
        .nav-link { color: #adb5bd; padding: 10px; border-radius: 5px; text-decoration: none; display: block; }
        .nav-link.active { background: #0d6efd; color: white; }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="fw-bold text-info mb-4">SMART ESTATE</h4>
    <nav>
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="admin_manage_properties.php" class="nav-link">Mali Zilizopo</a>
        <a href="admin_approve_bookings.php" class="nav-link active">Maombi ya Wateja</a>
        <a href="logout.php" class="nav-link text-danger mt-5">Toka Nje</a>
    </nav>
</div>

<div class="main-content">
    <h2 class="fw-bold mb-4">Uhakiki wa Maombi</h2>
    
    <div class="table-card">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Mteja</th>
                    <th>Nyumba</th>
                    <th>Hali</th>
                    <th>Kitendo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bookings as $row): ?>
                <tr>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($row['full_name'] ?? 'Mteja ID: '.$row['user_id']); ?></div>
                        <small class="text-muted"><?php echo htmlspecialchars($row['phone'] ?? ''); ?></small>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['property_title'] ?? 'N/A'); ?><br>
                        <small class="text-success">TZS <?php echo number_format($row['price'] ?? 0); ?></small>
                    </td>
                    <td>
                        <span class="badge <?php echo $row['status'] == 'Confirmed' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if($row['status'] == 'Pending'): ?>
                            <a href="?action=approve&id=<?php echo $row['booking_id']; ?>" class="btn-app" onclick="return confirm('Kubali?')">
                                <i class="fas fa-check"></i>
                            </a>
                            <a href="?action=reject&id=<?php echo $row['booking_id']; ?>" class="btn-rej" onclick="return confirm('Kataa?')">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php else: ?>
                            <small class="text-muted">Done</small>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>