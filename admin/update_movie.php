<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

$id = $_POST['id'];
$title = $_POST['title'];
$genre = $_POST['genre'];
$release_year = $_POST['release_year'];
$description = $_POST['description'];
$rating = 0; 

$get = $mysqli->prepare("SELECT poster FROM movie WHERE id = ?");
$get->bind_param("i", $id);
$get->execute();
$old = $get->get_result()->fetch_assoc();
$old_poster = $old['poster'];


if (!empty($_FILES['poster']['name'])) {

    $file_name = $_FILES['poster']['name'];
    $file_tmp  = $_FILES['poster']['tmp_name'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if (!in_array($ext, $allowed_ext)) {
        die("Only JPG, JPEG, PNG allowed!");
    }

    $new_name = time() . "_" . uniqid() . "." . $ext;
    $upload_path = "../assets/images/uploads/" . $new_name;

    move_uploaded_file($file_tmp, $upload_path);

    if (file_exists("../assets/images/uploads/" . $old_poster)) {
        unlink("../assets/images/uploads/" . $old_poster);
    }

    $poster = $new_name;

} else {
    $poster = $old_poster;
}


$update = $mysqli->prepare("UPDATE movie 
    SET title=?, genre=?, release_year=?, description=?, poster=? 
    WHERE id=?");

$update->bind_param("ssissi", $title, $genre, $release_year, $description, $poster, $id);
$update->execute();

header("Location: dashboard.php");
exit();
?>
<script>

document.getElementById('posterInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('posterPreview');

    if (file) {
        preview.src = URL.createObjectURL(file);
    }
});
</script>
