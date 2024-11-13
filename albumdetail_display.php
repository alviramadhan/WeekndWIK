
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    
    <title>WeekndWIK</title>
</head>

<body>
    <!-- Nav bar -->
    <ul class="topnav">
        <li>WeekndWIK</li>
        <div class="nav-center">
            <li><a href="index.php">HOME</a></li>
            <li><a href="album.php" class="active">ALBUM</a></li>
            <li><a href="song.php">SONG</a></li>
            <li><a href="favorite.html">MY FAV</a></li>
        </div>
        <button class="signup-button"><a href="login.php"> Log In </a></button>
        <button class="signup-button"><a href="signUp.html"> Sign Up </a></button>
        <li class="right"><a href="user.html"><span class="material-symbols-outlined">account_circle</span></a></li>
    </ul>
    


<?php
include 'db_connect.php'; // Database connection

// Fetch album details
$album_id = $_GET['album_id'];
$album_sql = "SELECT title, description, cover_image_url FROM albums WHERE album_id = $album_id";
$album_result = mysqli_query($conn, $album_sql);
$album = mysqli_fetch_assoc($album_result);

// Display album title and description
if ($album) {
    echo "<div class='album-header'>";
    echo "<img src='" . htmlspecialchars($album['cover_image_url']) . "' alt='Album Cover' class='album-cover' style='width:200px; height:auto;'>";
    echo "<h1>" . htmlspecialchars($album['title']) . "</h1>";
    echo "<p>" . htmlspecialchars($album['description']) . "</p>";
    echo "</div>";
} else {
    echo "<p>Album not found.</p>";
    exit;
}

// Fetch songs related to the album

$song_sql = "SELECT song_id, title, duration FROM songs WHERE album_id = $album_id";
$song_result = mysqli_query($conn, $song_sql);
?>

<table class="songs-table">
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Duration</th>
    </tr>

<?php
if (mysqli_num_rows($song_result) > 0) {
    $index = 1; // Initialize index for song numbering
    while ($song = mysqli_fetch_assoc($song_result)) {
        echo "<tr>";
        echo "<td>" . $index++ . "</td>";
        
        // Combine cover image and title into one <td>
        echo "<td>
        <div class='song-title'>
            <a href='songdetail_display.php?song_id=" . htmlspecialchars($song['song_id']) . "'>
                <img src='" . htmlspecialchars($album['cover_image_url']) . "' alt='Cover Image' class='cover-image'>
                <span class='song-title'>" . htmlspecialchars($song['title']) . "</span>
            </a>
        </div>
      </td>";
        
        echo "<td>" . htmlspecialchars($song['duration']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No songs found for this album.</td></tr>";
}
?>
</table>

<?php
// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
