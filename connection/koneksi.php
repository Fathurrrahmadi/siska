<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database {
    private $host = 'localhost';
    private $db_name = 'siska_a';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8mb4");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $exception) {
            // Tangani error koneksi
            error_log("Connection error: " . $exception->getMessage()); // Log error
            throw new PDOException("Connection failed: " . $exception->getMessage()); // Melempar exception agar error bisa ditangani di tempat lain
        }

        return $this->conn;
    }
}


?>
