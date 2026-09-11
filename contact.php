<?php

$current_page = 'contact';
$page_title = 'Canal de Contact et Télémétrie | VERTEX EXPEDITION';
$page_description = 'Contactez l\'équipe de support technique, conseil de litrage et atelier de réparation de VERTEX EXPEDITION.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <span class="tech-kicker">COMMUNICATION TECHNIQUE // CANAL DIRECT</span>
        <h1 class="fw-bold mb-2">Canal de Télémétrie et Support Base</h1>
        <p class="text-secondary fs-5 mb-0" style="max-width: 700px;">
            Des interrogations sur le litrage adapté à votre traversée ou besoin d'activer la garantie à vie en atelier ? Échangez directement avec nos ingénieurs et guides.
        </p>
    </div>
</div>

<div class="container-fluid px-lg-5 pb-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <div class="tech-form-card">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                    <div>
                        <h2 class="fs-4 fw-bold mb-1">Formulaire de Communication Technique</h2>
                        <span class="small tech-mono text-muted">TRANSMISSION SÉCURISÉE CHIFFRÉE // CANAL T-01</span>
                    </div>
                    <span class="badge badge-amber tech-mono">MAQUETTE V1</span>
                </div>

                <form id="contactFormDemo" onsubmit="event.preventDefault(); alert('Note V1 : Ce formulaire a été fidèlement maquetté graphiquement. L\'envoi serveur sera connecté dans la Version 2.');">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contactName" class="form-label-tech">
                                <i class="bi bi-person-fill text-amber me-1"></i> Nom et Prénom *
                            </label>
                            <input type="text" id="contactName" class="form-control-tech" placeholder="Ex. Marc Soler" required>
                        </div>

                        <div class="col-md-6">
                            <label for="contactEmail" class="form-label-tech">
                                <i class="bi bi-envelope-at-fill text-amber me-1"></i> Adresse E-mail / Canal *
                            </label>
                            <input type="email" id="contactEmail" class="form-control-tech" placeholder="nom@expedition.com" required>
                        </div>

                        <div class="col-md-6">
                            <label for="contactPhone" class="form-label-tech">
                                <i class="bi bi-telephone-fill text-amber me-1"></i> Téléphone Portable / Satellite
                            </label>
                            <input type="tel" id="contactPhone" class="form-control-tech" placeholder="+33 6 00 00 00 00">
                        </div>

                        <div class="col-md-6">
                            <label for="contactSubject" class="form-label-tech">
                                <i class="bi bi-tag-fill text-amber me-1"></i> Objet de la Demande *
                            </label>
                            <select id="contactSubject" class="form-select-tech text-secondary" required>
                                <option value="" selected disabled>Sélectionnez le sujet...</option>
                                <option value="litrage">Conseil de Litrage et Réglage Dorsal</option>
                                <option value="reparacion">Atelier de Réparation & Garantie à Vie</option>
                                <option value="pedido">Suivi de Commande d'Expédition</option>
                                <option value="otro">Autres questions techniques</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="contactMessage" class="form-label-tech">
                                <i class="bi bi-chat-left-text-fill text-amber me-1"></i> Détails de la Demande ou de l'Itinéraire *
                            </label>
                            <textarea id="contactMessage" class="form-control-tech" rows="5" placeholder="Indiquez l'altitude, la durée du raid ou l'anomalie constatée sur votre matériel..." required></textarea>
                        </div>

                        <!-- Consentement -->
                        <div class="col-12">
                            <div class="form-check form-check-tech">
                                <input class="form-check-input" type="checkbox" id="contactTerms" required>
                                <label class="form-check-label" for="contactTerms">
                                    J'accepte le traitement de mes données dans le cadre de la réponse technique de l'expédition.
                                </label>
                            </div>
                        </div>

                        <!-- Bouton d'Envoi -->
                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-vertex-primary w-100 justify-content-center py-3">
                                <i class="bi bi-send-fill me-2"></i> Émettre le Message vers la Base Centrale
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Colonne Droite : Informations du Camp de Base -->
        <div class="col-lg-5">
            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 mb-4">
                <span class="tech-kicker">COORDONNÉES ET BASE D'APPUI</span>
                <h3 class="fs-5 fw-bold mb-3">Centre des Opérations Alpines</h3>
                
                <div class="mb-3 d-flex gap-3">
                    <i class="bi bi-geo-alt-fill text-amber fs-4"></i>
                    <div class="small">
                        <strong class="text-white d-block">Base Centrale Chamonix :</strong>
                        <span class="text-secondary">Route des Pècles 142, 74400 Chamonix-Mont-Blanc, France</span>
                        <div class="tech-mono text-muted mt-1">GPS : 45°55'21"N 6°52'08"E</div>
                    </div>
                </div>

                <div class="mb-3 d-flex gap-3">
                    <i class="bi bi-headset text-amber fs-4"></i>
                    <div class="small">
                        <strong class="text-white d-block">Ligne de Liaison Directe :</strong>
                        <span class="text-secondary">+33 4 50 99 88 77 (Du lundi au samedi, 08:00 - 18:00)</span>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <i class="bi bi-envelope-paper-fill text-amber fs-4"></i>
                    <div class="small">
                        <strong class="text-white d-block">Fréquence Numérique :</strong>
                        <span class="text-secondary">base@vertex-expedition.lab</span>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="tech-mono small text-muted">DÉLAI ESTIMÉ DE RÉPONSE :</span>
                    <span class="badge badge-emerald">&lt; 4 HEURES</span>
                </div>
                <p class="small text-secondary mb-0">
                    Les messages transmis lors des alertes météo orageuses sur le massif du Mont-Blanc sont priorisés selon l'engagement des montagnards en progression.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
