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

// Check if the song is already in the user's favorites
$query_check = "SELECT * FROM liked_songs WHERE user_id = ? AND song_id = ?";
$stmt_check = $conn->prepare($query_check);

// Check if the prepare() call was successful
if ($stmt_check === false) {
    die('Error preparing SQL query: ' . $conn->error); // Show detailed error
}

$stmt_check->bind_param("ii", $user_id, $song_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // The song is already in the user's favorites
    echo "This song is already in your favorites.";
} else {
    // Insert the song into the favorites table if it is not already there
    $query = "INSERT INTO liked_songs (user_id, song_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    
    // Check if the prepare() call was successful
    if ($stmt === false) {
        die('Error preparing SQL query: ' . $conn->error); // Show detailed error
    }
    
    $stmt->bind_param("ii", $user_id, $song_id);

    if ($stmt->execute()) {
        header('Location: song.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close the prepared statement and connection
if (isset($stmt_check) && $stmt_check !== false) {
    $stmt_check->close();
}
if (isset($stmt) && $stmt !== false) {
    $stmt->close();
}
$conn->close();
?>
