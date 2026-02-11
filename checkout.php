<?php 
include 'db_connect.php'; 
session_start();

if (!isset($_GET['id'])) {
    header("Location: search_properties.php");
    exit();
}

$property_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ?");
$stmt->execute([$property_id]);
$property = $stmt->fetch();

if (!$property) { die("Mali haipo!"); }

// Logic ya Redirect & Insert
if (isset($_POST['confirm_booking'])) {
    $p_id = $_POST['property_id'];
    $u_id = $_SESSION['user_id'] ?? 1; 
    $total_price = $property['price'] + 15000;
    $status = 'Pending';

    // INSERT kulingana na column za table yako
    $sql = "INSERT INTO bookings (user_id, property_id, total_price, status) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$u_id, $p_id, $total_price, $status])) {
        echo "<script>
                alert('Malipo yamepokelewa! Admin anahakiki ombi lako sasa hivi.');
                window.location.href='search_properties.php';
              </script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Malipo Salama | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { background: #fdfdfd; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* MBWEMBWE ZA KUCHAGUA MTANDAO */
        .payment-option { display: none; }
        .payment-label {
            border: 2px solid #eee; border-radius: 20px; padding: 20px;
            cursor: pointer; transition: 0.3s all ease; background: white;
            text-align: center; display: block; height: 100%; position: relative;
        }
        .payment-label:hover { border-color: #ff385c; transform: translateY(-5px); }
        
        /* Hapa ndio picha inachaguliwa */
        .payment-option:checked + .payment-label {
            border-color: #ff385c; background: #fff5f6;
            box-shadow: 0 10px 20px rgba(255, 56, 92, 0.1);
        }
        .payment-option:checked + .payment-label::after {
            content: '\f058'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
            position: absolute; top: 10px; right: 10px; color: #ff385c;
        }

        .logo-img { height: 45px; margin-bottom: 10px; object-fit: contain; }
        .btn-confirm {
            background: #ff385c; color: white; padding: 18px; border-radius: 15px;
            width: 100%; font-weight: 800; border: none; font-size: 1.1rem;
        }
        .summary-card { border-radius: 25px; border: 1px solid #eee; padding: 25px; position: sticky; top: 20px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <form method="POST">
                <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
                
                <div class="row g-5">
                    <div class="col-lg-7">
                        <h2 class="fw-800 mb-4">Mbinu ya Malipo</h2>
                        <p class="text-muted mb-4">Chagua mtandao kisha weka namba ya simu au akaunti ya malipo.</p>

                        <div class="row g-3">
                            <div class="col-md-6 col-6">
                                <input type="radio" name="method" id="voda" class="payment-option" checked>
                                <label for="voda" class="payment-label">
                                    <img src="https://upload.wikimedia.org/wikipedia/en/thumb/8/8c/M-Pesa_logo.png/250px-M-Pesa_logo.png" class="logo-img d-block mx-auto">
                                    <span class="small fw-bold">M-Pesa</span>
                                </label>
                            </div>
                            <div class="col-md-6 col-6">
                                <input type="radio" name="method" id="tigo" class="payment-option">
                                <label for="tigo" class="payment-label">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Tigo_logo.svg/1200px-Tigo_logo.svg.png" class="logo-img d-block mx-auto">
                                    <span class="small fw-bold">Tigo Pesa</span>
                                </label>
                            </div>
                            <div class="col-md-6 col-6">
                                <input type="radio" name="method" id="airtel" class="payment-option">
                                <label for="airtel" class="payment-label">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Airtel_logo.svg/2560px-Airtel_logo.svg.png" class="logo-img d-block mx-auto">
                                    <span class="small fw-bold">Airtel Money</span>
                                </label>
                            </div>
                            <div class="col-md-6 col-6">
                                <input type="radio" name="method" id="bank" class="payment-option">
                                <label for="bank" class="payment-label">
                                    <div class="logo-img d-flex align-items-center justify-content-center mx-auto">
                                        <i class="fas fa-university fa-2x text-secondary"></i>
                                    </div>
                                    <span class="small fw-bold">Bank Transfer</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-5 p-4 bg-light rounded-4 border">
                            <label class="fw-bold mb-2">Weka Namba ya Malipo (Namba ya Simu / Akaunti)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-phone-alt text-muted"></i></span>
                                <input type="text" name="payment_ref" class="form-control form-control-lg border-start-0 shadow-none" placeholder="07XXXXXXXX au Namba ya Akaunti" required>
                            </div>
                            <p class="text-muted small mt-2"><i class="fas fa-lock me-1"></i> Malipo ni salama na yatahifadhiwa kwa Admin.</p>
                        </div>

                        <div class="mt-4">
                            <button type="submit" name="confirm_booking" class="btn-confirm shadow-lg">
                                Kamilisha Malipo TZS <?php echo number_format($property['price'] + 15000); ?>
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="summary-card bg-white shadow-sm">
                            <h5 class="fw-bold mb-4">Muhtasari wa Mali</h5>
                            <div class="d-flex gap-3 mb-4">
                                <img src="uploads/<?php echo $property['image_name']; ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 18px;">
                                <div>
                                    <h6 class="fw-bold mb-1"><?php echo $property['title']; ?></h6>
                                    <p class="small text-muted mb-0"><i class="fas fa-map-marker-alt"></i> <?php echo $property['location']; ?></p>
                                    <span class="badge bg-success-subtle text-success mt-2">Inapatikana</span>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Kodi ya Nyumba</span>
                                <span class="fw-bold">TZS <?php echo number_format($property['price']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Ada ya Huduma (Service)</span>
                                <span class="fw-bold">TZS 15,000</span>
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-800 fs-5">Jumla Kuu</span>
                                <span class="fw-800 fs-4 text-danger">TZS <?php echo number_format($property['price'] + 15000); ?></span>
                            </div>

                            <div class="mt-4 p-3 rounded-4 bg-light text-center">
                                <p class="small mb-0 text-muted">Ujumbe utatumwa kwa Admin mara tu utakapothibitisha.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>