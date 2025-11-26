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

        <select name="year" onchange="applyFilter()">
            <option value="">Select Year</option>
            <?php
            for ($y = date("Y"); $y >= 1900; $y--) {
                $selected = ($selectedYear == $y) ? "selected" : "";
                echo "<option value='$y' $selected>$y</option>";
            }
            ?>
        </select>
        <select name="rating" onchange="applyFilter()">
            <option value="">Rating</option>
            <?php
            for ($r = 3; $r <= 5; $r++) {
                $selected = ($selectedRating == $r) ? "selected" : "";
                echo "<option value='$r' $selected>$r+</option>";
            }
            ?>
        </select>
        <input list="genreList" name="genre" placeholder="Genre" onchange="applyFilter()" value="<?= htmlspecialchars($selectedGenre) ?>">

        <datalist id="genreList">
            <?php
            $genres = ['Action', 'Drama', 'Comedy', 'Horror', 'Romance', 'Thriller', 'Sci-Fi'];
            foreach ($genres as $genre) {
                echo "<option value='$genre'>";
            }
            ?>
        </datalist>
    </div>
</div>

<script>
function applyFilter() {
    const params = new URLSearchParams(window.location.search);

    document.querySelectorAll('.left-filters select, .left-filters input[list]').forEach(el => {
        if (el.value) params.set(el.name, el.value);
        else params.delete(el.name);
    });

    window.location.search = params.toString();
}
</script>
