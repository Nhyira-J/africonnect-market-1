<?php
session_start();
include("../controllers/delivery_rider_controller.php");

// Check if user is logged in and is an artisan
// if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'artisan'){
//     header("Location: ../view/login.php");
//     exit();
// }

// Fetch artisan_id (mock or from session)
if(isset($_SESSION['artisan_id'])){
    $real_artisan_id = $_SESSION['artisan_id'];
} else {
    // Fallback/Mock for development if session not set
    $real_artisan_id = 1; 
}

$location_filter = isset($_GET['location']) ? $_GET['location'] : '';
$vehicle_filter = isset($_GET['vehicle_type']) ? $_GET['vehicle_type'] : '';

if($location_filter || $vehicle_filter){
    $riders = filter_riders_ctr($location_filter, $vehicle_filter);
} else {
    $riders = view_all_riders_ctr();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery Riders | AfriConnect</title>
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
      justify-content: flex-end;
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

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
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
    }

    /* Card Grid */
    .riders-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 24px;
    }

    .rider-card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .rider-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 24px rgba(139, 69, 19, 0.15);
    }

    .rider-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 80px;
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      z-index: 0;
    }

    .rider-image-container {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      padding: 4px;
      background: white;
      position: relative;
      z-index: 1;
      margin-top: 20px;
      margin-bottom: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .rider-image {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      background: #f0f0f0;
    }

    .rider-initials {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      font-weight: 700;
      color: #8B4513;
    }

    .rider-name {
      font-size: 18px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 4px;
      z-index: 1;
    }

    .rider-vehicle {
      font-size: 14px;
      color: #666;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
      z-index: 1;
    }

    .rider-details {
      width: 100%;
      padding-top: 16px;
      border-top: 1px solid #f0f0f0;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .detail-item {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      color: #444;
      text-align: left;
    }

    .detail-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      color: #8B4513;
    }

    .status-badge {
      position: absolute;
      top: 16px;
      right: 16px;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      z-index: 1;
      background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .status-badge.available { color: #2e7d32; }
    .status-badge.busy { color: #f57c00; }
    .status-badge.offline { color: #d32f2f; }

    .contact-btn {
      width: 100%;
      padding: 12px;
      background: #8B4513;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      margin-top: 16px;
      cursor: pointer;
      transition: background 0.3s;
      text-decoration: none;
      display: block;
    }

    .contact-btn:hover {
      background: #A0522D;
    }

    /* Filter Styles */
    .filter-container {
        display: flex;
        gap: 16px;
        margin-bottom: 32px;
        background: white;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-select {
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        color: #333;
        outline: none;
        transition: all 0.3s;
        background: #f8f9fa;
    }

    .filter-select:focus {
        border-color: #8B4513;
        background: white;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
    }

    .filter-btn {
        padding: 12px 32px;
        background: #8B4513;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        height: 45px;
    }

    .filter-btn:hover {
        background: #A0522D;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2);
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar { width: 80px; }
      .sidebar-header { padding: 24px 12px; text-align: center; }
      .logo { display: none; }
      .sidebar-header::after { content: 'AC'; font-family: 'Domine', serif; font-weight: 700; color: #8B4513; font-size: 24px; }
      .nav-link span:not(.nav-icon), .logout-link span:not(.nav-icon) { display: none; }
      .nav-link, .logout-link { justify-content: center; padding: 12px; }
      .main-content { margin-left: 80px; }
    }

    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); width: 260px; }
      .sidebar.active { transform: translateX(0); }
      .main-content { margin-left: 0; }
      .riders-grid { grid-template-columns: 1fr; }
      .filter-container { flex-direction: column; align-items: stretch; }
      .filter-btn { width: 100%; }
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
        <a href="analytics.php" class="nav-link">
          <span class="nav-icon">📈</span>
          <span>Analytics</span>
        </a>
        <a href="settings.php" class="nav-link">
          <span class="nav-icon">⚙️</span>
          <span>Settings</span>
        </a>
        <a href="delivery_riders.php" class="nav-link active">
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
        <div class="page-header">
            <div>
                <h1 class="dashboard-title">Delivery Riders</h1>
                <p class="dashboard-subtitle">Find and connect with delivery partners.</p>
            </div>
        </div>

        <!-- Filter Section -->
        <form method="GET" class="filter-container">
            <div class="filter-group">
                <label class="filter-label">Location</label>
                <input type="text" name="location" class="filter-select" placeholder="Enter location..." value="<?php echo htmlspecialchars($location_filter); ?>">
            </div>
            <div class="filter-group">
                <label class="filter-label">Vehicle Type</label>
                <select name="vehicle_type" class="filter-select">
                    <option value="">All Vehicles</option>
                    <option value="Bike" <?php if($vehicle_filter == 'Bike') echo 'selected'; ?>>Bike</option>
                    <option value="Motorcycle" <?php if($vehicle_filter == 'Motorcycle') echo 'selected'; ?>>Motorcycle</option>
                    <option value="Van" <?php if($vehicle_filter == 'Van') echo 'selected'; ?>>Van</option>
                    <option value="Truck" <?php if($vehicle_filter == 'Truck') echo 'selected'; ?>>Truck</option>
                </select>
            </div>
            <button type="submit" class="filter-btn">Filter Riders</button>
        </form>

        <div class="riders-grid">
            <?php if($riders): ?>
                <?php foreach($riders as $rider): ?>
                <div class="rider-card">
                    <div class="status-badge <?php echo $rider['status']; ?>">
                        <?php echo ucfirst($rider['status']); ?>
                    </div>
                    
                    <div class="rider-image-container">
                        <?php if(!empty($rider['rider_image'])): ?>
                            <img src="<?php echo htmlspecialchars($rider['rider_image']); ?>" alt="<?php echo htmlspecialchars($rider['name']); ?>" class="rider-image">
                        <?php else: ?>
                            <div class="rider-initials">
                                <?php echo strtoupper(substr($rider['name'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h3 class="rider-name"><?php echo htmlspecialchars($rider['name']); ?></h3>
                    <div class="rider-vehicle">
                        <span>🛵</span>
                        <?php echo htmlspecialchars($rider['vehicle_type']); ?>
                    </div>

                    <div class="rider-details">
                        <div class="detail-item">
                            <div class="detail-icon">📍</div>
                            <span><?php echo htmlspecialchars($rider['location']); ?></span>
                        </div>
                        <div class="detail-item">
                            <div class="detail-icon">📞</div>
                            <span><?php echo htmlspecialchars($rider['phone']); ?></span>
                        </div>
                        <div class="detail-item">
                            <div class="detail-icon">✉️</div>
                            <span style="font-size: 13px;"><?php echo htmlspecialchars($rider['email']); ?></span>
                        </div>
                    </div>

                    <a href="tel:<?php echo htmlspecialchars($rider['phone']); ?>" class="contact-btn">
                        Call Rider
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: white; border-radius: 16px; color: #666;">
                    <div style="font-size: 48px; margin-bottom: 16px;">🛵</div>
                    <h3>No Delivery Riders Found</h3>
                    <p>Try adjusting your filters to find more riders.</p>
                </div>
            <?php endif; ?>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
