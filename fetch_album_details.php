<?php
include 'db_connect.php'; // Connect to the database

if (isset($_GET['album_id'])) {
    $album_id = intval($_GET['album_id']);
    
    // Fetch album details
    $album_sql = "SELECT title, description, cover_image_url FROM albums WHERE album_id = $album_id";
    $album_result = mysqli_query($conn, $album_sql);

    if ($album = mysqli_fetch_assoc($album_result)) {
        // Album Header
        echo "<div class='album-header'>";
        echo "<h1><a href='albumdetail_display.php?album_id=" . htmlspecialchars($album_id) . "'>" . htmlspecialchars($album['title']) . "</a></h1>";
        echo "<a href='albumdetail_display.php?album_id=" . htmlspecialchars($album_id) . "'>
                <img src='" . htmlspecialchars($album['cover_image_url']) . "' alt='Album Cover' style='width:100%; height:auto; border-radius:8px;'>
              </a>";
        echo "<p>" . htmlspecialchars($album['description']) . "</p>";
        echo "</div>";
    } else {
        echo "<p>Album details not found.</p>";
    }

    // Fetch songs related to the album
    $song_sql = "SELECT title, duration FROM songs WHERE album_id = $album_id";
    $song_result = mysqli_query($conn, $song_sql);

    if (mysqli_num_rows($song_result) > 0) {
        $song_count = 0;
        $total_duration_seconds = 0;

        // Loop through songs to calculate total duration and count
        while ($song = mysqli_fetch_assoc($song_result)) {
            $duration = $song['duration'];
            list($hours, $minutes, $seconds) = explode(":", $duration);
            $duration_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
            $total_duration_seconds += $duration_seconds;
            $song_count++;
        }

        // Calculate total duration
        $total_hours = floor($total_duration_seconds / 3600);
        $remaining_minutes = floor(($total_duration_seconds % 3600) / 60);
        $total_seconds = $total_duration_seconds % 60;
        $formatted_total_duration = sprintf("%02d:%02d:%02d", $total_hours, $remaining_minutes, $total_seconds);

        // Display total songs and total duration
        echo "<div class='album-details'>";
        echo "<p><strong>Total Duration:</strong> " . $formatted_total_duration . "</p>";
        echo "<p><strong>Total Songs:</strong> " . $song_count . "</p>";
        echo "<ul>";

        // Reset result pointer and display song list
        mysqli_data_seek($song_result, 0);
        while ($song = mysqli_fetch_assoc($song_result)) {
            echo "<li>" . htmlspecialchars($song['title']) . " - " . htmlspecialchars($song['duration']) . "</li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<p>No songs found for this album.</p>";
    }

    mysqli_close($conn);
} else {
    echo "<p>Invalid album ID.</p>";
}
?>
