<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AfriConnect - Local Artisans Marketplace | Handcrafted African Art</title>
  <meta name="description" content="Discover unique handcrafted treasures from local African artisans. Shop authentic paintings, artwork, and crafts while supporting local talent and celebrating African craftsmanship.">
  <meta name="keywords" content="African artisans, handcrafted art, local marketplace, paintings, crafts, African art, handmade products, artisan marketplace">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="AfriConnect - Local Artisans Marketplace | Handcrafted African Art">
  <meta property="og:description" content="Discover unique handcrafted treasures from local African artisans. Shop authentic paintings, artwork, and crafts while supporting local talent.">
  
  <style>
    /* Reset and base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Source Serif Pro', serif;
      line-height: 1.6;
      color: #3f3244;
      background-color: #ffffff;
    }
    
    img {
      max-width: 100%;
      height: auto;
      display: block;
    }
    
    button {
      cursor: pointer;
      border: none;
      background: none;
      font-family: inherit;
    }
    
    /* Layout components */
    .main-container {
      width: 100%;
      min-height: 100vh;
      background-color: #ffffff;
    }
    
    .section-container {
      width: 100%;
      padding: 16px;
    }
    
    .content-wrapper {
      width: 100%;
      max-width: 1344px;
      margin: 0 auto;
    }
    
    /* Header styles */
    .header-container {
      width: 100%;
      background-color: #fdfbfb;
    }
    
    .promo-banner {
      background-color: #aa4242;
      padding: 8px;
      text-align: center;
    }
    
    .promo-text {
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 600;
      color: #ffffff;
      line-height: 20px;
    }
    
    .main-header {
      padding: 14px 48px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .logo {
      font-family: 'Crimson Pro', serif;
      font-size: 24px;
      font-weight: 300;
      line-height: 36px;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #271a1a;
    }
    
    .nav-menu {
      display: none;
      gap: 40px;
      align-items: center;
    }
    
    .nav-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-family: 'Outfit', sans-serif;
      font-size: 15px;
      font-weight: 500;
      color: #271a1a;
      text-decoration: none;
      position: relative;
    }
    
    .nav-item:hover {
      color: #aa4242;
    }
    
    .nav-item img {
      width: 16px;
      height: 16px;
    }
    
    .header-actions {
      display: flex;
      gap: 24px;
      align-items: center;
    }
    
    .header-icon {
      width: 24px;
      height: 24px;
      cursor: pointer;
    }
    
    .hamburger {
      display: block;
      width: 24px;
      height: 24px;
      cursor: pointer;
    }
    
    /* Hero section */
    .hero-section {
      display: flex;
      flex-direction: column;
      padding: 16px;
      margin-top: 116px;
    }
    
    .hero-image {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 24px;
    }
    
    .hero-content {
      text-align: center;
    }
    
    .hero-title {
      font-size: 32px;
      font-weight: 600;
      line-height: 40px;
      letter-spacing: 3px;
      color: #3f3244;
      margin-bottom: 16px;
      box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    }
    
    .hero-description {
      font-size: 18px;
      font-weight: 400;
      font-style: italic;
      line-height: 28px;
      letter-spacing: 1px;
      color: #3f3244;
      margin-bottom: 24px;
    }
    
    .cta-button {
      font-size: 18px;
      font-weight: 400;
      line-height: 28px;
      color: #3f3244;
      background-color: #aac4ff;
      border: 1px solid #3f3244;
      border-radius: 8px;
      padding: 10px 34px;
      display: inline-block;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .cta-button:hover {
      background-color: #9bb3ff;
      transform: translateY(-2px);
    }
    
    /* Featured products section */
    .featured-section {
      padding: 32px 16px;
      text-align: center;
    }
    
    .section-title {
      font-size: 28px;
      font-weight: 600;
      line-height: 36px;
      color: #3f3244;
      background-color: #dde3ff;
      border-radius: 8px;
      padding: 8px 34px;
      display: inline-block;
      margin-bottom: 32px;
    }
    
    .products-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 24px;
      margin-bottom: 32px;
    }
    
    .product-card {
      background-color: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.3s ease;
    }
    
    .product-card:hover {
      transform: translateY(-4px);
    }
    
    .product-image-container {
      position: relative;
      width: 100%;
      height: 250px;
      overflow: hidden;
    }
    
    .product-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 3px;
    }
    
    .product-info {
      padding: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .product-name {
      font-size: 18px;
      font-weight: 700;
      line-height: 24px;
      color: #3f3244;
    }
    
    .product-price {
      font-size: 18px;
      font-weight: 400;
      line-height: 24px;
      color: #3f3244;
    }
    
    .view-all-button {
      font-size: 18px;
      font-weight: 400;
      line-height: 28px;
      color: #3f3244;
      background-color: #aac4ff;
      border-radius: 8px;
      padding: 10px 34px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
    }
    
    .view-all-button:hover {
      background-color: #9bb3ff;
    }
    
    /* Community section */
    .community-section {
      padding: 32px 16px;
      text-align: center;
    }
    
    .community-title {
      font-size: 28px;
      font-weight: 600;
      line-height: 36px;
      color: #3f3244;
      margin-bottom: 48px;
    }
    
    .artisans-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
      margin-bottom: 48px;
    }
    
    .artisan-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }
    
    .artisan-image {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
    }
    
    .artisan-name {
      font-size: 18px;
      font-weight: 700;
      line-height: 24px;
      color: #3f3244;
    }
    
    /* Comments section */
    .comments-section {
      padding: 32px 16px;
    }
    
    .comments-title {
      font-size: 28px;
      font-weight: 600;
      line-height: 36px;
      color: #3f3244;
      margin-bottom: 24px;
    }
    
    .comment-card {
      background-color: #eef1ff;
      border: 1px solid #3f3244;
      border-radius: 8px;
      padding: 18px;
      margin-bottom: 16px;
    }
    
    .comment-header {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 12px;
    }
    
    .comment-avatar {
      width: 60px;
      height: 60px;
      border-radius: 10px;
      object-fit: cover;
    }
    
    .comment-user-info h4 {
      font-size: 18px;
      font-weight: 700;
      line-height: 24px;
      color: #3f3244;
    }
    
    .comment-date {
      font-size: 12px;
      font-weight: 400;
      line-height: 16px;
      color: #3f3244;
    }
    
    .comment-text {
      font-size: 18px;
      font-weight: 400;
      font-style: italic;
      line-height: 24px;
      color: #3f3244;
    }
    
    /* Newsletter section */
    .newsletter-section {
      padding: 32px 16px;
    }
    
    .newsletter-title {
      font-size: 28px;
      font-weight: 700;
      line-height: 36px;
      color: #000000;
      margin-bottom: 16px;
    }
    
    .newsletter-form {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    .form-label {
      font-size: 18px;
      font-weight: 400;
      line-height: 24px;
      color: #000000;
    }
    
    .form-input {
      border: 2px solid #000000;
      padding: 10px 18px;
      font-size: 16px;
      font-weight: 400;
      line-height: 21px;
      color: #a19999;
      border-radius: 4px;
    }
    
    .subscribe-button {
      font-size: 18px;
      font-weight: 400;
      line-height: 28px;
      color: #000000;
      background-color: #aac4ff;
      border: 1px solid #000000;
      border-radius: 8px;
      padding: 10px 34px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .subscribe-button:hover {
      background-color: #9bb3ff;
    }
    
    /* Footer styles */
    .footer-container {
      border-top: 1px solid #aa4242;
      padding: 52px 16px;
      margin-top: 140px;
    }
    
    .footer-content {
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
      font-family: 'Crimson Pro', serif;
      font-size: 24px;
      font-weight: 300;
      line-height: 36px;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #271a1a;
    }
    
    .social-links {
      display: flex;
      gap: 14px;
    }
    
    .social-icon {
      width: 24px;
      height: 24px;
    }
    
    .footer-links {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }
    
    .footer-section h4 {
      font-family: 'Outfit', sans-serif;
      font-size: 15px;
      font-weight: 500;
      line-height: 19px;
      color: #271a1a;
      margin-bottom: 10px;
    }
    
    .footer-section ul {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    
    .footer-section a {
      font-family: 'Outfit', sans-serif;
      font-size: 15px;
      font-weight: 500;
      line-height: 19px;
      color: rgba(46, 19, 19, 0.62);
      text-decoration: none;
    }
    
    .footer-section a:hover {
      color: #271a1a;
    }
    
    .footer-newsletter {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    .footer-newsletter-form {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    .footer-input {
      border: 1px solid rgba(0, 0, 0, 0.04);
      border-radius: 8px;
      padding: 12px;
      background-color: rgba(117, 45, 45, 0.08);
      font-family: 'Outfit', sans-serif;
      font-size: 15px;
      color: rgba(46, 19, 19, 0.4);
    }
    
    .footer-subscribe-btn {
      border: 1px solid rgba(110, 73, 73, 0.2);
      border-radius: 8px;
      padding: 10px 20px;
      background-color: transparent;
      font-family: 'Outfit', sans-serif;
      font-size: 15px;
      font-weight: 500;
      color: #271a1a;
      cursor: pointer;
    }
    
    /* Responsive media queries */
    @media (min-width: 640px) {
      .promo-text {
        font-size: 16px;
      }
      
      .logo {
        font-size: 28px;
      }
      
      .hero-title {
        font-size: 42px;
        line-height: 52px;
        letter-spacing: 4px;
      }
      
      .hero-description {
        font-size: 22px;
        line-height: 32px;
      }
      
      .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 32px;
      }
      
      .artisans-grid {
        grid-template-columns: repeat(3, 1fr);
      }
      
      .artisan-image {
        width: 180px;
        height: 180px;
      }
      
      .newsletter-form {
        flex-direction: row;
        align-items: end;
      }
      
      .form-input {
        flex: 1;
      }
      
      .footer-content {
        flex-direction: row;
        justify-content: space-between;
      }
      
      .footer-links {
        flex-direction: row;
        gap: 48px;
      }
    }
    
    @media (min-width: 768px) {
      .section-container {
        padding: 24px;
      }
      
      .hamburger {
        display: none;
      }
      
      .nav-menu {
        display: flex;
      }
      
      .hero-section {
        flex-direction: row;
        align-items: center;
        gap: 48px;
      }
      
      .hero-image {
        width: 48%;
        margin-bottom: 0;
      }
      
      .hero-content {
        width: 52%;
        text-align: left;
      }
      
      .hero-title {
        font-size: 52px;
        line-height: 64px;
        letter-spacing: 5px;
      }
      
      .hero-description {
        font-size: 24px;
        line-height: 36px;
      }
      
      .section-title {
        font-size: 32px;
        line-height: 42px;
      }
      
      .community-title {
        font-size: 32px;
        line-height: 42px;
      }
      
      .artisan-image {
        width: 240px;
        height: 240px;
      }
      
      .comment-avatar {
        width: 84px;
        height: 84px;
      }
      
      .comment-text {
        font-size: 20px;
        line-height: 28px;
      }
    }
    
    @media (min-width: 1024px) {
      .main-header {
        padding: 14px 48px;
      }
      
      .logo {
        font-size: 32px;
      }
      
      .hero-title {
        font-size: 64px;
        line-height: 80px;
        letter-spacing: 7px;
      }
      
      .hero-description {
        font-size: 28px;
        line-height: 40px;
        letter-spacing: 2px;
      }
      
      .section-title {
        font-size: 36px;
        line-height: 46px;
      }
      
      .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
      }
      
      .product-image-container {
        height: 384px;
      }
      
      .community-title {
        font-size: 36px;
        line-height: 46px;
      }
      
      .artisans-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 48px;
      }
      
      .artisan-image {
        width: 360px;
        height: 360px;
      }
      
      .artisan-name {
        font-size: 24px;
        line-height: 31px;
      }
      
      .comments-title {
        font-size: 36px;
        line-height: 46px;
      }
      
      .comment-text {
        font-size: 24px;
        line-height: 31px;
      }
      
      .newsletter-title {
        font-size: 36px;
        line-height: 46px;
      }
      
      .footer-newsletter-form {
        flex-direction: row;
        gap: 12px;
      }
      
      .footer-input {
        flex: 1;
      }
    }
    
    @media (min-width: 1280px) {
      .content-wrapper {
        max-width: 1344px;
      }
      
      .section-container {
        padding: 32px 56px;
      }
    }
  </style>
  
  <script type="module" async src="https://static.rocket.new/rocket-web.js?_cfg=https%3A%2F%2Fafriconnec7264back.builtwithrocket.new&_be=https%3A%2F%2Fapplication.rocket.new&_v=0.1.10"></script>
  <script type="module" defer src="https://static.rocket.new/rocket-shot.js?v=0.0.1"></script>
  </head>
<body>
  <main class="main-container">
    <!-- Header -->
    <header class="header-container">
      <div class="promo-banner">
        <p class="promo-text">Sign up & get 10% Off on your first purchase</p>
      </div>
      
      <div class="main-header">
        <div class="content-wrapper" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
          <h1 class="logo">AfriConnect</h1>
          
          <nav class="nav-menu" role="navigation">
            <a href="#" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              Home
              <img src="../images/img_arrow_down.svg" alt="">
            </a>
            <a href="#" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              Shop
              <img src="../images/img_arrow_down.svg" alt="">
            </a>
            <a href="#" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              About Us
              <img src="../images/img_arrow_down.svg" alt="">
            </a>
            <a href="#" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              Contact
              <img src="../images/img_arrow_down.svg" alt="">
            </a>
            <a href="#" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              Blog
              <img src="../images/img_arrow_down.svg" alt="">
            </a>
          </nav>
          
          <div class="header-actions">
            <button class="hamburger" aria-label="Menu">☰</button>
            <img src="../images/img_search.svg" alt="Search" class="header-icon">
            <img src="../images/img_user.svg" alt="User account" class="header-icon">
            <img src="../images/img_shopping_bag.svg" alt="Shopping cart" class="header-icon">
          </div>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="content-wrapper" style="display: flex; flex-direction: column; gap: 32px;">
        <img src="../images/img_rectangle_1.png" alt="Local artisans workspace with handcrafted items" class="hero-image">
        
        <div class="hero-content">
          <h2 class="hero-title">Local Artisans Marketplace</h2>
          <p class="hero-description">Explore the warmth of handcrafted treasures, bask in the glow of unique stories, and illuminate your shopping journey with the brilliance of local talent.</p>
          <a href="#" class="cta-button">Shop Now →</a>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-section">
      <div class="content-wrapper">
        <h2 class="section-title">Featured Products</h2>
        
        <div class="products-grid">
          <article class="product-card">
            <div class="product-image-container">
              <img src="../images/img_rectangle_15.png" alt="Painting of multiple personalities artwork" class="product-image">
            </div>
            <div class="product-info">
              <h3 class="product-name">Painting of multiple personalities</h3>
              <span class="product-price">GHc10.00</span>
            </div>
          </article>
          
          <article class="product-card">
            <div class="product-image-container">
              <img src="../images/img_rectangle_15_232x620.png" alt="Monalisa painting reproduction" class="product-image">
            </div>
            <div class="product-info">
              <h3 class="product-name">Monalisa</h3>
              <span class="product-price">GHc 300.00</span>
            </div>
          </article>
          
          <article class="product-card">
            <div class="product-image-container">
              <img src="../images/img_rectangle_18881.png" alt="Sky painting with clouds and horizon" class="product-image">
            </div>
            <div class="product-info">
              <h3 class="product-name">Painting of the sky</h3>
              <span class="product-price">Ghc 250.00</span>
            </div>
          </article>
          
          <article class="product-card">
            <div class="product-image-container">
              <img src="../images/img_rectangle_15_384x620.png" alt="Oil painting with vibrant colors" class="product-image">
            </div>
            <div class="product-info">
              <h3 class="product-name">Oil Painting</h3>
              <span class="product-price">GHc10.00</span>
            </div>
          </article>
        </div>
        
        <a href="#" class="view-all-button">
          View all
          <img src="../images/img_group_1.svg" alt="" width="14" height="1">
        </a>
      </div>
    </section>

    <!-- Community Section -->
    <section class="community-section">
      <div class="content-wrapper">
        <h2 class="community-title">Learn From The Community</h2>
        
        <div class="artisans-grid">
          <article class="artisan-card">
            <img src="../images/img_ellipse_12.png" alt="Portrait of artisan Nettie" class="artisan-image">
            <h3 class="artisan-name">Nettie</h3>
          </article>
          
          <article class="artisan-card">
            <img src="../images/img_ellipse_12_360x360.png" alt="Portrait of artisan Sauer" class="artisan-image">
            <h3 class="artisan-name">Sauer</h3>
          </article>
          
          <article class="artisan-card">
            <img src="../images/img_ellipse_12_1.png" alt="Portrait of artisan Jeannette" class="artisan-image">
            <h3 class="artisan-name">Jeannette</h3>
          </article>
          
          <article class="artisan-card">
            <img src="../images/img_ellipse_12_2.png" alt="Portrait of artisan Harvey" class="artisan-image">
            <h3 class="artisan-name">Harvey</h3>
          </article>
          
          <article class="artisan-card">
            <img src="../images/img_ellipse_12_3.png" alt="Portrait of artisan Kerluke" class="artisan-image">
            <h3 class="artisan-name">Kerluke</h3>
          </article>
        </div>
      </div>
    </section>

    <!-- Comments Section -->
    <section class="comments-section">
      <div class="content-wrapper">
        <h2 class="comments-title">Comments</h2>
        
        <article class="comment-card">
          <div class="comment-header">
            <img src="../images/img_rectangle_17.png" alt="Josh Joe profile picture" class="comment-avatar">
            <div class="comment-user-info">
              <h4>Josh Joe</h4>
              <p class="comment-date">on 23/03/22</p>
            </div>
          </div>
          <p class="comment-text">"Such a delightful collection! Every piece tells a unique story. I love exploring this marketplace!"</p>
        </article>
        
        <article class="comment-card">
          <div class="comment-header">
            <img src="../images/img_rectangle_17_84x84.png" alt="Marlyn213 profile picture" class="comment-avatar">
            <div class="comment-user-info">
              <h4>Marlyn213</h4>
              <p class="comment-date">on 28/11/22</p>
            </div>
          </div>
          <p class="comment-text">"I've found the perfect addition to my home. The craftsmanship is exceptional, and the shopping experience was seamless."</p>
        </article>
        
        <article class="comment-card">
          <div class="comment-header">
            <img src="../images/img_rectangle_17_1.png" alt="User5323 profile picture" class="comment-avatar">
            <div class="comment-user-info">
              <h4>User5323</h4>
              <p class="comment-date">on 28/07/23</p>
            </div>
          </div>
          <p class="comment-text">"This marketplace is a gem! I've already recommended it to friends. Can't wait to see new additions and support more local artisans."</p>
        </article>
        
        <a href="#" class="view-all-button">
          Review
          <img src="../images/img_group_1_black_900.svg" alt="" width="14" height="1">
        </a>
      </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
      <div class="content-wrapper">
        <h2 class="newsletter-title">Subscribe to Our Newsletter</h2>
        
        <form class="newsletter-form">
          <label class="form-label">Email address</label>
          <input type="email" class="form-input" placeholder="Enter your email address" required>
          <button type="submit" class="subscribe-button">Subscribe</button>
        </form>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer-container">
      <div class="content-wrapper">
        <div class="footer-content">
          <div class="footer-brand">
            <h3 class="footer-logo">AfriCONNECT</h3>
            <div class="social-links">
              <img src="../images/img_facebook.svg" alt="Facebook" class="social-icon">
              <img src="../images/img_instagram.svg" alt="Instagram" class="social-icon">
              <img src="../images/img_twitter.svg" alt="Twitter" class="social-icon">
            </div>
          </div>
          
          <div class="footer-links">
            <div class="footer-section">
              <h4>Customer Service</h4>
              <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Shipping & Returns</a></li>
                <li><a href="#">FAQs</a></li>
              </ul>
            </div>
            
            <div class="footer-section">
              <h4>About Us</h4>
              <ul>
                <li><a href="#">Our Story</a></li>
                <li><a href="#">Sustainability</a></li>
                <li><a href="#">Careers</a></li>
              </ul>
            </div>
          </div>
          
          <div class="footer-newsletter">
            <h4>Join Our Newsletter</h4>
            <p>Subscribe for the latest updates and offers</p>
            <form class="footer-newsletter-form">
              <input type="email" class="footer-input" placeholder="Email address" required>
              <button type="submit" class="footer-subscribe-btn">Subscribe</button>
            </form>
          </div>
        </div>
      </div>
    </footer>
  </main>

  <script>
    // Mobile menu toggle
    document.querySelector('.hamburger').addEventListener('click', function() {
      const navMenu = document.querySelector('.nav-menu');
      navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
    });

    // Newsletter form submission
    document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const email = this.querySelector('input[type="email"]').value;
      if (email) {
        alert('Thank you for subscribing to our newsletter!');
        this.reset();
      }
    });

    // Footer newsletter form submission
    document.querySelector('.footer-newsletter-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const email = this.querySelector('input[type="email"]').value;
      if (email) {
        alert('Thank you for subscribing!');
        this.reset();
      }
    });

    // Product card hover effects
    document.querySelectorAll('.product-card').forEach(card => {
      card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px)';
        this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
      });
      
      card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = 'none';
      });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  </script>
</body>
</html>