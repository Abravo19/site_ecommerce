<?php
require_once __DIR__ . '/functions.php';   // démarre la session (avant toute sortie HTML)
require_once __DIR__ . '/db.php';          // connexion PDO ($pdo)
require_once __DIR__ . '/panier_fonctions.php';

if (!isset($page_title)) {
    $page_title = 'VERTEX EXPEDITION | Sacs à Dos Techniques & Matériel de Montagne';
}
if (!isset($page_description)) {
    $page_description = 'Sacs à dos techniques, équipements de montagne et matériel outdoor haute performance conçus pour l\'aventure et les expéditions.';
}
if (!isset($current_page)) {
    $current_page = '';
}
$nb_panier = panierCount();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e($page_description); ?>">
    <title><?php echo e($page_title); ?></title>

    <link rel="icon" type="image/svg+xml" href="img/favicon.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- BARRE DE NAVIGATION PRINCIPALE -->
<nav class="navbar navbar-expand-lg vertex-navbar">
    <div class="container-fluid px-lg-4">
        <a class="navbar-brand navbar-brand-custom" href="index.php">
            <img src="img/logo.png" alt="" class="brand-logo" width="28" height="28">
            <div>
                VERTEX
                <span class="brand-sub">EXPEDITION LAB</span>
            </div>
        </a>

        <!-- Boutons mobile : panier + menu -->
        <div class="d-flex align-items-center gap-2 d-lg-none">
            <a href="panier.php" class="cart-trigger-btn py-1 px-2 text-decoration-none" aria-label="Voir le panier">
                <i class="bi bi-backpack2-fill text-amber"></i>
                <span class="cart-count-badge" <?php echo $nb_panier > 0 ? '' : 'style="display: none;"'; ?>><?php echo (int)$nb_panier; ?></span>
            </a>
            <button class="navbar-toggler border-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#vertexNavbarContent" aria-controls="vertexNavbarContent" aria-expanded="false" aria-label="Navigation">
                <i class="bi bi-list text-white fs-3"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="vertexNavbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom <?php echo ($current_page === 'accueil') ? 'active' : ''; ?>" href="index.php">
                        <i class="bi bi-compass me-1"></i> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom <?php echo ($current_page === 'articles') ? 'active' : ''; ?>" href="articles.php">
                        <i class="bi bi-grid-3x3-gap me-1"></i> Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom <?php echo ($current_page === 'apropos') ? 'active' : ''; ?>" href="apropos.php">
                        <i class="bi bi-people me-1"></i> Qui sommes-nous ?
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom <?php echo ($current_page === 'contact') ? 'active' : ''; ?>" href="contact.php">
                        <i class="bi bi-chat-square-text me-1"></i> Contact
                    </a>
                </li>
                <?php if (isLoggedIn()): ?>
                    <?php $user_nav = getCurrentUser(); ?>
                    <li class="nav-item">
                        <span class="nav-link nav-link-custom disabled">
                            <i class="bi bi-person-check-fill me-1"></i> <?php echo e($user_nav['prenom']); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="deconnexion.php">
                            <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom <?php echo ($current_page === 'connexion') ? 'active' : ''; ?>" href="connexion.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom <?php echo ($current_page === 'inscription') ? 'active' : ''; ?>" href="inscription.php">
                            <i class="bi bi-person-plus me-1"></i> Inscription
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <form class="tech-search-wrapper" action="articles.php" method="GET" role="search">
                    <i class="bi bi-search tech-search-icon"></i>
                    <input type="text" name="q" class="tech-search-input" placeholder="Rechercher un article..." aria-label="Recherche" id="navSearchInput">
                </form>

                <a href="panier.php" class="cart-trigger-btn d-none d-lg-inline-flex text-decoration-none" aria-label="Voir le panier">
                    <i class="bi bi-backpack2-fill text-amber fs-6"></i>
                    <span class="tech-mono fw-bold">PANIER</span>
                    <span class="cart-count-badge" <?php echo $nb_panier > 0 ? '' : 'style="display: none;"'; ?>><?php echo (int)$nb_panier; ?></span>
                </a>
            </div>
        </div>
    </div>
</nav>
<?php flashRender(); ?>
