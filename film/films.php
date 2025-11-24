<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../includes/db.php";
include "../includes/session.php";
include "../includes/header.php";
include "../includes/filter-bar.php";

$year_filter = isset($_GET['year']) ? $_GET['year'] : '';
$genre_filter = isset($_GET['genre']) ? $_GET['genre'] : '';
$rating_filter = isset($_GET['rating']) ? $_GET['rating'] : '';
$popularity_filter = isset($_GET['popularity']) ? $_GET['popularity'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM movie WHERE 1";

if ($year_filter) {
    $query .= " AND release_year = '$year_filter'";
}
if ($genre_filter) {
    $query .= " AND genre = '$genre_filter'";
}
if ($rating_filter) {
    $query .= " AND rating >= '$rating_filter'";
}
if ($popularity_filter) {
    $query .= " AND popularity >= '$popularity_filter'";
}
if ($search_query) {
    $query .= " AND title LIKE '%$search_query%'";
}


$query .= " ORDER BY genre, id DESC";
$result = $mysqli->query($query);

$genres = [];

while ($row = $result->fetch_assoc()) {
    $genres[$row['genre']][] = $row;
}
?>
<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RateMyMovie</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/ratemymovie.png" type="image/x-icon">
</head>

<body>
    <h1>Browse Movies</h1>

    <form method="get" action="">
        <label for="search">Search by Title:</label>
        <input type="text" name="search" id="search" placeholder="Search by title" value="<?= htmlspecialchars($search_query) ?>">

        <label for="year">Year:</label>
        <input type="number" name="year" id="year" placeholder="Year" value="<?= htmlspecialchars($year_filter) ?>">

        <label for="genre">Genre:</label>
        <select name="genre" id="genre">
            <option value="">Select Genre</option>
            <option value="1" <?= $genre_filter == '1' ? 'selected' : '' ?>>Action</option>
            <option value="2" <?= $genre_filter == '2' ? 'selected' : '' ?>>Drama</option>
            <option value="3" <?= $genre_filter == '3' ? 'selected' : '' ?>>Comedy</option>
            <option value="4" <?= $genre_filter == '4' ? 'selected' : '' ?>>Horror</option>
        </select>

        <label for="rating">Minimum Rating:</label>
        <input type="number" name="rating" id="rating" min="1" max="10" step="0.1" value="<?= htmlspecialchars($rating_filter) ?>">

        <label for="popularity">Minimum Popularity:</label>
        <input type="number" name="popularity" id="popularity" min="0" max="100" value="<?= htmlspecialchars($popularity_filter) ?>">

        <button type="submit">Apply Filters</button>
    </form>

    <h2>Movies</h2>

    <?php foreach ($genres as $genre => $movies): ?>
        <div class="genre-box">
            <h3><?= htmlspecialchars($genre); ?></h3>

            <?php foreach ($movies as $movie): ?>
                <div class="movie-card">
                    <img src="uploads/<?= $movie['poster'] ?>" alt="<?= $movie['title'] ?>">
                    <h4><?= $movie['title'] ?></h4>
                    <p><?= $movie['release_year'] ?> | Rating: <?= $movie['rating'] ?> | Popularity: <?= $movie['popularity'] ?></p>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endforeach; ?>

</body>

</html> -->

<?php
include "../includes/footer.php";
$mysqli->close();
?>
