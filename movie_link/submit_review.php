<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";       // Database connection
include "../includes/session.php";  // Session handling

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

// Get data from POST request
$movie_id = $_POST['movie_id'] ?? null;
$rating = $_POST['rating'] ?? null;
$review = trim($_POST['review'] ?? '');
$user_id = $_SESSION['user_id']; // Current logged-in user's ID

// Pattern to detect inappropriate words (case-insensitive)
$pattern = "/(f[\W_]*u[\W_]*c[\W_]*k|s[\W_]*h[\W_]*i[\W_]*t|b[\W_]*i[\W_]*t[\W_]*c[\W_]*h|fuck|bastard|nude|bitch+|porn|d[\W_]*i[\W_]*c[\W_]*k|p[\W_]*u[\W_]*s[\W_]*s[\W_]*y)/i";

// Check for inappropriate content in review
if (preg_match($pattern, $review)) {
    $_SESSION['error'] = "Your review contains inappropriate content. Please write respectfully.";
    header("Location: ../movie_link/movie_description.php?id=" . $movie_id);
    exit();
}

// Ensure all required fields are filled
if (!$movie_id || !$rating || $review === '') {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ../movie_link/movie_description.php?id=" . $movie_id);
    exit();
}

try {
    // Insert the review into the database
    $insert = $mysqli->prepare("
        INSERT INTO reviews (movie_id, user_id, rating, review_text, created_at)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $insert->bind_param("iiis", $movie_id, $user_id, $rating, $review);
    $insert->execute();

    $_SESSION['success'] = "Review submitted successfully!"; // Success message

} catch (Exception $e) {
    // Handle any errors during insertion
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

// Redirect back to the movie description page
header("Location: ../movie_link/movie_description.php?id=" . $movie_id);
exit();
?>
