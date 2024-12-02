<?php
include "db_connect.php"; // Include your database connection

// Initialize an empty array for storing results
$song_results = [];

// Check if filters are set (genre or year)
if (!empty($_GET['genre']) || !empty($_GET['year'])) {
    // Retrieve selected genres and years from the GET request
    $selected_genres = isset($_GET['genre']) ? $_GET['genre'] : [];
    $selected_years = isset($_GET['year']) ? $_GET['year'] : [];

    // Start building the SQL query
    $sql = "
        SELECT songs.song_id, songs.title, songs.duration, songs.audio_url, albums.cover_image_url, albums.title AS album_title
        FROM songs 
        JOIN albums ON songs.album_id = albums.album_id 
        LEFT JOIN song_genres ON songs.song_id = song_genres.song_id
        LEFT JOIN genres ON song_genres.genre_id = genres.genre_id
    ";


    // Build conditions based on filters
    $where_conditions = [];

    // Genre filtering (if genres are selected)
    if (!empty($selected_genres)) {
        $genre_ids = implode(',', array_map('intval', $selected_genres)); // Sanitize genre IDs
        $where_conditions[] = "genres.genre_id IN ($genre_ids)";
    }

    // Year filtering (if years are selected)
    if (!empty($selected_years)) {
        $year_values = implode(',', array_map('intval', $selected_years)); // Sanitize year values
        $where_conditions[] = "albums.release_year IN ($year_values)";
    }

    // Add conditions to SQL if there are any
    if (!empty($where_conditions)) {
        $sql .= " WHERE " . implode(" AND ", $where_conditions);
    }

    // Randomly order the results
    $sql .= " ORDER BY RAND()";
    
    // Execute the query and check for errors
    $results = mysqli_query($conn, $sql);

    // Check if query execution was successful
    if (!$results) {
        // Query failed, display the error message
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if there are results
    if (mysqli_num_rows($results) > 0) {
        // Start the table structure
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
        while ($row = mysqli_fetch_assoc($results)) {
            $song_id = $row['song_id'];
            $song_title = $row['title']; // Changed from song_title to title
            $audio_url = $row['audio_url'];
            $duration = $row['duration'];
            $album_title = $row['album_title']; // Added album_title
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
        echo "<p>No results found.</p>";
    }
}

// Close the database connection
mysqli_close($conn);

?>
