
<?php
include "db_connect.php"; // Include the database connection
?>

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
            <li><a href="homepage.php" class="active">HOME</a></li>
            <li><a href="album.html">ALBUM</a></li>
            <li><a href="song.html">SONG</a></li>
            <li><a href="favorite.html">MY FAV</a></li>
        </div>
        <li class="right"><a href="user.html"><span class="material-symbols-outlined">account_circle</span></a></li>
    </ul>
    
    <!-- Search bar -->
    <div class="search-container">
        <span class="material-symbols-outlined">search</span>
        <input class="search-input" type="search" placeholder="Search album or song..">
        <button type="button" class="b1" onclick="openFilterPopup()">Filters</button>
        <button type="button" class="b2" onclick="">Search</button>
    </div>
    
    <!-- Filter Popup Modal -->
    <div id="filterPopup" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeFilterPopup()">&times;</span>
            <h2>Filter by</h2>
            <div>
                <h3>Genre</h3>
                <label><input type="checkbox" name="genre" value="Pop"> Pop</label><br>
                <label><input type="checkbox" name="genre" value="R&B"> RnB</label><br>
                <label><input type="checkbox" name="genre" value="Hip-Hop"> Hip-Hop</label><br>
            </div>
            <div>
                <h3>Year</h3>
                <label><input type="checkbox" name="year" value="2021"> 2021</label><br>
                <label><input type="checkbox" name="year" value="2020"> 2020</label><br>
                <label><input type="checkbox" name="year" value="2019"> 2019</label><br>
            </div> <br><br>
            <button type="button" onclick="applyFilters()">Apply Filters</button>
        </div>
    </div>
    
    <div class="image-container">
        <img src="theWeekndCover.jpg" alt="Cover"> 
        <h1 class="cover">THE<br>WEEKND</h1>
    </div>
    <br><br>
 
    <!-- Random Songs Section -->
    <div class="container">
        <h1>Random Songs</h1>
        <div class="grid-container">
            <?php include "random.php"; ?>
        </div>
    </div>
        </div>
    </div>
    
    <script>
        // Function to open the filter popup
        function openFilterPopup() {
            document.getElementById("filterPopup").style.display = "block";
        }

        // Function to close the filter popup
        function closeFilterPopup() {
            document.getElementById("filterPopup").style.display = "none";
        }

        // Function to apply filters (you can expand this for custom behavior)
        function applyFilters() {
            closeFilterPopup();
            alert("Filters applied!");
        }

        // Close popup if clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById("filterPopup");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>