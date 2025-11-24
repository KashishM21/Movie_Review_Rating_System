<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../includes/session.php";
include "../includes/db.php";


if ($_SESSION['role'] !== 'admin') {
    header("Location: /project/index.php");
    exit;
}

$movie_id = $_GET['id'] ?? 0;

$stmt = $mysqli->prepare("SELECT poster FROM movie WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();

if ($movie) {


    $del = $mysqli->prepare("DELETE FROM movie WHERE id = ?");
    $del->bind_param("i", $movie_id);
    $del->execute();  

    $poster_path = "../assets/images/uploads/" . $movie['poster'];
    if (file_exists($poster_path)) {
        unlink($poster_path);
    }

    header("Location: /project/index.php?msg=deleted");
    exit;
} else {
    echo "Movie not found!";
}
?>