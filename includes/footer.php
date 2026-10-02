<?php
?>

<footer class="vertex-footer">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center mb-5 pb-4 border-bottom border-secondary border-opacity-25">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <span class="tech-kicker">NEWSLETTER</span>
                <h4 class="fw-bold mb-1">Nouveautés produits et sorties de collection</h4>
                <p class="text-secondary small mb-0">Recevez un e-mail quand un nouveau sac ou une nouvelle série est disponible. Pas de spam.</p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2" onsubmit="event.preventDefault(); alert('Inscription à la newsletter enregistrée (fonctionnalité activée en V2).');">
                    <input type="email" class="form-control-tech" placeholder="Votre adresse e-mail..." required>
                    <button type="submit" class="btn btn-vertex-primary text-nowrap">
                        <i class="bi bi-envelope-fill me-1"></i> S'inscrire
                    </button>
                </form>
            </div>
        </div>

        <!-- Colonnes du Pied de Page -->
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
                <div class="navbar-brand-custom mb-3">
                    <span class="brand-icon"></span>
                    <div>
                        VERTEX
                        <span class="brand-sub">EXPEDITION LAB</span>
                    </div>
                </div>
                <p class="small text-secondary mb-3">
                    Sacs à dos techniques et équipement de montagne conçus pour durer, réparables et éprouvés sur le terrain.
                </p>
                <div class="tech-mono text-muted small">
                    CHAMONIX-MONT-BLANC, FRANCE
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-col-title">MATÉRIEL TECHNIQUE</div>
                <ul class="footer-links">
                    <li><a href="produits.php?cat=expedition">Sacs d'Expédition (65L - 85L)</a></li>
                    <li><a href="produits.php?cat=fastpacking">Fastpacking & Trail (15L - 30L)</a></li>
                    <li><a href="produits.php?cat=voyage">Sacs Duffel Étanche</a></li>
                    <li><a href="produits.php?cat=refuge">Abris & Bivouac</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-col-title">SERVICES & ATELIER</div>
                <ul class="footer-links">
                    <li><a href="contact.php">Garantie & Réparation</a></li>
                    <li><a href="qui-sommes-nous.php">Notre Histoire & Équipe</a></li>
                    <li><a href="contact.php">Service Client & Support</a></li>
                    <li><a href="inscription.php">Créer un compte</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-col-title">SUIVEZ-NOUS</div>
                <p class="small text-secondary mb-3">
                    Photos de terrain, nouveaux produits et coulisses de l'atelier.
                </p>
                <div class="d-flex gap-3 text-secondary fs-5">
                    <a href="#" class="text-secondary hover-white" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-secondary hover-white" title="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-secondary hover-white" title="Strava"><i class="bi bi-activity"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div>
                © 2026 VERTEX EXPEDITION EQUIPMENT. TOUS DROITS RÉSERVÉS.
            </div>
            <div class="d-flex gap-4">
                <a href="#" class="text-muted text-decoration-none hover-white">Mentions Légales</a>
                <a href="#" class="text-muted text-decoration-none hover-white">Politique de Confidentialité</a>
                <a href="#" class="text-muted text-decoration-none hover-white">Conditions Générales de Vente</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/main.js"></script>

</body>
</html>
