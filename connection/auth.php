<?php
session_start();
include_once 'koneksi.php';
include_once 'user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (isset($_POST['kirim'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $keepLoggedIn = isset($_POST['keep_logged_in']);

    try {
        $loginSuccessful = $user->login($username, $password, $keepLoggedIn);
        if ($loginSuccessful) {
            $_SESSION['username'] = $username;  // Simpan username dalam sesi
            header("location: ../dashboard.php");
            exit;
        } else {
            $error = $user->getLastError();
            header("location: ../index.php?error=" . urlencode($error));
            exit;
        }
    } catch (PDOException $e) {
        error_log("Login PDO error: " . $e->getMessage());
        header("location: ../index.php?error=" . urlencode("Database error. Please try again later."));
        exit;
    } catch (Exception $e) {
        error_log("Login general error: " . $e->getMessage());
        header("location: ../index.php?error=" . urlencode("An unexpected error occurred. Please try again later."));
        exit;
    }
}
?>
