<?php
include "db_connect.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_review_id'])) {
    $review_id = $_POST['delete_review_id'];
    $sql = "DELETE FROM reviews WHERE review_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $review_id, $user_id);
    $stmt->close();
}

// Fetch user reviews
$sql = "SELECT s.song_id, s.title AS song_title, r.rating, r.review_text, r.review_date, r.review_id 
        FROM reviews r 
        LEFT JOIN songs s ON r.song_id = s.song_id 
        WHERE r.user_id = ? 
        ORDER BY r.review_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    <title>Your Reviews - WeekndWIK</title>
    
    <style>
        /* Style for review item */
        .review-item {
            position: relative;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            display: block;
            color: inherit;
            border-radius: 8px;
        }

        /* Menu button (three dots) */
        .menu-button {
            color: white;
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: white 1px;
            font-size: 24px;
            cursor: pointer;
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 60px;
            right: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .dropdown-menu a {
            display: block;
            padding: 8px 12px;
            text-decoration: none;
            color: #333;
        }

        .dropdown-menu a:hover {
            background-color: #f0f0f0;
        }

        .menu-container:hover .dropdown-menu {
            display: block;
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
        <li class="right"><a href="user.php" class="active"><span class="material-symbols-outlined">account_circle</span></a></li>
    </ul>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <h2>Your Reviews</h2>
            <?php if (isset($delete_message)): ?>
                <p><?= htmlspecialchars($delete_message); ?></p>
            <?php endif; ?>

            <?php if ($result->num_rows > 0): ?>
                <div class="reviews-list">
                    <?php while ($review = $result->fetch_assoc()): ?>
                        <div class="review-item">
                            <h3><?= htmlspecialchars($review['song_title']); ?></h3>
                            <p>Rating: <?= htmlspecialchars($review['rating']); ?>/5</p>
                            <p>Comment: <?= htmlspecialchars($review['review_text']); ?></p>
                            <p>Date: <?= htmlspecialchars($review['review_date']); ?></p>

                            <div class="menu-container">
                                <button class="menu-button">⋮</button>
                                <div class="dropdown-menu">
                                    <a href="songdetail_display.php?song_id=<?= htmlspecialchars($review['song_id']); ?>">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="#" onclick="if(confirm('Are you sure you want to delete this review?')) { 
                                        document.getElementById('delete-form-<?= $review['review_id']; ?>').submit(); 
                                    } return false;">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                    <form id="delete-form-<?= $review['review_id']; ?>" method="POST" style="display:none;">
                                        <input type="hidden" name="delete_review_id" value="<?= htmlspecialchars($review['review_id']); ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>You haven't reviewed any songs yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Toggle the dropdown menu visibility
        document.querySelectorAll('.menu-button').forEach(button => {
            button.addEventListener('click', function() {
                const menu = this.nextElementSibling;
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });
        });

        // Close the dropdown when clicked outside
        window.addEventListener('click', function(event) {
            if (!event.target.matches('.menu-button')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>
