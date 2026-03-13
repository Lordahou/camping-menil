<?php
$content = loadContent();
$navigation = $content['navigation'] ?? [];
$contact = $content['contact'] ?? [];
$openingDates = $content['openingDates'] ?? [];
$footerLinks = $content['footerLinks'] ?? [];
$site = $content['site'] ?? [];
$phone = $contact['phone'] ?? '';
$phoneTel = formatPhone($phone);
$email = $contact['email'] ?? '';
$currentYear = date('Y');
?>
<footer class="bg-forest text-white/80">
  <!-- Main Footer -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">

      <!-- Brand -->
      <div class="lg:col-span-1">
        <a href="/" class="inline-block mb-4">
          <h3 class="text-white text-2xl font-heading">Camping du Bac</h3>
          <p class="text-sage text-sm mt-1">Ménil · Mayenne</p>
        </a>
        <p class="text-white/60 text-sm leading-relaxed mb-6">
          Camping 2 étoiles au bord de la Mayenne. Un cadre naturel d'exception pour des vacances
          ressourçantes entre rivière et nature.
        </p>
        <div class="flex items-center gap-2 mb-4">
          <div class="flex gap-0.5">
            <?php for ($i = 0; $i < ($site['stars'] ?? 2); $i++): ?>
              <svg class="w-4 h-4 text-sage" fill="currentColor" viewBox="0 0 24 24">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26" />
              </svg>
            <?php endfor; ?>
          </div>
          <span class="text-white/50 text-xs">Camping <?= e((string)($site['stars'] ?? 2)) ?> étoiles</span>
        </div>
        <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-3 py-1.5">
          <span class="text-sage font-bold text-sm"><?= e($site['rating'] ?? '9.6/10') ?></span>
          <span class="text-white/50 text-xs"><?= e($site['ratingSource'] ?? 'Fairguest') ?></span>
        </div>
      </div>

      <!-- Navigation -->
      <div>
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5">Découvrir</h4>
        <ul class="space-y-3">
          <?php foreach ($navigation as $item): ?>
            <li>
              <a href="<?= e($item['url'] ?? '#') ?>" class="text-white/60 hover:text-sage text-sm transition-colors duration-200">
                <?= e($item['label'] ?? '') ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5">Contact</h4>
        <ul class="space-y-4">
          <li class="flex items-start gap-3">
            <svg class="w-4 h-4 mt-0.5 text-sage flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
            <span class="text-white/60 text-sm"><?= e($contact['address'] ?? '') ?><br/><?= e($contact['postalCode'] ?? '') ?> <?= e($contact['city'] ?? '') ?></span>
          </li>
          <li>
            <a href="tel:<?= e($phoneTel) ?>" class="flex items-center gap-3 text-white/60 hover:text-sage text-sm transition-colors">
              <svg class="w-4 h-4 text-sage flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
              </svg>
              <?= e($phone) ?>
            </a>
          </li>
          <li>
            <a href="mailto:<?= e($email) ?>" class="flex items-center gap-3 text-white/60 hover:text-sage text-sm transition-colors">
              <svg class="w-4 h-4 text-sage flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 01-2.06 0L2 7"/>
              </svg>
              <?= e($email) ?>
            </a>
          </li>
        </ul>
      </div>

      <!-- Practical -->
      <div>
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5">Infos pratiques</h4>
        <ul class="space-y-3 text-white/60 text-sm">
          <li class="flex items-start gap-2">
            <svg class="w-4 h-4 mt-0.5 text-sage flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            <div>
              <span class="text-white/80 block">Emplacements</span>
              <?= e($openingDates['emplacements']['start'] ?? '') ?> — <?= e($openingDates['emplacements']['end'] ?? '') ?>
            </div>
          </li>
          <li class="flex items-start gap-2">
            <svg class="w-4 h-4 mt-0.5 text-sage flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <div>
              <span class="text-white/80 block">Chalets &amp; Maison éclusière</span>
              <?= e($openingDates['chalets'] ?? '') ?>
            </div>
          </li>
        </ul>

        <div class="mt-6 pt-6 border-t border-white/10">
          <a href="/contact" class="btn btn-sm bg-sage text-forest hover:bg-sage-light font-semibold w-full text-center">
            Réserver
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Partners -->
  <div class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-wrap items-center justify-center gap-8 opacity-50">
      <span class="text-xs uppercase tracking-widest text-white/40">Partenaires</span>
      <span class="text-sm text-white/40">Vélo Francette</span>
      <span class="text-sm text-white/40">France Vélo Tourisme</span>
      <span class="text-sm text-white/40">Mayenne Tourisme</span>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/40">
      <p>&copy; <?= e($currentYear) ?> <?= e($site['name'] ?? SITE_NAME) ?> — Commune de Ménil</p>
      <div class="flex items-center gap-4">
        <?php foreach ($footerLinks as $link): ?>
          <a href="<?= e($link['url'] ?? '#') ?>" class="hover:text-white/60 transition-colors"><?= e($link['label'] ?? '') ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</footer>
