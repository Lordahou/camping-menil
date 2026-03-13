<?php require_once __DIR__ . '/auth.php';
$content = loadContent();
$csrf = generateCSRF();
$page = 'general';

$site = $content['site'] ?? [];
$contact = $content['contact'] ?? [];
$opening = $content['openingDates'] ?? [];
$hero = $content['hero'] ?? [];
$bac = $content['bac'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations générales — Administration</title>
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
                <input type="hidden" name="section" value="general">

                <!-- Site info -->
                <div class="form-section">
                    <h2>Site</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="site_name">Nom du site</label>
                            <input type="text" id="site_name" name="site[name]" value="<?= e($site['name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="site_tagline">Accroche</label>
                            <input type="text" id="site_tagline" name="site[tagline]" value="<?= e($site['tagline'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="site_description">Description (SEO)</label>
                        <textarea id="site_description" name="site[description]" rows="3"><?= e($site['description'] ?? '') ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="site_rating">Note</label>
                            <input type="text" id="site_rating" name="site[rating]" value="<?= e($site['rating'] ?? '') ?>" placeholder="9.6/10">
                        </div>
                        <div class="form-group">
                            <label for="site_ratingSource">Source de la note</label>
                            <input type="text" id="site_ratingSource" name="site[ratingSource]" value="<?= e($site['ratingSource'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="site_bookingUrl">URL de réservation</label>
                            <input type="url" id="site_bookingUrl" name="site[bookingUrl]" value="<?= e($site['bookingUrl'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="form-section">
                    <h2>Contact</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact_address">Adresse</label>
                            <input type="text" id="contact_address" name="contact[address]" value="<?= e($contact['address'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="contact_city">Ville</label>
                            <input type="text" id="contact_city" name="contact[city]" value="<?= e($contact['city'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="contact_postalCode">Code postal</label>
                            <input type="text" id="contact_postalCode" name="contact[postalCode]" value="<?= e($contact['postalCode'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact_phone">Téléphone</label>
                            <input type="tel" id="contact_phone" name="contact[phone]" value="<?= e($contact['phone'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="contact_email">Email</label>
                            <input type="email" id="contact_email" name="contact[email]" value="<?= e($contact['email'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact_latitude">Latitude</label>
                            <input type="text" id="contact_latitude" name="contact[latitude]" value="<?= e((string)($contact['latitude'] ?? '')) ?>">
                        </div>
                        <div class="form-group">
                            <label for="contact_longitude">Longitude</label>
                            <input type="text" id="contact_longitude" name="contact[longitude]" value="<?= e((string)($contact['longitude'] ?? '')) ?>">
                        </div>
                    </div>
                </div>

                <!-- Opening dates -->
                <div class="form-section">
                    <h2>Dates d'ouverture</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="opening_emp_start">Emplacements — Ouverture</label>
                            <input type="text" id="opening_emp_start" name="openingDates[emplacements][start]"
                                   value="<?= e($opening['emplacements']['start'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="opening_emp_end">Emplacements — Fermeture</label>
                            <input type="text" id="opening_emp_end" name="openingDates[emplacements][end]"
                                   value="<?= e($opening['emplacements']['end'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="opening_chalets">Chalets</label>
                            <input type="text" id="opening_chalets" name="openingDates[chalets]"
                                   value="<?= e($opening['chalets'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="opening_maison">Maison éclusière</label>
                            <input type="text" id="opening_maison" name="openingDates[maisonEclusiere]"
                                   value="<?= e($opening['maisonEclusiere'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Hero -->
                <div class="form-section">
                    <h2>Section Hero</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="hero_title">Titre</label>
                            <input type="text" id="hero_title" name="hero[title]" value="<?= e($hero['title'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="hero_subtitle">Sous-titre</label>
                            <input type="text" id="hero_subtitle" name="hero[subtitle]" value="<?= e($hero['subtitle'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Bac -->
                <div class="form-section">
                    <h2>Le Bac de Ménil</h2>
                    <div class="form-group">
                        <label for="bac_description">Description</label>
                        <textarea id="bac_description" name="bac[description]" rows="3"><?= e($bac['description'] ?? '') ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="bac_price">Tarif</label>
                            <input type="text" id="bac_price" name="bac[price]" value="<?= e($bac['price'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bac_restrictions">Restrictions</label>
                        <textarea id="bac_restrictions" name="bac[restrictions]" rows="2"><?= e($bac['restrictions'] ?? '') ?></textarea>
                    </div>

                    <h3 style="font-size:.95rem;margin:1rem 0 .5rem;">Horaires basse saison</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Période</label>
                            <input type="text" name="bac[schedules][lowSeason][period]"
                                   value="<?= e($bac['schedules']['lowSeason']['period'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Horaires (séparés par des virgules)</label>
                            <input type="text" name="bac[schedules][lowSeason][times]"
                                   value="<?= e(implode(', ', $bac['schedules']['lowSeason']['times'] ?? [])) ?>">
                            <span class="form-hint">Ex : 9h30, 10h30, 11h30, 14h30</span>
                        </div>
                    </div>

                    <h3 style="font-size:.95rem;margin:1rem 0 .5rem;">Horaires haute saison</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Période</label>
                            <input type="text" name="bac[schedules][highSeason][period]"
                                   value="<?= e($bac['schedules']['highSeason']['period'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Horaires (séparés par des virgules)</label>
                            <input type="text" name="bac[schedules][highSeason][times]"
                                   value="<?= e(implode(', ', $bac['schedules']['highSeason']['times'] ?? [])) ?>">
                        </div>
                    </div>
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
</body>
</html>
