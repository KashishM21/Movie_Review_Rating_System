<?php
include "includes/db.php";             // Include database connection
error_reporting(E_ALL);                 // Turn on all error reporting
ini_set("display_errors", 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RateMyMovie</title>
    <link rel="stylesheet" href="../project/assets/css/poster_style.css"> <!-- Page styles -->
</head>

<body>
    <section id="main-section">
        <h1 class="page-title">Movies</h1>

        <?php
        // Fetch all distinct genres from the movie table
        $genres = $mysqli->query("SELECT DISTINCT genre FROM movie ORDER BY genre ASC");

        while ($g = $genres->fetch_assoc()) { // Loop through each genre
            $genre = $g['genre'];

            // Fetch all movies for this genre, selecting only necessary fields
            $movies = $mysqli->query("
                SELECT id, title, poster, release_year 
                FROM movie 
                WHERE genre='$genre' 
                ORDER BY id ASC
            ");
        ?>
            <div class="genre-block">
                <h2 class="genre-title"><?= htmlspecialchars($genre) ?></h2>

                <button class="prev-btn" onclick="scrollRow(this, -1)">&#10094;</button> <!-- Scroll left -->
                <div class="movie-row">
                    <?php while ($m = $movies->fetch_assoc()) {
                        // Prepare statement to get average rating and total ratings for this movie
                        $stmt = $mysqli->prepare("
                            SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_ratings 
                            FROM reviews 
                            WHERE movie_id = ?
                        ");
                        $stmt->bind_param("i", $m['id']);
                        $stmt->execute();
                        $ratingData = $stmt->get_result()->fetch_assoc();

                        // Format average rating or default to 0
                        $avg = $ratingData['avg_rating'] ? number_format($ratingData['avg_rating'], 1) : 0;
                        $total = $ratingData['total_ratings'];

                        // Update movie table with latest avg_rating and total_ratings
                        $update = $mysqli->prepare("
                            UPDATE movie 
                            SET avg_rating = ?, total_ratings = ?
                            WHERE id = ?
                        ");
                        $update->bind_param("dii", $avg, $total, $m['id']);
                        $update->execute();
                    ?>
                        <div class="movie-card">
                            <!-- Clickable poster linking to movie description page -->
                            <a href="/project/movie_link/movie_description.php?id=<?= $m['id'] ?>">
                                <img src="../project/assets/images/uploads/<?= $m['poster'] ?>" alt="<?= htmlspecialchars($m['title']) ?>">
                            </a>
                            <!-- Movie title -->
                            <h3><?= htmlspecialchars($m['title']) ?></h3>
                            <!-- Display average rating or no rating message -->
                            <p class="avg-rating">
                                <?= $total > 0 ? "&#11088; $avg ($total ratings)" : "&#11088; No rating yet" ?>
                            </p>
                        </div>
                    <?php } ?>
                </div>
                <button class="next-btn" onclick="scrollRow(this, 1)">&#10095;</button> <!-- Scroll right -->
            </div>
        <?php } ?>
    </section>

    <script>
        function scrollRow(btn, direction) {
            // Find the closest genre block of the clicked button
            const genreBlock = btn.closest('.genre-block');
            const row = genreBlock.querySelector('.movie-row');

            // Width of one movie card
            const cardWidth = row.querySelector('.movie-card').offsetWidth;
            const gap = 15; // Gap between cards
            const scrollAmount = (cardWidth + gap) * 3; // Scroll 3 cards at a time

            row.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth' // Smooth scrolling effect
            });
        }
    </script>
</body>

</html>
