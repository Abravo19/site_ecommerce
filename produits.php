<?php
require_once __DIR__ . '/data/produits.php';

$current_page = 'produits';
$page_title = 'Catalogue de Matériel Technique (' . count($produits) . ') | VERTEX EXPEDITION';
$page_description = 'Catalogue complet de sacs à dos d\'expédition, fastpacking ultraléger, duffels submersibles et abris bivouac de haute montagne.';

// Filtrage par recherche texte
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($search_query !== '') {
    $produits_filtered = array_filter($produits, function($item) use ($search_query) {
        $haystack = mb_strtolower(
            $item['name'] . ' ' . $item['category_label'] . ' ' . $item['short_desc'] . ' ' . $item['material'] . ' ' . $item['tag'],
            'UTF-8'
        );
        return mb_strpos($haystack, mb_strtolower($search_query, 'UTF-8'), 0, 'UTF-8') !== false;
    });
} else {
    $produits_filtered = $produits;
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
flashRender();
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="tech-kicker">CATALOGUE TECHNIQUE</span>
                <h1 class="fw-bold mb-2">Sacs à Dos & Équipement Outdoor</h1>
                <p class="text-secondary mb-0" style="max-width: 680px;">
                    Conçus pour l'alpinisme, le fastpacking et les traversées engagées. Retrouvez ici les détails techniques de chaque modèle : litrage, poids, matériaux et niveau d'imperméabilité.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-dark rounded border border-secondary border-opacity-25 tech-mono">
                    <i class="bi bi-box2-fill text-amber"></i>
                    <span>ARTICLES AU CATALOGUE :</span>
                    <strong class="text-white"><?php echo count($produits_filtered); ?> SUR <?php echo count($produits); ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-lg-5 mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 bg-dark rounded border border-secondary border-opacity-25">
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-warning btn-sm-tech catalog-filter-btn active" data-filter="all">
                <i class="bi bi-grid-fill me-1"></i> Tous (<?php echo count($produits); ?>)
            </button>
            <?php foreach ($categories as $code => $cat): ?>
            <button class="btn btn-vertex-outline btn-sm-tech catalog-filter-btn" data-filter="<?php echo e($code); ?>">
                <?php echo e($cat['label']); ?> (<?php echo $cat['nb']; ?>)
            </button>
            <?php endforeach; ?>
        </div>

        <div class="small tech-mono text-muted">
            <i class="bi bi-info-circle me-1 text-info"></i> Collection actuelle
        </div>
    </div>
</div>

<div class="container-fluid px-lg-5 pb-5">
    <?php if ($search_query !== ''): ?>
    <div class="d-flex align-items-center gap-2 mb-4 p-3 bg-dark rounded border border-info border-opacity-25">
        <i class="bi bi-search text-info"></i>
        <span class="tech-mono small">Résultats pour : <strong class="text-white">"<?php echo htmlspecialchars($search_query); ?>"</strong></span>
        <span class="tech-mono small text-muted">(<?php echo count($produits_filtered); ?> trouvé<?php echo count($produits_filtered) > 1 ? 's' : ''; ?>)</span>
        <a href="produits.php" class="btn btn-sm btn-outline-secondary ms-auto tech-mono" style="font-size: 0.7rem;">
            <i class="bi bi-x-lg me-1"></i> Effacer
        </a>
    </div>
    <?php endif; ?>

    <div class="row g-4" id="catalogProductsGrid">
        <?php foreach ($produits_filtered as $item): ?>
        <div class="col-lg-4 col-md-6 catalog-product-item" data-category="<?php echo htmlspecialchars($item['category']); ?>">
            <div class="product-card">
                <div class="product-thumb-container">
                    <a href="produit.php?slug=<?php echo e($item['slug']); ?>"><img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>" loading="lazy"></a>
                    <span class="product-ref-overlay"><?php echo htmlspecialchars($item['ref']); ?></span>
                    <div class="product-badge-overlay">
                        <span class="tech-badge <?php echo htmlspecialchars($item['badge_class']); ?>">
                            <?php echo htmlspecialchars($item['badge']); ?>
                        </span>
                    </div>
                </div>
                <div class="product-body">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="product-category-tag"><?php echo htmlspecialchars($item['category_label']); ?></span>
                        <span class="small tech-mono text-warning">
                            <i class="bi bi-star-fill me-1"></i><?php echo $item['rating']; ?> (<?php echo $item['reviews_count']; ?>)
                        </span>
                    </div>

                    <h2 class="product-name fs-5"><a href="produit.php?slug=<?php echo e($item['slug']); ?>" class="text-decoration-none text-reset"><?php echo htmlspecialchars($item['name']); ?></a></h2>
                    <p class="product-short-desc"><?php echo htmlspecialchars($item['short_desc']); ?></p>

                    <div class="product-specs-grid">
                        <div class="spec-cell">
                            <span class="spec-cell-label"><?php echo e($item['volume_label']); ?></span>
                            <span class="spec-cell-value text-amber"><?php echo htmlspecialchars($item['volume']); ?></span>
                        </div>
                        <div class="spec-cell">
                            <span class="spec-cell-label">POIDS</span>
                            <span class="spec-cell-value"><?php echo htmlspecialchars($item['weight']); ?></span>
                        </div>
                        <div class="spec-cell">
                            <span class="spec-cell-label">MATÉRIAU</span>
                            <span class="spec-cell-value" title="<?php echo htmlspecialchars($item['material']); ?>">
                                <?php echo htmlspecialchars($item['material']); ?>
                            </span>
                        </div>
                        <div class="spec-cell">
                            <span class="spec-cell-label">ÉTANCHÉITÉ</span>
                            <span class="spec-cell-value text-info"><?php echo htmlspecialchars($item['waterproof']); ?></span>
                        </div>
                    </div>

                    <!-- Volet de Spécifications Techniques -->
                    <div class="mb-3">
                        <button class="btn btn-sm btn-link text-secondary p-0 text-decoration-none tech-mono small" 
                                type="button" data-bs-toggle="collapse" data-bs-target="#specsCollapse-<?php echo $item['id']; ?>" 
                                aria-expanded="false">
                            <i class="bi bi-sliders me-1 text-amber"></i> Voir les caractéristiques techniques <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                        <div class="collapse mt-2" id="specsCollapse-<?php echo $item['id']; ?>">
                            <div class="p-3 bg-dark rounded border border-secondary border-opacity-25 small">
                                <p class="text-secondary small mb-2"><?php echo htmlspecialchars($item['full_desc']); ?></p>
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($item['specs'] as $specKey => $specVal): ?>
                                    <li class="py-1 border-bottom border-secondary border-opacity-25 d-flex justify-content-between">
                                        <span class="text-muted tech-mono"><?php echo htmlspecialchars($specKey); ?> :</span>
                                        <span class="text-white text-end ps-2"><?php echo htmlspecialchars($specVal); ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Pied de Carte avec Prix et Bouton Panier -->
                    <div class="product-footer flex-wrap gap-2">
                        <div class="product-price-box">
                            <span class="product-price"><?php echo number_format($item['price'], 2); ?> €</span>
                            <?php if (!empty($item['old_price'])): ?>
                                <span class="product-old-price"><?php echo number_format($item['old_price'], 2); ?> €</span>
                            <?php endif; ?>
                        </div>

                        <?php echo formAjoutPanier($item, 'produits.php'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
