<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$tarifs = $content['tarifs'] ?? [];

$pageTitle = 'Tarifs camping Mayenne 2026 — emplacement chalet location';
$pageDescription = 'Tarifs des emplacements, chalets, tentes bivouac et locations de loisirs au Camping du Bac de Ménil. Réservez votre séjour au bord de la Mayenne.';
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
      <img src="<?= e(getImagePath($content['hero']['image'] ?? '')) ?>" alt="Tarifs du Camping du Bac" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Nos Tarifs</h1>
      <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-light">Des tarifs accessibles, dans un cadre exceptionnel</p>
    </div>
  </section>

  <!-- Note disclaimer -->
  <section class="py-8 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-sage/10 rounded-2xl p-6 border border-sage/20 text-center reveal">
        <p class="text-forest text-sm leading-relaxed">
          <?= e($tarifs['note'] ?? 'Tarifs indicatifs — Consultez-nous pour les tarifs à jour.') ?>
          N'hésitez pas à <a href="/contact" class="text-green underline hover:text-forest">nous contacter</a>.
        </p>
      </div>
    </div>
  </section>

  <!-- Pricing tables -->
  <?php
  $categories = ['emplacements', 'chalets', 'bivouac', 'rentals'];
  foreach ($categories as $ci => $catKey):
    $cat = $tarifs[$catKey] ?? null;
    if (!$cat) continue;
  ?>
    <section class="py-12 lg:py-16 <?= $ci % 2 === 0 ? 'bg-cream' : 'bg-cream-dark' ?>">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal">
          <div class="card rounded-2xl shadow-soft overflow-hidden bg-white">
            <div class="bg-forest p-6">
              <h2 class="text-white font-heading text-xl mb-1"><?= e($cat['title'] ?? '') ?></h2>
              <p class="text-white/60 text-sm"><?= e($cat['description'] ?? '') ?></p>
            </div>
            <div class="divide-y divide-gray-100">
              <?php foreach ($cat['items'] ?? [] as $item): ?>
                <div class="flex items-center justify-between px-6 py-4 hover:bg-cream/50 transition-colors">
                  <span class="text-gray-700"><?= e($item['label'] ?? '') ?></span>
                  <span class="text-forest font-semibold whitespace-nowrap ml-4"><?= e($item['price'] ?? '') ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php if (!empty($cat['footnote'])): ?>
            <p class="text-gray-400 text-xs mt-3 px-2"><?= e($cat['footnote']) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endforeach; ?>

  <!-- Payment methods -->
  <section class="py-20 lg:py-28 bg-white reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-8">Moyens de paiement acceptés</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
            <h3 class="font-heading text-lg text-forest mb-2">Carte bancaire</h3>
            <p class="text-gray-500 text-sm">CB, Visa, Mastercard</p>
          </div>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
            <h3 class="font-heading text-lg text-forest mb-2">Chèques</h3>
            <p class="text-gray-500 text-sm">Chèques bancaires</p>
          </div>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
            <h3 class="font-heading text-lg text-forest mb-2">Chèques vacances</h3>
            <p class="text-gray-500 text-sm">ANCV acceptés</p>
          </div>
        </div>
        <?php if (!empty($tarifs['paymentNote'])): ?>
          <p class="text-gray-400 text-xs text-center mt-6"><?= e($tarifs['paymentNote']) ?></p>
        <?php endif; ?>
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
      <h2 class="font-heading text-3xl lg:text-4xl text-white mb-4">Prêt à réserver ?</h2>
      <p class="text-white/80 text-lg mb-10 leading-relaxed">Contactez-nous pour obtenir un devis personnalisé ou réservez directement en ligne.</p>
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
