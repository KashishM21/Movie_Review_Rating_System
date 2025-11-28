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
$bad_words = ["fuck", "shit", "bitch", "bastard", "nude", "porn"];

// $lower_review = strtolower($review);

// foreach ($bad_words as $word) {
//     if (strpos($lower_review, $word) !== false) {
//         $_SESSION['error'] = "Your review contains inappropriate words. Please write respectfully.";
//         header("Location: ../movie_link/movie_description.php?id=" . $movie_id);
//         exit();
//     }
// }
// Regex-based advanced bad word filter
$pattern = "/(f[\W_]*u[\W_]*c[\W_]*k|s[\W_]*h[\W_]*i[\W_]*t|b[\W_]*i[\W_]*t[\W_]*c[\W_]*h|asshole|bastard|nude|sex|porn|d[\W_]*i[\W_]*c[\W_]*k|p[\W_]*u[\W_]*s[\W_]*s[\W_]*y)/i";

if (preg_match($pattern, $review)) {
    $_SESSION['error'] = "Your review contains inappropriate content.";
    header("Location: ../movie_link/movie_description.php?id=" . $movie_id);
    exit();
}

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