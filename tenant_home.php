<?php
session_start();
require 'db_connect.php';

// Ulinzi: Hakikisha aliyelogin ni Mteja (Tenant)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tenant') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];
$first_name = explode(' ', $full_name)[0];
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karibu Elite Estates | <?php echo $first_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #fbbf24;
            --secondary: #3b82f6;
            --glass: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body, html { height: 100%; width: 100%; overflow: hidden; }

        /* --- BACKGROUND KALI YA KIFAHARI --- */
        .hero-wrapper {
            position: relative;
            height: 100vh;
            width: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2075&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* --- GLASS CONTAINER --- */
        .glass-box {
            background: var(--glass);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 60px;
            border-radius: 40px;
            text-align: center;
            max-width: 800px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .welcome-badge {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid var(--secondary);
            color: #60a5fa;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            color: white;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        h1 span {
            color: var(--gold);
            font-style: italic;
        }

        p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.25rem;
            margin-bottom: 45px;
            font-weight: 300;
        }

        /* --- BUTTONS --- */
        .btn-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-glow {
            padding: 20px 45px;
            border-radius: 20px;
            font-weight: 800;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.4s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .primary {
            background: white;
            color: #0f172a;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }

        .primary:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 30px rgba(255, 255, 255, 0.4);
        }

        .secondary-btn {
            background: var(--secondary);
            color: white;
            border: none;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .secondary-btn:hover {
            background: #2563eb;
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4);
        }

        .top-nav {
            position: absolute;
            top: 30px;
            right: 5%;
            z-index: 100;
        }
        .logout-btn {
            color: white;
            text-decoration: none;
            font-weight: 600;
            background: rgba(239, 68, 68, 0.2);
            padding: 10px 20px;
            border-radius: 12px;
            border: 1px solid rgba(239, 68, 68, 0.4);
            transition: 0.3s;
        }
        .logout-btn:hover { background: #ef4444; border-color: #ef4444; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px) scale(0.9); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @media (max-width: 768px) {
            h1 { font-size: 2.8rem; }
            .glass-box { padding: 40px 20px; }
        }
    </style>
</head>
<body>

    <div class="top-nav">
        <a href="logout.php" class="logout-btn"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <section class="hero-wrapper">
        <div class="glass-box">
            <div class="welcome-badge">Mteja wa Thamani</div>
            <h1>Karibu Nyumbani, <br> <span><?php echo $first_name; ?>.</span></h1>
            <p>Umefika mahali ambapo urahisi na anasa hukutana. Kila kitu unachohitaji kuhusu makazi yako kimeandaliwa kwa ubora wa hali ya juu.</p>
            
            <div class="btn-group">
                <a href="tenant_dashboard.php" class="btn-glow primary">
                    Fungua Dashboard <i class="fas fa-arrow-right"></i>
                </a>
                
                <a href="search_properties.php" class="btn-glow secondary-btn">
                    Tafuta Nyumba Mpya <i class="fas fa-search"></i>
                </a>
            </div>
        </div>
    </section>

</body>
</html>