<?php
/**
 * VERTEX EXPEDITION — Fiche détaillée d'un produit (produit.php?slug=...)
 */
require_once __DIR__ . '/data/produits.php';

// Le slug fourni par le visiteur est comparé aux produits déjà chargés : aucune requête SQL avec cette valeur.
$slug = $_GET['slug'] ?? '';
$item = null;
if (is_string($slug) && preg_match('/^[a-z0-9\-]{1,150}$/', $slug)) {
    foreach ($produits as $p) {
        if ($p['slug'] === $slug) {
            $item = $p;
            break;
        }
    }
}

$current_page = 'produits';

if ($item === null) {
    http_response_code(404);
    $page_title = 'Produit introuvable | VERTEX EXPEDITION';
    include __DIR__ . '/includes/header.php';
    include __DIR__ . '/includes/navbar.php';
    echo '<div class="container-fluid px-lg-5 py-5 text-center">'
       . '<i class="bi bi-compass display-3 text-muted d-block mb-3"></i>'
       . '<h1 class="fs-3">Produit introuvable</h1>'
       . '<p class="text-muted">Ce produit n\'existe pas ou n\'est plus au catalogue.</p>'
       . '<a href="produits.php" class="btn btn-vertex-primary btn-sm-tech">Retour au catalogue</a></div>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$page_title       = $item['name'] . ' | VERTEX EXPEDITION';
$page_description = $item['short_desc'];

// Produits de la même catégorie (suggestions)
$similaires = array_slice(array_filter($produits, function ($p) use ($item) {
    return $p['category'] === $item['category'] && $p['id'] !== $item['id'];
}), 0, 3);

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
flashRender();
?>

<div class="container-fluid px-lg-5 py-4">
    <nav aria-label="Fil d'Ariane" class="tech-mono small mb-3">
        <a href="index.php" class="text-muted text-decoration-none">Accueil</a> /
        <a href="produits.php" class="text-muted text-decoration-none">Catalogue</a> /
        <a href="produits.php?cat=<?php echo e($item['category']); ?>" class="text-muted text-decoration-none"><?php echo e($item['category_label']); ?></a> /
        <span class="text-white"><?php echo e($item['name']); ?></span>
    </nav>

    <div class="row g-5">
        <div class="col-lg-6">
            <div class="product-thumb-container" style="height:420px;border-radius:12px;">
                <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>" class="w-100">
                <span class="product-ref-overlay"><?php echo e($item['ref']); ?></span>
                <?php if ($item['badge'] !== ''): ?>
                <div class="product-badge-overlay">
                    <span class="tech-badge <?php echo e($item['badge_class']); ?>"><?php echo e($item['badge']); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-6">
            <span class="product-category-tag"><?php echo e($item['category_label']); ?></span>
            <h1 class="fw-bold mt-1 mb-2"><?php echo e($item['name']); ?></h1>

            <div class="small tech-mono text-warning mb-3">
                <i class="bi bi-star-fill me-1"></i><?php echo e($item['rating']); ?>
                <span class="text-muted">(<?php echo $item['reviews_count']; ?> avis)</span>
            </div>

            <div class="d-flex align-items-baseline gap-3 mb-3">
                <span class="fs-2 fw-bold text-white"><?php echo number_format($item['price'], 2, ',', ' '); ?> €</span>
                <?php if (!empty($item['old_price'])): ?>
                    <span class="product-old-price"><?php echo number_format($item['old_price'], 2, ',', ' '); ?> €</span>
                <?php endif; ?>
            </div>

            <p class="text-secondary"><?php echo e($item['short_desc']); ?></p>
            <p class="text-secondary small"><?php echo e($item['full_desc']); ?></p>

            <div class="product-specs-grid mb-4">
                <div class="spec-cell"><span class="spec-cell-label"><?php echo e($item['volume_label']); ?></span><span class="spec-cell-value text-amber"><?php echo e($item['volume']); ?></span></div>
                <div class="spec-cell"><span class="spec-cell-label">POIDS</span><span class="spec-cell-value"><?php echo e($item['weight']); ?></span></div>
                <div class="spec-cell"><span class="spec-cell-label">MATÉRIAU</span><span class="spec-cell-value"><?php echo e($item['material']); ?></span></div>
                <div class="spec-cell"><span class="spec-cell-label">ÉTANCHÉITÉ</span><span class="spec-cell-value text-info"><?php echo e($item['waterproof']); ?></span></div>
            </div>

            <?php if (!empty($item['colors'])): ?>
            <div class="mb-3 tech-mono small">
                <span class="text-muted">COLORIS :</span>
                <?php foreach ($item['colors'] as $couleur): ?>
                    <span class="badge bg-dark border border-secondary ms-1"><?php echo e($couleur); ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="mb-2 tech-mono small">
                <?php if ($item['in_stock']): ?>
                    <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>En stock</span>
                <?php else: ?>
                    <span class="text-danger"><i class="bi bi-x-circle-fill me-1"></i>Rupture de stock</span>
                <?php endif; ?>
            </div>

            <?php echo formAjoutPanier($item, 'produit.php?slug=' . $item['slug']); ?>
        </div>
    </div>

    <?php if (!empty($item['specs'])): ?>
    <div class="mt-5">
        <h2 class="fs-5 fw-bold mb-3"><i class="bi bi-sliders text-amber me-2"></i>Caractéristiques techniques</h2>
        <ul class="list-unstyled p-3 bg-dark rounded border border-secondary border-opacity-25 mb-0">
            <?php foreach ($item['specs'] as $cle => $val): ?>
            <li class="py-2 border-bottom border-secondary border-opacity-25 d-flex flex-wrap justify-content-between gap-2">
                <span class="text-muted tech-mono"><?php echo e($cle); ?> :</span>
                <span class="text-white text-end"><?php echo e($val); ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if ($similaires): ?>
    <div class="mt-5">
        <h2 class="fs-5 fw-bold mb-3">Dans la même catégorie</h2>
        <div class="row g-3">
            <?php foreach ($similaires as $s): ?>
            <div class="col-md-4">
                <a href="produit.php?slug=<?php echo e($s['slug']); ?>" class="d-flex gap-3 p-3 bg-dark rounded border border-secondary border-opacity-25 text-decoration-none">
                    <img src="<?php echo e($s['image']); ?>" alt="" style="width:72px;height:72px;object-fit:cover;border-radius:6px;">
                    <div>
                        <div class="text-white fw-bold"><?php echo e($s['name']); ?></div>
                        <div class="text-amber tech-mono small"><?php echo number_format($s['price'], 2, ',', ' '); ?> €</div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
