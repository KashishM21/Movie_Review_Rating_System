<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../includes/db.php";
include "../includes/header.php";
include "../includes/filter-bar.php";

// Read filters from the URL
$selectedYear   = $_GET['year'] ?? '';
$selectedRating = $_GET['rating'] ?? '';
$selectedGenre  = $_GET['genre'] ?? '';
$selectedTitle  = $_GET['title'] ?? '';

$results_per_page = 15;

// Validate page number
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

// Starting point for LIMIT
$offset = ($page - 1) * $results_per_page;


$query = "SELECT * FROM movie WHERE 1=1";
$count_query = "SELECT COUNT(*) AS total FROM movie WHERE 1=1";

// will store filter values and their types
$params = [];
$types = "";

// Apply filters and bind values
if ($selectedYear !== '') {
    $query .= " AND release_year = ?";
    $count_query .= " AND release_year = ?";
    $types .= "i";         // integer
    $params[] = $selectedYear;
}

if ($selectedRating !== '') {
    $query .= " AND avg_rating >= ?";
    $count_query .= " AND avg_rating >= ?";
    $types .= "d";         // double
    $params[] = $selectedRating;
}

if ($selectedGenre !== '') {
    $query .= " AND genre = ?";
    $count_query .= " AND genre = ?";
    $types .= "s";         // string
    $params[] = $selectedGenre;
}

if ($selectedTitle !== '') {
    $query .= " AND title LIKE ?";
    $count_query .= " AND title LIKE ?";
    $types .= "s";
    $params[] = "%$selectedTitle%";  
}

// Count total rows for pagination
$stmt_count = $mysqli->prepare($count_query);

// If filters exist → bind them
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}

$stmt_count->execute();
$count_result = $stmt_count->get_result();

// Fetch total rows
$total_rows = (int)$count_result->fetch_assoc()['total'];
$stmt_count->close();

// Total pages
$total_pages = ($results_per_page > 0) ? ceil($total_rows / $results_per_page) : 1;

// Final main query with sorting + pagination
$query .= "  ORDER BY release_year DESC, created_at DESC 
          LIMIT ? OFFSET ?";

$stmt = $mysqli->prepare($query);

// Add LIMIT + OFFSET values
$params_with_limit = $params;
$types_with_limit = $types . "ii"; 

$params_with_limit[] = $results_per_page;
$params_with_limit[] = $offset;

$bind_names = [];
$bind_names[] = $types_with_limit;

foreach ($params_with_limit as $k => $v) {
    $bind_names[] = &$params_with_limit[$k];  // pass by reference
}

// Bind the parameters dynamically
call_user_func_array([$stmt, 'bind_param'], $bind_names);

$stmt->execute();
$result = $stmt->get_result();

// Page heading
echo "<h1 class='page-title' style='text-align:center;'>&#10024;New Releases &#10024;</h1>";

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

        // Show rating or "No ratings"
        echo "<p>Rating: " .
            (!empty($row['total_ratings'])
                ? "&#11088; " . number_format($row['avg_rating'], 1) . " ({$row['total_ratings']} Rating)"
                : "No ratings yet")
            . "</p>";

        echo "</div>";
    }

    echo "</div>";

    // PAGINATION LINKS
    echo "<div class='pagination-links'>";

    // Function to rebuild URL including filters
    function build_pagination_link($page_num)
    {
        $params = $_GET;          // copy current URL params
        $params['page'] = $page_num;
        return '?' . http_build_query($params); // create URL query string
    }

    // Previous button
    if ($page > 1) {
        echo "<a href='" . build_pagination_link($page - 1) . "' class='page-link'>&laquo; Previous</a>";
    }

    // Page number range
    $start_page = max(1, $page - 2);
    $end_page = min($total_pages, $page + 2);

    // Show "1" and "..."
    if ($start_page > 1) {
        echo "<a href='" . build_pagination_link(1) . "' class='page-link'>1</a>";
        if ($start_page > 2) echo "<span class='page-ellipsis'>...</span>";
    }

    // Main pages
    for ($i = $start_page; $i <= $end_page; $i++) {
        $active_class = ($i == $page) ? 'active' : '';
        echo "<a href='" . build_pagination_link($i) . "' class='page-link {$active_class}'>{$i}</a>";
    }

    // Show "..." and last page
    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) echo "<span class='page-ellipsis'>...</span>";
        echo "<a href='" . build_pagination_link($total_pages) . "' class='page-link'>{$total_pages}</a>";
    }

    // Next button
    if ($page < $total_pages) {
        echo "<a href='" . build_pagination_link($page + 1) . "' class='page-link'>Next &raquo;</a>";
    }

    echo "</div>";

} else {
    // When no movies found
    echo "<p style='text-align:center; color:#d68101; font-size:1.2rem; margin-top:20px;'>No movies found.</p>";
}

// Close database
$stmt->close();
$mysqli->close();

include "../includes/footer.php";
?>
<link rel="stylesheet" href="../assets/css/film_style.css">
