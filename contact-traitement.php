<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}
$nom_complet   = trim($_POST['nom_complet'] ?? '');
$email         = trim($_POST['email'] ?? '');
$telephone     = trim($_POST['telephone'] ?? '');
$sujet         = trim($_POST['sujet'] ?? '');
$message       = trim($_POST['message'] ?? '');
$consentement  = isset($_POST['consentement']) ? 'Oui' : 'Non';

$labels_sujet = [
    'litrage'    => 'Conseil sur le choix du sac et le litrage',
    'reparacion' => 'Atelier de réparation & garantie',
    'pedido'     => 'Suivi de commande',
    'otro'       => 'Autre demande',
];
$sujet_affiche = $labels_sujet[$sujet] ?? $sujet;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Message reçu | VERTEX EXPEDITION</title>
</head>
<body>
    <h1>Message reçu</h1>
    <p>Voici les informations que vous avez envoyées :</p>
    <ul>
        <li><strong>Nom et prénom :</strong> <?php echo htmlspecialchars($nom_complet); ?></li>
        <li><strong>E-mail :</strong> <?php echo htmlspecialchars($email); ?></li>
        <li><strong>Téléphone :</strong> <?php echo htmlspecialchars($telephone !== '' ? $telephone : 'Non renseigné'); ?></li>
        <li><strong>Objet :</strong> <?php echo htmlspecialchars($sujet_affiche); ?></li>
        <li><strong>Message :</strong> <?php echo nl2br(htmlspecialchars($message)); ?></li>
        <li><strong>Consentement au traitement des données :</strong> <?php echo $consentement; ?></li>
    </ul>
    <p><a href="contact.php">&larr; Retour au formulaire de contact</a></p>
</body>
</html>
