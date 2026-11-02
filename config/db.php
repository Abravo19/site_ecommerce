<?php
$host     = 'localhost';
$dbname   = 'vertex_expedition';
$username = 'root';
$password = '';

// Mettre à true uniquement pour diagnostiquer un problème de connexion.
$debug = false;

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
} catch (Exception $e) {
    error_log('Erreur de connexion SQL : ' . $e->getMessage());
    http_response_code(500);
    die('Erreur de connexion SQL : ' . ($debug ? $e->getMessage() : 'service momentanément indisponible.'));
}

// Rend $pdo accessible même si ce fichier est inclus depuis une fonction.
$GLOBALS['pdo'] = $pdo;

/**
 * Retourne la connexion PDO créée ci-dessus.
 */
function getDB(): PDO
{
    return $GLOBALS['pdo'];
}
