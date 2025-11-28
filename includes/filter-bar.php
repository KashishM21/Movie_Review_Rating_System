<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$selectedYear = $_GET['year'] ?? '';
$selectedRating = $_GET['rating'] ?? '';
$selectedGenre = $_GET['genre'] ?? '';
?>
<link rel="stylesheet" href="../assets/css/filter-bar.css">

<div class="top-filter-bar">
    <div class="left-filters">
        <span class="label">BROWSE BY</span>

        <select name="year">
            <option value="">Select Year</option>
            <?php
            for ($y = date("Y"); $y >= 1900; $y--) {
                $selected = ($selectedYear == $y) ? "selected" : "";
                echo "<option value='$y' $selected>$y</option>";
            }
            ?>
        </select>

        <select name="rating">
            <option value="">Rating</option>
            <?php
            for ($r = 3; $r <= 5; $r++) {
                $selected = ($selectedRating == $r) ? "selected" : "";
                echo "<option value='$r' $selected>$r+</option>";
            }
            ?>
        </select>

        <input list="genreList" name="genre" placeholder="Genre" value="<?= htmlspecialchars($selectedGenre) ?>">

        <datalist id="genreList">
            <?php
            $genres = ['Action', 'Drama', 'Comedy', 'Horror', 'Romance', 'Thriller', 'Sci-Fi'];
            foreach ($genres as $genre) {
                echo "<option value='$genre'>";
            }
            ?>
        </datalist>

        <!-- 🔍 Search Button -->
        <button class="search-btn" onclick="applyFilter()">Search</button>

    </div>
</div>

<script>
function applyFilter() {
    const params = new URLSearchParams();

    document.querySelectorAll('.left-filters select, .left-filters input[list]').forEach(el => {
        if (el.value.trim() !== "") {
            params.set(el.name, el.value.trim());
        }
    });

    window.location.search = params.toString();
}
</script>
