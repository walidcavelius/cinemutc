<?php
require_once BASE_PATH . '/app/services/TMDBService.php';

$tmdbService = new TMDBService();
$tmdbId = htmlspecialchars($film['tmdb_id']);

$movieDetails = $tmdbService->getMovieDetails($tmdbId);

if (isset($movieDetails['poster_path'])):
?>

<a href="/cinemutc/film/<?= htmlspecialchars($movieDetails['id']) ?>" class="w-44 text-center mx-2">
    <div class="aspect-[2/3] relative"> <!-- Added fixed aspect ratio container -->
        <img 
            class="border-2 rounded-xl border-gray-400 hover:border-gray-700 absolute inset-0 w-full h-full object-cover" 
            src="<?= $tmdbService->getImageUrl($movieDetails['poster_path'], "w500") ?>" 
            alt="<?= htmlspecialchars($movieDetails['title']) ?>" 
        />
    </div>
</a>

<?php else: ?>
    <div class="w-44 aspect-[2/3] bg-white rounded-lg shadow-md overflow-hidden flex items-center justify-center">
        <p>Movie details not available</p>
    </div>
<?php endif; ?>
