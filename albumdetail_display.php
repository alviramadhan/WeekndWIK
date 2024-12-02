<?php
session_start();
include 'db_connect.php';

// Fetch album details
$album_id = $_GET['album_id'];
$album_sql = "SELECT title, description, cover_image_url, release_year FROM albums WHERE album_id = ?";
$album_stmt = $conn->prepare($album_sql);
$album_stmt->bind_param("i", $album_id);
$album_stmt->execute();
$album_result = $album_stmt->get_result();
$album = $album_result->fetch_assoc();

// Fetch songs related to the album
$song_sql = "SELECT song_id, title, duration FROM songs WHERE album_id = ?";
$song_stmt = $conn->prepare($song_sql);
$song_stmt->bind_param("i", $album_id);
$song_stmt->execute();
$song_result = $song_stmt->get_result();

// Calculate total duration and song count
if (mysqli_num_rows($song_result) > 0) {
    $song_count = 0;
    $total_duration_seconds = 0;

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
} else {
    $song_count = 0;
    $formatted_total_duration = "00:00:00";
}

// Fetch songs related to the album
$song_sql = "SELECT song_id, title, duration FROM songs WHERE album_id = ?";
$song_stmt = $conn->prepare($song_sql);
$song_stmt->bind_param("i", $album_id);
$song_stmt->execute();
$song_result = $song_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    <title>WeekndWIK</title>
    
    <style>
        .album-info {
            padding: 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
        }

        .album-item {
            margin: 10px;
        }

        .album-cover {
            max-width: 300px;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <!-- Nav bar -->
    <ul class="topnav">
        <li>WeekndWIK</li>
        <div class="nav-center">
            <li><a href="index.php">HOME</a></li>
            <li><a href="album.php" class="active">ALBUM</a></li>
            <li><a href="song.php">SONG</a></li>
            <li><a href="favourite.php">MY FAV</a></li>
        </div> 
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <li class="right"><a href="user.php"><span class="material-symbols-outlined">account_circle</span></a></li>
        <?php else: ?>
            <button class="nav-button"><a href="login.php">LOGIN</a></button>
            <button class="nav-button"><a href="signup.php">SIGN UP</a></button>
        <?php endif; ?>
    </ul>

    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-3">
                <img src="<?php echo htmlspecialchars($album['cover_image_url']); ?>" alt="Album Cover" class="album-cover">
            </div>
            <div class="col-7">
                <h2><?php echo htmlspecialchars($album['title']); ?></h2>
                <p><?php echo htmlspecialchars($album['description']); ?></p>
                <p><strong>Year:</strong> <?php echo htmlspecialchars($album['release_year']); ?></p>

                <!-- Display total songs and total duration -->
                <p><strong>Duration:</strong> <?php echo $formatted_total_duration; ?></p>
                <p><strong>Total Songs:</strong> <?php echo $song_count; ?> Songs</p>
            </div>
        </div>
        </div>
        <div style="padding: 20px; width: 100%;">
            <table class="songs-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($song_result->num_rows > 0): ?>
                        <?php $index = 1; ?>
                        <?php while ($song = $song_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $index++; ?></td>
                                <td>
                                    <div class="song-title">
                                        <a href="songdetail_display.php?song_id=<?php echo htmlspecialchars($song['song_id']); ?>">
                                            <img src="<?php echo htmlspecialchars($album['cover_image_url']); ?>" alt="Cover Image" class="cover-image">
                                            <span><?php echo htmlspecialchars($song['title']); ?></span>
                                        </a>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($song['duration']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3">No songs found for this album.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</body>
</html>
