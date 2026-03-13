<?php
/**
 * Load content from data/content.json
 * @return array Associative array of site content
 */
function loadContent(): array {
    $path = DATA_PATH . 'content.json';
    if (!file_exists($path)) {
        return [];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

/**
 * Save content to data/content.json
 * @param array $data Content data to save
 * @return bool Success status
 */
function saveContent(array $data): bool {
    $path = DATA_PATH . 'content.json';
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false;
    }
    return file_put_contents($path, $json) !== false;
}

/**
 * Escape string for safe HTML output (XSS protection)
 * @param string|null $string Input string
 * @return string Escaped string
 */
function e(?string $string): string {
    if ($string === null) {
        return '';
    }
    return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Generate a CSRF token and store it in the session
 * @return string The generated token
 */
function generateCSRF(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token = bin2hex(random_bytes(32));
    $_SESSION[CSRF_TOKEN_NAME] = $token;
    return $token;
}

/**
 * Validate a CSRF token against the session
 * @param string $token Token to validate
 * @return bool Whether the token is valid
 */
function validateCSRF(string $token): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION[CSRF_TOKEN_NAME]) || empty($token)) {
        return false;
    }
    $valid = hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    // Regenerate token after validation to prevent reuse
    unset($_SESSION[CSRF_TOKEN_NAME]);
    return $valid;
}

/**
 * Check if the admin is currently logged in
 * @return bool Whether the admin session is active
 */
function isLoggedIn(): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Resolve image path (checks uploads/ first, then images/ fallback)
 * @param string $path Relative image path (e.g. "/images/hero.jpg")
 * @return string Resolved path for use in src attributes
 */
function getImagePath(string $path): string {
    // If the path starts with /uploads/ or /images/, check the file system
    $basePath = dirname(__DIR__);

    // Try uploads directory first
    $uploadsFile = $basePath . '/uploads/' . basename($path);
    if (file_exists($uploadsFile)) {
        return '/uploads/' . basename($path);
    }

    // Try full path relative to site root
    $fullPath = $basePath . $path;
    if (file_exists($fullPath)) {
        return $path;
    }

    // Return original path as fallback
    return $path;
}

/**
 * Format phone number for tel: links (remove spaces and dots)
 * @param string $phone Phone number with formatting
 * @return string Clean phone number for tel: href
 */
function formatPhone(string $phone): string {
    return preg_replace('/[\s.\-]/', '', $phone);
}

/**
 * Get current page name for active nav state detection
 * @return string Current page path (e.g. "/le-camping", "/hebergements")
 */
function currentPage(): string {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    // Remove trailing slash except for root
    if ($path !== '/' && str_ends_with($path, '/')) {
        $path = rtrim($path, '/');
    }
    // Remove .php extension for clean URL matching
    $path = preg_replace('/\.php$/', '', $path);
    return $path;
}

/**
 * Check if a nav item is active
 */
function isActive(string $url): bool {
    $current = currentPage();
    $url = rtrim($url, '/');
    return $current === $url || $current === $url . '/';
}

/**
 * Render SVG icon path by name for highlight cards
 */
function getHighlightIcon(string $icon): string {
    $icons = [
        'river' => '<path d="M2 12s3-3 5-3c3 0 4 3 7 3s4-3 7-3 3 3 3 3"/><path d="M2 18s3-3 5-3c3 0 4 3 7 3s4-3 7-3 3 3 3 3" opacity="0.5"/>',
        'bike' => '<circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 100-2 1 1 0 000 2zM12 17.5V14l-3-3 4-3 2 3h3"/>',
        'star' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26"/>',
        'boat' => '<path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1 .6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M19.38 20A11.6 11.6 0 0021 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"/><path d="M19 13V7a2 2 0 00-2-2H7a2 2 0 00-2 2v6"/><path d="M12 9V3"/>',
        'location' => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>',
        'activity' => '<circle cx="12" cy="5" r="3"/><path d="M12 8v4l3 3"/><path d="M6.5 21.5s1.5-2 5.5-2 5.5 2 5.5 2"/>',
    ];
    return $icons[$icon] ?? $icons['star'];
}

/**
 * Render SVG icon path by name for service cards
 */
function getServiceIcon(string $icon): string {
    $icons = [
        'wifi' => '<path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0120 0"/><path d="M5 12.86a10 10 0 0114 0"/><path d="M8.5 16.43a5 5 0 017 0"/>',
        'electric' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10"/>',
        'laundry' => '<rect x="2" y="2" width="20" height="20" rx="3"/><circle cx="12" cy="13" r="5"/><path d="M12 8v2"/>',
        'accessible' => '<circle cx="16" cy="4" r="1"/><path d="M18 22l-4-8h-6l-2-5"/><circle cx="8" cy="20" r="2"/>',
        'pets' => '<path d="M10 5.172C10 3.782 8.884 2.5 7.5 2.5S5 3.782 5 5.172C5 7.5 7.5 10 7.5 10s2.5-2.5 2.5-4.828z"/><path d="M19 5.172C19 3.782 17.884 2.5 16.5 2.5S14 3.782 14 5.172C14 7.5 16.5 10 16.5 10s2.5-2.5 2.5-4.828z"/><path d="M7 14c-2.5 1.5-3 5-3 7h16c0-2-0.5-5.5-3-7-1.5 1-3.5 1.5-5 1.5S8.5 15 7 14z"/>',
        'bike-parking' => '<circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 100-2 1 1 0 000 2zM12 17.5V14l-3-3 4-3 2 3h3"/>',
        'playground' => '<path d="M6 9a3 3 0 100-6 3 3 0 000 6z"/><path d="M6 9v12"/><path d="M12 3v18"/><path d="M18 9a3 3 0 100-6 3 3 0 000 6z"/><path d="M18 9v12"/>',
        'fishing' => '<path d="M18 5l-3 3-3-3"/><path d="M15 8V2"/><path d="M15 22c-4 0-8-4-8-8 0-3 2-5 3-6l5 5c-1 1-3 3-6 3"/>',
    ];
    return $icons[$icon] ?? $icons['wifi'];
}

/**
 * Star SVG for ratings
 */
function starSvg(string $class = 'w-4 h-4 text-sage'): string {
    return '<svg class="' . e($class) . '" fill="currentColor" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26"/></svg>';
}

/**
 * Arrow SVG for buttons
 */
function arrowSvg(string $class = 'w-4 h-4'): string {
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
}
