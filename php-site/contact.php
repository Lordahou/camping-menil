<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$contact = $content['contact'] ?? [];
$site = $content['site'] ?? [];
$openingDates = $content['openingDates'] ?? [];
$phone = $contact['phone'] ?? '';
$phoneTel = formatPhone($phone);
$email = $contact['email'] ?? '';
$bookingUrl = $site['bookingUrl'] ?? '#';
$csrfToken = generateCSRF();

$pageTitle = 'Contact & Réservation';
$pageDescription = 'Contactez le Camping du Bac de Ménil pour réserver votre séjour. Réservation en ligne, téléphone ou email. Camping au bord de la Mayenne à Ménil (53).';
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
      <img src="<?= e(getImagePath($content['hero']['image'] ?? '')) ?>" alt="Contact Camping du Bac" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Contact & Réservation</h1>
      <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-light">Réservez en ligne ou contactez-nous pour préparer votre séjour</p>
    </div>
  </section>

  <!-- Online booking banner -->
  <section class="py-12 bg-cream">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-forest rounded-2xl p-8 lg:p-10 text-center reveal">
        <h2 class="font-heading text-2xl text-white mb-4">Réservation en ligne</h2>
        <p class="text-white/70 text-lg mb-8">Réservez directement votre emplacement, chalet ou tente bivouac sur notre plateforme sécurisée.</p>
        <a href="<?= e($bookingUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-lg bg-sage text-forest hover:bg-sage-light font-semibold">
          Réserver en ligne <?= arrowSvg() ?>
        </a>
      </div>
    </div>
  </section>

  <!-- Two-column: form + sidebar -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

        <!-- Contact form -->
        <div>
          <h2 class="font-heading text-3xl text-forest mb-6">Écrivez-nous</h2>
          <form action="/contact" method="POST" class="space-y-5">
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>" />
            <!-- Honeypot -->
            <div style="position:absolute;left:-9999px;top:-9999px;" aria-hidden="true">
              <label for="website">Ne pas remplir</label>
              <input type="text" name="website" id="website" tabindex="-1" autocomplete="off" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="nom" class="block text-sm font-medium text-forest mb-1.5">Nom *</label>
                <input type="text" name="nom" id="nom" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-sage focus:ring-2 focus:ring-sage/50 focus:outline-none transition-all text-sm" />
              </div>
              <div>
                <label for="prenom" class="block text-sm font-medium text-forest mb-1.5">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-sage focus:ring-2 focus:ring-sage/50 focus:outline-none transition-all text-sm" />
              </div>
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-forest mb-1.5">Email *</label>
              <input type="email" name="email" id="email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-sage focus:ring-2 focus:ring-sage/50 focus:outline-none transition-all text-sm" />
            </div>

            <div>
              <label for="telephone" class="block text-sm font-medium text-forest mb-1.5">Téléphone</label>
              <input type="tel" name="telephone" id="telephone" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-sage focus:ring-2 focus:ring-sage/50 focus:outline-none transition-all text-sm" />
            </div>

            <div>
              <label for="sujet" class="block text-sm font-medium text-forest mb-1.5">Sujet *</label>
              <select name="sujet" id="sujet" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-sage focus:ring-2 focus:ring-sage/50 focus:outline-none transition-all text-sm">
                <option value="">Sélectionnez un sujet</option>
                <option value="reservation">Réservation</option>
                <option value="information">Demande d'information</option>
                <option value="groupe">Groupe / Événement</option>
                <option value="autre">Autre</option>
              </select>
            </div>

            <div>
              <label for="message" class="block text-sm font-medium text-forest mb-1.5">Message *</label>
              <textarea name="message" id="message" rows="5" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-sage focus:ring-2 focus:ring-sage/50 focus:outline-none transition-all text-sm resize-y"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-full text-center">
              Envoyer le message <?= arrowSvg() ?>
            </button>
          </form>
        </div>

        <!-- Sidebar: contact info -->
        <div>
          <h2 class="font-heading text-3xl text-forest mb-6">Nos coordonnées</h2>
          <div class="space-y-6">
            <!-- Address -->
            <div class="card rounded-2xl shadow-soft p-6 bg-white">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-moss flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                  <h4 class="font-semibold text-forest mb-1">Adresse</h4>
                  <p class="text-gray-600 text-sm"><?= e($contact['address'] ?? '') ?><br><?= e($contact['postalCode'] ?? '') ?> <?= e($contact['city'] ?? '') ?></p>
                </div>
              </div>
            </div>
            <!-- Phone -->
            <div class="card rounded-2xl shadow-soft p-6 bg-white">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-moss flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                </div>
                <div>
                  <h4 class="font-semibold text-forest mb-1">Téléphone</h4>
                  <a href="tel:<?= e($phoneTel) ?>" class="text-green hover:text-forest transition-colors"><?= e($phone) ?></a>
                </div>
              </div>
            </div>
            <!-- Email -->
            <div class="card rounded-2xl shadow-soft p-6 bg-white">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-moss flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 01-2.06 0L2 7"/></svg>
                </div>
                <div>
                  <h4 class="font-semibold text-forest mb-1">Email</h4>
                  <a href="mailto:<?= e($email) ?>" class="text-green hover:text-forest transition-colors"><?= e($email) ?></a>
                </div>
              </div>
            </div>
            <!-- Opening hours -->
            <div class="card rounded-2xl shadow-soft p-6 bg-white">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-moss flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                </div>
                <div>
                  <h4 class="font-semibold text-forest mb-1">Ouverture</h4>
                  <p class="text-gray-600 text-sm">Emplacements : <?= e($openingDates['emplacements']['start'] ?? '') ?> &mdash; <?= e($openingDates['emplacements']['end'] ?? '') ?></p>
                  <p class="text-gray-600 text-sm">Chalets : <?= e($openingDates['chalets'] ?? '') ?></p>
                </div>
              </div>
            </div>
            <!-- Google Maps link -->
            <a href="<?= e($contact['googleMapsUrl'] ?? '#') ?>" target="_blank" rel="noopener noreferrer" class="block rounded-2xl overflow-hidden shadow-soft h-[250px] relative group">
              <div class="absolute inset-0 bg-forest/20 group-hover:bg-forest/10 transition-colors z-10 flex items-center justify-center">
                <span class="btn btn-outline border-white text-white btn-sm">Voir sur Google Maps <?= arrowSvg('w-3.5 h-3.5') ?></span>
              </div>
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2700!2d<?= e((string)($contact['longitude'] ?? '')) ?>!3d<?= e((string)($contact['latitude'] ?? '')) ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDfCsDQ2JzI5LjUiTiAwwrA0MCcyNC4wIlc!5e0!3m2!1sfr!2sfr!4v1"
                width="100%" height="100%" style="border:0;pointer-events:none;" loading="lazy"
                title="Carte du camping"
              ></iframe>
            </a>
          </div>
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
