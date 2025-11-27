<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "session.php";
?>


<link rel="stylesheet" href="../assets/css/style.css">
<link rel="shortcut icon" href="../assets/images/ratemymovie.png" type="image/x-icon">

<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
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
                    <a href="/project/index.php" class="nav-item">Home</a>
                    <a href="/project/film/films.php"
                        class="nav-item <?= $currentPage == 'films.php' ? 'active' : '' ?>">
                        Film
                    </a>
                    <a href="/project/film/new_released.php"
                        class="nav-item contact-link<?= $currentPage == 'new_released.php' ? 'active' : '' ?>">
                    New Release
                    </a>
                    <a href="#contact" class="nav-item contact-link">Contact</a>
                    <a href="/project/admin/movie.php" class="nav-item ">Add Movies</a>
                <?php
                else: ?>
                    <a href="/project/index.php" class="nav-item">Home</a>
                    <a href="/project/film/films.php"
                        class="nav-item <?= $currentPage == 'films.php' ? 'active' : '' ?>">
                        Film
                    </a>
                     <a href="/project/film/new_released.php"
                        class="nav-item contact-link<?= $currentPage == 'new_released.php' ? 'active' : '' ?>">
                    New Release
                    </a>
                    <a href="#contact" class="nav-item contact-link ">Contact</a>
                    <a href="#follow" class="nav-item contact-link">Follow</a>
                <?php endif; ?>
                <div class="right-search">
                    <input type="text" id="apiSearch" placeholder="Search movie Online…" onkeyup="searchAPI()">
                    <div id="apiResults"></div>
                </div>
            </div>
        </div>
        <div class="head">
            <div class="right-items">
                <div class="profile-container">
                    <img src="/project/assets/images/thriller/user.png"
                        alt="profile"
                        class="header-image profile-toggle">

                    <div class="profile-dropdown">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <span class="dropdown-item">Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></span>
                            <a href="/project/user/logout.php" class="dropdown-item"><img src="/project/assets/images/thriller/log-out.png" class="image">Logout</a>
                        <?php else: ?>
                            <?php if ($currentPage !== 'login.php'): ?>
                                <a href="/project/user/login.php" class="dropdown-item"><img src="/project/assets/images/thriller/enter.png" class="image">Sign In</a>
                            <?php endif; ?>

                            <?php if ($currentPage !== 'register.php'): ?>
                                <a href="/project/user/register.php" class="dropdown-item"><img src="/project/assets/images/thriller/add.png" class="image">Create Account</a>
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
        const toggle = document.querySelector(".profile-toggle");
        const dropdown = document.querySelector(".profile-dropdown");

        toggle.addEventListener("click", () => {
            dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
        });

        document.addEventListener("click", (e) => {
            if (!e.target.closest(".profile-container")) {
                dropdown.style.display = "none";
            }
            
        });
         document.addEventListener("click", (e) => {
        const searchBox = document.getElementById("apiSearch");
        const resultsBox = document.getElementById("apiResults");

        // If click is outside search box AND results dropdown
        if (!e.target.closest("#apiSearch") && !e.target.closest("#apiResults")) {
            resultsBox.style.display = "none";
        }
    });
    });

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
                    resultBox.innerHTML = "<p>No movies found</p>";
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