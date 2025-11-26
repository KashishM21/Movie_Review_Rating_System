<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";
include "../includes/session.php";
include "../includes/header.php";

if (!isset($_GET['id'])) {
    die("Movie ID missing!");
}

$id = $_GET['id'];

$query = $mysqli->prepare("SELECT * FROM movie WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$movie = $query->get_result()->fetch_assoc();

if (!$movie) {
    die("Movie not found!");
}
?>
    <link rel="stylesheet" href="../assets/css/edit_movie.css">
<h2>Edit Movie</h2>

<form action="update_movie.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $movie['id']; ?>">

    <label>Title:</label>
    <input type="text" name="title" value="<?= $movie['title']; ?>" required><br><br>

    <label>Genre:</label>
    <input type="text" name="genre" value="<?= $movie['genre']; ?>" required><br><br>

    <label>Release Year:</label>
    <input type="number" name="release_year" value="<?= $movie['release_year']; ?>" required><br><br>

    <label>Description:</label>
    <textarea name="description" required><?= $movie['description']; ?></textarea><br><br>

    <label>Poster:</label><br>
   <img id="posterPreview" src="../assets/images/uploads/<?= $movie['poster']; ?>" width="120">
    <input type="file" name="poster" id="posterInput"><br><br>
    <small>Upload only if you want to change poster</small><br><br>

    <button type="submit">Update Movie</button>
</form>

<?php include "../includes/footer.php"; ?>