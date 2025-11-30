<?php
require_once '../settings/core.php';
require_once '../actions/fetch_category_action.php';

// Redirect if not logged in or not admin
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../view/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Categories | AfriConnect Admin</title>
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

    /* Form Styles */
    .form-control { padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Outfit', sans-serif; width: 100%; max-width: 300px; }
    .btn-primary { padding: 10px 20px; background: #8B4513; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
    .btn-primary:hover { background: #A0522D; }
    
    .inline-form { display: flex; gap: 10px; align-items: center; }
    .btn-small { padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; }
    .btn-update { background: #e3f2fd; color: #1976d2; }
    .btn-delete { background: #ffebee; color: #d32f2f; }

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
        <a href="category.php" class="nav-link active">
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
                <h1 class="dashboard-title">Manage Categories</h1>
                <p class="dashboard-subtitle">Add, edit, or remove product categories.</p>
            </div>
        </div>

        <!-- Add Category Form -->
        <div class="card" style="margin-bottom: 32px;">
            <h3 style="margin-bottom: 16px; font-size: 18px;">Add New Category</h3>
            <form id="categoryForm" class="inline-form">
                <input type="text" id="category_name" name="category_name" class="form-control" placeholder="New Category Name" required>
                <button type="submit" class="btn-primary">Add Category</button>
            </form>
            <div id="message" style="margin-top: 10px;"></div>
        </div>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td>#<?= $cat['category_id'] ?></td>
                        <td>
                            <form class="updateCategoryForm inline-form" data-id="<?= $cat['category_id'] ?>">
                                <input type="text" class="form-control new_name" value="<?= htmlspecialchars($cat['name']) ?>" style="padding: 6px; width: 200px;" required>
                                <button type="submit" class="btn-small btn-update">Update</button>
                            </form>
                        </td>
                        <td>
                            <form class="deleteCategoryForm inline-form" data-id="<?= $cat['category_id'] ?>">
                                <button type="submit" class="btn-small btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </main>
  </div>
  <script src="../js/category.js"></script>
</body>
</html>