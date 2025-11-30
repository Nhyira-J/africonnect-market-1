<?php
require_once("../settings/db_class.php");

class cart_class extends db_connection
{
    // Add to cart
    public function add_to_cart($customer_id, $product_id, $quantity)
    {
        $ndb = new db_connection();
        $customer_id = mysqli_real_escape_string($ndb->db_conn(), $customer_id);
        $product_id = mysqli_real_escape_string($ndb->db_conn(), $product_id);
        $quantity = mysqli_real_escape_string($ndb->db_conn(), $quantity);

        // Check if user has an active cart (assuming one active cart per user for simplicity, or create new)
        // For this implementation, we'll check if a cart exists, if not create one.
        // Schema has `carts` table.
        
        $cart_id = $this->get_active_cart_id($customer_id);
        
        if (!$cart_id) {
            $create_cart_sql = "INSERT INTO carts (customer_id) VALUES ('$customer_id')";
            if ($this->db_query($create_cart_sql)) {
                $cart_id = $this->insert_id();
            } else {
                return false;
            }
        }

        // Check if item already in cart
        $check_item = "SELECT item_id, quantity FROM cart_items WHERE cart_id = '$cart_id' AND product_id = '$product_id'";
        $item_result = $this->db_fetch_one($check_item);

        if ($item_result) {
            // Update quantity
            $new_qty = $item_result['quantity'] + $quantity;
            $update_sql = "UPDATE cart_items SET quantity = '$new_qty' WHERE item_id = '" . $item_result['item_id'] . "'";
            return $this->db_query($update_sql);
        } else {
            // Insert new item
            $insert_sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES ('$cart_id', '$product_id', '$quantity')";
            return $this->db_query($insert_sql);
        }
    }

    private function get_active_cart_id($customer_id) {
        $ndb = new db_connection();
        $customer_id = mysqli_real_escape_string($ndb->db_conn(), $customer_id);
        // Assuming the latest cart is the active one for now, or we could add a status column to carts table
        $sql = "SELECT cart_id FROM carts WHERE customer_id = '$customer_id' ORDER BY created_at DESC LIMIT 1";
        $result = $this->db_fetch_one($sql);
        return $result ? $result['cart_id'] : false;
    }

    public function view_cart($customer_id)
    {
        $cart_id = $this->get_active_cart_id($customer_id);
        if (!$cart_id) return [];

        $sql = "SELECT ci.*, p.name, p.price, p.image_url, (p.price * ci.quantity) as subtotal 
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.product_id
                WHERE ci.cart_id = '$cart_id'";
        return $this->db_fetch_all($sql);
    }

    public function update_cart_quantity($item_id, $quantity)
    {
        $ndb = new db_connection();
        $item_id = mysqli_real_escape_string($ndb->db_conn(), $item_id);
        $quantity = mysqli_real_escape_string($ndb->db_conn(), $quantity);

        if ($quantity <= 0) {
            return $this->remove_from_cart($item_id);
        }

        $sql = "UPDATE cart_items SET quantity = '$quantity' WHERE item_id = '$item_id'";
        return $this->db_query($sql);
    }

    public function remove_from_cart($item_id)
    {
        $ndb = new db_connection();
        $item_id = mysqli_real_escape_string($ndb->db_conn(), $item_id);
        $sql = "DELETE FROM cart_items WHERE item_id = '$item_id'";
        return $this->db_query($sql);
    }

    public function get_cart_total($customer_id)
    {
        $items = $this->view_cart($customer_id);
        $total = 0;
        if ($items) {
            foreach ($items as $item) {
                $total += $item['subtotal'];
            }
        }
        return $total;
    }
    
    public function clear_cart($customer_id) {
        $cart_id = $this->get_active_cart_id($customer_id);
        if ($cart_id) {
             // We might want to just delete the items, or delete the cart itself.
             // Deleting items keeps the cart record.
             $sql = "DELETE FROM cart_items WHERE cart_id = '$cart_id'";
             return $this->db_query($sql);
        }
        return false;
    }
}
?>
