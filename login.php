<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Real Estate | Ingia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1613490493576-7fde63acd811?q=80&w=2071&auto=format&fit=crop');
            background-size: cover; background-position: center; height: 100vh;
            display: flex; justify-content: center; align-items: center; position: relative;
        }
        .back-home {
            position: absolute; top: 20px; left: 20px; color: white; text-decoration: none;
            background: rgba(255,255,255,0.1); padding: 10px 20px; border-radius: 30px;
            backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: 0.3s;
        }
        .back-home:hover { background: rgba(255,255,255,0.3); }
        .glass-box {
            background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px; padding: 50px 40px; width: 400px; text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4); color: #fff;
        }
        .input-group { margin-bottom: 20px; text-align: left; }
        .input-group input {
            width: 100%; padding: 14px 20px; background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 15px; color: #fff; outline: none;
        }
        .btn-login {
            width: 100%; padding: 15px; background: #fff; color: #1e3c72;
            border: none; border-radius: 15px; font-weight: 600; cursor: pointer; transition: 0.4s;
        }
        .btn-login:hover { background: #1e3c72; color: #fff; transform: translateY(-3px); }
        .footer-text a { color: #fff; font-weight: 600; text-decoration: none; border-bottom: 1px solid #fff; }
    </style>
</head>
<body>
    <a href="index.php" class="back-home">← Rudi Mwanzo</a>
    <div class="glass-box">
        <h2>Karibu Tena</h2>
        <p style="margin-bottom: 30px; color: #ddd;">Ingia kuendelea na Elite Real Estate</p>
        <form action="login_process.php" method="POST">
            <div class="input-group"><input type="email" name="email" placeholder="Barua Pepe" required></div>
            <div class="input-group"><input type="password" name="password" placeholder="Nenosiri" required></div>
            <button type="submit" class="btn-login">Ingia Sasa</button>
        </form>
        <p class="footer-text" style="margin-top: 25px;">Hauna akaunti? <a href="register.php">Jisajili Bure</a></p>
    </div>
</body>
</html>