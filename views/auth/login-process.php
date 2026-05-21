<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';

if (isset($_POST['login'])) {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {

        $_SESSION['error'] = "Email or password is empty";
        header("Location: login.php");
        exit;
    }

    try {

        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['password']) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: dashboard.php");
            exit;
        } else {

            $_SESSION['error'] = "Invalid credentials";
            header("Location: login.php");
            exit;
        }
    } catch (PDOException $e) {

        $_SESSION['error'] = $e->getMessage();
        header("Location: login.php");
        exit;
    }
}
