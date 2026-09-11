<?php
/**
 * VERTEX EXPEDITION - Page d'Accueil (index.php)
 */
require_once __DIR__ . '/data/produits.php';

$current_page = 'accueil';
$page_title = 'VERTEX EXPEDITION | Sacs à Dos Techniques & Matériel de Montagne';
$page_description = 'Sacs à dos techniques légers et robustes, testés en conditions réelles dans le massif du Mont-Blanc. Conception durable et réparable.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- SECTION HERO -->
<section class="hero-section">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center gy-5">
            <!-- Colonne Gauche : Présentation et Spécifications -->
            <div class="col-lg-7">
                <div class="hero-pill">
                    <i class="bi bi-compass me-1"></i> ÉQUIPEMENT DE MONTAGNE & EXPÉDITION
                </div>
                <h1 class="hero-title">
                    Sacs à dos techniques pour les terrains engagés
                </h1>
                <p class="hero-lead">
                    Conçus au cœur des Alpes avec des matières haute ténacité (Cordura®, Dyneema®). Confort de portage, robustesse à l'abrasion et réparabilité en atelier.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="produits.php" class="btn btn-vertex-primary">
                        Découvrir nos sacs <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <!-- Spécifications Techniques du Hero -->
                <div class="hero-specs-row">
                    <div class="hero-spec-item">
                        <span class="spec-label">TISSU PRINCIPAL</span>
                        <span class="spec-value text-amber">CORDURA® 500D RIPSTOP</span>
                        <span class="small text-muted" style="font-size: 0.68rem;">Haute résistance à l'abrasion</span>
                    </div>
                    <div class="hero-spec-item">
                        <span class="spec-label">SERVICE ATELIER</span>
                        <span class="spec-value text-white">RÉPARABILITÉ GARANTIE</span>
                        <span class="small text-muted" style="font-size: 0.68rem;">Atelier à Chamonix</span>
                    </div>
                    <div class="hero-spec-item">
                        <span class="spec-label">ERGONOMIE</span>
                        <span class="spec-value text-success">PORTAGE ÉQUILIBRÉ</span>
                        <span class="small text-muted" style="font-size: 0.68rem;">Stabilité de charge active</span>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Carte Produit Phare -->
            <div class="col-lg-5">
                <?php $featuredProduct = $produits[1]; ?>
                <div class="hero-product-card">
                    <div class="hero-image-wrapper">
                        <img src="<?php echo htmlspecialchars($featuredProduct['image']); ?>" alt="<?php echo htmlspecialchars($featuredProduct['name']); ?>">
                        <div class="hero-badge-overlay">
                            <i class="bi bi-award-fill me-1"></i> 65L PRO
                        </div>
                    </div>
                    <div class="hero-card-footer">
                        <div>
                            <div class="hero-card-meta">SAC D'EXPÉDITION // SÉRIE APEX</div>
                            <h3 class="hero-card-title"><?php echo htmlspecialchars($featuredProduct['name']); ?></h3>
                            <div class="text-success small tech-mono">
                                <i class="bi bi-check2-circle me-1"></i> ÉPROUVÉ EN CONDITIONS HIVERNALES
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="hero-price-tag"><?php echo number_format($featuredProduct['price'], 2); ?> €</div>
                            <button class="btn btn-vertex-primary btn-sm-tech btn-add-to-cart mt-1" 
                                    data-id="<?php echo $featuredProduct['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($featuredProduct['name']); ?>"
                                    data-price="<?php echo $featuredProduct['price']; ?>"
                                    data-volume="<?php echo htmlspecialchars($featuredProduct['volume']); ?>"
                                    data-weight="<?php echo htmlspecialchars($featuredProduct['weight']); ?>"
                                    data-image="<?php echo htmlspecialchars($featuredProduct['image']); ?>">
                                <i class="bi bi-cart-plus me-1"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CATÉGORIES TECHNIQUES SPÉCIALISÉES (01, 02, 03, 04) -->
<section class="categories-section">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-4">
            <div>
                <span class="tech-kicker">SEGMENTATION DU MATÉRIEL</span>
                <h2 class="fw-bold mb-0">Catégories de Matériel</h2>
            </div>
            <p class="text-muted small mb-0 mt-2 mt-md-0" style="max-width: 440px;">
                Équipement pensé pour chaque pratique : du fastpacking ultraléger aux longues traversées en autonomie.
            </p>
        </div>

        <div class="row g-4">
            <!-- 01 Sacs d'Expédition -->
            <div class="col-lg-3 col-md-6">
                <div class="category-card">
                    <div>
                        <div class="category-num-badge">
                            <span class="category-number">01</span>
                            <span class="category-volume-pill">VOL : 65L - 85L</span>
                        </div>
                        <h3 class="category-title">Sacs d'Expédition</h3>
                        <p class="category-desc">
                            Châssis rigide en aluminium 7075 et charge active pour les traversées de plusieurs jours en autonomie.
                        </p>
                    </div>
                    <a href="produits.php?cat=expedition" class="category-link">
                        VOIR EXPÉDITION <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 02 Fastpacking & Trail -->
            <div class="col-lg-3 col-md-6">
                <div class="category-card">
                    <div>
                        <div class="category-num-badge">
                            <span class="category-number">02</span>
                            <span class="category-volume-pill">VOL : 15L - 30L</span>
                        </div>
                        <h3 class="category-title">Fastpacking & Trail</h3>
                        <p class="category-desc">
                            Ajustement anatomique type gilet, sans rebond. Tissu Dyneema® imperméable haute ténacité.
                        </p>
                    </div>
                    <a href="produits.php?cat=fastpacking" class="category-link">
                        VOIR ULTRALÉGER <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 03 Sacs Duffel Hermétiques -->
            <div class="col-lg-3 col-md-6">
                <div class="category-card">
                    <div>
                        <div class="category-num-badge">
                            <span class="category-number">03</span>
                            <span class="category-volume-pill">VOL : 50L - 110L</span>
                        </div>
                        <h3 class="category-title">Sacs Duffel Étanche</h3>
                        <p class="category-desc">
                            Toile TPU 840D soudée haute fréquence. Protection fiable contre l'eau, la neige et la poussière.
                        </p>
                    </div>
                    <a href="produits.php?cat=voyage" class="category-link">
                        VOIR DUFFEL <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 04 Abris & Bivouac -->
            <div class="col-lg-3 col-md-6">
                <div class="category-card">
                    <div>
                        <div class="category-num-badge">
                            <span class="category-number">04</span>
                            <span class="category-volume-pill">4 SAISONS</span>
                        </div>
                        <h3 class="category-title">Abris & Bivouac</h3>
                        <p class="category-desc">
                            Abris individuels et tentes techniques ultralégères de moins de 1 kg pour les nuits en altitude.
                        </p>
                    </div>
                    <a href="produits.php?cat=refuge" class="category-link">
                        VOIR BIVOUAC <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRODUITS PHARE -->
<section class="products-section">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <span class="tech-kicker">NOTRE SÉLECTION</span>
                <h2 class="fw-bold mb-0">Sacs à Dos Recommandés</h2>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="produits.php" class="btn btn-vertex-outline btn-sm-tech">
                    Voir tout le catalogue (5) <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <?php 
            $featuredItems = array_slice($produits, 0, 3, true);
            foreach ($featuredItems as $item): 
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <div class="product-thumb-container">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <span class="product-ref-overlay"><?php echo htmlspecialchars($item['ref']); ?></span>
                        <div class="product-badge-overlay">
                            <span class="tech-badge <?php echo htmlspecialchars($item['badge_class']); ?>">
                                <?php echo htmlspecialchars($item['badge']); ?>
                            </span>
                        </div>
                    </div>

                    <div class="product-body">
                        <div class="product-category-tag"><?php echo htmlspecialchars($item['category_label']); ?></div>
                        <h3 class="product-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="product-short-desc"><?php echo htmlspecialchars($item['short_desc']); ?></p>

                        <!-- Grille d'Attributs Outdoor Spécifiques -->
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
                                <span class="spec-cell-value"><?php echo htmlspecialchars($item['material']); ?></span>
                            </div>
                            <div class="spec-cell">
                                <span class="spec-cell-label">ÉTANCHÉITÉ</span>
                                <span class="spec-cell-value text-info"><?php echo htmlspecialchars($item['waterproof']); ?></span>
                            </div>
                        </div>

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
                                <i class="bi bi-cart-plus me-1"></i> Ajouter au panier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
