// script for carosal

// document.querySelectorAll('.carousel').forEach(carousel => {
//     const rowWrapper = carousel.querySelector('.movie-row-wrapper');
//     const row = carousel.querySelector('.movie-row');
//     const prev = carousel.querySelector('.prev');
//     const next = carousel.querySelector('.next');

//     let scrollAmount = 0;
//     const scrollPerClick = 200; 

//     prev.addEventListener('click', () => {
//         rowWrapper.scrollBy({ left: -scrollPerClick, behavior: 'smooth' });
//     });

//     next.addEventListener('click', () => {
//         rowWrapper.scrollBy({ left: scrollPerClick, behavior: 'smooth' });
//     });
// });



// movie list script
function toggleCustomGenre() {
    let genre = document.getElementById("genre").value;
    let box = document.getElementById("customGenreBox");

    if (genre === "other") {
        box.style.display = "block";
    } else {
        box.style.display = "none";
    }
}