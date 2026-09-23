<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'vertex_expedition');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

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
            // En production, ne pas afficher le message d'erreur brut
            error_log('Erreur de connexion BDD : ' . $e->getMessage());
            die('<div style="padding:2rem;font-family:monospace;color:#ff4444;background:#111;text-align:center;">'
                . '<h2>⚠ Connexion à la base de données impossible</h2>'
                . '<p>Vérifiez que MySQL (WAMP) est démarré et que la base <code>vertex_expedition</code> existe.</p>'
                . '</div>');
        }
    }

    return $pdo;
}
