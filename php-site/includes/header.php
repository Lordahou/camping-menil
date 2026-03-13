<?php
$content = loadContent();
$currentPath = currentPage();
$navigation = $content['navigation'] ?? [];
$phone = $content['contact']['phone'] ?? '';
$phoneTel = formatPhone($phone);
?>
<header
  id="site-header"
  class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
  data-scrolled="false"
>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20 lg:h-24" id="header-inner">

      <!-- Logo -->
      <a href="/" class="flex items-center gap-3 group" aria-label="Accueil - Camping du Bac de Ménil">
        <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:bg-white/30 transition-all duration-300">
          <svg class="w-6 h-6 text-white header-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 12s3-2 5-2c3 0 3 2 5 2s4-2 5-2 3 2 5 2" stroke-linecap="round" stroke-linejoin="round" opacity="0.6"/>
          </svg>
        </div>
        <div class="hidden sm:block">
          <span class="text-white font-heading text-lg leading-tight header-text block">Camping du Bac</span>
          <span class="text-white/70 text-xs tracking-wider uppercase header-subtext block">Ménil · Mayenne</span>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center gap-1" aria-label="Navigation principale">
        <?php foreach ($navigation as $item): ?>
          <?php
            $url = $item['url'] ?? '#';
            $label = $item['label'] ?? '';
            $isActive = ($currentPath === $url || $currentPath === rtrim($url, '/'));
            $linkClass = $isActive
              ? 'bg-white/20 text-white'
              : 'text-white/85 hover:text-white hover:bg-white/10';
          ?>
          <a
            href="<?= e($url) ?>"
            class="px-3 xl:px-4 py-2 text-sm font-medium rounded-full transition-all duration-300 header-link <?= $linkClass ?>"
          >
            <?= e($label) ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <!-- CTA + Mobile Menu -->
      <div class="flex items-center gap-3">
        <a
          href="/contact"
          class="hidden md:inline-flex btn btn-sm bg-white text-forest font-semibold hover:bg-cream hover:text-forest border-white header-cta"
        >
          Réserver
        </a>

        <!-- Mobile Burger -->
        <button
          id="mobile-menu-toggle"
          class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-sm text-white hover:bg-white/20 transition-all"
          aria-label="Ouvrir le menu"
          aria-expanded="false"
        >
          <svg class="w-5 h-5 burger-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="6" x2="21" y2="6" class="burger-line-1" />
            <line x1="3" y1="12" x2="21" y2="12" class="burger-line-2" />
            <line x1="3" y1="18" x2="21" y2="18" class="burger-line-3" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu Overlay -->
  <div
    id="mobile-menu"
    class="fixed inset-0 z-50 bg-forest/98 backdrop-blur-xl flex flex-col opacity-0 pointer-events-none transition-opacity duration-300"
    aria-hidden="true"
  >
    <div class="flex items-center justify-between h-20 px-4 sm:px-6">
      <span class="text-white font-heading text-lg">Camping du Bac</span>
      <button
        id="mobile-menu-close"
        class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition-all"
        aria-label="Fermer le menu"
      >
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="6" y1="6" x2="18" y2="18" /><line x1="18" y1="6" x2="6" y2="18" />
        </svg>
      </button>
    </div>

    <nav class="flex-1 flex flex-col items-center justify-center gap-2 px-6" aria-label="Menu mobile">
      <?php foreach ($navigation as $i => $item): ?>
        <a
          href="<?= e($item['url'] ?? '#') ?>"
          class="text-white/90 hover:text-white text-2xl font-heading py-2 transition-all duration-300 hover:translate-x-2"
          style="animation-delay: <?= $i * 50 ?>ms"
        >
          <?= e($item['label'] ?? '') ?>
        </a>
      <?php endforeach; ?>
      <div class="mt-8 flex flex-col items-center gap-4">
        <a href="/contact" class="btn btn-primary btn-lg">Réserver mon séjour</a>
        <a href="tel:<?= e($phoneTel) ?>" class="text-white/70 text-sm flex items-center gap-2">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
          <?= e($phone) ?>
        </a>
      </div>
    </nav>
  </div>
</header>

<style>
  /* Scrolled state */
  [data-scrolled="true"] {
    background-color: rgba(26, 60, 42, 0.95);
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
  }
  [data-scrolled="true"] #header-inner {
    height: 4rem;
  }

  /* Smooth burger animation lines */
  .burger-line-1, .burger-line-2, .burger-line-3 {
    transition: all 0.3s ease;
    transform-origin: center;
  }
</style>

<script>
  // Header scroll effect
  const header = document.getElementById('site-header');
  let lastScroll = 0;

  function handleScroll() {
    const scrollY = window.scrollY;
    if (header) {
      header.dataset.scrolled = scrollY > 80 ? 'true' : 'false';
    }
    lastScroll = scrollY;
  }

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();

  // Mobile menu
  const menuToggle = document.getElementById('mobile-menu-toggle');
  const menuClose = document.getElementById('mobile-menu-close');
  const mobileMenu = document.getElementById('mobile-menu');

  function openMenu() {
    if (mobileMenu) {
      mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
      mobileMenu.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeMenu() {
    if (mobileMenu) {
      mobileMenu.classList.add('opacity-0', 'pointer-events-none');
      mobileMenu.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }
  }

  menuToggle?.addEventListener('click', openMenu);
  menuClose?.addEventListener('click', closeMenu);

  // Close on link click
  mobileMenu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', closeMenu);
  });

  // Close on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeMenu();
  });
</script>
