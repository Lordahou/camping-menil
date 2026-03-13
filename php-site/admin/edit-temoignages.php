<?php require_once __DIR__ . '/auth.php';
$content = loadContent();
$csrf = generateCSRF();
$page = 'temoignages';

$testimonials = $content['testimonials'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Témoignages — Administration</title>
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
                <input type="hidden" name="section" value="temoignages">

                <div class="form-section">
                    <h2>Témoignages</h2>
                    <div id="testimonials-container">
                        <?php foreach ($testimonials as $i => $t): ?>
                        <div class="item-row">
                            <button type="button" class="btn btn-danger btn-sm delete-row" onclick="removeRow(this)">Supprimer</button>
                            <div class="form-group">
                                <label>Texte</label>
                                <textarea name="testimonials[<?= $i ?>][text]" rows="3" required><?= e($t['text'] ?? '') ?></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Auteur</label>
                                    <input type="text" name="testimonials[<?= $i ?>][author]" value="<?= e($t['author'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Origine</label>
                                    <input type="text" name="testimonials[<?= $i ?>][origin]" value="<?= e($t['origin'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <select name="testimonials[<?= $i ?>][rating]">
                                        <?php for ($r = 5; $r >= 1; $r--): ?>
                                            <option value="<?= $r ?>" <?= (int)($t['rating'] ?? 5) === $r ? 'selected' : '' ?>><?= $r ?>/5</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-1"
                        onclick="addRow('testimonials-container', testimonialTemplate)">+ Ajouter un témoignage</button>
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
var testimonialTemplate = '<div class="item-row">'
    + '<button type="button" class="btn btn-danger btn-sm delete-row" onclick="removeRow(this)">Supprimer</button>'
    + '<div class="form-group"><label>Texte</label><textarea name="testimonials[__INDEX__][text]" rows="3" required></textarea></div>'
    + '<div class="form-row">'
    + '<div class="form-group"><label>Auteur</label><input type="text" name="testimonials[__INDEX__][author]" required></div>'
    + '<div class="form-group"><label>Origine</label><input type="text" name="testimonials[__INDEX__][origin]"></div>'
    + '<div class="form-group"><label>Note</label><select name="testimonials[__INDEX__][rating]">'
    + '<option value="5">5/5</option><option value="4">4/5</option><option value="3">3/5</option><option value="2">2/5</option><option value="1">1/5</option>'
    + '</select></div>'
    + '</div></div>';
</script>
</body>
</html>
