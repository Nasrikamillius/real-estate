<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Elite Estates | Pakia Mali</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #3b82f6; --dark: #0f172a; --bg: #f8fafc; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); display: flex; justify-content: center; padding: 40px; }
        .form-card { background: white; width: 100%; max-width: 800px; padding: 40px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 700; color: #475569; }
        input, select, textarea { width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; }
        .btn-submit { background: var(--primary); color: white; border: none; padding: 18px; border-radius: 15px; width: 100%; font-weight: 800; cursor: pointer; font-size: 1.1rem; }
    </style>
</head>
<body>
    <div class="form-card">
        <h1>Weka Mali Sokoni</h1>
        <p style="color: #64748b; margin-bottom: 25px;">Kumbuka: Mali yako itahakikiwa na Admin kabla ya kuonekana sokoni.</p>

        <form action="property_process.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Jina la Mali</label>
                <input type="text" name="title" required placeholder="Mf: Nyumba ya Kisasa">
            </div>

            <div class="grid">
                <div class="form-group">
                    <label>Aina ya Mali</label>
                    <select name="type" required>
                        <option value="Nyumba">Nyumba (House)</option>
                        <option value="Kiwanja">Kiwanja (Plot)</option>
                        <option value="Fremu ya Biashara">Fremu ya Biashara</option>
                        <option value="Apartment">Apartment</option>
                        <option value="Ofisi">Ofisi</option>
                        <option value="Land">Land</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Eneo (Location)</label>
                    <input type="text" name="location" required>
                </div>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label>Bei (TZS)</label>
                    <input type="number" name="price" required>
                </div>
                <div class="form-group">
                    <label>Idadi ya Vyumba</label>
                    <input type="number" name="rooms" value="0">
                </div>
            </div>

            <div class="form-group">
                <label>Maelezo ya Ziada</label>
                <textarea name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label>Picha ya Mali</label>
                <input type="file" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn-submit">Tuma kwa Admin Ikaguliwe</button>
        </form>
    </div>
</body>
</html>