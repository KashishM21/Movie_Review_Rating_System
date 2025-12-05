<?php
// Show all errors for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Include session and database connection
include "../includes/session.php";
include "../includes/db.php";

// Check if user is admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: /project/index.php"); 
    exit;
}

// Get movie ID from URL, default to 0
$movie_id = $_GET['id'] ?? 0;

// Fetch poster filename for the movie
$stmt = $mysqli->prepare("SELECT poster FROM movie WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();

if ($movie) { 
    // Delete movie record from database
    $del = $mysqli->prepare("DELETE FROM movie WHERE id = ?");
    $del->bind_param("i", $movie_id);
    $del->execute();

    // Delete poster file from server
    $poster_path = "../assets/images/uploads/" . $movie['poster'];
    if (file_exists($poster_path)) {
        unlink($poster_path);
    }

    // Redirect back with success message
    header("Location: /project/index.php?msg=deleted");
    exit;
} else {
    // Movie not found in database
    echo "Movie not found!";
}
?>
