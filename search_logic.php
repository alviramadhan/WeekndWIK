<?php
// Include database connection
include "db_connect.php";

// Check if search term is provided
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    // SQL query to search in both albums and songs
    $query = "
        SELECT s.song_id, s.title AS song_title, s.audio_url, s.duration, 
               a.title AS album_title, a.cover_image_url
        FROM songs s
        LEFT JOIN albums a ON s.album_id = a.album_id
        WHERE s.title LIKE '%$search%' OR a.title LIKE '%$search%'
    ";

    $result = mysqli_query($conn, $query);

    // Check if any results were returned
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='grid-container'>"; // Start the grid container for displaying results

        // Loop through the results
        while ($row = mysqli_fetch_assoc($result)) {
            // Define variables with data from the result
            $song_id = $row['song_id'];
            $song_title = $row['song_title'];
            $audio_url = $row['audio_url'];
            $duration = $row['duration'];
            $album_title = $row['album_title'];
            $cover_image = $row['cover_image_url'];

            // Display each result in a grid item
            echo "<div class='grid-item'>";
            // Add link to songdetail_display.php with the song_id parameter
            echo "<a href='songdetail_display.php?song_id=$song_id'>";
            echo "<img src='$cover_image' alt='Album Cover' style='width:100%; height:auto; border-radius:8px;'>";
            echo "<h3 class='title'>$song_title</h3>";
            echo "</a>";
            echo "<p>Duration: $duration</p>";
            echo "<a href='$audio_url' target='_blank' class='btn btn-primary'>Play Song</a>";
            echo "</div>";
        }

        echo "</div>"; // Close the grid container
    } else {
        // No results found
        echo "<p>No results found for '$search'.</p>";
    }
} else {
    echo "";
}

// Close the database connection
mysqli_close($conn);
?>
