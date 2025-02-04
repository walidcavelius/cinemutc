<?php
require_once BASE_PATH . '/app/helpers/auth_helper.php';
?>
<nav class="top-0 border-b-2 border-gray-200 flex justify-between p-5 px-8 items-center">
  <a href="/cinemutc/"><img src="../../../cinemutc/assets/logo.png" width="200" /></a>
  <ul class="flex flex-row justify-between">
    <li><a href="/cinemutc/programmation" class="mr-6">Programmation</a></li>
    <li><a href="/cinemutc/archive" class="mr-6">Archive</a></li>
    <li><a href="/cinemutc/infos" class="mr-6">À propos</a></li>
    <?php if (isset($_SESSION['user_id'])): ?>
      <?php if (isAdmin()): ?>
        <li><a href="/cinemutc/add-movie" class="mr-6">Ajouter un film</a></li>
      <?php endif; ?>
      <li><a href="/cinemutc/logout" class="mr-6">Déconnexion</a></li>
    <?php else: ?>
      <li><a href="/cinemutc/login" class="mr-6">Connexion</a></li>
    <?php endif; ?>
  </ul>
</nav>
