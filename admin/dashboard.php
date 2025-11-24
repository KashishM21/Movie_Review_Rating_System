<?php
include "../includes/session.php";
include "../includes/db.php";
include "../includes/header.php";
// include "../project/movie_link/movie_poster.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Latest Movies</title>
        <link rel="stylesheet" href="../assets/css/poster_style.css">

</head>
<body>

<section id="main-section">
    <h1 class="page-title">Latest Movies</h1>

    <?php
    $genres = $mysqli->query("SELECT DISTINCT genre FROM movie ORDER BY genre ASC");

    while ($g = $genres->fetch_assoc()) {
        $genre = $g['genre'];

        $movies = $mysqli->query("SELECT * FROM movie WHERE genre='$genre' ORDER BY id DESC");
    ?>

        <div class="genre-block">
            <h2 class="genre-title"><?php echo htmlspecialchars($genre); ?></h2>

            <div class="movie-row">

                <?php while ($m = $movies->fetch_assoc()) { ?>

                    <div class="movie-card">
                        <a href="../movie_link/movie_description.php?id=<?php echo $m['id']; ?>">
                            <img src="../assets/images/uploads/<?php echo $m['poster']; ?>" alt="Poster">
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

<?php include "../includes/footer.php"; ?>
