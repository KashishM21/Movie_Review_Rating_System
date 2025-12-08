<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../includes/db.php";       // DB connection
include "../includes/header.php";   // Header/navigation

$movie_id = $_GET['id'] ?? null;   // Get movie ID from URL

// Fetch movie from local database
$stmt = $mysqli->prepare("SELECT * FROM movie WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();

// If movie not in DB and ID starts with 'tt', fetch from OMDb API
if (!$movie && strpos($movie_id, 'tt') === 0) {
    $apikey = "b04d0cf";
    $url = "http://www.omdbapi.com/?i=$movie_id&apikey=$apikey";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && $data['Response'] == "True") {
        $movie = [
            'title' => $data['Title'],
            'genre' => $data['Genre'],
            'release_year' => $data['Year'],
            'description' => $data['Plot'],
            'poster' => $data['Poster'],
            'director' => $data['Director'] ?? '',
            'actor' => $data['Actors'] ?? '',
            'writer' => $data['Writer'] ?? '',
            'avg_rating' => 0,       // API movies default to 0 rating
            'total_ratings' => 0
        ];
    }
}

$is_api_movie = !isset($movie['id']);  // Flag to differentiate API vs local movies
if (!$movie) {
    echo "<h2 style='color:red;'>Movie not found.</h2>";
    exit; // Stop if movie not found locally or via API
}

// Prepare rating info
$rating_query = $mysqli->prepare("
    SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_ratings 
    FROM reviews 
    WHERE movie_id = ?
");
$rating_query->bind_param("i", $movie_id);
$rating_query->execute();
$rating_values = $rating_query->get_result()->fetch_assoc();

$average_rating = $rating_values['avg_rating'] 
                    ? number_format($rating_values['avg_rating'], 1) 
                    : 0;

$total_ratings = $rating_values['total_ratings'] ?? 0;

// User info from session
$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? "guest";
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $movie['title']; ?> - Movie Details</title>
    <link rel="stylesheet" href="../assets/css/movie_description.css">
    <script src="../assets/js/star_script.js"></script> <!-- For star rating -->
</head>

<body>
<a href="javascript:history.back()" class="btn-back">&#8592; Back</a>

<?php
// Determine poster URL (local or API)
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
<img src="<?= htmlspecialchars($poster_url); ?>"
     class="movie-poster"
     onerror="this.src='/project/assets/images/default-poster.png';">
    

    <div class="movie-info">
        <h1><?= $movie['title']; ?></h1>

        <!-- Display movie info if available -->
        <?php if (!empty($movie['description'])): ?><p><strong>Description:</strong> <?= $movie['description']; ?></p><?php endif; ?>
        <?php if (!empty($movie['genre'])): ?><p><strong>Genre:</strong> <?= $movie['genre']; ?></p><?php endif; ?>
        <?php if (!empty($movie['release_year'])): ?><p><strong>Release Year:</strong> <?= $movie['release_year']; ?></p><?php endif; ?>
        <?php if (!empty($movie['director'])): ?><p><strong>Director:</strong> <?= $movie['director']; ?></p><?php endif; ?>
        <?php if (!empty($movie['actor'])): ?><p><strong>Actor:</strong> <?= $movie['actor']; ?></p><?php endif; ?>
<?php if (!$is_api_movie): ?>
    <p><strong>Rating:</strong>
        <?php
        if ($total_ratings > 0) {
            echo "&#9733; " . $average_rating;
        } else {
            echo "&#9733; No ratings yet";
        }
        ?>
    </p>
<?php endif; ?>

        <?php if (!empty($movie['writer'])): ?><p><strong>Writers:</strong> <?= $movie['writer']; ?></p><?php endif; ?>

        <!-- Admin edit/delete links for local movies -->
        <?php if ($user_role === 'admin' && !$is_api_movie): ?>
            <a href="../admin/edit_movie.php?id=<?= $movie_id; ?>" class="btn-edit">Edit Movie</a>
            <a href="/project/admin/delete_movie.php?id=<?= $movie['id']; ?>" onclick="return confirm('Are you sure?');" class="btn-delete">Delete</a>
        <?php endif; ?>
    </div>
</section>

<?php
// Rating & review section for logged-in users (local movies only)
if ($user_role === "user" && !$is_api_movie):
    $check = $mysqli->prepare("SELECT * FROM reviews WHERE movie_id = ? AND user_id = ?");
    $check->bind_param("ii", $movie_id, $user_id);
    $check->execute();
    $existing = $check->get_result()->fetch_assoc();
if (!empty($_SESSION['error'])) {
    echo '<p class="error-message" style="color:red; text-align:center;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']); // clear message after showing it
}
    if (!$existing): ?>
        <section class="rate-section">
            <h2>Rate & Review</h2>
            <form action="submit_review.php" method="POST">
                <input type="hidden" name="movie_id" value="<?= $movie_id; ?>">
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
    <?php else: ?>
        <p class='note'>You have already rated & reviewed this movie.</p>
    <?php endif; ?>
<?php endif; ?>

<!-- Guest prompt to login -->
<?php if ($user_role === "guest"): ?>
    <div class="login-box">
        <p>You must login to rate & review</p>
        <a href="/project/user/login.php" class="login-btn">Login Now</a>
    </div>
<?php endif; ?>

<!-- Display all reviews for local movies -->
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

        while ($r = $reviews->fetch_assoc()): ?>
            <div class="review-box">
                <strong><?= $r['name']; ?></strong>
                <p>Rating: <?= str_repeat("★", $r['rating']); ?></p>
                <p>Review: <?= $r['review_text']; ?></p>
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