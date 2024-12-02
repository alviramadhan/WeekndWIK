<?php
include "db_connect.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Debugging: Log the retrieved user data
            error_log("Retrieved user data: " . print_r($user, true));

            if (password_verify($password, $user['password_hash'])) {
                // Store user information in the session
                $_SESSION['user_id'] = $user['user_id']; // Ensure 'id' is the correct column name
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['password'] = $user['password_hash'];

                $_SESSION['login_message'] = "Login successful!";
                $_SESSION['alert_type'] = "success";
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['login_message'] = "Incorrect password.";
                $_SESSION['alert_type'] = "danger";
                header('Location: login.php');
                exit;
            }
        } else {
            $_SESSION['login_message'] = "No account found with this email.";
            $_SESSION['alert_type'] = "danger";
            header('Location: login.php');
            exit;
        }
    } else {
        $_SESSION['login_message'] = "Please fill out all fields.";
        $_SESSION['alert_type'] = "danger";
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}