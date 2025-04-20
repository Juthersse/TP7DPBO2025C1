<?php
class Database {
    private $host = "localhost";
    private $port = "3307";
    private $username = "root";
    private $password = "";
    private $dbname = "restoran_db";
    public $conn;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("❌ Connection failed in Database.php: " . $e->getMessage());
        }
    }
}
?>
