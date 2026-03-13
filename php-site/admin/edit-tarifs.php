<?php require_once __DIR__ . '/auth.php';
$content = loadContent();
$csrf = generateCSRF();
$page = 'tarifs';

$tarifs = $content['tarifs'] ?? [];
$sections = ['emplacements', 'chalets', 'bivouac', 'rentals'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifs — Administration</title>
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

            <form method="post" action="save.php">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= e($csrf) ?>">
                <input type="hidden" name="section" value="tarifs">

                <div class="form-section">
                    <div class="form-group">
                        <label for="tarifs_note">Note générale tarifs</label>
                        <input type="text" id="tarifs_note" name="tarifs_note" value="<?= e($tarifs['note'] ?? '') ?>">
                    </div>
                </div>

                <?php foreach ($sections as $sec):
                    $data = $tarifs[$sec] ?? [];
                    $items = $data['items'] ?? [];
                ?>
                <div class="form-section">
                    <h2><?= e($data['title'] ?? ucfirst($sec)) ?></h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Titre section</label>
                            <input type="text" name="tarifs[<?= $sec ?>][title]" value="<?= e($data['title'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="tarifs[<?= $sec ?>][description]" value="<?= e($data['description'] ?? '') ?>">
                        </div>
                    </div>

                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Libellé</th>
                                <th>Prix</th>
                                <th style="width:100px;"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-<?= $sec ?>">
                            <?php foreach ($items as $j => $item): ?>
                            <tr>
                                <td><input type="text" name="tarifs[<?= $sec ?>][<?= $j ?>][label]" value="<?= e($item['label'] ?? '') ?>" required></td>
                                <td><input type="text" name="tarifs[<?= $sec ?>][<?= $j ?>][price]" value="<?= e($item['price'] ?? '') ?>" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeTableRow(this)">Supprimer</button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary btn-sm mt-1" onclick="addTarifRow('tbody-<?= $sec ?>', '<?= $sec ?>')">+ Ajouter une ligne</button>
                </div>
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
