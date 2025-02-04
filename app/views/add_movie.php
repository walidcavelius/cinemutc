<?php
$title = 'Ajouter un film';
ob_start();
?>

<div class="w-full h-full">
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-8">Ajouter un film</h1>
        
        <div class="mb-8">
            <label for="movie_search" class="block text-sm font-medium text-gray-700">Rechercher un film</label>
            <div class="mt-1 relative">
                <input type="text" 
                       id="movie_search" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Tapez le titre du film...">
                <div id="search_results" class="absolute z-10 w-full bg-white shadow-lg rounded-md mt-1 hidden">
                    <!-- Search results will be inserted here -->
                </div>
            </div>
        </div>

        <form method="POST" id="add_movie_form" class="space-y-6 hidden">
            <input type="hidden" name="tmdb_id" id="tmdb_id">
            
            <div id="movie_details" class="bg-gray-50 p-4 rounded-lg hidden">
                <!-- Selected movie details will be shown here -->
            </div>

            <div>
                <label for="semestre" class="block text-sm font-medium text-gray-700">Semestre</label>
                <select name="semestre" id="semestre" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <?php foreach (Film::getAllSemesters(5) as $semester): ?>
                        <option value="<?= htmlspecialchars($semester) ?>"><?= htmlspecialchars($semester) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="date_projection" class="block text-sm font-medium text-gray-700">Date de projection</label>
                <input type="date" name="date_projection" id="date_projection" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <button type="submit" 
                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Ajouter le film
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let searchTimeout;
const searchInput = document.getElementById('movie_search');
const searchResults = document.getElementById('search_results');
const movieForm = document.getElementById('add_movie_form');
const movieDetails = document.getElementById('movie_details');
const tmdbIdInput = document.getElementById('tmdb_id');

searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value.trim();
    
    if (query.length < 2) {
        searchResults.classList.add('hidden');
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch(`/cinemutc/api/search-movies?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(movies => {
                searchResults.innerHTML = movies.map(movie => `
                    <div class="p-2 hover:bg-gray-100 cursor-pointer flex items-center space-x-4" 
                         onclick="selectMovie(${movie.id}, '${movie.title.replace("'", "\\'")}', '${movie.poster_path || ''}')">
                        ${movie.poster_path 
                            ? `<img src="${movie.poster_path}" class="w-12 h-18 object-cover rounded">`
                            : '<div class="w-12 h-18 bg-gray-200 rounded"></div>'
                        }
                        <div>
                            <div class="font-medium">${movie.title}</div>
                            <div class="text-sm text-gray-500">${movie.release_date}</div>
                        </div>
                    </div>
                `).join('');
                searchResults.classList.remove('hidden');
            });
    }, 300);
});

function selectMovie(id, title, posterPath) {
    tmdbIdInput.value = id;
    searchResults.classList.add('hidden');
    movieForm.classList.remove('hidden');
    movieDetails.classList.remove('hidden');
    movieDetails.innerHTML = `
        <div class="flex items-center space-x-4">
            ${posterPath 
                ? `<img src="${posterPath}" class="w-20 h-30 object-cover rounded">`
                : '<div class="w-20 h-30 bg-gray-200 rounded"></div>'
            }
            <div>
                <h3 class="font-medium text-lg">${title}</h3>
                <p class="text-sm text-gray-500">ID TMDB: ${id}</p>
            </div>
        </div>
    `;
}

// Close search results when clicking outside
document.addEventListener('click', function(e) {
    if (!searchResults.contains(e.target) && e.target !== searchInput) {
        searchResults.classList.add('hidden');
    }
});
</script>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';
?> 