<?php
require_once __DIR__ . '/config/functions.php';   // session AVANT toute sortie HTML
require_once __DIR__ . '/config/db.php';

$current_page = 'contact';
$page_title = 'Contact & Support | VERTEX EXPEDITION';
$page_description = 'Contactez l\'équipe VERTEX EXPEDITION pour toute question sur nos sacs à dos, le choix du matériel ou le service de réparation.';

$labels_sujet = [
    'litrage'    => 'Conseil sur le choix du sac et le litrage',
    'reparacion' => 'Atelier de réparation & garantie',
    'pedido'     => 'Suivi de commande',
    'otro'       => 'Autre demande',
];

$errors = [];
$envoye = false;
$data = ['nom_complet' => '', 'email' => '', 'telephone' => '', 'sujet' => '', 'message' => '', 'consentement' => false];

// Une seule page pour le formulaire ET son traitement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['nom_complet']  = trim($_POST['nom_complet'] ?? '');
    $data['email']        = trim($_POST['email'] ?? '');
    $data['telephone']    = trim($_POST['telephone'] ?? '');
    $data['sujet']        = $_POST['sujet'] ?? '';
    $data['message']      = trim($_POST['message'] ?? '');
    $data['consentement'] = isset($_POST['consentement']);

    if (!csrfCheck($_POST['csrf'] ?? null)) {
        $errors[] = 'Votre session a expiré. Merci de réessayer.';
    }
    if ($data['nom_complet'] === '') {
        $errors[] = 'Le nom et le prénom sont obligatoires.';
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse e-mail invalide.';
    }
    if (!isset($labels_sujet[$data['sujet']])) {
        $errors[] = 'Veuillez choisir l\'objet de votre demande.';
    }
    if ($data['message'] === '') {
        $errors[] = 'Le message est obligatoire.';
    }
    if (!$data['consentement']) {
        $errors[] = 'Vous devez accepter le traitement de vos données.';
    }

    $envoye = empty($errors);
}

require_once __DIR__ . '/config/header.php';
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

                <?php if ($envoye): ?>
                    <div class="p-4 bg-dark rounded border border-success border-opacity-50">
                        <div class="text-center mb-3">
                            <i class="bi bi-check-circle-fill text-success fs-1 mb-2 d-block"></i>
                            <h3 class="fw-bold mb-1">Message reçu</h3>
                            <p class="text-secondary small mb-0">Voici les informations que vous avez envoyées :</p>
                        </div>
                        <ul class="list-unstyled small mb-3">
                            <li class="mb-2"><strong class="text-white">Nom et prénom :</strong> <span class="text-secondary"><?php echo e($data['nom_complet']); ?></span></li>
                            <li class="mb-2"><strong class="text-white">E-mail :</strong> <span class="text-secondary"><?php echo e($data['email']); ?></span></li>
                            <li class="mb-2"><strong class="text-white">Téléphone :</strong> <span class="text-secondary"><?php echo e($data['telephone'] !== '' ? $data['telephone'] : 'Non renseigné'); ?></span></li>
                            <li class="mb-2"><strong class="text-white">Objet :</strong> <span class="text-secondary"><?php echo e($labels_sujet[$data['sujet']]); ?></span></li>
                            <li class="mb-2"><strong class="text-white">Message :</strong> <span class="text-secondary"><?php echo nl2br(e($data['message'])); ?></span></li>
                            <li><strong class="text-white">Consentement :</strong> <span class="text-secondary">Oui</span></li>
                        </ul>
                        <a href="contact.php" class="btn btn-vertex-outline btn-sm-tech"><i class="bi bi-arrow-left me-1"></i> Nouveau message</a>
                    </div>
                <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <div class="p-3 mb-4 bg-dark rounded border border-danger border-opacity-50">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                            <strong class="text-danger small tech-mono">ERREUR(S) DE VALIDATION</strong>
                        </div>
                        <ul class="mb-0 small text-danger ps-3">
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo e($err); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form id="contactForm" method="POST" action="contact.php">
                    <?php echo csrfField(); ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contactName" class="form-label-tech">
                                <i class="bi bi-person-fill text-amber me-1"></i> Nom et Prénom *
                            </label>
                            <input type="text" id="contactName" name="nom_complet" class="form-control-tech" placeholder="Ex. Marc Soler" required value="<?php echo e($data['nom_complet']); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="contactEmail" class="form-label-tech">
                                <i class="bi bi-envelope-at-fill text-amber me-1"></i> Adresse E-mail *
                            </label>
                            <input type="email" id="contactEmail" name="email" class="form-control-tech" placeholder="nom@exemple.com" required value="<?php echo e($data['email']); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="contactPhone" class="form-label-tech">
                                <i class="bi bi-telephone-fill text-amber me-1"></i> Téléphone (optionnel)
                            </label>
                            <input type="tel" id="contactPhone" name="telephone" class="form-control-tech" placeholder="+33 6 00 00 00 00" value="<?php echo e($data['telephone']); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="contactSubject" class="form-label-tech">
                                <i class="bi bi-tag-fill text-amber me-1"></i> Objet de la Demande *
                            </label>
                            <select id="contactSubject" name="sujet" class="form-select-tech text-secondary" required>
                                <option value="" <?php echo $data['sujet'] === '' ? 'selected' : ''; ?> disabled>Sélectionnez le sujet...</option>
                                <?php foreach ($labels_sujet as $val => $lib): ?>
                                    <option value="<?php echo e($val); ?>" <?php echo $data['sujet'] === $val ? 'selected' : ''; ?>><?php echo e($lib); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="contactMessage" class="form-label-tech">
                                <i class="bi bi-chat-left-text-fill text-amber me-1"></i> Votre message *
                            </label>
                            <textarea id="contactMessage" name="message" class="form-control-tech" rows="5" placeholder="Décrivez votre besoin, votre pratique ou votre demande de réparation..." required><?php echo e($data['message']); ?></textarea>
                        </div>

                        <!-- Consentement -->
                        <div class="col-12">
                            <div class="form-check form-check-tech">
                                <input class="form-check-input" type="checkbox" id="contactTerms" name="consentement" required <?php echo $data['consentement'] ? 'checked' : ''; ?>>
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
                <?php endif; ?>
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

<?php include __DIR__ . '/config/footer.php'; ?>
