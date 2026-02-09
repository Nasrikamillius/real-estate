<?php 
include 'db_connect.php'; 
session_start();

// Logic ya Approve
if(isset($_GET['approve_id'])) {
    $id = $_GET['approve_id'];
    $stmt = $pdo->prepare("UPDATE properties SET status = 'Available' WHERE property_id = ?");
    $stmt->execute([$id]);
    header("Location: admin_approve_properties.php?msg=success");
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Idhinisha Mali | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #0f172a; --accent: #38bdf8; }
        body { background: #f8fafc; margin-left: 280px; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); position: fixed; left: 0; top: 0; padding: 25px; color: white; }
        .nav-link { color: #94a3b8; padding: 12px; border-radius: 10px; margin-bottom: 5px; display: block; text-decoration: none; }
        .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); }
        .prop-item { background: white; border-radius: 20px; padding: 20px; border: none; transition: 0.3s; }
        .prop-item img { width: 120px; height: 120px; object-fit: cover; border-radius: 15px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="fw-bold mb-5" style="color: var(--accent);">SMART ADMIN</h4>
    <a href="dashboard.php" class="nav-link"><i class="fas fa-chart-pie me-2"></i> Dashboard</a>
    <a href="admin_approve_properties.php" class="nav-link active"><i class="fas fa-check-double me-2"></i> Uhakiki Mali</a>
    <a href="admin_manage_properties.php" class="nav-link"><i class="fas fa-home me-2"></i> Mali Zote</a>
</div>

<div class="p-5">
    <h2 class="fw-bold mb-4">Mali Zinazosubiri Uhakiki ⏳</h2>
    
    <?php 
    $stmt = $pdo->query("SELECT * FROM properties WHERE status = 'Pending'");
    $pending_count = $stmt->rowCount();
    
    if($pending_count == 0) {
        echo "<div class='alert alert-info rounded-4'>Hakuna mali mpya zinazosubiri kwa sasa.</div>";
    }

    while($row = $stmt->fetch()): ?>
    <div class="prop-item shadow-sm mb-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-4">
                <img src="uploads/<?php echo $row['image_name']; ?>" class="shadow-sm">
                <div>
                    <h5 class="fw-bold mb-1"><?php echo $row['title']; ?></h5>
                    <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i> <?php echo $row['location']; ?></p>
                    <span class="badge bg-light text-dark">Bei: TZS <?php echo number_format($row['price']); ?></span>
                    <span class="badge bg-warning text-dark ms-2">Pending</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="?approve_id=<?php echo $row['property_id']; ?>" class="btn btn-success rounded-pill px-4 fw-bold">
                    APPROVE <i class="fas fa-check ms-1"></i>
                </a>
                <button class="btn btn-outline-danger rounded-pill px-4 fw-bold">REJECT</button>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

</body>
</html>