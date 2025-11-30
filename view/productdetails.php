<?php
session_start();
require_once("../controllers/product_controller.php");

if(isset($_GET['id'])){
    $product_id = $_GET['id'];
    $product = view_one_product_ctr($product_id);
} else {
    header("Location: shop.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> | AfriConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Base Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background: #fdfbfb; color: #271a1a; line-height: 1.6; }
        
        /* Header Styles (from index.php) */
        .header-container { background-color: #fdfbfb; width: 100%; }
        .promo-banner { background-color: #aa4242; padding: 8px; text-align: center; }
        .promo-text { font-size: 14px; font-family: 'Inter', Arial, sans-serif; font-weight: 600; color: #ffffff; }
        .main-header { padding: 14px 0; }
        .container { width: 100%; max-width: 1344px; margin: 0 auto; padding-left: 16px; padding-right: 16px; }
        .header-content { display: flex; justify-content: space-between; align-items: flex-end; }
        .logo { font-size: 24px; font-family: 'Crimson Pro', serif; font-weight: 300; line-height: 36px; letter-spacing: 1px; text-transform: uppercase; color: #271a1a; margin-top: 42px; text-decoration: none; }
        .nav-menu { display: none; gap: 40px; align-items: center; margin-bottom: 10px; }
        .nav-item { display: flex; gap: 6px; align-items: center; font-size: 15px; font-family: 'Outfit', Arial, sans-serif; font-weight: 500; color: #271a1a; text-decoration: none; cursor: pointer; }
        .nav-item:hover { color: #aa4242; }
        .nav-arrow { width: 16px; height: 16px; }
        .header-icons { display: flex; gap: 24px; align-items: center; margin-bottom: 8px; }
        .header-icon { width: 24px; height: 24px; cursor: pointer; transition: transform 0.3s ease; }
        .header-icon:hover { transform: scale(1.1); }
        .hamburger { display: block; width: 24px; height: 24px; cursor: pointer; }

        /* Footer Styles (from index.php) */
        .footer { border-top: 1px solid #aa4242; padding: 52px 16px; background-color: #fdfbfb; margin-top: 60px; }
        .footer-content { display: flex; flex-direction: column; gap: 40px; }
        .footer-main { display: flex; flex-direction: column; gap: 32px; }
        .footer-brand { display: flex; flex-direction: column; gap: 16px; }
        .footer-logo { font-size: 24px; font-family: 'Crimson Pro', serif; font-weight: 300; letter-spacing: 1px; text-transform: uppercase; color: #271a1a; }
        .social-icons { display: flex; gap: 14px; }
        .social-icon { width: 24px; height: 24px; cursor: pointer; transition: transform 0.3s ease; }
        .social-icon:hover { transform: scale(1.2); }
        .footer-links { display: flex; flex-direction: column; gap: 32px; }
        .footer-column { display: flex; flex-direction: column; gap: 10px; }
        .footer-column-title { font-size: 15px; font-family: 'Outfit', Arial, sans-serif; font-weight: 500; color: #271a1a; margin-bottom: 10px; }
        .footer-link { font-size: 15px; font-family: 'Outfit', Arial, sans-serif; font-weight: 500; color: #2e13139e; text-decoration: none; transition: color 0.3s ease; }
        .footer-link:hover { color: #aa4242; }
        .newsletter { display: flex; flex-direction: column; gap: 16px; }
        .newsletter-title { font-size: 15px; font-family: 'Outfit', Arial, sans-serif; font-weight: 600; color: #271a1a; }
        .newsletter-description { font-size: 15px; font-family: 'Outfit', Arial, sans-serif; font-weight: 400; color: #271a1a; }
        .newsletter-form { display: flex; flex-direction: column; gap: 12px; }
        .newsletter-input { padding: 12px; border: 1px solid #0000000a; border-radius: 8px; background-color: #752d2d14; font-size: 15px; font-family: 'Outfit', Arial, sans-serif; color: #2e131366; }
        .newsletter-btn { padding: 10px 20px; border: 1px solid #6e494933; border-radius: 8px; background-color: transparent; font-size: 15px; font-family: 'Outfit', Arial, sans-serif; font-weight: 500; color: #271a1a; cursor: pointer; transition: all 0.3s ease; }
        .newsletter-btn:hover { background-color: #aa4242; color: #ffffff; border-color: #aa4242; }

        /* Product Page Specific Styles */
        .breadcrumb { padding: 20px 0; color: #666; font-size: 14px; }
        .breadcrumb a { color: #666; text-decoration: none; }
        .breadcrumb a:hover { color: #aa4242; }
        
        .product-detail-container { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; margin-bottom: 60px; }
        .product-gallery { display: flex; flex-direction: column; gap: 20px; }
        .main-image { width: 100%; height: 500px; object-fit: cover; border-radius: 12px; background: #f5f5f5; }
        .product-info { display: flex; flex-direction: column; gap: 20px; }
        .product-category { color: #aa4242; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 14px; }
        .product-title { font-family: 'Domine', serif; font-size: 42px; color: #271a1a; line-height: 1.2; }
        .product-price { font-size: 32px; font-weight: 600; color: #aa4242; }
        .product-description { color: #555; font-size: 16px; line-height: 1.8; }
        .artisan-card { display: flex; align-items: center; gap: 15px; padding: 15px; background: #f9f9f9; border-radius: 8px; border: 1px solid #eee; }
        .artisan-avatar { width: 50px; height: 50px; border-radius: 50%; background: #ddd; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .artisan-details h4 { margin-bottom: 4px; color: #271a1a; }
        .artisan-details p { font-size: 13px; color: #666; }
        .action-area { margin-top: 20px; display: flex; gap: 20px; align-items: center; }
        .quantity-selector { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
        .qty-btn { padding: 12px 16px; background: #f5f5f5; border: none; cursor: pointer; font-size: 18px; }
        .qty-input { width: 50px; text-align: center; border: none; font-size: 16px; font-weight: 600; }
        .btn-add-cart { flex: 1; padding: 16px; background: #271a1a; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s; }
        .btn-add-cart:hover { background: #aa4242; }
        .features-list { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 30px; }
        .feature-item { display: flex; align-items: center; gap: 10px; font-size: 14px; color: #555; }

        /* Responsive */
        @media (min-width: 640px) {
            .container { padding-left: 24px; padding-right: 24px; }
            .promo-text { font-size: 16px; }
            .logo { font-size: 28px; }
            .newsletter-form { flex-direction: row; }
            .newsletter-input { flex: 1; }
        }
        @media (min-width: 768px) {
            .footer-main { flex-direction: row; justify-content: space-between; }
            .footer-links { flex-direction: row; gap: 60px; }
            .product-detail-container { grid-template-columns: 1fr; gap: 30px; }
            .main-image { height: 350px; }
            .product-title { font-size: 32px; }
        }
        @media (min-width: 1024px) {
            .container { padding-left: 32px; padding-right: 32px; }
            .hamburger { display: none; }
            .nav-menu { display: flex; }
            .logo { font-size: 32px; }
            .footer-content { flex-direction: row; justify-content: space-between; align-items: flex-start; }
            .footer-main { flex: 1; }
            .newsletter { width: 400px; }
            .product-detail-container { grid-template-columns: 1fr 1fr; gap: 50px; }
            .main-image { height: 500px; }
            .product-title { font-size: 42px; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header-container">
        <div class="promo-banner">
            <p class="promo-text">Sign up & get 10% Off on your first purchase</p>
        </div>
        
        <div class="main-header">
            <div class="container">
                <div class="header-content">
                    <a href="../index.php" style="text-decoration: none;"><h1 class="logo">AfriConnect</h1></a>
                    
                    <nav class="nav-menu" role="navigation">
                        <a href="../index.php" class="nav-item">
                            Home
                            <img src="../images/img_arrow_down.svg" alt="" class="nav-arrow">
                        </a>
                        <a href="shop.php" class="nav-item">
                            Shop
                            <img src="../images/img_arrow_down.svg" alt="" class="nav-arrow">
                        </a>
                        <a href="sell.php" class="nav-item">
                            Sell With Us
                            <img src="../images/img_arrow_down.svg" alt="" class="nav-arrow">
                        </a>
                        <a href="blog.php" class="nav-item">
                            Blog
                            <img src="../images/img_icon.svg" alt="" style="width: 8px; height: 4px;">
                        </a>
                        <a href="about.php" class="nav-item">
                            About Us
                            <img src="../images/img_arrow_down.svg" alt="" class="nav-arrow">
                        </a>
                    </nav>
                    
                    <div class="header-icons">
                        <button class="hamburger" aria-label="Menu">
                            <img src="../images/img_search.svg" alt="Search" class="header-icon">
                        </button>
                        <a href="#" aria-label="Search">
                            <img src="../images/img_search.svg" alt="Search" class="header-icon">
                        </a>
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="../actions/logout.php" aria-label="Logout">
                                <img src="../images/img_user.svg" alt="Logout" class="header-icon">
                            </a>
                        <?php else: ?>
                            <a href="login.php" aria-label="User account">
                                <img src="../images/img_user.svg" alt="User account" class="header-icon">
                            </a>
                        <?php endif; ?>
                        <a href="cart.php" aria-label="Shopping cart">
                            <img src="../images/img_shopping_bag.svg" alt="Shopping cart" class="header-icon">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">Home</a> / <a href="shop.php">Shop</a> / <?php echo htmlspecialchars($product['name']); ?>
        </div>

        <div class="product-detail-container">
            <!-- Gallery -->
            <div class="product-gallery">
                <img src="<?php echo !empty($product['image_url']) ? $product['image_url'] : '../images/img_a_beautifully_crafted.png'; ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>" class="main-image">
            </div>

            <!-- Info -->
            <div class="product-info">
                <div>
                    <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                    <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                </div>

                <div class="product-price">GH₵ <?php echo htmlspecialchars($product['price']); ?></div>

                <div class="artisan-card">
                    <div class="artisan-avatar">👨‍🎨</div>
                    <div class="artisan-details">
                        <h4>Crafted by <?php echo htmlspecialchars($product['business_name']); ?></h4>
                        <p>Verified Artisan • Authentic Handcraft</p>
                    </div>
                </div>

                <div class="product-description">
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>

                <div class="features-list">
                    <div class="feature-item"><span>🚚</span> Delivery in <?php echo $product['estimated_delivery_time']; ?> days</div>
                    <div class="feature-item"><span>🛡️</span> Quality Guarantee</div>
                    <div class="feature-item"><span>🌿</span> Sustainable Materials</div>
                    <div class="feature-item"><span>✋</span> Handmade with Love</div>
                </div>

                <form action="../actions/add_to_cart_process.php" method="GET" class="action-area">
                    <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                    <div class="quantity-selector">
                        <button type="button" class="qty-btn" onclick="decrement()">-</button>
                        <input type="text" name="qty" id="qty" value="1" class="qty-input" readonly>
                        <button type="button" class="qty-btn" onclick="increment()">+</button>
                    </div>
                    <button type="submit" class="btn-add-cart">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
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

    <script>
        function increment() {
            var value = parseInt(document.getElementById('qty').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('qty').value = value;
        }
        function decrement() {
            var value = parseInt(document.getElementById('qty').value, 10);
            value = isNaN(value) ? 0 : value;
            if(value > 1) {
                value--;
                document.getElementById('qty').value = value;
            }
        }
    </script>
</body>
</html>