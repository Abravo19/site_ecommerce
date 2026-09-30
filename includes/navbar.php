<?php
if (!isset($current_page)) {
    $current_page = '';
}
?>
<!-- BARRE DE NAVIGATION PRINCIPALE -->
<nav class="navbar navbar-expand-lg vertex-navbar">
    <div class="container-fluid px-lg-4">
        <!-- Logo et Marque -->
        <a class="navbar-brand navbar-brand-custom" href="index.php">
            <span class="brand-icon"></span>
            <div>
                VERTEX
                <span class="brand-sub">EXPEDITION LAB</span>
            </div>
        </a>

        <!-- Bouton Mobile -->
        <div class="d-flex align-items-center gap-2 d-lg-none">
            <button class="cart-trigger-btn py-1 px-2" aria-label="Ouvrir le Panier">
                <i class="bi bi-backpack2-fill text-amber"></i>
                <span class="cart-count-badge" id="cartCountBadgeMobile" style="display: none;">0</span>
            </button>
            <button class="navbar-toggler border-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#vertexNavbarContent" aria-controls="vertexNavbarContent" aria-expanded="false" aria-label="Navigation">
                <i class="bi bi-list text-white fs-3"></i>
            </button>
        </div>

        <!-- Liens et Menu -->
        <div class="collapse navbar-collapse" id="vertexNavbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom <?php echo ($current_page === 'accueil') ? 'active' : ''; ?>" href="index.php">
                        <i class="bi bi-compass me-1"></i> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom <?php echo ($current_page === 'produits') ? 'active' : ''; ?>" href="produits.php">
                        <i class="bi bi-grid-3x3-gap me-1"></i> Produits
                    </a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom <?php echo ($current_page === 'qui-sommes-nous') ? 'active' : ''; ?>" href="qui-sommes-nous.php">
                        <i class="bi bi-people me-1"></i> Qui sommes-nous ?
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom <?php echo ($current_page === 'contact') ? 'active' : ''; ?>" href="contact.php">
                        <i class="bi bi-chat-square-text me-1"></i> Contact
                    </a>
                </li>
                <?php if (isLoggedIn()): ?>
                    <?php $current_user_nav = getCurrentUser(); ?>
                    <li class="nav-item">
                        <span class="nav-link nav-link-custom disabled">
                            <i class="bi bi-person-check-fill me-1"></i> <?php echo htmlspecialchars($current_user_nav['prenom']); ?>
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

            <!-- Moteur de Recherche et Actions -->
            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <!-- Champ de Recherche -->
                <form class="tech-search-wrapper" action="produits.php" method="GET" role="search">
                    <i class="bi bi-search tech-search-icon"></i>
                    <input type="text" name="q" class="tech-search-input" placeholder="Rechercher un produit..." aria-label="Recherche" id="navSearchInput">
                </form>

                <!-- Bouton Panier -->
                <button class="cart-trigger-btn d-none d-lg-inline-flex" id="openCartNavBtn" aria-label="Voir le panier">
                    <i class="bi bi-backpack2-fill text-amber fs-6"></i>
                    <span class="tech-mono fw-bold">PANIER</span>
                    <span class="cart-count-badge" id="cartCountBadge" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </div>
</nav>
