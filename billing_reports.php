<?php
session_start();
require 'db_connect.php';

// Kuchukua jumla ya mapato (Mfano wa kodi)
$total_revenue = $pdo->query("SELECT SUM(price) FROM properties WHERE status = 'Sold' OR status = 'Active'")->fetchColumn();
$pending_payments = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Pending'")->fetchColumn();

// Vuta list ya miamala ya karibuni
$transactions = $pdo->query("SELECT b.*, u.full_name, p.price, p.title 
                            FROM bookings b 
                            JOIN users u ON b.client_id = u.user_id 
                            JOIN properties p ON b.property_id = p.property_id 
                            ORDER BY b.booking_id DESC LIMIT 10");
$list = $transactions->fetchAll();
?>

<main class="main">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>Ripoti za Fedha</h1>
        <button onclick="window.print()" style="padding: 10px 20px; border-radius: 10px; background: #0f172a; color: white; cursor: pointer;">
            <i class="fas fa-download"></i> Pakua Ripoti
        </button>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: linear-gradient(135deg, #0ea5e9, #2563eb); padding: 30px; border-radius: 20px; color: white;">
            <h3 style="font-size: 0.9rem; opacity: 0.8;">JUMLA YA MAPATO</h3>
            <p style="font-size: 2.5rem; font-weight: 800;"><?php echo number_format($total_revenue); ?> TZS</p>
        </div>
        <div style="background: white; padding: 30px; border-radius: 20px; border: 1px solid #e2e8f0;">
            <h3 style="font-size: 0.9rem; color: #64748b;">INVOICE ZINAZOSUBIRI</h3>
            <p style="font-size: 2.5rem; font-weight: 800; color: #0f172a;"><?php echo $pending_payments; ?></p>
        </div>
    </div>

    <div class="tenant-card">
        <h3>Miamala ya Karibuni</h3>
        <table>
            <thead>
                <tr>
                    <th>Mteja</th>
                    <th>Bidhaa/Nyumba</th>
                    <th>Kiasi</th>
                    <th>Hali</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list as $l): ?>
                <tr>
                    <td><?php echo $l['full_name']; ?></td>
                    <td><?php echo $l['title']; ?></td>
                    <td><strong><?php echo number_format($l['price']); ?> TZS</strong></td>
                    <td><span style="color: #16a34a; font-weight: 700;">● Paid</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>