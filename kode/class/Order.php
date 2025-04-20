<?php
require_once 'config/db.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllOrders() {
        $stmt = $this->db->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrder($customer_name, $table_number, $status = 'pending') {
        $stmt = $this->db->prepare("INSERT INTO orders (customer_name, table_number, status, order_date) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$customer_name, $table_number, $status]);
        return $this->db->lastInsertId();
    }

    public function updateOrder($id, $customer_name, $table_number, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET customer_name = ?, table_number = ?, status = ? WHERE id = ?");
        return $stmt->execute([$customer_name, $table_number, $status, $id]);
    }

    public function deleteOrder($id) {
        // First delete related order items
        $stmt = $this->db->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->execute([$id]);
        
        // Then delete the order
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getOrderDetails($order_id) {
        $stmt = $this->db->prepare("SELECT oi.*, d.name as dish_name, d.price 
                                   FROM order_items oi
                                   JOIN dishes d ON oi.dish_id = d.id
                                   WHERE oi.order_id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOrderItem($order_id, $dish_id, $quantity) {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, dish_id, quantity) VALUES (?, ?, ?)");
        return $stmt->execute([$order_id, $dish_id, $quantity]);
    }

    public function removeOrderItem($item_id) {
        $stmt = $this->db->prepare("DELETE FROM order_items WHERE id = ?");
        return $stmt->execute([$item_id]);
    }

    public function updateOrderStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function searchOrders($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE customer_name LIKE ? OR table_number LIKE ?");
        $keyword = "%$keyword%";
        $stmt->execute([$keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
