<?php
session_start();
include("../controllers/order_controller.php");

// Check if admin (simplified check, should be more robust in production)
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    // header("Location: ../view/login.php");
    // exit();
}

$orders = get_all_orders_ctr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders Management | Admin Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Reusing styles from dashboard.php */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Outfit', sans-serif; background: #f8f9fa; color: #1a1a1a; }
    .layout-wrapper { display: flex; min-height: 100vh; }
    
    /* Sidebar */
    .sidebar { width: 260px; background: #1a1a1a; color: white; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 100; left: 0; top: 0; }
    .sidebar-header { padding: 24px; border-bottom: 1px solid #333; }
    .logo { font-family: 'Domine', serif; font-size: 24px; font-weight: 700; color: white; text-decoration: none; }
    .sidebar-nav { padding: 24px 16px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #aaa; text-decoration: none; font-weight: 500; border-radius: 8px; transition: all 0.3s ease; }
    .nav-link:hover { background: #333; color: white; }
    .nav-link.active { background: #aa4242; color: white; }
    .nav-icon { font-size: 18px; width: 24px; text-align: center; }
    .sidebar-footer { padding: 24px; border-top: 1px solid #333; }
    .logout-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #ff6b6b; text-decoration: none; font-weight: 500; border-radius: 8px; transition: all 0.3s ease; }
    .logout-link:hover { background: #333; }

    /* Main Content */
    .main-content { flex: 1; margin-left: 260px; background: #f8f9fa; min-height: 100vh; display: flex; flex-direction: column; }
    .dashboard-header { background: white; border-bottom: 1px solid #e8e8e8; padding: 16px 40px; display: flex; justify-content: flex-end; align-items: center; position: sticky; top: 0; z-index: 90; }
    .header-right { display: flex; align-items: center; gap: 24px; }
    .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 8px 16px; border-radius: 10px; transition: background 0.3s ease; }
    .user-profile:hover { background: #f8f9fa; }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: #aa4242; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px; }
    .user-info h4 { font-size: 14px; font-weight: 600; color: #1a1a1a; }
    .user-info p { font-size: 12px; color: #666; }

    /* Dashboard Container */
    .dashboard-container { padding: 40px; max-width: 1200px; width: 100%; margin: 0 auto; }
    .dashboard-title { font-family: 'Domine', serif; font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
    .dashboard-subtitle { font-size: 15px; color: #666; margin-bottom: 32px; }

    /* Orders Table */
    .orders-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); }
    .orders-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .orders-table thead th { text-align: left; font-size: 12px; font-weight: 600; color: #666; padding: 12px 16px; text-transform: uppercase; letter-spacing: 0.5px; }
    .orders-table tbody tr { background: #fafafa; transition: all 0.3s ease; }
    .orders-table tbody tr:hover { background: #f0f0f0; transform: scale(1.005); }
    .orders-table tbody td { padding: 16px; font-size: 14px; border-top: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0; }
    .orders-table tbody td:first-child { border-left: 1px solid #f0f0f0; border-radius: 12px 0 0 12px; }
    .orders-table tbody td:last-child { border-right: 1px solid #f0f0f0; border-radius: 0 12px 12px 0; }
    .order-id { font-weight: 600; color: #aa4242; }
    .customer-name { font-weight: 500; color: #1a1a1a; }
    .order-date { color: #666; font-size: 13px; }
    .order-total { font-weight: 600; color: #1a1a1a; }
    
    .status-badge { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
    .status-badge.pending { background: #fff3e0; color: #f57c00; }
    .status-badge.processing { background: #e3f2fd; color: #1976d2; }
    .status-badge.shipped { background: #f3e5f5; color: #7b1fa2; }
    .status-badge.delivered { background: #e8f5e9; color: #2e7d32; }
    .status-badge.cancelled { background: #ffebee; color: #d32f2f; }

    .action-btn-sm { padding: 6px 12px; border: 1px solid #e0e0e0; background: white; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 500; color: #666; transition: all 0.2s; }
    .action-btn-sm:hover { border-color: #aa4242; color: #aa4242; }
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
        <a href="manage_users.php" class="nav-link">
          <span class="nav-icon">👥</span>
          <span>Users</span>
        </a>
        <a href="delivery_riders.php" class="nav-link">
          <span class="nav-icon">🛵</span>
          <span>Delivery Riders</span>
        </a>
        <a href="category.php" class="nav-link">
          <span class="nav-icon">📁</span>
          <span>Categories</span>
        </a>
        <a href="orders.php" class="nav-link active">
          <span class="nav-icon">🛍️</span>
          <span>Orders</span>
        </a>
        <a href="settings.php" class="nav-link">
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

    <!-- Main Content -->
    <main class="main-content">
      <header class="dashboard-header">
        <div class="header-right">
          <div class="user-profile">
            <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 2)); ?></div>
            <div class="user-info">
              <h4><?php echo htmlspecialchars($_SESSION['user_name']); ?></h4>
              <p>Admin</p>
            </div>
          </div>
        </div>
      </header>

      <div class="dashboard-container">
        <h1 class="dashboard-title">Orders Management</h1>
        <p class="dashboard-subtitle">View and manage all platform orders.</p>

        <div class="orders-card">
          <table class="orders-table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($orders)): ?>
                <?php foreach($orders as $order): ?>
                  <tr>
                    <td><span class="order-id">#<?php echo $order['invoice_no']; ?></span></td>
                    <td>
                      <div class="customer-name"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                      <div class="order-date"><?php echo htmlspecialchars($order['email']); ?></div>
                    </td>
                    <td class="order-date"><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                    <td><span class="status-badge <?php echo strtolower($order['order_status']); ?>"><?php echo ucfirst($order['order_status']); ?></span></td>
                    <td class="order-total">GH₵ <?php echo number_format($order['total_amount'], 2); ?></td>
                    <td>
                      <button class="action-btn-sm" onclick="viewOrderDetails(<?php echo $order['order_id']; ?>)">View Details</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" style="text-align: center; color: #666;">No orders found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Order Details Modal -->
        <div class="modal-overlay" id="orderDetailsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
            <div class="modal-container" style="background: white; width: 90%; max-width: 600px; border-radius: 16px; padding: 24px; max-height: 90vh; overflow-y: auto;">
                <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 class="modal-title" style="font-size: 20px; font-weight: 700;">Order Details <span id="modal_order_id" style="color: #aa4242;"></span></h3>
                    <button onclick="closeModal()" style="background: none; border: none; font-size: 24px; cursor: pointer;">×</button>
                </div>
                <div class="modal-body">
                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                        <h4 style="font-size: 14px; color: #666; margin-bottom: 8px;">Status</h4>
                        <select id="modal_order_status" onchange="updateStatus()" style="padding: 8px; border-radius: 6px; border: 1px solid #ddd; width: 100%;">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    
                    <h4 style="font-size: 14px; color: #666; margin-bottom: 12px;">Customer Information</h4>
                    <div id="modal_customer_info" style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                        <!-- Customer info will be populated here -->
                    </div>
                    
                    <h4 style="font-size: 14px; color: #666; margin-bottom: 12px;">Items Ordered</h4>
                    <div id="modal_order_items">
                        <!-- Items will be populated here -->
                    </div>
                    
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; text-align: right;">
                        <div style="font-size: 16px; font-weight: 700;">Total: <span id="modal_order_total"></span></div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </main>
  </div>

  <script>
      let currentOrderId = null;

      function viewOrderDetails(orderId) {
          currentOrderId = orderId;
          fetch(`../actions/get_order_details.php?order_id=${orderId}`)
              .then(response => response.json())
              .then(data => {
                  if(data.status === 'success') {
                      document.getElementById('modal_order_id').textContent = '#' + data.order.invoice_no;
                      document.getElementById('modal_order_status').value = data.order.order_status;
                      
                      // Display customer info
                      const customerInfo = document.getElementById('modal_customer_info');
                      customerInfo.innerHTML = `
                          <div style="font-size: 14px; margin-bottom: 8px;"><strong>Name:</strong> ${data.order.customer_name}</div>
                          <div style="font-size: 14px; margin-bottom: 8px;"><strong>Email:</strong> ${data.order.email}</div>
                          <div style="font-size: 14px;"><strong>Order Date:</strong> ${new Date(data.order.order_date).toLocaleDateString()}</div>
                      `;
                      
                      const itemsContainer = document.getElementById('modal_order_items');
                      itemsContainer.innerHTML = '';
                      let total = 0;
                      
                      data.products.forEach(item => {
                          const itemTotal = item.quantity * item.unit_price;
                          total += itemTotal;
                          itemsContainer.innerHTML += `
                              <div style="display: flex; gap: 12px; margin-bottom: 12px; align-items: center;">
                                  <img src="${item.image_url}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                                  <div style="flex: 1;">
                                      <div style="font-weight: 600; font-size: 14px;">${item.name}</div>
                                      <div style="font-size: 12px; color: #666;">Qty: ${item.quantity} x GH₵ ${item.unit_price}</div>
                                  </div>
                                  <div style="font-weight: 600; font-size: 14px;">GH₵ ${itemTotal.toFixed(2)}</div>
                              </div>
                          `;
                      });
                      
                      document.getElementById('modal_order_total').textContent = 'GH₵ ' + total.toFixed(2);
                      
                      document.getElementById('orderDetailsModal').style.display = 'flex';
                  } else {
                      alert('Failed to load order details');
                  }
              })
              .catch(error => console.error('Error:', error));
      }

      function closeModal() {
          document.getElementById('orderDetailsModal').style.display = 'none';
      }

      function updateStatus() {
          const newStatus = document.getElementById('modal_order_status').value;
          if(!currentOrderId) return;

          const formData = new FormData();
          formData.append('order_id', currentOrderId);
          formData.append('status', newStatus);

          fetch('../actions/update_order_status.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if(data.status === 'success') {
                  alert('Order status updated successfully');
                  location.reload(); // Reload to reflect changes in table
              } else {
                  alert('Failed to update status');
              }
          })
          .catch(error => console.error('Error:', error));
      }

      // Close modal when clicking outside
      window.onclick = function(event) {
          const modal = document.getElementById('orderDetailsModal');
          if (event.target == modal) {
              closeModal();
          }
      }
  </script>
</body>
</html>
