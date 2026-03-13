<div class="sidebar-overlay" id="sidebarOverlay"></div>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        Camping du Bac
        <small>Administration</small>
    </div>
    <ul class="sidebar-nav">
        <li><a href="index.php" class="<?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>">
            <span class="nav-icon">&#9881;</span> Tableau de bord
        </a></li>
        <li><a href="edit-general.php" class="<?= ($page ?? '') === 'general' ? 'active' : '' ?>">
            <span class="nav-icon">&#9998;</span> Infos générales
        </a></li>
        <li><a href="edit-hebergements.php" class="<?= ($page ?? '') === 'hebergements' ? 'active' : '' ?>">
            <span class="nav-icon">&#127968;</span> Hébergements
        </a></li>
        <li><a href="edit-tarifs.php" class="<?= ($page ?? '') === 'tarifs' ? 'active' : '' ?>">
            <span class="nav-icon">&#128176;</span> Tarifs
        </a></li>
        <li><a href="edit-activites.php" class="<?= ($page ?? '') === 'activites' ? 'active' : '' ?>">
            <span class="nav-icon">&#127754;</span> Activités
        </a></li>
        <li><a href="edit-faq.php" class="<?= ($page ?? '') === 'faq' ? 'active' : '' ?>">
            <span class="nav-icon">&#10067;</span> FAQ
        </a></li>
        <li><a href="edit-temoignages.php" class="<?= ($page ?? '') === 'temoignages' ? 'active' : '' ?>">
            <span class="nav-icon">&#11088;</span> Témoignages
        </a></li>
        <li><a href="upload-images.php" class="<?= ($page ?? '') === 'images' ? 'active' : '' ?>">
            <span class="nav-icon">&#128247;</span> Images
        </a></li>
    </ul>
    <div class="sidebar-footer">
        <a href="logout.php">&#10140; Déconnexion</a>
    </div>
</aside>
