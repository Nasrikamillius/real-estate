<?php
/**
 * ELITE REAL ESTATE MANAGEMENT SYSTEM 
 * Purpose: Smart Login Process with Role Recognition
 */

session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        // 1. Tafuta mtumiaji kwa email yake
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // 2. Linganisha password
        if ($user && password_verify($password, $user['password_hash'])) {
         $_SESSION['full_name']   =
         $user['full_name']; //
            // 3. Login imefanikiwa! Tunahifadhi siri zake kwenye Session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role'] = strtolower($user['role']); // Tunahakikisha ni herufi ndogo

            // 4. SMART REDIRECT: Mpeleke mahali sahihi kulingana na cheo chake
            if ($_SESSION['role'] === 'admin') {
                // Kama ni Admin, mpeleke kwenye ofisi yake kuu
                header("Location: dashboard.php");
            } else {
                // Kama ni Mpangaji/Mteja, mpeleke kwenye dashboard ya wapangaji
                header("Location: tenant_home.php");
            }
            exit();

        } else {
            // Kama password au email imekosewa
            echo "<script>alert('Barua pepe au nenosiri siyo sahihi!'); window.location.href='login.php';</script>";
        }

    } catch (PDOException $e) {
        error_log($e->getMessage());
        die("Kuna tatizo la kiufundi. Jaribu tena baadae.");
    }
} else {
    header("Location: login.php");
}
?>