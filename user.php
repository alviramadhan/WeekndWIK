<?php
include "db_connect.php"; 
session_start();

// Handle logout
if (isset($_POST['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to homepage or login page
    exit(); // Ensure the script stops here
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch total reviews and average rating for the logged-in user
$sql = "SELECT COUNT(*) AS total_reviews, 
               ROUND(AVG(rating), 2) AS average_rating 
        FROM reviews 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$total_reviews = $data['total_reviews'] ?? 0;
$average_rating = $data['average_rating'] ?? '0.00';

// Update user details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_details'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];

    $update_sql = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $new_username, $new_email, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['username'] = $new_username;
        $_SESSION['email'] = $new_email;
        $success_message = "Details updated successfully!";
    } else {
        $error_message = "Failed to update details. Please try again.";
    }
}
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
    
    
    <style>
        .reviewStatistic-container {
            text-decoration: none;
            padding :20px;
            display: flex;
            justify-content: space-around; 
            align-items: center; 
            margin-top: 20px;
            text-align: center; 
            border: solid white 3px;
            border-radius: 8px;
            background:#1E1E1E;
        }

        /* Styling for each statistic item */
        .statistic-item {
            flex: 1; 
            margin: 10px;
        }

        .rs-heading {
            margin: 5px 0;
            font-size: 2.5em;
            font-weight: bolder;
        }

        img.circular-image{
            width: 40%;
            height: auto;
            border-radius: 50%;
            border: 5px solid white;
        }

        .accountContainer{
            margin: 20px 0;
            padding: 8%;
            border: 3px solid white;
            border-radius: 8px;
        }

        input.account-detail {
            width: 100%;
            font-size: 15px;
            padding: 4px;
            border-radius: 6px;
            display: block;
            margin-left: auto; 
            margin-right: auto;
        }
        
        
        button.logout-button{
            background: #FF6363;
            font-size: 20px;
            color: white;
            width: 80%;
            font-weight: bold;
            display: block;
            margin-left: auto; margin-right: auto;
        }
        button.logout-button:hover{
            background: darkred;
        }
    </style>
</head>

<body>
    <!-- Nav bar -->
    <ul class="topnav">
        <li>WeekndWIK</li>
        <div class="nav-center">
            <li><a href="index.php">HOME</a></li>
            <li><a href="album.php">ALBUM</a></li>
            <li><a href="song.php">SONG</a></li>
            <li><a href="favourite.php">MY FAV</a></li>
        </div>
        <li class="right"><a href="user.html" class="active"><span class="material-symbols-outlined">account_circle</span></a></li>
    </ul>
    
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <h2><br>Review Statistic<br></h2>
            <a href="user_reviews.php?user_id=<?php echo $user_id; ?>" class="reviewStatistic-container">
                <div class="statistic-item">
                    <h4>Total<br>Review</h4>
                    <h1 class="rs-heading"><?php echo $total_reviews; ?></h1>
                </div>
                <div class="statistic-item">
                    <h4>Average<br>Rating</h4>
                    <h1 class="rs-heading"><?php echo $average_rating; ?></h1>
                </div>
            </a>
            <h2><br>Account Settings<br></h2>
<!--
            <img class="circular-image" src="Profile_Image.png">
            <p class="underscore" style="text-align: center">Change Profile Picture</p>
-->
            <div class="accountContainer">  
                <form method="POST">
                    <h3 style="margin: 0;">Username:</h3>
                    <input class="account-detail" type="text" name="username" 
                           value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" required>

                    <h3 style="margin: 0;">Email:</h3>
                    <input class="account-detail" type="email" name="email" 
                           value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required>

                    <button style="width: 100%;margin: 10px 0;" type="submit" name="update_details">Save Changes</button>
                </form>
            </div> <br><br>

            
            <form method="POST" style="text-align: center;">
                    <button type="submit" name="logout" class="logout-button">LOG OUT</button>
            </form>
        </div>
    </div>
</body>
</html>