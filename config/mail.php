<?php

/**
 * Envoie le mail de bienvenue à un nouvel inscrit.
 * Le mot de passe n'est jamais affiché dans le mail (il est chiffré en base).
 *
 * @param array $user Doit contenir : prenom, nom, email, pseudo (facultatif)
 * @return bool true si PHP a accepté le mail pour envoi
 */
function envoyerMailInscription(array $user): bool
{
    // Vérification du format de l'adresse e-mail
    if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $to      = $user['email'];
    $subject = 'Bienvenue chez VERTEX EXPEDITION, ' . $user['prenom'] . ' !';
    $pseudo  = ($user['pseudo'] ?? '') !== '' ? $user['pseudo'] : null;

    $message  = "Bonjour " . $user['prenom'] . " " . $user['nom'] . ",\r\n\r\n";
    $message .= "Merci de vous être inscrit(e) sur VERTEX EXPEDITION, la boutique de sacs à dos techniques et d'équipement de montagne conçus à Chamonix.\r\n\r\n";
    $message .= "Avec votre compte, vous pouvez dès maintenant :\r\n";
    $message .= "- parcourir tout notre catalogue : sacs d'expédition, fastpacking, duffels étanches et abris ;\r\n";
    $message .= "- consulter la fiche détaillée de chaque article (litrage, poids, matériaux, étanchéité) ;\r\n";
    $message .= "- remplir votre panier et choisir les quantités souhaitées ;\r\n";
    $message .= "- nous contacter pour un conseil de choix, une garantie ou une réparation en atelier.\r\n\r\n";
    $message .= "Rappel de vos informations de connexion :\r\n";
    $message .= "- Identifiant : " . $user['email'] . "\r\n";
    if ($pseudo !== null) {
        $message .= "- Pseudo : " . $pseudo . "\r\n";
    }
    $message .= "- Mot de passe : le même que celui saisi lors de l'inscription\r\n\r\n";
    $message .= "À très bientôt sur les sentiers,\r\n";
    $message .= "L'équipe VERTEX EXPEDITION\r\n";

    // Les lignes de plus de 70 caractères sont à éviter dans un mail texte
    $message = wordwrap($message, 70, "\r\n", false);

    $headers  = "From: VERTEX EXPEDITION <contact@vertex-expedition.com>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

    $ok = @mail($to, $encodedSubject, $message, $headers);
    if (!$ok) {
        error_log('mail() a échoué pour ' . $to . ' (serveur de messagerie non configuré ?)');
    }
    return $ok;
}
