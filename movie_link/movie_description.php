<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../includes/db.php";
include "../includes/header.php";

$movie_id = $_GET['id'] ?? 0;


$stmt = $mysqli->prepare("SELECT * FROM movie WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();
$average_rating = $movie['avg_rating'] ? number_format($movie['avg_rating'], 1) : 0;
$total_ratings = $movie['total_ratings'];


if (!$movie) {
    echo "<h2 style='color:red;'>Movie not found.</h2>";
    include "footer.php";
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? "guest";
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $movie['title']; ?> - Movie Details</title>
    <link rel="stylesheet" href="../assets/css/movie_description.css">
   
</head>
<script src="../assets/js/star_script.js"></script>
<body>

    <section class="movie-details">
        <img src="/project/assets/images/uploads/<?php echo $movie['poster']; ?>" class="movie-poster">

        <div class="movie-info">
            <h1><?php echo $movie['title']; ?></h1>
            <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
            <p><strong>Release Year:</strong> <?php echo $movie['release_year']; ?></p>
            <p><strong>Average Rating:</strong> 
<?php 
if ($total_ratings > 0) {
    echo "&#9733; $average_rating ($total_ratings ratings)";
} else {
    echo "&#9733; No ratings yet";
}
?>

</p>

            <p><?php echo $movie['description']; ?></p>
            <?php if ($user_role === 'admin'): ?>
                <a href="../admin/edit_movie.php?id=<?php echo $movie_id; ?>" class="btn-edit">Edit Movie</a>
                <a href="/project/admin/delete_movie.php?id=<?php echo $movie['id']; ?>"
                   onclick="return confirm('Are you sure?');"
                   class="btn-delete">Delete</a>
            <?php endif; ?>
        </div>
    </section>
    <?php
    if ($user_role === "user") {
        $check = $mysqli->prepare("SELECT * FROM reviews WHERE movie_id = ? AND user_id = ?");
        $check->bind_param("ii", $movie_id, $user_id);
        $check->execute();
        $existing = $check->get_result()->fetch_assoc();

        if (!$existing):
    ?>
            <section class="rate-section">
                <h2>Rate & Review</h2>

                <form action="submit_review.php" method="POST">
                    <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">

                    <label>Rating:</label>
                    <div id="star-rating">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>

                    <input type="hidden" name="rating" id="rating-value">

                    <label>Your Review:</label>
                    <textarea name="review"></textarea>

                    <button type="submit" class="btn-submit">Submit</button>
                </form>
            </section>

    <?php
        else:
            echo "<p class='note'>You have already rated & reviewed this movie.</p>";
        endif;
    }
    ?>

    <?php if ($user_role === "guest"): ?>
        <a href="/project/user/login.php"><p class='note'>Login to rate or review.</p></a>
    <?php endif; ?>

    <hr>

    <section class="reviews">
        <h2>User Reviews</h2>

        <?php
        $rev = $mysqli->prepare("
            SELECT r.*, u.name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id
            WHERE movie_id = ?
        ");
        $rev->bind_param("i", $movie_id);
        $rev->execute();
        $reviews = $rev->get_result();

        while ($r = $reviews->fetch_assoc()):
        ?>
            <div class="review-box">
                <strong><?php echo $r['name']; ?></strong>
                <p>Rating: <?php echo str_repeat("★", $r['rating']); ?></p>
                <p><?php echo $r['review_text']; ?></p>
            </div>
        <?php endwhile; ?>
    </section>
</body>
</html>
<?php include "../includes/footer.php"; ?>