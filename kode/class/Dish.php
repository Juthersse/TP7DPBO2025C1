<?php
require_once 'config/db.php';

class Dish {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
		
		if ($this->db == null) {
			die("❌ Database connection in Dish.php failed.");
		}
    }

    public function getAllDishes() {
        $stmt = $this->db->query("SELECT dishes.*, categories.name as category_name 
                                 FROM dishes 
                                 JOIN categories ON dishes.category_id = categories.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDishById($id) {
        $stmt = $this->db->prepare("SELECT dishes.*, categories.name as category_name 
                                   FROM dishes 
                                   JOIN categories ON dishes.category_id = categories.id 
                                   WHERE dishes.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createDish($name, $description, $price, $category_id) {
        $stmt = $this->db->prepare("INSERT INTO dishes (name, description, price, category_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $description, $price, $category_id]);
    }

    public function updateDish($id, $name, $description, $price, $category_id) {
        $stmt = $this->db->prepare("UPDATE dishes SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $price, $category_id, $id]);
    }

    public function deleteDish($id) {
        $stmt = $this->db->prepare("DELETE FROM dishes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function searchDishes($keyword) {
        $stmt = $this->db->prepare("SELECT dishes.*, categories.name as category_name 
                                   FROM dishes 
                                   JOIN categories ON dishes.category_id = categories.id 
                                   WHERE dishes.name LIKE ? OR dishes.description LIKE ?");
        $keyword = "%$keyword%";
        $stmt->execute([$keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
