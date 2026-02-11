<?php
include 'db_connect.php';
session_start();

// 1. Kamata ID ya booking husika pekee
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // 2. Fanya UPDATE kwa ID HIYO MOJA TU (Hapa ndipo palikuwa na shida)
    $stmt = $pdo->prepare("UPDATE bookings SET status = 'Confirmed' WHERE booking_id = ?");
    
    if ($stmt->execute([$booking_id])) {
        // 3. Ikishafanikiwa, mrudishe admin kwenye list
        header("Location: admin_approve_bookings.php?msg=approved");
        exit();
    } else {
        echo "Kuna tatizo limetokea wakati wa ku-approve.";
    }
} else {
    // Kama hakuna ID iliyotumwa
    header("Location: admin_approve_bookings.php");
    exit();
}
?>