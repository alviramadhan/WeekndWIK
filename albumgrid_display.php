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
            echo "<div class='grid-item album-item' onclick='openPopup(" . $row['album_id'] . ")'>";
            echo "<a href='albumdetail_display.php?album_id=" . $row['album_id'] . "'>";       
            echo "<img src='" . $row['cover_image_url'] . "' alt='Album Cover' class='cover-image' style='width:100%; height:auto; border-radius:8px;'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "</div>";
        }
    } else {
        echo "<p>No albums found.</p>";
    }

    mysqli_close($conn);
    ?>
</div>

<!-- Popup Structure -->
<div id="albumPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <div id="popupDetails"></div>
    </div>
</div>

<script>
    // Function to open the popup
    function openPopup(albumId) {
        fetch('fetch_album_details.php?album_id=' + albumId)
            .then(response => response.text())
            .then(data => {
                document.getElementById('popupDetails').innerHTML = data;
                document.getElementById('albumPopup').style.display = 'block';
            });
    }

    // Function to close the popup
    function closePopup() {
        document.getElementById('albumPopup').style.display = 'none';
    }
</script>