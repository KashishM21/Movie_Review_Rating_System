<?php
include "../includes/session.php";

include "../includes/db.php";
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if ($email === '' || $password === '') {
        $error = "Email and Password are required.";
    } 
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }
    else {
        
        try {
            $stmt = $mysqli->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($user_id, $user_name, $hashed_password, $role);
            if ($stmt->fetch()) {
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['name'] = $user_name;
                    $_SESSION['role']=$role;
                    if($role==='admin'){
                        header("Location:../admin/dashboard.php");
                    }
                    else{
                        header("Location:../index.php");
                    }
                    exit;
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }

            $stmt->close();
            
        } catch (mysqli_sql_exception $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
include "../includes/header.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/form_style.css">

  <div class="form-container">
<h2>Login Form</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<form method="post">
    <label>Email</label><br>
    <input type="email" name="email" placeholder="Enter your email"><br><br>

    <label>Password</label><br>
    <input type="password" name="password" placeholder="Enter your password"><br><br>

    <label>Confirm Password</label><br>
    <input type="password" name="confirm_password" placeholder="Confirm your password" required><br><br>

    <button type="submit">Login</button>
</form>

<p>Not registered? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>
<?php
include "../includes/footer.php";
?>
