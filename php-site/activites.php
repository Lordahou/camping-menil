<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$activities = $content['activities'] ?? [];
$bac = $content['bac'] ?? [];
$surroundings = $content['surroundings'] ?? [];
$rentals = $content['tarifs']['rentals'] ?? [];

$pageTitle = 'Activités & Alentours';
$pageDescription = 'Canoë, pédalo, paddle, vélo, pêche, randonnée... Découvrez toutes les activités du Camping du Bac de Ménil et les sites à visiter aux alentours.';
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
      <img src="<?= e(getImagePath('/images/activites/canoe.jpg')) ?>" alt="Activités au Camping du Bac" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Activités & Alentours</h1>
      <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-light">Sur l'eau, à vélo ou à pied : explorez, jouez, détendez-vous</p>
    </div>
  </section>

  <!-- Activities cards grid -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">De quoi bien s'occuper</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Des activités nautiques, du plein air et des loisirs pour tous les âges</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($activities as $a): ?>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all overflow-hidden bg-white group">
            <div class="relative aspect-[3/2] overflow-hidden">
              <img src="<?= e(getImagePath($a['image'] ?? '')) ?>" alt="<?= e($a['title'] ?? '') ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <?php if (!empty($a['category'])): ?>
                <span class="absolute top-4 left-4 badge bg-white/90 text-forest text-xs font-medium px-3 py-1 rounded-full"><?= e($a['category']) ?></span>
              <?php endif; ?>
            </div>
            <div class="p-5 lg:p-6">
              <h3 class="font-heading text-lg text-forest mb-2"><?= e($a['title'] ?? '') ?></h3>
              <p class="text-gray-500 text-sm leading-relaxed"><?= e($a['description'] ?? '') ?></p>
              <?php if (!empty($a['price'])): ?>
                <p class="text-green text-sm font-semibold mt-3"><?= e($a['price']) ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Le Bac immersive -->
  <section class="relative py-20 lg:py-28 overflow-hidden reveal">
    <div class="absolute inset-0">
      <img src="<?= e(getImagePath('/images/activites/bac-menil.jpg')) ?>" alt="Le Bac de Ménil" class="w-full h-full object-cover" loading="lazy" />
      <div class="absolute inset-0 bg-forest/80 backdrop-blur-sm"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
          <span class="badge bg-white/15 text-white/90 mb-4 inline-flex">Patrimoine fluvial</span>
          <h2 class="font-heading text-3xl lg:text-4xl text-white mb-6">Le Bac de Ménil</h2>
          <p class="text-white/80 text-lg leading-relaxed mb-4"><?= e($bac['description'] ?? '') ?></p>
          <p class="text-white/60 text-sm mb-4"><?= e($bac['price'] ?? '') ?></p>
          <p class="text-white/50 text-xs"><?= e($bac['restrictions'] ?? '') ?></p>
        </div>
        <div>
          <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/10">
            <h4 class="text-white font-semibold mb-4">Horaires du Bac</h4>
            <div class="space-y-4">
              <div>
                <p class="text-sage text-sm font-semibold mb-2">Basse saison</p>
                <p class="text-white/50 text-xs mb-2"><?= e($bac['schedules']['lowSeason']['period'] ?? '') ?></p>
                <div class="flex flex-wrap gap-2">
                  <?php foreach ($bac['schedules']['lowSeason']['times'] ?? [] as $t): ?>
                    <span class="text-white/80 text-sm bg-white/5 px-3 py-1 rounded-full"><?= e($t) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="border-t border-white/10 pt-4">
                <p class="text-sage text-sm font-semibold mb-2">Haute saison</p>
                <p class="text-white/50 text-xs mb-2"><?= e($bac['schedules']['highSeason']['period'] ?? '') ?></p>
                <div class="flex flex-wrap gap-2">
                  <?php foreach ($bac['schedules']['highSeason']['times'] ?? [] as $t): ?>
                    <span class="text-white/80 text-sm bg-white/5 px-3 py-1 rounded-full"><?= e($t) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Rental pricing -->
  <?php if (!empty($rentals['items'])): ?>
    <section class="py-20 lg:py-28 bg-cream-dark reveal">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card rounded-2xl shadow-soft overflow-hidden bg-white">
          <div class="bg-forest p-6">
            <h2 class="text-white font-heading text-xl mb-1"><?= e($rentals['title'] ?? 'Location loisirs') ?></h2>
            <p class="text-white/60 text-sm"><?= e($rentals['description'] ?? '') ?></p>
          </div>
          <div class="divide-y divide-gray-100">
            <?php foreach ($rentals['items'] as $item): ?>
              <div class="flex items-center justify-between px-6 py-4 hover:bg-cream/50 transition-colors">
                <span class="text-gray-700"><?= e($item['label'] ?? '') ?></span>
                <span class="text-forest font-semibold whitespace-nowrap ml-4"><?= e($item['price'] ?? '') ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- Surroundings -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Aux alentours</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Le sud Mayenne regorge de trésors : patrimoine, nature et culture à portée de main</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
        <?php foreach ($surroundings as $s): ?>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-white">
            <div class="flex items-start justify-between mb-3">
              <h3 class="font-heading text-lg text-forest"><?= e($s['title'] ?? '') ?></h3>
              <span class="badge bg-sage/10 text-forest text-xs font-semibold px-3 py-1 rounded-full whitespace-nowrap ml-3"><?= e($s['distance'] ?? '') ?></span>
            </div>
            <p class="text-gray-500 text-sm leading-relaxed"><?= e($s['description'] ?? '') ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Tourism links -->
  <section class="py-12 bg-cream-dark reveal">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h3 class="font-heading text-xl text-forest mb-6">Liens utiles tourisme</h3>
      <div class="flex flex-wrap items-center justify-center gap-4">
        <a href="https://www.mayenne-tourisme.com" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">Mayenne Tourisme</a>
        <a href="https://www.francevelotourisme.com" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">France Vélo Tourisme</a>
        <a href="https://www.lavelofrancette.com" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">La Vélo Francette</a>
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
      <h2 class="font-heading text-3xl lg:text-4xl text-white mb-4">Prêt pour l'aventure ?</h2>
      <p class="text-white/80 text-lg mb-10 leading-relaxed">Réservez votre séjour et profitez de toutes ces activités au bord de la Mayenne.</p>
      <a href="/contact" class="btn btn-lg bg-white text-forest hover:bg-cream border-white font-semibold">Réserver mon séjour <?= arrowSvg() ?></a>
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
