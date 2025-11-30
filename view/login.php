<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | AfriConnect</title>
  <!-- <link rel="stylesheet" href="../css/main.css"> -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Outfit', sans-serif;
      min-height: 100vh;
      background: #f8f9fa;
    }

    .auth-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      min-height: 100vh;
      position: relative;
      overflow: hidden;
    }

    /* Image Side - Enhanced */
    .auth-image-side {
      position: relative;
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px;
    }

    .auth-image-side::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(139, 69, 19, 0.92) 0%, rgba(101, 67, 33, 0.88) 100%);
      backdrop-filter: blur(2px);
    }

    .auth-content-overlay {
      position: relative;
      z-index: 2;
      color: white;
      max-width: 500px;
      text-align: center;
      animation: fadeInUp 0.8s ease-out;
    }

    .auth-quote {
      font-family: 'Domine', serif;
      font-size: 32px;
      font-weight: 600;
      line-height: 1.4;
      margin-bottom: 24px;
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .auth-content-overlay p {
      font-size: 18px;
      opacity: 0.95;
      font-weight: 300;
      letter-spacing: 0.3px;
    }

    /* Form Side - Modernized */
    .auth-form-side {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 80px;
      background: white;
      position: relative;
      animation: fadeIn 0.6s ease-out;
    }

    /* Decorative Elements */
    .auth-form-side::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(180deg, #8B4513 0%, #D2691E 100%);
    }

    .auth-header {
      margin-bottom: 48px;
    }

    .auth-logo {
      font-family: 'Domine', serif;
      font-size: 28px;
      font-weight: 700;
      color: #8B4513;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 32px;
      position: relative;
      transition: transform 0.3s ease;
    }

    .auth-logo::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 40px;
      height: 3px;
      background: #D2691E;
      border-radius: 2px;
    }

    .auth-logo:hover {
      transform: translateX(4px);
    }

    .auth-title {
      font-family: 'Domine', serif;
      font-size: 36px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 12px;
      letter-spacing: -0.5px;
    }

    .auth-subtitle {
      font-size: 16px;
      color: #666;
      font-weight: 400;
    }

    /* Form Elements - Enhanced */
    .form-group {
      margin-bottom: 28px;
    }

    .form-label {
      display: block;
      font-size: 14px;
      font-weight: 500;
      color: #333;
      margin-bottom: 10px;
      letter-spacing: 0.2px;
    }

    .form-control {
      width: 100%;
      padding: 14px 18px;
      font-size: 15px;
      font-family: 'Outfit', sans-serif;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      transition: all 0.3s ease;
      background: #fafafa;
      color: #1a1a1a;
    }

    .form-control:focus {
      outline: none;
      border-color: #8B4513;
      background: white;
      box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.08);
      transform: translateY(-1px);
    }

    .form-control::placeholder {
      color: #999;
      font-weight: 300;
    }

    /* Button - Premium Style */
    .btn {
      width: 100%;
      padding: 16px 32px;
      font-size: 16px;
      font-weight: 600;
      color: white;
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: 'Outfit', sans-serif;
      letter-spacing: 0.5px;
      margin-top: 12px;
      box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2);
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.1) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3);
    }

    .btn:hover::before {
      opacity: 1;
    }

    .btn:active {
      transform: translateY(0);
    }

    /* Alert Messages - Refined */
    .alert {
      margin-top: 24px;
      padding: 14px 18px;
      border-radius: 10px;
      font-size: 14px;
      text-align: center;
      font-weight: 500;
      animation: slideDown 0.4s ease-out;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .alert-error {
      color: #c62828;
      background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
      border: 1px solid #ef9a9a;
    }

    .alert-success {
      color: #2e7d32;
      background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
      border: 1px solid #a5d6a7;
    }

    .alert::before {
      content: '⚠';
      font-size: 18px;
    }

    .alert-success::before {
      content: '✓';
    }

    /* Footer - Enhanced */
    .auth-footer {
      margin-top: 40px;
      text-align: center;
      font-size: 15px;
      color: #666;
      padding-top: 32px;
      border-top: 1px solid #e8e8e8;
    }

    .auth-footer a {
      color: #8B4513;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      position: relative;
    }

    .auth-footer a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: #8B4513;
      transition: width 0.3s ease;
    }

    .auth-footer a:hover::after {
      width: 100%;
    }

    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive Design */
    @media (max-width: 968px) {
      .auth-container {
        grid-template-columns: 1fr;
      }

      .auth-image-side {
        display: none;
      }

      .auth-form-side {
        padding: 40px 32px;
      }

      .auth-title {
        font-size: 30px;
      }
    }

    @media (max-width: 480px) {
      .auth-form-side {
        padding: 32px 24px;
      }

      .auth-title {
        font-size: 26px;
      }

      .auth-quote {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <!-- Image Side -->
    <div class="auth-image-side" style="background-image: url('../images/img_an_artisan_meticulously.png');">
      <div class="auth-content-overlay">
        <div class="auth-quote">"Connecting African artisans to the world, one masterpiece at a time."</div>
        <p>Join our community of creators and connoisseurs.</p>
      </div>
    </div>

    <!-- Form Side -->
    <div class="auth-form-side">
      <div class="auth-header">
        <a href="../index.php" class="auth-logo">AfriConnect</a>
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-subtitle">Please enter your details to sign in.</p>
      </div>

      <form action="../actions/login_process.php" method="POST">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" required placeholder="Enter your email">
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required placeholder="Enter your password">
        </div>

        <button type="submit" name="login" class="btn">Sign In</button>
        
        <?php if(isset($_GET['error'])) { ?>
          <div class="alert alert-error">
              <?php 
                  if($_GET['error'] == 'invalid_credentials') echo "Invalid email or password.";
                  elseif($_GET['error'] == 'empty_fields') echo "Please fill in all fields.";
              ?>
          </div>
        <?php } ?>
        
        <?php if(isset($_GET['success'])) { ?>
          <div class="alert alert-success">
              <?php if($_GET['success'] == 'registered') echo "Registration successful! Please login."; ?>
          </div>
        <?php } ?>
      </form>
      
      <div class="auth-footer">
        Don't have an account? <a href="register.php">Create an account</a>
      </div>
    </div>
  </div>
</body>
</html>