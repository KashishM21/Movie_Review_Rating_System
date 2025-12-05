<?php
include "../includes/header.php"; // Include header
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <link rel="stylesheet" href="../assets/css/movie_form.css"> <!-- CSS for form styling -->
    <script src="../assets/js/script.js"></script> <!-- JS for form behavior -->
</head>

<body>
    <!-- Display error or success message -->
    <?php if (!empty($message)): ?>
        <p style="color:red; font-weight:bold;"><?= $message ?></p>
    <?php endif; ?>

    <div class="container2">
        <h2>Add Movie</h2>

        <!-- Form to add new movie, enctype allows file upload -->
        <form method="post" action="add_movie.php" enctype="multipart/form-data">   

            <!-- Movie title input -->
            <label for='title'>Movie Title</label><br>
            <input type="text" name="title" placeholder="Enter movie title"> <br><br>

            <!-- Genre selection -->
            <label for="genre">Select Genre:</label>
            <select id="genre" name="genre" onchange="toggleCustomGenre()">
                <option value="">Select a Genre</option>
                <option value="action">Action</option>
                <option value="adventure">Adventure</option>
                <option value="comedy">Comedy</option>
                <option value="drama">Drama</option>
                <option value="thriller">Thriller</option>
                <option value="romance">Romance</option>
                <option value="horror">Horror</option>
                <option value="animation">Animation</option>
                <option value="other">Other</option>
            </select>
            <br><br>

            <!-- Custom genre input, shown only if "Other" is selected -->
            <div id="customGenreBox" style="display:none;">
                <label>Enter Custom Genre</label>
                <input type="text" name="custom_genre" placeholder="Type genre manually">
            </div>
            <br>

            <!-- Movie description -->
            <label for='description'>Description</label><br>
            <textarea name="description" rows="4" placeholder="Movie description"></textarea> <br><br>

            <!-- Release year selection -->
            <label for="release_year">Release Year</label><br>
            <select name="release_year" id="release_year">
                <option value="">Select Year</option>
                <?php
                // Show years from current year down to 1900
                for ($y = date("Y"); $y >= 1900; $y--) {
                    echo "<option value='$y'>$y</option>";
                }
                ?>
            </select>
            <br><br>

            <!-- Director input -->
            <label for="director">Director:</label><br>
            <input type="text" name="director" placeholder="Enter name"> <br><br>

            <!-- Actors input -->
            <label for="actor">Actors:</label><br>
            <input type="text" name="actor" placeholder="Enter name"> <br><br>

            <!-- Writers input -->
            <label for="">Writers:</label><br>
            <input type="text" name="writer" placeholder="Enter name"> <br><br>

            <!-- Poster upload -->
            <label>Poster Image</label>
            <input type="file" name="poster" accept="image/*" required> <br><br>

            <!-- Submit button -->
            <button type="submit" name='submit'>Add Movie</button>

        </form>
    </div>

</body>

</html>

<?php
include "../includes/footer.php"; // Include footer
?>
