<?php
session_start();

include "db_connect.php"; // Include the database connection
include "signup_process.php";


if (isset($_SESSION['login_message'])) {
    $alertType = isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : 'info';
    echo "<div class ='container'>";
    echo "<div class='alert alert-$alertType alert-dismissible fade in' style='background-color:#7838de; padding: 5px;'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close' style=' font-size: 20px;'>&times;</a>";
    echo "<strong>" . htmlspecialchars($_SESSION['login_message']) . "</strong>";
    echo "</div>";
    echo "</div>";

    unset($_SESSION['login_message'], $_SESSION['alert_type']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body style="display: flex; height: 100vh;">
    <div class="login-container">
        <h2 style="text-align: center">LOGIN</h2>
        <form id="loginForm" method="POST" action="login_process.php">
            <h4>Email</h4>
            <input type="email" name="email" placeholder="Email" required>
            <h4>Password</h4>
            <input type="password" name="password" placeholder="Password" required>
            <a href="#" >Forgotten password?</a>
            <button type="submit" style="margin: 10px 0">Log In</button>
        </form>
        <!--CHECK HERE-->
        <p style="text-align: center; font-size: 0.8em; margin-top: 10px;">Don't have an account? <a href="signup.php">Sign Up</a></p>      
    </div>

    <!-- For Alert -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- For Alert JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <script src="java.js"></script>
</body>
</html>
