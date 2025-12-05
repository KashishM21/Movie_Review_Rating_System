<?php
// Show all errors for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Retrieve filter values from URL or default to empty string
$selectedYear = $_GET['year'] ?? '';
$selectedRating = $_GET['rating'] ?? '';
$selectedGenre = $_GET['genre'] ?? '';
$selectedTitle = $_GET['title'] ?? '';
?>
<link rel="stylesheet" href="../assets/css/filter-bar.css"> <!-- CSS for filter bar -->

<div class="top-filter-bar">
    <div class="left-filters">
        <span class="label">BROWSE BY</span>

        <!-- Year filter -->
        <select name="year">
            <option value="">Select Year</option>
            <?php
            // Show years from current year down to 1900
            for ($y = date("Y"); $y >= 1900; $y--) {
                $selected = ($selectedYear == $y) ? "selected" : "";
                echo "<option value='$y' $selected>$y</option>";
            }
            ?>
        </select>

        <!-- Rating filter -->
        <select name="rating">
            <option value="">Rating</option>
            <?php
            // Show ratings from 3+ to 5+
            for ($r = 2; $r <= 5; $r++) {
                $selected = ($selectedRating == $r) ? "selected" : "";
                echo "<option value='$r' $selected>$r+</option>";
            }
            ?>
        </select>

        <!-- Genre filter with datalist -->
        <input list="genreList" name="genre" placeholder="Genre" value="<?= htmlspecialchars($selectedGenre) ?>">
        <datalist id="genreList">
            <?php
            $genres = ['Action', 'Drama', 'Comedy', 'Horror', 'Romance', 'Thriller', 'Sci-Fi'];
            foreach ($genres as $genre) {
                echo "<option value='$genre'>";
            }
            ?>
        </datalist>

        <!-- Title search -->
        <input type="text" name="title" placeholder="Search by Title" value="<?= htmlspecialchars($selectedTitle) ?>">

        <!-- Search button triggers JS function -->
        <button class="search-btn" onclick="applyFilter()">Search</button>
    </div>
</div>

<script>
    // Applies filters by building URL parameters and reloading the page
    function applyFilter() {
        const params = new URLSearchParams();
        document.querySelectorAll('.left-filters select, .left-filters input').forEach(el => {
            if (el.value.trim() !== "") {
                params.set(el.name, el.value.trim());
            }
        });

        window.location.search = params.toString(); // Reload page with new query
    }
</script>
