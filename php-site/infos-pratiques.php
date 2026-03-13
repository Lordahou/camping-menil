<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$contact = $content['contact'] ?? [];
$openingDates = $content['openingDates'] ?? [];
$bac = $content['bac'] ?? [];
$faq = $content['faq'] ?? [];
$phone = $contact['phone'] ?? '';
$phoneTel = formatPhone($phone);

$pageTitle = 'Infos pratiques';
$pageDescription = 'Dates d\'ouverture, accès, règlement intérieur, FAQ... Toutes les informations pratiques pour votre séjour au Camping du Bac de Ménil.';
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
      <img src="<?= e(getImagePath($content['hero']['image'] ?? '')) ?>" alt="Infos pratiques Camping du Bac" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Infos pratiques</h1>
      <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-light">Tout ce qu'il faut savoir pour préparer votre séjour</p>
    </div>
  </section>

  <!-- Opening dates -->
  <section class="py-20 lg:py-28 bg-white reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Dates d'ouverture</h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-4xl mx-auto">
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
          <h3 class="font-heading text-lg text-forest mb-3">Emplacements</h3>
          <p class="text-gray-600 text-sm"><?= e($openingDates['emplacements']['start'] ?? '') ?></p>
          <p class="text-gray-600 text-sm">au <?= e($openingDates['emplacements']['end'] ?? '') ?></p>
        </div>
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
          <h3 class="font-heading text-lg text-forest mb-3">Chalets</h3>
          <p class="text-green font-semibold"><?= e($openingDates['chalets'] ?? '') ?></p>
        </div>
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-cream text-center">
          <h3 class="font-heading text-lg text-forest mb-3">Maison éclusière</h3>
          <p class="text-green font-semibold"><?= e($openingDates['maisonEclusiere'] ?? '') ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Check-in / Check-out / Payments -->
  <section class="py-20 lg:py-28 bg-cream-dark reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-white text-center">
          <svg class="w-8 h-8 text-forest mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <h3 class="font-heading text-lg text-forest mb-2">Arrivée</h3>
          <p class="text-gray-600 text-sm">Emplacements : 12h00</p>
          <p class="text-gray-600 text-sm">Chalets : 16h00</p>
        </div>
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-white text-center">
          <svg class="w-8 h-8 text-forest mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 8 14"/></svg>
          <h3 class="font-heading text-lg text-forest mb-2">Départ</h3>
          <p class="text-gray-600 text-sm">Emplacements : 12h00</p>
          <p class="text-gray-600 text-sm">Chalets : 10h00</p>
        </div>
        <div class="card rounded-2xl shadow-soft hover:shadow-md transition-all p-6 bg-white text-center">
          <svg class="w-8 h-8 text-forest mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          <h3 class="font-heading text-lg text-forest mb-2">Paiements</h3>
          <p class="text-gray-600 text-sm">CB, chèques,</p>
          <p class="text-gray-600 text-sm">chèques vacances</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Rules -->
  <section class="py-20 lg:py-28 bg-white reveal">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Règles du camping</h2>
      </div>
      <ul class="space-y-3 text-gray-600">
        <?php
        $rules = [
          'Silence entre 22h et 8h',
          'Animaux acceptés, tenus en laisse, carnet de vaccination à jour',
          'Barbecues surélevés autorisés uniquement',
          'Vitesse limitée à 5 km/h dans le camping',
          'Tri sélectif obligatoire',
        ];
        foreach ($rules as $rule): ?>
          <li class="flex items-start gap-3">
            <svg class="w-5 h-5 text-green flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            <span><?= e($rule) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <!-- How to get there -->
  <section class="py-20 lg:py-28 bg-cream-dark reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
          <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-6">Comment venir ?</h2>
          <div class="space-y-4 text-gray-600 leading-relaxed">
            <p><strong>Adresse :</strong> <?= e($contact['address'] ?? '') ?>, <?= e($contact['postalCode'] ?? '') ?> <?= e($contact['city'] ?? '') ?></p>
            <p><strong>GPS :</strong> <?= e((string)($contact['latitude'] ?? '')) ?>, <?= e((string)($contact['longitude'] ?? '')) ?></p>
            <p><strong>En voiture :</strong> À 5 minutes de Château-Gontier par la D22.</p>
            <p><strong>À vélo :</strong> Directement sur l'itinéraire de La Vélo Francette (V43), le long du chemin de halage de la Mayenne.</p>
            <p><strong>En train :</strong> Gare de Château-Gontier à 5 km. Correspondances TER depuis Laval et Angers.</p>
          </div>
          <div class="mt-6">
            <a href="<?= e($contact['googleMapsUrl'] ?? '#') ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
              Voir sur Google Maps <?= arrowSvg('w-4 h-4') ?>
            </a>
          </div>
        </div>
        <div class="rounded-2xl overflow-hidden shadow-soft h-[350px]">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2700!2d<?= e((string)($contact['longitude'] ?? '')) ?>!3d<?= e((string)($contact['latitude'] ?? '')) ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDfCsDQ2JzI5LjUiTiAwwrA0MCcyNC4wIlc!5e0!3m2!1sfr!2sfr!4v1"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" title="Carte du Camping du Bac de Ménil"
          ></iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- Le Bac schedule -->
  <section class="py-20 lg:py-28 bg-forest text-white reveal">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="font-heading text-3xl lg:text-4xl mb-4">Horaires du Bac de Ménil</h2>
        <p class="text-white/60"><?= e($bac['restrictions'] ?? '') ?></p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php if (!empty($bac['schedules'])): ?>
          <?php foreach ($bac['schedules'] as $key => $schedule): ?>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
              <h3 class="font-heading text-xl text-sage mb-2"><?= $key === 'lowSeason' ? 'Basse saison' : 'Haute saison' ?></h3>
              <p class="text-white/60 text-sm mb-4"><?= e($schedule['period'] ?? '') ?></p>
              <div class="flex flex-wrap gap-2">
                <?php foreach ($schedule['times'] ?? [] as $t): ?>
                  <span class="text-white/80 text-sm bg-white/5 px-3 py-1 rounded-full"><?= e($t) ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="font-heading text-3xl lg:text-4xl text-forest mb-4">Questions fréquentes</h2>
      </div>
      <div class="space-y-3">
        <?php foreach ($faq as $item): ?>
          <details class="group card rounded-2xl shadow-soft overflow-hidden bg-white">
            <summary class="flex items-center justify-between p-6 cursor-pointer text-forest font-semibold hover:bg-cream transition-colors">
              <?= e($item['question'] ?? '') ?>
              <svg class="w-5 h-5 text-green flex-shrink-0 ml-4 transition-transform duration-300 group-open:rotate-45" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </summary>
            <div class="px-6 pb-6 text-gray-600 leading-relaxed"><?= e($item['answer'] ?? '') ?></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Quick contact -->
  <section class="py-16 bg-cream-dark reveal">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="font-heading text-2xl text-forest mb-6">Une question ?</h2>
      <p class="text-gray-600 text-lg mb-8">N'hésitez pas à nous contacter, nous serons ravis de vous répondre.</p>
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="tel:<?= e($phoneTel) ?>" class="btn btn-primary"><?= e($phone) ?></a>
        <a href="/contact" class="btn btn-outline">Formulaire de contact</a>
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
