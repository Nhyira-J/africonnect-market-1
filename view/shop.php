<?php
session_start();
require_once("../controllers/product_controller.php");
require_once("../controllers/category_controller.php");

// Get filter parameters
$category_id = isset($_GET['category']) ? $_GET['category'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch products based on filters or all products
if ($category_id || $min_price || $max_price || $search_term) {
    $products = filter_products_ctr($category_id, $min_price, $max_price, $search_term);
} else {
    $products = view_all_products_ctr();
}

$categories = view_all_categories_ctr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop | AfriConnect</title>
  <!-- <link rel="stylesheet" href="../css/main.css"> -->
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

    /* Page specific styles */
    .shop-header {
        background: linear-gradient(176deg, #fdfbfbb2 0%, #7c3030b2 100%);
        padding: 60px 20px;
        text-align: center;
        margin-bottom: 40px;
    }
    .shop-title {
        font-family: 'Domine', serif;
        font-size: 48px;
        color: #271a1a;
        margin-bottom: 16px;
    }
    .shop-subtitle {
        font-size: 18px;
        color: #555;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .shop-layout {
        display: flex;
        gap: 40px;
        padding: 0 20px;
        max-width: 1344px;
        margin: 0 auto 60px;
    }
    
    .filters-sidebar {
        width: 250px;
        flex-shrink: 0;
    }
    
    .filter-group {
        margin-bottom: 30px;
    }
    
    .filter-title {
        font-family: 'Domine', serif;
        font-size: 18px;
        margin-bottom: 15px;
        color: #271a1a;
        border-bottom: 2px solid #eee;
        padding-bottom: 8px;
    }
    
    .filter-list {
        list-style: none;
        padding: 0;
    }
    
    .filter-item {
        margin-bottom: 10px;
    }
    
    .filter-item label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 15px;
        color: #555;
    }
    
    .products-grid {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }
    
    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
    }
    
    .product-image {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }
    
    .product-details {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-category {
        font-size: 12px;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 5px;
        letter-spacing: 1px;
    }
    
    .product-name {
        font-family: 'Domine', serif;
        font-size: 18px;
        margin-bottom: 10px;
        color: #271a1a;
    }
    
    .product-price {
        font-size: 20px;
        font-weight: 600;
        color: #aa4242;
        margin-bottom: 15px;
    }
    
    .artisan-info {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid #eee;
        font-size: 14px;
        color: #666;
    }
    
    .btn-add-cart {
        width: 100%;
        padding: 12px;
        background: #271a1a;
        color: white;
        border: none;
        border-radius: 6px;
        margin-top: 15px;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .btn-add-cart:hover {
        background: #aa4242;
    }
    
    .btn {
        display: inline-block;
        padding: 14px 28px;
        background-color: #aa4242;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        font-size: 16px;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(170, 66, 66, 0.2);
    }

    @media (max-width: 768px) {
        .shop-layout {
            flex-direction: column;
        }
        .filters-sidebar {
            width: 100%;
        }
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
                <span style="font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 500; color: #271a1a;">Welcome, <span style="color: #aa4242;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
              </div>
            <?php else: ?>
              <a href="login.php" aria-label="User account"><img src="../images/img_user.svg" alt="User account" class="header-icon"></a>
            <?php endif; ?>
            <a href="cart.php" aria-label="Shopping cart"><img src="../images/img_shopping_bag.svg" alt="Shopping cart" class="header-icon"></a>
            <a href="../actions/logout.php" style="font-size: 14px; color: #aa4242; text-decoration: underline;">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="shop-header">
      <h1 class="shop-title">Browse Our Collection</h1>
      <p class="shop-subtitle">Discover unique, handcrafted treasures from artisans across Africa.</p>
      
      <!-- Search Bar -->
      <form method="GET" action="shop.php" style="max-width: 600px; margin: 20px auto 0;">
          <div style="display: flex; gap: 10px;">
              <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search_term); ?>" style="flex: 1; padding: 12px 16px; border: 2px solid #ddd; border-radius: 8px; font-size: 15px; font-family: 'Outfit', sans-serif;">
              <button type="submit" class="btn" style="padding: 12px 24px; white-space: nowrap;">Search</button>
          </div>
      </form>
  </div>

  <div class="shop-layout">
      <!-- Sidebar -->
      <aside class="filters-sidebar">
          <form method="GET" action="shop.php" id="filterForm">
              <!-- Hidden field to preserve search term -->
              <?php if($search_term): ?>
                  <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_term); ?>">
              <?php endif; ?>
              
              <div class="filter-group">
                  <h3 class="filter-title">Categories</h3>
                  <ul class="filter-list">
                      <?php if($categories): ?>
                          <?php foreach($categories as $cat): ?>
                          <li class="filter-item">
                              <label>
                                  <input type="radio" name="category" value="<?php echo $cat['category_id']; ?>" <?php echo ($category_id == $cat['category_id']) ? 'checked' : ''; ?> onchange="document.getElementById('filterForm').submit()"> 
                                  <?php echo $cat['name']; ?>
                              </label>
                          </li>
                          <?php endforeach; ?>
                          <li class="filter-item">
                              <label>
                                  <input type="radio" name="category" value="" <?php echo empty($category_id) ? 'checked' : ''; ?> onchange="document.getElementById('filterForm').submit()"> 
                                  All Categories
                              </label>
                          </li>
                      <?php else: ?>
                          <li class="filter-item">No categories found</li>
                      <?php endif; ?>
                  </ul>
              </div>

              <div class="filter-group">
                  <h3 class="filter-title">Price Range</h3>
                  <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                      <input type="number" name="min_price" placeholder="Min" value="<?php echo htmlspecialchars($min_price); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                      <input type="number" name="max_price" placeholder="Max" value="<?php echo htmlspecialchars($max_price); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                  </div>
                  <button type="submit" class="btn" style="width: 100%; padding: 8px;">Apply</button>
                  <a href="shop.php" class="btn" style="width: 100%; padding: 8px; margin-top: 8px; background: #666; display: block; text-decoration: none; text-align: center;">Clear Filters</a>
              </div>
          </form>
      </aside>

      <!-- Products Grid -->
      <main class="products-grid">
          <?php if($products): ?>
              <?php foreach($products as $product): ?>
              <article class="product-card">
                  <img src="<?php echo !empty($product['image_url']) ? $product['image_url'] : '../images/img_a_beautifully_crafted.png'; ?>" 
                       alt="<?php echo $product['name']; ?>" class="product-image">
                  <div class="product-details">
                      <div class="product-category"><?php echo $product['category_name']; ?></div>
                      <h3 class="product-name"><?php echo $product['name']; ?></h3>
                      <div class="product-price">GH₵ <?php echo $product['price']; ?></div>
                      
                      <div class="artisan-info">
                          <img src="../images/img_user.svg" alt="" style="width: 16px; opacity: 0.6;">
                          <span><?php echo $product['business_name']; ?></span>
                      </div>
                      
                      <div style="display: flex; gap: 10px; margin-top: 15px;">
                          <a href="../actions/add_to_cart_process.php?id=<?php echo $product['product_id']; ?>" style="flex: 1;">
                              <button class="btn-add-cart" style="margin-top: 0;">Add to Cart</button>
                          </a>
                          <a href="productdetails.php?id=<?php echo $product['product_id']; ?>" style="display: flex; align-items: center; justify-content: center; background: #f0f0f0; width: 44px; border-radius: 6px; text-decoration: none;">
                              <span style="font-size: 20px;">👁️</span>
                          </a>
                      </div>
                  </div>
              </article>
              <?php endforeach; ?>
          <?php else: ?>
              <p>No products found.</p>
          <?php endif; ?>
      </main>
  </div>

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