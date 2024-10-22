<?php
$title = $film['titre'];
ob_start();
?>

<div class="w-full h-full">
    <div class="max-w-5xl relative m-auto h-full">
            <div class="-z-50 relative m-auto bg-center bg-cover h-96"
                style="background-image:url(https://image.tmdb.org/t/p/<?php echo $film['backdrop_path']; ?>); 
                       box-shadow: inset 5px 5px 100px 70px rgb(243 244 246), inset -5px -5px 100px 70px rgb(243 244 246);">
            </div>
            <div class="mt-[-5%] flex justify-start gap-3">
                <a href="" class="text-center flex w-1/4">
                    <img class="border-2 rounded-md border-gray-400 hover:border-gray-700"
                         src="https://image.tmdb.org/t/p/w500<?php echo $film['poster_path']; ?>"
                         alt="<?php echo $film['titre']; ?>" />
                </a>
                <div class="ml-10 mt-4 flex flex-col w-3/4">
                    <h1 class="text-3xl"><?php echo $film['titre']; ?></h1>
                    <p class="text-md my-4"><?php echo $film['overview']; ?></p>
                </div>
                <div class=""></div>
            </div>
    </div>
</div>


<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';
?>