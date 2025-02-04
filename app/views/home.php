<?php
$title = 'Accueil - Film Club';
ob_start();
?>
<a href="/cinemutc/film/<?= $viewData['id'] ?>"
    class="block bg-center bg-cover shadow-[inset_1000px_1000px_rgba(0,0,0,0.3)] h-screen relative"
    style="background-image: url(<?= htmlspecialchars($viewData['backdropUrl']) ?>)">
    <h1 class="text-white m-10 text-5xl absolute top-0 left-0"><?= htmlspecialchars($viewData['title']) ?></h1>
    <p class="text-white m-10 bottom-0 left-0 absolute">
        Réalisé par <?= htmlspecialchars($viewData['directors']) ?><br />
        <?= htmlspecialchars($viewData['releaseYear']) ?><br /><br />
        Mercredi 20 septembre<br />
        FA205
    </p>
</a>
<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';
?>
