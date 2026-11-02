<?php
require_once __DIR__ . '/config/catalogue.php';

$current_page = 'accueil';
$page_title = 'VERTEX EXPEDITION | Sacs à Dos & Matériel de Montagne';
$page_description = 'Sacs à dos de montagne, fastpacking et bivouac conçus et réparés à Chamonix.';

require_once __DIR__ . '/config/header.php';
?>

<!-- Section Hero -->
<section class="hero-section">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center gy-5">
            <!-- Colonne Gauche : Présentation -->
            <div class="col-lg-7">
                <div class="hero-pill">
                    <i class="bi bi-compass me-1"></i> Conçu à Chamonix — Massif du Mont-Blanc
                </div>
                <h1 class="hero-title">
                    Sacs à dos et matériel pour la haute montagne
                </h1>
                <p class="hero-lead">
                    Des sacs pensés pour l'alpinisme, le trail au long cours et le bivouac. Fabriqués avec des tissus résistants à l'abrasion et réparables dans notre atelier de Chamonix.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="articles.php" class="btn btn-vertex-primary">
                        Découvrir le catalogue <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <a href="apropos.php" class="btn btn-vertex-outline">
                        Notre atelier
                    </a>
                </div>

                <!-- Points clés -->
                <div class="hero-specs-row">
                    <div class="hero-spec-item">
                        <span class="spec-label">Matériaux</span>
                        <span class="spec-value text-amber">Cordura® &amp; Dyneema®</span>
                        <span class="small text-muted" style="font-size: 0.75rem;">Tissus résistants à l'abrasion</span>
                    </div>
                    <div class="hero-spec-item">
                        <span class="spec-label">Atelier Chamonix</span>
                        <span class="spec-value text-white">Réparation &amp; Garantie</span>
                        <span class="small text-muted" style="font-size: 0.75rem;">Pièces et coutures réparables</span>
                    </div>
                    <div class="hero-spec-item">
                        <span class="spec-label">Conception</span>
                        <span class="spec-value text-success">Testé sur le terrain</span>
                        <span class="small text-muted" style="font-size: 0.75rem;">Avec des guides de haute montagne</span>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Produit mis en avant -->
            <div class="col-lg-5">
                <?php $featuredProduct = $produits[1] ?? reset($produits); ?>
                <?php if ($featuredProduct): ?>
                <div class="hero-product-card">
                    <div class="hero-image-wrapper">
                        <a href="article.php?slug=<?php echo e($featuredProduct['slug']); ?>">
                            <img src="<?php echo e($featuredProduct['image']); ?>" alt="<?php echo e($featuredProduct['name']); ?>">
                        </a>
                        <div class="hero-badge-overlay">
                            <?php echo e($featuredProduct['volume']); ?>
                        </div>
                    </div>
                    <div class="hero-card-footer flex-wrap gap-2">
                        <div>
                            <div class="hero-card-meta"><?php echo e($featuredProduct['category_label']); ?></div>
                            <h3 class="hero-card-title">
                                <a href="article.php?slug=<?php echo e($featuredProduct['slug']); ?>" class="text-white text-decoration-none">
                                    <?php echo e($featuredProduct['name']); ?>
                                </a>
                            </h3>
                            <div class="text-secondary small">
                                <?php echo e($featuredProduct['weight']); ?> · <?php echo e($featuredProduct['material']); ?>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="hero-price-tag mb-1"><?php echo number_format($featuredProduct['price'], 2, ',', ' '); ?> €</div>
                            <?php echo formAjoutPanier($featuredProduct, 'index.php'); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Section Catégories -->
<section class="categories-section">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1">Nos gammes d'équipement</h2>
                <p class="text-secondary mb-0">
                    Quatre familles de matériel adaptées à votre pratique en montagne.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <!-- 01 Sacs d'Expédition -->
            <div class="col-lg-3 col-md-6">
                <div class="category-card">
                    <div>
                        <div class="category-num-badge">
                            <span class="category-volume-pill">45 L à 95 L</span>
                        </div>
                        <h3 class="category-title">Sacs d'Expédition</h3>
                        <p class="category-desc">
                            Armature aluminium et report de charge sur les hanches pour l'alpinisme et les raids de plusieurs jours.
                        </p>
                    </div>
                    <a href="articles.php?cat=expedition" class="category-link">
                        Voir les sacs d'expédition <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 02 Fastpacking & Trail -->
            <div class="col-lg-3 col-md-6">
                <div class="category-card">
                    <div>
                        <div class="category-num-badge">
                            <span class="category-volume-pill">8 L à 35 L</span>
                        </div>
                        <h3 class="category-title">Fastpacking &amp; Trail</h3>
                        <p class="category-desc">
                            Gilets et sacs légers à maintien proche du corps pour les sorties rapides et le trail en montagne.
                        </p>
                    </div>
                    <a href="articles.php?cat=fastpacking" class="category-link">
                        Voir la gamme trail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 03 Sacs Duffel Étanche -->
            <div class="col-lg-3 col-md-6">
                <div class="category-card">
                    <div>
                        <div class="category-num-badge">
                            <span class="category-volume-pill">25 L à 120 L</span>
                        </div>
                        <h3 class="category-title">Sacs Duffel Étanche</h3>
                        <p class="category-desc">
                            Sacs de transport en toile TPU soudée pour protéger le matériel de l'humidité et de la poussière.
                        </p>
                    </div>
                    <a href="articles.php?cat=voyage" class="category-link">
                        Voir les sacs de voyage <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 04 Abris & Bivouac -->
            <div class="col-lg-3 col-md-6">
                <div class="category-card">
                    <div>
                        <div class="category-num-badge">
                            <span class="category-volume-pill">3 &amp; 4 saisons</span>
                        </div>
                        <h3 class="category-title">Abris &amp; Bivouac</h3>
                        <p class="category-desc">
                            Tentes d'altitude, sursacs de bivouac, sacs de couchage en duvet et matelas isolants.
                        </p>
                    </div>
                    <a href="articles.php?cat=refuge" class="category-link">
                        Voir le matériel de bivouac <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Produits Phares -->
<section class="products-section">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1">Sélection du moment</h2>
                <p class="text-secondary mb-0">Nos modèles les plus utilisés par nos clients en montagne.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="articles.php" class="btn btn-vertex-outline btn-sm-tech">
                    Voir tout le catalogue (<?php echo count($produits); ?>) <i class="bi bi-arrow-right ms-1"></i>
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
                        <a href="article.php?slug=<?php echo e($item['slug']); ?>">
                            <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>">
                        </a>
                        <span class="product-ref-overlay"><?php echo e($item['ref']); ?></span>
                        <?php if ($item['badge'] !== ''): ?>
                        <div class="product-badge-overlay">
                            <span class="tech-badge <?php echo e($item['badge_class']); ?>">
                                <?php echo e($item['badge']); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-body">
                        <div class="product-category-tag"><?php echo e($item['category_label']); ?></div>
                        <h3 class="product-name">
                            <a href="article.php?slug=<?php echo e($item['slug']); ?>" class="text-white text-decoration-none">
                                <?php echo e($item['name']); ?>
                            </a>
                        </h3>
                        <p class="product-short-desc"><?php echo e($item['short_desc']); ?></p>

                        <div class="product-specs-grid">
                            <div class="spec-cell">
                                <span class="spec-cell-label"><?php echo e($item['volume_label']); ?></span>
                                <span class="spec-cell-value text-amber"><?php echo e($item['volume']); ?></span>
                            </div>
                            <div class="spec-cell">
                                <span class="spec-cell-label">POIDS</span>
                                <span class="spec-cell-value"><?php echo e($item['weight']); ?></span>
                            </div>
                            <div class="spec-cell">
                                <span class="spec-cell-label">MATÉRIAU</span>
                                <span class="spec-cell-value"><?php echo e($item['material']); ?></span>
                            </div>
                            <div class="spec-cell">
                                <span class="spec-cell-label">ÉTANCHÉITÉ</span>
                                <span class="spec-cell-value text-info"><?php echo e($item['waterproof']); ?></span>
                            </div>
                        </div>

                        <div class="product-footer flex-wrap gap-2">
                            <div class="product-price-box">
                                <span class="product-price"><?php echo number_format($item['price'], 2, ',', ' '); ?> €</span>
                                <?php if (!empty($item['old_price'])): ?>
                                    <span class="product-old-price"><?php echo number_format($item['old_price'], 2, ',', ' '); ?> €</span>
                                <?php endif; ?>
                            </div>

                            <?php echo formAjoutPanier($item, 'index.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/config/footer.php'; ?>
