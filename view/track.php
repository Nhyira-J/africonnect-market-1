<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Track Order | AfriConnect</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    /* Reuse styles from shop.php */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Outfit', Arial, sans-serif; background-color: #fdfbfb; color: #271a1a; line-height: 1.6; }
    img { max-width: 100%; height: auto; }
    button { cursor: pointer; border: none; background: none; font-family: inherit; }
    .container { width: 100%; max-width: 1344px; margin: 0 auto; padding-left: 16px; padding-right: 16px; }
    
    /* Header (Simplified for brevity, matching shop.php) */
    .header-container { background-color: #fdfbfb; width: 100%; }
    .promo-banner { background-color: #aa4242; padding: 8px; text-align: center; }
    .promo-text { font-size: 14px; font-weight: 600; color: #ffffff; }
    .main-header { padding: 14px 0; }
    .header-content { display: flex; justify-content: space-between; align-items: flex-end; }
    .logo { font-size: 24px; font-family: 'Crimson Pro', serif; font-weight: 300; letter-spacing: 1px; text-transform: uppercase; color: #271a1a; margin-top: 42px; text-decoration: none; }
    .nav-menu { display: flex; gap: 40px; align-items: center; margin-bottom: 10px; }
    .nav-item { font-size: 15px; font-weight: 500; color: #271a1a; text-decoration: none; }
    .header-icons { display: flex; gap: 24px; align-items: center; margin-bottom: 8px; }
    .header-icon { width: 24px; height: 24px; }

    /* Track Page Specifics */
    .track-header {
        background: linear-gradient(176deg, #fdfbfbb2 0%, #7c3030b2 100%);
        padding: 60px 20px;
        text-align: center;
        margin-bottom: 40px;
    }
    .track-title { font-family: 'Domine', serif; font-size: 48px; color: #271a1a; margin-bottom: 16px; }
    .track-subtitle { font-size: 18px; color: #555; max-width: 600px; margin: 0 auto; }

    .track-container { max-width: 800px; margin: 0 auto 80px; padding: 0 20px; }
    
    .track-form-card {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 40px;
    }

    .form-group { margin-bottom: 24px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 500; color: #271a1a; }
    .form-input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 16px; }
    .btn-track { width: 100%; padding: 14px; background: #aa4242; color: white; border-radius: 8px; font-weight: 600; font-size: 16px; transition: background 0.3s; }
    .btn-track:hover { background: #8a3535; }

    /* Results */
    .track-result { display: none; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .order-info { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
    .info-group h4 { font-size: 14px; color: #666; margin-bottom: 4px; }
    .info-group p { font-size: 18px; font-weight: 600; color: #271a1a; }

    /* Timeline */
    .timeline { position: relative; display: flex; justify-content: space-between; margin: 40px 0; }
    .timeline::before { content: ''; position: absolute; top: 15px; left: 0; width: 100%; height: 2px; background: #eee; z-index: 0; }
    .timeline-step { position: relative; z-index: 1; text-align: center; width: 25%; }
    .step-icon { width: 32px; height: 32px; background: #eee; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; transition: all 0.3s; }
    .step-label { font-size: 14px; color: #999; font-weight: 500; }
    
    .timeline-step.active .step-icon { background: #aa4242; }
    .timeline-step.active .step-label { color: #aa4242; font-weight: 700; }
    .timeline-step.completed .step-icon { background: #4caf50; }
    .timeline-step.completed .step-label { color: #4caf50; }

    /* Footer (Simplified) */
    .footer { border-top: 1px solid #aa4242; padding: 52px 16px; background-color: #fdfbfb; margin-top: auto; }
    .footer-content { display: flex; justify-content: space-between; }
    .footer-logo { font-family: 'Crimson Pro', serif; font-size: 24px; text-transform: uppercase; }

    @media (max-width: 768px) {
        .nav-menu { display: none; }
        .timeline { flex-direction: column; gap: 20px; }
        .timeline::before { width: 2px; height: 100%; left: 15px; top: 0; }
        .timeline-step { display: flex; align-items: center; gap: 16px; width: 100%; text-align: left; }
        .step-icon { margin: 0; }
    }

    .rating {
        display: inline-flex;
        flex-direction: row-reverse;
    }
    .rating input {
        display: none;
    }
    .rating label {
        font-size: 40px;
        color: #ddd;
        cursor: pointer;
        padding: 0 5px;
        transition: color 0.2s;
    }
    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: #ffc107;
    }
  </style>
</head>
<body>
  <header class="header-container">
    <div class="promo-banner">
      <p class="promo-text">Sign up & get 10% Off on your first purchase</p>
    </div>
    <div class="main-header">
      <div class="container">
        <div class="header-content">
          <a href="../index.php" style="text-decoration: none;"><h1 class="logo">AfriConnect</h1></a>
          <nav class="nav-menu">
            <a href="../index.php" class="nav-item">Home</a>
            <a href="sell.php" class="nav-item">Sell With Us</a>
            <a href="shop.php" class="nav-item">Shop</a>
            <a href="about.php" class="nav-item">About Us</a>
          </nav>
          <div class="header-icons">
            <a href="cart.php"><img src="../images/img_shopping_bag.svg" alt="Cart" class="header-icon"></a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="track-header">
      <h1 class="track-title">Track Your Order</h1>
      <p class="track-subtitle">Enter your order details below to check the status of your shipment.</p>
  </div>

  <div class="track-container">
      <div class="track-form-card">
          <form id="trackForm" onsubmit="trackOrder(event)">
              <div class="form-group">
                  <label class="form-label">Order ID (Invoice No)</label>
                  <input type="text" name="invoice_no" class="form-input" placeholder="e.g. INV-123456" required>
              </div>
              <div class="form-group">
                  <label class="form-label">Email Address</label>
                  <input type="email" name="email" class="form-input" placeholder="Enter the email used for checkout" required>
              </div>
              <button type="submit" class="btn-track">Track Order</button>
          </form>
      </div>

      <div id="trackResult" class="track-result">
          <div class="order-info">
              <div class="info-group">
                  <h4>Order ID</h4>
                  <p id="res_invoice"></p>
              </div>
              <div class="info-group">
                  <h4>Date Placed</h4>
                  <p id="res_date"></p>
              </div>
              <div class="info-group">
                  <h4>Total Amount</h4>
                  <p id="res_total"></p>
              </div>
          </div>

          <div class="timeline">
              <div class="timeline-step" id="step_pending">
                  <div class="step-icon">1</div>
                  <div class="step-label">Pending</div>
              </div>
              <div class="timeline-step" id="step_processing">
                  <div class="step-icon">2</div>
                  <div class="step-label">Processing</div>
              </div>
              <div class="timeline-step" id="step_shipped">
                  <div class="step-icon">3</div>
                  <div class="step-label">Shipped</div>
              </div>
              <div class="timeline-step" id="step_delivered">
                  <div class="step-icon">4</div>
                  <div class="step-label">Delivered</div>
              </div>
          </div>
          
          <div style="text-align: center; margin-top: 30px;">
              <p id="status_message" style="font-size: 16px; color: #666;"></p>
          </div>
      </div>

      <div id="reviewSection" style="display: none; margin-top: 40px; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
          <h3 style="font-size: 24px; margin-bottom: 20px; text-align: center; font-family: 'Domine', serif;">Rate your experience</h3>
          <form action="../actions/add_review_process.php" method="POST">
              <input type="hidden" name="invoice_no" id="review_invoice_no">
              
              <div style="margin-bottom: 20px; text-align: center;">
                  <div class="rating">
                      <input type="radio" name="rating" value="5" id="5" required><label for="5">☆</label>
                      <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                      <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                      <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                      <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                  </div>
              </div>
              
              <div style="margin-bottom: 20px;">
                  <textarea name="comment" placeholder="Tell us what you liked or how we can improve..." style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; resize: vertical;" rows="4" required></textarea>
              </div>
              
              <button type="submit" name="submit_review" style="width: 100%; padding: 14px; background: #333; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: 600;">Submit Review</button>
          </form>
      </div>
  </div>

  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-brand">
          <h3 class="footer-logo">AfriCONNECT</h3>
        </div>
        <div>
            <p>&copy; 2024 AfriConnect. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <script>
      function trackOrder(e) {
          e.preventDefault();
          const form = e.target;
          const formData = new FormData(form);
          const btn = form.querySelector('button');
          const originalText = btn.textContent;
          
          btn.textContent = 'Tracking...';
          btn.disabled = true;

          fetch('../actions/track_order_action.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              btn.textContent = originalText;
              btn.disabled = false;

              if(data.status === 'success') {
                  displayResult(data.order);
              } else {
                  alert(data.message);
                  document.getElementById('trackResult').style.display = 'none';
              }
          })
          .catch(error => {
              console.error('Error:', error);
              btn.textContent = originalText;
              btn.disabled = false;
              alert('An error occurred. Please try again.');
          });
      }

      function displayResult(order) {
          document.getElementById('res_invoice').textContent = '#' + order.invoice_no;
          document.getElementById('res_date').textContent = new Date(order.order_date).toLocaleDateString();
          document.getElementById('res_total').textContent = 'GH₵ ' + parseFloat(order.total_amount).toFixed(2);
          
          const status = order.order_status.toLowerCase();
          const steps = ['pending', 'processing', 'shipped', 'delivered'];
          let activeFound = false;

          steps.forEach((step, index) => {
              const el = document.getElementById('step_' + step);
              el.className = 'timeline-step'; // Reset

              if (step === status) {
                  el.classList.add('active');
                  activeFound = true;
                  // Mark previous as completed
                  for(let i=0; i<index; i++) {
                      document.getElementById('step_' + steps[i]).classList.add('completed');
                  }
              } else if (!activeFound) {
                   // If we haven't found the active one yet, assume this one is completed (if status is advanced)
                   // Actually, logic above handles it.
              }
          });
          
          // Fallback if status matches none (e.g. cancelled)
          if(status === 'cancelled') {
               document.getElementById('status_message').textContent = 'This order has been cancelled.';
               document.getElementById('status_message').style.color = 'red';
          } else {
               document.getElementById('status_message').textContent = `Current Status: ${status.charAt(0).toUpperCase() + status.slice(1)}`;
               document.getElementById('status_message').style.color = '#666';
          }

          document.getElementById('trackResult').style.display = 'block';

          // Show review section if delivered
          if(status === 'delivered'){
              document.getElementById('reviewSection').style.display = 'block';
              document.getElementById('review_invoice_no').value = order.invoice_no;
          } else {
              document.getElementById('reviewSection').style.display = 'none';
          }
      }
  </script>
</body>
</html>
