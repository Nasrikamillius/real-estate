<?php 
include 'db_connect.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wapangaji Waliopo | Glass Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');

        body {
            /* Background image ya kifahari */
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1600607687940-4e23035607d9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.1); /* Muonekano wa kioo */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            width: 100%;
        }

        .main-title {
            color: white;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 30px;
        }

        .custom-table {
            background: rgba(255, 255, 255, 0.95); /* Table nyeupe iliyotulia */
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .custom-table thead {
            background: #0f172a;
            color: white;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .avatar-box {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #006aff, #00d4ff);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .status-pill {
            background: #dcfce7;
            color: #15803d;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
        }

        .btn-view {
            background: #f1f5f9;
            border: none;
            color: #0f172a;
            border-radius: 10px;
            padding: 8px 12px;
            transition: 0.3s;
        }

        .btn-view:hover {
            background: #006aff;
            color: white;
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="glass-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="main-title mb-0">Wapangaji Waliopo 🏡</h2>
            <span class="badge bg-primary rounded-pill px-3">Admin Panel</span>
        </div>

        <div class="custom-table">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="p-4">Mpangaji</th>
                            <th>Simu / Barua Pepe</th>
                            <th>Mali / Nyumba</th>
                            <th>Tarehe ya Kuanza</th>
                            <th>Status</th>
                            <th class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Query inayopata data zote muhimu
                        $sql = "SELECT u.username, u.email, p.title, b.created_at, b.status 
                                FROM bookings b 
                                JOIN users u ON b.user_id = u.user_id 
                                JOIN properties p ON b.property_id = p.property_id 
                                WHERE b.status = 'Confirmed'
                                ORDER BY b.created_at DESC";
                        
                        $stmt = $pdo->query($sql);
                        if($stmt->rowCount() > 0):
                            while($row = $stmt->fetch()): ?>
                            <tr>
                                <td class="p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-box me-3"><?php echo strtoupper(substr($row['username'], 0, 1)); ?></div>
                                        <span class="fw-bold text-dark"><?php echo $row['username']; ?></span>
                                    </div>
                                </td>
                                <td class="text-muted small"><?php echo $row['email']; ?></td>
                                <td class="fw-semibold text-primary"><?php echo $row['title']; ?></td>
                                <td class="text-muted small"><?php echo date('d M, Y', strtotime($row['created_at'])); ?></td>
                                <td><span class="status-pill">ACTIVE</span></td>
                                <td class="text-center">
                                    <button class="btn-view"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                            <?php endwhile; 
                        else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-user-slash d-block fs-1 mb-3"></i>
                                    Bado hakuna mpangaji aliyethibitishwa.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>