<?php 
include 'db_connect.php'; 
session_start();

// Hakikisha mteja amelogin kabla ya kulipa
if(!isset($_SESSION['user_id'])){ 
    header("Location: login.php"); 
    exit(); 
}

// Pokea data kutoka View Property
$p_id = $_POST['property_id'] ?? null;
$amount = $_POST['amount'] ?? 0;
$b_date = $_POST['booking_date'] ?? '';

if(!$p_id) { header("Location: search_property.php"); exit(); }

// Vuta data ya nyumba kwa ajili ya muhtasari (Summary)
$stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ?");
$stmt->execute([$p_id]);
$prop = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; }
        .checkout-container { max-width: 1000px; margin: 50px auto; }
        .card-custom { border-radius: 25px; border: none; overflow: hidden; }
        .payment-method { 
            border: 2px solid #e2e8f0; border-radius: 15px; padding: 15px; 
            cursor: pointer; transition: 0.3s; margin-bottom: 10px;
        }
        .payment-method:hover, .payment-method.active { border-color: #0f172a; background: #f1f5f9; }
        .prop-preview-img { width: 100px; height: 100px; object-fit: cover; border-radius: 15px; }
        .btn-pay { background: #0f172a; color: white; border-radius: 15px; padding: 18px; font-weight: 700; width: 100%; border: none; }
    </style>
</head>
<body>

<div class="container checkout-container">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-custom shadow-sm p-4 bg-white">
                <h3 class="fw-bold mb-4">Thibitisha na Lipa</h3>
                
                <h6 class="fw-bold mb-3">Chagua Njia ya Malipo</h6>
                <div class="payment-method active d-flex align-items-center">
                    <i class="fas fa-mobile-alt fa-2x me-3 text-primary"></i>
                    <div>
                        <p class="mb-0 fw-bold">Mobile Money (M-Pesa / Tigo Pesa)</p>
                        <small class="text-muted">Lipia kwa namba ya simu papo hapo</small>
                    </div>
                </div>
                <div class="payment-method d-flex align-items-center">
                    <i class="fas fa-credit-card fa-2x me-3 text-muted"></i>
                    <div>
                        <p class="mb-0 fw-bold">Kadi ya Benki (Visa/MasterCard)</p>
                        <small class="text-muted">Coming soon...</small>
                    </div>
                </div>

                <form action="process_payment.php" method="POST" class="mt-4">
                    <input type="hidden" name="property_id" value="<?php echo $p_id; ?>">
                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="booking_date" value="<?php echo $b_date; ?>">
                    
                    <div class="mb-4">
                        <label class="small fw-bold mb-2">NAMBA YAKO YA SIMU (KWA MALIPO)</label>
                        <input type="text" name="phone" class="form-control form-control-lg bg-light border-0" placeholder="0xxx xxx xxx" required>
                    </div>

                    <button type="submit" class="btn-pay shadow-lg">
                        KAMILISHA OMBI LA MALI <i class="fas fa-lock ms-2"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-custom shadow-sm p-4 bg-white">
                <h5 class="fw-bold mb-4">Muhtasari wa Oda</h5>
                <div class="d-flex gap-3 mb-4">
                    <img src="uploads/<?php echo $prop['image_name']; ?>" class="prop-preview-img">
                    <div>
                        <h6 class="fw-bold mb-1"><?php echo $prop['title']; ?></h6>
                        <p class="small text-muted mb-0"><?php echo $prop['location']; ?></p>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tarehe ya kuanza</span>
                    <span class="fw-bold"><?php echo date('M d, Y', strtotime($b_date)); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Kodi ya mwezi 1</span>
                    <span>TZS <?php echo number_format($amount); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Ada ya huduma (VAT)</span>
                    <span>TZS 0</span>
                </div>
                
                <div class="d-flex justify-content-between border-top pt-3">
                    <h5 class="fw-bold">Jumla Kuu</h5>
                    <h4 class="fw-800 text-primary">TZS <?php echo number_format($amount); ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>