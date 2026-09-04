<?php
/**
 * VERTEX EXPEDITION - En-tête Commun & Téléométrie Supérieure (HUD)
 */
if (!isset($page_title)) {
    $page_title = 'VERTEX EXPEDITION | Équipement Outdoor, Sacs à Dos et Matériel de Voyage';
}
if (!isset($page_description)) {
    $page_description = 'Sacs à dos ergonomiques à charge active, systèmes ultralégers ripstop et matériel de précision testé à -35°C dans le Mont-Blanc.';
}
if (!isset($current_page)) {
    $current_page = '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <!-- Polices de Haute Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- CDN Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icônes Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Feuille de Style Globale Unique -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- BARRE SUPÉRIEURE DE TÉLÉMÉTRIE TECHNIQUE (HUD) -->
<div class="top-telemetry-bar d-none d-lg-block">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="telemetry-item">
                    <span class="text-amber"><i class="bi bi-broadcast me-1"></i> LAB ALPIN :</span>
                    <strong>TÉLÉMÉTRIE EN DIRECT</strong>
                </div>
                <div class="telemetry-item">
                    <i class="bi bi-snow me-1 text-info"></i> TEMP. TEST BASE :
                    <strong>-22°C MASSIF DU MONT-BLANC</strong>
                </div>
                <div class="telemetry-item">
                    <i class="bi bi-clock-history me-1 text-warning"></i> DÉPARTS EXPÉDITION :
                    <strong>COMMANDES TECHNIQUES &lt; 18:00 H</strong>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <div class="telemetry-item">
                    <span class="pulse-dot me-1"></span> RÉSEAU OPÉRATIONNEL :
                    <strong>100% OPÉRATIONNEL</strong>
                </div>
                <div class="telemetry-item">
                    <i class="bi bi-globe2 me-1"></i> DEVISE :
                    <strong class="text-white">EUR (€)</strong>
                </div>
                <div class="telemetry-item">
                    <a href="contact.php" class="text-secondary text-decoration-none hover-white">
                        <i class="bi bi-headset me-1 text-amber"></i> SUPPORT TECHNIQUE
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
