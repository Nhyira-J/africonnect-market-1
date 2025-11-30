<?php
session_start();
include("../controllers/delivery_rider_controller.php");

// Check if user is logged in and is an admin
// if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
//     header("Location: ../view/login.php");
//     exit();
// }

// Handle Form Submissions
if(isset($_POST['add_rider'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $vehicle_type = $_POST['vehicle_type'];
    $location = $_POST['location'];
    $status = 'available'; // Default status
    $image = $_FILES['rider_image'];

    if(add_rider_ctr($name, $email, $phone, $vehicle_type, $location, $status, $image)){
        echo "<script>alert('Rider added successfully');</script>";
    } else {
        echo "<script>alert('Failed to add rider');</script>";
    }
}

if(isset($_POST['delete_rider'])){
    $id = $_POST['rider_id'];
    if(delete_rider_ctr($id)){
        echo "<script>alert('Rider deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete rider');</script>";
    }
}

$riders = view_all_riders_ctr();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Delivery Riders | AfriConnect Admin</title>
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
    
    .status-badge { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
    .status-badge.available { background: #e8f5e9; color: #2e7d32; }
    .status-badge.busy { background: #fff3e0; color: #f57c00; }
    .status-badge.offline { background: #ffebee; color: #d32f2f; }

    .action-btn { padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; margin-right: 8px; display: inline-block; cursor: pointer; border: none; }
    .action-btn.edit { background: #e3f2fd; color: #1976d2; }
    .action-btn.delete { background: #ffebee; color: #d32f2f; }
    .action-btn.primary { background: #8B4513; color: white; padding: 10px 20px; font-size: 14px; }
    .action-btn:hover { opacity: 0.8; }

    /* Modal */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; justify-content: center; align-items: center; }
    .modal-overlay.active { display: flex; }
    .modal-container { background: white; width: 100%; max-width: 500px; border-radius: 16px; padding: 24px; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-title { font-size: 20px; font-weight: 700; }
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Outfit', sans-serif; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; }

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
        <a href="delivery_riders.php" class="nav-link active">
          <span class="nav-icon">🛵</span>
          <span>Delivery Riders</span>
        </a>
        <a href="verify_artisans.php" class="nav-link">
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
                <h1 class="dashboard-title">Manage Delivery Riders</h1>
                <p class="dashboard-subtitle">Add and manage delivery partners.</p>
            </div>
            <button class="action-btn primary" onclick="openModal()">+ Add New Rider</button>
        </div>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Vehicle</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($riders): ?>
                        <?php foreach($riders as $rider): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <?php if(!empty($rider['rider_image'])): ?>
                                        <img src="<?php echo htmlspecialchars($rider['rider_image']); ?>" alt="Rider" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #666;">
                                            <?php echo strtoupper(substr($rider['name'], 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div style="font-weight: 600;"><?php echo htmlspecialchars($rider['name']); ?></div>
                                </div>
                            </td>
                            <td>
                                <div><?php echo htmlspecialchars($rider['phone']); ?></div>
                                <div style="font-size: 12px; color: #999;"><?php echo htmlspecialchars($rider['email']); ?></div>
                            </td>
                            <td><?php echo htmlspecialchars($rider['vehicle_type']); ?></td>
                            <td><?php echo htmlspecialchars($rider['location']); ?></td>
                            <td>
                                <span class="status-badge <?php echo $rider['status']; ?>">
                                    <?php echo ucfirst($rider['status']); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="rider_id" value="<?php echo $rider['rider_id']; ?>">
                                    <button type="submit" name="delete_rider" class="action-btn delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">No riders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Add Rider Modal -->
  <div class="modal-overlay" id="addRiderModal">
      <div class="modal-container">
          <div class="modal-header">
              <h3 class="modal-title">Add New Rider</h3>
              <button class="action-btn delete" onclick="closeModal()" style="padding: 4px 8px;">×</button>
          </div>
          <form method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  <div class="form-group">
                      <label class="form-label">Profile Image</label>
                      <input type="file" name="rider_image" class="form-control" accept="image/*">
                  </div>
                  <div class="form-group">
                      <label class="form-label">Full Name</label>
                      <input type="text" name="name" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <label class="form-label">Phone Number</label>
                      <input type="text" name="phone" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <label class="form-label">Vehicle Type</label>
                      <select name="vehicle_type" class="form-control" required>
                          <option value="Bike">Bike</option>
                          <option value="Motorcycle">Motorcycle</option>
                          <option value="Van">Van</option>
                          <option value="Truck">Truck</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label class="form-label">Location</label>
                      <input type="text" name="location" class="form-control" required>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="action-btn" onclick="closeModal()">Cancel</button>
                  <button type="submit" name="add_rider" class="action-btn primary">Add Rider</button>
              </div>
          </form>
      </div>
  </div>

  <script>
      function openModal() {
          document.getElementById('addRiderModal').classList.add('active');
      }
      function closeModal() {
          document.getElementById('addRiderModal').classList.remove('active');
      }
  </script>
</body>
</html>
