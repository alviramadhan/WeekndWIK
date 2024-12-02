<?php
include 'db_connect.php'; // Connect to the database

// Query to select random songs along with album cover URL
$sql = "
    SELECT songs.song_id, songs.title, songs.duration, songs.audio_url, albums.cover_image_url 
    FROM songs 
    JOIN albums ON songs.album_id = albums.album_id 
    ORDER BY RAND() LIMIT 5
";

$results = mysqli_query($conn, $sql);

// Check if we have songs to display
if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_array($results)) {
        $song_id = $row['song_id'];
        $title = $row['title'];
        $duration = $row['duration'];
        $audio_url = $row['audio_url'];
        $cover_image_url = $row['cover_image_url'];
        
        // Display each song with the album cover image
        echo "<div class='grid-item'>";
        // Add link to songdetail_display.php with the song_id parameter
        echo "<a href='songdetail_display.php?song_id=$song_id'>";
        echo "<img src='$cover_image_url' alt='Album Cover' style='width:100%; height:auto; border-radius:8px;'>";
        echo "<h3 class='title'>$title</h3>";
        echo "</a>";
        echo "<p>Duration: $duration</p>";
        echo "<a href='$audio_url' target='_blank' class='btn btn-primary'>Play Song</a>";
        echo "</div>";
    }
} else {
    echo "<p>No songs found.</p>";
}
?>


