<?php

namespace App\Controllers;

use PDO;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class LoginController
{
  private $pdo;
  private $provider;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
    $this->provider = new \League\OAuth2\Client\Provider\GenericProvider([
      "clientId"                => "9d878a5d-7cfe-40a1-95d4-00bcbad46e87",    // Le client ID de l'app
      "clientSecret"            => "3f17507cbd310f15a0b96ae7b4c60d4e06bda1b3c531da77ce7d3926746f129b",    // Le client secret de l'app
      "redirectUri"             => "https://assos.utc.fr/cinemutc/auth/callback",
      "urlAuthorize"            => "https://auth.assos.utc.fr/oauth/authorize",
      "urlAccessToken"          => "https://auth.assos.utc.fr/oauth/token",
      "urlResourceOwnerDetails" => "https://auth.assos.utc.fr/api/user",
      "scopes"                  => "users-infos"
    ]);
  }

  public function showLoginForm()
  {
    require BASE_PATH . '/app/views/login.php';
  }

  public function login()
  {
    session_start();

    // Generate a random state parameter
    $state = bin2hex(random_bytes(16));
    $_SESSION['oauth2state'] = $state;

    // Redirect the user to the OAuth2 authorization URL
    $authorizationUrl = $this->provider->getAuthorizationUrl([
      'state' => $state
    ]);

    header('Location: ' . $authorizationUrl);
    exit;
  }

  public function callback()
  {
    echo "<script>console.log('Callback function triggered');</script>";

    session_start();

    // Retrieve and remove the state parameter from the session
    $storedState = isset($_SESSION['oauth2state']) ? $_SESSION['oauth2state'] : null;
    unset($_SESSION['oauth2state']);

    // Check if the state parameter is present and valid
    if (empty($_GET['state']) || $_GET['state'] !== $storedState) {
      header('Location: /cinemutc/login?error=invalid_state');
      exit;
    }

    // Check if the authorization code is present
    if (empty($_GET['code'])) {
      header('Location: /cinemutc/login?error=no_code');
      exit;
    }

    try {
      // Exchange the authorization code for an access token
      $accessToken = $this->provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
      ]);

      // Retrieve the user's details from API
      $resourceOwner = $this->provider->getResourceOwner($accessToken);
      $userDetails = $resourceOwner->toArray();

      // Log user details for debugging
      error_log('OAuth User Details: ' . print_r($userDetails, true));

      // Make sure we have at least an email
      if (empty($userDetails['email'])) {
        error_log('No email provided in OAuth response');
        header('Location: /cinemutc//login?error=missing_email');
        exit;
      }

      // Check if user account has been deleted
      if (!empty($userDetails['deleted_at'])) {
        header('Location: /cinemutc//login?error=account_deleted');
        exit;
      }

      // Check if user account provide from cas
      if ($userDetails['provider'] !== 'cas') {
        header('Location: /cinemutc//login?error=invalid_provider');
        exit;
      }

      // Find user by email or create new one
      $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
      $stmt->execute([$userDetails['email']]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user) {
        // Create new user if they don't exist
        $stmt = $this->pdo->prepare('INSERT INTO users 
                    (email, name, role) 
                    VALUES (?, ?, ?)');
        $stmt->execute([
          isset($userDetails['name']) ? $userDetails['name'] : $userDetails['email'],
          'user'  // Default role
        ]);

        // Fetch the newly created user
        $userId = $this->pdo->lastInsertId();
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
      }

      if (!$user) {
        error_log('Failed to create or retrieve user');
        header('Location: /cinemutc/login?error=user_creation_failed');
        exit;
      }

      // Set session for logged-in user
      $_SESSION['user_id'] = $user['id'];

      // Redirect to home page
      header('Location: /cinemutc');
      exit;
    } catch (IdentityProviderException $e) {
      error_log('OAuth error: ' . $e->getMessage());
      header('Location: /cinemutc/login?error=authentication_failed');
      exit;
    }
  }

  public function logout()
  {
    session_start();
    session_destroy();
    header('Location: /cinemutc');
    exit;
  }
}
