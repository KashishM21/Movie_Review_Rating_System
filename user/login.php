<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../includes/session.php"; 
include "../includes/db.php";      

$error = '';
$success = '';
$redirectUrl = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Email and Password are required.";
    } else {
        try {
            $stmt = $mysqli->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $mysqli->error);
            }

            $stmt->bind_param('s', $email);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->store_result();

            if ($stmt->num_rows === 0) {
                $error = "Invalid email or password.";
            } else {
                $stmt->bind_result($user_id, $user_name, $hashed_password, $role);
                $stmt->fetch();
                if (empty($hashed_password)) {
                    $error = "Login failed: password hash missing (contact admin).";
                } elseif (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['name'] = $user_name;
                    $_SESSION['role'] = $role;

                    $success = "Login successful!";
                    $redirectUrl = ($role === 'admin') ? "../admin/dashboard.php" : "../index.php";
                } else {
                    $error = "Invalid email or password.";
                }
            }
            $stmt->close();

        } catch (Exception $e) {
            $error = "Database error: " . $e->getMessage();
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

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<div class="page-content">
    <div class="form-container">

        <?php if (!empty($error)): ?>
            <script>
            Swal.fire({
                title: "Login Failed!",
                text: "<?= htmlspecialchars($error) ?>",
                icon: "error",
                confirmButtonText: "OK"
            });
            </script>
        <?php elseif (!empty($success)): ?>
            <script>
            Swal.fire({
                title: "Login Successful!",
                text: "Redirecting...",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });

            setTimeout(() => {
                window.location.href = "<?= $redirectUrl ?>";
            }, 2100);
            </script>
        <?php endif; ?>

        <h2>Login Form</h2>

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
