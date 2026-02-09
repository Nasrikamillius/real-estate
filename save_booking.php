<?php 
include 'db_connect.php'; 
session_start();

if(isset($_POST['finalize_booking'])) {
    $user_id = $_SESSION['user_id']; // ID ya mteja aliyelogin
    $prop_id = $_POST['prop_id'];
    $amount = $_POST['amount'];
    $booking_date = date('Y-m-d H:i:s');

    // 1. Ingiza kwenye table ya bookings ikiwa na hali ya 'Pending'
    $sql = "INSERT INTO bookings (user_id, property_id, amount, status, created_at) VALUES (?, ?, ?, 'Pending', ?)";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$user_id, $prop_id, $amount, $booking_date])) {
        // 2. Badilisha hali ya mali kuwa 'Reserved' ili mteja mwingine asiione kama ipo wazi
        $update = $pdo->prepare("UPDATE properties SET status = 'Reserved' WHERE property_id = ?");
        $update->execute([$prop_id]);

        echo "<script>
                alert('Malipo yamepokelewa! Tafadhali subiri Admin athibitishe maombi yako.');
                window.location='my_bookings.php';
              </script>";
    }
}
?>