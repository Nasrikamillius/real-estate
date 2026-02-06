<?php
/**
 * ELITE REAL ESTATE MANAGEMENT SYSTEM 
 * Purpose: Processing User Registration
 */

session_start();
require 'db_connect.php'; // Inaita daraja letu la database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Pokea na usafishe data
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email     = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password  = $_POST['password'];

    // 2. Hash Password - Huu ndio ulinzi namba moja
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // 3. Hakikisha Email haijatumika na mtu mwingine
        $check = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            echo "<script>alert('Samahani, hii Email imeshachukuliwa!'); window.history.back();</script>";
            exit();
        }

        // 4. Ingiza data kwenye Table yetu ya 'users'
        // Tunampa Role ya 'Tenant' (Mteja) kwa kuanzia
        $sql = "INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, 'Tenant')";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$full_name, $email, $password_hash])) {
            // Success! Mpe ujumbe wa ushindi
            echo "<script>
                    alert('Hongera sana! Akaunti yako imekamilika.');
                    window.location.href = 'login.php';
                  </script>";
        }

    } catch (PDOException $e) {
        // Ikitokea hitilafu ya database
        error_log($e->getMessage());
        die("Kuna tatizo limetokea kwenye mfumo. Jaribu tena.");
    }
} else {
    header("Location: register.php");
    exit();
}
?>