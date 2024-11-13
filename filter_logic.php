<?php
include "db_connect.php"; // Include your database connection

// Initialize an empty array for storing results
$song_results = [];

// Check if filters are set
if (!empty($_GET['genre']) || !empty($_GET['year'])) {
    // Retrieve selected genres and years
    $selected_genres = isset($_GET['genre']) ? $_GET['genre'] : [];
    $selected_years = isset($_GET['year']) ? $_GET['year'] : [];

    // Start building the SQL query
    $sql = "
        SELECT songs.song_id, songs.title, songs.duration, songs.audio_url, albums.cover_image_url 
        FROM songs 
        JOIN albums ON songs.album_id = albums.album_id 
        LEFT JOIN song_genres ON songs.song_id = song_genres.song_id
        LEFT JOIN genres ON song_genres.genre_id = genres.genre_id
    ";

    // Build conditions based on filters
    $where_conditions = [];

    // Genre filtering
    if (!empty($selected_genres)) {
        $genre_ids = implode(',', array_map('intval', $selected_genres));
        $where_conditions[] = "genres.genre_id IN ($genre_ids)";
    }

    // Year filtering
    if (!empty($selected_years)) {
        $year_values = implode(',', array_map('intval', $selected_years));
        $where_conditions[] = "albums.release_year IN ($year_values)";
    }

    // Add conditions to SQL if there are any
    if (!empty($where_conditions)) {
        $sql .= " WHERE " . implode(" AND ", $where_conditions);
    }

    // Order randomly 
    $sql .= " ORDER BY RAND()";
    $results = mysqli_query($conn, $sql);

    // Fetch results if there are any
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_array($results)) {
            $song_results[] = $row;
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
