<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $song_id = $_POST['song_id'];
    $user_id = $_SESSION['user_id']; // Assuming user is logged in
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $review_date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO reviews (song_id, user_id, rating, review_text, review_date) 
            VALUES ('$song_id', '$user_id', '$rating', '$review_text', '$review_date')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Review submitted successfully!";
    } else {
        $_SESSION['message'] = "Failed to submit review.";
    }

    header("Location: songdetail_display.php?song_id=$song_id");
    exit();
}
?>
