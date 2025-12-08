<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../includes/db.php";
include "../includes/header.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<p style='color:red; text-align:center;'>Access denied. Admins only.</p>";
    exit;
}

$userId = $_GET['user_id'] ?? null;
?>

<link rel="stylesheet" href="../assets/css/users_profile.css">
<link rel="stylesheet" href="../assets/css/film_style.css">

<h1 style="text-align:center; color:#d68101;">User Details</h1>

<?php if (!$userId): ?>
    <!-- List all users -->
    <?php
    $userQuery = "SELECT id, name, email, role, created_at 
                  FROM users 
                  WHERE role = 'user' 
                  ORDER BY created_at DESC";
    $userResult = $mysqli->query($userQuery);
    ?>
    <?php if ($userResult->num_rows > 0): ?>
        <div class="users-container">
            <?php while ($user = $userResult->fetch_assoc()): ?>
                <div class="user-card">
                    <h2><a href="?user_id=<?= $user['id']; ?>"><?= htmlspecialchars($user['name']); ?></a> (<?= htmlspecialchars($user['role']); ?>)</h2>
                    <p>Email: <?= htmlspecialchars($user['email']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="text-align:center; color:#d68101;">No users found.</p>
    <?php endif; ?>

<?php else: ?>
    <!-- Show reviews of a particular user -->

    <?php
    $stmt = $mysqli->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        echo "<p style='text-align:center; color:red;'>User not found.</p>";
    } else {

        $results_per_page = 15; // reviews per page
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $results_per_page;

        // Count total reviews
        $countStmt = $mysqli->prepare("
            SELECT COUNT(*) AS total 
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.user_id = ? AND u.role='user'
        ");
        $countStmt->bind_param("i", $userId);
        $countStmt->execute();
        $totalReviews = $countStmt->get_result()->fetch_assoc()['total'];
        $countStmt->close();

        $total_pages = ceil($totalReviews / $results_per_page);

        // Fetch paginated reviews
        $reviewQuery = $mysqli->prepare("
            SELECT r.rating, r.review_text, r.created_at AS review_date, 
                   m.id AS movie_id, m.title, m.poster, m.release_year
            FROM reviews r
            JOIN movie m ON r.movie_id = m.id
            WHERE r.user_id = ?
            ORDER BY r.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $reviewQuery->bind_param("iii", $userId, $results_per_page, $offset);
        $reviewQuery->execute();
        $reviews = $reviewQuery->get_result();
    ?>

        <p><a href="users_profile.php" class="btn-back">&#8592;Back</a></p>

        <div class="user-info">
            <h2><?= htmlspecialchars($user['name']); ?></h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        </div>

        <?php if ($reviews->num_rows > 0): ?>
            <div class="user-reviews-container">
                <?php while ($rev = $reviews->fetch_assoc()):
                    $posterPath = !empty($rev['poster']) && $rev['poster'] !== 'N/A'
                        ? "../assets/images/uploads/" . htmlspecialchars($rev['poster'])
                        : "../assets/images/default-poster.png";
                ?>
                    <div class="user-review-box">
                        <a href="/project/movie_link/movie_description.php?id=<?= $rev['movie_id']; ?>">
                            <img src="<?= $posterPath ?>" alt="<?= htmlspecialchars($rev['title']); ?>">
                        </a>
                        <h3><?= htmlspecialchars($rev['title']); ?></h3>
                        <p>Year: <?= htmlspecialchars($rev['release_year']); ?></p>
                        <p class="rating">Rating: <?= str_repeat("&#9733;", $rev['rating']); ?></p>
                        <p class="review-text">Review: <?= htmlspecialchars($rev['review_text']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination links -->
            <div class="pagination-links">
                <?php
                $build_link = function($page_num) {
                    $params = $_GET;
                    $params['page'] = $page_num;
                    return '?' . http_build_query($params);
                };

                if ($page > 1) echo "<a href='" . $build_link($page - 1) . "' class='page-link'>&laquo; Previous</a>";

                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo "<a href='" . $build_link($i) . "' class='page-link {$active}'>$i</a>";
                }

                if ($page < $total_pages) echo "<a href='" . $build_link($page + 1) . "' class='page-link'>Next &raquo;</a>";
                ?>
            </div>
        <?php else: ?>
            <p style="color:red; text-align:center">This user has not rated or reviewed any movies yet.</p>
        <?php endif; ?>

    <?php } ?>
<?php endif; ?>

<?php
$mysqli->close();
include "../includes/footer.php";
?>
