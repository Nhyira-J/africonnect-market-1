<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sell With Us | AfriConnect</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    /* Reset and base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Outfit', Arial, sans-serif;
      background-color: #fdfbfb;
      color: #271a1a;
      line-height: 1.6;
    }
    
    img {
      max-width: 100%;
      height: auto;
    }
    
    button {
      cursor: pointer;
      border: none;
      background: none;
      font-family: inherit;
    }
    
    /* Layout components */
    .container {
      width: 100%;
      max-width: 1344px;
      margin: 0 auto;
      padding-left: 16px;
      padding-right: 16px;
    }
    
    /* Header styles */
    .header-container {
      background-color: #fdfbfb;
      width: 100%;
    }
    
    .promo-banner {
      background-color: #aa4242;
      padding: 8px;
      text-align: center;
    }
    
    .promo-text {
      font-size: 14px;
      font-family: 'Inter', Arial, sans-serif;
      font-weight: 600;
      color: #ffffff;
    }
    
    .main-header {
      padding: 14px 0;
    }
    
    .header-content {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }
    
    .logo {
      font-size: 24px;
      font-family: 'Crimson Pro', serif;
      font-weight: 300;
      line-height: 36px;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #271a1a;
      margin-top: 42px;
    }
    
    .nav-menu {
      display: none;
      gap: 40px;
      align-items: center;
      margin-bottom: 10px;
    }
    
    .nav-item {
      display: flex;
      gap: 6px;
      align-items: center;
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 500;
      color: #271a1a;
      text-decoration: none;
      cursor: pointer;
    }
    
    .nav-item:hover {
      color: #aa4242;
    }
    
    .nav-arrow {
      width: 16px;
      height: 16px;
    }
    
    .header-icons {
      display: flex;
      gap: 24px;
      align-items: center;
      margin-bottom: 8px;
    }
    
    .header-icon {
      width: 24px;
      height: 24px;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    
    .header-icon:hover {
      transform: scale(1.1);
    }
    
    .hamburger {
      display: block;
      width: 24px;
      height: 24px;
      cursor: pointer;
    }

    /* Footer */
    .footer {
      border-top: 1px solid #aa4242;
      padding: 52px 16px;
      background-color: #fdfbfb;
    }
    
    .footer-content {
      display: flex;
      flex-direction: column;
      gap: 40px;
    }
    
    .footer-main {
      display: flex;
      flex-direction: column;
      gap: 32px;
    }
    
    .footer-brand {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    
    .footer-logo {
      font-size: 24px;
      font-family: 'Crimson Pro', serif;
      font-weight: 300;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #271a1a;
    }
    
    .social-icons {
      display: flex;
      gap: 14px;
    }
    
    .social-icon {
      width: 24px;
      height: 24px;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    
    .social-icon:hover {
      transform: scale(1.2);
    }
    
    .footer-links {
      display: flex;
      flex-direction: column;
      gap: 32px;
    }
    
    .footer-column {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    
    .footer-column-title {
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 500;
      color: #271a1a;
      margin-bottom: 10px;
    }
    
    .footer-link {
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 500;
      color: #2e13139e;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    
    .footer-link:hover {
      color: #aa4242;
    }
    
    .newsletter {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    
    .newsletter-title {
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 600;
      color: #271a1a;
    }
    
    .newsletter-description {
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 400;
      color: #271a1a;
    }
    
    .newsletter-form {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    .newsletter-input {
      padding: 12px;
      border: 1px solid #0000000a;
      border-radius: 8px;
      background-color: #752d2d14;
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      color: #2e131366;
    }
    
    .newsletter-btn {
      padding: 10px 20px;
      border: 1px solid #6e494933;
      border-radius: 8px;
      background-color: transparent;
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 500;
      color: #271a1a;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .newsletter-btn:hover {
      background-color: #aa4242;
      color: #ffffff;
      border-color: #aa4242;
    }

    /* Responsive media queries */
    @media (min-width: 640px) {
      .container {
        padding-left: 24px;
        padding-right: 24px;
      }
      .promo-text {
        font-size: 16px;
      }
      .logo {
        font-size: 28px;
      }
      .newsletter-form {
        flex-direction: row;
      }
      .newsletter-input {
        flex: 1;
      }
    }
    
    @media (min-width: 768px) {
      .footer-main {
        flex-direction: row;
        justify-content: space-between;
      }
      .footer-links {
        flex-direction: row;
        gap: 60px;
      }
    }
    
    @media (min-width: 1024px) {
      .container {
        padding-left: 32px;
        padding-right: 32px;
      }
      .hamburger {
        display: none;
      }
      .nav-menu {
        display: flex;
      }
      .logo {
        font-size: 32px;
      }
      .footer-content {
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
      }
      .footer-main {
        flex: 1;
      }
      .newsletter {
        width: 400px;
      }
    }

    /* Sell Page Specific Styles */
    .sell-hero {
        background: linear-gradient(rgba(39, 26, 26, 0.7), rgba(39, 26, 26, 0.7)), url('../images/img_an_artisan_meticulously.png');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 120px 20px;
        text-align: center;
        margin-bottom: 60px;
    }

    .sell-hero-title {
        font-family: 'Domine', serif;
        font-size: 56px;
        margin-bottom: 20px;
        color: white;
    }

    .sell-hero-subtitle {
        font-size: 20px;
        max-width: 700px;
        margin: 0 auto 40px;
        opacity: 0.9;
    }

    .btn-primary {
        display: inline-block;
        padding: 16px 40px;
        background-color: #aa4242;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 18px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .btn-primary:hover {
        background-color: #8a3535;
        transform: translateY(-2px);
    }

    .benefits-section {
        padding: 60px 20px;
        background-color: white;
        margin-bottom: 60px;
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .benefit-card {
        text-align: center;
        padding: 30px;
        border-radius: 12px;
        background: #fdfbfb;
        transition: transform 0.3s ease;
    }

    .benefit-card:hover {
        transform: translateY(-5px);
    }

    .benefit-icon {
        width: 60px;
        height: 60px;
        background: #fcecec;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .benefit-icon img {
        width: 30px;
        height: 30px;
    }

    .benefit-title {
        font-family: 'Domine', serif;
        font-size: 24px;
        margin-bottom: 15px;
        color: #271a1a;
    }

    .benefit-desc {
        color: #666;
        line-height: 1.6;
    }

    .cta-section {
        background-color: #271a1a;
        color: white;
        padding: 80px 20px;
        text-align: center;
    }

    .cta-title {
        font-family: 'Domine', serif;
        font-size: 40px;
        margin-bottom: 20px;
        color: white;
    }

    .cta-desc {
        font-size: 18px;
        margin-bottom: 40px;
        opacity: 0.8;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
  </style>
</head>
<body>
  <header class="header-container">
    <div class="promo-banner">
      <p class="promo-text">Sign up & get 10% Off on your first purchase</p>
    </div>
    
    <div class="main-header">
      <div class="container">
        <div class="header-content">
          <a href="../index.php" style="text-decoration: none;"><h1 class="logo">AfriConnect</h1></a>
          
          <nav class="nav-menu" role="navigation">
            <a href="../index.php" class="nav-item">Home <img src="../images/img_arrow_down.svg" alt="" class="nav-arrow"></a>
            <a href="shop.php" class="nav-item">Shop <img src="../images/img_arrow_down.svg" alt="" class="nav-arrow"></a>
            <a href="sell.php" class="nav-item">Sell With Us <img src="../images/img_arrow_down.svg" alt="" class="nav-arrow"></a>
            <a href="blog.php" class="nav-item">Blog <img src="../images/img_icon.svg" alt="" style="width: 8px; height: 4px;"></a>
            <a href="about.php" class="nav-item">About Us <img src="../images/img_arrow_down.svg" alt="" class="nav-arrow"></a>
          </nav>
          
          <div class="header-icons">
            <button class="hamburger" aria-label="Menu">
              <img src="../images/img_search.svg" alt="Search" class="header-icon">
            </button>
            <a href="#" aria-label="Search"><img src="../images/img_search.svg" alt="Search" class="header-icon"></a>
            <?php if(isset($_SESSION['user_id'])): ?>
              <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 500; color: #271a1a;">Welcome, <span style="color: #aa4242;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span></span>
              </div>
            <?php else: ?>
              <a href="login.php" aria-label="User account"><img src="../images/img_user.svg" alt="User account" class="header-icon"></a>
            <?php endif; ?>
            <a href="cart.php" aria-label="Shopping cart"><img src="../images/img_shopping_bag.svg" alt="Shopping cart" class="header-icon"></a>
            <?php if(isset($_SESSION['user_id'])): ?>
            <a href="../actions/logout.php" style="font-size: 14px; color: #aa4242; text-decoration: underline;">Logout</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="sell-hero">
      <h1 class="sell-hero-title">Share Your Craft with the World</h1>
      <p class="sell-hero-subtitle">Join AfriConnect's community of artisans and showcase your unique handmade creations to a global audience.</p>
      <a href="../artisan/artisan_register.php?role=artisan" class="btn-primary">Start Selling Today</a>
  </div>

  <section class="benefits-section">
      <div class="container">
          <div class="benefits-grid">
              <div class="benefit-card">
                  <div class="benefit-icon">
                      <img src="../images/img_icon.svg" alt="Global Reach">
                  </div>
                  <h3 class="benefit-title">Global Reach</h3>
                  <p class="benefit-desc">Expand your business beyond borders. We connect you with customers from all over the world who appreciate authentic African craftsmanship.</p>
              </div>

              <div class="benefit-card">
                  <div class="benefit-icon">
                      <img src="../images/img_shopping_bag.svg" alt="Fair Prices">
                  </div>
                  <h3 class="benefit-title">Fair Compensation</h3>
                  <p class="benefit-desc">Set your own prices and get paid fairly for your work. We believe in empowering artisans and ensuring sustainable livelihoods.</p>
              </div>

              <div class="benefit-card">
                  <div class="benefit-icon">
                      <img src="../images/img_user.svg" alt="Community">
                  </div>
                  <h3 class="benefit-title">Community Support</h3>
                  <p class="benefit-desc">Join a thriving community of creators. Get access to resources, tips, and support to help you grow your business.</p>
              </div>
          </div>
      </div>
  </section>

  <section class="cta-section">
      <div class="container">
          <h2 class="cta-title">Ready to Grow Your Business?</h2>
          <p class="cta-desc">It takes less than 5 minutes to set up your shop and start selling. Join us today and be part of the movement.</p>
          <a href="../artisan/artisan_register.php?role=artisan" class="btn-primary" style="background-color: white; color: #aa4242;">Register as Artisan</a>
      </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-main">
          <div class="footer-brand">
            <h3 class="footer-logo">AfriCONNECT</h3>
            <div class="social-icons">
              <a href="#"><img src="../images/img_facebook.svg" alt="Facebook" class="social-icon"></a>
              <a href="#"><img src="../images/img_instagram.svg" alt="Instagram" class="social-icon"></a>
              <a href="#"><img src="../images/img_twitter.svg" alt="Twitter" class="social-icon"></a>
            </div>
          </div>
          <div class="footer-links">
            <div class="footer-column">
              <h4 class="footer-column-title">Shop</h4>
              <a href="#" class="footer-link">New Arrivals</a>
              <a href="#" class="footer-link">Best Sellers</a>
              <a href="#" class="footer-link">Categories</a>
            </div>
            <div class="footer-column">
              <h4 class="footer-column-title">Company</h4>
              <a href="#" class="footer-link">About Us</a>
              <a href="#" class="footer-link">Contact</a>
              <a href="#" class="footer-link">Blog</a>
            </div>
            <div class="footer-column">
              <h4 class="footer-column-title">Support</h4>
              <a href="#" class="footer-link">FAQs</a>
              <a href="#" class="footer-link">Shipping</a>
              <a href="#" class="footer-link">Returns</a>
            </div>
          </div>
        </div>
        <div class="newsletter">
          <h4 class="newsletter-title">Join our Newsletter</h4>
          <p class="newsletter-description">Get the latest updates and offers.</p>
          <form class="newsletter-form">
            <input type="email" placeholder="Enter your email" class="newsletter-input">
            <button type="submit" class="newsletter-btn">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
