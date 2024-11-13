<?php
include 'db_connect.php';

$query = "SELECT s.song_id, s.title, s.duration, s.audio_url, a.cover_image_url, a.title as album_title
          FROM songs s 
          JOIN albums a ON s.album_id = a.album_id";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $index = 1;
    while ($row = $result->fetch_assoc()) {
        $song_id = $row['song_id']; // Ensure $song_id is defined here
        echo "<tr>";
        echo "<td>" . $index++ . "</td>";
        
        // Wrap the entire cell content in an <a> tag
        echo "<td>
                <a href='songdetail_display.php?song_id={$song_id}' style= inherit;'>
                    <div class='song-title'>
                        <div class='cover-image'>
                            <img src='{$row['cover_image_url']}' alt='Cover Image' class='cover-image'>
                        </div>
                        <span>{$row['title']}</span>
                    </div>
                </a>
              </td>";
        
        echo "<td>" . $row['album_title'] . "</td>";
        echo "<td>" . $row['duration'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<p>No songs found for this filter.</p>";
}
?>
