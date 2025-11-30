<?php
session_start();
include("../controllers/customer_controller.php");

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../view/login.php");
    exit();
}

$unverified_artisans = get_unverified_artisans_ctr();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Artisans | AfriConnect Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Outfit', sans-serif; background: #f8f9fa; color: #1a1a1a; }
    .layout-wrapper { display: flex; min-height: 100vh; }

    /* Sidebar Styles */
    .sidebar { width: 260px; background: #1a1a1a; color: white; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 100; left: 0; top: 0; }
    .sidebar-header { padding: 24px; border-bottom: 1px solid #333; }
    .logo { font-family: 'Domine', serif; font-size: 24px; font-weight: 700; color: white; text-decoration: none; }
    .sidebar-nav { padding: 24px 16px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #aaa; text-decoration: none; font-weight: 500; border-radius: 8px; transition: all 0.3s ease; }
    .nav-link:hover { background: #333; color: white; }
    .nav-link.active { background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); color: white; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); }
    .nav-icon { font-size: 18px; width: 24px; text-align: center; }
    .sidebar-footer { padding: 24px; border-top: 1px solid #333; }
    .logout-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #ff6b6b; text-decoration: none; font-weight: 500; border-radius: 8px; transition: all 0.3s ease; }
    .logout-link:hover { background: rgba(255, 107, 107, 0.1); }

    /* Main Content */
    .main-content { flex: 1; margin-left: 260px; background: #f8f9fa; min-height: 100vh; display: flex; flex-direction: column; }
    .dashboard-header { background: white; border-bottom: 1px solid #e8e8e8; padding: 16px 40px; display: flex; justify-content: flex-end; align-items: center; position: sticky; top: 0; z-index: 90; }
    .admin-profile { display: flex; align-items: center; gap: 12px; padding: 8px 16px; border-radius: 10px; background: #f8f9fa; }
    .admin-avatar { width: 40px; height: 40px; border-radius: 50%; background: #333; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px; }
    .admin-info h4 { font-size: 14px; font-weight: 600; color: #1a1a1a; }
    .admin-info p { font-size: 12px; color: #666; }

    /* Page Content */
    .dashboard-container { padding: 40px; max-width: 1200px; width: 100%; margin: 0 auto; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
    .dashboard-title { font-family: 'Domine', serif; font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
    .dashboard-subtitle { font-size: 15px; color: #666; }

    .card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); }
    .table { width: 100%; border-collapse: collapse; }
    .table th { text-align: left; padding: 12px; font-size: 12px; color: #666; text-transform: uppercase; border-bottom: 1px solid #eee; }
    .table td { padding: 16px 12px; font-size: 14px; border-bottom: 1px solid #f9f9f9; color: #333; }
    .table tr:last-child td { border-bottom: none; }
    
    .action-btn { padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; margin-right: 8px; display: inline-block; cursor: pointer; border: none; }
    .action-btn.verify { background: #e8f5e9; color: #2e7d32; }
    .action-btn.verify:hover { background: #c8e6c9; }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar { width: 80px; }
      .sidebar-header { padding: 24px 12px; text-align: center; }
      .logo { display: none; }
      .sidebar-header::after { content: 'AC'; font-family: 'Domine', serif; font-weight: 700; color: white; font-size: 24px; }
      .nav-link span:not(.nav-icon), .logout-link span:not(.nav-icon) { display: none; }
      .nav-link, .logout-link { justify-content: center; padding: 12px; }
      .main-content { margin-left: 80px; }
    }
  </style>
</head>
<body>
  <div class="layout-wrapper">
    <aside class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="logo">AfriConnect</a>
      </div>
      <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-link">
          <span class="nav-icon">📊</span>
          <span>Dashboard</span>
        </a>
        <a href="manage_users.php" class="nav-link">
          <span class="nav-icon">👥</span>
          <span>Manage Users</span>
        </a>
        <a href="delivery_riders.php" class="nav-link">
          <span class="nav-icon">🛵</span>
          <span>Delivery Riders</span>
        </a>
        <a href="verify_artisans.php" class="nav-link active">
          <span class="nav-icon">✅</span>
          <span>Verify Artisans</span>
        </a>
        <a href="category.php" class="nav-link">
          <span class="nav-icon">🏷️</span>
          <span>Categories</span>
        </a>
        <a href="orders.php" class="nav-link">
          <span class="nav-icon">🛍️</span>
          <span>Orders</span>
        </a>
        <a href="#" class="nav-link">
          <span class="nav-icon">⚙️</span>
          <span>Settings</span>
        </a>
      </nav>
      <div class="sidebar-footer">
        <a href="../actions/logout.php" class="logout-link">
          <span class="nav-icon">🚪</span>
          <span>Logout</span>
        </a>
      </div>
    </aside>

    <main class="main-content">
      <header class="dashboard-header">
        <div class="header-right">
          <div class="admin-profile">
            <div class="admin-avatar">AD</div>
            <div class="admin-info">
              <h4>Administrator</h4>
              <p>Super Admin</p>
            </div>
          </div>
        </div>
      </header>

      <div class="dashboard-container">
        <div class="page-header">
            <div>
                <h1 class="dashboard-title">Verify Artisans</h1>
                <p class="dashboard-subtitle">Review and verify new artisan registrations.</p>
            </div>
        </div>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Owner Name</th>
                        <th>Email</th>
                        <th>Bio</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($unverified_artisans): ?>
                        <?php foreach($unverified_artisans as $artisan): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 600;"><?php echo htmlspecialchars($artisan['business_name']); ?></div>
                            </td>
                            <td><?php echo htmlspecialchars($artisan['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($artisan['email']); ?></td>
                            <td><?php echo htmlspecialchars(substr($artisan['bio'], 0, 50)) . '...'; ?></td>
                            <td>
                                <form action="../actions/verify_artisan_action.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="artisan_id" value="<?php echo $artisan['artisan_id']; ?>">
                                    <button type="submit" name="verify" class="action-btn verify">Verify</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #666;">
                                No pending verifications.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
