<?php
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/config/db.php';

requireAdmin();

$pdo = getDB();
$current_page = 'admin';
$page_title = 'Administration du Catalogue | VERTEX EXPEDITION';
$page_description = 'Espace d\'administration VERTEX EXPEDITION : gestion des produits, prix, stocks et images.';

// Transforme un nom de produit en slug pour l'URL
function slugify(string $text): string
{
    $map = [
        'à'=>'a','â'=>'a','ä'=>'a','á'=>'a','ã'=>'a',
        'è'=>'e','é'=>'e','ê'=>'e','ë'=>'e',
        'ì'=>'i','í'=>'i','î'=>'i','ï'=>'i',
        'ò'=>'o','ó'=>'o','ô'=>'o','ö'=>'o','õ'=>'o',
        'ù'=>'u','ú'=>'u','û'=>'u','ü'=>'u',
        'ç'=>'c','ñ'=>'n','œ'=>'oe',
    ];
    $text = mb_strtolower(trim($text), 'UTF-8');
    $text = strtr($text, $map);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-') ?: 'produit-' . time();
}

// Catégories disponibles
$categories_db = $pdo->query("SELECT id_categorie, code, libelle FROM categorie ORDER BY id_categorie ASC")->fetchAll();
$cat_ids_valides = array_map('intval', array_column($categories_db, 'id_categorie'));

$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck($_POST['csrf'] ?? null)) {
        $errors[] = 'Jeton de sécurité invalide ou session expirée. Veuillez réessayer.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'fix_inverted_prices') {
            $inverted = $pdo->query("SELECT id_produit, prix, prix_promo FROM produit WHERE prix_promo IS NOT NULL AND prix_promo > prix")->fetchAll();
            $upd = $pdo->prepare("UPDATE produit SET prix = ?, prix_promo = ? WHERE id_produit = ?");
            foreach ($inverted as $inv) {
                $upd->execute([$inv['prix_promo'], $inv['prix'], $inv['id_produit']]);
            }
            flashSet('success', count($inverted) . ' produit(s) avec prix/promotion inversés ont été corrigés en base de données.');
            redirect('admin.php');
        }

        // 2) Suppression d'un produit
        if ($action === 'delete_product') {
            $id_del = (int)($_POST['id_produit'] ?? 0);
            if ($id_del > 0) {
                try {
                    $stmtDel = $pdo->prepare("DELETE FROM produit WHERE id_produit = ?");
                    $stmtDel->execute([$id_del]);
                    flashSet('success', 'Le produit #' . $id_del . ' a été supprimé du catalogue.');
                } catch (PDOException $e) {
                    flashSet('danger', 'Impossible de supprimer ce produit car il est lié à un panier ou une commande existante.');
                }
            }
            redirect('admin.php');
        }

        // 3) Changement de rôle d'un utilisateur
        if ($action === 'toggle_role') {
            $id_target = (int)($_POST['id_client'] ?? 0);
            $new_role  = ($_POST['new_role'] ?? '') === 'admin' ? 'admin' : 'client';
            $me        = getCurrentUser();

            if ($id_target > 0) {
                if ($id_target === (int)$me['id'] && $new_role !== 'admin') {
                    flashSet('warning', 'Vous ne pouvez pas retirer vos propres droits administrateur.');
                } else {
                    $stmtRole = $pdo->prepare("UPDATE client SET role = ? WHERE id_client = ?");
                    $stmtRole->execute([$new_role, $id_target]);
                    flashSet('success', 'Le rôle de l\'utilisateur #' . $id_target . ' a été mis à jour (' . $new_role . ').');
                }
            }
            redirect('admin.php#utilisateurs');
        }

        // 4) Création ou modification d'un produit
        if ($action === 'save_product') {
            $id_produit        = (int)($_POST['id_produit'] ?? 0);
            $id_categorie      = (int)($_POST['id_categorie'] ?? 0);
            $reference         = trim($_POST['reference'] ?? '');
            $nom               = trim($_POST['nom'] ?? '');
            $slug              = trim($_POST['slug'] ?? '');
            $tag               = trim($_POST['tag'] ?? '');
            $badge             = trim($_POST['badge'] ?? '');
            $prix              = str_replace(',', '.', trim($_POST['prix'] ?? ''));
            $prix_promo        = str_replace(',', '.', trim($_POST['prix_promo'] ?? ''));
            $quantite_stock    = (int)($_POST['quantite_stock'] ?? 0);
            $volume_litres     = trim($_POST['volume_litres'] ?? '');
            $poids_grammes     = trim($_POST['poids_grammes'] ?? '');
            $materiau          = trim($_POST['materiau'] ?? '');
            $etancheite        = trim($_POST['etancheite'] ?? '');
            $usage_temperature = trim($_POST['usage_temperature'] ?? '');
            $description_courte = trim($_POST['description_courte'] ?? '');
            $description_longue = trim($_POST['description_longue'] ?? '');
            $image_actuelle    = trim($_POST['image_actuelle'] ?? '');
            $reset_image       = isset($_POST['reset_image']);

            if ($slug === '' && $nom !== '') {
                $slug = slugify($nom);
            } else {
                $slug = slugify($slug);
            }

            if ($nom === '') {
                $errors[] = 'Le nom du produit est obligatoire.';
            }
            if ($reference === '') {
                $errors[] = 'La référence du produit est obligatoire.';
            }
            if (!in_array($id_categorie, $cat_ids_valides, true)) {
                $errors[] = 'Veuillez choisir une catégorie valide.';
            }
            if ($prix === '' || !is_numeric($prix) || (float)$prix < 0) {
                $errors[] = 'Le prix normal doit être un nombre positif.';
            }
            if ($prix_promo !== '' && (!is_numeric($prix_promo) || (float)$prix_promo < 0)) {
                $errors[] = 'Le prix promotionnel doit être un nombre positif ou laissé vide.';
            }

            $prix_val  = (float)$prix;
            $promo_val = ($prix_promo !== '' && (float)$prix_promo > 0) ? (float)$prix_promo : null;

            // Si l'utilisateur a saisi un prix promo supérieur au prix normal, on les permute automatiquement
            if ($promo_val !== null && $promo_val > $prix_val) {
                $tmp = $prix_val;
                $prix_val = $promo_val;
                $promo_val = $tmp;
            }

            // Gestion de l'image (upload ou chemin existant)
            $chemin_image = $reset_image ? null : ($image_actuelle !== '' ? $image_actuelle : null);

            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                $file = $_FILES['image_file'];
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $errors[] = 'Erreur lors du téléversement de l\'image (code ' . (int)$file['error'] . ').';
                } elseif ($file['size'] > 5 * 1024 * 1024) {
                    $errors[] = 'L\'image ne doit pas dépasser 5 Mo.';
                } else {
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
                    if (!in_array($ext, $allowed_exts, true)) {
                        $errors[] = 'Format d\'image non autorisé. Utilisez JPG, PNG, WEBP ou SVG.';
                    } else {
                        $upload_dir = __DIR__ . '/img/articles';
                        if (!is_dir($upload_dir)) {
                            mkdir($upload_dir, 0755, true);
                        }
                        $filename = $slug . '-' . substr(bin2hex(random_bytes(3)), 0, 6) . '.' . ($ext === 'jpeg' ? 'jpg' : $ext);
                        $dest = $upload_dir . '/' . $filename;
                        if (move_uploaded_file($file['tmp_name'], $dest)) {
                            $chemin_image = 'img/articles/' . $filename;
                        } else {
                            $errors[] = 'Impossible d\'enregistrer l\'image dans img/articles/.';
                        }
                    }
                }
            }

            if (empty($errors)) {
                try {
                    if ($id_produit > 0) {
                        $stmtSave = $pdo->prepare("
                            UPDATE produit SET
                                id_categorie = ?,
                                reference = ?,
                                slug = ?,
                                nom = ?,
                                tag = ?,
                                badge = ?,
                                prix = ?,
                                prix_promo = ?,
                                volume_litres = ?,
                                poids_grammes = ?,
                                materiau = ?,
                                etancheite = ?,
                                usage_temperature = ?,
                                image_principale = ?,
                                description_courte = ?,
                                description_longue = ?,
                                quantite_stock = ?
                            WHERE id_produit = ?
                        ");
                        $stmtSave->execute([
                            $id_categorie,
                            $reference,
                            $slug,
                            $nom,
                            $tag !== '' ? $tag : null,
                            $badge !== '' ? $badge : null,
                            $prix_val,
                            $promo_val,
                            $volume_litres !== '' ? (int)$volume_litres : null,
                            $poids_grammes !== '' ? (int)$poids_grammes : null,
                            $materiau !== '' ? $materiau : null,
                            $etancheite !== '' ? $etancheite : null,
                            $usage_temperature !== '' ? $usage_temperature : null,
                            $chemin_image,
                            $description_courte !== '' ? $description_courte : null,
                            $description_longue !== '' ? $description_longue : null,
                            max(0, $quantite_stock),
                            $id_produit,
                        ]);
                        flashSet('success', 'Le produit « ' . $nom . ' » a été mis à jour avec succès.');
                    } else {
                        $stmtSave = $pdo->prepare("
                            INSERT INTO produit (
                                id_categorie, reference, slug, nom, tag, badge,
                                prix, prix_promo, volume_litres, poids_grammes,
                                materiau, etancheite, usage_temperature, image_principale,
                                description_courte, description_longue, quantite_stock
                            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmtSave->execute([
                            $id_categorie,
                            $reference,
                            $slug,
                            $nom,
                            $tag !== '' ? $tag : null,
                            $badge !== '' ? $badge : null,
                            $prix_val,
                            $promo_val,
                            $volume_litres !== '' ? (int)$volume_litres : null,
                            $poids_grammes !== '' ? (int)$poids_grammes : null,
                            $materiau !== '' ? $materiau : null,
                            $etancheite !== '' ? $etancheite : null,
                            $usage_temperature !== '' ? $usage_temperature : null,
                            $chemin_image,
                            $description_courte !== '' ? $description_courte : null,
                            $description_longue !== '' ? $description_longue : null,
                            max(0, $quantite_stock),
                        ]);
                        flashSet('success', 'Le nouveau produit « ' . $nom . ' » a été ajouté au catalogue.');
                    }
                    redirect('admin.php');
                } catch (PDOException $e) {
                    $errors[] = 'Erreur base de données (vérifiez que la référence et le slug sont uniques) : ' . $e->getMessage();
                }
            }
        }
    }
}

// Récupération des produits et des clients
$produits_db = $pdo->query("
    SELECT p.*, c.code AS cat_code, c.libelle AS cat_libelle
    FROM produit p
    INNER JOIN categorie c ON c.id_categorie = p.id_categorie
    ORDER BY p.id_produit ASC
")->fetchAll();

$nb_inverted = 0;
foreach ($produits_db as $p) {
    if ($p['prix_promo'] !== null && (float)$p['prix_promo'] > (float)$p['prix']) {
        $nb_inverted++;
    }
}

// Produit en cours d'édition (si ?edit=ID)
$edit_id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$edit_product = null;
if ($edit_id > 0) {
    foreach ($produits_db as $p) {
        if ((int)$p['id_produit'] === $edit_id) {
            $edit_product = $p;
            break;
        }
    }
}

$clients_db = $pdo->query("
    SELECT id_client, nom, prenom, pseudo, email, role, date_inscription
    FROM client
    ORDER BY id_client ASC
")->fetchAll();

require_once __DIR__ . '/config/header.php';
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <span class="tech-kicker"><i class="bi bi-shield-lock-fill me-1"></i> ESPACE ADMINISTRATEUR</span>
                <h1 class="fw-bold mb-1">Gestion du Catalogue & des Utilisateurs</h1>
                <p class="text-secondary mb-0">
                    Modifiez les produits, les prix, les stocks et téléversez de nouvelles images directement sans toucher au code.
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="admin.php#form-produit" class="btn btn-vertex-primary btn-sm-tech">
                    <i class="bi bi-plus-circle me-1"></i> Nouveau Produit
                </a>
                <a href="articles.php" class="btn btn-vertex-outline btn-sm-tech">
                    <i class="bi bi-eye me-1"></i> Voir le Catalogue
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-lg-5 pb-5">

    <?php if ($nb_inverted > 0): ?>
    <div class="p-3 mb-4 bg-dark rounded border border-warning d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <strong class="text-warning tech-mono small d-block">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> ANOMALIE DÉTECTÉE DANS LA BASE DE DONNÉES
            </strong>
            <span class="small text-secondary">
                <?php echo $nb_inverted; ?> produit(s) ont un <code>prix_promo</code> supérieur au <code>prix</code> normal.
            </span>
        </div>
        <form method="POST" action="admin.php" class="m-0">
            <?php echo csrfField(); ?>
            <input type="hidden" name="action" value="fix_inverted_prices">
            <button type="submit" class="btn btn-warning btn-sm-tech text-dark fw-bold">
                <i class="bi bi-wrench-adjustable me-1"></i> Corriger automatiquement les <?php echo $nb_inverted; ?> prix inversés
            </button>
        </form>
    </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
    <div class="p-3 mb-4 bg-dark rounded border border-danger">
        <strong class="text-danger tech-mono small d-block mb-1">
            <i class="bi bi-x-octagon-fill me-1"></i> ERREUR
        </strong>
        <ul class="mb-0 small text-danger ps-3">
            <?php foreach ($errors as $err): ?>
                <li><?php echo e($err); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- FORMULAIRE AJOUT / MODIFICATION DE PRODUIT -->
    <div class="tech-form-card mb-5" id="form-produit">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <h2 class="fs-4 fw-bold mb-1">
                    <?php if ($edit_product): ?>
                        <i class="bi bi-pencil-square text-amber me-2"></i>Modifier : <?php echo e($edit_product['nom']); ?>
                    <?php else: ?>
                        <i class="bi bi-plus-square text-amber me-2"></i>Ajouter un nouveau produit
                    <?php endif; ?>
                </h2>
                <span class="small tech-mono text-muted">
                    <?php echo $edit_product ? 'ID PRODUIT #' . (int)$edit_product['id_produit'] : 'CRÉATION D\'UNE NOUVELLE FICHE PRODUIT'; ?>
                </span>
            </div>
            <?php if ($edit_product): ?>
                <a href="admin.php" class="btn btn-outline-secondary btn-sm-tech">
                    <i class="bi bi-x-lg me-1"></i> Annuler l'édition
                </a>
            <?php endif; ?>
        </div>

        <form method="POST" action="admin.php<?php echo $edit_product ? '?edit=' . (int)$edit_product['id_produit'] : ''; ?>" enctype="multipart/form-data">
            <?php echo csrfField(); ?>
            <input type="hidden" name="action" value="save_product">
            <input type="hidden" name="id_produit" value="<?php echo (int)($edit_product['id_produit'] ?? 0); ?>">
            <input type="hidden" name="image_actuelle" value="<?php echo e($edit_product['image_principale'] ?? ''); ?>">

            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label-tech">Nom du produit *</label>
                    <input type="text" name="nom" class="form-control-tech" required
                           placeholder="Ex. VERTEX APEX 65L PRO"
                           value="<?php echo e($edit_product['nom'] ?? ''); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label-tech">Référence *</label>
                    <input type="text" name="reference" class="form-control-tech" required
                           placeholder="Ex. VT-APEX-65P"
                           value="<?php echo e($edit_product['reference'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label-tech">Catégorie *</label>
                    <select name="id_categorie" class="form-select-tech text-white" required>
                        <?php foreach ($categories_db as $cat): ?>
                            <option value="<?php echo (int)$cat['id_categorie']; ?>"
                                <?php echo ((int)($edit_product['id_categorie'] ?? 1) === (int)$cat['id_categorie']) ? 'selected' : ''; ?>>
                                <?php echo e($cat['libelle']); ?> (<?php echo e($cat['code']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label-tech">Prix normal (€) *</label>
                    <input type="number" step="0.01" min="0" name="prix" class="form-control-tech" required
                           placeholder="Ex. 420.00"
                           value="<?php echo e($edit_product['prix'] ?? ''); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label-tech">Prix promo (€) <span class="text-muted">(optionnel)</span></label>
                    <input type="number" step="0.01" min="0" name="prix_promo" class="form-control-tech"
                           placeholder="Vide si pas de promo"
                           value="<?php echo e($edit_product['prix_promo'] ?? ''); ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label-tech">Stock *</label>
                    <input type="number" min="0" name="quantite_stock" class="form-control-tech" required
                           value="<?php echo (int)($edit_product['quantite_stock'] ?? 10); ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label-tech">Volume (L)</label>
                    <input type="number" min="0" name="volume_litres" class="form-control-tech"
                           placeholder="Ex. 65"
                           value="<?php echo e($edit_product['volume_litres'] ?? ''); ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label-tech">Poids (g)</label>
                    <input type="number" min="0" name="poids_grammes" class="form-control-tech"
                           placeholder="Ex. 1140"
                           value="<?php echo e($edit_product['poids_grammes'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label-tech">Badge technique</label>
                    <input type="text" name="badge" class="form-control-tech"
                           placeholder="Ex. ALPINE PRO / IP68 SUBMERSIBLE"
                           value="<?php echo e($edit_product['badge'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label-tech">Collection / Tag</label>
                    <input type="text" name="tag" class="form-control-tech"
                           placeholder="Ex. Série Alpine"
                           value="<?php echo e($edit_product['tag'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label-tech">Slug URL <span class="text-muted">(auto si vide)</span></label>
                    <input type="text" name="slug" class="form-control-tech"
                           placeholder="Ex. vertex-apex-65l-pro"
                           value="<?php echo e($edit_product['slug'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label-tech">Matériau</label>
                    <input type="text" name="materiau" class="form-control-tech"
                           placeholder="Ex. 500D Cordura® Ripstop"
                           value="<?php echo e($edit_product['materiau'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label-tech">Étanchéité</label>
                    <input type="text" name="etancheite" class="form-control-tech"
                           placeholder="Ex. Imperméable IPX6"
                           value="<?php echo e($edit_product['etancheite'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label-tech">Usage / Température</label>
                    <input type="text" name="usage_temperature" class="form-control-tech"
                           placeholder="Ex. Usage 4 saisons"
                           value="<?php echo e($edit_product['usage_temperature'] ?? ''); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label-tech">Description courte</label>
                    <textarea name="description_courte" rows="2" class="form-control-tech"
                              placeholder="Résumé affiché sur la carte du catalogue..."><?php echo e($edit_product['description_courte'] ?? ''); ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label-tech">Description longue</label>
                    <textarea name="description_longue" rows="2" class="form-control-tech"
                              placeholder="Description détaillée affichée sur la fiche du produit..."><?php echo e($edit_product['description_longue'] ?? ''); ?></textarea>
                </div>

                <!-- Gestion de l'image -->
                <div class="col-12">
                    <div class="p-3 bg-black rounded border border-secondary border-opacity-25">
                        <div class="row align-items-center g-3">
                            <div class="col-md-2 text-center">
                                <?php
                                $preview_img = $edit_product
                                    ? produitImage($edit_product['image_principale'], $edit_product['cat_code'])
                                    : 'img/articles/placeholder-expedition.svg';
                                ?>
                                <img src="<?php echo e($preview_img); ?>" alt="Aperçu"
                                     style="width:88px;height:88px;object-fit:cover;border-radius:8px;border:1px solid rgba(255,255,255,0.15);">
                            </div>
                            <div class="col-md-10">
                                <label class="form-label-tech">
                                    <i class="bi bi-image text-amber me-1"></i> Téléverser une nouvelle image (JPG, PNG, WEBP, SVG — max 5 Mo)
                                </label>
                                <input type="file" name="image_file" class="form-control form-control-sm bg-dark text-white border-secondary"
                                       accept=".jpg,.jpeg,.png,.webp,.svg">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mt-2 small text-muted">
                                    <span>
                                        Image actuelle :
                                        <code class="text-amber"><?php echo e($edit_product['image_principale'] ?? 'Aucune (placeholder automatique)'); ?></code>
                                    </span>
                                    <?php if (!empty($edit_product['image_principale'])): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reset_image" id="resetImageCheck">
                                        <label class="form-check-label text-warning" for="resetImageCheck">
                                            Retirer l'image personnalisée (utiliser le placeholder)
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 pt-2 d-flex gap-2">
                    <button type="submit" class="btn btn-vertex-primary px-4 py-2">
                        <i class="bi bi-check2-circle me-1"></i>
                        <?php echo $edit_product ? 'Enregistrer les modifications' : 'Ajouter le produit au catalogue'; ?>
                    </button>
                    <?php if ($edit_product): ?>
                        <a href="article.php?slug=<?php echo e($edit_product['slug']); ?>" class="btn btn-vertex-outline px-3 py-2">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Voir la fiche
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <!-- LISTE COMPLÈTE DES PRODUITS -->
    <div class="tech-form-card mb-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <h2 class="fs-5 fw-bold mb-0"><i class="bi bi-box-seam text-amber me-2"></i>Produits du Catalogue (<?php echo count($produits_db); ?>)</h2>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 small">
                <thead>
                    <tr class="tech-mono text-secondary">
                        <th>ID</th>
                        <th>Image</th>
                        <th>Réf / Nom</th>
                        <th>Catégorie</th>
                        <th>Prix normal</th>
                        <th>Prix promo</th>
                        <th>Stock</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits_db as $p): ?>
                        <?php $img = produitImage($p['image_principale'], $p['cat_code']); ?>
                        <tr>
                            <td class="tech-mono text-muted">#<?php echo (int)$p['id_produit']; ?></td>
                            <td>
                                <img src="<?php echo e($img); ?>" alt=""
                                     style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                            </td>
                            <td>
                                <div class="fw-bold text-white"><?php echo e($p['nom']); ?></div>
                                <div class="tech-mono text-muted" style="font-size:0.75rem;"><?php echo e($p['reference']); ?></div>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-25 text-light border border-secondary border-opacity-25">
                                    <?php echo e($p['cat_libelle']); ?>
                                </span>
                            </td>
                            <td class="tech-mono"><?php echo number_format((float)$p['prix'], 2, ',', ' '); ?> €</td>
                            <td class="tech-mono">
                                <?php if ($p['prix_promo'] !== null): ?>
                                    <span class="text-amber fw-bold"><?php echo number_format((float)$p['prix_promo'], 2, ',', ' '); ?> €</span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="tech-mono">
                                <?php if ((int)$p['quantite_stock'] > 0): ?>
                                    <span class="text-success"><?php echo (int)$p['quantite_stock']; ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rupture (0)</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="admin.php?edit=<?php echo (int)$p['id_produit']; ?>#form-produit"
                                       class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="bi bi-pencil-square"></i> Modifier
                                    </a>
                                    <form method="POST" action="admin.php" class="d-inline"
                                          onsubmit="return confirm('Supprimer définitivement « <?php echo e(addslashes($p['nom'])); ?> » ?');">
                                        <?php echo csrfField(); ?>
                                        <input type="hidden" name="action" value="delete_product">
                                        <input type="hidden" name="id_produit" value="<?php echo (int)$p['id_produit']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- GESTION DES UTILISATEURS ET RÔLES -->
    <div class="tech-form-card" id="utilisateurs">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <h2 class="fs-5 fw-bold mb-0"><i class="bi bi-people-fill text-amber me-2"></i>Comptes Clients & Administrateurs (<?php echo count($clients_db); ?>)</h2>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 small">
                <thead>
                    <tr class="tech-mono text-secondary">
                        <th>ID</th>
                        <th>Nom & Prénom</th>
                        <th>Pseudo</th>
                        <th>E-mail</th>
                        <th>Inscription</th>
                        <th>Rôle actuel</th>
                        <th class="text-end">Changer le rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients_db as $cl): ?>
                        <tr>
                            <td class="tech-mono text-muted">#<?php echo (int)$cl['id_client']; ?></td>
                            <td class="fw-bold text-white"><?php echo e($cl['prenom'] . ' ' . $cl['nom']); ?></td>
                            <td class="tech-mono text-muted"><?php echo e($cl['pseudo'] ?? '—'); ?></td>
                            <td><?php echo e($cl['email']); ?></td>
                            <td class="tech-mono text-muted"><?php echo e($cl['date_inscription']); ?></td>
                            <td>
                                <?php if ($cl['role'] === 'admin'): ?>
                                    <span class="badge bg-warning text-dark tech-mono">ADMIN</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary tech-mono">CLIENT</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <form method="POST" action="admin.php#utilisateurs" class="d-inline">
                                    <?php echo csrfField(); ?>
                                    <input type="hidden" name="action" value="toggle_role">
                                    <input type="hidden" name="id_client" value="<?php echo (int)$cl['id_client']; ?>">
                                    <?php if ($cl['role'] === 'admin'): ?>
                                        <input type="hidden" name="new_role" value="client">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            Passer en Client
                                        </button>
                                    <?php else: ?>
                                        <input type="hidden" name="new_role" value="admin">
                                        <button type="submit" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-shield-lock me-1"></i> Promouvoir Admin
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include __DIR__ . '/config/footer.php'; ?>
