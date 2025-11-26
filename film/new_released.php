<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include "../includes/db.php";
include "../includes/header.php";
include "../includes/filter-bar.php"; 

$results_per_page = 5; 
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $results_per_page; 

$sort_column = 'created_at'; 

$count_query = "SELECT COUNT(*) AS total FROM movie";
$stmt_count = $mysqli->prepare($count_query);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_rows = $count_result->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_rows / $results_per_page);

$query = "SELECT * FROM movie ORDER BY {$sort_column} DESC, id DESC LIMIT ? OFFSET ?";

$params = [$results_per_page, $offset];
$types = "ii";

$stmt = $mysqli->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1 class='page-title' style='text-align: center;'>New Releases</h1>";

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
        echo "<p>Rating: " . (!empty($row['total_ratings']) ? "⭐ " . number_format($row['avg_rating'], 1) . " ({$row['total_ratings']} Rating)" : "No ratings yet") . "</p>";
        echo "</div>";
    }
    echo "</div>";

    echo "<div class='pagination-links'>";
    
    function build_pagination_link($page_num) {
        $params = $_GET;
        $params['page'] = $page_num;
        return '?' . http_build_query($params);
    }
    
    if ($page > 1) {
        echo "<a href='" . build_pagination_link($page - 1) . "' class='page-link'>&laquo; Previous</a>";
    }

    $start_page = max(1, $page - 2);
    $end_page = min($total_pages, $page + 2);

    if ($start_page > 1) {
        echo "<a href='" . build_pagination_link(1) . "' class='page-link'>1</a>";
        if ($start_page > 2) {
            echo "<span class='page-ellipsis'>...</span>";
        }
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $active_class = ($i == $page) ? 'active' : '';
        echo "<a href='" . build_pagination_link($i) . "' class='page-link {$active_class}'>{$i}</a>";
    }

    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            echo "<span class='page-ellipsis'>...</span>";
        }
        echo "<a href='" . build_pagination_link($total_pages) . "' class='page-link'>{$total_pages}</a>";
    }

    if ($page < $total_pages) {
        echo "<a href='" . build_pagination_link($page + 1) . "' class='page-link'>Next &raquo;</a>";
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