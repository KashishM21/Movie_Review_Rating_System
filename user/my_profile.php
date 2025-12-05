<?php
// Start PHP session to access user session variables
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Include database connection file
include "../includes/db.php";

// Include header file (optional, for navbar or site header)
include "../includes/header.php";

// Get logged-in user's ID from session
$user_id = $_SESSION['user_id'] ?? null;

// If user is not logged in, show error message and stop script
if (!$user_id) {
    echo "<p style='color:red; text-align:center;'>You must login to view your profile.</p>";
    exit;
}

// SQL query to fetch all reviews by this user, along with the corresponding movie info
$query = "
    SELECT r.*, m.title, m.poster, m.release_year, m.genre
    FROM reviews r
    JOIN movie m ON r.movie_id = m.id
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
";

// Prepare the SQL statement
$stmt = $mysqli->prepare($query);

// Bind the user_id parameter to the prepared statement (integer)
$stmt->bind_param("i", $user_id);

// Execute the prepared statement
$stmt->execute();

// Get the result set from the executed statement
$result = $stmt->get_result();
?>

<!-- Link to external CSS file for profile page styling -->
<link rel="stylesheet" href="../assets/css/my_profile.css">

<!-- Page title -->
<h1>Your Reviews & Ratings</h1>

<?php if ($result->num_rows > 0): ?>
    <!-- Container for all user review cards -->
    <div class="user-reviews-container">
        <?php while ($row = $result->fetch_assoc()): 
            // Determine poster path: use uploaded poster if available, otherwise default poster
            $posterPath = !empty($row['poster']) && $row['poster'] !== 'N/A' 
                          ? "../assets/images/uploads/" . htmlspecialchars($row['poster']) 
                          : "../assets/images/default-poster.png";
        ?>
            <!-- Make the entire review card clickable, linking to the movie description page -->
            <a href="../movie_link/movie_description.php?id=<?= $row['movie_id'] ?>" class="user-review-box-link">
                <div class="user-review-box">
                    <!-- Movie poster -->
                    <img src="<?= $posterPath ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    
                    <!-- Movie title -->
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    
                    <!-- Genre -->
                    <p>Genre: <?= htmlspecialchars($row['genre']) ?></p>
                    
                    <!-- Release year -->
                    <p>Year: <?= htmlspecialchars($row['release_year']) ?></p>
                    
                    <!-- User's rating displayed as stars -->
                    <p>Rating: <?= str_repeat("★", $row['rating']); ?></p>
                    
                    <!-- User's written review -->
                    <p>Review: <?= htmlspecialchars($row['review_text']); ?></p>
                    
                    <!-- Review date -->
                    <p class="review-date">Reviewed on: <?= date("d M Y, H:i", strtotime($row['created_at'])) ?></p>
                </div>
            </a>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <!-- Message shown if user has not reviewed any movies -->
    <p style="text-align:center; color:#d68101;">You haven't rated or reviewed any movies yet.</p>
<?php endif; ?>

<?php
// Close the prepared statement
$stmt->close();

// Close the database connection
$mysqli->close();

// Include the footer file
include "../includes/footer.php";
?>
