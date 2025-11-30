<?php
session_start();
include("../controllers/cart_controller.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$cart_items = view_cart_ctr($customer_id);
$total = get_cart_total_ctr($customer_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | AfriConnect</title>
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

        /* Cart Page Specific Styles */
        .cart-header { margin-bottom: 40px; margin-top: 40px; }
        .cart-title { font-family: 'Domine', serif; font-size: 36px; margin-bottom: 10px; }
        .cart-subtitle { color: #666; }
        
        .cart-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
        .cart-items { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .cart-table { width: 100%; border-collapse: collapse; }
        .cart-table th { text-align: left; padding: 15px; border-bottom: 1px solid #eee; color: #666; font-weight: 500; }
        .cart-table td { padding: 20px 15px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
        
        .product-col { display: flex; align-items: center; gap: 15px; }
        .img-thumb { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; background: #f5f5f5; }
        .product-name { font-weight: 600; color: #271a1a; margin-bottom: 4px; }
        .product-meta { font-size: 13px; color: #888; }
        
        .qty-badge { background: #f0f0f0; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500; }
        .price { font-weight: 600; color: #271a1a; }
        .remove-btn { color: #d32f2f; text-decoration: none; font-size: 13px; font-weight: 500; }
        .remove-btn:hover { text-decoration: underline; }
        
        .cart-summary { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); height: fit-content; }
        .summary-title { font-family: 'Domine', serif; font-size: 24px; margin-bottom: 20px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; color: #555; }
        .summary-row.total { border-top: 2px solid #eee; padding-top: 15px; margin-top: 15px; font-weight: 700; color: #271a1a; font-size: 18px; }
        
        .btn-checkout { display: block; width: 100%; padding: 16px; background: #aa4242; color: white; text-align: center; text-decoration: none; border-radius: 8px; font-weight: 600; margin-top: 20px; transition: background 0.3s; }
        .btn-checkout:hover { background: #8a3535; }
        .btn-continue { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; font-size: 14px; }
        .btn-continue:hover { color: #271a1a; }
        
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
            .cart-layout { grid-template-columns: 2fr 1fr; }
        }
        @media (max-width: 768px) {
            .cart-layout { grid-template-columns: 1fr; }
        }
        @media (min-width: 1024px) {
            .container { padding-left: 32px; padding-right: 32px; }
            .hamburger { display: none; }
            .nav-menu { display: flex; }
            .logo { font-size: 32px; }
            .footer-content { flex-direction: row; justify-content: space-between; align-items: flex-start; }
            .footer-main { flex: 1; }
            .newsletter { width: 400px; }
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
        <div class="cart-header">
            <h1 class="cart-title">Shopping Cart</h1>
            <p class="cart-subtitle"><?php echo $cart_items ? count($cart_items) : 0; ?> items in your cart</p>
        </div>
        
        <?php if($cart_items): ?>
        <div class="cart-layout">
            <div class="cart-items">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cart_items as $item): ?>
                        <tr>
                            <td>
                                <div class="product-col">
                                    <img src="<?php echo $item['image_url']; ?>" class="img-thumb">
                                    <div>
                                        <div class="product-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                        <div class="product-meta">Artisan Item</div>
                                    </div>
                                </div>
                            </td>
                            <td class="price">GHS <?php echo $item['price']; ?></td>
                            <td><span class="qty-badge"><?php echo $item['quantity']; ?></span></td>
                            <td class="price">GHS <?php echo $item['subtotal']; ?></td>
                            <td><a href="../actions/remove_from_cart.php?id=<?php echo $item['item_id']; ?>" class="remove-btn">Remove</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="cart-summary">
                <h3 class="summary-title">Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>GHS <?php echo $total; ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>GHS <?php echo $total; ?></span>
                </div>
                
                <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
                <a href="shop.php" class="btn-continue">Continue Shopping</a>
            </div>
        </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px;">
                <div style="font-size: 60px; margin-bottom: 20px;">🛒</div>
                <h3>Your cart is empty</h3>
                <p style="color: #666; margin-bottom: 30px;">Looks like you haven't added any unique treasures yet.</p>
                <a href="shop.php" class="btn-checkout" style="max-width: 200px; margin: 0 auto;">Start Shopping</a>
            </div>
        <?php endif; ?>
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
</body>
</html>
