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

<h1 style="text-align:center; color:#d68101;">Users Management</h1>

<?php if (!$userId): ?>
    <!-- List all users -->
    <?php
    $userQuery = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
    $userResult = $mysqli->query($userQuery);
    ?>
    <?php if ($userResult->num_rows > 0): ?>
        <div class="users-container">
            <?php while ($user = $userResult->fetch_assoc()): ?>
                <div class="user-card">
                    <h2><a href="?user_id=<?= $user['id']; ?>"><?= htmlspecialchars($user['name']); ?></a> (<?= htmlspecialchars($user['role']); ?>)</h2>
                    <p>Email: <?= htmlspecialchars($user['email']); ?></p>
                    <p>Registered On: <?= date("d M Y, H:i", strtotime($user['created_at'])); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="text-align:center; color:#d68101;">No users found.</p>
    <?php endif; ?>

<?php else: ?>
    <!-- Show reviews of a particular user -->
    <?php
    $stmt = $mysqli->prepare("SELECT id, name, email, role, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        echo "<p style='text-align:center; color:red;'>User not found.</p>";
    } else {
    ?>
        <div class="user-card">
            <h2><?= htmlspecialchars($user['name']); ?> (<?= htmlspecialchars($user['role']); ?>)</h2>
            <p>Email: <?= htmlspecialchars($user['email']); ?></p>
            <p>Registered On: <?= date("d M Y, H:i", strtotime($user['created_at'])); ?></p>
            <p><a href="users_profile.php" style="color:#d68101;">← Back to all users</a></p>

            <?php
            $reviewQuery = $mysqli->prepare("
                SELECT r.rating, r.review_text, r.created_at AS review_date, m.title, m.poster, m.release_year
                FROM reviews r
                JOIN movie m ON r.movie_id = m.id
                WHERE r.user_id = ?
                ORDER BY r.created_at DESC
            ");
            $reviewQuery->bind_param("i", $userId);
            $reviewQuery->execute();
            $reviews = $reviewQuery->get_result();
            ?>

            <?php if ($reviews->num_rows > 0): ?>
                <div class="user-reviews-container">
                    <?php while ($rev = $reviews->fetch_assoc()): 
                        $posterPath = !empty($rev['poster']) && $rev['poster'] !== 'N/A'
                            ? "../assets/images/uploads/" . htmlspecialchars($rev['poster'])
                            : "../assets/images/default-poster.png";
                    ?>
                        <div class="user-review-box">
                            <img src="<?= $posterPath ?>" alt="<?= htmlspecialchars($rev['title']); ?>">
                            <h3><?= htmlspecialchars($rev['title']); ?></h3>
                            <p>Year: <?= htmlspecialchars($rev['release_year']); ?></p>
                            <p>Rating: <?= str_repeat("★", $rev['rating']); ?></p>
                            <p>Review: <?= htmlspecialchars($rev['review_text']); ?></p>
                            <p class="review-date">Reviewed on: <?= date("d M Y, H:i", strtotime($rev['review_date'])); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p style="color:#d68101;">This user has not rated or reviewed any movies yet.</p>
            <?php endif; ?>
        </div>
    <?php } ?>
<?php endif; ?>

<?php
$mysqli->close();
include "../includes/footer.php";
?>
