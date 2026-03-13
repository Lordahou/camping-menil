<?php require_once __DIR__ . '/auth.php';
$content = loadContent();
$csrf = generateCSRF();
$page = 'hebergements';

$accommodations = $content['accommodations'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hébergements — Administration</title>
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
                <div class="alert alert-success">Modifications enregistrées avec succès.</div>
            <?php endif; ?>
            <?php if (!empty($_GET['error'])): ?>
                <div class="alert alert-error"><?= e($_GET['error']) ?></div>
            <?php endif; ?>

            <form method="post" action="save.php" enctype="multipart/form-data">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= e($csrf) ?>">
                <input type="hidden" name="section" value="hebergements">

                <?php foreach ($accommodations as $i => $acc): ?>
                <details class="item-block" <?= $i === 0 ? 'open' : '' ?>>
                    <summary><?= e($acc['title'] ?? 'Hébergement ' . ($i + 1)) ?></summary>
                    <div class="item-body">
                        <input type="hidden" name="accommodations[<?= $i ?>][id]" value="<?= e($acc['id'] ?? '') ?>">

                        <div class="form-row">
                            <div class="form-group">
                                <label>Titre</label>
                                <input type="text" name="accommodations[<?= $i ?>][title]" value="<?= e($acc['title'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Sous-titre</label>
                                <input type="text" name="accommodations[<?= $i ?>][subtitle]" value="<?= e($acc['subtitle'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="accommodations[<?= $i ?>][description]" rows="3"><?= e($acc['description'] ?? '') ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Capacité</label>
                                <input type="text" name="accommodations[<?= $i ?>][capacity]" value="<?= e($acc['capacity'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="number" name="accommodations[<?= $i ?>][count]" value="<?= e((string)($acc['count'] ?? '')) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Équipements (séparés par des virgules)</label>
                            <input type="text" name="accommodations[<?= $i ?>][features]"
                                   value="<?= e(implode(', ', $acc['features'] ?? [])) ?>">
                            <span class="form-hint">Ex : Électricité, Wi-Fi gratuit, Accès rivière</span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Arrivée</label>
                                <input type="text" name="accommodations[<?= $i ?>][checkin]" value="<?= e($acc['checkin'] ?? '') ?>" placeholder="À partir de 16h00">
                            </div>
                            <div class="form-group">
                                <label>Départ</label>
                                <input type="text" name="accommodations[<?= $i ?>][checkout]" value="<?= e($acc['checkout'] ?? '') ?>" placeholder="Avant 10h00">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Image actuelle</label>
                            <?php if (!empty($acc['image'])): ?>
                                <div style="margin:.5rem 0;">
                                    <img src="<?= e($acc['image']) ?>" alt="" class="image-preview">
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="accommodations[<?= $i ?>][image]" value="<?= e($acc['image'] ?? '') ?>">
                            <input type="file" name="accommodations_image_<?= $i ?>" accept=".jpg,.jpeg,.png,.webp">
                            <span class="form-hint">Laisser vide pour conserver l'image actuelle</span>
                        </div>

                        <div class="form-group">
                            <label>Texte alternatif image</label>
                            <input type="text" name="accommodations[<?= $i ?>][imageAlt]" value="<?= e($acc['imageAlt'] ?? '') ?>">
                        </div>
                    </div>
                </details>
                <?php endforeach; ?>

                <div class="save-bar">
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script src="assets/admin.js"></script>
</body>
</html>
