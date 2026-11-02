<?php
$current_page = 'apropos';
$page_title = 'Qui sommes-nous ? | VERTEX EXPEDITION';
$page_description = 'Découvrez l\'histoire et l\'atelier de VERTEX EXPEDITION à Chamonix.';

require_once __DIR__ . '/config/header.php';
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <h1 class="fw-bold mb-2">Qui sommes-nous ?</h1>
        <p class="text-secondary fs-5 mb-0" style="max-width: 740px;">
            Installé au pied du massif du Mont-Blanc, notre atelier conçoit des sacs à dos et des équipements de montagne durables, pensés pour être réparés plutôt que remplacés.
        </p>
    </div>
</div>

<section class="container-fluid px-lg-5 mb-5 pb-4">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-7">
            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 h-100">
                <h2 class="fs-4 fw-bold mb-3">Notre démarche à Chamonix</h2>
                <p class="text-secondary">
                    VERTEX EXPEDITION est né d'un constat simple en montagne : un sac à dos doit rester fiable quand la météo se dégrade, sans alourdir inutilement la course.
                </p>
                <p class="text-secondary mb-4">
                    Chaque modèle est d'abord assemblé en petite série et testé par des pratiquants réguliers en alpinisme, en randonnée alpine et en trail. Dans notre atelier de Chamonix, nous assurons également le remplacement des boucles, des sangles et la réparation des coutures ou fermetures étanches.
                </p>

                <div class="row g-3 pt-2 border-top border-secondary border-opacity-25">
                    <div class="col-sm-4">
                        <strong class="text-amber d-block fs-5">Chamonix</strong>
                        <span class="small text-secondary">Atelier de conception et réparation</span>
                    </div>
                    <div class="col-sm-4">
                        <strong class="text-white d-block fs-5">Petites séries</strong>
                        <span class="small text-secondary">Contrôle soigné des coutures et matériaux</span>
                    </div>
                    <div class="col-sm-4">
                        <strong class="text-success d-block fs-5">Réparable</strong>
                        <span class="small text-secondary">Service après-vente directement à l'atelier</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-black border border-warning text-amber fw-bold fs-4"
                             style="width:64px;height:64px;flex-shrink:0;">
                            GB
                        </div>
                        <div>
                            <div class="team-role mb-0">Fondateur &amp; Responsable Atelier</div>
                            <h3 class="team-name mb-0">Gabriel Bravo</h3>
                        </div>
                    </div>
                    <p class="team-bio mb-3">
                        Passionné de montagne et d'équipement technique, il supervise le choix des matériaux, les tests sur le terrain et le suivi des réparations à l'atelier.
                    </p>
                </div>

                <div class="pt-3 border-top border-secondary border-opacity-25">
                    <a href="contact.php" class="btn btn-vertex-outline btn-sm-tech">
                        <i class="bi bi-envelope me-1"></i> Contacter l'atelier
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/config/footer.php'; ?>
