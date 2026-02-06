<?php
session_start();

// Futa data zote za session
$_SESSION = array();

// Kama kuna session cookie, ifute pia
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Haribu session kabisa
session_destroy();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Premium | Kuaga</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --accent-blue: #38bdf8;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--sidebar-bg);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: white;
        }

        .logout-box {
            text-align: center;
            animation: fadeIn 1.2s ease-out;
        }

        .icon-circle {
            width: 100px;
            height: 100px;
            background: rgba(56, 189, 248, 0.1);
            border: 2px solid var(--accent-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 2.5rem;
            color: var(--accent-blue);
            box-shadow: 0 0 30px rgba(56, 189, 248, 0.3);
            animation: pulse 2s infinite;
        }

        h1 { font-weight: 800; font-size: 2rem; margin-bottom: 10px; }
        p { color: #94a3b8; font-weight: 500; margin-bottom: 30px; }

        .loader {
            width: 50px;
            height: 5px;
            background: rgba(255,255,255,0.1);
            margin: 0 auto;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .loader::after {
            content: '';
            position: absolute;
            left: -50%;
            width: 100%;
            height: 100%;
            background: var(--accent-blue);
            animation: loading 2s linear forwards;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
        @keyframes loading { 0% { left: -100%; } 100% { left: 100%; } }
    </style>
    <script>
        // Rudisha mteja kwenye login page baada ya sekunde 3
        setTimeout(function() {
            window.location.href = "login.php";
        }, 3000);
    </script>
</head>
<body>

    <div class="logout-box">
        <div class="icon-circle">
            <i class="fas fa-power-off"></i>
        </div>
        <h1>Umetoka kwa Usalama!</h1>
        <p>Tunakusafishia njia, subiri kidogo...</p>
        <div class="loader"></div>
    </div>

</body>
</html>