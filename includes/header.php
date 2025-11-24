<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/ratemymovie.png" type="image/x-icon">


</head>

<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <!-- header -->
    <header>
        <div class="container">
            <div class="head">
                <a href="/project/index.php" class="logo">
                    <img src="/project/assets/images/RateMyMovie211.png" alt="RateMyMovie">

                </a>
            </div>
            <div class="head">
                <div class="nav-bar">
                    <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="/project/film/films.php"
                            class="nav-item <?= $currentPage == 'films.php' ? 'active' : '' ?>">
                            Film
                        </a>

                        <a href="#about" class="nav-item">About</a>
                        <a href="#contact" class="nav-item ">Contact</a>
                        <a href="/project/admin/movie.php" class="nav-item ">Add Movies</a>
                    <?php
                    else: ?>
                        <!-- <a href="../project/film/films.php" class="nav-item">Film</a> -->
                         <a href="/project/film/films.php"
                            class="nav-item <?= $currentPage == 'films.php' ? 'active' : '' ?>">
                            Film
                        </a>
                        <a href="#about" class="nav-item">About</a>
                        <a href="#contact" class="nav-item ">Contact</a>
                        <a href="#follow" class="nav-item ">Follow</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="head">
                <div class="right-items">
                    <?php if (isset($_SESSION['user_id'])): ?>

                        <span class="nav-item">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
                        <a href="/project/user/logout.php" class="nav-item">Logout</a>

                    <?php else: ?>

                        <a href="/project/user/login.php" class="nav-item">Sign In</a>
                        <a href="/project/user/register.php" class="nav-item">Create Account</a>

                    <?php endif; ?>
                </div>

            </div>
        </div>
    </header>
</body>

</html>