<?php
$title = 'Infos';
ob_start();
?>

<div class="w-full h-full">
  <div class="max-w-4xl relative m-auto">
    <h1 class="my-4 text-5xl">Présentation</h1>
    <p>
      Ciném'UTC est le club cinéma qui projette un film chaque semaine en amphi ! Tu es fanatique de
      la bobine ou tu veux simplement te détendre après les cours ? Nos séances sont ouvertes à tous
      et notre équipe est là pour animer la projection (présentation, débat, ...). Si tu as loupé le
      thriller phénomène de l'été ou si tu veux revoir un bon vieux classique, on a tout ce qu'il te
      faut.
    </p>
    <h2 class="my-4 text-3xl">Le bureau</h2>
  </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';
?>
