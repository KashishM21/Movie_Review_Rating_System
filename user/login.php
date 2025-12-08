<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../includes/session.php";  // Start session and manage user login state
include "../includes/db.php";       // Database connection

// Initialize variables for error/success messages and redirect URL
$error = '';
$success = '';
$redirectUrl = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and trim user input
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check if both email and password are provided
    if ($email === '' || $password === '') {
        $error = "Email and Password are required.";
    } else {
        try {
            // Prepare SQL statement to fetch user data by email
            $stmt = $mysqli->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $mysqli->error);
            }

            $stmt->bind_param('s', $email); // Bind email parameter
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $stmt->store_result(); // Store result to check if user exists

            if ($stmt->num_rows === 0) {
                $error = "Invalid email or password."; // No user found
            } else {
                // Bind results to variables
                $stmt->bind_result($user_id, $user_name, $hashed_password, $role);
                $stmt->fetch();

                if (empty($hashed_password)) {
                    $error = "Login failed: password hash missing (contact admin).";
                } elseif (password_verify($password, $hashed_password)) {
                    // Successful login: set session variables
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['name'] = $user_name;
                    $_SESSION['role'] = $role;

                    $success = "Login successful!";
                    // Redirect admins to dashboard, normal users to homepage
                    $redirectUrl = ($role === 'admin') ? "../admin/dashboard.php" : "../index.php";
                } else {
                    $error = "Invalid email or password."; // Wrong password
                }
            }

            $stmt->close();

        } catch (Exception $e) {
            $error = "Database error: " . $e->getMessage(); // Catch any database errors
        }
    }
}

include "../includes/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="../assets/css/form_style.css">

<!-- SweetAlert CDN for popup messages -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<div class="page-content">
    <div class="form-container">

        <?php if (!empty($error)): ?>
            <!-- Show error popup using SweetAlert -->
            <script>
            Swal.fire({
                title: "Login Failed!",
                text: "<?= htmlspecialchars($error) ?>",
                icon: "error",
                confirmButtonText: "OK"
            });
            </script>
        <?php elseif (!empty($success)): ?>
            <!-- Show success popup and redirect after 2 seconds -->
            <script>
            Swal.fire({
                title: "Login Successful!",
                text: "Welcome",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });

            setTimeout(() => {
                window.location.href = "<?= $redirectUrl ?>";
            }, 1000);
            </script>
        <?php endif; ?>

        <h2>Login Form</h2>

        <!-- Login form -->
        <form method="post" action="">
            <label>Email</label><br>
            <input type="email" name="email" placeholder="Enter your email" required><br><br>

            <label>Password</label><br>
            <input type="password" name="password" placeholder="Enter your password" required><br><br>

            <button type="submit">Login</button>
        </form>

        <p>Not registered? <a href="register.php">Register here</a></p>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
