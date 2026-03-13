<?php
/**
 * HTML <head> section
 *
 * Expected variables:
 * - $pageTitle (string, optional): Page title (without site name suffix)
 * - $pageDescription (string, optional): Meta description
 * - $pageCanonical (string, optional): Canonical URL override
 * - $pageOgImage (string, optional): Open Graph image path
 * - $noindex (bool, optional): Whether to add noindex meta
 */

$content = loadContent();

$siteName = $content['site']['name'] ?? SITE_NAME;
$siteDescription = $content['site']['description'] ?? '';
$siteUrl = $content['site']['url'] ?? SITE_URL;

// Build full title
$title = isset($pageTitle) && $pageTitle !== $siteName
    ? $pageTitle . ' | ' . $siteName
    : $siteName;

$description = $pageDescription ?? $siteDescription;
$canonical = $pageCanonical ?? $siteUrl . ($_SERVER['REQUEST_URI'] ?? '/');
$ogImage = $pageOgImage ?? '/images/og-default.jpg';
$ogImageFull = $siteUrl . $ogImage;

$latitude = $content['contact']['latitude'] ?? '';
$longitude = $content['contact']['longitude'] ?? '';
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- SEO -->
<title><?= e($title) ?></title>
<meta name="description" content="<?= e($description) ?>" />
<?php if (!empty($noindex)): ?>
<meta name="robots" content="noindex, nofollow" />
<?php endif; ?>
<link rel="canonical" href="<?= e($canonical) ?>" />

<!-- Open Graph -->
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= e($title) ?>" />
<meta property="og:description" content="<?= e($description) ?>" />
<meta property="og:image" content="<?= e($ogImageFull) ?>" />
<meta property="og:url" content="<?= e($canonical) ?>" />
<meta property="og:locale" content="fr_FR" />
<meta property="og:site_name" content="<?= e($siteName) ?>" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?= e($title) ?>" />
<meta name="twitter:description" content="<?= e($description) ?>" />
<meta name="twitter:image" content="<?= e($ogImageFull) ?>" />

<!-- Geo -->
<meta name="geo.region" content="FR-53" />
<meta name="geo.placename" content="Ménil, Mayenne" />
<meta name="geo.position" content="<?= e($latitude . ';' . $longitude) ?>" />

<!-- Favicon -->
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="apple-touch-icon" href="/images/apple-touch-icon.png" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

<!-- Stylesheet -->
<link rel="stylesheet" href="/assets/css/style.css" />

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Campground',
    'name' => $content['site']['name'] ?? '',
    'description' => $description,
    'url' => $siteUrl,
    'telephone' => $content['contact']['phone'] ?? '',
    'email' => $content['contact']['email'] ?? '',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $content['contact']['address'] ?? '',
        'addressLocality' => $content['contact']['city'] ?? '',
        'postalCode' => $content['contact']['postalCode'] ?? '',
        'addressRegion' => $content['contact']['department'] ?? '',
        'addressCountry' => 'FR',
    ],
    'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => $content['contact']['latitude'] ?? 0,
        'longitude' => $content['contact']['longitude'] ?? 0,
    ],
    'starRating' => [
        '@type' => 'Rating',
        'ratingValue' => '2',
    ],
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '9.6',
        'bestRating' => '10',
        'ratingCount' => '150',
    ],
    'priceRange' => '11€ - 575€',
    'amenityFeature' => [
        ['@type' => 'LocationFeatureSpecification', 'name' => 'Wi-Fi gratuit', 'value' => true],
        ['@type' => 'LocationFeatureSpecification', 'name' => 'Accès rivière', 'value' => true],
        ['@type' => 'LocationFeatureSpecification', 'name' => 'Accueil Vélo', 'value' => true],
    ],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
</script>
