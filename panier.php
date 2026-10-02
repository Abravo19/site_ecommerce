<?php
/**
 * VERTEX EXPEDITION — Panier (Livrable 9)
 * Traite les actions POST (ajouter, plus, moins, retirer) puis redirige (Post/Redirect/Get).
 */
require_once __DIR__ . '/includes/panier.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck($_POST['csrf'] ?? null)) {
        flashSet('danger', 'Votre session a expiré. Merci de réessayer.');
        redirect('panier.php');
    }

    $action = $_POST['action'] ?? '';
    $id     = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
    $retour = 'panier.php';

    if ($id === false || $id === null || $id < 1) {
        flashSet('danger', 'Produit invalide.');
        redirect('panier.php');
    }

    switch ($action) {
        case 'ajouter':
            $qte = filter_var($_POST['quantite'] ?? 1, FILTER_VALIDATE_INT);
            panierAjouter($id, $qte === false ? 0 : $qte);
            $retour = retourSecurise($_POST['retour'] ?? '');
            break;
        case 'plus':
            panierModifier($id, 1);
            break;
        case 'moins':
            panierModifier($id, -1);
            break;
        case 'retirer':
            panierRetirer($id);
            flashSet('info', 'Article retiré du panier.');
            break;
        default:
            flashSet('danger', 'Action inconnue.');
    }
    redirect($retour);
}

$panier = panierLignes();

$current_page     = 'panier';
$page_title       = 'Mon panier | VERTEX EXPEDITION';
$page_description = 'Consultez et modifiez le contenu de votre panier VERTEX EXPEDITION.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
flashRender();
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <span class="tech-kicker">VOTRE SÉLECTION</span>
        <h1 class="fw-bold mb-1">Mon panier</h1>
        <p class="text-secondary mb-0">
            <?php echo $panier['nb_articles']; ?> article<?php echo $panier['nb_articles'] > 1 ? 's' : ''; ?> dans votre panier
        </p>
    </div>
</div>

<div class="container-fluid px-lg-5 pb-5">
<?php if (empty($panier['lignes'])): ?>
    <div class="text-center py-5">
        <i class="bi bi-bag-x display-3 text-muted d-block mb-3"></i>
        <p class="text-muted mb-3">Votre panier est vide.</p>
        <a href="produits.php" class="btn btn-vertex-primary btn-sm-tech">
            <i class="bi bi-grid-3x3-gap me-1"></i> Découvrir le catalogue
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <?php foreach ($panier['lignes'] as $l): ?>
            <div class="d-flex flex-wrap align-items-center gap-3 p-3 mb-3 bg-dark rounded border border-secondary border-opacity-25">
                <a href="produit.php?slug=<?php echo e($l['slug']); ?>">
                    <img src="<?php echo e($l['image']); ?>" alt="<?php echo e($l['nom']); ?>"
                         style="width:96px;height:96px;object-fit:cover;border-radius:6px;">
                </a>

                <div class="flex-grow-1" style="min-width:180px;">
                    <a class="text-white text-decoration-none fw-bold" href="produit.php?slug=<?php echo e($l['slug']); ?>">
                        <?php echo e($l['nom']); ?>
                    </a>
                    <div class="tech-mono small text-muted">Prix unitaire : <?php echo number_format($l['pu'], 2, ',', ' '); ?> €</div>
                </div>

                <!-- Quantité : − / + -->
                <div class="d-flex align-items-center gap-2">
                    <form method="post" action="panier.php">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="action" value="moins">
                        <input type="hidden" name="id" value="<?php echo $l['id']; ?>">
                        <button class="btn btn-sm btn-dark border border-secondary px-2" type="submit"
                                aria-label="Retirer un exemplaire de <?php echo e($l['nom']); ?>">
                            <i class="bi bi-dash-lg"></i>
                        </button>
                    </form>
                    <span class="tech-mono fw-bold px-2" aria-live="polite"><?php echo $l['qte']; ?></span>
                    <form method="post" action="panier.php">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="action" value="plus">
                        <input type="hidden" name="id" value="<?php echo $l['id']; ?>">
                        <button class="btn btn-sm btn-dark border border-secondary px-2" type="submit"
                                aria-label="Ajouter un exemplaire de <?php echo e($l['nom']); ?>">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </form>
                </div>

                <div class="text-amber fw-bold tech-mono" style="min-width:110px;text-align:right;">
                    <?php echo number_format($l['sous_total'], 2, ',', ' '); ?> €
                </div>

                <!-- Retirer l'article quelle que soit la quantité -->
                <form method="post" action="panier.php">
                    <?php echo csrfField(); ?>
                    <input type="hidden" name="action" value="retirer">
                    <input type="hidden" name="id" value="<?php echo $l['id']; ?>">
                    <button class="btn btn-link text-muted p-0" type="submit" title="Retirer du panier"
                            aria-label="Retirer <?php echo e($l['nom']); ?> du panier">
                        <i class="bi bi-trash fs-5"></i>
                    </button>
                </form>
            </div>
            <?php endforeach; ?>

            <a href="produits.php" class="btn btn-vertex-outline btn-sm-tech">
                <i class="bi bi-arrow-left me-1"></i> Continuer mes achats
            </a>
        </div>

        <div class="col-lg-4">
            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25">
                <h2 class="fs-5 fw-bold mb-3">Récapitulatif</h2>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted tech-mono small">ARTICLES :</span>
                    <span class="tech-mono"><?php echo $panier['nb_articles']; ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted tech-mono small">TVA (20 %) :</span>
                    <span class="text-success tech-mono small">INCLUSE</span>
                </div>
                <hr class="border-secondary">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="tech-mono">TOTAL :</span>
                    <span class="fs-4 fw-bold text-white"><?php echo number_format($panier['total'], 2, ',', ' '); ?> €</span>
                </div>
                <button class="btn btn-vertex-primary w-100 justify-content-center py-3" type="button" disabled>
                    <i class="bi bi-shield-lock-fill me-2"></i> Valider la commande (bientôt disponible)
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
