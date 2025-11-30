<?php
session_start();
include("../controllers/customer_controller.php");

if(!isset($_SESSION['user_id']) || !isset($_SESSION['artisan_id'])){
    header("Location: ../view/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$message_type = "";

// Handle Form Submission
if(isset($_POST['update_profile'])){
    $business_name = $_POST['business_name'];
    $bio = $_POST['bio'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    if(update_artisan_profile_ctr($user_id, $business_name, $bio, $phone, $address)){
        $message = "Profile updated successfully!";
        $message_type = "success";
    } else {
        $message = "Failed to update profile.";
        $message_type = "error";
    }
}

// Fetch Current Details
$artisan = get_artisan_details_ctr($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings | Artisan Dashboard</title>
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

    /* Settings Specific Styles */
    .settings-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 40px; }
    .settings-nav { background: white; border-radius: 16px; padding: 24px; height: fit-content; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); }
    .settings-nav-item { display: block; padding: 12px 16px; color: #666; text-decoration: none; font-weight: 500; border-radius: 8px; margin-bottom: 8px; transition: all 0.3s ease; }
    .settings-nav-item:hover { background: #f8f9fa; color: #8B4513; }
    .settings-nav-item.active { background: #fff3e0; color: #8B4513; font-weight: 600; }

    .settings-content { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); }
    .section-title { font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #f0f0f0; }
    
    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 14px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px; }
    .form-input { width: 100%; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 15px; transition: all 0.3s ease; }
    .form-input:focus { border-color: #8B4513; outline: none; box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1); }
    .form-textarea { width: 100%; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 15px; min-height: 120px; resize: vertical; transition: all 0.3s ease; }
    .form-textarea:focus { border-color: #8B4513; outline: none; box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1); }

    .profile-upload { display: flex; align-items: center; gap: 24px; margin-bottom: 32px; }
    .current-avatar { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 700; }
    .upload-btn { padding: 10px 20px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; font-weight: 600; color: #666; transition: all 0.3s ease; }
    .upload-btn:hover { border-color: #8B4513; color: #8B4513; }

    .save-btn { padding: 14px 32px; background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s ease; }
    .save-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3); }
    
    .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500; }
    .alert.success { background: #e8f5e9; color: #2e7d32; }
    .alert.error { background: #ffebee; color: #d32f2f; }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar { width: 80px; }
      .logo, .nav-link span:not(.nav-icon), .logout-link span:not(.nav-icon) { display: none; }
      .main-content { margin-left: 80px; }
      .settings-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); width: 260px; }
      .sidebar.active { transform: translateX(0); }
      .main-content { margin-left: 0; }
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
        <a href="settings.php" class="nav-link active">
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
            <div class="user-avatar"><?php echo strtoupper(substr($artisan['full_name'], 0, 2)); ?></div>
            <div class="user-info">
              <h4><?php echo htmlspecialchars($artisan['full_name']); ?></h4>
              <p>Artisan</p>
            </div>
          </div>
        </div>
      </header>

      <div class="dashboard-container">
        <h1 class="dashboard-title">Settings</h1>
        <p class="dashboard-subtitle">Manage your account and store preferences.</p>

        <div class="settings-grid">
          <!-- Settings Nav -->
          <div class="settings-nav">
            <a href="#" class="settings-nav-item active">General Profile</a>
            <a href="#" class="settings-nav-item">Security</a>
            <a href="#" class="settings-nav-item">Notifications</a>
            <a href="#" class="settings-nav-item">Payment Methods</a>
          </div>

          <!-- Settings Content -->
          <div class="settings-content">
            <h2 class="section-title">General Profile</h2>
            
            <?php if($message): ?>
                <div class="alert <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
              <div class="profile-upload">
                <div class="current-avatar"><?php echo strtoupper(substr($artisan['full_name'], 0, 2)); ?></div>
                <div>
                  <h4 style="margin-bottom: 8px; color: #1a1a1a;">Profile Picture</h4>
                  <button type="button" class="upload-btn">Upload New</button>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Business Name</label>
                <input type="text" name="business_name" class="form-input" value="<?php echo htmlspecialchars($artisan['business_name']); ?>" placeholder="Enter business name">
              </div>

              <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" value="<?php echo htmlspecialchars($artisan['email']); ?>" disabled style="background: #f0f0f0; cursor: not-allowed;">
              </div>

              <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-input" value="<?php echo htmlspecialchars($artisan['phone']); ?>" placeholder="Enter phone number">
              </div>
              
              <div class="form-group">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-input" value="<?php echo htmlspecialchars($artisan['address']); ?>" placeholder="Enter address">
              </div>

              <div class="form-group">
                <label class="form-label">Bio / Description</label>
                <textarea name="bio" class="form-textarea" placeholder="Tell us about your craft..."><?php echo htmlspecialchars($artisan['bio']); ?></textarea>
              </div>

              <button type="submit" name="update_profile" class="save-btn">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
