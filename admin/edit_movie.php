<?php
// Show all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database, session, and header
include "../includes/db.php";
include "../includes/session.php";
include "../includes/header.php";

// Check if movie ID is present in URL
if (!isset($_GET['id'])) {
    die("Movie ID missing!");
}

$id = $_GET['id'];

// Fetch movie data from database
$query = $mysqli->prepare("SELECT * FROM movie WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$movie = $query->get_result()->fetch_assoc();

// Stop if movie does not exist
if (!$movie) {
    die("Movie not found!");
}
?>
<link rel="stylesheet" href="../assets/css/edit_movie.css">

<h2>Edit Movie</h2>

<form action="update_movie.php" method="POST" enctype="multipart/form-data">
    <!-- Hidden input for movie ID -->
    <input type="hidden" name="id" value="<?= $movie['id']; ?>">

    <!-- Movie title -->
    <label>Title:</label>
    <input type="text" name="title" value="<?= $movie['title']; ?>" required><br><br>

    <!-- Movie genre -->
    <label>Genre:</label>
    <input type="text" name="genre" value="<?= $movie['genre']; ?>" required><br><br>

    <!-- Release year -->
    <label>Release Year:</label>
    <input type="number" name="release_year" value="<?= $movie['release_year']; ?>" required><br><br>

    <!-- Movie description -->
    <label>Description:</label>
    <textarea name="description" required><?= $movie['description']; ?></textarea><br><br>

    <!-- Poster preview and file input -->
    <label>Poster:</label><br>
    <img id="posterPreview" src="../assets/images/uploads/<?= $movie['poster']; ?>" width="120">
    <input type="file" name="poster" id="posterInput" onchange="previewPoster(event)"><br><br>
    <!-- Only upload if you want to change poster -->
    <small>Upload only if you want to change poster</small><br><br>

    <button type="submit">Update Movie</button>
</form>

<script>
// Live preview of selected poster image using URL.createObjectURL
function previewPoster(event) {
    const input = event.target;
    const preview = document.getElementById('posterPreview');

    if (input.files && input.files[0]) {
        // Create a temporary URL for the selected file
        preview.src = URL.createObjectURL(input.files[0]);
    }
}
</script>

<?php include "../includes/footer.php"; ?> <!-- Footer -->
