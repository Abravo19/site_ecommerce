<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vérifie si un utilisateur est connecté.
 * @return bool
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Retourne les informations de l'utilisateur connecté.
 * @return array|null  Tableau associatif avec les infos ou null si non connecté.
 */
function getCurrentUser(): ?array
{
    if (!isLoggedIn()) {
        return null;
    }

    return [
        'id'     => $_SESSION['user_id'],
        'nom'    => $_SESSION['user_nom'] ?? '',
        'prenom' => $_SESSION['user_prenom'] ?? '',
        'pseudo' => $_SESSION['user_pseudo'] ?? '',
        'email'  => $_SESSION['user_email'] ?? '',
        'role'   => $_SESSION['user_role'] ?? 'client',
    ];
}

/**
 * Redirige vers la page de connexion si l'utilisateur n'est pas connecté.
 * @param string $redirect_url  URL de retour après connexion.
 */
function requireLogin(string $redirect_url = ''): void
{
    if (!isLoggedIn()) {
        $url = 'connexion.php';
        if ($redirect_url !== '') {
            $url .= '?redirect=' . urlencode($redirect_url);
        }
        header('Location: ' . $url);
        exit;
    }
}

/**
 * Connecte un utilisateur en stockant ses données en session.
 * @param array $user  Données de l'utilisateur depuis la BDD.
 */
function loginUser(array $user): void
{
    $_SESSION['user_id']     = $user['id_client'];
    $_SESSION['user_nom']    = $user['nom'];
    $_SESSION['user_prenom'] = $user['prenom'];
    $_SESSION['user_pseudo'] = $user['pseudo'] ?? '';
    $_SESSION['user_email']  = $user['email'];
    $_SESSION['user_role']   = $user['role'] ?? 'client';

    // Regénérer l'ID de session pour prévenir le fixation de session
    session_regenerate_id(true);
}

/**
 * Déconnecte l'utilisateur et détruit la session.
 */
function logoutUser(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}
