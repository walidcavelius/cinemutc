<?php
// Make sure we have access to the database connection
require_once BASE_PATH . '/app/config/database.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : "CINÉM'UTC" ?></title>
  <link href="/cinemutc/css/tailwind.css" rel="stylesheet">
  <script src="https://unpkg.com/htmx.org@1.9.6"></script>
  <script src="https://unpkg.com/htmx.org/dist/ext/head-support.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 h-screen flex flex-col">
  <?php require __DIR__ . '/components/navbar.php'; ?>
  <?= $content ?>
</body>

</html>
