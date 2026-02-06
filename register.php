<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Real Estate | Jisajili</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center; height: 100vh;
            display: flex; justify-content: center; align-items: center;
        }
        .back-home {
            position: absolute; top: 20px; left: 20px; color: white; text-decoration: none;
            background: rgba(255,255,255,0.1); padding: 10px 20px; border-radius: 30px;
            backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: 0.3s;
        }
        .glass-container {
            background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px);
            border-radius: 25px; border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px; width: 420px; text-align: center; color: #fff;
        }
        .form-group { margin-bottom: 20px; }
        .form-group input {
            width: 100%; padding: 14px; background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 12px; color: #fff; outline: none;
        }
        .btn-register {
            width: 100%; padding: 15px; background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none; border-radius: 12px; color: #fff; font-weight: 600; cursor: pointer; transition: 0.4s;
        }
        .footer-links a { color: #fff; text-decoration: none; font-weight: 600; border-bottom: 1px solid #fff; }
    </style>
</head>
<body>
    <a href="index.php" class="back-home">← Rudi Mwanzo</a>
    <div class="glass-container">
        <h2 style="margin-bottom: 30px;">Tengeneza Akaunti</h2>
        <form action="register_process.php" method="POST">
            <div class="form-group"><input type="text" name="full_name" placeholder="Jina Kamili" required></div>
            <div class="form-group"><input type="email" name="email" placeholder="Barua Pepe" required></div>
            <div class="form-group"><input type="password" name="password" placeholder="Nenosiri" required></div>
            <button type="submit" class="btn-register">Jisajili Sasa</button>
        </form>
        <div class="footer-links" style="margin-top: 25px;">Tayari una akaunti? <a href="login.php">Ingia Hapa</a></div>
    </div>
</body>
</html>