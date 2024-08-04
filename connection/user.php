<?php
session_start();
class User {
    private $conn;
    private $table_name = "users";
    private $last_error = '';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function authenticate($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && $password == $row['password']) {
            return $row;
        }

        $this->last_error = "Invalid username or password.";
        return false;
    }

    public function login($username, $password, $keepLoggedIn) {
        $authenticatedUser = $this->authenticate($username, $password);
        if ($authenticatedUser) {
            // Simpan sesi pengguna
            $_SESSION['username'] = $authenticatedUser['username'];
            $_SESSION['role'] = $authenticatedUser['role']; // Menambahkan role ke session
            $_SESSION['user_id'] = $authenticatedUser['id'];
            $_SESSION['keep_logged_in'] = $keepLoggedIn;
            return true;
        } else {
            return false;
        }
    }
    

    public function getLastError() {
        return $this->last_error;
    }
}

