<?php
include "includes/db.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RateMyMovie</title>
    <link rel="stylesheet" href="../project/assets/css/poster_style.css">
</head>

<body>
   <section id="main-section">
        <h1 class="page-title">Latest Movies</h1>

        <?php
        $genres = $mysqli->query("SELECT DISTINCT genre FROM movie ORDER BY genre ASC");

        while ($g = $genres->fetch_assoc()) {
            $genre = $g['genre'];
            $movies = $mysqli->query("SELECT id, title, poster, release_year FROM movie WHERE genre='$genre' ORDER BY id ASC");
        ?>
            <div class="genre-block">
                <h2 class="genre-title"><?= htmlspecialchars($genre) ?></h2>

                <button class="prev-btn" onclick="scrollRow(this, -1)">&#10094;</button>
                <div class="movie-row">
                    <?php while ($m = $movies->fetch_assoc()) {
                        $stmt = $mysqli->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_ratings FROM reviews WHERE movie_id = ?");
                        $stmt->bind_param("i", $m['id']);
                        $stmt->execute();
                        $ratingData = $stmt->get_result()->fetch_assoc();

                        $avg = $ratingData['avg_rating'] ? number_format($ratingData['avg_rating'], 1) : 0;
                        $total = $ratingData['total_ratings'];

                        $update = $mysqli->prepare("
                            UPDATE movie 
                            SET avg_rating = ?, total_ratings = ?
                            WHERE id = ?
                        ");
                        $update->bind_param("dii", $avg, $total, $m['id']);
                        $update->execute();
                    ?>
                        <div class="movie-card">
                            <a href="/project/movie_link/movie_description.php?id=<?= $m['id'] ?>">
                                <img src="../project/assets/images/uploads/<?= $m['poster'] ?>" alt="<?= htmlspecialchars($m['title']) ?>">
                            </a>
                            <h3><?= htmlspecialchars($m['title']) ?></h3>
                            <p class="avg-rating">
                                <?= $total > 0 ? "&#11088; $avg ($total ratings)" : "&#11088; No rating yet" ?>
                            </p>
                        </div>
                    <?php } ?>
                </div>
                <button class="next-btn" onclick="scrollRow(this, 1)">&#10095;</button>
            </div>
        <?php } ?>
    </section>
    <script>
        function scrollRow(btn, direction) {
            const genreBlock = btn.closest('.genre-block');
            const row = genreBlock.querySelector('.movie-row');

            const cardWidth = row.querySelector('.movie-card').offsetWidth;
            const gap = 15;
            const scrollAmount = (cardWidth + 15) * 3;

            row.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>