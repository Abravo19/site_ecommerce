<?php
/**
 * VERTEX EXPEDITION - Page d'Inscription (inscription.php)
 * V1 : Maquettage graphique soigné du formulaire (non fonctionnel par directive)
 */
$current_page = 'inscription';
$page_title = 'Créer un compte | VERTEX EXPEDITION';
$page_description = 'Créez votre compte VERTEX pour enregistrer votre matériel, suivre vos commandes et bénéficier de notre service de garantie.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- EN-TÊTE DE LA PAGE -->
<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <span class="tech-kicker">ESPACE CLIENT</span>
        <h1 class="fw-bold mb-2">Créer un compte</h1>
        <p class="text-secondary fs-5 mb-0" style="max-width: 720px;">
            Enregistrez votre équipement, bénéficiez de la garantie fabricant et suivez vos commandes en toute simplicité.
        </p>
    </div>
</div>

<!-- FORMULAIRE GRAPHIQUE D'INSCRIPTION -->
<div class="container-fluid px-lg-5 pb-5">
    <div class="row g-5">
        <!-- Formulaire Graphique -->
        <div class="col-lg-7">
            <div class="tech-form-card">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                    <div>
                        <h2 class="fs-4 fw-bold mb-1">Nouveau compte</h2>
                        <span class="small tech-mono text-muted">REJOIGNEZ LA COMMUNAUTÉ VERTEX</span>
                    </div>
                </div>

                <form id="inscriptionFormDemo" onsubmit="event.preventDefault(); alert('Merci ! Votre compte a été créé avec succès. (Démonstration V1)');">
                    <div class="row g-3">
                        <!-- Nom et Prénom -->
                        <div class="col-md-6">
                            <label for="regFullName" class="form-label-tech">
                                <i class="bi bi-person-badge-fill text-amber me-1"></i> Nom et Prénom *
                            </label>
                            <input type="text" id="regFullName" class="form-control-tech" placeholder="Ex. Marc Soler" required>
                        </div>

                        <!-- Indicatif / Pseudo -->
                        <div class="col-md-6">
                            <label for="regCallsign" class="form-label-tech">
                                <i class="bi bi-person-gear text-amber me-1"></i> Pseudo (optionnel)
                            </label>
                            <input type="text" id="regCallsign" class="form-control-tech" placeholder="Ex. Marc_Alpinist">
                        </div>

                        <!-- E-mail -->
                        <div class="col-12">
                            <label for="regEmail" class="form-label-tech">
                                <i class="bi bi-envelope-check-fill text-amber me-1"></i> Adresse E-mail *
                            </label>
                            <input type="email" id="regEmail" class="form-control-tech" placeholder="votre-email@exemple.com" required>
                        </div>

                        <!-- Discipline Principale -->
                        <div class="col-12">
                            <label for="regDiscipline" class="form-label-tech">
                                <i class="bi bi-compass-fill text-amber me-1"></i> Pratique principale *
                            </label>
                            <select id="regDiscipline" class="form-select-tech text-secondary" required>
                                <option value="" selected disabled>Sélectionnez votre pratique...</option>
                                <option value="alpinisme">Alpinisme & Haute Montagne</option>
                                <option value="fastpacking">Fastpacking, Trail & Randonnée rapide</option>
                                <option value="expedition">Expéditions & Trekking engagé</option>
                                <option value="viaje">Voyage & Aventure en autonomie</option>
                                <option value="vivac">Bivouac & Camp d'altitude</option>
                            </select>
                        </div>

                        <!-- Mot de Passe -->
                        <div class="col-md-6">
                            <label for="regPass" class="form-label-tech">
                                <i class="bi bi-lock-fill text-amber me-1"></i> Mot de Passe *
                            </label>
                            <input type="password" id="regPass" class="form-control-tech" placeholder="8 caractères minimum" required>
                        </div>

                        <!-- Confirmation Mot de Passe -->
                        <div class="col-md-6">
                            <label for="regPassConfirm" class="form-label-tech">
                                <i class="bi bi-shield-lock-fill text-amber me-1"></i> Confirmer le Mot de Passe *
                            </label>
                            <input type="password" id="regPassConfirm" class="form-control-tech" placeholder="Répétez le mot de passe" required>
                        </div>

                        <!-- Checkboxes de Consentement -->
                        <div class="col-12">
                            <div class="form-check form-check-tech mb-2">
                                <input class="form-check-input" type="checkbox" id="regConsentSafety" checked>
                                <label class="form-check-label" for="regConsentSafety">
                                    Je souhaite recevoir les actualités et informations sur les produits.
                                </label>
                            </div>

                            <div class="form-check form-check-tech">
                                <input class="form-check-input" type="checkbox" id="regConsentTerms" required>
                                <label class="form-check-label" for="regConsentTerms">
                                    J'ai pris connaissance et j'accepte les <a href="#" class="text-amber">Conditions Générales d'Utilisation</a> et la <a href="#" class="text-amber">Politique de Confidentialité</a>.
                                </label>
                            </div>
                        </div>

                        <!-- Bouton d'Inscription -->
                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-vertex-primary w-100 justify-content-center py-3">
                                <i class="bi bi-person-check-fill me-2"></i> Créer mon compte
                            </button>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <span class="small text-muted">Vous disposez déjà d'un compte ? </span>
                            <a href="#" class="small text-amber text-decoration-none fw-bold" onclick="alert('Module de Connexion planifié pour la Version 2.');">Se Connecter</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Colonne Droite : Privilèges du compte -->
        <div class="col-lg-5">
            <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 mb-4">
                <span class="tech-kicker">AVANTAGES CLIENT</span>
                <h3 class="fs-5 fw-bold mb-3">Pourquoi créer un compte ?</h3>

                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-start gap-3 mb-3">
                        <div class="p-2 bg-black rounded border border-secondary border-opacity-25 text-amber">
                            <i class="bi bi-shield-fill-check fs-5"></i>
                        </div>
                        <div>
                            <strong class="text-white d-block small">Enregistrement de votre Matériel</strong>
                            <p class="small text-secondary mb-0">
                                Associez votre sac à dos à votre profil pour faciliter les démarches de garantie et de réparation.
                            </p>
                        </div>
                    </li>

                    <li class="d-flex align-items-start gap-3 mb-3">
                        <div class="p-2 bg-black rounded border border-secondary border-opacity-25 text-success">
                            <i class="bi bi-tools fs-5"></i>
                        </div>
                        <div>
                            <strong class="text-white d-block small">Service Réparation & Entretien</strong>
                            <p class="small text-secondary mb-0">
                                Prise en charge rapide en atelier pour le remplacement de boucles, le recollage ou les réglages sur mesure.
                            </p>
                        </div>
                    </li>

                    <li class="d-flex align-items-start gap-3">
                        <div class="p-2 bg-black rounded border border-secondary border-opacity-25 text-info">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                        <div>
                            <strong class="text-white d-block small">Accès aux Séries Limitées</strong>
                            <p class="small text-secondary mb-0">
                                Notification prioritaire lors du lancement de nouvelles séries et de tirages en matières techniques exclusives.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="p-4 bg-dark rounded border border-warning border-opacity-25 text-center">
                <i class="bi bi-award-fill text-warning fs-1 mb-2 d-block"></i>
                <h5 class="fw-bold mb-1">Garantie Fabricant Incluse</h5>
                <p class="small text-secondary mb-0">
                    Chaque sac VERTEX est conçu pour durer et réparable dans notre atelier de Chamonix.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
