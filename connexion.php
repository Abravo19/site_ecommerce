<?php
$current_page = 'connexion';
$page_title = 'Connexion | VERTEX EXPEDITION';
$page_description = 'Connectez-vous à votre compte VERTEX EXPEDITION.';

include __DIR__ . '/includes/header.php';

// Rediriger si déjà connecté
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$redirect_url = $_GET['redirect'] ?? ($_POST['redirect'] ?? 'index.php');
$errors = [];
$email_saisi = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_saisi = trim($_POST['email'] ?? '');
    $password    = $_POST['password'] ?? '';

    if ($email_saisi === '' || $password === '') {
        $errors[] = 'Veuillez renseigner votre e-mail et votre mot de passe.';
    } else {
        $pdo = getDB();
        $stmt = $pdo->prepare("SELECT * FROM client WHERE email = ?");
        $stmt->execute([$email_saisi]);
        $user = $stmt->fetch();

        $ok = false;
        if ($user) {
            $hashCalcule = hash('sha256', $password . ($user['sel_mdp'] ?? ''));
            $ok = hash_equals($user['mot_de_passe_hash'], $hashCalcule);
        }

        if ($ok) {
            loginUser($user);
            header('Location: ' . $redirect_url);
            exit;
        }

        $errors[] = 'E-mail ou mot de passe incorrect.';
    }
}

include __DIR__ . '/includes/navbar.php';
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <span class="tech-kicker">ESPACE CLIENT</span>
        <h1 class="fw-bold mb-2">Connexion</h1>
        <p class="text-secondary fs-5 mb-0" style="max-width: 720px;">
            Connectez-vous pour accéder à votre compte VERTEX EXPEDITION.
        </p>
    </div>
</div>

<div class="container-fluid px-lg-5 pb-5">
    <div class="row g-5 justify-content-center">
        <div class="col-lg-6">
            <div class="tech-form-card">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                    <div>
                        <h2 class="fs-4 fw-bold mb-1">Se connecter</h2>
                        <span class="small tech-mono text-muted">ESPACE PERSONNEL</span>
                    </div>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="p-3 mb-4 bg-dark rounded border border-danger border-opacity-50">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                            <strong class="text-danger small tech-mono">ERREUR</strong>
                        </div>
                        <ul class="mb-0 small text-danger ps-3">
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo htmlspecialchars($err); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="connexion.php">
                    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect_url); ?>">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="loginEmail" class="form-label-tech">
                                <i class="bi bi-envelope-check-fill text-amber me-1"></i> Adresse E-mail *
                            </label>
                            <input type="email" id="loginEmail" name="email" class="form-control-tech"
                                   placeholder="votre-email@exemple.com" required
                                   value="<?php echo htmlspecialchars($email_saisi); ?>">
                        </div>

                        <div class="col-12">
                            <label for="loginPassword" class="form-label-tech">
                                <i class="bi bi-lock-fill text-amber me-1"></i> Mot de Passe *
                            </label>
                            <input type="password" id="loginPassword" name="password" class="form-control-tech"
                                   placeholder="Votre mot de passe" required>
                        </div>

                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-vertex-primary w-100 justify-content-center py-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                            </button>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <span class="small text-muted">Pas encore de compte ? </span>
                            <a href="inscription.php" class="small text-amber text-decoration-none fw-bold">Créer un compte</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
