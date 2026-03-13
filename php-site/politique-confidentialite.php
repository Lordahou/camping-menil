<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$pageTitle = 'Politique de confidentialité';
$pageDescription = 'Politique de confidentialité du site Camping du Bac de Ménil. Informations RGPD, collecte de données et droits des utilisateurs.';
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
      <img src="<?= e(getImagePath($content['hero']['image'] ?? '')) ?>" alt="Politique de confidentialité" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Politique de confidentialité</h1>
    </div>
  </section>

  <!-- Content -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="space-y-10 text-gray-600 leading-relaxed">

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Introduction</h2>
          <p>La Commune de Ménil, éditrice du site <?= e($content['site']['url'] ?? '') ?>, s'engage à protéger la vie privée de ses utilisateurs conformément au Règlement Général sur la Protection des Données (RGPD - Règlement UE 2016/679) et à la loi Informatique et Libertés.</p>
          <p class="mt-2">Cette politique décrit comment nous collectons, utilisons et protégeons vos données personnelles.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Responsable du traitement</h2>
          <p><strong>Commune de Ménil</strong></p>
          <p>SIRET : 215 301 508 000 10</p>
          <p><?= e($content['contact']['address'] ?? '') ?>, <?= e($content['contact']['postalCode'] ?? '') ?> <?= e($content['contact']['city'] ?? '') ?></p>
          <p>Email : <a href="mailto:<?= e($content['contact']['emailMairie'] ?? '') ?>" class="text-green hover:text-forest transition-colors"><?= e($content['contact']['emailMairie'] ?? '') ?></a></p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Données collectées</h2>
          <p>Nous collectons uniquement les données strictement nécessaires au traitement de vos demandes :</p>
          <ul class="list-none space-y-2 mt-3">
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Formulaire de contact :</strong> nom, prénom, email, téléphone (facultatif), message</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Réservation en ligne :</strong> données transmises au prestataire Naxiresa (sous-traitant)</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Navigation :</strong> aucun cookie de suivi ou d'analyse n'est déposé sans votre consentement</span>
            </li>
          </ul>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Finalités du traitement</h2>
          <p>Vos données sont collectées pour les finalités suivantes :</p>
          <ul class="list-none space-y-2 mt-3">
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span>Répondre à vos demandes d'information et de réservation</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span>Gestion des réservations et du séjour</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span>Respect des obligations légales et réglementaires</span>
            </li>
          </ul>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Base légale</h2>
          <p>Le traitement de vos données repose sur :</p>
          <ul class="list-none space-y-2 mt-3">
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Votre consentement</strong> (formulaire de contact)</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>L'exécution d'un contrat</strong> (réservation)</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>L'obligation légale</strong> (fiche de police pour l'hébergement)</span>
            </li>
          </ul>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Durée de conservation</h2>
          <p>Vos données sont conservées pour la durée strictement nécessaire :</p>
          <ul class="list-none space-y-2 mt-3">
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span>Messages de contact : 12 mois</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span>Données de réservation : durée légale (fiches de police : 6 mois, comptabilité : 10 ans)</span>
            </li>
          </ul>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Vos droits</h2>
          <p>Conformément au RGPD, vous disposez des droits suivants sur vos données personnelles :</p>
          <ul class="list-none space-y-2 mt-3">
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Droit d'accès :</strong> obtenir une copie de vos données</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Droit de rectification :</strong> corriger vos données inexactes</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Droit à l'effacement :</strong> demander la suppression de vos données</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Droit d'opposition :</strong> vous opposer au traitement</span>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><strong>Droit à la portabilité :</strong> recevoir vos données dans un format structuré</span>
            </li>
          </ul>
          <p class="mt-4">Pour exercer vos droits, contactez-nous à <a href="mailto:<?= e($content['contact']['emailMairie'] ?? '') ?>" class="text-green hover:text-forest transition-colors"><?= e($content['contact']['emailMairie'] ?? '') ?></a>.</p>
          <p class="mt-2">Vous pouvez également introduire une réclamation auprès de la <a href="https://www.cnil.fr" target="_blank" rel="noopener noreferrer" class="text-green hover:text-forest underline transition-colors">CNIL</a>.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Cookies</h2>
          <p>Ce site utilise uniquement des cookies techniques strictement nécessaires au fonctionnement du site (session PHP). Aucun cookie de suivi, d'analyse ou publicitaire n'est déposé sans votre consentement explicite.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Sécurité</h2>
          <p>Nous mettons en place des mesures techniques et organisationnelles appropriées pour protéger vos données contre tout accès non autorisé, perte ou altération.</p>
        </div>

        <div>
          <h2 class="font-heading text-2xl text-forest mb-4">Mise à jour</h2>
          <p>Cette politique de confidentialité peut être mise à jour à tout moment. La date de dernière mise à jour figure ci-dessous.</p>
          <p class="mt-2 text-sm text-gray-400">Dernière mise à jour : <?= date('d/m/Y') ?></p>
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
