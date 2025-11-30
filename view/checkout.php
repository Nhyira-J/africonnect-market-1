<?php
session_start();
include("../controllers/cart_controller.php");
include("../controllers/customer_controller.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$user_id = $_SESSION['user_id'];
$total = get_cart_total_ctr($customer_id);

// Fetch user details
$user_details = get_customer_details_ctr($user_id);

// Parse full name into first and last name
$full_name = $user_details['full_name'];
$name_parts = explode(" ", $full_name);
$first_name = $name_parts[0];
$last_name = isset($name_parts[1]) ? implode(" ", array_slice($name_parts, 1)) : '';

// Parse address if possible (assuming format: address, city, country)
$full_address = $user_details['address'];
$address_parts = explode(", ", $full_address);
$address = isset($address_parts[0]) ? $address_parts[0] : $full_address;
$city = isset($address_parts[1]) ? $address_parts[1] : '';
// Country is likely the 3rd part, but we don't have a country field in the form currently, just region.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | AfriConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Base Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background: #f8f9fa; color: #271a1a; min-height: 100vh; display: flex; flex-direction: column; }
        
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
        .footer { border-top: 1px solid #aa4242; padding: 52px 16px; background-color: #fdfbfb; margin-top: auto; }
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

        /* Breadcrumb */
        .breadcrumb { background: white; padding: 16px 0; border-bottom: 1px solid #e8e8e8; }
        .breadcrumb-nav { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #666; }
        .breadcrumb-link { color: #666; text-decoration: none; transition: color 0.3s ease; }
        .breadcrumb-link:hover { color: #aa4242; }
        .breadcrumb-current { color: #aa4242; font-weight: 600; }

        /* Main Content */
        .checkout-main { flex: 1; padding: 60px 20px; }
        .checkout-container { max-width: 1200px; margin: 0 auto; }
        
        .page-header { text-align: center; margin-bottom: 48px; }
        .page-title { font-family: 'Domine', serif; font-size: 36px; font-weight: 700; color: #271a1a; margin-bottom: 12px; }
        .page-subtitle { font-size: 16px; color: #666; font-weight: 400; }

        /* Progress Steps */
        .progress-steps { display: flex; justify-content: center; align-items: center; margin-bottom: 48px; gap: 24px; }
        .step { display: flex; flex-direction: column; align-items: center; gap: 8px; position: relative; }
        .step-number { width: 48px; height: 48px; border-radius: 50%; background: #e8e8e8; color: #999; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; transition: all 0.3s ease; }
        .step.active .step-number { background: linear-gradient(135deg, #aa4242 0%, #8a3535 100%); color: white; box-shadow: 0 4px 12px rgba(170, 66, 66, 0.3); }
        .step.completed .step-number { background: #4caf50; color: white; }
        .step-label { font-size: 14px; color: #666; font-weight: 500; }
        .step.active .step-label { color: #aa4242; font-weight: 600; }
        .step-connector { width: 80px; height: 2px; background: #e8e8e8; margin-bottom: 32px; }
        .step-connector.active { background: #aa4242; }

        /* Two Column Layout */
        .checkout-grid { display: grid; grid-template-columns: 1fr; gap: 32px; }

        /* Left Column - Form */
        .checkout-form-section { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); }
        
        .section-title { font-size: 20px; font-weight: 600; color: #271a1a; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0; }
        
        .form-row { display: grid; grid-template-columns: 1fr; gap: 20px; margin-bottom: 24px; }
        
        .form-group { display: flex; flex-direction: column; }
        .form-label { font-size: 14px; font-weight: 600; color: #271a1a; margin-bottom: 8px; }
        .form-label .required { color: #aa4242; }
        
        .form-input { padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; font-family: 'Outfit', sans-serif; transition: all 0.3s ease; background: #fafafa; }
        .form-input:focus { outline: none; border-color: #aa4242; background: white; box-shadow: 0 0 0 4px rgba(170, 66, 66, 0.08); }
        
        .form-select { padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; font-family: 'Outfit', sans-serif; background: #fafafa; cursor: pointer; transition: all 0.3s ease; }
        .form-select:focus { outline: none; border-color: #aa4242; background: white; box-shadow: 0 0 0 4px rgba(170, 66, 66, 0.08); }

        /* Payment Methods */
        .payment-methods { display: grid; gap: 16px; margin-bottom: 24px; }
        .payment-option { position: relative; }
        .payment-option input[type="radio"] { position: absolute; opacity: 0; }
        .payment-card { display: flex; align-items: center; gap: 16px; padding: 18px 20px; border: 2px solid #e0e0e0; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; background: #fafafa; }
        .payment-option input[type="radio"]:checked + .payment-card { border-color: #aa4242; background: #fff5f5; box-shadow: 0 4px 12px rgba(170, 66, 66, 0.1); }
        .payment-icon { font-size: 28px; }
        .payment-info { flex: 1; }
        .payment-name { font-size: 16px; font-weight: 600; color: #271a1a; margin-bottom: 4px; }
        .payment-desc { font-size: 13px; color: #666; }
        .radio-indicator { width: 20px; height: 20px; border: 2px solid #e0e0e0; border-radius: 50%; position: relative; transition: all 0.3s ease; }
        .payment-option input[type="radio"]:checked + .payment-card .radio-indicator { border-color: #aa4242; }
        .payment-option input[type="radio"]:checked + .payment-card .radio-indicator::after { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 10px; height: 10px; background: #aa4242; border-radius: 50%; }

        /* Right Column - Order Summary */
        .order-summary-section { background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); position: sticky; top: 20px; height: fit-content; }
        
        .summary-title { font-size: 20px; font-weight: 600; color: #271a1a; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0; }
        
        .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; font-size: 15px; color: #666; }
        .summary-row .label { font-weight: 500; }
        .summary-row .value { font-weight: 600; color: #271a1a; }
        
        .promo-code { margin: 24px 0; padding: 20px 0; border-top: 1px dashed #e0e0e0; border-bottom: 1px dashed #e0e0e0; }
        .promo-input-group { display: flex; gap: 12px; }
        .promo-input { flex: 1; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; }
        .promo-btn { padding: 12px 24px; background: white; border: 2px solid #aa4242; color: #aa4242; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .promo-btn:hover { background: #aa4242; color: white; }
        
        .total-row { display: flex; justify-content: space-between; align-items: center; padding: 24px 0; margin-top: 16px; border-top: 2px solid #f0f0f0; }
        .total-label { font-size: 18px; font-weight: 700; color: #271a1a; }
        .total-amount { font-size: 28px; font-weight: 700; color: #aa4242; }
        
        .checkout-btn { width: 100%; padding: 18px; background: linear-gradient(135deg, #aa4242 0%, #8a3535 100%); color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; margin-top: 24px; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 4px 16px rgba(170, 66, 66, 0.3); font-family: 'Outfit', sans-serif; }
        .checkout-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(170, 66, 66, 0.4); }
        .checkout-btn:active { transform: translateY(0); }
        
        .security-badges { display: flex; align-items: center; justify-content: center; gap: 16px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #f0f0f0; }
        .security-badge { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #666; }
        .security-icon { font-size: 16px; }
        
        .back-to-cart { display: inline-flex; align-items: center; gap: 8px; margin-top: 24px; color: #666; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.3s ease; }
        .back-to-cart:hover { color: #aa4242; transform: translateX(-4px); }

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
            .form-row.two-col { grid-template-columns: 1fr 1fr; }
            .progress-steps { gap: 0; }
        }
        @media (min-width: 1024px) {
            .container { padding-left: 32px; padding-right: 32px; }
            .hamburger { display: none; }
            .nav-menu { display: flex; }
            .logo { font-size: 32px; }
            .footer-content { flex-direction: row; justify-content: space-between; align-items: flex-start; }
            .footer-main { flex: 1; }
            .newsletter { width: 400px; }
            .checkout-grid { grid-template-columns: 1.5fr 1fr; }
        }
        @media (max-width: 640px) {
            .page-title { font-size: 28px; }
            .checkout-form-section, .order-summary-section { padding: 24px; }
            .progress-steps { flex-direction: column; gap: 16px; }
            .step-connector { display: none; }
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

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <div class="container">
            <nav class="breadcrumb-nav">
                <a href="../index.php" class="breadcrumb-link">Home</a>
                <span>/</span>
                <a href="cart.php" class="breadcrumb-link">Cart</a>
                <span>/</span>
                <span class="breadcrumb-current">Checkout</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="checkout-main">
        <div class="checkout-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Secure Checkout</h1>
                <p class="page-subtitle">Complete your purchase securely and safely</p>
            </div>

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step completed">
                    <div class="step-number">✓</div>
                    <div class="step-label">Shopping Cart</div>
                </div>
                <div class="step-connector active"></div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div class="step-label">Checkout</div>
                </div>
                <div class="step-connector"></div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>

            <!-- Checkout Grid -->
            <div class="checkout-grid">
                <!-- Left Column - Form -->
                <div class="checkout-form-section">
                    <form action="../actions/process_payment.php" method="POST" id="checkoutForm">
                        <!-- Shipping Information -->
                        <h2 class="section-title">📍 Shipping Information</h2>
                        
                        <div class="form-row two-col">
                            <div class="form-group">
                                <label class="form-label">First Name <span class="required">*</span></label>
                                <input type="text" name="first_name" class="form-input" required placeholder="John" value="<?php echo htmlspecialchars($first_name); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Last Name <span class="required">*</span></label>
                                <input type="text" name="last_name" class="form-input" required placeholder="Doe" value="<?php echo htmlspecialchars($last_name); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Email Address <span class="required">*</span></label>
                                <input type="email" name="email" class="form-input" required placeholder="john.doe@example.com" value="<?php echo htmlspecialchars($user_details['email']); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Phone Number <span class="required">*</span></label>
                                <input type="tel" name="phone" class="form-input" required placeholder="+233 XX XXX XXXX" value="<?php echo htmlspecialchars($user_details['phone']); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Delivery Address <span class="required">*</span></label>
                                <input type="text" name="address" class="form-input" required placeholder="House number and street name" value="<?php echo htmlspecialchars($address); ?>">
                            </div>
                        </div>

                        <div class="form-row two-col">
                            <div class="form-group">
                                <label class="form-label">City <span class="required">*</span></label>
                                <input type="text" name="city" class="form-input" required placeholder="Accra" value="<?php echo htmlspecialchars($city); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Region <span class="required">*</span></label>
                                <select name="region" class="form-select" required>
                                    <option value="">Select Region</option>
                                    <option value="Greater Accra">Greater Accra</option>
                                    <option value="Ashanti">Ashanti</option>
                                    <option value="Western">Western</option>
                                    <option value="Eastern">Eastern</option>
                                    <option value="Central">Central</option>
                                    <option value="Northern">Northern</option>
                                    <option value="Upper East">Upper East</option>
                                    <option value="Upper West">Upper West</option>
                                    <option value="Volta">Volta</option>
                                    <option value="Brong Ahafo">Brong Ahafo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <h2 class="section-title" style="margin-top: 40px;">💳 Payment Method</h2>
                        
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="mobile_money" checked>
                                <div class="payment-card">
                                    <div class="payment-icon">📱</div>
                                    <div class="payment-info">
                                        <div class="payment-name">Mobile Money</div>
                                        <div class="payment-desc">Pay with MTN, Telecel, or AirtelTigo</div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="card">
                                <div class="payment-card">
                                    <div class="payment-icon">💳</div>
                                    <div class="payment-info">
                                        <div class="payment-name">Credit / Debit Card</div>
                                        <div class="payment-desc">Visa, Mastercard, Verve accepted</div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash">
                                <div class="payment-card">
                                    <div class="payment-icon">💵</div>
                                    <div class="payment-info">
                                        <div class="payment-name">Cash on Delivery</div>
                                        <div class="payment-desc">Pay when you receive your order</div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </div>
                            </label>
                        </div>

                        <a href="cart.php" class="back-to-cart">← Back to Shopping Cart</a>
                    </form>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="order-summary-section">
                    <h2 class="summary-title">Order Summary</h2>
                    
                    <div class="summary-row">
                        <span class="label">Subtotal</span>
                        <span class="value">GHS <?php echo number_format($total, 2); ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="label">Shipping Fee</span>
                        <span class="value" style="color: #4caf50;">Free</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="label">Tax (Included)</span>
                        <span class="value">GHS 0.00</span>
                    </div>

                    <!-- Promo Code -->
                    <div class="promo-code">
                        <div class="promo-input-group">
                            <input type="text" class="promo-input" placeholder="Enter promo code">
                            <button type="button" class="promo-btn">Apply</button>
                        </div>
                    </div>

                    <div class="total-row">
                        <span class="total-label">Total</span>
                        <span class="total-amount">GHS <?php echo number_format($total, 2); ?></span>
                    </div>

                    <button type="submit" form="checkoutForm" name="pay" class="checkout-btn">
                        <span>🔒</span>
                        <span>Complete Secure Payment</span>
                    </button>

                    <div class="security-badges">
                        <div class="security-badge">
                            <span class="security-icon">🔒</span>
                            <span>SSL Encrypted</span>
                        </div>
                        <div class="security-badge">
                            <span class="security-icon">✓</span>
                            <span>Secure Payment</span>
                        </div>
                        <div class="security-badge">
                            <span class="security-icon">🛡️</span>
                            <span>Protected</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Service</a>
                <a href="#" class="footer-link">Refund Policy</a>
                <a href="#" class="footer-link">Contact Support</a>
            </div>
            <p class="copyright">© 2025 AfriConnect. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Form validation
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#d32f2f';
                } else {
                    field.style.borderColor = '#e0e0e0';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });

        // Phone number formatting
        const phoneInput = document.querySelector('input[name="phone"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0 && !value.startsWith('233')) {
                    if (value.startsWith('0')) {
                        value = '233' + value.substring(1);
                    }
                }
                e.target.value = value ? '+' + value : '';
            });
        }
    </script>
</body>
</html>