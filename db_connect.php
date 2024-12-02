<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "weekndwik";

//Initiate the connection
$conn = new mysqli($servername, $username, $password, $db);


// Check the connection if error
if ($conn->connect_error) {
    die("Error: Unable to connect to the database.");
}

?>
