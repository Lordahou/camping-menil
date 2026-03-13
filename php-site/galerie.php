<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$content = loadContent();

$pageTitle = 'Galerie photos';
$pageDescription = 'Découvrez en images le Camping du Bac de Ménil : emplacements, chalets, activités nautiques, bac de Ménil et cadre naturel au bord de la Mayenne.';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php include __DIR__ . '/includes/head.php'; ?>
<style>
  /* Lightbox */
  .lightbox-overlay {
    position: fixed; inset: 0; z-index: 100;
    background: rgba(0,0,0,0.9);
    display: none; align-items: center; justify-content: center;
    cursor: zoom-out;
  }
  .lightbox-overlay.active { display: flex; }
  .lightbox-overlay img {
    max-width: 90vw; max-height: 90vh;
    object-fit: contain; border-radius: 0.5rem;
  }
</style>
</head>
<body class="bg-cream font-body text-gray-800 antialiased">
<?php include __DIR__ . '/includes/header.php'; ?>
<main>

  <!-- Hero medium -->
  <section class="relative h-[50vh] min-h-[400px] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
      <img src="<?= e(getImagePath('/images/galerie/galerie-1.jpg')) ?>" alt="Galerie photos du Camping du Bac" class="w-full h-full object-cover" fetchpriority="high" />
      <div class="absolute inset-0 gradient-hero"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl text-white mb-4">Galerie photos</h1>
      <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-light">Découvrez le camping et son cadre naturel en images</p>
    </div>
  </section>

  <!-- Photo grid -->
  <section class="py-20 lg:py-28 bg-cream reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
        <?php for ($n = 1; $n <= 12; $n++): ?>
          <div class="relative overflow-hidden rounded-2xl shadow-soft hover:shadow-md transition-all aspect-[4/3] group cursor-pointer" onclick="openLightbox(this.querySelector('img'))">
            <img
              src="<?= e(getImagePath('/images/galerie/galerie-' . $n . '.jpg')) ?>"
              alt="Camping du Bac de Ménil — Photo <?= $n ?>"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              loading="lazy"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
          </div>
        <?php endfor; ?>
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
      <h2 class="font-heading text-3xl lg:text-4xl text-white mb-4">Envie de vivre ces moments ?</h2>
      <p class="text-white/80 text-lg mb-10 leading-relaxed">Réservez votre séjour au Camping du Bac de Ménil.</p>
      <a href="/contact" class="btn btn-lg bg-white text-forest hover:bg-cream border-white font-semibold">Réserver mon séjour <?= arrowSvg() ?></a>
    </div>
  </section>

</main>

<!-- Lightbox overlay -->
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox()">
  <img src="" alt="" id="lightbox-img" />
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script>
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => { if(e.isIntersecting) { e.target.classList.add('revealed'); observer.unobserve(e.target); }});
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Lightbox
function openLightbox(img) {
  const overlay = document.getElementById('lightbox');
  const lbImg = document.getElementById('lightbox-img');
  lbImg.src = img.src;
  lbImg.alt = img.alt;
  overlay.classList.add('active');
  document.body.style.overflow = 'hidden';
}
function closeLightbox() {
  document.getElementById('lightbox').classList.remove('active');
  document.body.style.overflow = '';
}
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeLightbox(); });
</script>
</body>
</html>
