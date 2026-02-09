<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $u_id = $_SESSION['user_id'];
    $p_id = $_POST['property_id'];
    $amount = $_POST['amount'];
    $phone = $_POST['phone'];
    $b_date = $_POST['booking_date'];

    try {
        // Tunahifadhi kama 'Pending' ili Admin athibitishe picha ya muamala/pesa
        // Hakikisha majina haya yanafanana na ya database yako
$sql = "INSERT INTO bookings (user_id, property_id, amount, status, created_at) 
        VALUES (?, ?, ?, 'Pending', NOW())";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$u_id, $p_id, $amount])) {
            // Tukifanikiwa, tunampeleka mteja kwenye ukurasa wa pongezi
            header("Location: payment_success.php");
            exit();
        }
    } catch (PDOException $e) {
        // Hapa itakuambia kama bado kuna tatizo la database badala ya kuleta Fatal Error nyeusi
        die("Kuna tatizo la kiufundi: " . $e->getMessage());
    }
}
?>