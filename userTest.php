// debug.php
<?php
session_start();
echo "User  ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not set') . "<br>";
echo "Email: " . (isset($_SESSION['email']) ? $_SESSION['email'] : 'Not set') . "<br>";
echo "Username: " . (isset($_SESSION['username']) ? $_SESSION['username'] : 'Not set') . "<br>";
echo "Password: " . (isset($_SESSION['password']) ? $_SESSION['password'] : 'Not set') . "<br>";
?>