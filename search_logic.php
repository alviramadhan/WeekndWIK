<?php
include "db_connect.php";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $query = "
        SELECT s.song_id, s.title AS song_title, s.audio_url, s.duration, 
               a.title AS album_title, a.cover_image_url
        FROM songs s
        LEFT JOIN albums a ON s.album_id = a.album_id
        WHERE s.title LIKE '%$search%'
    ";

    $result = mysqli_query($conn, $query);

    // Check if any results were returned
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='songs-table'>";
        echo "<thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Album</th>
                    <th>Duration</th>
                </tr>
              </thead>";
        echo "<tbody>";

        $index = 1;

        // Loop through the results
        while ($row = mysqli_fetch_assoc($result)) {
            $song_id = $row['song_id'];
            $song_title = $row['song_title'];
            $audio_url = $row['audio_url'];
            $duration = $row['duration'];
            $album_title = $row['album_title'];
            $cover_image = $row['cover_image_url'];

            echo "<tr>";
            echo "<td>" . $index++ . "</td>";
            echo "<td>
                    <a href='songdetail_display.php?song_id=$song_id'>
                        <div class='song-title'>
                            <div class='cover-image'>
                                <img src='$cover_image' alt='Cover Image' class='cover-image'>
                            </div>
                            <span>$song_title</span>
                        </div>
                    </a>
                  </td>";
            echo "<td>$album_title</td>";
            echo "<td>$duration</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No results found for '$search'.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);

    // Query for both songs and albums
    $query = "
        (SELECT 'song' AS type, s.song_id AS id, s.title AS name, a.title AS album_name
         FROM songs s
         LEFT JOIN albums a ON s.album_id = a.album_id
         WHERE s.title LIKE '%$search%')
        UNION
        (SELECT 'album' AS type, a.album_id AS id, a.title AS name, NULL AS album_name
         FROM albums a
         WHERE a.title LIKE '%$search%')
        LIMIT 10
    ";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $type = $row['type']; // Type (song or album)
            $id = htmlspecialchars($row['id']);
            $name = htmlspecialchars($row['name']);
            $album_name = htmlspecialchars($row['album_name']);
            $href = ($type === 'song') ? "songdetail_display.php?song_id=$id" : "albumdetail_display.php?album_id=$id"; // Generate link based on type

            if ($type === 'song') {
                echo "<div class='suggestion' data-href='$href'>$name - $album_name</div>";
            } else {
                echo "<div class='suggestion' data-href='$href'>Album: $name</div>";
            }
        }
    } else {
        echo "<div class='no-result'>No suggestions found</div>";
    }
}


mysqli_close($conn);
?>
