<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<link rel="stylesheet" href="../assets/css/filter-bar.css">
<div class="top-filter-bar">
    <div class="left-filters">
        <span class="label">BROWSE BY</span>

        <select name="year" onchange="applyFilter()">
            <option value="">Select Year</option>
            <?php
            for ($y = date("Y"); $y >= 1900; $y--) {
                echo "<option value='$y'>$y</option>";
            }
            ?>
        </select>

        <select name="rating" onchange="applyFilter()">
            <option value="">Rating</option>
            <option value="5">5+</option>
            <option value="4">4+</option>
            <option value="3">3+</option>
        </select>


        <input list="genreList" name="genre" placeholder="Genre" onchange="applyFilter()">

        <datalist id="genreList">
            <option value="Action">
            <option value="Drama">
            <option value="Comedy">
            <option value="Horror">
            <option value="Romance">
            <option value="Thriller">
            <option value="Sci-Fi">
        </datalist>
    </div>
</div>

<script>
    function applyFilter() {
        const params = new URLSearchParams(window.location.search);

        document.querySelectorAll('.left-filters select, .left-filters input[type="number"]').forEach(el => {
            if (el.value) params.set(el.name, el.value);
            else params.delete(el.name);
        });

        window.location.search = params.toString();
    }
</script>