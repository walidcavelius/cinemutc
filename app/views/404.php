<?php
$title = '404 - Page Not Found';
ob_start();
?>

<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <h1 class="text-9xl font-extrabold text-blue-600">404</h1>
        <h2 class="mt-6 text-3xl font-bold text-gray-900">
            Page Not Found
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Oops! The page you're looking for doesn't exist.
        </p>
        <div class="mt-5">
            <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Go back home
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>