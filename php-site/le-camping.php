<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$site = $content['site'] ?? [];
$contact = $content['contact'] ?? [];
$bac = $content['bac'] ?? [];

$pageTitle = 'Le Camping';
$pageDescription = 'Découvrez le Camping du Bac de Ménil, camping 2 étoiles au bord de la Mayenne. Un cadre naturel entre rivière et chemin de halage, à 5 min de Château-Gontier.';
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
      <img src="<?= e(getImagePath($content['hero']['image'] ?? '')) ?>" alt="Le Camping du Bac de Ménil" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Le Camping</h1>
      <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-light">Un coin de nature au bord de la Mayenne, entre chemin de halage et rivière</p>
    </div>
  </section>

  <!-- History / Presentation -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <div>
          <span class="badge bg-sage/10 text-forest text-xs font-semibold px-3 py-1 rounded-full mb-4 inline-block">Notre histoire</span>
          <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-6">Un camping municipal au caractère unique</h2>
          <div class="space-y-4 text-gray-600 leading-relaxed">
            <p>
              Géré par la commune de Ménil, le Camping du Bac est un lieu d'accueil chaleureux niché au bord de la Mayenne.
              Avec ses 34 emplacements ombragés, ses chalets tout confort, ses tentes bivouac pour cyclistes et sa maison
              éclusière de caractère, il offre une expérience de séjour variée et authentique.
            </p>
            <p>
              Situé sur l'itinéraire de La Vélo Francette et labellisé Accueil Vélo, le camping est une étape idéale pour
              les cyclistes de passage comme pour les familles en quête de nature et de tranquillité.
            </p>
            <p>
              Le camping tire son nom du Bac de Ménil, dernier bac à traction manuelle du département de la Mayenne,
              qui permet de traverser la rivière juste à côté du camping.
            </p>
          </div>
        </div>
        <div class="relative rounded-2xl overflow-hidden aspect-[4/3] shadow-soft">
          <img src="<?= e(getImagePath('/images/galerie/galerie-1.jpg')) ?>" alt="Vue du camping au bord de la Mayenne" class="w-full h-full object-cover" loading="lazy" />
        </div>
      </div>
    </div>
  </section>

  <!-- Values -->
  <section class="py-20 lg:py-28 bg-cream-dark reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Nos valeurs</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Ce qui fait l'âme du Camping du Bac</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php
        $values = [
          ['icon' => '<path d="M17 8c.7-1 1-2.2 1-3.5C18 2.5 16 1 16 1s-2 1.5-2 3.5c0 1.3.3 2.5 1 3.5"/><path d="M12 12c-1.5-2-2.5-3.5-2.5-5.5C9.5 3.5 12 1 12 1s2.5 2.5 2.5 5.5c0 2-1 3.5-2.5 5.5z"/><path d="M7 8c-.7-1-1-2.2-1-3.5C6 2.5 8 1 8 1s2 1.5 2 3.5c0 1.3-.3 2.5-1 3.5"/><path d="M12 22v-10"/><path d="M8 18c-2 0-4-1-4-3.5S8 10 8 10"/><path d="M16 18c2 0 4-1 4-3.5S16 10 16 10"/>',
           'title' => 'Nature', 'desc' => 'Un environnement préservé au bord de la Mayenne, avec des espaces verts, des arbres centenaires et un accès direct à la rivière.'],
          ['icon' => '<path d="M2 12s3-3 5-3c3 0 4 3 7 3s4-3 7-3 3 3 3 3"/><path d="M2 18s3-3 5-3c3 0 4 3 7 3s4-3 7-3 3 3 3 3" opacity="0.5"/>',
           'title' => 'Calme', 'desc' => 'Loin du tumulte, le camping est un havre de paix où le chant des oiseaux et le murmure de la rivière sont vos seuls compagnons.'],
          ['icon' => '<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>',
           'title' => 'Authenticité', 'desc' => 'Un accueil chaleureux, un patrimoine fluvial unique avec le Bac de Ménil, et la simplicité d\'un camping municipal à taille humaine.'],
        ];
        foreach ($values as $v): ?>
          <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-8 bg-white text-center">
            <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-sage/10 flex items-center justify-center">
              <svg class="w-8 h-8 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><?= $v['icon'] ?></svg>
            </div>
            <h3 class="font-heading text-2xl text-forest mb-3"><?= e($v['title']) ?></h3>
            <p class="text-gray-600 leading-relaxed"><?= e($v['desc']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Location / Map -->
  <section class="py-20 lg:py-28 bg-white reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Situation</h2>
        <p class="text-gray-600"><?= e($contact['address'] ?? '') ?>, <?= e($contact['postalCode'] ?? '') ?> <?= e($contact['city'] ?? '') ?> &mdash; <?= e($contact['department'] ?? '') ?></p>
      </div>
      <div class="rounded-2xl overflow-hidden shadow-soft h-[400px] lg:h-[500px]">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2700!2d<?= e((string)($contact['longitude'] ?? '')) ?>!3d<?= e((string)($contact['latitude'] ?? '')) ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDfCsDQ2JzI5LjUiTiAwwrA0MCcyNC4wIlc!5e0!3m2!1sfr!2sfr!4v1"
          width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade" title="Carte du Camping du Bac de Ménil"
        ></iframe>
      </div>
    </div>
  </section>

  <!-- Awards / Labels -->
  <section class="py-20 lg:py-28 bg-cream-dark reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Labels & distinctions</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Des engagements reconnus pour la qualité de votre séjour</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-4xl mx-auto">
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-white text-center">
          <div class="flex gap-0.5 justify-center mb-3">
            <?php for ($i = 0; $i < ($site['stars'] ?? 2); $i++): ?>
              <?= starSvg('w-5 h-5 text-sage') ?>
            <?php endfor; ?>
          </div>
          <h3 class="font-heading text-lg text-forest mb-2">Camping <?= e((string)($site['stars'] ?? 2)) ?> étoiles</h3>
          <p class="text-gray-500 text-sm">Classement officiel Atout France</p>
        </div>
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-white text-center">
          <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-sage/10 flex items-center justify-center">
            <svg class="w-6 h-6 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><?= getServiceIcon('bike-parking') ?></svg>
          </div>
          <h3 class="font-heading text-lg text-forest mb-2">Accueil Vélo</h3>
          <p class="text-gray-500 text-sm">Étape labellisée sur La Vélo Francette</p>
        </div>
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-white text-center">
          <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-sage/10 flex items-center justify-center">
            <svg class="w-6 h-6 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><?= getHighlightIcon('star') ?></svg>
          </div>
          <h3 class="font-heading text-lg text-forest mb-2">Noté <?= e($site['rating'] ?? '9.6/10') ?></h3>
          <p class="text-gray-500 text-sm">Avis vérifiés <?= e($site['ratingSource'] ?? 'Fairguest') ?></p>
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
