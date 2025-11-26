<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../includes/db.php";
include "../includes/header.php";

$movie_id = $_GET['id'] ?? null;
$stmt = $mysqli->prepare("SELECT * FROM movie WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();
$movie_id = $_GET['id'] ?? null;

if (!$movie && strpos($movie_id, 'tt') === 0) { // IMDb ID starts with 'tt'
    $apikey = "b04d0cf";
    $url = $url = "http://www.omdbapi.com/?i=$movie_id&apikey=$apikey";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && $data['Response'] == "True") {
        $movie = [
            'title' => $data['Title'],
            'genre' => $data['Genre'],
            'release_year' => $data['Year'],
            'description' => $data['Plot'],
            'poster' => $data['Poster'],
            'avg_rating' => 0,
            'total_ratings' => 0
        ];
    }
}
$is_api_movie = !isset($movie['id']);

if (!$movie) {
    echo "<h2 style='color:red;'>Movie not found.</h2>";
    exit;
}

$average_rating = $movie['avg_rating'] ? number_format($movie['avg_rating'], 1) : 0;
$total_ratings = $movie['total_ratings'] ?? 0;

$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? "guest";
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $movie['title']; ?> - Movie Details</title>
    <link rel="stylesheet" href="../assets/css/movie_description.css">

    <script src="../assets/js/star_script.js"></script>
</head>

<body>
    <?php

    $poster = $movie['poster'] ?? '';
    if (empty($poster) || $poster === 'N/A') {
        $poster_url = "/project/assets/images/default-poster.png";
    } elseif (strpos($poster, 'http') === 0) {
        $poster_url = $poster;
    } else {
        $poster_url = "/project/assets/images/uploads/" . $poster;
    }
    ?>

    <section class="movie-details">
        <img src="<?= $poster_url ?>" class="movie-poster">

        <div class="movie-info">
            <h1><?php echo $movie['title']; ?></h1>
            <?php if (!empty($movie['description'])): ?>
                <p><strong>Description:</strong><?php echo $movie['description']; ?></p>
            <?php endif; ?>
            <?php if (!empty($movie['genre'])): ?>

                <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
            <?php endif; ?>
            <?php if (!empty($movie['release_year'])): ?>

                <p><strong>Release Year:</strong> <?php echo $movie['release_year']; ?></p>
            <?php endif; ?>
            
            <?php if (!empty($movie['director'])): ?>

                <p><strong>Director:</strong> <?php echo $movie['director']; ?></p>
            <?php endif; ?>
            <?php if (!empty($movie['actor'])): ?>

                <p><strong>Actor:</strong> <?php echo $movie['actor']; ?></p>
            <?php endif; ?>
            <?php if (!empty($movie['avg_rating'])): ?>

                <p><strong> Rating:</strong>

                    <?php
                    if ($total_ratings > 0) {
                        echo "&#9733; $average_rating ($total_ratings ratings)";
                    } else {
                        echo "&#9733; No ratings yet";
                    }
                    ?>
                </p>
            <?php endif; ?>
            <?php if (!empty($movie['stars'])): ?>

                <p><strong>Stars:</strong><?php echo $movie['stars']; ?></p>
            <?php endif; ?>
            <?php if ($user_role === 'admin' && !$is_api_movie): ?>
                <a href="../admin/edit_movie.php?id=<?php echo $movie_id; ?>" class="btn-edit">Edit Movie</a>
                <a href="/project/admin/delete_movie.php?id=<?php echo $movie['id']; ?>"
                    onclick="return confirm('Are you sure?');"
                    class="btn-delete">Delete</a>
            <?php endif; ?>
        </div>
    </section>
    <?php
    if ($user_role === "user" && !$is_api_movie) {
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
        // echo "<p class='note'>You have already rated & reviewed this movie.</p>";
        endif;
    }
    ?>
   <?php if ($user_role === "guest"): ?>
    <div class="login-box">
        <p>You must login to rate & review</p>
        <a href="/project/user/login.php" class="login-btn">Login Now</a>
    </div>
<?php endif; ?>

    
    <?php if (!$is_api_movie): ?>

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
    <?php endif; ?>
</body>

</html>
<?php include "../includes/footer.php"; ?>
<script>
    fetch(`https://www.omdbapi.com/?i=${movie.imdbID}&apikey=b04d0cf`)
  .then(res => res.json())
  .then(data => {
    console.log(data.imdbRating); 
  });

</script>