<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include "../includes/db.php";
include "../includes/header.php";
include "../includes/filter-bar.php";

$year   = $_GET['year'] ?? '';
$genre  = $_GET['genre'] ?? '';
$rating = $_GET['rating'] ?? '';
$search = $_GET['title'] ?? '';

$results_per_page = 15;
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $results_per_page;

$where = [];
$params = [];
$types = "";

if (!empty($year)) {
    $where[] = "release_year = ?";
    $params[] = $year;
    $types .= "i";
}

if (!empty($rating)) {
    $where[] = "avg_rating >= ?";
    $params[] = $rating;
    $types .= "i";
}

if (!empty($genre)) {
    $where[] = "genre LIKE ?";
    $params[] = "%$genre%";
    $types .= "s";
}

if (!empty($search)) {
    $where[] = "title LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}
$where_sql = "";
if (count($where) > 0) {
    $where_sql = "WHERE " . implode(" AND ", $where);
}

$count_query = "SELECT COUNT(*) AS total FROM movie $where_sql";
$stmt_count = $mysqli->prepare($count_query);

if ($types) {
    $stmt_count->bind_param($types, ...$params);
}

$stmt_count->execute();
$total_rows = $stmt_count->get_result()->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_rows / $results_per_page);
$query = "SELECT * FROM movie $where_sql 
          ORDER BY release_year DESC, created_at DESC 
          LIMIT ? OFFSET ?";

$params2 = $params;
$types2 = $types;

$params2[] = $results_per_page;
$params2[] = $offset;
$types2 .= "ii";

$stmt = $mysqli->prepare($query);
$stmt->bind_param($types2, ...$params2);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1 class='page-title' style='text-align:center;'>&#10024;New Releases &#10024;</h1>";


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

        if (!empty($row['total_ratings'])) {
            echo "<p>Rating: ⭐ " . number_format($row['avg_rating'], 1) . " ({$row['total_ratings']} Ratings)</p>";
        } else {
            echo "<p>No ratings yet</p>";
        }

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
        $active = ($i == $page) ? 'active' : '';
        echo "<a href='" . build_pagination_link($i) . "' class='page-link $active'>$i</a>";
    }

    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1)
            echo "<span class='page-ellipsis'>...</span>";
        echo "<a href='" . build_pagination_link($total_pages) . "' class='page-link'>{$total_pages}</a>";
    }

    if ($page < $total_pages) {
        echo "<a href='" . build_pagination_link($page + 1) . "' class='page-link'>Next &raquo;</a>";
    }

    echo "</div>";

} else {
    echo "<p style='text-align:center;'>No movies found.</p>";
}

$stmt->close();
$mysqli->close();

include "../includes/footer.php";
?>

<link rel="stylesheet" href="../assets/css/film_style.css">
