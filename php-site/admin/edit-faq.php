<?php require_once __DIR__ . '/auth.php';
$content = loadContent();
$csrf = generateCSRF();
$page = 'faq';

$faq = $content['faq'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ — Administration</title>
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
                <input type="hidden" name="section" value="faq">

                <div class="form-section">
                    <h2>Questions fréquentes</h2>
                    <div id="faq-container">
                        <?php foreach ($faq as $i => $item): ?>
                        <div class="item-row">
                            <button type="button" class="btn btn-danger btn-sm delete-row" onclick="removeRow(this)">Supprimer</button>
                            <div class="form-group">
                                <label>Question</label>
                                <input type="text" name="faq[<?= $i ?>][question]" value="<?= e($item['question'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Réponse</label>
                                <textarea name="faq[<?= $i ?>][answer]" rows="3" required><?= e($item['answer'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-1"
                        onclick="addRow('faq-container', faqTemplate)">+ Ajouter une question</button>
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
var faqTemplate = '<div class="item-row">'
    + '<button type="button" class="btn btn-danger btn-sm delete-row" onclick="removeRow(this)">Supprimer</button>'
    + '<div class="form-group"><label>Question</label><input type="text" name="faq[__INDEX__][question]" required></div>'
    + '<div class="form-group"><label>Réponse</label><textarea name="faq[__INDEX__][answer]" rows="3" required></textarea></div>'
    + '</div>';
</script>
</body>
</html>
