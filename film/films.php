<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";
include "../includes/session.php";
include "../includes/header.php";
include "../includes/filter-bar.php";

// Get filters safely
$year = $_GET['year'] ?? '';
$genre = $_GET['genre'] ?? '';
$rating = $_GET['rating'] ?? '';
$popularity = $_GET['popularity'] ?? '';
$search = $_GET['search'] ?? '';

// Build base query
$query = "SELECT * FROM movie WHERE 1=1";
$params = [];
$types = "";

// Apply filters
if ($year) {
    $query .= " AND release_year = ?";
    $params[] = $year;
    $types .= "i";
}
if ($genre) {
    $query .= " AND genre = ?";
    $params[] = $genre;
    $types .= "s";
}
if ($rating) {
    $query .= " AND avg_rating >= ?";
    $params[] = $rating;
    $types .= "d";
}
if ($popularity) {
    $query .= " AND total_ratings >= ?";
    $params[] = $popularity;
    $types .= "i";
}
if ($search) {
    $query .= " AND title LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}

// Order by avg_rating, release_year, id
$query .= " ORDER BY avg_rating DESC, release_year DESC, id DESC";

// Prepare and execute
$stmt = $mysqli->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Display movies
if ($result->num_rows > 0) {
    echo "<div class='movies-container'>";
    while ($row = $result->fetch_assoc()) {
        $posterPath = "../assets/images/uploads/" . htmlspecialchars($row['poster']);
        echo "<div class='movie'>";
        echo "<a href='../movie_link/movie_description.php?id={$row['id']}'>";
        echo "<img src='{$posterPath}' alt='" . htmlspecialchars($row['title']) . "' style='width:150px;'><br>";
        echo "</a>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>Genre: " . htmlspecialchars($row['genre']) . "</p>";
        echo "<p>Year: " . htmlspecialchars($row['release_year']) . "</p>";
        echo "<p>Rating: " . (!empty($row['total_ratings']) ? "⭐ " . number_format($row['avg_rating'], 1) . " ({$row['total_ratings']} votes)" : "No ratings yet") . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No movies found.</p>";
}

$stmt->close();
$mysqli->close();

include "../includes/footer.php";
?>
<link rel="stylesheet" href="../assets/css/film_style.css">


