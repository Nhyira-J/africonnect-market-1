<?php
session_start();
if(!isset($_SESSION['temp_user_id'])){
    header("Location: register.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | AfriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .otp-container { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; }
        h2 { margin-bottom: 10px; color: #1a1a1a; }
        p { color: #666; margin-bottom: 30px; font-size: 14px; }
        .form-control { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; margin-bottom: 20px; font-size: 18px; text-align: center; letter-spacing: 4px; }
        .btn { background: #8B4513; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 16px; cursor: pointer; width: 100%; font-weight: 600; }
        .btn:hover { background: #6d360f; }
        .error { color: #d32f2f; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="otp-container">
        <h2>Verify Your Email</h2>
        <p>We sent a 6-digit code to <strong><?php echo htmlspecialchars($_SESSION['temp_email']); ?></strong></p>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="error">Invalid or expired OTP. Please try again.</div>
        <?php endif; ?>

        <form action="../actions/otp_process.php" method="POST">
            <input type="text" name="otp" class="form-control" placeholder="000000" maxlength="6" required>
            <button type="submit" name="verify_otp" class="btn">Verify</button>
        </form>
    </div>
</body>
</html>
