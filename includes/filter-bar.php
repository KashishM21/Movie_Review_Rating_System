<style>
.top-filter-bar {
    display: flex;
    flex-wrap: wrap;           
    align-items: center;      
    gap: 10px;           
    margin-bottom: 20px; 
}

.top-filter-bar .left-filters select,
.top-filter-bar .left-filters input[type="number"],
.top-filter-bar .right-search input {
    padding: 5px 10px;  
    border-radius: 5px;   
    border: 1px solid #ccc; 
    font-size: 14px;           
    outline: none;        
    transition: border 0.3s;  
}

.top-filter-bar .left-filters select:focus,
.top-filter-bar .left-filters input[type="number"]:focus,
.top-filter-bar .right-search input:focus {
    border-color: #ffa600ff;     
}
</style>

<div class="top-filter-bar">
    <div class="left-filters">
        <span class="label">BROWSE BY</span>

        <!-- Year as calendar picker -->
        <input type="number" name="year" placeholder="Year" min="1900" max="2100" onchange="applyFilter()">

        <!-- Rating dropdown -->
        <select name="rating" onchange="applyFilter()">
            <option value="">Rating</option>
            <option value="5">5+</option>
            <option value="4">4+</option>
            <option value="3">3+</option>
        </select>

        <!-- Popularity dropdown -->
        <select name="popularity" onchange="applyFilter()">
            <option value="">Popular</option>
            <option value="50">50+</option>
            <option value="70">70+</option>
        </select>

        <!-- Genre dropdown -->
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
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="applySearch()" oninput="limitWord(this)">
    </div>
</div>

<script>
function applyFilter() {
    const params = new URLSearchParams(window.location.search);

    document.querySelectorAll('.left-filters select, .left-filters input[type="number"]').forEach(el => {
        if (el.value) params.set(el.name, el.value); // add/update filter
        else params.delete(el.name);               // remove filter if empty
    });

    window.location.search = params.toString(); // reload page with filters in URL
}

function applySearch() {
    const params = new URLSearchParams(window.location.search);
    const search = document.getElementById("searchInput").value;

    if (search) params.set("search", search); 
    else params.delete("search");

    window.location.search = params.toString(); // reload page with search in URL
}

</script>
