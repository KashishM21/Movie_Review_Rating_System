<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";
include "../includes/session.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$movie_id = $_POST['movie_id'] ?? null;
$rating = $_POST['rating'] ?? null;
$review = trim($_POST['review'] ?? '');
$user_id = $_SESSION['user_id'];


if (!$movie_id || !$rating || $review === '') {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ../movie_link/movie_description.php?id=" . $movie_id);
    exit();
}

try {
 
    $check = $mysqli->prepare("SELECT id FROM reviews WHERE movie_id = ? AND user_id = ?");
    $check->bind_param("ii", $movie_id, $user_id);
    $check->execute();
    $existing = $check->get_result()->fetch_assoc();

    if ($existing) {
   
        $update = $mysqli->prepare("
            UPDATE reviews
            SET rating = ?, review_text = ?, created_at = NOW()
            WHERE id = ?
        ");
        $update->bind_param("isi", $rating, $review, $existing['id']);
        $update->execute();
        $_SESSION['success'] = "Review updated successfully!";
    } else {
        $insert = $mysqli->prepare("
            INSERT INTO reviews (movie_id, user_id, rating, review_text, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $insert->bind_param("iiis", $movie_id, $user_id, $rating, $review);
        $insert->execute();
        $_SESSION['success'] = "Review submitted successfully!";
    }

} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header("Location: ../movie_link/movie_description.php?id=" . $movie_id);
exit();