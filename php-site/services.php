<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$services = $content['services'] ?? [];

$pageTitle = 'Services & Équipements';
$pageDescription = 'Wi-Fi gratuit, électricité, machine à laver, accessibilité PMR, animaux acceptés... Découvrez les services du Camping du Bac de Ménil.';
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
      <img src="<?= e(getImagePath($content['hero']['image'] ?? '')) ?>" alt="Services du Camping du Bac" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Services & Équipements</h1>
      <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-light">Tout ce qu'il faut pour un séjour sans souci — et quelques surprises en plus</p>
    </div>
  </section>

  <!-- Services Grid -->
  <section class="py-20 lg:py-28 bg-white reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Nos services</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Au Camping du Bac, les services ne sont pas un argument commercial : c'est simplement notre façon de vous accueillir. Wi-Fi, électricité, sanitaires entretenus quotidiennement, accessibilité PMR, accueil Vélo certifié : l'essentiel est là.</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <?php foreach ($services as $s): ?>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-white text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-moss flex items-center justify-center">
              <svg class="w-6 h-6 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <?= getServiceIcon($s['icon'] ?? 'wifi') ?>
              </svg>
            </div>
            <h3 class="font-heading text-lg text-forest mb-2"><?= e($s['title'] ?? '') ?></h3>
            <p class="text-gray-500 text-sm leading-relaxed"><?= e($s['description'] ?? '') ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Equipment & Facilities -->
  <section class="py-20 lg:py-28 bg-cream-dark reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Équipements & installations</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Les infrastructures du camping pour votre confort quotidien</p>
      </div>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
          <h3 class="font-heading text-2xl text-forest mb-6">Sanitaires — Propres, entretenus chaque jour</h3>
          <p class="text-gray-600 leading-relaxed mb-4">Les blocs sanitaires sont nettoyés quotidiennement. Douches chaudes gratuites, WC, lavabos, bacs de vaisselle et lessive. Machine à laver en libre-service disponible.</p>
          <ul class="space-y-3 text-gray-600">
            <?php
            $facilities = ['Douches chaudes gratuites', 'WC individuels', 'Bacs vaisselle et lessive', 'Espace bébé', 'Sanitaires PMR accessibles'];
            foreach ($facilities as $f): ?>
              <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <span><?= e($f) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="rounded-2xl overflow-hidden shadow-soft aspect-[4/3]">
          <img src="<?= e(getImagePath('/images/galerie/galerie-3.jpg')) ?>" alt="Sanitaires du camping" class="w-full h-full object-cover" loading="lazy" />
        </div>
      </div>
    </div>
  </section>

  <!-- Accessibility -->
  <section class="py-20 lg:py-28 bg-white reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-6">Camping accessible à tous</h2>
        <p class="text-gray-600 text-lg leading-relaxed mb-8">Le Camping du Bac s'engage à accueillir chaque visiteur dans les meilleures conditions. Emplacement PMR, chalet entièrement adapté, sanitaires accessibles et allées praticables en fauteuil roulant.</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
            <h3 class="font-heading text-lg text-forest mb-2">1 emplacement PMR</h3>
            <p class="text-gray-500 text-sm">Emplacement adapté et accessible</p>
          </div>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
            <h3 class="font-heading text-lg text-forest mb-2">1 chalet adapté</h3>
            <p class="text-gray-500 text-sm">Chalet de plain-pied avec équipements PMR</p>
          </div>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
            <h3 class="font-heading text-lg text-forest mb-2">Sanitaires PMR</h3>
            <p class="text-gray-500 text-sm">Bloc sanitaire accessible aux fauteuils roulants</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Additional info -->
  <section class="py-20 lg:py-28 bg-cream-dark reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Informations complémentaires</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-8 bg-white">
          <h3 class="font-heading text-lg text-forest mb-3">Animaux bienvenus (conditions)</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Vos compagnons à quatre pattes sont les bienvenus au Camping du Bac. Conditions : tenus en laisse en permanence, carnet de vaccination à jour. Chiens de catégorie 1 et 2 non admis.</p>
        </div>
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-8 bg-white">
          <h3 class="font-heading text-lg text-forest mb-3">Label Accueil Vélo — Étape certifiée Vélo Francette</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Le camping est officiellement reconnu par le label Accueil Vélo. Local vélos sécurisé, kit de réparation de base, informations sur les itinéraires et connexion directe au chemin de halage et à la Vélo Francette (V43).</p>
        </div>
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-8 bg-white">
          <h3 class="font-heading text-lg text-forest mb-3">Aire de vidange</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Une aire de service pour camping-cars est disponible à proximité du camping pour la vidange des eaux usées et le remplissage en eau propre.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-20 lg:py-28 bg-green relative overflow-hidden reveal">
    <div class="absolute inset-0 opacity-20">
      <div class="absolute top-0 left-0 w-96 h-96 rounded-full bg-white/10 -translate-x-1/2 -translate-y-1/2"></div>
      <div class="absolute bottom-0 right-0 w-72 h-72 rounded-full bg-white/10 translate-x-1/3 translate-y-1/3"></div>
    </div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
      <h2 class="font-heading text-3xl lg:text-4xl text-white mb-4">Des questions sur nos services ?</h2>
      <p class="text-white/80 text-lg mb-10 leading-relaxed">Contactez-nous pour toute information complémentaire sur nos équipements.</p>
      <a href="/contact" class="btn btn-lg bg-white text-forest hover:bg-cream border-white font-semibold">Nous contacter <?= arrowSvg() ?></a>
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
