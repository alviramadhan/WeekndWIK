<?php
session_start();
include 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$song_id = $_POST['song_id'];  // Assuming song_id is passed via POST

// Step 1: Remove the song from the favorites table
$query_remove = "DELETE FROM liked_songs WHERE user_id = ? AND song_id = ?";
$stmt_remove = $conn->prepare($query_remove);

// Check if the prepare() call was successful
if ($stmt_remove === false) {
    die('Error preparing SQL query: ' . $conn->error); // Show detailed error
}

$stmt_remove->bind_param("ii", $user_id, $song_id);

if ($stmt_remove->execute()) {
    // Redirect to favorite page after removing from favorites
    header('Location: song.php');
    exit();
} else {
    echo "Error: " . $stmt_remove->error;
}

// Close the prepared statement and connection
if (isset($stmt_remove) && $stmt_remove !== false) {
    $stmt_remove->close();
}
$conn->close();
?>
