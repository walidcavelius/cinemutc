<?php
$title = 'Connexion';
ob_start();

// Handle error messages
$error = isset($_GET['error']) ? $_GET['error'] : null;
$errorMessage = '';

switch ($error) {
  case 'invalid_state':
    $errorMessage = 'État de connexion invalide. Veuillez réessayer.';
    break;
  case 'no_code':
    $errorMessage = 'Code d\'autorisation manquant. Veuillez réessayer.';
    break;
  case 'account_deleted':
    $errorMessage = 'Ce compte a été supprimé.';
    break;
  case 'invalid_provider':
    $errorMessage = 'Fournisseur d\'authentification non valide.';
    break;
  case 'authentication_failed':
    $errorMessage = 'L\'authentification a échoué. Veuillez réessayer.';
    break;
  case 'missing_email':
    $errorMessage = 'Adresse e-mail non fournie. Veuillez réessayer.';
    break;
  case 'user_creation_failed':
    $errorMessage = 'Échec de la création du compte. Veuillez réessayer ou contacter le support.';
    break;
}
?>

<div class="w-full h-full flex justify-center items-center">
  <div class="max-w-md w-full">
    <h1 class="my-4 text-3xl text-center">Connexion</h1>

    <?php if ($errorMessage): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?php echo htmlspecialchars($errorMessage); ?></span>
      </div>
    <?php endif; ?>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <div class="flex flex-col items-center justify-center space-y-4">
        <p class="text-gray-600 text-center mb-4">
          Connectez-vous avec votre compte UTC
        </p>

        <a href="/cinemutc/auth/login"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline w-full text-center">
          Se connecter avec UTC
        </a>

        <p class="text-sm text-gray-500 mt-4 text-center">
          Vous devez avoir un compte UTC valide pour accéder à ce service.
        </p>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layout.php';
