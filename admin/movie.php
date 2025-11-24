<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
        <link rel="stylesheet" href="../assets/css/movie_form.css">

</head>

<body>
<?php if (!empty($message)): ?>
    <p style="color:red; font-weight:bold;"><?= $message ?></p>
<?php endif; ?>

    <div class="container">
        <h2>Add Movie</h2>

        <form method="post" action="add_movie.php" enctype="multipart/form-data">

            <label for='title'>Movie Title</label><br>
            <input type="text" name="title" placeholder="Enter movie title"> <br><br>

            <label for="genre">Select Genre:</label>
            <select id="genre" name="genre">
                <option value="">Select a Genre</option>
                <option value="action">Action</option>
                <option value="adventure">Adventure</option>
                <option value="comdey">Comedy</option>
            </select> <br><br>

            <label for='description'>Description</label><br>
            <textarea name="description" rows="4" placeholder="Movie description"></textarea> <br><br>

<label for="release_year">Release Year</label><br>
<input type="number" name="release_year" min="1900" max="2099" placeholder="2025">
<br><br>

            <label>Poster Image</label>
            <input type="file" name="poster" accept="image/*" required> <br><br>

            <button type="submit" name='submit'>Add Movie</button>

        </form>
    </div>

</body>

</html>