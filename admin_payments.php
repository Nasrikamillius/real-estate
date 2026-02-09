<?php 
include 'db_connect.php'; 
session_start();

// Hesabu jumla ya mapato yote (Total Revenue)
$revenue_stmt = $pdo->query("SELECT SUM(amount) as total FROM bookings WHERE status = 'Confirmed'");
$total_revenue = $revenue_stmt->fetch()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Malipo & Mapato | Smart Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { background: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; }
        .stat-card { background: white; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .payment-table { background: white; border-radius: 25px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.05); overflow: hidden; }
        .prop-thumb { width: 70px; height: 50px; object-fit: cover; border-radius: 10px; }
        .status-pill { background: #dcfce7; color: #166534; padding: 6px 15px; border-radius: 50px; font-size: 11px; font-weight: 800; }
        .revenue-text { color: #006aff; font-weight: 800; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-800 text-dark">Usimamizi wa Malipo 💰</h2>
            <p class="text-muted">Fuatilia kila shilingi inayopokelewa kutoka kwa wapangaji.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="stat-card p-4 d-inline-block text-start">
                <small class="text-uppercase text-muted fw-bold small">Jumla ya Mapato (Confirmed)</small>
                <h2 class="revenue-text mb-0">TZS <?php echo number_format($total_revenue); ?></h2>
            </div>
        </div>
    </div>

    <div class="payment-table p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr class="text-muted small fw-bold">
                        <th class="ps-3">NYUMBA / MALI</th>
                        <th>MPANGAJI</th>
                        <th>KIASI ALICHOLIPA</th>
                        <th>TAREHE YA MALIPO</th>
                        <th>HALI (STATUS)</th>
                        <th class="text-center">RISITI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // SQL inayovuta malipo yaliyokamilika tu (Confirmed)
                    $sql = "SELECT b.*, u.username, p.title, p.image_name 
                            FROM bookings b 
                            JOIN users u ON b.user_id = u.user_id 
                            JOIN properties p ON b.property_id = p.property_id 
                            WHERE b.status = 'Confirmed' 
                            ORDER BY b.created_at DESC";
                    
                    $stmt = $pdo->query($sql);
                    while($row = $stmt->fetch()): ?>
                    <tr>
                        <td class="ps-3 py-3">
                            <div class="d-flex align-items-center">
                                <img src="uploads/<?php echo $row['image_name']; ?>" class="prop-thumb me-3 shadow-sm">
                                <div>
                                    <div class="fw-bold"><?php echo $row['title']; ?></div>
                                    <small class="text-muted small">Property ID: #<?php echo $row['property_id']; ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-semibold"><?php echo $row['username']; ?></td>
                        <td><span class="fw-bold text-dark">TZS <?php echo number_format($row['amount']); ?></span></td>
                        <td><small class="text-muted"><?php echo date('d M, Y', strtotime($row['created_at'])); ?></small></td>
                        <td><span class="status-pill text-uppercase">PAID / SUCCESS</span></td>
                        <td class="text-center">
                            <button class="btn btn-light btn-sm rounded-circle"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>