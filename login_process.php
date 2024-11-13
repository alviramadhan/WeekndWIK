<?php
include "db_connect.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['login_message'] = "Login successful!";
                $_SESSION['alert_type'] = "success";
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['login_message'] = "Invalid password.";
                $_SESSION['alert_type'] = "danger";
                header('Location: login.php');
                exit;
            }
        } else {
            $_SESSION['login_message'] = "No account found with that email.";
            $_SESSION['alert_type'] = "danger";
            header('Location: login.php');
            exit;
        }
    } else {
        $_SESSION['login_message'] = "Please provide both email and password.";
        $_SESSION['alert_type'] = "danger";
        header('Location: login.php');
        exit;
    }
} else {
    echo " ";
}

$conn->close();
