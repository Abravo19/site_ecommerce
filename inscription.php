<?php
$current_page = 'inscription';
$page_title = 'Créer un compte | VERTEX EXPEDITION';
$page_description = 'Créez votre compte VERTEX pour enregistrer votre matériel, suivre vos commandes et bénéficier de notre service de garantie.';

include __DIR__ . '/includes/header.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}
$pdo = getDB();
$stmtDisc = $pdo->query("SELECT id_discipline, libelle FROM discipline ORDER BY libelle ASC");
$disciplines = $stmtDisc->fetchAll();

$errors = [];
$success = false;
$form_data = [
    'nom'         => '',
    'prenom'      => '',
    'pseudo'      => '',
    'email'       => '',
    'discipline'  => '',
    'newsletter'  => false,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données
    $form_data['nom']        = trim($_POST['nom'] ?? '');
    $form_data['prenom']     = trim($_POST['prenom'] ?? '');
    $form_data['pseudo']     = trim($_POST['pseudo'] ?? '');
    $form_data['email']      = trim($_POST['email'] ?? '');
    $form_data['discipline'] = $_POST['discipline'] ?? '';
    $form_data['newsletter'] = isset($_POST['newsletter']);
    $password                = $_POST['password'] ?? '';
    $password_confirm        = $_POST['password_confirm'] ?? '';

    // Validations
    if ($form_data['nom'] === '') {
        $errors[] = 'Le nom est obligatoire.';
    }
    if ($form_data['prenom'] === '') {
        $errors[] = 'Le prénom est obligatoire.';
    }
    if ($form_data['email'] === '' || !filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse e-mail invalide.';
    }
    if ($form_data['discipline'] === '') {
        $errors[] = 'Veuillez sélectionner votre pratique principale.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }
    if ($password !== $password_confirm) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }
    if (!isset($_POST['terms'])) {
        $errors[] = 'Vous devez accepter les conditions générales.';
    }

    // Vérifier unicité de l'email
    if (empty($errors)) {
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM client WHERE email = ?");
        $stmtCheck->execute([$form_data['email']]);
        if ($stmtCheck->fetchColumn() > 0) {
            $errors[] = 'Un compte existe déjà avec cette adresse e-mail.';
        }
    }

    // Insertion en BDD
    if (empty($errors)) {
        try {
            // Algorithme imposé par le sujet : SHA-256, avec un sel aléatoire propre
            // à chaque utilisateur (stocké dans sel_mdp) pour éviter les tables de
            // correspondance (rainbow tables).
            $sel  = bin2hex(random_bytes(16));
            $hash = hash('sha256', $password . $sel);

            $stmtInsert = $pdo->prepare("
                INSERT INTO client (nom, prenom, pseudo, email, mot_de_passe_hash, sel_mdp, id_discipline, consentement_newsletter)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmtInsert->execute([
                $form_data['nom'],
                $form_data['prenom'],
                $form_data['pseudo'] !== '' ? $form_data['pseudo'] : null,
                $form_data['email'],
                $hash,
                $sel,
                (int)$form_data['discipline'],
                $form_data['newsletter'] ? 1 : 0,
            ]);

            // Connexion automatique après inscription
            $newUserId = $pdo->lastInsertId();
            $stmtUser = $pdo->prepare("SELECT * FROM client WHERE id_client = ?");
            $stmtUser->execute([$newUserId]);
            $newUser = $stmtUser->fetch();

            if ($newUser) {
                loginUser($newUser);
            }

            $success = true;
        } catch (PDOException $e) {
            error_log('Erreur inscription : ' . $e->getMessage());
            $errors[] = 'Une erreur technique est survenue. Veuillez réessayer.';
        }
    }
}

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

<!-- FORMULAIRE D'INSCRIPTION -->
<div class="container-fluid px-lg-5 pb-5">
    <div class="row g-5">
        <!-- Formulaire -->
        <div class="col-lg-7">
            <div class="tech-form-card">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                    <div>
                        <h2 class="fs-4 fw-bold mb-1">Nouveau compte</h2>
                        <span class="small tech-mono text-muted">REJOIGNEZ LA COMMUNAUTÉ VERTEX</span>
                    </div>
                </div>

                <?php if ($success): ?>
                    <div class="p-4 bg-dark rounded border border-success border-opacity-50 text-center">
                        <i class="bi bi-check-circle-fill text-success fs-1 mb-3 d-block"></i>
                        <h3 class="fw-bold mb-2">Compte créé avec succès !</h3>
                        <p class="text-secondary mb-3">
                            Bienvenue chez VERTEX EXPEDITION, <strong class="text-white"><?php echo htmlspecialchars($form_data['prenom']); ?></strong>.
                            Vous êtes maintenant connecté(e).
                        </p>
                        <a href="index.php" class="btn btn-vertex-primary">
                            <i class="bi bi-compass me-1"></i> Explorer le catalogue
                        </a>
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
                                    <li><?php echo htmlspecialchars($err); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form id="inscriptionForm" method="POST" action="inscription.php">
                        <div class="row g-3">
                            <!-- Nom -->
                            <div class="col-md-6">
                                <label for="regNom" class="form-label-tech">
                                    <i class="bi bi-person-badge-fill text-amber me-1"></i> Nom *
                                </label>
                                <input type="text" id="regNom" name="nom" class="form-control-tech" 
                                       placeholder="Ex. Soler" required
                                       value="<?php echo htmlspecialchars($form_data['nom']); ?>">
                            </div>

                            <!-- Prénom -->
                            <div class="col-md-6">
                                <label for="regPrenom" class="form-label-tech">
                                    <i class="bi bi-person-fill text-amber me-1"></i> Prénom *
                                </label>
                                <input type="text" id="regPrenom" name="prenom" class="form-control-tech" 
                                       placeholder="Ex. Marc" required
                                       value="<?php echo htmlspecialchars($form_data['prenom']); ?>">
                            </div>

                            <!-- Pseudo -->
                            <div class="col-md-6">
                                <label for="regCallsign" class="form-label-tech">
                                    <i class="bi bi-person-gear text-amber me-1"></i> Pseudo (optionnel)
                                </label>
                                <input type="text" id="regCallsign" name="pseudo" class="form-control-tech" 
                                       placeholder="Ex. Marc_Alpinist"
                                       value="<?php echo htmlspecialchars($form_data['pseudo']); ?>">
                            </div>

                            <!-- E-mail -->
                            <div class="col-md-6">
                                <label for="regEmail" class="form-label-tech">
                                    <i class="bi bi-envelope-check-fill text-amber me-1"></i> Adresse E-mail *
                                </label>
                                <input type="email" id="regEmail" name="email" class="form-control-tech" 
                                       placeholder="votre-email@exemple.com" required
                                       value="<?php echo htmlspecialchars($form_data['email']); ?>">
                            </div>

                            <!-- Discipline Principale (dynamique depuis BDD) -->
                            <div class="col-12">
                                <label for="regDiscipline" class="form-label-tech">
                                    <i class="bi bi-compass-fill text-amber me-1"></i> Pratique principale *
                                </label>
                                <select id="regDiscipline" name="discipline" class="form-select-tech text-secondary" required>
                                    <option value="" selected disabled>Sélectionnez votre pratique...</option>
                                    <?php foreach ($disciplines as $disc): ?>
                                        <option value="<?php echo $disc['id_discipline']; ?>"
                                            <?php echo ($form_data['discipline'] == $disc['id_discipline']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($disc['libelle']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Mot de Passe -->
                            <div class="col-md-6">
                                <label for="regPass" class="form-label-tech">
                                    <i class="bi bi-lock-fill text-amber me-1"></i> Mot de Passe *
                                </label>
                                <input type="password" id="regPass" name="password" class="form-control-tech" 
                                       placeholder="8 caractères minimum" required minlength="8">
                            </div>

                            <!-- Confirmation Mot de Passe -->
                            <div class="col-md-6">
                                <label for="regPassConfirm" class="form-label-tech">
                                    <i class="bi bi-shield-lock-fill text-amber me-1"></i> Confirmer le Mot de Passe *
                                </label>
                                <input type="password" id="regPassConfirm" name="password_confirm" class="form-control-tech" 
                                       placeholder="Répétez le mot de passe" required>
                            </div>

                            <!-- Checkboxes -->
                            <div class="col-12">
                                <div class="form-check form-check-tech mb-2">
                                    <input class="form-check-input" type="checkbox" id="regConsentSafety" name="newsletter"
                                        <?php echo $form_data['newsletter'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="regConsentSafety">
                                        Je souhaite recevoir les actualités et informations sur les produits.
                                    </label>
                                </div>

                                <div class="form-check form-check-tech">
                                    <input class="form-check-input" type="checkbox" id="regConsentTerms" name="terms" required>
                                    <label class="form-check-label" for="regConsentTerms">
                                        J'ai pris connaissance et j'accepte les <a href="mentions-legales.php" class="text-amber">Conditions Générales d'Utilisation</a> et la <a href="mentions-legales.php" class="text-amber">Politique de Confidentialité</a>.
                                    </label>
                                </div>
                            </div>

                            <!-- Bouton -->
                            <div class="col-12 pt-2">
                                <button type="submit" class="btn btn-vertex-primary w-100 justify-content-center py-3">
                                    <i class="bi bi-person-check-fill me-2"></i> Créer mon compte
                                </button>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <span class="small text-muted">Vous disposez déjà d'un compte ? </span>
                                <a href="connexion.php" class="small text-amber text-decoration-none fw-bold">Se Connecter</a>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
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
