<?php require_once __DIR__ . '/auth.php';
$content = loadContent();
$csrf = generateCSRF();
$page = 'activites';

$activities = $content['activities'] ?? [];
$surroundings = $content['surroundings'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activités — Administration</title>
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
                <input type="hidden" name="section" value="activites">

                <!-- Activities -->
                <div class="form-section">
                    <h2>Activités</h2>
                    <div id="activities-container">
                        <?php foreach ($activities as $i => $act): ?>
                        <div class="item-row">
                            <button type="button" class="btn btn-danger btn-sm delete-row" onclick="removeRow(this)">Supprimer</button>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input type="text" name="activities[<?= $i ?>][title]" value="<?= e($act['title'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Catégorie</label>
                                    <input type="text" name="activities[<?= $i ?>][category]" value="<?= e($act['category'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Tarif</label>
                                    <input type="text" name="activities[<?= $i ?>][price]" value="<?= e($act['price'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="activities[<?= $i ?>][description]" rows="2"><?= e($act['description'] ?? '') ?></textarea>
                            </div>
                            <div class="form-group">
                                <?php if (!empty($act['image'])): ?>
                                    <img src="<?= e($act['image']) ?>" alt="" class="image-preview" style="margin-bottom:.5rem;">
                                <?php endif; ?>
                                <input type="hidden" name="activities[<?= $i ?>][image]" value="<?= e($act['image'] ?? '') ?>">
                                <input type="file" name="activities_image_<?= $i ?>" accept=".jpg,.jpeg,.png,.webp">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-1"
                        onclick="addRow('activities-container', activityTemplate)">+ Ajouter une activité</button>
                </div>

                <!-- Surroundings -->
                <div class="form-section">
                    <h2>Aux alentours</h2>
                    <div id="surroundings-container">
                        <?php foreach ($surroundings as $i => $sur): ?>
                        <div class="item-row">
                            <button type="button" class="btn btn-danger btn-sm delete-row" onclick="removeRow(this)">Supprimer</button>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input type="text" name="surroundings[<?= $i ?>][title]" value="<?= e($sur['title'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Distance</label>
                                    <input type="text" name="surroundings[<?= $i ?>][distance]" value="<?= e($sur['distance'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="surroundings[<?= $i ?>][description]" rows="2"><?= e($sur['description'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-1"
                        onclick="addRow('surroundings-container', surroundingTemplate)">+ Ajouter un lieu</button>
                </div>

                <div class="save-bar">
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script src="assets/admin.js"></script>
<script>
var activityTemplate = '<div class="item-row">'
    + '<button type="button" class="btn btn-danger btn-sm delete-row" onclick="removeRow(this)">Supprimer</button>'
    + '<div class="form-row">'
    + '<div class="form-group"><label>Titre</label><input type="text" name="activities[__INDEX__][title]" required></div>'
    + '<div class="form-group"><label>Catégorie</label><input type="text" name="activities[__INDEX__][category]"></div>'
    + '<div class="form-group"><label>Tarif</label><input type="text" name="activities[__INDEX__][price]"></div>'
    + '</div>'
    + '<div class="form-group"><label>Description</label><textarea name="activities[__INDEX__][description]" rows="2"></textarea></div>'
    + '<div class="form-group"><input type="hidden" name="activities[__INDEX__][image]" value=""><input type="file" name="activities_image___INDEX__" accept=".jpg,.jpeg,.png,.webp"></div>'
    + '</div>';

var surroundingTemplate = '<div class="item-row">'
    + '<button type="button" class="btn btn-danger btn-sm delete-row" onclick="removeRow(this)">Supprimer</button>'
    + '<div class="form-row">'
    + '<div class="form-group"><label>Titre</label><input type="text" name="surroundings[__INDEX__][title]" required></div>'
    + '<div class="form-group"><label>Distance</label><input type="text" name="surroundings[__INDEX__][distance]"></div>'
    + '</div>'
    + '<div class="form-group"><label>Description</label><textarea name="surroundings[__INDEX__][description]" rows="2"></textarea></div>'
    + '</div>';
</script>
</body>
</html>
