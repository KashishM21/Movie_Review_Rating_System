document.addEventListener("DOMContentLoaded", function () {
    const starsContainers = document.querySelectorAll(".rate-section #star-rating");

    starsContainers.forEach(container => {
        const stars = container.querySelectorAll(".star");
        const ratingInput = container.parentElement.querySelector("#rating-value");

        highlightStars(ratingInput.value);

        stars.forEach(star => {
            star.addEventListener("mouseover", function () {
                highlightStars(this.dataset.value);
            });

            star.addEventListener("mouseout", function () {
                highlightStars(ratingInput.value);
            });

            star.addEventListener("click", function () {
                ratingInput.value = this.dataset.value;
                highlightStars(ratingInput.value);
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                star.style.color = (parseInt(star.dataset.value) <= parseInt(rating)) ? "#FFD700" : "#ccc";
            });
        }
    });
});
