<?php
session_start();
include("../controllers/order_controller.php");

if(!isset($_SESSION['user_id']) || !isset($_SESSION['artisan_id'])){
    header("Location: ../view/login.php");
    exit();
}

$artisan_id = $_SESSION['artisan_id'];
$analytics = get_artisan_analytics_ctr($artisan_id);
$recent_orders = get_orders_by_artisan_ctr($artisan_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Artisan Dashboard | AfriConnect</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Outfit', sans-serif;
      background: #f8f9fa;
      color: #1a1a1a;
    }

    /* Layout Wrapper */
    .layout-wrapper {
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 260px;
      background: white;
      border-right: 1px solid #e8e8e8;
      display: flex;
      flex-direction: column;
      position: fixed;
      height: 100vh;
      z-index: 100;
      left: 0;
      top: 0;
    }

    .sidebar-header {
      padding: 24px;
      border-bottom: 1px solid #f0f0f0;
    }

    .logo {
      font-family: 'Domine', serif;
      font-size: 24px;
      font-weight: 700;
      color: #8B4513;
      text-decoration: none;
    }

    .sidebar-nav {
      padding: 24px 16px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      color: #666;
      text-decoration: none;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .nav-link:hover {
      background: #f8f9fa;
      color: #8B4513;
    }

    .nav-link.active {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      color: white;
      box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2);
    }

    .nav-icon {
      font-size: 18px;
      width: 24px;
      text-align: center;
    }

    .sidebar-footer {
      padding: 24px;
      border-top: 1px solid #f0f0f0;
    }

    .logout-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      color: #d32f2f;
      text-decoration: none;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .logout-link:hover {
      background: #ffebee;
    }

    /* Main Content Area */
    .main-content {
      flex: 1;
      margin-left: 260px;
      background: #f8f9fa;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Header */
    .dashboard-header {
      background: white;
      border-bottom: 1px solid #e8e8e8;
      padding: 16px 40px;
      display: flex;
      justify-content: flex-end; /* Aligned to right since logo is in sidebar */
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 90;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 24px;
    }

    .notification-icon {
      position: relative;
      cursor: pointer;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      background: #f8f9fa;
      transition: all 0.3s ease;
    }

    .notification-icon:hover {
      background: #8B4513;
      color: white;
    }

    .notification-badge {
      position: absolute;
      top: -4px;
      right: -4px;
      background: #d32f2f;
      color: white;
      font-size: 11px;
      font-weight: 600;
      padding: 2px 6px;
      border-radius: 10px;
      min-width: 18px;
      text-align: center;
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      padding: 8px 16px;
      border-radius: 10px;
      transition: background 0.3s ease;
    }

    .user-profile:hover {
      background: #f8f9fa;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 16px;
    }

    .user-info h4 {
      font-size: 14px;
      font-weight: 600;
      color: #1a1a1a;
    }

    .user-info p {
      font-size: 12px;
      color: #666;
    }

    /* Dashboard Container */
    .dashboard-container {
      padding: 40px;
      max-width: 1200px;
      width: 100%;
      margin: 0 auto;
    }

    .dashboard-title {
      font-family: 'Domine', serif;
      font-size: 32px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 8px;
    }

    .dashboard-subtitle {
      font-size: 15px;
      color: #666;
      margin-bottom: 32px;
    }

    /* Time Period Tabs */
    .time-period-tabs {
      display: flex;
      gap: 12px;
      margin-bottom: 32px;
      background: white;
      padding: 8px;
      border-radius: 12px;
      width: fit-content;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .tab {
      padding: 10px 24px;
      border: none;
      background: transparent;
      font-family: 'Outfit', sans-serif;
      font-size: 14px;
      font-weight: 500;
      color: #666;
      cursor: pointer;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .tab.active {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      color: white;
      box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2);
    }

    .tab:hover:not(.active) {
      background: #f8f9fa;
      color: #8B4513;
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 24px;
      margin-bottom: 32px;
    }

    .stat-card {
      background: white;
      padding: 24px;
      border-radius: 16px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
      border: 1px solid transparent;
      position: relative;
      overflow: hidden;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, #8B4513 0%, #D2691E 100%);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      border-color: #8B4513;
    }

    .stat-card:hover::before {
      transform: scaleX(1);
    }

    .stat-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 16px;
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    .stat-icon.sales { background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); }
    .stat-icon.orders { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); }
    .stat-icon.pending { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); }
    .stat-icon.revenue { background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); }

    .stat-label {
      font-size: 14px;
      color: #666;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .stat-value {
      font-size: 28px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 12px;
    }

    .stat-change {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 12px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 6px;
    }

    .stat-change.positive { color: #2e7d32; background: #e8f5e9; }
    .stat-change.negative { color: #d32f2f; background: #ffebee; }

    /* Content Grid */
    .content-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 24px;
      margin-bottom: 32px;
    }

    /* Card Styles */
    .card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 16px;
      border-bottom: 1px solid #f0f0f0;
    }

    .card-title {
      font-size: 18px;
      font-weight: 600;
      color: #1a1a1a;
    }

    .view-all {
      font-size: 14px;
      color: #8B4513;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .view-all:hover {
      color: #A0522D;
      transform: translateX(4px);
    }

    /* Top Products */
    .product-item {
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 12px;
      border-radius: 12px;
      transition: all 0.3s ease;
      margin-bottom: 8px;
    }

    .product-item:hover {
      background: #f8f9fa;
    }

    .product-image {
      width: 50px;
      height: 50px;
      border-radius: 10px;
      background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      flex-shrink: 0;
    }

    .product-info { flex: 1; }
    .product-name { font-size: 14px; font-weight: 600; color: #1a1a1a; margin-bottom: 4px; }
    .product-sales { font-size: 12px; color: #666; }
    .product-revenue { font-size: 14px; font-weight: 700; color: #8B4513; }

    /* Notifications */
    .notification-item {
      display: flex;
      gap: 12px;
      padding: 12px;
      border-radius: 12px;
      transition: all 0.3s ease;
      margin-bottom: 8px;
      border-left: 3px solid transparent;
    }

    .notification-item:hover { background: #f8f9fa; }
    .notification-item.unread { background: #fef7f0; border-left-color: #8B4513; }

    .notification-icon-wrapper {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .notification-icon-wrapper.order { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); }
    .notification-icon-wrapper.message { background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); }
    .notification-icon-wrapper.alert { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); }

    .notification-content { flex: 1; }
    .notification-title { font-size: 13px; font-weight: 600; color: #1a1a1a; margin-bottom: 2px; }
    .notification-text { font-size: 12px; color: #666; margin-bottom: 2px; }
    .notification-time { font-size: 11px; color: #999; }

    /* Recent Orders */
    .orders-section { grid-column: 1 / -1; }

    .orders-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 8px;
    }

    .orders-table thead th {
      text-align: left;
      font-size: 12px;
      font-weight: 600;
      color: #666;
      padding: 12px 16px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .orders-table tbody tr {
      background: #fafafa;
      transition: all 0.3s ease;
    }

    .orders-table tbody tr:hover {
      background: #f0f0f0;
      transform: scale(1.005);
    }

    .orders-table tbody td {
      padding: 16px;
      font-size: 14px;
      border-top: 1px solid #f0f0f0;
      border-bottom: 1px solid #f0f0f0;
    }

    .orders-table tbody td:first-child {
      border-left: 1px solid #f0f0f0;
      border-radius: 12px 0 0 12px;
    }

    .orders-table tbody td:last-child {
      border-right: 1px solid #f0f0f0;
      border-radius: 0 12px 12px 0;
    }

    .order-id { font-weight: 600; color: #8B4513; }

    .status-badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 600;
    }

    .status-badge.pending { background: #fff3e0; color: #f57c00; }
    .status-badge.processing { background: #e3f2fd; color: #1976d2; }
    .status-badge.shipped { background: #f3e5f5; color: #7b1fa2; }
    .status-badge.delivered { background: #e8f5e9; color: #2e7d32; }

    /* Quick Actions */
    .quick-actions {
      display: flex;
      gap: 12px;
      margin-bottom: 32px;
    }

    .action-btn {
      padding: 12px 24px;
      border: 2px solid #8B4513;
      background: white;
      color: #8B4513;
      font-family: 'Outfit', sans-serif;
      font-size: 14px;
      font-weight: 600;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .action-btn:hover {
      background: #8B4513;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2);
    }

    .action-btn.primary {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      color: white;
      border: none;
    }

    .action-btn.primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3);
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar {
        width: 80px;
      }
      .sidebar-header {
        padding: 24px 12px;
        text-align: center;
      }
      .logo {
        font-size: 14px;
        display: none; /* Hide text logo on tablet */
      }
      .sidebar-header::after {
        content: 'AC';
        font-family: 'Domine', serif;
        font-weight: 700;
        color: #8B4513;
        font-size: 24px;
      }
      .nav-link span:not(.nav-icon), .logout-link span:not(.nav-icon) {
        display: none;
      }
      .nav-link, .logout-link {
        justify-content: center;
        padding: 12px;
      }
      .main-content {
        margin-left: 80px;
      }
      .content-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        width: 260px;
      }
      .sidebar.active {
        transform: translateX(0);
      }
      .main-content {
        margin-left: 0;
      }
      .dashboard-header {
        justify-content: space-between;
      }
      .menu-toggle {
        display: block;
      }
      .stats-grid {
        grid-template-columns: 1fr;
      }
      .quick-actions {
        flex-direction: column;
      }
      .orders-table {
        display: block;
        overflow-x: auto;
      }
    }
  </style>
</head>
<body>
  <div class="layout-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="logo">AfriConnect</a>
      </div>
      
      <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-link active">
          <span class="nav-icon">📊</span>
          <span>Dashboard</span>
        </a>
        <a href="product.php" class="nav-link">
          <span class="nav-icon">📦</span>
          <span>Products</span>
        </a>
        <a href="orders.php" class="nav-link">
          <span class="nav-icon">🛍️</span>
          <span>Orders</span>
        </a>  
        <a href="messages.php" class="nav-link">
          <span class="nav-icon">💬</span>
          <span>Messages</span>
        </a>
        <a href="analytics.php" class="nav-link">
          <span class="nav-icon">📈</span>
          <span>Analytics</span>
        </a>
        <a href="settings.php" class="nav-link">
          <span class="nav-icon">⚙️</span>
          <span>Settings</span>
        </a>
        <a href="delivery_riders.php" class="nav-link">
          <span class="nav-icon">🛵</span>
          <span>Delivery Riders</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <a href="../actions/logout.php" class="logout-link">
          <span class="nav-icon">🚪</span>
          <span>Logout</span>
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Header -->
      <header class="dashboard-header">
        <div class="header-right">
          <div class="notification-icon">
            <span>🔔</span>
            <span class="notification-badge">5</span>
          </div>
          <div class="user-profile">
            <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 2)); ?></div>
            <div class="user-info">
              <h4><?php echo htmlspecialchars($_SESSION['user_name']); ?></h4>
              <p>Artisan</p>
            </div>
          </div>
        </div>
      </header>

      <!-- Dashboard Content -->
      <div class="dashboard-container">
        <h1 class="dashboard-title">Dashboard Overview</h1>
        <p class="dashboard-subtitle">Welcome back! Here's what's happening with your shop today.</p>

        <!-- Quick Actions -->
        <div class="quick-actions">
          <button class="action-btn primary">
            <span>➕</span> Add New Product
          </button>
          <button class="action-btn">
            <span>📦</span> Manage Inventory
          </button>
          <button class="action-btn">
            <span>💬</span> Messages (3)
          </button>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-header">
              <div>
                <div class="stat-label">Total Sales</div>
                <div class="stat-value">GH₵ <?php echo number_format($analytics['total_revenue'], 2); ?></div>
                <span class="stat-change positive">Lifetime</span>
              </div>
              <div class="stat-icon sales">💰</div>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-header">
              <div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value"><?php echo $analytics['total_orders']; ?></div>
                <span class="stat-change positive">Lifetime</span>
              </div>
              <div class="stat-icon orders">📊</div>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-header">
              <div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value"><?php echo $analytics['pending_orders']; ?></div>
                <span class="stat-change negative">Action Required</span>
              </div>
              <div class="stat-icon pending">⏳</div>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-header">
              <div>
                <div class="stat-label">Revenue</div>
                <div class="stat-value">GH₵ <?php echo number_format($analytics['total_revenue'], 2); ?></div>
                <span class="stat-change positive">Lifetime</span>
              </div>
              <div class="stat-icon revenue">📈</div>
            </div>
          </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
          <!-- Top Selling Products -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Top Selling Products</h3>
              <a href="analytics.php" class="view-all">View All →</a>
            </div>
            
            </div>

          <!-- Notifications -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Recent Notifications</h3>
              <a href="#" class="view-all">View All →</a>
            </div>

            <div class="notification-item unread">
              <div class="notification-icon-wrapper order">📦</div>
              <div class="notification-content">
                <div class="notification-title">New Order Received</div>
                <div class="notification-text">Order #ORD-2847 for Hand-Carved Mask</div>
                <div class="notification-time">5 minutes ago</div>
              </div>
            </div>

            <div class="notification-item unread">
              <div class="notification-icon-wrapper message">💬</div>
              <div class="notification-content">
                <div class="notification-title">New Message</div>
                <div class="notification-text">Customer inquiry about pottery set</div>
                <div class="notification-time">15 minutes ago</div>
              </div>
            </div>

            <div class="notification-item unread">
              <div class="notification-icon-wrapper order">📦</div>
              <div class="notification-content">
                <div class="notification-title">Order Delivered</div>
                <div class="notification-text">Order #ORD-2832 marked as delivered</div>
                <div class="notification-time">1 hour ago</div>
              </div>
            </div>

            <div class="notification-item">
              <div class="notification-icon-wrapper alert">⭐</div>
              <div class="notification-content">
                <div class="notification-title">New Review</div>
                <div class="notification-text">5-star review on Kente Cloth Fabric</div>
                <div class="notification-time">2 hours ago</div>
              </div>
            </div>

            <div class="notification-item">
              <div class="notification-icon-wrapper message">💬</div>
              <div class="notification-content">
                <div class="notification-title">New Message</div>
                <div class="notification-text">Custom order request from premium buyer</div>
                <div class="notification-time">3 hours ago</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Orders -->
        <div class="card orders-section">
          <div class="card-header">
            <h3 class="card-title">Recent Orders</h3>
            <a href="#" class="view-all">View All Orders →</a>
          </div>

          <table class="orders-table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="order-id">#ORD-2847</td>
                <td>Ama Mensah</td>
                <td>Hand-Carved Wooden Mask</td>
                <td>Nov 23, 2025</td>
                <td>GH₵ 250</td>
                <td><span class="status-badge pending">Pending</span></td>
              </tr>
              <tr>
                <td class="order-id">#ORD-2846</td>
                <td>Kofi Owusu</td>
                <td>Traditional Pottery Set</td>
                <td>Nov 23, 2025</td>
                <td>GH₵ 180</td>
                <td><span class="status-badge processing">Processing</span></td>
              </tr>
              <tr>
                <td class="order-id">#ORD-2845</td>
                <td>Abena Osei</td>
                <td>Kente Cloth Fabric</td>
                <td>Nov 22, 2025</td>
                <td>GH₵ 320</td>
                <td><span class="status-badge shipped">Shipped</span></td>
              </tr>
              <tr>
                <td class="order-id">#ORD-2844</td>
                <td>Yaw Boateng</td>
                <td>Abstract Painting Canvas</td>
                <td>Nov 22, 2025</td>
                <td>GH₵ 450</td>
                <td><span class="status-badge delivered">Delivered</span></td>
              </tr>
              <tr>
                <td class="order-id">#ORD-2843</td>
                <td>Efua Asante</td>
                <td>Handmade Beaded Jewelry</td>
                <td>Nov 21, 2025</td>
                <td>GH₵ 95</td>
                <td><span class="status-badge delivered">Delivered</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Time period tabs functionality
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
      tab.addEventListener('click', function() {
        tabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        // Here you would typically fetch new data based on the selected period
      });
    });
  </script>
</body>
</html>