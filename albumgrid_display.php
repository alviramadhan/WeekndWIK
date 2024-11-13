<div class="grid-container">
    <?php
    include 'db_connect.php'; // Connect to the database

    // Query to fetch all albums
    $sql = "SELECT album_id, title, cover_image_url FROM albums";
    $results = mysqli_query($conn, $sql);

    // Check if there are any albums to display
    if (mysqli_num_rows($results) > 0) {
        // Loop through each album and display it as a grid item
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<div class='grid-item album-item'>";
            echo "<a href='albumdetail_display.php?album_id=" . $row['album_id'] . "'>";
            echo "<img src='" . $row['cover_image_url'] . "' alt='Album Cover' class='cover-image' style='width:100%; height:auto; border-radius:8px;'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No albums found.</p>";
    }

    mysqli_close($conn);
    ?>
</div>
