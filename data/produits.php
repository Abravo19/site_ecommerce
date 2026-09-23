<?php
/**
 * VERTEX EXPEDITION — Chargement des Produits depuis la BDD
 * 
 * Remplace l'ancien tableau statique par des requêtes SQL.
 * Le format de sortie ($produits) reste identique pour garantir
 * la compatibilité avec index.php et produits.php.
 */

require_once __DIR__ . '/../includes/db.php';

$pdo = getDB();

// ── Requête principale : produits + catégorie ──────────────────────
$sql = "
    SELECT
        p.id_produit,
        p.reference,
        p.slug,
        p.nom,
        p.tag,
        p.badge,
        p.prix,
        p.prix_promo,
        p.volume_litres,
        p.poids_grammes,
        p.materiau,
        p.etancheite,
        p.usage_temperature,
        p.image_principale,
        p.description_courte,
        p.description_longue,
        p.note_moyenne,
        p.nombre_avis,
        p.quantite_stock,
        c.code       AS cat_code,
        c.libelle    AS cat_libelle
    FROM produit p
    INNER JOIN categorie c ON c.id_categorie = p.id_categorie
    ORDER BY p.id_produit ASC
";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

// ── Caractéristiques par produit ───────────────────────────────────
$stmtSpecs = $pdo->query("
    SELECT id_produit, libelle_cle, valeur
    FROM caracteristique_produit
    ORDER BY id_caracteristique ASC
");
$allSpecs = [];
foreach ($stmtSpecs->fetchAll() as $spec) {
    $allSpecs[$spec['id_produit']][$spec['libelle_cle']] = $spec['valeur'];
}

// ── Couleurs par produit ───────────────────────────────────────────
$stmtColors = $pdo->query("
    SELECT pc.id_produit, co.nom_couleur
    FROM produit_couleur pc
    INNER JOIN couleur co ON co.id_couleur = pc.id_couleur
    ORDER BY pc.id_produit, co.id_couleur
");
$allColors = [];
foreach ($stmtColors->fetchAll() as $color) {
    $allColors[$color['id_produit']][] = $color['nom_couleur'];
}

// ── Mapping des badges CSS ─────────────────────────────────────────
// Reproduit les classes badge de l'ancien tableau statique
function getBadgeClass(string $catCode, string $badge): string
{
    $badge_lower = mb_strtolower($badge, 'UTF-8');
    if (strpos($badge_lower, 'ip68') !== false || strpos($badge_lower, 'submersible') !== false) {
        return 'badge-cyan';
    }
    if (strpos($badge_lower, 'ultra') !== false || strpos($badge_lower, '820g') !== false || strpos($badge_lower, '480g') !== false || strpos($badge_lower, 'saison') !== false) {
        return 'badge-emerald';
    }
    return 'badge-amber';
}

// ── Formatage du volume pour l'affichage ───────────────────────────
function formatVolume(array $row): string
{
    $nom = $row['nom'];
    // Cas spéciaux basés sur le nom du produit
    if (stripos($nom, '65L') !== false) return '65L (+10L)';
    if (stripos($nom, '85+10') !== false) return '85+10L';
    if (stripos($nom, 'BIVY') !== false || stripos($nom, 'TENT') !== false) return '1 Personne + Matériel';
    return $row['volume_litres'] . ' Litres';
}

// ── Formatage du poids pour l'affichage ────────────────────────────
function formatWeight(int $grams): string
{
    if ($grams >= 1000) {
        return number_format($grams / 1000, 2, '.', '') . ' kg';
    }
    return $grams . ' g';
}

// ── Construction du tableau $produits (format identique à l'ancien) ─
$produits = [];

foreach ($rows as $row) {
    $id = (int)$row['id_produit'];

    // Le prix affiché est le prix promo s'il existe, sinon le prix normal
    $displayPrice = $row['prix_promo'] !== null ? (float)$row['prix_promo'] : (float)$row['prix'];
    $oldPrice     = $row['prix_promo'] !== null ? (float)$row['prix'] : null;

    // Mapping des catégories vers les labels d'affichage de l'ancien tableau
    $categoryLabels = [
        'expedition'  => "Sac à Dos d'Expédition",
        'fastpacking' => 'Fastpacking & Trail',
        'voyage'      => 'Sacs Duffel Étanche',
        'refuge'      => 'Abri & Bivouac Technique',
    ];

    // Cas spécial pour SERAC qui avait un label différent
    $catLabel = $categoryLabels[$row['cat_code']] ?? $row['cat_libelle'];
    if ($id === 3) {
        $catLabel = 'Haute Montagne & Expédition';
    }

    $produits[$id] = [
        'id'             => $id,
        'ref'            => 'RÉF: ' . $row['reference'],
        'slug'           => $row['slug'],
        'name'           => $row['nom'],
        'category'       => $row['cat_code'],
        'category_label' => $catLabel,
        'tag'            => $row['tag'] ?? '',
        'badge'          => $row['badge'] ?? '',
        'badge_class'    => getBadgeClass($row['cat_code'], $row['badge'] ?? ''),
        'price'          => $displayPrice,
        'old_price'      => $oldPrice,
        'volume'         => formatVolume($row),
        'volume_num'     => (int)$row['volume_litres'],
        'weight'         => formatWeight((int)$row['poids_grammes']),
        'weight_num'     => (int)$row['poids_grammes'],
        'material'       => $row['materiau'] ?? '',
        'waterproof'     => $row['etancheite'] ?? '',
        'temp_rating'    => $row['usage_temperature'] ?? '',
        'image'          => $row['image_principale'] ?? '',
        'short_desc'     => $row['description_courte'] ?? '',
        'full_desc'      => $row['description_longue'] ?? '',
        'specs'          => $allSpecs[$id] ?? [],
        'colors'         => $allColors[$id] ?? [],
        'featured'       => ($id <= 3),  // Les 3 premiers sont "featured"
        'rating'         => (float)$row['note_moyenne'],
        'reviews_count'  => (int)$row['nombre_avis'],
        'in_stock'       => ((int)$row['quantite_stock'] > 0),
    ];
}
