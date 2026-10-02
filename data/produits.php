<?php
/**
 * VERTEX EXPEDITION — Chargement des produits depuis la base de données.
 *
 * Fournit :
 *   $produits   : tableau [id => produit] (même format qu'avant, utilisé par index.php, produits.php, produit.php)
 *   $categories : tableau [code => ['label' => ..., 'nb' => ...]] pour les filtres du catalogue
 *
 * Aucune donnée utilisateur n'entre dans ces requêtes (elles sont donc sans risque d'injection SQL).
 */

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

$pdo = getDB();

// ── Produits + catégorie ───────────────────────────────────────────
$rows = $pdo->query("
    SELECT p.id_produit, p.reference, p.slug, p.nom, p.tag, p.badge, p.prix, p.prix_promo,
           p.volume_litres, p.poids_grammes, p.materiau, p.etancheite, p.usage_temperature,
           p.image_principale, p.description_courte, p.description_longue,
           p.note_moyenne, p.nombre_avis, p.quantite_stock,
           c.code AS cat_code, c.libelle AS cat_libelle
    FROM produit p
    INNER JOIN categorie c ON c.id_categorie = p.id_categorie
    ORDER BY p.id_produit ASC
")->fetchAll();

// ── Caractéristiques techniques ────────────────────────────────────
$allSpecs = [];
foreach ($pdo->query("SELECT id_produit, libelle_cle, valeur FROM caracteristique_produit ORDER BY id_caracteristique")->fetchAll() as $s) {
    $allSpecs[$s['id_produit']][$s['libelle_cle']] = $s['valeur'];
}

// ── Couleurs ───────────────────────────────────────────────────────
$allColors = [];
foreach ($pdo->query("
    SELECT pc.id_produit, co.nom_couleur
    FROM produit_couleur pc INNER JOIN couleur co ON co.id_couleur = pc.id_couleur
    ORDER BY pc.id_produit, co.id_couleur
")->fetchAll() as $c) {
    $allColors[$c['id_produit']][] = $c['nom_couleur'];
}

// ── Aides d'affichage ──────────────────────────────────────────────
function getBadgeClass(string $badge): string
{
    $b = mb_strtolower($badge, 'UTF-8');
    if (strpos($b, 'ip6') !== false || strpos($b, 'submersible') !== false || strpos($b, 'étanche') !== false) {
        return 'badge-cyan';
    }
    if (strpos($b, 'ultra') !== false || strpos($b, 'saison') !== false || strpos($b, 'light') !== false) {
        return 'badge-emerald';
    }
    return 'badge-amber';
}

function formatWeight(int $grams): string
{
    return $grams >= 1000 ? number_format($grams / 1000, 2, '.', '') . ' kg' : $grams . ' g';
}

// ── Construction du tableau $produits ──────────────────────────────
$produits   = [];
$categories = [];
$position   = 0;

foreach ($rows as $row) {
    $id     = (int)$row['id_produit'];
    $specs  = $allSpecs[$id] ?? [];
    $estRefuge = ($row['cat_code'] === 'refuge');

    // Volume : litres si renseignés, sinon la capacité indiquée dans les caractéristiques (abris, couchage)
    $volume = $row['volume_litres'] !== null
        ? $row['volume_litres'] . ' L'
        : ($specs['Capacité'] ?? ($specs['Température confort'] ?? '—'));

    $prixNormal = (float)$row['prix'];
    $enPromo    = $row['prix_promo'] !== null;

    $produits[$id] = [
        'id'             => $id,
        'ref'            => 'RÉF: ' . $row['reference'],
        'slug'           => $row['slug'],
        'name'           => $row['nom'],
        'category'       => $row['cat_code'],
        'category_label' => $row['cat_libelle'],
        'tag'            => $row['tag'] ?? '',
        'badge'          => $row['badge'] ?? '',
        'badge_class'    => getBadgeClass($row['badge'] ?? ''),
        'price'          => $enPromo ? (float)$row['prix_promo'] : $prixNormal,
        'old_price'      => $enPromo ? $prixNormal : null,
        'volume'         => $volume,
        'volume_label'   => $row['volume_litres'] !== null ? 'LITRAGE' : ($estRefuge ? 'CAPACITÉ' : 'VOLUME'),
        'volume_num'     => (int)$row['volume_litres'],
        'weight'         => formatWeight((int)$row['poids_grammes']),
        'weight_num'     => (int)$row['poids_grammes'],
        'material'       => $row['materiau'] ?? '',
        'waterproof'     => $row['etancheite'] ?? '',
        'temp_rating'    => $row['usage_temperature'] ?? '',
        'image'          => produitImage($row['image_principale'], $row['cat_code']),
        'short_desc'     => $row['description_courte'] ?? '',
        'full_desc'      => $row['description_longue'] ?? '',
        'specs'          => $specs,
        'colors'         => $allColors[$id] ?? [],
        'featured'       => ($position < 3),   // les 3 premiers produits du catalogue sont mis en avant
        'rating'         => (float)$row['note_moyenne'],
        'reviews_count'  => (int)$row['nombre_avis'],
        'stock'          => (int)$row['quantite_stock'],
        'in_stock'       => ((int)$row['quantite_stock'] > 0),
    ];
    $position++;

    if (!isset($categories[$row['cat_code']])) {
        $categories[$row['cat_code']] = ['label' => $row['cat_libelle'], 'nb' => 0];
    }
    $categories[$row['cat_code']]['nb']++;
}
