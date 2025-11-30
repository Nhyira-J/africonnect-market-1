<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AfriConnect | Authentic African Handicrafts & Artisan Products</title>
  <meta name="description" content="Discover unique African handicrafts including pottery, jewelry, and textiles. Shop authentic artisan products made from sustainable materials with traditional craftsmanship.">
  <meta name="keywords" content="African handicrafts, artisan products, pottery, jewelry, textiles, sustainable crafts, handmade goods, traditional art">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="AfriConnect | Authentic African Handicrafts & Artisan Products">
  <meta property="og:description" content="Discover unique African handicrafts including pottery, jewelry, and textiles. Shop authentic artisan products made from sustainable materials.">
  
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
    
    .flex-row {
      display: flex;
      flex-direction: row;
    }
    
    .flex-col {
      display: flex;
      flex-direction: column;
    }
    
    .flex-center {
      justify-content: center;
      align-items: center;
    }
    
    .flex-between {
      justify-content: space-between;
    }
    
    .flex-start {
      justify-content: flex-start;
    }
    
    .flex-end {
      align-items: flex-end;
    }
    
    .w-full {
      width: 100%;
    }
    
    .w-auto {
      width: auto;
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
    
    /* Hero section */
    .hero-section {
      position: relative;
      width: 100%;
      height: 60vh;
      background: linear-gradient(176deg, #fdfbfbb2 0%, #7c3030b2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 48px 16px;
    }
    
    .hero-content {
      z-index: 2;
      max-width: 1344px;
      width: 100%;
    }
    
    .hero-title {
      font-size: 48px;
      font-family: 'Domine', serif;
      font-weight: 700;
      line-height: 1.2;
      color: #ffffffff;
      margin-bottom: 24px;
    }
    
    .hero-image {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 70%;
      object-fit: cover;
      z-index: 1;
    }
    
    /* Shop section */
    .shop-section {
      background-color: #0d020219;
      padding: 80px 16px;
      text-align: center;
    }
    
    .shop-title {
      font-size: 32px;
      font-family: 'Domine', serif;
      font-weight: 400;
      line-height: 52px;
      color: #000000ff;
      margin-bottom: 32px;
      text-shadow: 0px 0px 32px #0000001e;
    }
    
    .shop-btn {
      background-color: #fdfbfb;
      color: #271a1a;
      font-size: 18px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 500;
      padding: 10px 32px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
    }
    
    .shop-btn:hover {
      background-color: #aa4242;
      color: #ffffff;
      transform: translateY(-2px);
    }
    
    /* Categories section */
    .categories-section {
      padding: 48px 16px;
      background-color: #fdfbfb;
    }
    
    .section-title {
      font-size: 32px;
      font-family: 'Domine', serif;
      font-weight: 700;
      line-height: 55px;
      color: #271a1a;
      margin-bottom: 32px;
    }
    
    .categories-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 24px;
    }
    
    .category-item {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }
    
    .category-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 8px;
    }
    
    .category-name {
      font-size: 18px;
      font-family: 'Domine', serif;
      font-weight: 700;
      color: #271a1a;
    }
    
    /* Best sellers section */
    .bestsellers-section {
      padding: 44px 16px;
      background-color: #fdfbfb;
    }
    
    .products-slider {
      position: relative;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      margin-bottom: 32px;
    }
    
    .products-container {
      display: flex;
      gap: 32px;
      padding-bottom: 16px;
    }
    
    .product-card {
      flex-shrink: 0;
      width: 280px;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    .product-image {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 8px;
    }
    
    .product-info {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    
    .product-name {
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 600;
      color: #271a1a;
    }
    
    .product-price {
      font-size: 15px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 400;
      color: #271a1a;
    }
    
    .color-options {
      display: flex;
      gap: 12px;
      margin-top: 8px;
    }
    
    .color-swatch {
      width: 32px;
      height: 24px;
      border-radius: 4px;
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    
    .color-swatch:hover {
      transform: scale(1.1);
    }
    
    .pager-indicator {
      display: flex;
      justify-content: center;
      gap: 8px;
    }
    
    .pager-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: #d1d5db;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    
    .pager-dot.active {
      background-color: #aa4242;
    }
    
    /* Feature sections */
    .feature-section {
      padding: 116px 16px;
      background-color: #fdfbfb;
    }
    
    .feature-content {
      display: flex;
      flex-direction: column;
      gap: 40px;
      align-items: center;
    }
    
    .feature-text {
      text-align: center;
    }
    
    .feature-title {
      font-size: 32px;
      font-family: 'Domine', serif;
      font-weight: 700;
      line-height: 55px;
      color: #271a1a;
      margin-bottom: 16px;
    }
    
    .feature-description {
      font-size: 20px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 400;
      line-height: 31px;
      color: #271a1a;
      margin-bottom: 32px;
    }
    
    .feature-btn {
      background-color: #aa4242;
      color: #fdfbfb;
      font-size: 18px;
      font-family: 'Outfit', Arial, sans-serif;
      font-weight: 500;
      padding: 10px 32px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
    }
    
    .feature-btn:hover {
      background-color: #8a3535;
      transform: translateY(-2px);
    }
    
    .feature-image {
      width: 100%;
      max-width: 500px;
      height: auto;
      border-radius: 16px;
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
    
    /* Interactive states */
    .nav-item:hover,
    .footer-link:hover {
      color: #aa4242;
    }
    
    .product-card:hover {
      transform: translateY(-4px);
      transition: transform 0.3s ease;
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
      
      .hero-title {
        font-size: 64px;
      }
      
      .shop-title {
        font-size: 40px;
      }
      
      .section-title {
        font-size: 40px;
      }
      
      .categories-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .category-image {
        height: 300px;
      }
      
      .newsletter-form {
        flex-direction: row;
      }
      
      .newsletter-input {
        flex: 1;
      }
    }
    
    @media (min-width: 768px) {
      .hero-section {
        height: 70vh;
      }
      
      .hero-title {
        font-size: 80px;
      }
      
      .shop-title {
        font-size: 48px;
      }
      
      .section-title {
        font-size: 48px;
      }
      
      .feature-content {
        flex-direction: row;
        text-align: left;
      }
      
      .feature-text {
        flex: 1;
        text-align: left;
      }
      
      .feature-title {
        font-size: 40px;
      }
      
      .feature-description {
        font-size: 24px;
      }
      
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
      
      .hero-section {
        height: 80vh;
      }
      
      .hero-title {
        font-size: 120px;
      }
      
      .categories-grid {
        grid-template-columns: repeat(3, 1fr);
      }
      
      .category-image {
        height: 432px;
      }
      
      .products-container {
        justify-content: space-between;
      }
      
      .product-card {
        width: calc(25% - 24px);
      }
      
      .feature-title {
        font-size: 48px;
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
    
    @media (min-width: 1280px) {
      .hero-title {
        font-size: 120px;
      }
    }
  </style>
  
  <script type="module" async src="https://static.rocket.new/rocket-web.js?_cfg=https%3A%2F%2Fafriconnec7264back.builtwithrocket.new&_be=https%3A%2F%2Fapplication.rocket.new&_v=0.1.10"></script>
  <script type="module" defer src="https://static.rocket.new/rocket-shot.js?v=0.0.1"></script>
  </head>
<body>
  <header class="header-container">
    <div class="promo-banner">
      <p class="promo-text">Sign up & get 10% Off on your first purchase</p>
    </div>
    
    <div class="main-header">
      <div class="container">
        <div class="header-content">
          <h1 class="logo">AfriConnect</h1>
          
          <nav class="nav-menu" role="navigation">
            <a href="#" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              Home
              <img src="images/img_arrow_down.svg" alt="" class="nav-arrow">
            </a>
            <a href="view/shop.php" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              Shop
              <img src="images/img_arrow_down.svg" alt="" class="nav-arrow">
            </a>
            <a href="view/sell.php" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              Sell With Us
              <img src="images/img_arrow_down.svg" alt="" class="nav-arrow">
            </a>
            <a href="view/blog.php" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              Blog
              <img src="images/img_icon.svg" alt="" style="width: 8px; height: 4px;">
            </a>
            <a href="view/about.php" class="nav-item" role="menuitem" aria-haspopup="true" aria-expanded="false">
              About Us
              <img src="images/img_arrow_down.svg" alt="" class="nav-arrow">
            </a>
          </nav>
          
          <div class="header-icons">
            <button class="hamburger" aria-label="Menu">
              <img src="images/img_search.svg" alt="Search" class="header-icon">
            </button>
            <a href="#" aria-label="Search">
              <img src="images/img_search.svg" alt="Search" class="header-icon">
            </a>
            <a href="view/login.php" aria-label="User account">
              <img src="images/img_user.svg" alt="User account" class="header-icon">
            </a>
            <a href="#" aria-label="Shopping cart">
              <img src="images/img_shopping_bag.svg" alt="Shopping cart" class="header-icon">
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main>
    <section class="hero-section">
      <div class="hero-content">
        <h2 class="hero-title">Discover Unique Handicrafts</h2>
      </div>
      <img src="images/img_a_beautifully_crafted.png" alt="Beautiful handcrafted ceramic vase with intricate patterns" class="hero-image">
    </section>

    <section class="shop-section">
      <div class="container">
        <h2 class="shop-title">Shop Our Latest Collection</h2>
        <a href="view/shop.php" class="shop-btn">Shop Now</a>
      </div>
    </section>

    <section class="categories-section">
      <div class="container">
        <h2 class="section-title">Featured Categories</h2>
        <div class="categories-grid">
          <article class="category-item">
            <img src="images/img_a_handcrafted_ceramic.png" alt="Handcrafted ceramic pottery with traditional African patterns" class="category-image">
            <h3 class="category-name">Pottery</h3>
          </article>
          <article class="category-item">
            <img src="images/img_a_colorful_handcrafted.png" alt="Colorful handcrafted African jewelry with beads and traditional designs" class="category-image">
            <h3 class="category-name">Jewelry</h3>
          </article>
          <article class="category-item">
            <img src="images/img_a_close_up_view.png" alt="Close up view of colorful African textile patterns and weaving" class="category-image">
            <h3 class="category-name">Textiles</h3>
          </article>
        </div>
      </div>
    </section>

    <section class="bestsellers-section">
      <div class="container">
        <h2 class="section-title">Best Sellers</h2>
        <div class="products-slider">
          <div class="products-container">
            <article class="product-card">
              <img src="images/img_a_beautiful_handcrafted.png" alt="Beautiful handcrafted ceramic vase with traditional African motifs" class="product-image">
              <div class="product-info">
                <h3 class="product-name">Handcrafted Vase</h3>
                <p class="product-price">GHc4500</p>
              </div>
            </article>
            
            <article class="product-card">
              <img src="images/img_a_vibrant_beaded.png" alt="Vibrant beaded necklace with traditional African colors and patterns" class="product-image">
              <div class="product-info">
                <h3 class="product-name">Beaded Necklace</h3>
                <p class="product-price">GHc3000</p>
                <div class="color-options">
                  <img src="images/img_swatch.svg" alt="Color option 1" class="color-swatch">
                  <img src="images/img_swatch_light_green_800.svg" alt="Color option 2" class="color-swatch">
                  <img src="images/img_swatch_red_900.svg" alt="Color option 3" class="color-swatch">
                </div>
              </div>
            </article>
            
            <article class="product-card">
              <img src="images/img_a_colorful_woven.png" alt="Colorful woven scarf with traditional African patterns and vibrant colors" class="product-image">
              <div class="product-info">
                <h3 class="product-name">Woven Scarf</h3>
                <p class="product-price">GHc250</p>
                <div class="color-options">
                  <img src="images/img_swatch_deep_orange_400.svg" alt="Orange color option" class="color-swatch">
                  <img src="images/img_swatch_blue_900.svg" alt="Blue color option" class="color-swatch">
                  <img src="images/img_swatch_light_green_800.svg" alt="Green color option" class="color-swatch">
                  <img src="images/img_swatch_red_900.svg" alt="Red color option" class="color-swatch">
                </div>
              </div>
            </article>
            
            <article class="product-card">
              <img src="images/img_a_brown_ceramic.png" alt="Brown ceramic bowl with traditional African craftsmanship and earth tones" class="product-image">
              <div class="product-info">
                <h3 class="product-name">Ceramic Bowl</h3>
                <p class="product-price">GHc350</p>
                <div class="color-options">
                  <img src="images/img_itemcolors.svg" alt="Available color options" class="color-swatch">
                </div>
              </div>
            </article>
                        <article class="product-card">
              <img src="images/img_a_brown_ceramic.png" alt="Brown ceramic bowl with traditional African craftsmanship and earth tones" class="product-image">
              <div class="product-info">
                <h3 class="product-name">Ceramic Bowl</h3>
                <p class="product-price">GHc350</p>
                <div class="color-options">
                  <img src="images/img_itemcolors.svg" alt="Available color options" class="color-swatch">
                </div>
              </div>
            </article>
          </div>
        </div>
        
        <div class="pager-indicator">
          <span class="pager-dot active"></span>
          <span class="pager-dot"></span>
          <span class="pager-dot"></span>
        </div>
      </div>
    </section>

    <section class="feature-section">
      <div class="container">
        <div class="feature-content">
          <div class="feature-text">
            <h2 class="feature-title">Sustainable Materials</h2>
            <p class="feature-description">All our products are made from eco-friendly materials.</p>
            <a href="#" class="feature-btn">Learn More</a>
          </div>
          <img src="images/img_a_close_up_view_484x624.png" alt="Close up view of sustainable materials used in African handicrafts" class="feature-image">
        </div>
      </div>
    </section>

    <section class="feature-section">
      <div class="container">
        <div class="feature-content">
          <img src="images/img_an_artisan_meticulously.png" alt="An artisan meticulously crafting traditional pottery with care and attention to detail" class="feature-image">
          <div class="feature-text">
            <h2 class="feature-title">Artisan Craftsmanship</h2>
            <p class="feature-description">Each item is crafted with care and attention to detail.</p>
            <a href="#" class="feature-btn">Explore</a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-main">
          <div class="footer-brand">
            <h3 class="footer-logo">AfriCONNECT</h3>
            <div class="social-icons">
              <a href="#" aria-label="Facebook">
                <img src="images/img_facebook.svg" alt="Facebook" class="social-icon">
              </a>
              <a href="#" aria-label="Instagram">
                <img src="images/img_instagram.svg" alt="Instagram" class="social-icon">
              </a>
              <a href="#" aria-label="Twitter">
                <img src="images/img_twitter.svg" alt="Twitter" class="social-icon">
              </a>
            </div>
          </div>
          
          <div class="footer-links">
            <div class="footer-column">
              <h4 class="footer-column-title">Customer Service</h4>
              <ul role="menu">
                <li role="menuitem"><a href="#" class="footer-link">Contact Us</a></li>
                <li role="menuitem"><a href="#" class="footer-link">Shipping & Returns</a></li>
                <li role="menuitem"><a href="#" class="footer-link">FAQs</a></li>
              </ul>
            </div>
            
            <div class="footer-column">
              <h4 class="footer-column-title">About Us</h4>
              <ul role="menu">
                <li role="menuitem"><a href="#" class="footer-link">Our Story</a></li>
                <li role="menuitem"><a href="#" class="footer-link">Sustainability</a></li>
                <li role="menuitem"><a href="#" class="footer-link">Careers</a></li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="newsletter">
          <h4 class="newsletter-title">Join Our Newsletter</h4>
          <p class="newsletter-description">Subscribe for the latest updates and offers</p>
          <form class="newsletter-form">
            <input type="email" placeholder="Email address" class="newsletter-input" required>
            <button type="submit" class="newsletter-btn">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Simple slider functionality
    document.addEventListener('DOMContentLoaded', function() {
      const slider = document.querySelector('.products-slider');
      const dots = document.querySelectorAll('.pager-dot');
      
      dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
          dots.forEach(d => d.classList.remove('active'));
          this.classList.add('active');
        });
      });
      
      // Mobile menu toggle (placeholder)
      const hamburger = document.querySelector('.hamburger');
      const navMenu = document.querySelector('.nav-menu');
      
      if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
          navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
        });
      }
    });
  </script>
</body>
</html>