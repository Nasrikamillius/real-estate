<?php
include 'db_connect.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Badilisha status kuwa 'Confirmed' au 'Paid'
    $sql = "UPDATE bookings SET status = 'Confirmed' WHERE booking_id = ?";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$id])) {
        echo "<script>alert('Booking Imekubaliwa!'); window.location='admin_approve_bookings.php';</script>";
    }
}
?>