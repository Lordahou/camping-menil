<header class="topbar">
    <div style="display:flex;align-items:center;gap:.75rem;">
        <button class="hamburger" id="hamburger" aria-label="Menu">&#9776;</button>
        <h1>Administration &mdash; Camping du Bac</h1>
    </div>
    <div class="topbar-right">
        <?= e($_SESSION['admin_email'] ?? '') ?>
    </div>
</header>
