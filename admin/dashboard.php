<?php
include "../includes/db.php";        // DB connection
include "../includes/header.php";    // Page header

// Turn on all error messages for debugging
error_reporting(E_ALL); 
ini_set("display_errors", 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Movies</title>
    <link rel="stylesheet" href="../assets/css/poster_style.css"> <!-- CSS for posters -->
</head>

<body>

<section id="main-section">
    <h1 class="page-title">Latest Movies</h1>

    <?php
    // Fetch distinct genres from the movie table
    $genres = $mysqli->query("SELECT DISTINCT genre FROM movie ORDER BY genre ASC");

    while ($g = $genres->fetch_assoc()) { // Loop through each genre
        $genre = $g['genre'];

        // Fetch all movies of the current genre
        $movies = $mysqli->query("SELECT * FROM movie WHERE genre='$genre' ORDER BY id ASC");
    ?>

        <div class="genre-block">
            <h2 class="genre-title"><?php echo htmlspecialchars($genre); ?></h2>

            <button class="prev-btn" onclick="scrollRow(this, -1)">&#10094;</button> <!-- Scroll left -->

            <div class="movie-row">
                <?php while ($m = $movies->fetch_assoc()) { // Loop through movies ?>
                    
                    <?php
                    // Get average rating and total ratings for each movie
                    $stmt = $mysqli->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_ratings FROM reviews WHERE movie_id = ?");
                    $stmt->bind_param("i", $m['id']);
                    $stmt->execute();
                    $ratingData = $stmt->get_result()->fetch_assoc();

                    $avg = $ratingData['avg_rating'] ? number_format($ratingData['avg_rating'], 1) : 0;
                    $total = $ratingData['total_ratings'];
                    ?>
                    
                    <div class="movie-card">
                        <a href="../movie_link/movie_description.php?id=<?php echo $m['id']; ?>">
                            <img src="../assets/images/uploads/<?php echo $m['poster']; ?>" alt="Poster"> 
                            <!-- Clickable poster links to movie description -->
                        </a>
                        <h3><?php echo htmlspecialchars($m['title']); ?></h3> <!-- Movie title -->

                        <p class="avg-rating">
                            <?php 
                            if ($total > 0) {
                                echo "&#11088; $avg ($total ratings)"; // Show rating & count
                            } else {
                                echo "&#11088; No rating yet"; // If no ratings
                            }
                            ?>
                        </p>
                    </div>

                <?php } ?>
            </div>

            <button class="next-btn" onclick="scrollRow(this, 1)">&#10095;</button> <!-- Scroll right -->

        </div>

    <?php } ?>

</section>

<script>
    // Scroll movie row left/right by 3 cards
    function scrollRow(btn, direction) {
        const genreBlock = btn.closest('.genre-block'); // Ensure scroll is in correct genre
        const row = genreBlock.querySelector('.movie-row');

        const cardWidth = row.querySelector('.movie-card').offsetWidth; // Card width including padding & border
        const scrollAmount = (cardWidth + 15) * 3; // Scroll 3 cards plus 15px gap

        row.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }
</script>

</body>
</html>

<?php include "../includes/footer.php"; ?> <!-- Footer -->
