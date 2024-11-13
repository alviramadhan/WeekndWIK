<?php
include "db_connect.php"; // Include the database connection
?>
<?php
include "filter_logic.php"; // Include the database connection
?>
<?php include "search_logic.php";?>

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
            <li><a href="album.php" >ALBUM</a></li>
            <li><a href="song.php" class="active">SONG</a></li>
            <li><a href="favorite.html">MY FAV</a></li>
        </div>
       
        <button class="signup-button"><a href="login.php"> Log In </a></button>
        <button class="signup-button"><a href="signUp.php"> Sign Up </a></button>
        <li class="right"><a href="user.html"><span class="material-symbols-outlined">account_circle</span></a></li>
    </ul>
    
<!-- Search bar with form -->
<div class="search-container">
    <form method="GET" action="song.php">
        <span class="material-symbols-outlined">search</span>
        <input class="search-input" type="text" name="search" placeholder="Search an album or song..." required>
        <button type="submit" class="b2">Search</button>
            
    </form>
    <button type="button" class="b1" onclick="openFilterPopup()">Filters</button> 
       
</div>




          <!-- Filter Form and Modal -->
    <div id="filterPopup" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeFilterPopup()">&times;</span>
            <h2>Filter by</h2>
            <form method="GET" action="song.php">
                <div>
                    <h3>Genre</h3>
                    <label><input type="checkbox" name="genre[]" value="1"> Alternative R&B</label><br>
                    <label><input type="checkbox" name="genre[]" value="2"> Pop</label><br>
                    <label><input type="checkbox" name="genre[]" value="3"> R&B</label><br>
                    <label><input type="checkbox" name="genre[]" value="4"> Synthwave</label><br>
                    <label><input type="checkbox" name="genre[]" value="5"> Synth-Pop</label><br>
                
                </div>
                <div>
                    <h3>Year</h3>
                    <label><input type="checkbox" name="year[]" value="2012"> 2012</label><br>
                    <label><input type="checkbox" name="year[]" value="2013"> 2013</label><br>
                    <label><input type="checkbox" name="year[]" value="2015"> 2015</label><br>
                    <label><input type="checkbox" name="year[]" value="2016"> 2016</label><br>
                    <label><input type="checkbox" name="year[]" value="2018"> 2018</label><br>
                    <label><input type="checkbox" name="year[]" value="2020"> 2020</label><br>
                    <label><input type="checkbox" name="year[]" value="2022"> 2022</label><br>
                <button type="submit">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>


    <br>
    <div class="container">
        <h1>Results</h1>
        <div class="grid-container">
            <?php if (!empty($song_results)): ?>
                <?php foreach ($song_results as $row): ?>
                    <div class="grid-item">
                        <img src="<?= htmlspecialchars($row['cover_image_url']); ?>" alt="Album Cover" style="width:100%; height:auto; border-radius:8px;">
                        <h3 class="title"><?= htmlspecialchars($row['title']); ?></h3>
                        <p>Duration: <?= htmlspecialchars($row['duration']); ?></p>
                        <a href="<?= htmlspecialchars($row['audio_url']); ?>" target="_blank" class="btn btn-primary">Play Song</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No songs found for this filter.</p>
            <?php endif; ?>
        </div>

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
        <?php include 'songtable_display.php'; ?>
    </tbody>
</table>


    
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