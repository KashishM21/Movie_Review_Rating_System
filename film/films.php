<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../includes/db.php";
include "../includes/header.php";
include "../includes/filter-bar.php"; // your filter bar

// GET filters
$selectedYear   = $_GET['year'] ?? '';
$selectedRating = $_GET['rating'] ?? '';
$selectedGenre  = $_GET['genre'] ?? '';
$selectedTitle  = $_GET['title'] ?? '';

// Pagination settings
$results_per_page = 15;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $results_per_page;

// Base query
$query = "SELECT * FROM movie WHERE 1=1";
$count_query = "SELECT COUNT(*) AS total FROM movie WHERE 1=1";

$params = [];
$types = "";

// Apply filters
if ($selectedYear !== '') {
    $query .= " AND release_year = ?";
    $count_query .= " AND release_year = ?";
    $types .= "i";
    $params[] = $selectedYear;
}

if ($selectedRating !== '') {
    $query .= " AND avg_rating >= ?";
    $count_query .= " AND avg_rating >= ?";
    $types .= "d";
    $params[] = $selectedRating;
}

if ($selectedGenre !== '') {
    $query .= " AND genre = ?";
    $count_query .= " AND genre = ?";
    $types .= "s";
    $params[] = $selectedGenre;
}

if ($selectedTitle !== '') {
    $query .= " AND title LIKE ?";
    $count_query .= " AND title LIKE ?";
    $types .= "s";
    $params[] = "%$selectedTitle%"; 
}

$stmt_count = $mysqli->prepare($count_query);
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_rows = (int)$count_result->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ($results_per_page > 0) ? ceil($total_rows / $results_per_page) : 1;

$query .= " ORDER BY avg_rating DESC, release_year DESC, id DESC LIMIT ? OFFSET ?";

$stmt = $mysqli->prepare($query);

$params_with_limit = $params;
$types_with_limit = $types . "ii";
$params_with_limit[] = $results_per_page;
$params_with_limit[] = $offset;

$bind_names = [];
$bind_names[] = $types_with_limit;
foreach ($params_with_limit as $k => $v) {
    $bind_names[] = &$params_with_limit[$k];
}
call_user_func_array([$stmt, 'bind_param'], $bind_names);

$stmt->execute();
$result = $stmt->get_result();
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
        echo "<p>Rating: " . (!empty($row['total_ratings']) ? "&#11088; " . number_format($row['avg_rating'], 1) . " ({$row['total_ratings']} Rating)" : "No ratings yet") . "</p>";
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
        if ($start_page > 2) echo "<span class='page-ellipsis'>...</span>";
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $active_class = ($i == $page) ? 'active' : '';
        echo "<a href='" . build_pagination_link($i) . "' class='page-link {$active_class}'>{$i}</a>";
    }

    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) echo "<span class='page-ellipsis'>...</span>";
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
