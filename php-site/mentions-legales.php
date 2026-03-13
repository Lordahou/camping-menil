<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$pageTitle = 'Mentions légales';
$pageDescription = 'Mentions légales du site Camping du Bac de Ménil. Éditeur, hébergement, propriété intellectuelle et responsabilités.';
$noindex = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php include __DIR__ . '/includes/head.php'; ?>
</head>
<body class="bg-cream font-body text-gray-800 antialiased">
<?php include __DIR__ . '/includes/header.php'; ?>
<main>

  <!-- Hero medium -->
  <section class="relative h-[50vh] min-h-[400px] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
      <img src="<?= e(getImagePath($content['hero']['image'] ?? '')) ?>" alt="Mentions légales" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Mentions légales</h1>
    </div>
  </section>

  <!-- Content -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="space-y-10 text-gray-600 leading-relaxed">

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Éditeur du site</h2>
          <p><strong>Commune de Ménil</strong></p>
          <p>Mairie de Ménil<br>
          <?= e($content['contact']['address'] ?? 'Rue du Port') ?><br>
          <?= e($content['contact']['postalCode'] ?? '53200') ?> <?= e($content['contact']['city'] ?? 'Ménil') ?></p>
          <p>SIRET : 215 301 508 000 10</p>
          <p>Téléphone : <?= e($content['contact']['phone'] ?? '') ?></p>
          <p>Email : <a href="mailto:<?= e($content['contact']['emailMairie'] ?? '') ?>" class="text-green hover:text-forest transition-colors"><?= e($content['contact']['emailMairie'] ?? '') ?></a></p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Directeur de la publication</h2>
          <p>Le Maire de la commune de Ménil, en sa qualité de représentant légal de la collectivité.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Hébergement du site</h2>
          <p>Ce site est hébergé par la commune de Ménil ou son prestataire technique.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Propriété intellectuelle</h2>
          <p>L'ensemble du contenu de ce site (textes, images, graphismes, logo, icônes, etc.) est la propriété exclusive de la Commune de Ménil ou de ses partenaires, sauf mentions contraires.</p>
          <p class="mt-2">Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site est interdite sans l'autorisation écrite préalable de la Commune de Ménil.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Responsabilité</h2>
          <p>La Commune de Ménil s'efforce de fournir sur le site des informations aussi précises que possible. Toutefois, elle ne pourra être tenue responsable des omissions, des inexactitudes et des carences dans la mise à jour.</p>
          <p class="mt-2">Les liens hypertextes présents sur ce site peuvent renvoyer vers d'autres sites internet. La responsabilité de la Commune de Ménil ne saurait être engagée quant au contenu de ces sites.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Données personnelles</h2>
          <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles.</p>
          <p class="mt-2">Pour plus d'informations, consultez notre <a href="/politique-confidentialite" class="text-green hover:text-forest underline transition-colors">politique de confidentialité</a>.</p>
          <p class="mt-2">Contact DPO : <a href="mailto:<?= e($content['contact']['emailMairie'] ?? '') ?>" class="text-green hover:text-forest transition-colors"><?= e($content['contact']['emailMairie'] ?? '') ?></a></p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Crédits photos</h2>
          <p>Photographies : Commune de Ménil / Camping du Bac de Ménil. Tous droits réservés.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Droit applicable</h2>
          <p>Le présent site et ses mentions légales sont soumis au droit français. En cas de litige, les tribunaux français seront seuls compétents.</p>
        </div>

      </div>
    </div>
  </section>

</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
<script>
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => { if(e.isIntersecting) { e.target.classList.add('revealed'); observer.unobserve(e.target); }});
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
</body>
</html>
