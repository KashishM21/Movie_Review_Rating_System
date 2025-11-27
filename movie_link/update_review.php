<?php
session_start();
include "../includes/db.php";

// Check for logged-in user
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    // Redirect or display error if user is not logged in
    header("Location: ../login.php");
    exit;
}

if (!isset($_POST['review_id'], $_POST['movie_id'], $_POST['rating'], $_POST['review'])) {
    echo "Missing data!";
    exit;
}

$review_id = intval($_POST['review_id']);
$movie_id  = intval($_POST['movie_id']);
$rating    = intval($_POST['rating']);
$review    = $_POST['review'];

// 1. Update the user's review (Security check included)
$stmt = $mysqli->prepare("UPDATE reviews SET rating = ?, review_text = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("isii", $rating, $review, $review_id, $user_id);

if ($stmt->execute()) {
    
    // Check if any rows were actually affected (i.e., the user owned the review)
    if ($stmt->affected_rows > 0) {
        
        // 2. Recalculate Average Rating and Total Count
        $avg_stmt = $mysqli->prepare("
            SELECT AVG(rating) AS avg_rating, COUNT(id) AS total_ratings 
            FROM reviews 
            WHERE movie_id = ?
        ");
        $avg_stmt->bind_param("i", $movie_id);
        $avg_stmt->execute();
        $stats = $avg_stmt->get_result()->fetch_assoc();
        
        $new_avg_rating = $stats['avg_rating'] ?? 0;
        $new_total_ratings = $stats['total_ratings'] ?? 0;
        
        // 3. Update the movie table with the new statistics
        $update_movie_stmt = $mysqli->prepare("
            UPDATE movie 
            SET avg_rating = ?, total_ratings = ? 
            WHERE id = ?
        ");
        // Use 's' for avg_rating as it is a floating point number
        $update_movie_stmt->bind_param("sii", $new_avg_rating, $new_total_ratings, $movie_id);
        $update_movie_stmt->execute();
        
        // Redirect upon successful update
        header("Location: movie_description.php?id=" . $movie_id . "&updated=1");
        exit;
    } else {
        echo "Error: Review not found or you do not have permission to update it.";
        exit;
    }
} else {
    echo "Error updating review: " . $mysqli->error;
}
?>