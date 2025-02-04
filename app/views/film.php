<?php
ob_start();
require_once BASE_PATH . '/app/models/Rating.php';
$ratingModel = new Rating();
$averageRating = $ratingModel->getAverageRating($film['tmdb_id']);
if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user_id'])) {
    $userHasRated = $ratingModel->userHasRated($_SESSION['user_id'], $film['id']);
} else {
    $userHasRated = false; // Default value if no session is active
}

?>
<div class="w-full h-full">
  <div class="max-w-6xl relative m-auto h-full">
    <div class="-z-50 relative m-auto bg-top bg-cover h-96"
      style="background-image:url(https://image.tmdb.org/t/p/<?php echo $film['backdrop_path']; ?>); 
                       box-shadow: inset 5px 5px 100px 70px rgb(243 244 246), inset -5px -5px 100px 70px rgb(243 244 246);">
    </div>
    <div class="mt-[-5%] flex justify-start gap-3">
      <a href="" class="text-center flex w-1/6 aspect-[2/3]">
        <img class="border-2 rounded-md border-gray-400 hover:border-gray-700"
          src="https://image.tmdb.org/t/p/w500<?php echo $film['poster_path']; ?>"
          alt="<?php echo $film['title']; ?>" />
      </a>
      <div class="ml-10 mt-4 flex flex-col w-4/6">
        <div class="flex items-end space-x-4">
          <h1 class="text-2xl"><?php echo $film['title']; ?></h1>
          <h2 class="text-base"><?php echo $film['release_date']; ?></h2>
          <h2 class="text-base">Réalisé par <?php echo $film['directors']; ?></h2>
        </div>
        <p class="text-sm my-4"><?php echo $film['overview']; ?></p>
        <div id="reviewResult"></div>
      </div>
      <div class="ml-10 mt-4 flex flex-col w-1/6 items-center">
        <h3 class="text-base">Moyenne: <?php echo $averageRating; ?></h3>
        <div x-data="{ isOpen: false }" class="relative">
          <!-- Button to open the modal -->
          <button @click="isOpen = true" class="bg-gray-900 text-white px-4 py-2 rounded">
            Review
          </button>

          <!-- Modal Background and Window -->
          <div x-show="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
            style="display: none;">
            <!-- Modal Content (Click outside this box to close the modal) -->
            <div @click.away="isOpen = false" class="bg-white w-96 p-6 rounded shadow-lg">
              <!-- Modal Content -->
              <h2 class="text-lg font-bold mb-4">Écrire une review</h2>
              <form action="/cinemutc/rate_movie" method="POST" hx-post="/cinemutc/rate_movie">
                <input type="hidden" name="movie_id" value="<?php echo $film['tmdb_id']; ?>">
                <label for="rating">Donner une note:</label>
                <select name="rating" id="rating" required class="border border-gray-300 rounded mb-4 w-full">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                <label for="review">Commentaire:</label>
                <textarea name="review" id="review" rows="4"
                  class="border border-gray-300 rounded mb-4 w-full"></textarea>
                <button type="submit" @click="isOpen = false"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit
                  Review</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-col space-y-4 my-4">
      <?php
      require_once BASE_PATH . '/app/models/Rating.php';
      $ratingModel = new Rating();
      $ratings = $ratingModel->getReviews($film['tmdb_id']);
      foreach ($ratings as $rating) {
        require BASE_PATH . '/app/views/components/review.php';
      }
      ?>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';

?>
