<?php
include 'db_connect.php';
$query = "SELECT s.song_id, s.title, s.duration, s.audio_url, a.cover_image_url, a.title as album_title
          FROM songs s 
          JOIN albums a ON s.album_id = a.album_id";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $index = 1;
    while ($row = $result->fetch_assoc()) {
        $song_id = $row['song_id']; 
        $song_title = $row['title'];
        $album_title = $row['album_title'];
        $cover_image_url = $row['cover_image_url'];
        $duration = $row['duration'];

        // Check if the song is already in the favorites (optional, to handle toggle functionality)
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $liked = false;
        if ($user_id) {
            $check_favorite_query = "SELECT * FROM liked_songs WHERE user_id = ? AND song_id = ?";
            $stmt = $conn->prepare($check_favorite_query);
            $stmt->bind_param("ii", $user_id, $song_id);
            $stmt->execute();
            $result_check = $stmt->get_result();
            if ($result_check->num_rows > 0) {
                $liked = true;
            }
            $stmt->close();
        }

        echo "<tr class='song-row' data-song-id='{$song_id}'>";
        echo "<td>" . $index++ . "</td>";

        // Wrap the song title and image with an onclick event
        echo "<td>
                <div class='song-title' onclick='openPopup({$song_id})' >
                    <div class='cover-image'>
                        <img src='{$cover_image_url}' alt='Cover Image' class='cover-image'>
                    </div>
                    <span>{$song_title}</span>
                </div>
              </td>";

        echo "<td>{$album_title}</td>";

        // Add the Love button and handle the favorite state
        if ($liked) {
            // If the song is liked, show the filled heart
            echo "<td>
                    <form method='POST' action='remove_from_favourites.php'>
                        <input type='hidden' name='song_id' value='{$song_id}'>
                        <button type='submit' class='love-button' style='background-color: black;'>❤️</button>
                    </form>
                  </td>";
        } else {
            // If the song is not liked, show the unfilled heart
            echo "<td>
                    <form method='POST' action='add_to_favourites.php'>
                        <input type='hidden' name='song_id' value='{$song_id}'>
                        <button type='submit' class='love-button' style='background-color: black;'>🤍</button>
                    </form>
                  </td>";
        }

        echo "<td>{$duration}</td>";
        echo "</tr>";
    }
} else {
    echo "<p>No songs found for this filter.</p>";
}
?>

<!-- Popup Modal -->
<div id="songPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <div id="popupDetails"></div>
    </div>
</div>

<script>
// Function to open the popup and fetch song details
function openPopup(songId) {
    fetch('fetch_song_details.php?song_id=' + songId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('popupDetails').innerHTML = data;
            document.getElementById('songPopup').style.display = 'block';
        });
}

// Function to close the popup
function closePopup() {
    document.getElementById('songPopup').style.display = 'none';
}
</script>