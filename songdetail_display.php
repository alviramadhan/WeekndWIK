<?php
include "db_connect.php"; // Database connection

// Get song_id from the URL
$song_id = isset($_GET['song_id']) ? intval($_GET['song_id']) : 0;

// Fetch song details including title, cover image, duration, genre, and description
$sql = "
    SELECT s.title, s.duration, s.description, a.cover_image_url, g.genre_name, a.release_year, s.audio_url
    FROM songs s
    LEFT JOIN albums a ON s.album_id = a.album_id
    LEFT JOIN song_genres sg ON s.song_id = sg.song_id
    LEFT JOIN genres g ON sg.genre_id = g.genre_id
    WHERE s.song_id = $song_id";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $song = mysqli_fetch_assoc($result);
} else {
    echo "Song not found.";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    <title>WeekndWIK</title>
</head>
<body>
    <!-- Nav bar -->
    <ul class="topnav">
        <li>WeekndWIK</li>
        <div class="nav-center">
            <li><a href="index.php">HOME</a></li>
            <li><a href="album.php" >ALBUM</a></li>
            <li><a href="song.php" class="active">SONG</a></li>
            <li><a href="favorite.html">MY FAV</a></li>
        </div>
        <button class="signup-button"><a href="login.php"> Log In </a></button>
        <button class="signup-button"><a href="signUp.php"> Sign Up </a></button>
        <li class="right"><a href="user.html"><span class="material-symbols-outlined">account_circle</span></a></li>
    </ul>
    
    <div class="song-detail-container grid-item">
        <img src="<?= htmlspecialchars($song['cover_image_url']); ?>" alt="Album Cover" class="album-cover" style='width:200px; height:auto;'>
        <h1 class="title"><?= htmlspecialchars($song['title']); ?></h1>
        <p><strong>Duration:</strong> <?= htmlspecialchars($song['duration']); ?></p>
        <p><strong>Release Date:</strong> <?= htmlspecialchars($song['release_year']); ?></p>
        <p><strong>Genre:</strong> <?= htmlspecialchars($song['genre_name']); ?></p>
        <p><strong>Description:</strong><br> <?= htmlspecialchars($song['description']); ?></p>
        <a href="<?= htmlspecialchars($song['audio_url']); ?>" target="_blank" class="btn btn-primary">Play Song</a>
    </div>
</body>
</html>
