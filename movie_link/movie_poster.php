<?php
include "includes/db.php";
error_reporting(E_ALL);
ini_set("display_errors",1);
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

            $movies = $mysqli->query("SELECT id, title, poster, release_year FROM movie WHERE genre='$genre' ORDER BY id DESC");
        ?>
            <div class="genre-block">
                <h2 class="genre-title"><?php echo htmlspecialchars($genre); ?></h2>

                <div class="movie-row"> 
                    <?php while ($m = $movies->fetch_assoc()) { 
                        $stmt = $mysqli->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_ratings FROM reviews WHERE movie_id = ?");
                        $stmt->bind_param("i", $m['id']);
                        $stmt->execute();
                        $ratingData = $stmt->get_result()->fetch_assoc();

                        $avg = $ratingData['avg_rating'] ? number_format($ratingData['avg_rating'], 1) : 0;
                        $total = $ratingData['total_ratings'];
                    ?>
                        <div class="movie-card">
                            <a href="/project/movie_link/movie_description.php?id=<?php echo $m['id']; ?>">
                                <img src="../project/assets/images/uploads/<?php echo $m['poster']; ?>" alt="Poster">
                            </a>
                            <h3><?php echo htmlspecialchars($m['title']); ?></h3>
                           
                            <p class="avg-rating">
                                <?php 
                                if ($total > 0) {
                                    echo "⭐ $avg ($total ratings)";
                                } else {
                                    echo "⭐ No rating yet";
                                }
                                ?>
                            </p>
                        </div>
                    <?php } ?>
                </div> 
            </div>
        <?php
        }
        ?>

    </section>
</body>

</html>
