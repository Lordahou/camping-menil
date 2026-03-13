<?php require_once __DIR__ . '/auth.php';
$content = loadContent();
$csrf = generateCSRF();
$page = 'images';

// Image categories and their expected files
$categories = [
    'hero' => [
        'label' => 'Image Hero',
        'images' => [
            ['key' => 'hero', 'label' => 'Image principale (hero)', 'current' => $content['hero']['image'] ?? '']
        ]
    ],
    'hebergements' => [
        'label' => 'Hébergements',
        'images' => []
    ],
    'activites' => [
        'label' => 'Activités',
        'images' => []
    ],
    'galerie' => [
        'label' => 'Galerie',
        'images' => []
    ]
];

// Build hébergements images from accommodations data
foreach (($content['accommodations'] ?? []) as $acc) {
    $categories['hebergements']['images'][] = [
        'key' => 'hebergement-' . ($acc['id'] ?? ''),
        'label' => $acc['title'] ?? 'Hébergement',
        'current' => $acc['image'] ?? ''
    ];
}

// Build activités images from activities data
foreach (($content['activities'] ?? []) as $i => $act) {
    $categories['activites']['images'][] = [
        'key' => 'activite-' . $i,
        'label' => $act['title'] ?? 'Activité ' . ($i + 1),
        'current' => $act['image'] ?? ''
    ];
}

// Gallery images — scan the uploads/galerie directory
$galerieDir = UPLOADS_PATH . 'galerie/';
if (is_dir($galerieDir)) {
    $files = glob($galerieDir . '*.{jpg,jpeg,png,webp}', GLOB_BRACE);
    foreach ($files as $j => $f) {
        $categories['galerie']['images'][] = [
            'key' => 'galerie-' . $j,
            'label' => 'Photo ' . ($j + 1),
            'current' => '/uploads/galerie/' . basename($f)
        ];
    }
}
// Always show at least empty slots up to 12
$galCount = count($categories['galerie']['images']);
for ($g = $galCount; $g < 12; $g++) {
    $categories['galerie']['images'][] = [
        'key' => 'galerie-' . $g,
        'label' => 'Photo ' . ($g + 1),
        'current' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des images — Administration</title>
    <link rel="stylesheet" href="assets/admin.css">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="admin-wrapper">
    <?php include __DIR__ . '/partials/sidebar.php'; ?>
    <div class="main-content">
        <?php include __DIR__ . '/partials/topbar.php'; ?>
        <div class="page-content">

            <?php if (!empty($_GET['success'])): ?>
                <div class="alert alert-success">Image(s) mise(s) à jour avec succès.</div>
            <?php endif; ?>
            <?php if (!empty($_GET['error'])): ?>
                <div class="alert alert-error"><?= e($_GET['error']) ?></div>
            <?php endif; ?>

            <form method="post" action="save.php" enctype="multipart/form-data">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= e($csrf) ?>">
                <input type="hidden" name="section" value="images">

                <?php foreach ($categories as $catKey => $cat): ?>
                <div class="form-section">
                    <h2><?= e($cat['label']) ?></h2>
                    <?php foreach ($cat['images'] as $img): ?>
                    <div class="image-upload-group">
                        <label><?= e($img['label']) ?></label>
                        <?php if (!empty($img['current'])): ?>
                            <img src="<?= e($img['current']) ?>" alt="" class="image-preview">
                        <?php else: ?>
                            <span class="text-muted text-sm">Aucune image</span>
                        <?php endif; ?>
                        <input type="hidden" name="images[<?= e($img['key']) ?>][current]" value="<?= e($img['current']) ?>">
                        <input type="hidden" name="images[<?= e($img['key']) ?>][category]" value="<?= e($catKey) ?>">
                        <input type="file" name="image_<?= e($img['key']) ?>" accept=".jpg,.jpeg,.png,.webp">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

                <div class="save-bar">
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Envoyer les images</button>
                </div>
            </form>

            <div class="form-section mt-2">
                <h2>Informations</h2>
                <p class="text-sm text-muted">
                    Formats acceptés : JPG, JPEG, PNG, WebP.<br>
                    Taille maximale : 5 Mo par image.<br>
                    Les images sont enregistrées dans le dossier <code>uploads/</code>.
                </p>
            </div>

        </div>
    </div>
</div>
<script src="assets/admin.js"></script>
</body>
</html>
