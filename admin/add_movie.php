<?php

// Load session handling
include "../includes/session.php";

// Load database connection
include "../includes/db.php";

$message = "";

if (isset($_POST['submit'])) {

    // Collect form inputs (trim removes extra unnecessary spaces)
    $title = trim($_POST['title']);
    $release_year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $description = trim($_POST['description']);
    $custom_genre = trim($_POST['custom_genre'] ?? '');

    // If admin typed a custom genre, use it (convert to lowercase for consistency)
    if (!empty($custom_genre)) {
        $genre = strtolower($custom_genre);
    } else {
        $genre = strtolower($genre);
    }

    // Validate if a file is uploaded correctly (UPLOAD_ERR_OK = no error)
    if (!isset($_FILES['poster']) || $_FILES['poster']['error'] !== UPLOAD_ERR_OK) {
        die("Poster upload failed!");
    }

    // Retrieve uploaded file name and temporary file path
    $file_name = $_FILES['poster']['name'];
    $file_tmp = $_FILES['poster']['tmp_name'];
    // Max file size (2MB)
    $max_size = 512 * 1024; // 512 KB

    if ($_FILES['poster']['size'] > $max_size) {
        $error = "Poster image must be less than 512 KB!";
    }

    if (!empty($error)) {
        echo "<p style='color:red;'>$error</p>";
        exit;
    }

    // Allowed file extensions
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    // Extract extension and convert to lowercase
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Check if uploaded file has allowed extension
    if (!in_array($ext, $allowed_ext)) {
        die("Only JPG, JPEG, PNG files are allowed!");
    }

    // Directory where posters will be stored
    $upload_dir = "../assets/images/uploads/";

    // Create folder if it doesn’t exist (0777 = read, write, execute permissions)
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate a unique file name (time + random unique ID)
    $new_name = time() . "_" . uniqid() . "." . $ext;

    // Full path where file will be saved
    $upload_path = $upload_dir . $new_name;

    // Move uploaded file from temporary folder to final folder
    if (!move_uploaded_file($file_tmp, $upload_path)) {
        die("Failed to save poster!");
    }

    // Check if a movie with the same title & year already exists
    $check = $mysqli->prepare("SELECT id FROM movie WHERE title = ? AND release_year = ?");
    $check->bind_param("ss", $title, $release_year);
    $check->execute();
    $check->store_result();

    // If a duplicate movie exists, stop
    if ($check->num_rows > 0) {
        die("This movie already exists in the database!");
    }

    // Insert new movie record into database
    $stmt = $mysqli->prepare("
        INSERT INTO movie (title, genre, release_year, description, poster)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $title, $genre, $release_year, $description, $new_name);

    // Execute query
    if ($stmt->execute()) {
        $message = "Movie Added Successfully!";

        // Redirect to homepage after successful insertion
        header("Location: /project/index.php");
        exit();
    } else {
        // If insertion fails, show error
        $message = "Error inserting movie: " . $mysqli->error;
    }
}
