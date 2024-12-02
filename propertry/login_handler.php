<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: admin/admin.php');
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header('Location: login.php');
            exit;
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
