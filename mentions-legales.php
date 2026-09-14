<?php
$current_page = 'mentions-legales';
$page_title = 'Mentions Légales | VERTEX EXPEDITION';
$page_description = 'Mentions légales, politique de confidentialité et conditions générales de vente de VERTEX EXPEDITION.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="page-header-technical">
    <div class="container-fluid px-lg-5">
        <span class="tech-kicker">INFORMATIONS LÉGALES</span>
        <h1 class="fw-bold mb-2">Mentions Légales</h1>
        <p class="text-secondary fs-5 mb-0" style="max-width: 720px;">
            Informations légales, politique de confidentialité et conditions générales de vente de VERTEX EXPEDITION.
        </p>
    </div>
</div>

<div class="container-fluid px-lg-5 pb-5">
    <!-- Mentions Légales -->
    <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 mb-4" id="mentions">
        <h2 class="fs-4 fw-bold mb-3"><i class="bi bi-building text-amber me-2"></i>Mentions Légales</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="small">
                    <strong class="text-white d-block mb-2">Éditeur du site</strong>
                    <p class="text-secondary mb-1">VERTEX EXPEDITION EQUIPMENT</p>
                    <p class="text-secondary mb-1">Entreprise individuelle</p>
                    <p class="text-secondary mb-1">Route des Pècles 142</p>
                    <p class="text-secondary mb-1">74400 Chamonix-Mont-Blanc, France</p>
                    <p class="text-secondary mb-0">E-mail : contact@vertex-expedition.com</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small">
                    <strong class="text-white d-block mb-2">Responsable de la publication</strong>
                    <p class="text-secondary mb-3">Gabriel Bravo — Fondateur & Gérant</p>

                    <strong class="text-white d-block mb-2">Hébergement</strong>
                    <p class="text-secondary mb-0">Ce site est un projet de développement en phase de maquettage (V1). Les informations d'hébergement seront ajoutées lors de la mise en production.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Politique de Confidentialité -->
    <div class="p-4 bg-dark rounded border border-secondary border-opacity-25 mb-4" id="confidentialite">
        <h2 class="fs-4 fw-bold mb-3"><i class="bi bi-shield-lock text-amber me-2"></i>Politique de Confidentialité</h2>
        <div class="small text-secondary">
            <p>VERTEX EXPEDITION s'engage à protéger la vie privée des utilisateurs de son site web. Cette politique de confidentialité décrit les informations que nous collectons et la manière dont elles sont utilisées.</p>

            <strong class="text-white d-block mt-3 mb-2">Données collectées</strong>
            <p>Lors de l'utilisation de nos formulaires (contact, inscription, newsletter), les données suivantes peuvent être collectées :</p>
            <ul class="list-unstyled ms-3 mb-3">
                <li class="mb-1"><i class="bi bi-check2 text-amber me-2"></i>Nom et prénom</li>
                <li class="mb-1"><i class="bi bi-check2 text-amber me-2"></i>Adresse e-mail</li>
                <li class="mb-1"><i class="bi bi-check2 text-amber me-2"></i>Numéro de téléphone (optionnel)</li>
                <li class="mb-1"><i class="bi bi-check2 text-amber me-2"></i>Contenu du message</li>
            </ul>

            <strong class="text-white d-block mt-3 mb-2">Utilisation des données</strong>
            <p>Ces données sont utilisées uniquement pour traiter votre demande (support client, garantie, réparation, information produit). Elles ne sont ni revendues, ni transmises à des tiers sans votre consentement.</p>

            <strong class="text-white d-block mt-3 mb-2">Cookies</strong>
            <p>Ce site utilise le stockage local du navigateur (localStorage) pour mémoriser le contenu de votre panier. Aucun cookie tiers n'est utilisé à des fins de traçage publicitaire.</p>

            <strong class="text-white d-block mt-3 mb-2">Vos droits</strong>
            <p class="mb-0">Conformément au RGPD, vous disposez d'un droit d'accès, de rectification, de suppression et de portabilité de vos données. Pour exercer ces droits, contactez-nous à : <span class="text-white">contact@vertex-expedition.com</span></p>
        </div>
    </div>

    <!-- Conditions Générales de Vente -->
    <div class="p-4 bg-dark rounded border border-secondary border-opacity-25" id="cgv">
        <h2 class="fs-4 fw-bold mb-3"><i class="bi bi-file-earmark-text text-amber me-2"></i>Conditions Générales de Vente</h2>
        <div class="small text-secondary">
            <p>Les présentes Conditions Générales de Vente régissent les ventes de produits effectuées sur le site VERTEX EXPEDITION.</p>

            <strong class="text-white d-block mt-3 mb-2">Prix</strong>
            <p>Les prix affichés sont en euros, toutes taxes comprises (TTC), TVA à 20% incluse. VERTEX EXPEDITION se réserve le droit de modifier ses prix à tout moment, les produits étant facturés sur la base du tarif en vigueur au moment de la commande.</p>

            <strong class="text-white d-block mt-3 mb-2">Livraison</strong>
            <p>Les commandes sont expédiées depuis notre atelier de Chamonix-Mont-Blanc. La livraison est offerte en France métropolitaine à partir de 150,00 € d'achat. Les délais de livraison sont de 3 à 5 jours ouvrés.</p>

            <strong class="text-white d-block mt-3 mb-2">Retours et échanges</strong>
            <p>Vous disposez d'un délai de 14 jours à compter de la réception pour retourner un article. Les produits doivent être retournés dans leur état d'origine, non utilisés et dans leur emballage d'origine.</p>

            <strong class="text-white d-block mt-3 mb-2">Garantie & Réparation</strong>
            <p class="mb-0">Tous les produits VERTEX bénéficient d'une garantie fabricant. Notre atelier de Chamonix assure la réparation et l'entretien de vos équipements (remplacement de boucles, coutures, zips). Contactez notre service client pour toute demande de prise en charge.</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
