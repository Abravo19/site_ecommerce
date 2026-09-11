<?php

$current_page = 'contact';
$page_title = 'Contact & Support | VERTEX EXPEDITION';
$page_description = 'Contactez l\'équipe VERTEX EXPEDITION pour toute question sur nos sacs à dos, le choix du matériel ou le service de réparation.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <span class="tech-kicker">CONTACT & ASSISTANCE</span>
        <h1 class="fw-bold mb-2">Contactez notre équipe</h1>
        <p class="text-secondary fs-5 mb-0" style="max-width: 700px;">
            Une question sur un modèle, le choix du litrage ou notre service de réparation ? Notre équipe basée à Chamonix vous répond du lundi au vendredi.
        </p>
    </div>
</div>

<div class="container-fluid px-lg-5 pb-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <div class="tech-form-card">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                    <div>
                        <h2 class="fs-4 fw-bold mb-1">Formulaire de Contact</h2>
                        <span class="small tech-mono text-muted">RÉPONSE SOUS 24H À 48H</span>
                    </div>
                </div>

                <form id="contactFormDemo" onsubmit="event.preventDefault(); alert('Merci pour votre message ! Ce formulaire est une démonstration V1.');">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contactName" class="form-label-tech">
                                <i class="bi bi-person-fill text-amber me-1"></i> Nom et Prénom *
                            </label>
                            <input type="text" id="contactName" class="form-control-tech" placeholder="Ex. Marc Soler" required>
                        </div>

                        <div class="col-md-6">
                            <label for="contactEmail" class="form-label-tech">
                                <i class="bi bi-envelope-at-fill text-amber me-1"></i> Adresse E-mail *
                            </label>
                            <input type="email" id="contactEmail" class="form-control-tech" placeholder="nom@exemple.com" required>
                        </div>

                        <div class="col-md-6">
                            <label for="contactPhone" class="form-label-tech">
                                <i class="bi bi-telephone-fill text-amber me-1"></i> Téléphone (optionnel)
                            </label>
                            <input type="tel" id="contactPhone" class="form-control-tech" placeholder="+33 6 00 00 00 00">
                        </div>

                        <div class="col-md-6">
                            <label for="contactSubject" class="form-label-tech">
                                <i class="bi bi-tag-fill text-amber me-1"></i> Objet de la Demande *
                            </label>
                            <select id="contactSubject" class="form-select-tech text-secondary" required>
                                <option value="" selected disabled>Sélectionnez le sujet...</option>
                                <option value="litrage">Conseil sur le choix du sac et le litrage</option>
                                <option value="reparacion">Atelier de réparation & garantie</option>
                                <option value="pedido">Suivi de commande</option>
                                <option value="otro">Autre demande</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="contactMessage" class="form-label-tech">
                                <i class="bi bi-chat-left-text-fill text-amber me-1"></i> Votre message *
                            </label>
                            <textarea id="contactMessage" class="form-control-tech" rows="5" placeholder="Décrivez votre besoin, votre pratique ou votre demande de réparation..." required></textarea>
                        </div>

                        <!-- Consentement -->
                        <div class="col-12">
                            <div class="form-check form-check-tech">
                                <input class="form-check-input" type="checkbox" id="contactTerms" required>
                                <label class="form-check-label" for="contactTerms">
                                    J'accepte que mes données soient utilisées pour traiter ma demande.
                                </label>
                            </div>
                        </div>

                        <!-- Bouton d'Envoi -->
                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-vertex-primary w-100 justify-content-center py-3">
                                <i class="bi bi-send-fill me-2"></i> Envoyer le message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 mb-4">
                <span class="tech-kicker">COORDONNÉES</span>
                <h3 class="fs-5 fw-bold mb-3">Atelier & Siège</h3>
                
                <div class="mb-3 d-flex gap-3">
                    <i class="bi bi-geo-alt-fill text-amber fs-4"></i>
                    <div class="small">
                        <strong class="text-white d-block">Atelier Chamonix :</strong>
                        <span class="text-secondary">Route des Pècles 142, 74400 Chamonix-Mont-Blanc, France</span>
                    </div>
                </div>

                <div class="mb-3 d-flex gap-3">
                    <i class="bi bi-headset text-amber fs-4"></i>
                    <div class="small">
                        <strong class="text-white d-block">Téléphone :</strong>
                        <span class="text-secondary">+33 4 50 99 88 77 (Du lundi au vendredi, 09:00 - 18:00)</span>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <i class="bi bi-envelope-paper-fill text-amber fs-4"></i>
                    <div class="small">
                        <strong class="text-white d-block">E-mail :</strong>
                        <span class="text-secondary">contact@vertex-expedition.com</span>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="tech-mono small text-muted">DÉLAI DE RÉPONSE HABITUEL :</span>
                    <span class="badge badge-emerald">&lt; 24 HEURES</span>
                </div>
                <p class="small text-secondary mb-0">
                    Nos conseillers et techniciens traitent chaque demande avec attention pour vous orienter vers l'équipement le plus adapté à votre projet.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
