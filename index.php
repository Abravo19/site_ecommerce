<?php
/**
 * VERTEX EXPEDITION - Page d'Accueil (index.php)
 * Présentation de la marque, innovations alpines et produits emblématiques
 */
require_once __DIR__ . '/data/produits.php';

$current_page = 'accueil';
$page_title = 'VERTEX EXPEDITION | Équipement Outdoor, Sacs à Dos et Matériel de Voyage';
$page_description = 'Sacs à dos ergonomiques à charge active, systèmes ultralégers ripstop et matériel de précision testé à -35°C dans le Mont-Blanc.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- ==========================================================================
     SECTION HERO
     ========================================================================== -->
<section class="hero-section">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center gy-5">
            <!-- Colonne Gauche : Présentation et Spécifications -->
            <div class="col-lg-7">
                <div class="hero-pill">
                    <i class="bi bi-shield-shaded me-1"></i> COLLECTION ALPINE 2026
                </div>
                <h1 class="hero-title">
                    Équipement sans compromis pour terrain hostile
                </h1>
                <p class="hero-lead">
                    Sacs à dos ergonomiques à charge active, systèmes modulaires ripstop ultralégers et matériel de précision testés pour supporter les exigences les plus extrêmes en haute montagne et expéditions polaires.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="produits.php" class="btn btn-vertex-primary">
                        Explorer les Sacs Pro <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <a href="#volume" class="btn btn-vertex-outline">
                        <i class="bi bi-sliders me-1"></i> Guide des Litrages & Réglage
                    </a>
                </div>

                <!-- Spécifications Techniques du Hero -->
                <div class="hero-specs-row">
                    <div class="hero-spec-item">
                        <span class="spec-label">TISSU PRINCIPAL</span>
                        <span class="spec-value text-amber">500D CORDURA® RIPSTOP</span>
                        <span class="small text-muted" style="font-size: 0.68rem;">100% Résistance Anti-abrasion</span>
                    </div>
                    <div class="hero-spec-item">
                        <span class="spec-label">POLITIQUE CIRCULAIRE</span>
                        <span class="spec-value text-white">GARANTIE À VIE</span>
                        <span class="small text-muted" style="font-size: 0.68rem;">Atelier de Réparation Arctique</span>
                    </div>
                    <div class="hero-spec-item">
                        <span class="spec-label">OPTIMISATION GRAMME</span>
                        <span class="spec-value text-success">POIDS MOYEN &lt;950g</span>
                        <span class="small text-muted" style="font-size: 0.68rem;">100% Répartition Anatomique</span>
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
                            <div class="hero-card-meta">SAC D'EXPÉDITION</div>
                            <h3 class="hero-card-title"><?php echo htmlspecialchars($featuredProduct['name']); ?></h3>
                            <div class="text-success small tech-mono">
                                <i class="bi bi-check2-circle me-1"></i> TEST VALIDÉ : GROENLAND (-35°C)
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

<!-- ==========================================================================
     CATÉGORIES TECHNIQUES SPÉCIALISÉES (01, 02, 03, 04)
     ========================================================================== -->
<section class="categories-section">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-4">
            <div>
                <span class="tech-kicker">SEGMENTATION DU MATÉRIEL</span>
                <h2 class="fw-bold mb-0">Catégories Techniques Spécialisées</h2>
            </div>
            <p class="text-muted small mb-0 mt-2 mt-md-0" style="max-width: 440px;">
                Équipement structuré selon le litrage, l'ergonomie de portage, la résistance aux températures polaires et la répartition du poids en passages alpins exposés.
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
                            Châssis rigide en aluminium 7075 et charge active pour les traversées de plus de 7 jours en autonomie totale.
                        </p>
                    </div>
                    <a href="produits.php?cat=expedition" class="category-link">
                        EXPLORER EXPÉDITION <i class="bi bi-arrow-right"></i>
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
                            Ajustement anatomique type gilet, sans rebond vertical. Confection en Dyneema® imperméable haute ténacité.
                        </p>
                    </div>
                    <a href="produits.php?cat=fastpacking" class="category-link">
                        EXPLORER ULTRALÉGER <i class="bi bi-arrow-right"></i>
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
                        <h3 class="category-title">Sacs Duffel Hermétiques</h3>
                        <p class="category-desc">
                            Toile TPU 840D soudée haute fréquence. Protection absolue contre l'eau, le blizzard, la boue et la poussière.
                        </p>
                    </div>
                    <a href="produits.php?cat=voyage" class="category-link">
                        EXPLORER CHARGE LOURDE <i class="bi bi-arrow-right"></i>
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
                            Tentes d'assaut et abris bivouac techniques ultralégers de moins de 1 kg pour les nuits engagées sur vire.
                        </p>
                    </div>
                    <a href="produits.php?cat=refuge" class="category-link">
                        EXPLORER BIVOUAC <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PRODUITS PHARE (SACS À DOS HAUTE PERFORMANCE)
     ========================================================================== -->
<section class="products-section">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <span class="tech-kicker">MATÉRIEL PRINCIPAL</span>
                <h2 class="fw-bold mb-0">Sacs à Dos de Haute Performance</h2>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="produits.php" class="btn btn-vertex-outline btn-sm-tech">
                    Voir le Catalogue Complet (5) <i class="bi bi-arrow-right ms-1"></i>
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
                                <span class="spec-cell-label">POIDS TECHNIQUE</span>
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
                                <i class="bi bi-cart-plus me-1"></i> Ajouter à l'Équipement
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INGÉNIERIE ANATOMIQUE ET RÉSISTANCE EXTRÊME
     ========================================================================== -->
<section class="engineering-section">
    <div class="container-fluid px-lg-5">
        <div class="text-center mb-5">
            <span class="tech-kicker">ÉTUDE DES MATÉRIAUX ET BIOMÉCANIQUE</span>
            <h2 class="fw-bold">Ingénierie Anatomique et Résistance Extrême</h2>
            <p class="text-secondary mx-auto" style="max-width: 650px;">
                Chaque couture est thermo-tensionnée pour supporter des tractions supérieures à 150 N/mm². Nous développons des solutions de durabilité active conformes aux normes alpines internationales.
            </p>
        </div>

        <div class="schematic-box">
            <div class="row align-items-center g-4">
                <!-- Colonne Gauche : Callouts 01 et 02 -->
                <div class="col-lg-3">
                    <div class="schematic-callout">
                        <div class="callout-num">CHÂSSIS</div>
                        <h4 class="callout-title">Châssis en Aluminium 7075</h4>
                        <p class="callout-desc">Exosquelette anatomique à flexion torsionnelle active qui transfère 85% de la charge vers les hanches.</p>
                    </div>

                    <div class="schematic-callout">
                        <div class="callout-num">RESPIRABILITÉ</div>
                        <h4 class="callout-title">Panneau Dorsal AirMesh 3D</h4>
                        <p class="callout-desc">Canaux thermo-convectifs de ventilation réduisant la sudation dorsale de 28% pendant les ascensions soutenues.</p>
                    </div>
                </div>

                <!-- Centre : Diagramme Technique -->
                <div class="col-lg-6 text-center">
                    <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 position-relative">
                        <span class="badge badge-amber position-absolute top-0 start-50 translate-middle tech-mono">
                            SCHÉMA BIOMÉCANIQUE
                        </span>
                        <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=700&q=80" 
                             alt="Éclaté Technique Vertex" class="img-fluid rounded my-3" style="max-height: 320px; object-fit: contain;">
                        
                        <div class="row g-2 pt-3 border-top border-secondary border-opacity-25">
                            <div class="col-6">
                                <div class="tech-mono text-amber fw-bold fs-4">35.000</div>
                                <div class="small text-muted" style="font-size: 0.7rem;">CYCLES MARTINDALE ABRASION</div>
                            </div>
                            <div class="col-6">
                                <div class="tech-mono text-info fw-bold fs-4">0%</div>
                                <div class="small text-muted" style="font-size: 0.7rem;">ABSORPTION D'EAU MEMBRANE</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne Droite : Callouts 03 et 04 -->
                <div class="col-lg-3">
                    <div class="schematic-callout">
                        <div class="callout-num">SUSPENSION</div>
                        <h4 class="callout-title">Ceinture Lombaire Pivotante</h4>
                        <p class="callout-desc">Accompagne la cadence naturelle en marche avec crampons ou skis, éliminant les points de friction latérale.</p>
                    </div>

                    <div class="schematic-callout">
                        <div class="callout-num">RÉSISTANCE AU FROID</div>
                        <h4 class="callout-title">Boucles Duraflex® Anti-Gel</h4>
                        <p class="callout-desc">Polymère formulé pour ne pas casser jusqu'à -45°C. Manipulables avec des moufles d'expédition polaire.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     MATRICE DE VOLUME ("De quel volume avez-vous besoin ?")
     ========================================================================== -->
<section class="volume-matrix-section" id="volume">
    <div class="container-fluid px-lg-5">
        <div class="text-center mb-5">
            <span class="tech-kicker">MATRICE DE VOLUME ET AUTONOMIE</span>
            <h2 class="fw-bold">De quel volume avez-vous besoin pour votre prochaine expédition ?</h2>
            <p class="text-secondary mx-auto" style="max-width: 600px;">
                Déterminez la capacité idéale en fonction de la durée du périple, de l'isolation thermique requise et du degré d'autosuffisance.
            </p>
        </div>

        <div class="row g-4">
            <!-- 15 - 30 L -->
            <div class="col-lg-3 col-md-6">
                <div class="matrix-card" data-filter="fastpacking">
                    <div>
                        <div class="matrix-liters">15 — 30 L</div>
                        <div class="matrix-duration">Journée / Fast-Trail / Via Ferrata</div>
                        <p class="small text-secondary mb-3">Sorties non-stop d'une journée. Priorité à l'aérodynamisme, la légèreté extrême et le maintien au torse.</p>
                        <ul class="matrix-checklist">
                            <li><i class="bi bi-check2"></i> Coupe-vent et couche thermique</li>
                            <li><i class="bi bi-check2"></i> Poche à eau d'hydratation 2L</li>
                            <li><i class="bi bi-check2"></i> Trousse de secours et lampe frontale</li>
                        </ul>
                    </div>
                    <div class="matrix-recommendation">
                        MODÈLE SUGGÉRÉ :
                        <strong>CHRONO 25L ULTRALIGHT</strong>
                    </div>
                </div>
            </div>

            <!-- 35 - 50 L -->
            <div class="col-lg-3 col-md-6">
                <div class="matrix-card" data-filter="voyage">
                    <div>
                        <div class="matrix-liters">35 — 50 L</div>
                        <div class="matrix-duration">Week-end / Refuge Alpin</div>
                        <p class="small text-secondary mb-3">Traversées de 2 à 3 jours avec nuitée en refuge gardé ou bivouac estival ultraléger.</p>
                        <ul class="matrix-checklist">
                            <li><i class="bi bi-check2"></i> Vêtements de rechange et nécessaire</li>
                            <li><i class="bi bi-check2"></i> Réchaud et vivres pour 2 jours</li>
                            <li><i class="bi bi-check2"></i> Drap de sac ou sac de bivouac</li>
                        </ul>
                    </div>
                    <div class="matrix-recommendation">
                        MODÈLE SUGGÉRÉ :
                        <strong>BORA DUFFEL OU FAST-PACK 40L</strong>
                    </div>
                </div>
            </div>

            <!-- 60 - 75 L (Le plus populaire) -->
            <div class="col-lg-3 col-md-6">
                <div class="matrix-card featured-matrix" data-filter="expedition">
                    <div>
                        <span class="badge badge-amber mb-2 tech-mono">LE PLUS POPULAIRE</span>
                        <div class="matrix-liters text-amber">60 — 75 L</div>
                        <div class="matrix-duration">Traversée Alpine de 4 à 7 Jours</div>
                        <p class="small text-secondary mb-3">Autonomie complète en haute montagne avec tente, réchaud et matériel technique glaciaire.</p>
                        <ul class="matrix-checklist">
                            <li><i class="bi bi-check2 text-amber"></i> Tente, duvet -10°C et matelas</li>
                            <li><i class="bi bi-check2 text-amber"></i> Crampons, baudrier et piolet</li>
                            <li><i class="bi bi-check2 text-amber"></i> Charge recommandée : 14 à 22 kg</li>
                        </ul>
                    </div>
                    <div class="matrix-recommendation">
                        MODÈLE SUGGÉRÉ :
                        <strong class="text-amber">VERTEX APEX 65L PRO</strong>
                    </div>
                </div>
            </div>

            <!-- 80 - 110 L -->
            <div class="col-lg-3 col-md-6">
                <div class="matrix-card" data-filter="expedition">
                    <div>
                        <div class="matrix-liters">80 — 110 L</div>
                        <div class="matrix-duration">Grande Expédition & Camp de Base</div>
                        <p class="small text-secondary mb-3">Expéditions polaires et sommets majeurs. Conçu pour le portage de charges lourdes et traction de traîneau.</p>
                        <ul class="matrix-checklist">
                            <li><i class="bi bi-check2"></i> Sac de couchage grand froid polaire</li>
                            <li><i class="bi bi-check2"></i> Ravitaillement pour 10 à 20 jours</li>
                            <li><i class="bi bi-check2"></i> Charge recommandée : jusqu'à 35 kg</li>
                        </ul>
                    </div>
                    <div class="matrix-recommendation">
                        MODÈLE SUGGÉRÉ :
                        <strong>SERAC EXPEDITION 85+10</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     RETOURS D'EXPÉRIENCE DEPUIS LES GLACIERS
     ========================================================================== -->
<section class="py-5">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <span class="tech-kicker">RAPPORTS DE TERRAIN</span>
                <h2 class="fw-bold mb-0">Retours d'Expérience depuis les Glaciers</h2>
            </div>
            <div class="small tech-mono text-muted mt-2 mt-md-0">
                SITES D'ESSAIS : MASSIF DU MONT-BLANC, PATAGONIE DU SUD
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80" 
                             alt="Marc Soler" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                        <div>
                            <h5 class="mb-0 fs-6 fw-bold">Marc Soler</h5>
                            <span class="tech-mono text-amber small">Guide UIAGM - Chamonix</span>
                        </div>
                    </div>
                    <p class="small text-secondary mb-0">
                        "La répartition du poids de l'Apex 65L est remarquable. Pendant 6 jours sur l'éperon Frendo, le panneau dorsal a évité l'accumulation d'humidité et le tissu Cordura a résisté aux frottements répétés contre le granite abrasif sans aucune déchirure."
                    </p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80" 
                             alt="Elena Santoro" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                        <div>
                            <h5 class="mb-0 fs-6 fw-bold">Elena Santoro</h5>
                            <span class="tech-mono text-success small">Athlète Ultra-Trail - Dolomites</span>
                        </div>
                    </div>
                    <p class="small text-secondary mb-0">
                        "Avec le Chrono 25L en Dyneema, j'ai gagné près de 500 grammes en course par rapport à mon ancien sac. Zéro ballottement dans les descentes pierreuses et les flasques restent parfaitement accessibles."
                    </p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80" 
                             alt="Dr. Henrik Lind" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                        <div>
                            <h5 class="mb-0 fs-6 fw-bold">Dr. Henrik Lind</h5>
                            <span class="tech-mono text-info small">Géophysicien Polaire - Svalbard Camp</span>
                        </div>
                    </div>
                    <p class="small text-secondary mb-0">
                        "Les boucles Duraflex anti-gel tiennent parole : à -38°C dans le fjord de Van Keulen, d'autres boucles cèdent sous l'impact. Le Serac 85 a traversé deux semaines de blizzard arctique sans rupture de fermeture."
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     DURABILITÉ, CIRCULARITÉ ET ATELIER DE RÉPARATION
     ========================================================================== -->
<section class="container-fluid px-lg-5">
    <div class="durability-banner">
        <div class="row align-items-center gy-4">
            <div class="col-lg-8">
                <span class="tech-kicker text-warning">ENGAGEMENT DE CIRCULARITÉ TOTALE</span>
                <h2 class="fw-bold mb-3">
                    Conçu pour durer toute une vie. En cas de bris en expédition, nous réparons sans frais.
                </h2>
                <p class="text-secondary mb-4" style="max-width: 680px;">
                    Nous refusons l'obsolescence programmée. Notre atelier de réparation à Chamonix restaure les déchirures, thermo-soude les zips étanches et remplace les tiges en aluminium pour que votre sac VERTEX vous accompagne pendant des décennies.
                </p>
                <div class="d-flex flex-wrap gap-4 pt-2">
                    <div class="d-flex align-items-center gap-2 small tech-mono text-white">
                        <i class="bi bi-shield-check text-success fs-5"></i> GARANTIE À VIE
                    </div>
                    <div class="d-flex align-items-center gap-2 small tech-mono text-white">
                        <i class="bi bi-recycle text-amber fs-5"></i> 100% TISSUS RÉCUPÉRABLES
                    </div>
                    <div class="d-flex align-items-center gap-2 small tech-mono text-white">
                        <i class="bi bi-heart-pulse text-info fs-5"></i> ATELIER ARCTIQUE PERMANENT
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-center">
                <div class="durability-stat-box">
                    <div class="small tech-mono text-muted mb-1">MÉTRIQUE DE RÉPARABILITÉ 2024</div>
                    <div class="durability-number">94.8%</div>
                    <p class="small text-secondary mb-3">Des équipements retournés à l'atelier ont été remis en service actif chez leurs propriétaires en moins de 10 jours ouvrés.</p>
                    <a href="qui-sommes-nous.php#reparation" class="btn btn-vertex-outline btn-sm-tech w-100">
                        Découvrir le Protocole de Réparation
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
