<?php
// Test file — delete after debugging
echo '<h1>PHP fonctionne !</h1>';
echo '<p>Version PHP : ' . phpversion() . '</p>';
echo '<p>Date : ' . date('Y-m-d H:i:s') . '</p>';

// Test includes
echo '<h2>Test includes :</h2>';
try {
    require_once __DIR__ . '/includes/config.php';
    echo '<p style="color:green">✓ config.php chargé</p>';
} catch (Exception $e) {
    echo '<p style="color:red">✗ config.php : ' . $e->getMessage() . '</p>';
}

try {
    require_once __DIR__ . '/includes/functions.php';
    echo '<p style="color:green">✓ functions.php chargé</p>';
} catch (Exception $e) {
    echo '<p style="color:red">✗ functions.php : ' . $e->getMessage() . '</p>';
}

// Test JSON loading
try {
    $content = loadContent();
    echo '<p style="color:green">✓ content.json chargé (' . count($content) . ' clés)</p>';
} catch (Exception $e) {
    echo '<p style="color:red">✗ content.json : ' . $e->getMessage() . '</p>';
}

// Test data directory
echo '<h2>Permissions :</h2>';
echo '<p>data/ existe : ' . (is_dir(DATA_PATH) ? 'oui' : 'non') . '</p>';
echo '<p>data/ writable : ' . (is_writable(DATA_PATH) ? 'oui' : 'non') . '</p>';
echo '<p>uploads/ writable : ' . (is_writable(UPLOADS_PATH) ? 'oui' : 'non') . '</p>';

echo '<p><a href="/admin/login.php">Tester le login admin →</a></p>';
echo '<p><strong>Supprimer ce fichier après le test !</strong></p>';
