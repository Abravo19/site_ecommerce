<?php
require_once __DIR__ . '/session.php';

function e($valeur): string
{
    return htmlspecialchars((string)$valeur, ENT_QUOTES, 'UTF-8');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrfToken()) . '">';
}

function csrfCheck($jeton): bool
{
    return isset($_SESSION['csrf']) && is_string($jeton) && hash_equals($_SESSION['csrf'], $jeton);
}

function flashSet(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flashRender(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $types = ['success', 'warning', 'danger', 'info'];
    $type = in_array($f['type'], $types, true) ? $f['type'] : 'info';
    echo '<div class="container-fluid px-lg-5 mt-3"><div class="alert alert-' . $type
        . ' alert-dismissible fade show tech-mono small mb-0" role="alert">'
        . e($f['message'])
        . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button></div></div>';
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function retourSecurise($url, string $defaut = 'panier.php'): string
{
    if (is_string($url) && preg_match('/^(index|produits|produit|panier)\.php(\?[A-Za-z0-9=&_.%\-]*)?$/', $url)) {
        return $url;
    }
    return $defaut;
}

function produitImage(?string $chemin, string $categorie): string
{
    if ($chemin !== null && $chemin !== '' && is_file(__DIR__ . '/../' . $chemin)) {
        return $chemin;
    }
    $cat = preg_match('/^[a-z]+$/', $categorie) ? $categorie : 'expedition';
    return 'assets/images/produits/placeholder-' . $cat . '.svg';
}

function formAjoutPanier(array $item, string $retour, string $classe = ''): string
{
    $id  = (int)$item['id'];
    $max = max(1, min(99, (int)($item['stock'] ?? 99)));

    if (empty($item['in_stock'])) {
        return '<button type="button" class="btn btn-outline-secondary btn-sm-tech" disabled>'
             . '<i class="bi bi-x-circle me-1"></i> Rupture de stock</button>';
    }

    return '<form method="post" action="panier.php" class="d-flex align-items-center gap-2 ' . e($classe) . '">'
         . csrfField()
         . '<input type="hidden" name="action" value="ajouter">'
         . '<input type="hidden" name="id" value="' . $id . '">'
         . '<input type="hidden" name="retour" value="' . e($retour) . '">'
         . '<label class="visually-hidden" for="qte-' . $id . '">Quantité</label>'
         . '<input type="number" id="qte-' . $id . '" name="quantite" value="1" min="1" max="' . $max . '" required'
         . ' class="form-control form-control-sm bg-dark text-white border-secondary tech-mono" style="width:70px">'
         . '<button type="submit" class="btn btn-vertex-primary btn-sm-tech">'
         . '<i class="bi bi-cart-plus me-1"></i> Ajouter</button>'
         . '</form>';
}
