<?php
session_start();
require 'db_connect.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Log in kwanza ili uweze kubook");
    exit();
}

if (isset($_GET['property_id'])) {
    $property_id = $_GET['property_id'];
    $client_id = $_SESSION['user_id'];

    try {
        
        $check = $pdo->prepare("SELECT * FROM bookings WHERE property_id = ? AND client_id = ? AND status != 'Cancelled'");
        $check->execute([$property_id, $client_id]);

        if ($check->rowCount() > 0) {
            header("Location: tenant_dashboard.php?msg=Tayari ulishatuma maombi ya nyumba hii.");
            exit();
        }

        
        $stmt = $pdo->prepare("INSERT INTO bookings (property_id, client_id, status) VALUES (?, ?, 'Pending')");
        if ($stmt->execute([$property_id, $client_id])) {
            
            header("Location: tenant_dashboard.php?success=Ombi lako limetumwa! Subiri uthibitisho.");
            exit();
        }

    } catch (PDOException $e) {
        die("Kosa la kiufundi: " . $e->getMessage());
    }
} else {
    header("Location: search_properties.php");
    exit();
}