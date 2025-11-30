<?php
session_start();
include("../controllers/product_controller.php");
include("../controllers/category_controller.php");

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

$products = view_products_by_artisan_ctr($real_artisan_id);
$categories = view_all_categories_ctr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management | AfriConnect</title>
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

    /* Card Styles */
    .card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    /* Product Table */
    .product-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 8px;
    }

    .product-table thead th {
      text-align: left;
      font-size: 12px;
      font-weight: 600;
      color: #666;
      padding: 12px 16px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .product-table tbody tr {
      background: #fafafa;
      transition: all 0.3s ease;
    }

    .product-table tbody tr:hover {
      background: #f0f0f0;
      transform: scale(1.005);
    }

    .product-table tbody td {
      padding: 16px;
      font-size: 14px;
      border-top: 1px solid #f0f0f0;
      border-bottom: 1px solid #f0f0f0;
      vertical-align: middle;
    }

    .product-table tbody td:first-child {
      border-left: 1px solid #f0f0f0;
      border-radius: 12px 0 0 12px;
    }

    .product-table tbody td:last-child {
      border-right: 1px solid #f0f0f0;
      border-radius: 0 12px 12px 0;
    }

    .product-img-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        background-color: #eee;
    }

    .status-badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 600;
    }

    .status-badge.available { background: #e8f5e9; color: #2e7d32; }
    .status-badge.out_of_stock { background: #ffebee; color: #d32f2f; }

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
      text-decoration: none;
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

    .action-link {
        color: #666;
        text-decoration: none;
        margin-right: 10px;
        font-weight: 500;
        transition: color 0.2s;
    }

    .action-link:hover {
        color: #8B4513;
    }

    .action-link.delete:hover {
        color: #d32f2f;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: none;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .modal-container {
        background: white;
        width: 100%;
        max-width: 600px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        transform: translateY(20px);
        transition: transform 0.3s ease;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-overlay.active .modal-container {
        transform: translateY(0);
    }

    .modal-header {
        padding: 24px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-family: 'Domine', serif;
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #666;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .modal-close:hover {
        color: #d32f2f;
    }

    .modal-body {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        font-size: 15px;
        font-family: 'Outfit', sans-serif;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        transition: all 0.3s ease;
        background: #fafafa;
        color: #1a1a1a;
    }

    .form-control:focus {
        outline: none;
        border-color: #8B4513;
        background: white;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.08);
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-row .form-group {
        flex: 1;
    }

    .modal-footer {
        padding: 24px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-cancel {
        padding: 12px 24px;
        border: 1px solid #e0e0e0;
        background: white;
        color: #666;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #f8f9fa;
        color: #333;
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
      .product-table { display: block; overflow-x: auto; }
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
        <a href="product.php" class="nav-link active">
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
        <div class="page-header">
            <div>
                <h1 class="dashboard-title">Product Management</h1>
                <p class="dashboard-subtitle">Manage your inventory and add new items.</p>
            </div>
            <button class="action-btn primary" onclick="openModal()">
                <span>➕</span> Add New Product
            </button>
        </div>

        <div class="card">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($products): ?>
                        <?php foreach($products as $product): ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img-thumb">
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1a1a1a;"><?php echo htmlspecialchars($product['name']); ?></div>
                                <div style="font-size: 12px; color: #666;"><?php echo htmlspecialchars(substr($product['description'], 0, 50)) . '...'; ?></div>
                            </td>
                            <td style="font-weight: 600; color: #8B4513;">GH₵ <?php echo htmlspecialchars($product['price']); ?></td>
                            <td><?php echo isset($product['quantity']) ? $product['quantity'] : 'N/A'; ?></td>
                            <td>
                                <span class="status-badge <?php echo $product['stock_status']; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $product['stock_status'])); ?>
                                </span>
                            </td>
                            <td>
                                <a href="javascript:void(0)" onclick="openEditModal(<?php echo $product['product_id']; ?>)" class="action-link">Edit</a>
                                <a href="javascript:void(0)" onclick="deleteProduct(<?php echo $product['product_id']; ?>)" class="action-link delete">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #666;">
                                No products found. Click "Add New Product" to get started!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Add Product Modal -->
  <div class="modal-overlay" id="addProductModal">
      <div class="modal-container">
          <div class="modal-header">
              <h3 class="modal-title">Add New Product</h3>
              <button class="modal-close" onclick="closeModal()">×</button>
          </div>
          <form action="../actions/add_product_process.php" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  <div class="form-group">
                      <label class="form-label">Product Name</label>
                      <input type="text" name="name" class="form-control" placeholder="e.g., Kente Scarf" required>
                  </div>
                  
                  <div class="form-row">
                      <div class="form-group">
                          <label class="form-label">Price (GHS)</label>
                          <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                      </div>
                      <div class="form-group">
                          <label class="form-label">Quantity</label>
                          <input type="number" name="quantity" class="form-control" placeholder="1" required>
                      </div>
                      <div class="form-group">
                          <label class="form-label">Category</label>
                          <select name="category" class="form-control" required>
                              <option value="">Select Category</option>
                              <?php foreach($categories as $cat): ?>
                                  <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['name']; ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Description</label>
                      <textarea name="description" rows="3" class="form-control" placeholder="Describe your product..." required></textarea>
                  </div>

                  <div class="form-row">
                      <div class="form-group">
                          <label class="form-label">Estimated Delivery (Days)</label>
                          <input type="number" name="delivery_time" class="form-control" placeholder="e.g., 3">
                      </div>
                      <div class="form-group">
                          <label class="form-label">Product Image</label>
                          <input type="file" name="image" class="form-control" accept="image/*" required>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                  <button type="submit" name="add_product" class="action-btn primary">Add Product</button>
              </div>
          </form>
      </div>
  </div>

  <!-- Edit Product Modal -->
  <div class="modal-overlay" id="editProductModal">
      <div class="modal-container">
          <div class="modal-header">
              <h3 class="modal-title">Edit Product</h3>
              <button class="modal-close" onclick="closeEditModal()">×</button>
          </div>
          <form id="editProductForm" enctype="multipart/form-data">
              <input type="hidden" name="product_id" id="edit_product_id">
              <div class="modal-body">
                  <div class="form-group">
                      <label class="form-label">Product Name</label>
                      <input type="text" name="name" id="edit_name" class="form-control" required>
                  </div>
                  
                  <div class="form-row">
                      <div class="form-group">
                          <label class="form-label">Price (GHS)</label>
                          <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label class="form-label">Quantity</label>
                          <input type="number" name="quantity" id="edit_quantity" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label class="form-label">Category</label>
                          <select name="category" id="edit_category" class="form-control" required>
                              <option value="">Select Category</option>
                              <?php foreach($categories as $cat): ?>
                                  <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['name']; ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Description</label>
                      <textarea name="description" id="edit_description" rows="3" class="form-control" required></textarea>
                  </div>

                  <div class="form-row">
                      <div class="form-group">
                          <label class="form-label">Estimated Delivery (Days)</label>
                          <input type="number" name="delivery_time" id="edit_delivery_time" class="form-control">
                      </div>
                      <div class="form-group">
                          <label class="form-label">Stock Status</label>
                          <select name="stock_status" id="edit_stock_status" class="form-control">
                              <option value="available">Available</option>
                              <option value="out_of_stock">Out of Stock</option>
                          </select>
                      </div>
                  </div>
                  
                  <div class="form-group">
                      <label class="form-label">Product Image (Leave empty to keep current)</label>
                      <input type="file" name="image" class="form-control" accept="image/*">
                      <div id="current_image_preview" style="margin-top: 10px;"></div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                  <button type="submit" class="action-btn primary">Save Changes</button>
              </div>
          </form>
      </div>
  </div>

  <script>
      // Add Product Modal
      function openModal() {
          const modal = document.getElementById('addProductModal');
          modal.classList.add('active');
          document.body.style.overflow = 'hidden';
      }

      function closeModal() {
          const modal = document.getElementById('addProductModal');
          modal.classList.remove('active');
          document.body.style.overflow = '';
      }

      // Edit Product Modal
      function openEditModal(productId) {
          // Fetch product details
          fetch(`../actions/get_product_details.php?id=${productId}`)
              .then(response => response.json())
              .then(data => {
                  if(data.status === 'success') {
                      const product = data.data;
                      document.getElementById('edit_product_id').value = product.product_id;
                      document.getElementById('edit_name').value = product.name;
                      document.getElementById('edit_price').value = product.price;
                      document.getElementById('edit_category').value = product.category_id;
                      document.getElementById('edit_description').value = product.description;
                      document.getElementById('edit_delivery_time').value = product.estimated_delivery_time;
                      document.getElementById('edit_stock_status').value = product.stock_status;
                      
                      // Show current image
                      const imgPreview = document.getElementById('current_image_preview');
                      imgPreview.innerHTML = `<img src="${product.image_url}" style="height: 60px; border-radius: 6px;">`;

                      const modal = document.getElementById('editProductModal');
                      modal.classList.add('active');
                      document.body.style.overflow = 'hidden';
                  } else {
                      alert('Failed to fetch product details');
                  }
              })
              .catch(error => console.error('Error:', error));
      }

      // Check for URL parameters
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('success')) {
          const success = urlParams.get('success');
          if (success === 'added') {
              alert('Product added successfully!');
              // Clean URL
              window.history.replaceState({}, document.title, window.location.pathname);
          }
      } else if (urlParams.has('error')) {
          const error = urlParams.get('error');
          if (error === 'failed') {
              alert('Failed to add product. Please try again.');
          } else if (error === 'upload_failed') {
              alert('Image upload failed.');
          } else if (error === 'invalid_file_type') {
              alert('Invalid file type. Please upload an image.');
          } else if (error === 'no_artisan_profile') {
              alert('Error: Artisan profile not found.');
          }
          // Clean URL
          window.history.replaceState({}, document.title, window.location.pathname);
      }

      function closeEditModal() {
          const modal = document.getElementById('editProductModal');
          modal.classList.remove('active');
          document.body.style.overflow = '';
      }

      // Handle Edit Form Submission
      document.getElementById('editProductForm').addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);

          fetch('../actions/update_product_action.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if(data.status === 'success') {
                  alert('Product updated successfully');
                  location.reload();
              } else {
                  alert(data.message || 'Failed to update product');
              }
          })
          .catch(error => console.error('Error:', error));
      });

      // AJAX Delete Product
      function deleteProduct(productId) {
          if(confirm('Are you sure you want to delete this product?')) {
              const formData = new FormData();
              formData.append('id', productId);

              fetch('../actions/delete_product_action.php', {
                  method: 'POST',
                  body: formData
              })
              .then(response => response.json())
              .then(data => {
                  if(data.status === 'success') {
                      // Remove row from table or reload
                      // For simplicity, reloading to update list
                      location.reload();
                  } else {
                      alert(data.message || 'Failed to delete product');
                  }
              })
              .catch(error => console.error('Error:', error));
          }
      }

      // Close modals when clicking outside
      window.onclick = function(event) {
          const addModal = document.getElementById('addProductModal');
          const editModal = document.getElementById('editProductModal');
          if (event.target == addModal) {
              closeModal();
          }
          if (event.target == editModal) {
              closeEditModal();
          }
      }
  </script>
</body>
</html>
