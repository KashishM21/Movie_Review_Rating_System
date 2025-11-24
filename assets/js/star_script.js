document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll("#star-rating .star");
    const ratingInput = document.getElementById("rating-value");

    stars.forEach(star => {
        star.addEventListener("mouseover", function() {
            highlightStars(this.dataset.value);
        });
        star.addEventListener("mouseout", function() {
            highlightStars(ratingInput.value);
        });
        star.addEventListener("click", function() {
            ratingInput.value = this.dataset.value;
            highlightStars(ratingInput.value);
        });
    });

    function highlightStars(rating) {
        stars.forEach(star => {
            if (star.dataset.value <= rating) {
                star.style.color = "#FFD700"; 
            } else {
                star.style.color = "#ccc";
            }
        });
    }
});
