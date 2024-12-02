<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $song_id = intval($_POST['song_id']);
    $user_id = intval($_SESSION['user_id']);
    $rating = intval($_POST['rating']);
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);
    $review_date = date('Y-m-d H:i:s');

    $sql = "UPDATE reviews 
            SET rating = '$rating', review_text = '$review_text', review_date = '$review_date' 
            WHERE song_id = $song_id AND user_id = $user_id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['review_message'] = "Review updated successfully!";
    } else {
        $_SESSION['review_message'] = "Failed to update review.";
    }

    header("Location: songdetail_display.php?song_id=$song_id");
    exit();
}
?>
