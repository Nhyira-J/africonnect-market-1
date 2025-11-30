<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful | AfriConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f8f9fa; color: #271a1a; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 20px; }
        .success-card { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 500px; width: 100%; }
        .icon { font-size: 64px; color: #4caf50; margin-bottom: 20px; }
        .title { font-family: 'Domine', serif; font-size: 28px; font-weight: 700; margin-bottom: 10px; }
        .message { color: #666; margin-bottom: 30px; line-height: 1.5; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #aa4242; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: background 0.3s ease; }
        .btn:hover { background-color: #8a3535; }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="icon">✓</div>
        <h1 class="title">Payment Successful!</h1>
        <p class="message">Thank you for your purchase. Your order has been placed successfully and is being processed.</p>
        <?php if(isset($_GET['invoice_no'])): ?>
            <div style="background: #f0f0f0; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <p style="margin: 0; font-size: 14px; color: #666;">Your Order ID:</p>
                <p style="margin: 5px 0 0; font-size: 24px; font-weight: 700; color: #271a1a; letter-spacing: 1px;"><?php echo htmlspecialchars($_GET['invoice_no']); ?></p>
                <p style="margin: 5px 0 0; font-size: 12px; color: #888;">Please save this ID to track your order.</p>
            </div>
        <?php endif; ?>



        <div style="display: flex; gap: 10px; justify-content: center;">
            <a href="track.php" class="btn">Track Order</a>
            <a href="shop.php" class="btn" style="background-color: #333;">Continue Shopping</a>
        </div>
    </div>
    <style>
        /* CSS removed */
    </style>
</body>
</html>
