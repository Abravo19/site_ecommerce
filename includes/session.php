<?php
/**
 * Initialisation de la session PHP.
 *
 * Démarre la session si elle n'est pas déjà active afin de permettre
 * le fonctionnement du panier, des messages flash et des jetons CSRF.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
