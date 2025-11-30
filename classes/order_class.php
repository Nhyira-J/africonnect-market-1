<?php
require_once("../settings/db_class.php");

class order_class extends db_connection
{
    public function add_order($customer_id, $invoice_no, $total_amount, $status)
    {
        $ndb = new db_connection();
        $customer_id = mysqli_real_escape_string($ndb->db_conn(), $customer_id);
        $invoice_no = mysqli_real_escape_string($ndb->db_conn(), $invoice_no);
        $total_amount = mysqli_real_escape_string($ndb->db_conn(), $total_amount);
        $status = mysqli_real_escape_string($ndb->db_conn(), $status);

        $sql = "INSERT INTO `orders` (`customer_id`, `invoice_no`, `total_amount`, `order_status`) 
                VALUES ('$customer_id', '$invoice_no', '$total_amount', '$status')";
        
        if($this->db_query($sql)){
            return $this->insert_id();
        } else {
            return false;
        }
    }

    public function add_order_details($order_id, $product_id, $quantity, $unit_price)
    {
        $ndb = new db_connection();
        $order_id = mysqli_real_escape_string($ndb->db_conn(), $order_id);
        $product_id = mysqli_real_escape_string($ndb->db_conn(), $product_id);
        $quantity = mysqli_real_escape_string($ndb->db_conn(), $quantity);
        $unit_price = mysqli_real_escape_string($ndb->db_conn(), $unit_price);

        $sql = "INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`, `unit_price`) 
                VALUES ('$order_id', '$product_id', '$quantity', '$unit_price')";
        
        return $this->db_query($sql);
    }

    public function add_payment($order_id, $amount, $currency, $status)
    {
        $ndb = new db_connection();
        $order_id = mysqli_real_escape_string($ndb->db_conn(), $order_id);
        $amount = mysqli_real_escape_string($ndb->db_conn(), $amount);
        $currency = mysqli_real_escape_string($ndb->db_conn(), $currency);
        $status = mysqli_real_escape_string($ndb->db_conn(), $status);

        $sql = "INSERT INTO `payments` (`order_id`, `amount`, `currency`, `payment_status`) 
                VALUES ('$order_id', '$amount', '$currency', '$status')";
        
        return $this->db_query($sql);
    }
    
    public function get_order($order_id) {
        $ndb = new db_connection();
        $order_id = mysqli_real_escape_string($ndb->db_conn(), $order_id);
        $sql = "SELECT o.*, u.full_name as customer_name, u.email 
                FROM orders o
                JOIN customers c ON o.customer_id = c.customer_id
                JOIN users u ON c.user_id = u.user_id
                WHERE o.order_id = '$order_id'";
        return $this->db_fetch_one($sql);
    }

    public function get_all_orders() {
        $sql = "SELECT o.*, u.full_name as customer_name, u.email 
                FROM orders o 
                JOIN customers c ON o.customer_id = c.customer_id 
                JOIN users u ON c.user_id = u.user_id 
                ORDER BY o.order_date DESC";
        return $this->db_fetch_all($sql);
    }

    public function get_orders_by_artisan($artisan_id) {
        $ndb = new db_connection();
        $artisan_id = mysqli_real_escape_string($ndb->db_conn(), $artisan_id);
        
        // Fetch orders that contain products from this artisan
        // We need to be careful here. An order might contain products from multiple artisans.
        // We should probably show the order if it contains at least one product from the artisan.
        // And maybe calculate the subtotal for that artisan's products in that order.
        
        $sql = "SELECT DISTINCT o.order_id, o.invoice_no, o.order_date, o.order_status, 
                       u.full_name as customer_name, u.email,
                       (SELECT SUM(od.quantity * od.unit_price) 
                        FROM order_details od 
                        JOIN products p ON od.product_id = p.product_id 
                        WHERE od.order_id = o.order_id AND p.artisan_id = '$artisan_id') as artisan_total
                FROM orders o
                JOIN order_details od ON o.order_id = od.order_id
                JOIN products p ON od.product_id = p.product_id
                JOIN customers c ON o.customer_id = c.customer_id
                JOIN users u ON c.user_id = u.user_id
                WHERE p.artisan_id = '$artisan_id'
                ORDER BY o.order_date DESC";
                
        return $this->db_fetch_all($sql);
    }

    public function get_artisan_analytics($artisan_id) {
        $ndb = new db_connection();
        $artisan_id = mysqli_real_escape_string($ndb->db_conn(), $artisan_id);
        
        $analytics = [];
        
        // Total Revenue
        $sql_revenue = "SELECT SUM(od.quantity * od.unit_price) as total_revenue
                        FROM order_details od
                        JOIN products p ON od.product_id = p.product_id
                        JOIN orders o ON od.order_id = o.order_id
                        WHERE p.artisan_id = '$artisan_id' AND o.order_status != 'cancelled'";
        $result_revenue = $this->db_fetch_one($sql_revenue);
        $analytics['total_revenue'] = $result_revenue['total_revenue'] ?? 0;
        
        // Total Orders (count of unique orders containing artisan's products)
        $sql_orders = "SELECT COUNT(DISTINCT o.order_id) as total_orders
                       FROM orders o
                       JOIN order_details od ON o.order_id = od.order_id
                       JOIN products p ON od.product_id = p.product_id
                       WHERE p.artisan_id = '$artisan_id'";
        $result_orders = $this->db_fetch_one($sql_orders);
        $analytics['total_orders'] = $result_orders['total_orders'] ?? 0;
        
        // Pending Orders
        $sql_pending = "SELECT COUNT(DISTINCT o.order_id) as pending_orders
                        FROM orders o
                        JOIN order_details od ON o.order_id = od.order_id
                        JOIN products p ON od.product_id = p.product_id
                        WHERE p.artisan_id = '$artisan_id' AND o.order_status = 'pending'";
        $result_pending = $this->db_fetch_one($sql_pending);
        $analytics['pending_orders'] = $result_pending['pending_orders'] ?? 0;
        
        // Top Selling Products
        $sql_top = "SELECT p.name, SUM(od.quantity) as total_sold, SUM(od.quantity * od.unit_price) as revenue
                    FROM order_details od
                    JOIN products p ON od.product_id = p.product_id
                    WHERE p.artisan_id = '$artisan_id'
                    GROUP BY p.product_id
                    ORDER BY total_sold DESC
                    LIMIT 5";
        $analytics['top_products'] = $this->db_fetch_all($sql_top);
        
        return $analytics;
    }

    public function get_total_revenue() {
        $sql = "SELECT SUM(total_amount) as total_revenue FROM orders WHERE order_status != 'cancelled'";
        return $this->db_fetch_one($sql);
    }

    public function update_order_status($order_id, $status) {
        $ndb = new db_connection();
        $order_id = mysqli_real_escape_string($ndb->db_conn(), $order_id);
        $status = mysqli_real_escape_string($ndb->db_conn(), $status);
        
        $sql = "UPDATE orders SET order_status = '$status' WHERE order_id = '$order_id'";
        return $this->db_query($sql);
    }

    public function get_order_details_by_artisan($order_id, $artisan_id) {
        $ndb = new db_connection();
        $order_id = mysqli_real_escape_string($ndb->db_conn(), $order_id);
        $artisan_id = mysqli_real_escape_string($ndb->db_conn(), $artisan_id);
        
        $sql = "SELECT od.*, p.name, p.image_url, p.price 
                FROM order_details od
                JOIN products p ON od.product_id = p.product_id
                WHERE od.order_id = '$order_id' AND p.artisan_id = '$artisan_id'";
                
        return $this->db_fetch_all($sql);
    }
}
?>
