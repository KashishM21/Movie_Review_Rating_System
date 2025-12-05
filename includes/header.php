<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "session.php"; // Start session and check login
?>
<link rel="stylesheet" href="../assets/css/style.css"> <!-- Main CSS -->
<link rel="shortcut icon" href="../assets/images/ratemymovie.png" type="image/x-icon"> <!-- Favicon -->

<?php
// Store the current page filename for highlighting active nav item
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header>
    <div class="container">
        <!-- Logo Section -->
        <div class="head">
            <a href="/project/index.php" class="logo">
                <img src="/project/assets/images/RateMyMovie211.png" alt="RateMyMovie">
            </a>
        </div>

        <!-- Navigation Menu -->
        <div class="head">
            <div class="nav-bar">
                <a href="/project/index.php" class="nav-item">Home</a>
                <a href="/project/film/films.php" class="nav-item <?= $currentPage == 'films.php' ? 'active' : '' ?>">Film</a>
                <a href="/project/film/new_released.php" class="nav-item contact-link<?= $currentPage == 'new_released.php' ? 'active' : '' ?>">New Release</a>
                <a href="#contact" class="nav-item contact-link">Contact</a>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <!-- Admin users see Add Movies link -->
                    <a href="/project/admin/movie.php" class="nav-item">Add Movies</a>
                <?php else: ?>
                    <!-- Regular users see Follow link -->
                    <a href="#follow" class="nav-item contact-link">Follow</a>
                <?php endif; ?>

                <!-- Search bar for online movies via API -->
                <div class="right-search">
                    <input type="text" id="apiSearch" placeholder="Search movie Online…" onkeyup="searchAPI()">
                    <div id="apiResults"></div> <!-- API results dropdown -->
                </div>
            </div>
        </div>

        <!-- Profile / Login Section -->
  <div class="head">
    <div class="right-items">
        <div class="profile-container">
            <!-- Profile icon -->
            <img src="/project/assets/images/thriller/user-dropdown2.png" alt="profile" class="header-image profile-toggle">

            <div class="profile-dropdown">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged-in user -->
                    <span class="dropdown-item">Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></span>
                    <a href="/project/user/logout.php" class="dropdown-item">
                        <img src="/project/assets/images/thriller/log-out.png" class="image"> Logout
                    </a>

                    <!-- Show profile link based on role -->
                    <?php if (($_SESSION['role'] ?? '') === 'admin' && $currentPage !== 'users_profile.php'): ?>
                        <!-- Admin sees all users profile -->
                        <a href="/project/admin/users_profile.php" class="dropdown-item">
                            <img src="/project/assets/images/thriller/admin.png" class="image"> Users Profile
                        </a>
                    <?php elseif (($_SESSION['role'] ?? '') !== 'admin' && $currentPage !== 'my_profile.php'): ?>
                        <!-- Regular user sees own profile -->
                        <a href="/project/user/my_profile.php" class="dropdown-item">
                            <img src="/project/assets/images/thriller/log-out.png" class="image"> My Profile
                        </a>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- User is not logged in: Show login/register links -->
                    <?php if ($currentPage !== 'login.php'): ?>
                        <a href="/project/user/login.php" class="dropdown-item">
                            <img src="/project/assets/images/thriller/enter.png" class="image"> Sign In
                        </a>
                    <?php endif; ?>

                    <?php if ($currentPage !== 'register.php'): ?>
                        <a href="/project/user/register.php" class="dropdown-item">
                            <img src="/project/assets/images/thriller/add.png" class="image"> Create Account
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Profile dropdown toggle
        const toggle = document.querySelector(".profile-toggle");
        const dropdown = document.querySelector(".profile-dropdown");

        toggle.addEventListener("click", () => {
            dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
        });

        // Close profile dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".profile-container")) {
                dropdown.style.display = "none";
            }
        });

        // Close API search results when clicking outside
        document.addEventListener("click", (e) => {
            const searchBox = document.getElementById("apiSearch");
            const resultsBox = document.getElementById("apiResults");

            if (!e.target.closest("#apiSearch") && !e.target.closest("#apiResults")) {
                resultsBox.style.display = "none";
            }
        });
    });

    // Search movies using OMDb API
    function searchAPI() {
        let query = document.getElementById("apiSearch").value.trim();
        let resultBox = document.getElementById("apiResults");

        if (query.length < 2) {
            resultBox.innerHTML = "";
            resultBox.style.display = "none";
            return;
        }

        fetch(`https://www.omdbapi.com/?s=${encodeURIComponent(query)}&apikey=b04d0cf`)
            .then(response => response.json())
            .then(data => {
                if (data.Search) {
                    let html = "<ul>";
                    data.Search.forEach(movie => {
                        html += `
                        <li>
                            <a href="/project/movie_link/movie_description.php?id=${movie.imdbID}">
                                <img src="${movie.Poster !== 'N/A' ? movie.Poster : '/project/assets/images/default-poster.png'}" />
                                ${movie.Title} (${movie.Year})
                            </a>
                        </li>`;
                    });
                    html += "</ul>";
                    resultBox.innerHTML = html;
                    resultBox.style.display = "block";
                } else {
                    resultBox.innerHTML = '<p style="color: red; font-weight: bold;">No movies found</p>';
                    resultBox.style.display = "block";
                }
            })
            .catch(err => {
                resultBox.innerHTML = "<p>Error loading API</p>";
                resultBox.style.display = "block";
                console.error(err);
            });
    }
</script>