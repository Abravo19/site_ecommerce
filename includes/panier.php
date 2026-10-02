<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/db.php';

const PANIER_QTE_MAX = 99;

/** @return array<int,int> */
function panierGet(): array
{
    return $_SESSION['panier'] ?? [];
}

function panierCount(): int
{
    return array_sum(panierGet());
}

function panierProduit(int $id): ?array
{
    $stmt = getDB()->prepare('SELECT id_produit, nom, quantite_stock FROM produit WHERE id_produit = ?');
    $stmt->execute([$id]);
    $p = $stmt->fetch();
    return $p ?: null;
}

function panierAjouter(int $id, int $qte): void
{
    if ($qte < 1) {
        flashSet('danger', 'Quantité invalide : le minimum est de 1.');
        return;
    }
    $qte = min($qte, PANIER_QTE_MAX);

    $p = panierProduit($id);
    if ($p === null) {
        flashSet('danger', 'Produit introuvable.');
        return;
    }
    $stock = (int)$p['quantite_stock'];
    if ($stock < 1) {
        flashSet('warning', $p['nom'] . ' est en rupture de stock.');
        return;
    }

    $panier  = panierGet();
    $max     = min(PANIER_QTE_MAX, $stock);
    $nouveau = ($panier[$id] ?? 0) + $qte;

    if ($nouveau > $max) {
        $panier[$id] = $max;
        flashSet('warning', 'Quantité limitée au stock disponible (' . $max . ') pour ' . $p['nom'] . '.');
    } else {
        $panier[$id] = $nouveau;
        flashSet('success', $qte . ' × ' . $p['nom'] . ' ajouté' . ($qte > 1 ? 's' : '') . ' au panier.');
    }
    $_SESSION['panier'] = $panier;
}

function panierModifier(int $id, int $delta): void
{
    $panier = panierGet();
    if (!isset($panier[$id])) {
        return;
    }
    $nouveau = $panier[$id] + $delta;

    if ($nouveau <= 0) {
        unset($panier[$id]);
    } else {
        $p = panierProduit($id);
        $max = $p ? min(PANIER_QTE_MAX, (int)$p['quantite_stock']) : 0;
        if ($nouveau > $max) {
            flashSet('warning', 'Stock maximal atteint pour cet article (' . $max . ').');
            $nouveau = $max;
        }
        if ($nouveau <= 0) {
            unset($panier[$id]);
        } else {
            $panier[$id] = $nouveau;
        }
    }
    $_SESSION['panier'] = $panier;
}

function panierRetirer(int $id): void
{
    $panier = panierGet();
    unset($panier[$id]);
    $_SESSION['panier'] = $panier;
}

/**
 * @return array{lignes: array, total: float, nb_articles: int}
 */
function panierLignes(): array
{
    $panier = panierGet();
    if (!$panier) {
        return ['lignes' => [], 'total' => 0.0, 'nb_articles' => 0];
    }

    $ids = array_keys($panier);
    $in  = implode(',', array_fill(0, count($ids), '?'));
    $stmt = getDB()->prepare(
        "SELECT p.id_produit, p.slug, p.nom, p.prix, p.prix_promo, p.image_principale, p.quantite_stock, c.code AS cat
         FROM produit p INNER JOIN categorie c ON c.id_categorie = p.id_categorie
         WHERE p.id_produit IN ($in)"
    );
    $stmt->execute($ids);

    $lignes = [];
    $total  = 0.0;
    $nb     = 0;
    $trouves = [];
    foreach ($stmt->fetchAll() as $r) {
        $id   = (int)$r['id_produit'];
        $trouves[$id] = true;
        $pu   = $r['prix_promo'] !== null ? (float)$r['prix_promo'] : (float)$r['prix'];
        $qte  = $panier[$id];
        $lignes[] = [
            'id'       => $id,
            'slug'     => $r['slug'],
            'nom'      => $r['nom'],
            'image'    => produitImage($r['image_principale'], $r['cat']),
            'pu'       => $pu,
            'qte'      => $qte,
            'sous_total' => $pu * $qte,
            'stock'    => (int)$r['quantite_stock'],
        ];
        $total += $pu * $qte;
        $nb    += $qte;
    }

    // Produit supprimé de la base entre-temps : on le retire du panier.
    foreach ($ids as $id) {
        if (!isset($trouves[$id])) {
            unset($panier[$id]);
        }
    }
    $_SESSION['panier'] = $panier;

    return ['lignes' => $lignes, 'total' => $total, 'nb_articles' => $nb];
}
