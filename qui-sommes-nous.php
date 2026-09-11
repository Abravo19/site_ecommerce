<?php
$current_page = 'qui-sommes-nous';
$page_title = 'Qui sommes-nous ? | VERTEX EXPEDITION';
$page_description = 'Découvrez l\'équipe derrière VERTEX EXPEDITION.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <span class="tech-kicker">LABORATOIRE ALPIN DE HAUTE PRÉCISIO</span>
        <h1 class="fw-bold mb-3">Notre Mission : Dompter l'Hostilité</h1>
        <p class="text-secondary fs-5 mb-0" style="max-width: 760px;">
            Fondée au cœur du massif du Mont-Blanc par des guides de haute montagne et des ingénieurs en matériaux. Nous concevons les sacs à dos et l'équipement que nous exigeons lorsque le mercure chute sous les -25°C.
        </p>
    </div>
</div>

<section class="container-fluid px-lg-5 mb-5 pb-4">
    <div class="mb-4">
        <span class="tech-kicker">L'ÉQUIPE</span>
        <h2 class="fw-bold mb-0">La Personne Derrière VERTEX EXPEDITION</h2>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-6 col-md-6">
            <div class="team-card">
                <div class="team-avatar-box">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80" alt="Alex Vance">
                </div>
                <div class="team-card-body">
                    <div class="team-role">Fondateur & Guide de Montagne</div>
                    <h3 class="team-name">Gabriel Bravo</h3>
                    <p class="team-bio">
                        Guide de haute montagne depuis plus de 10 ans. Il teste chaque sac sur le terrain avant sa mise en vente.
                    </p>
                </div>
            </div>
        </div>

<?php include __DIR__ . '/includes/footer.php'; ?>
