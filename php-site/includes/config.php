<?php
// Site configuration
define('SITE_NAME', 'Camping du Bac de Ménil');
define('SITE_URL', 'https://camping.menil53.fr');
define('DATA_PATH', __DIR__ . '/../data/');
define('UPLOADS_PATH', __DIR__ . '/../uploads/');
define('IMAGES_PATH', __DIR__ . '/../images/');

// Admin credentials
// Default password: camping2026
define('ADMIN_EMAIL', 'campingdubac@orange.fr');

// Load or generate admin password hash
$_adminHashFile = DATA_PATH . '.admin_hash';
if (file_exists($_adminHashFile)) {
    define('ADMIN_PASSWORD_HASH', trim(file_get_contents($_adminHashFile)));
} else {
    $_hash = password_hash('camping2026', PASSWORD_BCRYPT);
    @file_put_contents($_adminHashFile, $_hash);
    define('ADMIN_PASSWORD_HASH', $_hash);
}

// Security
define('CSRF_TOKEN_NAME', 'csrf_token');
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes

// Upload settings
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
$GLOBALS['ALLOWED_EXTENSIONS'] = array('jpg', 'jpeg', 'png', 'webp', 'svg');
