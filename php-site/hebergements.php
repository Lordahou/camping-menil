<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$accommodations = $content['accommodations'] ?? [];

$pageTitle = 'Nos hébergements — Camping emplacement chalet gîte Mayenne Château-Gontier';
$pageDescription = 'Emplacements, chalets, tentes bivouac et maison éclusière au Camping du Bac de Ménil. Trouvez l\'hébergement idéal au bord de la Mayenne.';
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
      <img src="<?= e(getImagePath('/images/hebergements/chalets.jpg')) ?>" alt="Hébergements au Camping du Bac" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Nos hébergements</h1>
      <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-light">Du simple emplacement au gîte de caractère — trouvez votre façon de vivre le bord de Mayenne</p>
    </div>
  </section>

  <!-- Intro -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-6">Un hébergement pour chaque façon de voyager</h2>
      <p class="text-gray-600 text-lg leading-relaxed">Campeur avec tente et vélo, famille en quête de confort, couple cherchant un gîte de caractère ou groupe souhaitant privatiser une maison historique : le Camping du Bac a pensé à chacun d'entre vous.</p>
    </div>
  </section>

  <!-- Detailed accommodation sections -->
  <?php foreach ($accommodations as $i => $a): ?>
    <section class="py-20 lg:py-28 <?= $i % 2 === 0 ? 'bg-white' : 'bg-cream-dark' ?> reveal" id="<?= e($a['id'] ?? '') ?>">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          <!-- Image -->
          <div class="<?= $i % 2 === 1 ? 'lg:order-2' : '' ?>">
            <div class="relative rounded-2xl overflow-hidden shadow-soft aspect-[4/3]">
              <img src="<?= e(getImagePath($a['image'] ?? '')) ?>" alt="<?= e($a['imageAlt'] ?? '') ?>" class="w-full h-full object-cover" loading="lazy" />
              <?php if (!empty($a['count'])): ?>
                <span class="absolute top-4 left-4 badge bg-forest/90 text-white text-sm font-semibold px-4 py-1.5 rounded-full">
                  <?= e((string)$a['count']) ?> <?= $a['count'] > 1 ? 'disponibles' : 'disponible' ?>
                </span>
              <?php endif; ?>
              <?php if (!empty($a['capacity'])): ?>
                <span class="absolute bottom-4 left-4 badge bg-white/90 text-forest text-xs px-3 py-1 rounded-full"><?= e($a['capacity']) ?></span>
              <?php endif; ?>
            </div>
          </div>
          <!-- Content -->
          <div class="<?= $i % 2 === 1 ? 'lg:order-1' : '' ?>">
            <p class="text-green text-sm font-semibold uppercase tracking-wider mb-1"><?= e($a['subtitle'] ?? '') ?></p>
            <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4"><?= e($a['title'] ?? '') ?></h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-6"><?= e($a['description'] ?? '') ?></p>

            <div class="flex flex-wrap gap-2 mb-6">
              <?php foreach ($a['features'] ?? [] as $f): ?>
                <span class="badge bg-sage/10 text-forest text-sm px-4 py-1.5 rounded-full"><?= e($f) ?></span>
              <?php endforeach; ?>
            </div>

            <?php if (!empty($a['checkin']) || !empty($a['checkout'])): ?>
              <div class="bg-cream rounded-xl p-4 mb-6 border border-gray-100">
                <div class="grid grid-cols-2 gap-4 text-sm">
                  <?php if (!empty($a['checkin'])): ?>
                    <div>
                      <span class="text-gray-400 text-xs uppercase tracking-wider">Arrivée</span>
                      <p class="text-forest font-semibold"><?= e($a['checkin']) ?></p>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($a['checkout'])): ?>
                    <div>
                      <span class="text-gray-400 text-xs uppercase tracking-wider">Départ</span>
                      <p class="text-forest font-semibold"><?= e($a['checkout']) ?></p>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            <?php endif; ?>

            <div class="flex flex-wrap gap-3">
              <a href="/contact" class="btn btn-primary">Réserver <?= arrowSvg('w-4 h-4') ?></a>
              <a href="/tarifs" class="btn btn-outline">Voir les tarifs</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endforeach; ?>

  <!-- CTA -->
  <section class="py-20 lg:py-28 bg-green relative overflow-hidden reveal">
    <div class="absolute inset-0 opacity-20">
      <div class="absolute top-0 left-0 w-96 h-96 rounded-full bg-white/10 -translate-x-1/2 -translate-y-1/2"></div>
      <div class="absolute bottom-0 right-0 w-72 h-72 rounded-full bg-white/10 translate-x-1/3 translate-y-1/3"></div>
    </div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
      <h2 class="font-heading text-3xl lg:text-4xl text-white mb-4">Trouvé votre hébergement idéal ?</h2>
      <p class="text-white/80 text-lg mb-10 leading-relaxed">Réservez dès maintenant et profitez de notre cadre naturel au bord de la Mayenne.</p>
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="/contact" class="btn btn-lg bg-white text-forest hover:bg-cream border-white font-semibold">Réserver mon séjour <?= arrowSvg() ?></a>
        <a href="/tarifs" class="btn btn-secondary btn-lg">Consulter les tarifs</a>
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
