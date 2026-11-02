<?php
// Paramètres de connexion à la base de données
$host     = 'localhost';
$dbname   = 'vertex_expedition';
$username = 'root';
$password = '';

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
    error_log('Erreur connexion BDD : ' . $e->getMessage());
    http_response_code(500);
    die('Erreur de connexion à la base de données : ' . ($debug ? $e->getMessage() : 'service indisponible.'));
}

$GLOBALS['pdo'] = $pdo;

function getDB(): PDO
{
    return $GLOBALS['pdo'];
}
