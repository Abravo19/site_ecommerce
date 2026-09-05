<?php
/**
 * VERTEX EXPEDITION - Liste des Articles (produits.php)
 * Limite stricte V1 : Exactement 5 articles techniques
 */
require_once __DIR__ . '/data/produits.php';

$current_page = 'produits';
$page_title = 'Catalogue de Matériel Technique (5) | VERTEX EXPEDITION';
$page_description = 'Catalogue complet de sacs à dos d\'expédition, fastpacking ultraléger, duffels submersibles et abris bivouac de haute montagne.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- ==========================================================================
     EN-TÊTE TECHNIQUE DU CATALOGUE
     ========================================================================== -->
<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="tech-kicker">NOTRE COLLECTION</span>
                <h1 class="fw-bold mb-2">Équipement d'Expédition et de Traversée</h1>
                <p class="text-secondary mb-0" style="max-width: 680px;">
                    Tous les articles sont soumis à des essais de fatigue mécanique en chambre climatique. Consultez les attributs spécifiques de litrage, poids sur balance de laboratoire, matériaux et imperméabilité.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-dark rounded border border-secondary border-opacity-25 tech-mono">
                    <i class="bi bi-box2-fill text-amber"></i>
                    <span>ARTICLES AU CATALOGUE :</span>
                    <strong class="text-white"><?php echo count($produits); ?> SUR 5</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================================
     BARRE DE FILTRES TECHNIQUES
     ========================================================================== -->
<div class="container-fluid px-lg-5 mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 bg-dark rounded border border-secondary border-opacity-25">
        <!-- Boutons de Filtre par Catégorie -->
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-warning btn-sm-tech catalog-filter-btn active" data-filter="all">
                <i class="bi bi-grid-fill me-1"></i> Tous (5)
            </button>
            <button class="btn btn-vertex-outline btn-sm-tech catalog-filter-btn" data-filter="expedition">
                Expédition (65L-85L)
            </button>
            <button class="btn btn-vertex-outline btn-sm-tech catalog-filter-btn" data-filter="fastpacking">
                Fastpacking & Trail (25L)
            </button>
            <button class="btn btn-vertex-outline btn-sm-tech catalog-filter-btn" data-filter="voyage">
                Duffel Submersible (75L)
            </button>
            <button class="btn btn-vertex-outline btn-sm-tech catalog-filter-btn" data-filter="refuge">
                Abri Bivouac (1P)
            </button>
        </div>

        <div class="small tech-mono text-muted">
            <i class="bi bi-info-circle me-1 text-info"></i> Collection actuelle
        </div>
    </div>
</div>

<!-- ==========================================================================
     GRILLE DES PRODUITS (EXACTEMENT LES 5 ARTICLES)
     ========================================================================== -->
<div class="container-fluid px-lg-5 pb-5">
    <div class="row g-4" id="catalogProductsGrid">
        <?php foreach ($produits as $item): ?>
        <div class="col-lg-4 col-md-6 catalog-product-item" data-category="<?php echo htmlspecialchars($item['category']); ?>">
            <div class="product-card">
                <!-- Vignette avec Badges -->
                <div class="product-thumb-container">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <span class="product-ref-overlay"><?php echo htmlspecialchars($item['ref']); ?></span>
                    <div class="product-badge-overlay">
                        <span class="tech-badge <?php echo htmlspecialchars($item['badge_class']); ?>">
                            <?php echo htmlspecialchars($item['badge']); ?>
                        </span>
                    </div>
                </div>

                <!-- Corps de la Carte -->
                <div class="product-body">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="product-category-tag"><?php echo htmlspecialchars($item['category_label']); ?></span>
                        <span class="small tech-mono text-warning">
                            <i class="bi bi-star-fill me-1"></i><?php echo $item['rating']; ?> (<?php echo $item['reviews_count']; ?>)
                        </span>
                    </div>

                    <h2 class="product-name fs-5"><?php echo htmlspecialchars($item['name']); ?></h2>
                    <p class="product-short-desc"><?php echo htmlspecialchars($item['short_desc']); ?></p>

                    <!-- Grille des Spécifications Outdoor -->
                    <div class="product-specs-grid">
                        <div class="spec-cell">
                            <span class="spec-cell-label">LITRAGE</span>
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

                    <!-- Volet d'Ingénierie Déroulant -->
                    <div class="mb-3">
                        <button class="btn btn-sm btn-link text-secondary p-0 text-decoration-none tech-mono small" 
                                type="button" data-bs-toggle="collapse" data-bs-target="#specsCollapse-<?php echo $item['id']; ?>" 
                                aria-expanded="false">
                            <i class="bi bi-cpu me-1 text-amber"></i> Déplier les spécifications d'ingénierie <i class="bi bi-chevron-down ms-1"></i>
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
                    <div class="product-footer">
                        <div class="product-price-box">
                            <span class="product-price"><?php echo number_format($item['price'], 2); ?> €</span>
                            <?php if (!empty($item['old_price'])): ?>
                                <span class="product-old-price"><?php echo number_format($item['old_price'], 2); ?> €</span>
                            <?php endif; ?>
                        </div>

                        <button class="btn btn-vertex-primary btn-sm-tech btn-add-to-cart"
                                data-id="<?php echo $item['id']; ?>"
                                data-name="<?php echo htmlspecialchars($item['name']); ?>"
                                data-price="<?php echo $item['price']; ?>"
                                data-volume="<?php echo htmlspecialchars($item['volume']); ?>"
                                data-weight="<?php echo htmlspecialchars($item['weight']); ?>"
                                data-image="<?php echo htmlspecialchars($item['image']); ?>">
                            <i class="bi bi-cart-plus me-1"></i> Ajouter à l'Équipement
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Section nouveautés retirée (contenu généré par IA) -->
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
