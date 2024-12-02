<?php
session_start();
include "db_connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>WeekndWIK</title>
</head>
<body style="padding: 20px;">
    <!-- Nav bar -->
    <ul class="topnav">
        <li>WeekndWIK</li>
        <div class="nav-center">
            <li><a href="index.php">HOME</a></li>
            <li><a href="album.php">ALBUM</a></li>
            <li><a href="song.php" class="active">SONG</a></li>
            <li><a href="favourite.php">MY FAV</a></li>
        </div>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Show logout button if user is logged in -->
            <li class="right"><a href="user.php"><span class="material-symbols-outlined">account_circle</span></a></li>
        <?php else: ?>
            <!-- Show login and signup buttons if user is NOT logged in -->
            <button class="nav-button"><a href="login.php">LOGIN</a></button>
            <button class="nav-button"><a href="signup.php">SIGN UP</a></button>
        <?php endif; ?>
    </ul>
    
    <!-- Search bar -->
    <div class="search-container" style="position: relative">
        <span class="material-symbols-outlined search-icon" style="color: gray">search</span>
        <form method="GET" action="song.php" style="display: flex; width: 100%;" required>
        <input id="search" style="margin: 0; border: 0;" class="search-input" type="text" name="search" placeholder="Search song...">
        <div id="results"></div>
            <button type="button" class="filter-button" onclick="openFilterPopup()">Filters</button> 
            <button type="submit" class="search-button">Search</button>
        </form>
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

    <?php
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        // Show search results
        include 'search_logic.php';
    } elseif (isset($_GET['genre']) || isset($_GET['year'])) {
        // Show filter results
        include 'filter_logic.php';
    } else {
        echo '<table class="songs-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Album</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>';
        include 'songtable_display.php';
        echo '</tbody></table>';
    }
    ?>
    

    <script>
        // Function to open the filter popup
        function openFilterPopup() {
            document.getElementById("filterPopup").style.display = "block";
        }

        // Function to close the filter popup
        function closeFilterPopup() {
            document.getElementById("filterPopup").style.display = "none";
        }

        // Close popup if clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById("filterPopup");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
       
        $(document).ready(function () {
    $("#search").on("keyup", function () {
        let query = $(this).val().trim();
        if (query.length > 0) {
            $.ajax({
                url: "search_logic.php",
                method: "POST",
                data: { search: query },
                success: function (data) {
                    $("#results").html(data).show();
                },
                error: function () {
                    $("#results").html("<div class='no-result'>Error fetching suggestions</div>").show();
                }
            });
        } else {
            $("#results").hide();
        }
    });

    // Redirect to the song detail page when a suggestion is clicked
    $(document).on("click", ".suggestion", function () {
        const href = $(this).data("href"); // Get the link from data-href
        window.location.href = href; // Redirect to the song page
    });

    // Close suggestions when clicking outside
    $(document).on("click", function (e) {
        if (!$(e.target).closest("#search, #results").length) {
            $("#results").hide();
        }
    });
});


    </script>
</body>
</html>

<style>.songs-table {
    width: 100%;
    border-collapse: collapse;
}

.songs-table th, .songs-table td {
    padding: 10px;
    border-bottom: 1px solid #333;
    text-align: left;
}

.songs-table th {
    font-weight: bold;
    color: #aaa;
}

.songs-table td {
    color: #eee;
    font-size: 16px;
}

.song-title {
    display: flex;
    align-items: center;
    font-size: 16px;
    cursor: pointer;
}

.cover-image {
    width: 40px; /* Adjust the size as needed /
    height: 40px;
    margin-right: 10px;
    border-radius: 5px; / Optional rounded corners */

}
</style>
