<?php
include "db_connect.php";

// Check if song_id is set in the URL
if (!isset($_GET['song_id'])) {
    die("Error: song_id is not specified.");
}

// Fetch song ID from URL
$song_id = intval($_GET['song_id']);

// Fetch average rating and reviews count
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

// Calculate the maximum count to normalize the widths
$max_rating_count = max($ratings_count);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Breakdown</title>
    <style>
        .rating-breakdown {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .rating-label {
            font-weight: bold;
            width: 70px; /* Fixed width for labels */
        }

        .rating-progress {
            height: 20px; /* Height of the progress bar */
            background-color: #FFBD69; /* Color of the progress bar */
            border-radius: 5px;
            flex-grow: 1; /* Allow the bar to grow */
            margin: 0 10px; /* Space between label and count */
            transition: width 0.3s ease; /* Smooth transition for width */
        }

        .rating-count {
            width: 40px; /* Fixed width for count */
            text-align: right; /* Align count to the right */
            font-weight: bold; /* Make count bold */
        }
    </style>
</head>
<body>

<div class="rating-breakdown">
    <h3>Rating Breakdown (<?= $review_data['total_reviews']; ?> Reviews)</h3>
    <?php foreach ($ratings_count as $rating => $count): ?>
        <?php
        // Calculate the width for each rating bar as a percentage of the maximum count
        $width = ($max_rating_count > 0) ? ($count / $max_rating_count) * 50 : 0;
        ?>
        <div class="rating-bar">
            <div class="rating-label"><?= $rating; ?> Star</div>
            <div class="rating-progress">
                <div style="border-radius : 4px; height: 100%; background: #FF6363; width: <?= $width ?>%;"></div>
            </div>
            <div class="rating-count"><?= $count; ?></div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>