<?php
session_start();
include 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "
    SELECT s.song_id, s.title, s.duration, s.audio_url, a.cover_image_url, a.title as album_title
    FROM liked_songs f
    JOIN songs s ON f.song_id = s.song_id
    JOIN albums a ON s.album_id = a.album_id
    WHERE f.user_id = $user_id";

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    <title>My Favorites</title>
</head>
<body style="padding: 20px">
    <!-- Nav bar -->
    <ul class="topnav">
        <li>WeekndWIK</li>
        <div class="nav-center">
            <li><a href="index.php">HOME</a></li>
            <li><a href="album.php">ALBUM</a></li>
            <li><a href="song.php">SONG</a></li>
            <li><a href="favourite.php" class="active">MY FAV</a></li>
        </div>
        <li class="right"><a href="user.php"><span class="material-symbols-outlined">account_circle</span></a></li>
    </ul>

    <div class="container">
        <h1 style="padding-top : 50px;">LIKED SONGS</h1>
        <table class="songs-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Album</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $index = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $index++; ?></td>
                            <td>
                                <a href="songdetail_display.php?song_id=<?= $row['song_id'] ?>">
                                    <div class="song-title">
                                        <div class="cover-image">
                                            <img src="<?= $row['cover_image_url'] ?>" alt="Cover Image" class="cover-image">
                                        </div>
                                        <span><?= $row['title'] ?></span>
                                    </div>
                                </a>
                            </td>
                            <td><?= $row['album_title'] ?></td>
                            <td><?= $row['duration'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">You have no favorite songs.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
