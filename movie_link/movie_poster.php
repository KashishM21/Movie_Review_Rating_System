<?php
include "includes/db.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RateMyMovie</title>
    <link rel="stylesheet" href="../project/assets/css/poster_style.css">
    <!-- <link rel="shortcut icon" href="../assets/images/ratemymovie.png" type="image/x-icon"> -->


</head>

<body>
    <section id="main-section">

        <h1 class="page-title">Latest Movies</h1>

        <?php
        // Get all unique genres
        $genres = $mysqli->query("SELECT DISTINCT genre FROM movie ORDER BY genre ASC");

        while ($g = $genres->fetch_assoc()) {
            $genre = $g['genre'];

            // Fetch movies of this genre
            $movies = $mysqli->query("SELECT * FROM movie WHERE genre='$genre' ORDER BY id DESC");
        ?>

            <div class="genre-block">
                <h2 class="genre-title"><?php echo htmlspecialchars($genre); ?></h2>

                <div class="movie-row">
                    <?php while ($m = $movies->fetch_assoc()) { ?>

                        <div class="movie-card">
                            <a href="/project/movie_link/movie_description.php?id=<?php echo $m['id']; ?>">
                                <img src="../project/assets/images/uploads/<?php echo $m['poster']; ?>" alt="Poster">
                            </a>

                            <h3><?php echo htmlspecialchars($m['title']); ?></h3>
                            <p class="year"><?php echo $m['release_year']; ?></p>
                        </div>

                    <?php } ?>
                </div>

            </div>

        <?php } ?>

    </section>

</body>

</html>

