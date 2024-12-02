<?php
include "db_connect.php"; 
include "filter_logic.php"; 
session_start();

if (isset($_SESSION['login_message'])) {
    $alertType = isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : 'info';
    echo "<div class ='container'>";
    echo "<div class='alert alert-$alertType alert-dismissible fade in' style='background-color:#7838de; padding: 5px;'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close' style=' font-size: 20px;'>&times;</a>";
    echo "<strong>" . htmlspecialchars($_SESSION['login_message']) . "</strong>";
    echo "</div>";
    echo "</div>";

    unset($_SESSION['login_message'], $_SESSION['alert_type']);
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <!-- Material Symbols Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    
    <title>WeekndWIK</title>
</head>

<body style="padding:20px;">
    <!-- Nav bar -->
    <ul class="topnav">
        <li>WeekndWIK</li>
        <div class="nav-center">
            <li><a href="index.php" class="active">HOME</a></li>
            <li><a href="album.php">ALBUM</a></li>
            <li><a href="song.php">SONG</a></li>
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
          
    

    <!-- hero --> 
    <div class="image-container">
        <img src="theWeekndCover.jpg" alt="Cover"> 
        <h1 class="cover">THE<br>WEEKND</h1>
    </div>
    <br><br>


    <!-- Random Songs Section -->
    <div class="trending-container">
        <h1>Random Songs</h1>
        <div class="grid-container">
            <?php include "random_display.php"; ?>
        </div>
    </div>
   
    <!-- For Alert -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- For Alert JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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