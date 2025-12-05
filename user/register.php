<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    //    VALIDATION SECTION

    if ($name === '' || $email === '' || $password === '' || $confirm_password === '') {
        $error = "All fields are required.";
    }

    // Email format using regex
    elseif (!preg_match('/^[a-zA-Z0-9._]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/', $email)) {
        $error = "Invalid email format.";
    }

    // Password match
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }

    // Strong password regex
    elseif (!preg_match(
        '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
        $password
    )) {
        $error = "Password must be at least 8 characters long 
              and contain at least one uppercase letter, 
              one lowercase letter, and one number.";
    }


    //    INSERT USER
    else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $mysqli->prepare("INSERT INTO users(name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $email, $password_hashed);
            $stmt->execute();
            $stmt->close();

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

include "../includes/header.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/form_style.css">
</head>

<body>
    <div class="form-container">
        <h2>Registration Form</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Name</label><br>
            <input type="text" name="name" placeholder="Enter your name"><br><br>

            <label>Email</label><br>
            <input type="email" name="email" placeholder="Enter your Email"><br><br>

            <label>Password</label><br>
            <input type="password" name="password" placeholder="Enter your password"><br><br>

            <label>Confirm Password</label><br>
            <input type="password" name="confirm_password" placeholder="Confirm your password"><br><br>

            <button type="submit">Register</button>
        </form>

        <p>Already registered? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>

<?php
include "../includes/footer.php";
?>