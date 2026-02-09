<?php 
include 'db_connect.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings | Zillow Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Jakarta Sans', sans-serif; }
        .booking-table { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .prop-thumb { width: 80px; height: 60px; object-fit: cover; border-radius: 12px; }
        .status-badge { background: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: 700; }
        .btn-approve { background: #0f172a; color: white; border-radius: 12px; font-weight: 600; padding: 8px 20px; transition: 0.3s; border: none; }
        .btn-approve:hover { background: #334155; transform: scale(1.05); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="mb-5">
        <h2 class="fw-800 text-dark">Maombi ya Malipo 🏠</h2>
        <p class="text-muted">Hakiki malipo ya wateja na upandishe hadhi ya umiliki.</p>
    </div>

    <div class="booking-table">
        <table class="table table-borderless align-middle mb-0">
            <thead class="bg-light">
                <tr class="text-muted small fw-bold">
                    <th class="ps-4">NYUMBA / MALI</th>
                    <th>MPANGAJI</th>
                    <th>KIASI (TZS)</th>
                    <th>TAREHE</th>
                    <th>STATUS</th>
                    <th class="text-center">KITENDO</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // SQL iliyonyooka bila error ya 'b'
                $sql = "SELECT b.*, u.username, p.title, p.image_name 
                        FROM bookings b 
                        JOIN users u ON b.user_id = u.user_id 
                        JOIN properties p ON b.property_id = p.property_id 
                        ORDER BY b.created_at DESC";
                
                $stmt = $pdo->query($sql);
                
                while($row = $stmt->fetch()): ?>
                <tr class="border-bottom">
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <img src="uploads/<?php echo $row['image_name']; ?>" class="prop-thumb me-3 shadow-sm">
                            <div>
                                <h6 class="mb-0 fw-bold"><?php echo $row['title']; ?></h6>
                                <small class="text-muted">ID: #BK-<?php echo $row['booking_id']; ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-600 text-dark"><?php echo $row['username']; ?></div>
                    </td>
                    <td>
                        <div class="fw-bold text-primary">TZS <?php echo number_format($row['amount']); ?></div>
                    </td>
                    <td>
                        <div class="small text-muted"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></div>
                    </td>
                    <td>
                        <span class="status-badge text-uppercase"><?php echo $row['status']; ?></span>
                    </td>
                    <td class="text-center">
                        <a href="approve_action.php?id=<?php echo $row['booking_id']; ?>" class="btn-approve shadow-sm">
                            Approve
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>