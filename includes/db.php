<?php
$configFile = __DIR__ . '/config.php';
if (is_file($configFile)) {
    require_once $configFile;
}

defined('DB_HOST')    || define('DB_HOST', 'localhost');
defined('DB_NAME')    || define('DB_NAME', 'vertex_expedition');
defined('DB_USER')    || define('DB_USER', 'root');
defined('DB_PASS')    || define('DB_PASS', '');
defined('DB_CHARSET') || define('DB_CHARSET', 'utf8mb4');

/**
 * Retourne une instance PDO unique (singleton).
 * @return PDO
 */
function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log('Erreur de connexion BDD : ' . $e->getMessage());
            http_response_code(500);
            die('<div style="padding:2rem;font-family:monospace;color:#ff4444;background:#111;text-align:center;">'
                . '<h2>Connexion à la base de données impossible</h2>'
                . '<p>Le service est momentanément indisponible. Réessayez dans quelques instants.</p>'
                . '</div>');
        }
    }

    return $pdo;
}
