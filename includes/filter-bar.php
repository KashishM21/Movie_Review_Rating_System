<div class="top-filter-bar">
    <div class="left-filters">
        <span class="label">BROWSE BY</span>

        <select name="year" onchange="applyFilter()">
            <option value="">Year</option>
            <option value="2025">2025</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
        </select>

        <select name="rating" onchange="applyFilter()">
            <option value="">Rating</option>
            <option value="5">5+</option>
            <option value="4">4+</option>
            <option value="3">3+</option>
        </select>

        <select name="popularity" onchange="applyFilter()">
            <option value="">Popular</option>
            <option value="50">50+</option>
            <option value="70">70+</option>
        </select>

        <select name="genre" onchange="applyFilter()">
            <option value="">Genre</option>
            <option value="1">Action</option>
            <option value="2">Drama</option>
            <option value="3">Comedy</option>
            <option value="4">Horror</option>
        </select>

    </div>

    <div class="right-search">
        <span class="label">FIND A FILM</span>
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="applySearch()">
    </div>
</div>

<script>
function applyFilter() {
    const params = new URLSearchParams(window.location.search);

    document.querySelectorAll('.left-filters select').forEach(sel => {
        if (sel.value) params.set(sel.name, sel.value);
        else params.delete(sel.name);
    });

    window.location.search = params.toString();
}

function applySearch() {
    const params = new URLSearchParams(window.location.search);
    const search = document.getElementById("searchInput").value;

    if (search) params.set("search", search);
    else params.delete("search");

    window.location.search = params.toString();
}
</script>
Report: 21/11/2025
~Kashish
Creates the filter_bar page.
Created the add_movie page.
Connected the add_movie page with the database.
Displayed all movies on the index page.
Updated the header with clickable links for better navigation.
Updated the footer with clickable links for better navigation.
Developed the movie_description page to show details such as title, genre, release year, review, and rating.