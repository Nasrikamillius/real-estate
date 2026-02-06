<?php

// Maelezo ya Server yako
$host    = 'localhost';
$db_name = 'real_estate_db';
$user    = 'root';
$pass    = ''; // Weka nenosiri lako hapa kama lipo
$charset = 'utf8mb4';

// Muundo wa DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Inatupa ripoti kukiwa na tatizo
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Inaleta data kwa njia ya mpangilio (Arrays)
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Inazuia SQL Injection kwa nguvu zaidi
];

try {
    // Kutengeneza muunganisho
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Ukitaka kuhakikisha muunganisho upo, ondoa "//" hapa chini wakati wa kutezi
    // echo "Hongera! Muunganisho wa Database umefanikiwa."; 

} catch (PDOException $e) {
    // Badala ya kuonyesha kosa la kiufundi kwa mteja, tunarekodi na kutoa ujumbe mfupi
    error_log($e->getMessage());
    die("Samahani, mfumo umeshindwa kuunganishwa na hifadhidata kwa sasa.");
}
?>