<?php
include "../includes/session.php";
include "../includes/db.php";

$message = "";

if (isset($_POST['submit'])) {

    $title = trim($_POST['title']);
    $release_year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $description = trim($_POST['description']);
    $custom_genre = trim($_POST['custom_genre'] ?? '');

    if (!empty($custom_genre)) {
        $genre = strtolower($custom_genre); 
    } else {
        $genre = strtolower($genre); 
    }

    if (!isset($_FILES['poster']) || $_FILES['poster']['error'] !== UPLOAD_ERR_OK) {
        die("Poster upload failed!");
    }

    $file_name = $_FILES['poster']['name'];
    $file_tmp = $_FILES['poster']['tmp_name'];
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        die("Only JPG, JPEG, PNG files are allowed!");
    }

    $upload_dir = "../assets/images/uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $new_name = time() . "_" . uniqid() . "." . $ext;
    $upload_path = $upload_dir . $new_name;

    if (!move_uploaded_file($file_tmp, $upload_path)) {
        die("Failed to save poster!");
    }

    $check = $mysqli->prepare("SELECT id FROM movie WHERE title = ? AND release_year = ?");
    $check->bind_param("ss", $title, $release_year);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("This movie already exists in the database!");
    }

    $stmt = $mysqli->prepare("
        INSERT INTO movie (title, genre, release_year, description, poster)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $title, $genre, $release_year, $description, $new_name);

    if ($stmt->execute()) {
        $message = "Movie Added Successfully!";
        header("Location: /project/index.php");
        exit();
    } else {
        $message = "Error inserting movie: " . $mysqli->error;
    }
}
?>