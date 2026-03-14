<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$site = $content['site'] ?? [];
$hero = $content['hero'] ?? [];
$highlights = $content['highlights'] ?? [];
$accommodations = $content['accommodations'] ?? [];
$services = $content['services'] ?? [];
$activities = $content['activities'] ?? [];
$testimonials = $content['testimonials'] ?? [];
$surroundings = $content['surroundings'] ?? [];
$bac = $content['bac'] ?? [];
$contact = $content['contact'] ?? [];

$pageTitle = 'Camping municipal Ménil Mayenne — Bord de Mayenne — Vélo Francette — Bac de Ménil';
$pageDescription = 'Camping municipal 2 étoiles au bord de la Mayenne à Ménil (53). Emplacements, chalets, tentes bivouac, maison éclusière. Vélo Francette, Bac de Ménil. Note 9.6/10. Réservez en ligne.';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php include __DIR__ . '/includes/head.php'; ?>
</head>
<body class="bg-cream font-body text-gray-800 antialiased">
<?php include __DIR__ . '/includes/header.php'; ?>
<main>

  <!-- Hero — full viewport -->
  <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
      <img
        src="<?= e(getImagePath($hero['image'] ?? '/images/hero/camping-menil-panorama.jpg')) ?>"
        alt="<?= e($hero['imageAlt'] ?? 'Camping du Bac de Ménil') ?>"
        class="w-full h-full object-cover"
        fetchpriority="high"
      />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-32">
      <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm rounded-full px-4 py-2 mb-8">
        <?= starSvg('w-4 h-4 text-sage') ?>
        <span class="text-white/90 text-sm font-medium">Noté <?= e($site['rating'] ?? '9.6/10') ?> par nos visiteurs</span>
      </div>
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-7xl text-white mb-6 leading-tight">
        <?= e($hero['title'] ?? '') ?>
      </h1>
      <p class="text-lg sm:text-xl lg:text-2xl text-white/80 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
        <?= e($hero['subtitle'] ?? '') ?>
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="<?= e($hero['cta1']['url'] ?? '/contact') ?>" class="btn btn-primary btn-lg">
          <?= e($hero['cta1']['text'] ?? 'Réserver') ?>
          <?= arrowSvg('w-5 h-5') ?>
        </a>
        <a href="<?= e($hero['cta2']['url'] ?? '/le-camping') ?>" class="btn btn-secondary btn-lg">
          <?= e($hero['cta2']['text'] ?? 'Découvrir') ?>
        </a>
      </div>
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
      <svg class="w-6 h-6 text-white/50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
    </div>
  </section>

  <!-- Intro — rating badge -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-sage/10 rounded-full px-4 py-2 mb-8">
          <div class="flex gap-0.5">
            <?php for ($i = 0; $i < ($site['stars'] ?? 2); $i++): ?>
              <?= starSvg('w-4 h-4 text-sage') ?>
            <?php endfor; ?>
          </div>
          <span class="text-forest text-sm font-bold"><?= e($site['rating'] ?? '') ?></span>
          <span class="text-gray-500 text-sm"><?= e($site['ratingSource'] ?? '') ?></span>
        </div>
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-6"><?= e($site['shortName'] ?? 'Camping du Bac') ?></h2>
        <p class="text-gray-600 text-lg leading-relaxed">
          Niché au bord de la Mayenne, le Camping du Bac vous accueille dans un cadre
          verdoyant et paisible, entre chemin de halage et rivière. À 5 minutes de Château-Gontier,
          sur l'itinéraire de La Vélo Francette, c'est le lieu idéal pour des vacances nature,
          en famille ou entre amis.
        </p>
      </div>
    </div>
  </section>

  <!-- Highlights — 6 cards grid -->
  <section class="py-20 lg:py-28 bg-cream-dark reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Pourquoi nous choisir</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Un cadre exceptionnel et des services pensés pour votre confort</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        <?php foreach ($highlights as $h): ?>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 lg:p-8 bg-white text-center">
            <div class="w-14 h-14 mx-auto mb-5 rounded-2xl bg-moss flex items-center justify-center">
              <svg class="w-6 h-6 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <?= getHighlightIcon($h['icon'] ?? 'star') ?>
              </svg>
            </div>
            <h3 class="font-heading text-lg text-forest mb-2"><?= e($h['title'] ?? '') ?></h3>
            <p class="text-gray-500 text-sm leading-relaxed"><?= e($h['description'] ?? '') ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Accommodations — 4 cards -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Trouvez votre coin de paradis</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Emplacements, chalets, tentes bivouac ou maison éclusière : il y en a pour tous les goûts</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
        <?php foreach ($accommodations as $a): ?>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all overflow-hidden bg-white group">
            <div class="relative overflow-hidden aspect-[4/3]">
              <img
                src="<?= e(getImagePath($a['image'] ?? '')) ?>"
                alt="<?= e($a['imageAlt'] ?? '') ?>"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                loading="lazy"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <?php if (!empty($a['capacity'])): ?>
                <span class="absolute bottom-4 left-4 badge bg-white/90 text-forest text-xs"><?= e($a['capacity']) ?></span>
              <?php endif; ?>
            </div>
            <div class="p-6 lg:p-8">
              <p class="text-green text-sm font-semibold uppercase tracking-wider mb-1"><?= e($a['subtitle'] ?? '') ?></p>
              <h3 class="font-heading text-xl text-forest mb-3"><?= e($a['title'] ?? '') ?></h3>
              <p class="text-gray-500 text-sm leading-relaxed mb-5"><?= e($a['description'] ?? '') ?></p>
              <div class="flex flex-wrap gap-2 mb-6">
                <?php foreach (array_slice($a['features'] ?? [], 0, 5) as $f): ?>
                  <span class="text-xs px-3 py-1 rounded-full bg-moss/50 text-forest font-medium"><?= e($f) ?></span>
                <?php endforeach; ?>
              </div>
              <a href="/hebergements#<?= e($a['id'] ?? '') ?>" class="btn btn-outline btn-sm w-full text-center">
                Découvrir <?= arrowSvg('w-3.5 h-3.5') ?>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-12">
        <a href="/hebergements" class="btn btn-outline btn-lg">Tous nos hébergements <?= arrowSvg() ?></a>
      </div>
    </div>
  </section>

  <!-- Le Bac immersive — dark bg -->
  <section class="relative py-20 lg:py-28 overflow-hidden reveal">
    <div class="absolute inset-0">
      <img src="<?= e(getImagePath('/images/activites/bac-menil.jpg')) ?>" alt="Le Bac de Ménil sur la Mayenne" class="w-full h-full object-cover" loading="lazy" />
      <div class="absolute inset-0 bg-forest/80 backdrop-blur-sm"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
          <span class="badge bg-white/15 text-white/90 mb-4 inline-flex">Expérience unique</span>
          <h2 class="font-heading text-3xl lg:text-4xl text-white mb-6">Le Bac de Ménil</h2>
          <p class="text-white/80 text-lg leading-relaxed mb-4"><?= e($bac['description'] ?? '') ?></p>
          <p class="text-white/60 text-sm mb-8"><?= e($bac['price'] ?? '') ?> &mdash; <?= e($bac['restrictions'] ?? '') ?></p>
          <a href="/activites" class="btn btn-secondary">En savoir plus <?= arrowSvg() ?></a>
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

  <!-- Services — icon grid -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Tout pour votre confort</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Des équipements et services pensés pour un séjour sans souci</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <?php foreach ($services as $s): ?>
          <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-white/50 transition-colors duration-200">
            <div class="w-12 h-12 rounded-xl bg-moss flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <?= getServiceIcon($s['icon'] ?? 'wifi') ?>
              </svg>
            </div>
            <div>
              <h4 class="font-semibold text-forest text-sm mb-0.5"><?= e($s['title'] ?? '') ?></h4>
              <p class="text-gray-500 text-sm"><?= e($s['description'] ?? '') ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-10">
        <a href="/services" class="btn btn-outline btn-sm">Tous nos services</a>
      </div>
    </div>
  </section>

  <!-- Activities — card grid with category badges -->
  <section class="py-20 lg:py-28 bg-cream-dark reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Explorez, jouez, détendez-vous</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Sur l'eau, à vélo ou à pied : le camping et ses environs regorgent d'activités</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($activities as $a): ?>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all overflow-hidden bg-white group">
            <div class="relative aspect-[3/2] overflow-hidden">
              <img src="<?= e(getImagePath($a['image'] ?? '')) ?>" alt="<?= e($a['title'] ?? '') ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <span class="absolute top-4 left-4 badge bg-white/90 text-forest text-xs"><?= e($a['category'] ?? '') ?></span>
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
      <div class="text-center mt-12">
        <a href="/activites" class="btn btn-outline btn-lg">Toutes les activités</a>
      </div>
    </div>
  </section>

  <!-- Testimonials — dark bg, star ratings -->
  <section class="py-20 lg:py-28 bg-forest text-white reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl mb-4">Ce qu'ils en disent</h2>
        <div class="flex items-center justify-center gap-3">
          <span class="text-sage text-3xl font-heading"><?= e($site['rating'] ?? '9.6/10') ?></span>
          <div class="text-left">
            <div class="flex gap-0.5">
              <?php for ($i = 0; $i < 5; $i++): ?>
                <?= starSvg() ?>
              <?php endfor; ?>
            </div>
            <span class="text-white/50 text-xs">Excellent &mdash; <?= e($site['ratingSource'] ?? 'Fairguest') ?></span>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        <?php foreach ($testimonials as $t): ?>
          <div class="bg-white/8 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:bg-white/12 transition-all duration-300">
            <div class="flex gap-1 mb-4">
              <?php for ($s = 0; $s < ($t['rating'] ?? 5); $s++): ?>
                <?= starSvg() ?>
              <?php endfor; ?>
            </div>
            <blockquote class="text-white/80 text-sm leading-relaxed mb-6 italic">
              &laquo; <?= e($t['text'] ?? '') ?> &raquo;
            </blockquote>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-sage/20 flex items-center justify-center text-sage font-semibold text-sm">
                <?= e(mb_substr($t['author'] ?? '', 0, 1)) ?>
              </div>
              <div>
                <p class="text-white font-medium text-sm"><?= e($t['author'] ?? '') ?></p>
                <p class="text-white/40 text-xs"><?= e($t['origin'] ?? '') ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Surroundings — distance badges -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Un territoire à explorer</h2>
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

  <!-- CTA Banner — green bg -->
  <section class="py-20 lg:py-28 bg-green relative overflow-hidden reveal">
    <div class="absolute inset-0 opacity-20">
      <div class="absolute top-0 left-0 w-96 h-96 rounded-full bg-white/10 -translate-x-1/2 -translate-y-1/2"></div>
      <div class="absolute bottom-0 right-0 w-72 h-72 rounded-full bg-white/10 translate-x-1/3 translate-y-1/3"></div>
    </div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
      <h2 class="font-heading text-3xl lg:text-4xl text-white mb-4">Prêt à vivre l'expérience Ménil ?</h2>
      <p class="text-white/80 text-lg mb-10 leading-relaxed">Réservez votre séjour au bord de la Mayenne et profitez d'un cadre naturel exceptionnel.</p>
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="/contact" class="btn btn-lg bg-white text-forest hover:bg-cream border-white font-semibold">
          Réserver mon séjour <?= arrowSvg() ?>
        </a>
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
