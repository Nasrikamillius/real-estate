<?php 
include 'db_connect.php'; 
session_start();

// Hapa unaweza kuweka logic ya ku-update password au jina la kampuni baadae
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Mipangilio | Smart Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --accent: #38bdf8; --sidebar-bg: #0f172a; }
        body { 
            background: url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover; font-family: 'Inter', sans-serif;
        }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(241, 245, 249, 0.95); z-index: -1; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); position: fixed; color: white; padding: 30px 15px; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 800; color: var(--accent); margin-bottom: 40px; text-align: center; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 12px; margin-bottom: 8px; display: flex; align-items: center; text-decoration: none; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(56, 189, 248, 0.1); color: var(--accent); border-right: 4px solid var(--accent); }
        
        .main-content { margin-left: 280px; padding: 40px; }
        .settings-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px); border-radius: 30px; padding: 40px; border: 1px solid rgba(255,255,255,0.4); }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; }
        .save-btn { background: var(--accent); color: var(--sidebar-bg); font-weight: 700; border: none; border-radius: 12px; padding: 12px 30px; }
    </style>
</head>
<body>
<div class="overlay"></div>

<div class="sidebar">
    <div class="sidebar-brand">SMART ESTATE</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-grid-2 me-2"></i> Dashboard</a>
        <a class="nav-link" href="admin_add_property.php"><i class="fas fa-plus-circle me-2"></i> Ongeza Mali</a>
        <a class="nav-link" href="admin_manage_properties.php"><i class="fas fa-home me-2"></i> Simamia Mali</a>
        <a class="nav-link" href="admin_approve_bookings.php"><i class="fas fa-file-invoice-dollar me-2"></i> Maombi & Malipo</a>
        <a class="nav-link" href="admin_tenants.php"><i class="fas fa-users-crown me-2"></i> Wapangaji</a>
        <a class="nav-link" href="admin_payments.php"><i class="fas fa-wallet me-2"></i> Ripoti ya Fedha</a>
        <a class="nav-link" href="admin_maintenance.php"><i class="fas fa-tools me-2"></i> Matengenezo</a>
        <a class="nav-link" href="admin_messages.php"><i class="fas fa-comment-alt-lines me-2"></i> Ujumbe</a>
        <a class="nav-link active" href="admin_settings.php"><i class="fas fa-sliders-h me-2"></i> Mipangilio</a>
    </nav>
</div>

<div class="main-content">
    <h2 class="fw-bold mb-4">Mipangilio ya Mfumo ⚙️</h2>
    
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="settings-card shadow-sm">
                <h5 class="fw-bold mb-4">Taarifa za Biashara</h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label small">Jina la Kampuni</label>
                        <input type="text" class="form-control" value="Smart Estate Limited">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Email ya Mawasiliano</label>
                        <input type="email" class="form-control" value="admin@smartestate.co.tz">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Namba ya Simu (WhatsApp)</label>
                        <input type="text" class="form-control" value="+255 700 000 000">
                    </div>
                    <button type="submit" class="save-btn">Hifadhi Mabadiliko</button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="settings-card shadow-sm border-top border-info border-5">
                <h5 class="fw-bold mb-4 text-primary">Badilisha Nywila (Password)</h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label small">Password ya Sasa</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password Mpya</label>
                        <input type="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-outline-dark w-100 rounded-pill">Update Password</button>
                </form>
            </div>
            
            <div class="mt-4 p-4 rounded-4 bg-danger bg-opacity-10 border border-danger border-opacity-25">
                <h6 class="fw-bold text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Danger Zone</h6>
                <p class="small text-muted mb-0">Ukifuta akaunti yako, data zote za wateja na mali zitapotea moja kwa moja.</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>