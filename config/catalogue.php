<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$pdo = getDB();

// Récupération des produits avec leur catégorie
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

// Caractéristiques techniques de chaque produit
$allSpecs = [];
foreach ($pdo->query("SELECT id_produit, libelle_cle, valeur FROM caracteristique_produit ORDER BY id_caracteristique")->fetchAll() as $s) {
    $allSpecs[$s['id_produit']][$s['libelle_cle']] = $s['valeur'];
}

// Couleurs disponibles par produit
$allColors = [];
foreach ($pdo->query("
    SELECT pc.id_produit, co.nom_couleur
    FROM produit_couleur pc INNER JOIN couleur co ON co.id_couleur = pc.id_couleur
    ORDER BY pc.id_produit, co.id_couleur
")->fetchAll() as $c) {
    $allColors[$c['id_produit']][] = $c['nom_couleur'];
}

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

// Préparation du tableau des produits pour les pages du site
$produits   = [];
$categories = [];
$position   = 0;

foreach ($rows as $row) {
    $id     = (int)$row['id_produit'];
    $specs  = $allSpecs[$id] ?? [];
    $estRefuge = ($row['cat_code'] === 'refuge');

    $volume = $row['volume_litres'] !== null
        ? $row['volume_litres'] . ' L'
        : ($specs['Capacité'] ?? ($specs['Température confort'] ?? '—'));

    $prixNormal = (float)$row['prix'];
    $prixPromo  = $row['prix_promo'] !== null ? (float)$row['prix_promo'] : null;
    $enPromo    = ($prixPromo !== null && $prixPromo > 0 && $prixPromo != $prixNormal);
    $prixActif  = $enPromo ? min($prixNormal, $prixPromo) : $prixNormal;
    $ancienPrix = $enPromo ? max($prixNormal, $prixPromo) : null;

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
        'price'          => $prixActif,
        'old_price'      => $ancienPrix,
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
        'featured'       => ($position < 3),
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
