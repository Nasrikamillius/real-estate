<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tenant') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


try {
    $stmt = $pdo->prepare("SELECT * FROM utilities WHERE client_id = ? ORDER BY status DESC, id DESC");
    $stmt->execute([$user_id]);
    $bills = $stmt->fetchAll();
} catch (PDOException $e) {
    $bills = [];
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Bili na Malipo | Elite Estates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #0f172a; --accent: #3b82f6; --red: #ef4444; --green: #10b981; --bg: #f8fafc; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); color: var(--primary); padding: 40px 5%; }

        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .header h1 { font-size: 2rem; font-weight: 800; }

        /* WALLET STYLE CARDS */
        .billing-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; }
        
        .bill-card {
            background: white; border-radius: 25px; padding: 30px; position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;
            transition: 0.3s; overflow: hidden;
        }
        .bill-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 6px; height: 100%;
        }
        .unpaid::before { background: var(--red); }
        .paid::before { background: var(--green); }

        .bill-header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .icon-box { width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        
        .status-tag { padding: 5px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .status-unpaid { background: #fee2e2; color: var(--red); }
        .status-paid { background: #dcfce7; color: var(--green); }

        .amount { font-size: 1.8rem; font-weight: 800; margin: 15px 0 5px; }
        .bill-type { font-weight: 700; color: #64748b; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
        
        .bill-details { border-top: 1px dashed #e2e8f0; margin-top: 20px; padding-top: 20px; font-size: 0.9rem; color: #94a3b8; }
        .bill-details p { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .bill-details b { color: var(--primary); }

        .btn-pay {
            width: 100%; background: var(--primary); color: white; border: none;
            padding: 15px; border-radius: 15px; font-weight: 800; cursor: pointer;
            margin-top: 20px; transition: 0.3s; text-decoration: none; display: block; text-align: center;
        }
        .btn-pay:hover { background: var(--accent); transform: translateY(-3px); }

        .empty-state { text-align: center; padding: 100px; background: white; border-radius: 30px; grid-column: 1/-1; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h1>Invois na Malipo</h1>
            <p style="color: #64748b;">Dhibiti bili zako za huduma na kodi hapa.</p>
        </div>
        <a href="tenant_dashboard.php" style="text-decoration:none; color:var(--primary); font-weight:700;"><i class="fas fa-arrow-left"></i> Rudi Dashboard</a>
    </div>

    <div class="billing-grid">
        <?php if (count($bills) > 0): ?>
            <?php foreach ($bills as $b): 
                $isPaid = ($b['status'] == 'Paid');
                $icon = "fa-bolt"; 
                $color = "#fef3c7"; $iColor = "#d97706";
                if($b['bill_type'] == 'Maji') { $icon = "fa-droplet"; $color = "#e0f2fe"; $iColor = "#0284c7"; }
                if($b['bill_type'] == 'Kodi') { $icon = "fa-house-lock"; $color = "#f1f5f9"; $iColor = "#1e293b"; }
            ?>
            <div class="bill-card <?php echo $isPaid ? 'paid' : 'unpaid'; ?>">
                <div class="bill-header">
                    <div class="icon-box" style="background: <?php echo $color; ?>; color: <?php echo $iColor; ?>;">
                        <i class="fas <?php echo $icon; ?>"></i>
                    </div>
                    <span class="status-tag <?php echo $isPaid ? 'status-paid' : 'status-unpaid'; ?>">
                        <?php echo $isPaid ? 'Imelipwa' : 'Inasubiri'; ?>
                    </span>
                </div>
                
                <p class="bill-type"><?php echo $b['bill_type']; ?> - <?php echo $b['billing_month']; ?></p>
                <h2 class="amount">TZS <?php echo number_format($b['amount']); ?></h2>

                <div class="bill-details">
                    <p>Namba ya Invois: <b>#ELT-<?php echo $b['id']; ?></b></p>
                    <p>Tarehe ya Mwisho: <b>28 <?php echo $b['billing_month']; ?></b></p>
                </div>

                <?php if (!$isPaid): ?>
                    <a href="pay_bill.php?id=<?php echo $b['id']; ?>" class="btn-pay">Lipia Sasa</a>
                <?php else: ?>
                    <button class="btn-pay" style="background: #f1f5f9; color: #94a3b8; cursor: default;">Tayari Imelipwa</button>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-file-invoice-dollar" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h2>Huna bili yoyote kwa sasa</h2>
                <p style="color: #94a3b8; margin-top: 10px;">Bili zako zikishatolewa zitaonekana hapa.</p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>