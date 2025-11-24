<?php
include "../includes/session.php";
include "../includes/db.php";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $error = "All fields are required.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $mysqli->prepare("INSERT INTO users(name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $email, $password_hashed);
            $stmt->execute();
            $stmt->close();
            // $success = "Registration successful. <a href='login.php'>Login here</a>";
            header("Location: login.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $error = "Email already registered.";
            } else {
                $error = "Registration failed: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/form_style.css">
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color:green;"><?= $success ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Name</label><br>
            <input type="text" name="name"><br><br>

            <label>Email</label><br>
            <input type="email" name="email"><br><br>

            <label>Password</label><br>
            <input type="password" name="password" ><br><br>

            <button type="submit">Register</button>
        </form>

        <p>Already registered? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
