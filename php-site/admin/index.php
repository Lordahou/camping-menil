<?php require_once __DIR__ . '/auth.php';
$content = loadContent();
$csrf = generateCSRF();
$page = 'dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord — Administration</title>
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

            <div class="welcome-banner">
                <h2>Bienvenue dans l'administration</h2>
                <p><?= e(date('l j F Y')) ?> — <?= e($_SESSION['admin_email'] ?? '') ?></p>
            </div>

            <h2 style="font-size:1rem;margin-bottom:.5rem;">Gestion du contenu</h2>
            <div class="dashboard-grid">
                <div class="card">
                    <a href="edit-general.php">
                        <div class="card-icon">&#9881;</div>
                        <h3>Informations générales</h3>
                        <p>Coordonnées, horaires, description du site</p>
                    </a>
                </div>
                <div class="card">
                    <a href="edit-hebergements.php">
                        <div class="card-icon">&#127968;</div>
                        <h3>Hébergements</h3>
                        <p>Emplacements, chalets, bivouac, maison éclusière</p>
                    </a>
                </div>
                <div class="card">
                    <a href="edit-tarifs.php">
                        <div class="card-icon">&#128176;</div>
                        <h3>Tarifs</h3>
                        <p>Emplacements, chalets, locations loisirs</p>
                    </a>
                </div>
                <div class="card">
                    <a href="edit-activites.php">
                        <div class="card-icon">&#127754;</div>
                        <h3>Activités</h3>
                        <p>Activités et lieux à découvrir</p>
                    </a>
                </div>
                <div class="card">
                    <a href="edit-faq.php">
                        <div class="card-icon">&#10067;</div>
                        <h3>FAQ</h3>
                        <p>Questions fréquentes</p>
                    </a>
                </div>
                <div class="card">
                    <a href="edit-temoignages.php">
                        <div class="card-icon">&#11088;</div>
                        <h3>Témoignages</h3>
                        <p>Avis et retours de visiteurs</p>
                    </a>
                </div>
                <div class="card">
                    <a href="upload-images.php">
                        <div class="card-icon">&#128247;</div>
                        <h3>Gestion des images</h3>
                        <p>Photos du camping et des hébergements</p>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="assets/admin.js"></script>
</body>
</html>
