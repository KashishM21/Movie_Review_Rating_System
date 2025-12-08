<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../includes/db.php";
include "../includes/session.php";

$message = "";

if (isset($_POST['submit'])) {

    // Collect and trim inputs
    $title = trim($_POST['title']);
    $actor = trim($_POST['actor']);
    $director = trim($_POST['director']);
    $writer = trim($_POST['writer']);
    $description = trim($_POST['description']);
    $genre = trim($_POST['genre']);
    $custom_genre = trim($_POST['custom_genre'] ?? '');
    $release_year = trim($_POST['release_year']);
    $rating = trim($_POST['rating'] ?? '');

    // If custom genre provided, use it
    if (!empty($custom_genre)) {
        $genre = strtolower($custom_genre);
    } else {
        $genre = strtolower($genre);
    }

    // -------------------
    // TITLE VALIDATION
    // -------------------
    if (empty($title)) die("Movie title is required!");
    if (strlen($title) < 2 || strlen($title) > 100) die("Movie title must be between 2 and 100 characters.");
    if (!preg_match('/^[a-zA-Z0-9 _.,():"]+$/', $title)) {
        die("Movie title contains invalid characters! Allowed: letters, numbers, spaces, _ , . ( ) : \"");
    }

    // -------------------
    // ACTOR VALIDATION
    // -------------------
    if (empty($actor)) die("Actor name is required!");
    if (strlen($actor) < 2 || strlen($actor) > 100) die("Actor name must be between 2 and 100 characters.");
    if (!preg_match('/^[a-zA-Z, ]+$/', $actor)) die("Actor name contains invalid characters! Only letters, spaces, and commas allowed.");

    // -------------------
    // DIRECTOR VALIDATION
    // -------------------
    if (empty($director)) die("Director name is required!");
    if (strlen($director) < 2 || strlen($director) > 100) die("Director name must be between 2 and 100 characters.");
    if (!preg_match('/^[a-zA-Z, ]+$/', $director)) die("Director name contains invalid characters! Only letters, spaces, and commas allowed.");

    // -------------------
    // WRITER VALIDATION
    // -------------------
    if (empty($writer)) die("Writer name is required!");
    if (strlen($writer) < 2 || strlen($writer) > 100) die("Writer name must be between 2 and 100 characters.");
    if (!preg_match('/^[a-zA-Z, ]+$/', $writer)) die("Writer name contains invalid characters! Only letters, spaces, and commas allowed.");

    // -------------------
    // DESCRIPTION VALIDATION
    // -------------------
    if (empty($description)) die("Description is required!");
    if (strlen($description) < 10 || strlen($description) > 1000) {
        die("Description must be between 10 and 1000 characters.");
    }
    // Optional: sanitize description for HTML
    $description = htmlspecialchars($description);

    // -------------------
    // GENRE VALIDATION
    // -------------------
    if (empty($genre)) die("Genre is required!");
    if (strlen($genre) < 2 || strlen($genre) > 50) die("Genre must be between 2 and 50 characters.");
    if (!preg_match('/^[a-zA-Z, ]+$/', $genre)) die("Genre contains invalid characters! Only letters, spaces, and commas allowed.");

    // -------------------
    // RELEASE YEAR VALIDATION
    // -------------------
    if (empty($release_year)) die("Release year is required!");
    if (!preg_match('/^\d{4}$/', $release_year)) die("Release year must be a 4-digit number!");
    $current_year = date("Y");
    if ($release_year < 1900 || $release_year > $current_year) {
        die("Release year must be between 1900 and $current_year.");
    }

    // -------------------
    // RATING VALIDATION
    // -------------------
    if (empty($rating)) die("Rating is required!");
    if (!is_numeric($rating)) die("Rating must be a number!");
    if ($rating < 1 || $rating > 5) die("Rating must be between 1 and 5.");

    // -------------------
    // POSTER VALIDATION
    // -------------------
    if (!isset($_FILES['poster']) || $_FILES['poster']['error'] !== UPLOAD_ERR_OK) die("Poster upload failed!");
    $file_name = $_FILES['poster']['name'];
    $file_tmp = $_FILES['poster']['tmp_name'];
    $max_size = 512 * 1024; // 512 KB limit
    if ($_FILES['poster']['size'] > $max_size) die("Poster image must be less than 512 KB!");
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext)) die("Only JPG, JPEG, PNG files are allowed!");
    $upload_dir = "../assets/images/uploads/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    $new_name = time() . "_" . uniqid() . "." . $ext;
    $upload_path = $upload_dir . $new_name;
    if (!move_uploaded_file($file_tmp, $upload_path)) die("Failed to save poster!");

    // -------------------
    // DUPLICATE MOVIE CHECK
    // -------------------
    $check = $mysqli->prepare("SELECT id FROM movie WHERE title = ? AND release_year = ?");
    $check->bind_param("ss", $title, $release_year);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) die("This movie already exists in the database!");
    $check->close();

    // -------------------
    // INSERT MOVIE INTO DATABASE
    // -------------------
    $stmt = $mysqli->prepare("
        INSERT INTO movie (title, actor, director, writer, genre, release_year, description, poster, rating)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssssisi", $title, $actor, $director, $writer, $genre, $release_year, $description, $new_name, $rating);

    if ($stmt->execute()) {
        $message = "Movie Added Successfully!";
        header("Location: /project/index.php");
        exit();
    } else {
        $message = "Error inserting movie: " . $mysqli->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
