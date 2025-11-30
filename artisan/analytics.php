<?php
session_start();
include("../controllers/order_controller.php");

if(!isset($_SESSION['user_id']) || !isset($_SESSION['artisan_id'])){
    header("Location: ../view/login.php");
    exit();
}

$artisan_id = $_SESSION['artisan_id'];
$analytics = get_artisan_analytics_ctr($artisan_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Analytics | Artisan Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Reusing styles from dashboard.php */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Outfit', sans-serif; background: #f8f9fa; color: #1a1a1a; }
    .layout-wrapper { display: flex; min-height: 100vh; }
    
    /* Sidebar */
    .sidebar { width: 260px; background: white; border-right: 1px solid #e8e8e8; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 100; left: 0; top: 0; }
    .sidebar-header { padding: 24px; border-bottom: 1px solid #f0f0f0; }
    .logo { font-family: 'Domine', serif; font-size: 24px; font-weight: 700; color: #8B4513; text-decoration: none; }
    .sidebar-nav { padding: 24px 16px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #666; text-decoration: none; font-weight: 500; border-radius: 8px; transition: all 0.3s ease; }
    .nav-link:hover { background: #f8f9fa; color: #8B4513; }
    .nav-link.active { background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); color: white; box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2); }
    .nav-icon { font-size: 18px; width: 24px; text-align: center; }
    .sidebar-footer { padding: 24px; border-top: 1px solid #f0f0f0; }
    .logout-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #d32f2f; text-decoration: none; font-weight: 500; border-radius: 8px; transition: all 0.3s ease; }
    .logout-link:hover { background: #ffebee; }

    /* Main Content */
    .main-content { flex: 1; margin-left: 260px; background: #f8f9fa; min-height: 100vh; display: flex; flex-direction: column; }
    .dashboard-header { background: white; border-bottom: 1px solid #e8e8e8; padding: 16px 40px; display: flex; justify-content: flex-end; align-items: center; position: sticky; top: 0; z-index: 90; }
    .header-right { display: flex; align-items: center; gap: 24px; }
    .notification-icon { position: relative; cursor: pointer; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: #f8f9fa; transition: all 0.3s ease; }
    .notification-icon:hover { background: #8B4513; color: white; }
    .notification-badge { position: absolute; top: -4px; right: -4px; background: #d32f2f; color: white; font-size: 11px; font-weight: 600; padding: 2px 6px; border-radius: 10px; min-width: 18px; text-align: center; }
    .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 8px 16px; border-radius: 10px; transition: background 0.3s ease; }
    .user-profile:hover { background: #f8f9fa; }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px; }
    .user-info h4 { font-size: 14px; font-weight: 600; color: #1a1a1a; }
    .user-info p { font-size: 12px; color: #666; }

    /* Dashboard Container */
    .dashboard-container { padding: 40px; max-width: 1200px; width: 100%; margin: 0 auto; }
    .dashboard-title { font-family: 'Domine', serif; font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
    .dashboard-subtitle { font-size: 15px; color: #666; margin-bottom: 32px; }

    /* Analytics Specific Styles */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px; }
    .stat-card { background: white; padding: 24px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; border: 1px solid transparent; position: relative; overflow: hidden; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); border-color: #8B4513; }
    .stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
    .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .stat-icon.sales { background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); }
    .stat-icon.orders { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); }
    .stat-icon.visitors { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); }
    .stat-icon.conversion { background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); }
    .stat-label { font-size: 14px; color: #666; font-weight: 500; margin-bottom: 8px; }
    .stat-value { font-size: 28px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; }
    .stat-change { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; }
    .stat-change.positive { color: #2e7d32; background: #e8f5e9; }
    .stat-change.negative { color: #d32f2f; background: #ffebee; }

    .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 32px; }
    .chart-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); }
    .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .chart-title { font-size: 18px; font-weight: 600; color: #1a1a1a; }
    .chart-placeholder { height: 300px; background: #f8f9fa; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 14px; border: 2px dashed #e0e0e0; }

    .top-products-list { display: flex; flex-direction: column; gap: 16px; }
    .product-rank-item { display: flex; align-items: center; gap: 16px; padding: 12px; border-radius: 12px; background: #f8f9fa; }
    .rank-number { width: 24px; height: 24px; background: #8B4513; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
    .product-rank-info { flex: 1; }
    .product-rank-name { font-size: 14px; font-weight: 600; color: #1a1a1a; }
    .product-rank-sales { font-size: 12px; color: #666; }
    .product-rank-revenue { font-weight: 700; color: #8B4513; font-size: 14px; }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar { width: 80px; }
      .logo, .nav-link span:not(.nav-icon), .logout-link span:not(.nav-icon) { display: none; }
      .main-content { margin-left: 80px; }
      .charts-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); width: 260px; }
      .sidebar.active { transform: translateX(0); }
      .main-content { margin-left: 0; }
      .stats-grid { grid-template-columns: 1fr; }
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
        <a href="dashboard.php" class="nav-link">
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
        <a href="analytics.php" class="nav-link active">
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

      <div class="dashboard-container">
        <h1 class="dashboard-title">Analytics Overview</h1>
        <p class="dashboard-subtitle">Detailed insights into your shop's performance.</p>

        <!-- Stats Grid -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-header">
              <div>
                <div class="stat-label">Total Revenue</div>
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
              <div class="stat-icon orders">🛍️</div>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-header">
              <div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value"><?php echo $analytics['pending_orders']; ?></div>
                <span class="stat-change negative">Action Required</span>
              </div>
              <div class="stat-icon visitors">⏳</div>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-header">
              <div>
                <div class="stat-label">Avg. Order Value</div>
                <div class="stat-value">GH₵ <?php echo $analytics['total_orders'] > 0 ? number_format($analytics['total_revenue'] / $analytics['total_orders'], 2) : '0.00'; ?></div>
                <span class="stat-change positive">Lifetime</span>
              </div>
              <div class="stat-icon conversion">⚖</div>
            </div>
          </div>
        </div>

        <!-- Charts Grid -->
        <div class="charts-grid">
          <div class="chart-card">
            <div class="chart-header">
              <h3 class="chart-title">Revenue Over Time</h3>
              <select style="padding: 8px; border-radius: 6px; border: 1px solid #e0e0e0;">
                <option>Last 7 Days</option>
                <option>Last 30 Days</option>
                <option>This Year</option>
              </select>
            </div>
            <div class="chart-placeholder">
              [Revenue Chart Visualization - Coming Soon]
            </div>
          </div>

          <div class="chart-card">
            <div class="chart-header">
              <h3 class="chart-title">Top Products</h3>
            </div>
            <div class="top-products-list">
              <?php if(!empty($analytics['top_products'])): ?>
                <?php $rank = 1; foreach($analytics['top_products'] as $product): ?>
                  <div class="product-rank-item">
                    <div class="rank-number"><?php echo $rank++; ?></div>
                    <div class="product-rank-info">
                      <div class="product-rank-name"><?php echo htmlspecialchars($product['name']); ?></div>
                      <div class="product-rank-sales"><?php echo $product['total_sold']; ?> sold</div>
                    </div>
                    <div class="product-rank-revenue">GH₵ <?php echo number_format($product['revenue'], 2); ?></div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p style="text-align: center; color: #666;">No sales data yet.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
