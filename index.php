s<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Real Estate | Karibu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #000;
            color: #fff;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            width: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .hero p {
            font-size: 1.2rem;
            font-weight: 300;
            margin-bottom: 30px;
            color: #ddd;
        }

        /* Buttons Style */
        .btn-container {
            display: flex;
            gap: 20px;
        }

        .btn {
            padding: 15px 40px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.4s ease;
            text-transform: uppercase;
        }

        .btn-login {
            background: #1e3c72;
            color: #fff;
            border: 2px solid #1e3c72;
        }

        .btn-login:hover {
            background: transparent;
            border-color: #fff;
        }

        .btn-register {
            background: #fff;
            color: #000;
            border: 2px solid #fff;
        }

        .btn-register:hover {
            background: transparent;
            color: #fff;
        }

        /* Responsive kwa simu */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .btn-container { flex-direction: column; width: 100%; align-items: center; }
            .btn { width: 80%; text-align: center; }
        }
    </style>
</head>
<body>

    <section class="hero">
        <h1>Elite Real Estate</h1>
        <p>Uwekezaji wa Uhakika. Maisha ya Ndoto Yako.</p>
        
        <div class="btn-container">
            <a href="login.php" class="btn btn-login">Login</a>
            <a href="register.php" class="btn btn-register">Register</a>
        </div>
    </section>

</body>
</html>