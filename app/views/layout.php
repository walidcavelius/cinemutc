<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "CINÉM'UTC" ?></title>
    <link href="/cinemutc/public/css/tailwind.css" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.9.6"></script>
    <script src="https://unpkg.com/htmx.org/dist/ext/head-support.js"></script>
</head>
<body class="bg-gray-100 flex flex-col h-screen">
    <?php require __DIR__ . '/components/navbar.php'; ?>
    <?= $content ?>
</body>
</html>