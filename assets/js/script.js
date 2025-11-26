
function toggleCustomGenre() {
    let genre = document.getElementById("genre").value;
    let box = document.getElementById("customGenreBox");

    if (genre === "other") {
        box.style.display = "block";
    } else {
        box.style.display = "none";
    }
}