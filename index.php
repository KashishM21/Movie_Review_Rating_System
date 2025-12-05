<?php
error_reporting(E_ALL);
ini_set("dislay_errors", 1);
include "../projcet/includes/session.php";
include "includes/db.php";
    include "../project/includes/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RateMyMovie</title>
    <link rel="stylesheet" href="../project/assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/ratemymovie.png" type="image/x-icon">
</head>
<body class="body-box">
    <?php
    include "../project/movie_link/movie_poster.php";
    ?>
</body>
</html>
<?php
include "includes/footer.php";

