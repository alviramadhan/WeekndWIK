<?php
include "db_connect.php";
session_start();

// Fetch song ID from URL
$song_id = intval($_GET['song_id']);

// Fetch song details
$song_sql = "SELECT s.title, s.duration, s.description, a.cover_image_url, a.title AS album_title, a.release_year, g.genre_name, s.audio_url
             FROM songs s
             LEFT JOIN albums a ON s.album_id = a.album_id
             LEFT JOIN song_genres sg ON s.song_id = sg.song_id
             LEFT JOIN genres g ON sg.genre_id = g.genre_id
             WHERE s.song_id = $song_id";

$song_result = mysqli_query($conn, $song_sql);
$song = mysqli_fetch_assoc($song_result);

// Check if the logged-in user has already rated the song
$user_rating = null;
$user_review_text = '';
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $user_review_sql = "SELECT rating, review_text 
                        FROM reviews 
                        WHERE song_id = $song_id AND user_id = $user_id";
    $user_review_result = mysqli_query($conn, $user_review_sql);
    if (mysqli_num_rows($user_review_result) > 0) {
        $user_review = mysqli_fetch_assoc($user_review_result);
        $user_rating = $user_review['rating'];
        $user_review_text = $user_review['review_text'];
    }
}

// Fetch average rating and reviews
$review_sql = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE song_id = $song_id";
$review_result = mysqli_query($conn, $review_sql);
$review_data = mysqli_fetch_assoc($review_result);

// Fetch rating distribution for the histogram
$rating_distribution_sql = "
    SELECT rating, COUNT(*) AS count 
    FROM reviews 
    WHERE song_id = $song_id 
    GROUP BY rating
    ORDER BY rating DESC";

$rating_distribution_result = mysqli_query($conn, $rating_distribution_sql);

// Initialize an array for ratings (1 to 5)
$ratings_count = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
while ($row = mysqli_fetch_assoc($rating_distribution_result)) {
    $ratings_count[intval($row['rating'])] = intval($row['count']);
}

// Fetch individual reviews
$reviews_sql = "SELECT r.rating, r.review_text, r.review_date, u.username 
                    FROM reviews r 
                    LEFT JOIN users u ON r.user_id = u.user_id 
                    WHERE r.song_id = $song_id 
                    ORDER BY r.review_date DESC";
$reviews_result = mysqli_query($conn, $reviews_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>WeekndWIK</title>
    
    <style>
        .stars i {
            color: #FFD700; 
            font-size: 35px;
            margin-right: 5px;
        }

        .review-container {
            margin: 20px 0;
            padding: 20px;
            border: solid 3px white;
            border-radius: 8px;
        }

        .review-input {
            width: 100%;
            border-radius: 8px;
            height: auto;
            font-size: 15px;
            color: white;
            border: solid 2px white;
            background: black;
            padding: 10px;
        }

        .star-rating {
            display: flex;
            direction: row;
            justify-content: center;
            font-size: 4rem;
            cursor: pointer;
        }

        .star-rating span {
            color: lightgray;
            transition: color 0.2s;
            margin-right: 5px;
        }

        .star-rating span.hover,
        .star-rating span.selected {
            color: #FFD700;
        }

        .submitBtn-review-container {
            margin: 15px 0 0 0;
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .reviews {
            margin-top: 20px;
            border-radius: 8px;
        }

        .review {
            border-bottom: 1px solid gray;
            padding: 10px 0;
        }

        .review:last-child {
            border-bottom: none;
        }

        .review strong {
            color: #FFBD69;
            font-size: 1.1em;
        }

        .review small {
            color: #aaa;
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
            <li><a href="song.php" class="active">SONG</a></li>
            <li><a href="favourite.php">MY FAV</a></li>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li class="right"><a href="user.php"><span class="material-symbols-outlined">account_circle</span></a></li>
        <?php else: ?>
            <button class="nav-button"><a href="login.php">LOGIN</a></button>
            <button class="nav-button"><a href="signup.php">SIGN UP</a></button>
        <?php endif; ?>
    </ul>

    <div class="container" style="display: flex; gap: 20px; margin-top: 50px;">
        <div class="col-4" style="flex: 1;">
            <img src="<?= htmlspecialchars($song['cover_image_url']); ?>" alt="Album Cover" style="width: 100%; border-radius: 10px;">
            <h2><?= htmlspecialchars($song['title']); ?></h2>
            <p><strong>Album:</strong> <?= htmlspecialchars($song['album_title']); ?></p>
            <p><strong>Duration:</strong> <?= htmlspecialchars($song['duration']); ?></p>
            <p><strong>Year:</strong> <?= htmlspecialchars($song['release_year']); ?></p>
            <p><strong>Genre:</strong> <?= htmlspecialchars($song['genre_name']); ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($song['description']); ?></p>
            <a href="<?= htmlspecialchars($song['audio_url']); ?>" target="_blank" style="color: #FFBD69;">Play Song</a>
        </div>

        <div class="col-8" style="flex: 3;">
            <!-- Rating Section -->
            <div class="review-container">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <h2>Your Rating:</h2>
                    <form method="POST" action="<?= $user_rating !== null ? 'update_review.php' : 'submit_review.php'; ?>">
                        <div class="star-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?= ($i <= $user_rating) ? 'selected' : ''; ?>" data-value="<?= $i; ?>">&#9733;</span>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" id="rating-value" name="rating" value="<?= $user_rating; ?>">
                        <textarea class="review-input" name="review_text" required><?= htmlspecialchars($user_review_text); ?></textarea>
                        <input type="hidden" name="song_id" value="<?= $song_id; ?>">
                        <div class="submitBtn-review-container">
                            <button style="background: #FFBD69; color: black; padding: 8px 20px;" type="submit"><?= $user_rating ? 'Update' : 'Submit'; ?></button>
                        </div>
                    </form>
                <?php else: ?>
                    <p>Please <a href="login.php">log in</a> to leave a review.</p>
                <?php endif; ?>
            </div>

            <!-- Rating Breakdown -->
            <div class="rating-breakdown">
                <?php include 'rating_breakdown.php'; ?>
            </div>

            <!-- Reviews Section -->
            <div class="reviews">
                <?php if (mysqli_num_rows($reviews_result) > 0): ?>
                    <?php while ($review = mysqli_fetch_assoc($reviews_result)): ?>
                        <div class="review">
                            <p><strong><?= htmlspecialchars($review['username']); ?></strong></p>
                            <p>Rating: <?= htmlspecialchars($review['rating']); ?>/5</p>
                            <p><?= htmlspecialchars($review['review_text']); ?></p>
                            <p><small><?= htmlspecialchars($review['review_date']); ?></small></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No reviews yet.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script>
        // Handle star hover and click
        const stars = document.querySelectorAll('.star');
        const ratingValueInput = document.getElementById('rating-value');
        
        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const value = star.dataset.value;
                stars.forEach(star => {
                    if (star.dataset.value <= value) {
                        star.classList.add('hover');
                    } else {
                        star.classList.remove('hover');
                    }
                });
            });

            star.addEventListener('mouseout', () => {
                stars.forEach(star => star.classList.remove('hover'));
            });

            star.addEventListener('click', () => {
                const value = star.dataset.value;
                ratingValueInput.value = value;
                stars.forEach(star => {
                    if (star.dataset.value <= value) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            });
        });
    </script>
</body>
</html>
