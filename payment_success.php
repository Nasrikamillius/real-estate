<?php
// Hii ni kodi ya PHP, lazima file liishe na .php
session_start();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malipo Yamefanikiwa | Smart Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f1f5f9; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: sans-serif; }
        .success-card { background: white; padding: 40px; border-radius: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); text-align: center; max-width: 450px; border: none; }
        .icon-circle { width: 80px; height: 80px; background: #22c55e; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px; }
        .btn-home { background: #0f172a; color: white; border-radius: 12px; padding: 12px 25px; text-decoration: none; font-weight: bold; display: inline-block; transition: 0.3s; }
        .btn-home:hover { background: #334155; color: white; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="success-card">
    <div class="icon-circle shadow-sm">
        <i class="fas fa-check"></i>
    </div>
    <h2 class="fw-bold text-dark">Malipo Yamepokelewa!</h2>
    <p class="text-muted fs-5">Ombi lako la kupanga limefika kwa Admin. Tafadhali subiri uhakiki ufanyike kwenye Dashboard yako.</p>
    
    <div class="alert alert-info border-0 rounded-3 small">
        <i class="fas fa-info-circle me-1"></i> Utapokea ujumbe wa uthibitisho hivi punde.
    </div>

    <a href="index.php" class="btn-home mt-3 shadow-sm">Rudi Nyumbani</a>
</div>

</body>
</html>