<?php
include "db_connect.php"; // Include the database connection
include "signup_process.php";
?>

<?php
session_start();
if (isset($_SESSION['signup_message'])) {
    $alertType = $_SESSION['alert_type'] ?? 'info';
    echo "<div class='container'>";
    echo "<div class='alert alert-$alertType alert-dismissible fade in' style='background-color:#7838de; padding: 5px; border: 20px; margin: 10px;'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close' style=' font-size: 20px;'>&times;</a>";
    echo "<strong>" . htmlspecialchars($_SESSION['signup_message']) . "</strong>";
    echo "</div>";
    echo "</div>";
    unset($_SESSION['signup_message'], $_SESSION['alert_type']);
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body style="display: flex; height: 100vh;">
  
<div class="login-container">
    <h2 style="text-align: center">SIGN UP</h2>
    <form method="POST" action="signup_process.php">
        <h4>Username</h4>
        <input type="text" name="username" placeholder="Username" required>
        <h4>Email</h4>
        <input type="email" name="email" placeholder="Email" required>
        <h4>Password</h4>
        <input type="password" name="password" placeholder="Password" required>
        <h4>Confirm Password</h4>
        <input type="password" name="confirmPassword" placeholder="Confirm Password" required>

        <button type="submit" style="margin: 10px 0">Sign Up</button>
    </form>
    
    <p style="text-align: center; font-size: 0.8em; margin-top: 10px;">
        Already have an account? <a href="login.php">Log In</a>
    </p>
</div>
    
    <!-- For Alert -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- For Alert JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
