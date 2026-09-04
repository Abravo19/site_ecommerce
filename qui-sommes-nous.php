<?php
/**
 * VERTEX EXPEDITION - Qui sommes-nous ? et Dons (qui-sommes-nous.php)
 * Présentation des membres de l'équipe et engagement environnemental
 */
$current_page = 'qui-sommes-nous';
$page_title = 'Qui sommes-nous ? & Dons | VERTEX EXPEDITION';
$page_description = 'Découvrez l\'équipe d\'ingénieurs, de guides alpins et d\'artisans de VERTEX, ainsi que notre programme de dons pour la préservation des glaciers.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- ==========================================================================
     EN-TÊTE DE LA PAGE
     ========================================================================== -->
<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <span class="tech-kicker">LABORATOIRE ALPIN DE HAUTE PRÉCISION</span>
        <h1 class="fw-bold mb-3">Notre Mission : Dompter l'Hostilité</h1>
        <p class="text-secondary fs-5 mb-0" style="max-width: 760px;">
            Fondée au cœur du massif du Mont-Blanc par des guides de haute montagne et des ingénieurs en matériaux. Nous concevons les sacs à dos et l'équipement que nous exigeons lorsque le mercure chute sous les -25°C.
        </p>
    </div>
</div>

<!-- ==========================================================================
     MEMBRES DE L'ÉQUIPE TECHNIQUE
     ========================================================================== -->
<section class="container-fluid px-lg-5 mb-5 pb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <div>
            <span class="tech-kicker">CORPS TECHNIQUE // MEMBRES DE L'EXPÉDITION</span>
            <h2 class="fw-bold mb-0">L'Équipe Derrière le Matériel</h2>
        </div>
        <p class="text-muted small mb-0 mt-2 mt-md-0" style="max-width: 440px;">
            Un collectif interdisciplinaire où chaque choix d'ingénierie est éprouvé sur arête rocheuse avant validation en laboratoire.
        </p>
    </div>

    <div class="row g-4">
        <!-- Membre 1 -->
        <div class="col-lg-3 col-md-6">
            <div class="team-card">
                <div class="team-avatar-box">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80" alt="Alex Vance">
                </div>
                <div class="team-card-body">
                    <div class="team-role">Fondateur & Guide UIAGM</div>
                    <h3 class="team-name">Alex Vance</h3>
                    <p class="team-bio">
                        Plus de 14 ans d'encadrement dans les Alpes, le Caucase et la Patagonie. Il dirige les tests de terrain des prototypes en conditions réelles de froid et de glace vive.
                    </p>
                </div>
            </div>
        </div>

        <!-- Membre 2 -->
        <div class="col-lg-3 col-md-6">
            <div class="team-card">
                <div class="team-avatar-box">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80" alt="Dre Camille Laurent">
                </div>
                <div class="team-card-body">
                    <div class="team-role">Ingénieure Polymères & Tissus</div>
                    <h3 class="team-name">Dre Camille Laurent</h3>
                    <p class="team-bio">
                        Docteure en Sciences des Matériaux. Spécialiste des composites Dyneema®, du thermosoudage imperméable et de l'optimisation du grammage sans concession de solidité.
                    </p>
                </div>
            </div>
        </div>

        <!-- Membre 3 -->
        <div class="col-lg-3 col-md-6">
            <div class="team-card">
                <div class="team-avatar-box">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80" alt="Mateo Ruiz">
                </div>
                <div class="team-card-body">
                    <div class="team-role">Conception Biomécanique & Portage</div>
                    <h3 class="team-name">Mateo Ruiz</h3>
                    <p class="team-bio">
                        Expert en cinématique posturale. Il façonne les exosquelettes en aluminium 7075 et les ceintures actives pour éliminer la fatigue lombaire sur les marches de plus de 10 heures.
                    </p>
                </div>
            </div>
        </div>

        <!-- Membre 4 -->
        <div class="col-lg-3 col-md-6">
            <div class="team-card">
                <div class="team-avatar-box">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&q=80" alt="Klara Nygård">
                </div>
                <div class="team-card-body">
                    <div class="team-role">Responsable Atelier & Réparation</div>
                    <h3 class="team-name">Klara Nygård</h3>
                    <p class="team-bio">
                        Artisane textile de montagne. Elle pilote notre atelier de réparation circulaire, s'assurant que chaque sac abîmé retrouve 100% de son intégrité et de son étanchéité d'origine.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PROGRAMME DE DONS ET ENGAGEMENT ENVIRONNEMENTAL
     ========================================================================== -->
<section class="container-fluid px-lg-5 mb-5" id="dons">
    <div class="p-5 bg-dark rounded border border-warning border-opacity-25 position-relative overflow-hidden">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="tech-kicker text-warning">RESPONSABILITÉ ÉCOLOGIQUE // 1% FOR THE PLANET</span>
                <h2 class="fw-bold mb-3">
                    Dons Directs pour la Préservation des Glaciers
                </h2>
                <p class="text-secondary mb-3">
                    La haute montagne est notre terrain de jeu et notre milieu de vie. Pour chaque équipement commandé sur VERTEX EXPEDITION, nous reversons automatiquement **1% de notre chiffre d'affaires brut** à des observatoires scientifiques indépendants chargés de mesurer le recul glaciaire et de préserver les sentiers d'altitude.
                </p>
                <div class="row g-3 pt-2">
                    <div class="col-sm-4">
                        <div class="p-3 bg-black rounded border border-secondary border-opacity-25 text-center">
                            <div class="fs-4 fw-bold text-amber tech-mono">14.850 €</div>
                            <span class="small text-muted" style="font-size: 0.72rem;">REVERSÉS EN 2024</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 bg-black rounded border border-secondary border-opacity-25 text-center">
                            <div class="fs-4 fw-bold text-success tech-mono">3 PROJETS</div>
                            <span class="small text-muted" style="font-size: 0.72rem;">FINANCÉS DANS LES ALPES</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 bg-black rounded border border-secondary border-opacity-25 text-center">
                            <div class="fs-4 fw-bold text-info tech-mono">100% AUDITÉ</div>
                            <span class="small text-muted" style="font-size: 0.72rem;">RAPPORT TRANSPARENT</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 text-center">
                <div class="p-4 bg-black rounded border border-secondary border-opacity-25">
                    <i class="bi bi-tree-fill display-3 text-success mb-3 d-block"></i>
                    <h4 class="fw-bold mb-2">Initiative "Glaciers Vivants"</h4>
                    <p class="small text-secondary mb-3">
                        Partenariat avec le Centre de Glaciologie de Chamonix pour déployer des micro-stations météorologiques autonomes sur les arêtes rocheuses à plus de 3 500 mètres.
                    </p>
                    <button class="btn btn-vertex-outline btn-sm-tech w-100" onclick="alert('Téléchargement du Rapport de Transparence des Dons 2024-2025 au format PDF.');">
                        <i class="bi bi-file-earmark-pdf me-1 text-danger"></i> Télécharger le Rapport des Dons
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PHILOSOPHIE DE RÉPARATION ET CIRCULARITÉ
     ========================================================================== -->
<section class="container-fluid px-lg-5 mb-5" id="reparation">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <span class="tech-kicker">ATELIER DE RÉPARABILITÉ ACTIVE</span>
            <h2 class="fw-bold mb-3">Si ce n'est pas réparable, nous ne le fabriquons pas</h2>
            <p class="text-secondary">
                Chaque pièce de nos sacs à dos est conçue pour être démontée à l'aide d'outils standards ou via des coutures d'accès direct. Nous bannissons les colles toxiques irréversibles et les boucles plastiques propriétaires introuvables.
            </p>
            <ul class="list-unstyled">
                <li class="d-flex align-items-start gap-2 mb-2 text-secondary">
                    <i class="bi bi-check-circle-fill text-amber mt-1"></i>
                    <span>Remplacement sans frais à vie des boucles endommagées par le gel extrême.</span>
                </li>
                <li class="d-flex align-items-start gap-2 mb-2 text-secondary">
                    <i class="bi bi-check-circle-fill text-amber mt-1"></i>
                    <span>Thermosoudage des déchirures de roche ou de crampon en moins de 72 heures ouvrées.</span>
                </li>
                <li class="d-flex align-items-start gap-2 text-secondary">
                    <i class="bi bi-check-circle-fill text-amber mt-1"></i>
                    <span>Programme de rachat d'équipement usagé pour reconditionnement (Version 2).</span>
                </li>
            </ul>
        </div>
        <div class="col-lg-6">
            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25">
                <img src="https://images.unsplash.com/photo-1547949003-9792a18a2601?auto=format&fit=crop&w=800&q=80" 
                     alt="Atelier de réparation Vertex" class="img-fluid rounded mb-3">
                <div class="small tech-mono text-muted text-center">
                    ATELIER CENTRAL // CHAMONIX-MONT-BLANC // POSTES DE THERMOSOUDAGE LASER
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
