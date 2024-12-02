<?php
include 'db_connect.php';

if (isset($_GET['song_id'])) {
    $song_id = intval($_GET['song_id']);

    // Prepare the SQL query to fetch song details
    $sql = 
        "SELECT s.song_id as song_id, s.title AS song_title, a.title AS album_title, a.release_year, s.duration, a.genre, s.audio_url
        FROM songs s
        JOIN albums a ON s.album_id = a.album_id
        WHERE s.song_id = ?";
    
    // Check if the query preparation is successful
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter (song_id)
        $stmt->bind_param("i", $song_id);
        
        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $song = $result->fetch_assoc();
                echo "<h2><a href='songdetail_display.php?song_id="  . htmlspecialchars($song['song_id']) . "'>"  . htmlspecialchars($song['song_title']) . "</a> </h2>";
                echo "<p><strong>Album:</strong> " . htmlspecialchars($song['album_title']) . "</p>";
                echo "<p><strong>Year:</strong> " . htmlspecialchars($song['release_year']) . "</p>";
                echo "<p><strong>Duration:</strong> " . htmlspecialchars($song['duration']) . "</p>";
                echo "<p><strong>Genre:</strong> " . htmlspecialchars($song['genre']) . "</p>";
            // "Play Song" link
        echo "<p><a href='" . htmlspecialchars($song['audio_url']) . "' target='_blank'>Play Song</a></p>";
        
        // Link to song details
        echo "<p><a href='songdetail_display.php?song_id=$song_id'>View Song Details</a></p>";
        echo "</div>";
           
            } else {
                echo "<p>Song details not found.</p>";
            }
        } else {
            echo "<p>Error executing query: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // If the prepare fails, show the error
        echo "<p>Error preparing query: " . $conn->error . "</p>";
    }

    // Close the connection
    $conn->close();
} else {
    echo "<p>Invalid song ID.</p>";
}
?>
