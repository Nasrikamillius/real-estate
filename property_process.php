<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kamata data zote kama zilivyo kwenye fomu yako
    $title       = $_POST['title'] ?? 'Bila Jina';
    $type        = $_POST['type'] ?? 'Nyumba'; 
    $location    = $_POST['location'] ?? '';
    $price       = $_POST['price'] ?? 0;
    $rooms       = $_POST['rooms'] ?? 0;
    $description = $_POST['description'] ?? '';
    $user_id     = $_SESSION['user_id'];
    $user_role   = $_SESSION['role'] ?? 'tenant';

    // Mfumo wa Admin Approval (Pending kwa mteja)
    $status = ($user_role === 'admin') ? 'Approved' : 'Pending';

    // Shughulikia Picha
    $image_name = 'default.jpg';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image_name);
    }

    try {
        // Tunahifadhi kwenye 'type' na 'property_type' ili kutosheleza dashboard yako
        $sql = "INSERT INTO properties (title, type, property_type, location, price, rooms, description, image, owner_id, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $type, $type, $location, $price, $rooms, $description, $image_name, $user_id, $status]);

        $redirect = ($user_role === 'admin') ? 'dashboard.php' : 'tenant_dashboard.php';
        echo "<script>alert('Mali imehifadhiwa!'); window.location.href='$redirect';</script>";
    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
}
