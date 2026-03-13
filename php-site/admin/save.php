<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Auth check
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// CSRF validation
if (!validateCSRF($_POST[CSRF_TOKEN_NAME] ?? '')) {
    header('Location: index.php?error=' . urlencode('Token de sécurité invalide.'));
    exit;
}

$section = $_POST['section'] ?? '';
$content = loadContent();

// Backup current content
$backupPath = DATA_PATH . 'content.json.bak';
$currentPath = DATA_PATH . 'content.json';
if (file_exists($currentPath)) {
    copy($currentPath, $backupPath);
}

$redirect = 'index.php?success=1';

// --- Helper: handle a file upload, return new path or original ---
function handleUpload(string $fileKey, string $destDir, string $filename = ''): string {
    if (empty($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
        return '';
    }

    $file = $_FILES[$fileKey];

    // Validate size
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return '';
    }

    // Validate extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS)) {
        return '';
    }

    // Create destination directory if needed
    $fullDir = UPLOADS_PATH . $destDir;
    if (!is_dir($fullDir)) {
        mkdir($fullDir, 0755, true);
    }

    // Generate filename
    if (empty($filename)) {
        $filename = pathinfo($file['name'], PATHINFO_FILENAME);
        $filename = preg_replace('/[^a-z0-9_-]/i', '-', $filename);
    }
    $destFile = $fullDir . '/' . $filename . '.' . $ext;

    if (move_uploaded_file($file['tmp_name'], $destFile)) {
        return '/uploads/' . $destDir . '/' . $filename . '.' . $ext;
    }
    return '';
}

// --- Route by section ---
switch ($section) {

    // ====== GENERAL ======
    case 'general':
        // Site
        if (isset($_POST['site'])) {
            foreach (['name', 'tagline', 'description', 'rating', 'ratingSource', 'bookingUrl'] as $key) {
                if (isset($_POST['site'][$key])) {
                    $content['site'][$key] = trim($_POST['site'][$key]);
                }
            }
        }
        // Contact
        if (isset($_POST['contact'])) {
            foreach (['address', 'city', 'postalCode', 'phone', 'email'] as $key) {
                if (isset($_POST['contact'][$key])) {
                    $content['contact'][$key] = trim($_POST['contact'][$key]);
                }
            }
            if (isset($_POST['contact']['latitude'])) {
                $content['contact']['latitude'] = (float)$_POST['contact']['latitude'];
            }
            if (isset($_POST['contact']['longitude'])) {
                $content['contact']['longitude'] = (float)$_POST['contact']['longitude'];
            }
        }
        // Opening dates
        if (isset($_POST['openingDates'])) {
            $od = $_POST['openingDates'];
            if (isset($od['emplacements']['start'])) {
                $content['openingDates']['emplacements']['start'] = trim($od['emplacements']['start']);
            }
            if (isset($od['emplacements']['end'])) {
                $content['openingDates']['emplacements']['end'] = trim($od['emplacements']['end']);
            }
            if (isset($od['chalets'])) {
                $content['openingDates']['chalets'] = trim($od['chalets']);
            }
            if (isset($od['maisonEclusiere'])) {
                $content['openingDates']['maisonEclusiere'] = trim($od['maisonEclusiere']);
            }
        }
        // Hero
        if (isset($_POST['hero'])) {
            foreach (['title', 'subtitle'] as $key) {
                if (isset($_POST['hero'][$key])) {
                    $content['hero'][$key] = trim($_POST['hero'][$key]);
                }
            }
        }
        // Bac
        if (isset($_POST['bac'])) {
            foreach (['description', 'price', 'restrictions'] as $key) {
                if (isset($_POST['bac'][$key])) {
                    $content['bac'][$key] = trim($_POST['bac'][$key]);
                }
            }
            // Schedules
            if (isset($_POST['bac']['schedules'])) {
                foreach (['lowSeason', 'highSeason'] as $season) {
                    if (isset($_POST['bac']['schedules'][$season]['period'])) {
                        $content['bac']['schedules'][$season]['period'] = trim($_POST['bac']['schedules'][$season]['period']);
                    }
                    if (isset($_POST['bac']['schedules'][$season]['times'])) {
                        $timesStr = $_POST['bac']['schedules'][$season]['times'];
                        $times = array_map('trim', explode(',', $timesStr));
                        $times = array_filter($times, function ($t) { return $t !== ''; });
                        $content['bac']['schedules'][$season]['times'] = array_values($times);
                    }
                }
            }
        }
        $redirect = 'edit-general.php?success=1';
        break;

    // ====== HEBERGEMENTS ======
    case 'hebergements':
        if (isset($_POST['accommodations']) && is_array($_POST['accommodations'])) {
            $accommodations = [];
            foreach ($_POST['accommodations'] as $i => $acc) {
                $item = [
                    'id' => trim($acc['id'] ?? ''),
                    'title' => trim($acc['title'] ?? ''),
                    'subtitle' => trim($acc['subtitle'] ?? ''),
                    'description' => trim($acc['description'] ?? ''),
                    'capacity' => trim($acc['capacity'] ?? ''),
                    'count' => (int)($acc['count'] ?? 0),
                    'features' => array_values(array_filter(array_map('trim', explode(',', $acc['features'] ?? '')))),
                    'checkin' => trim($acc['checkin'] ?? ''),
                    'checkout' => trim($acc['checkout'] ?? ''),
                    'image' => trim($acc['image'] ?? ''),
                    'imageAlt' => trim($acc['imageAlt'] ?? '')
                ];
                // Handle image upload
                $uploaded = handleUpload('accommodations_image_' . $i, 'hebergements', $item['id']);
                if ($uploaded) {
                    $item['image'] = $uploaded;
                }
                $accommodations[] = $item;
            }
            $content['accommodations'] = $accommodations;
        }
        $redirect = 'edit-hebergements.php?success=1';
        break;

    // ====== TARIFS ======
    case 'tarifs':
        if (isset($_POST['tarifs_note'])) {
            $content['tarifs']['note'] = trim($_POST['tarifs_note']);
        }
        if (isset($_POST['tarifs']) && is_array($_POST['tarifs'])) {
            foreach (['emplacements', 'chalets', 'bivouac', 'rentals'] as $sec) {
                if (!isset($_POST['tarifs'][$sec])) continue;

                $sectionData = $_POST['tarifs'][$sec];
                // Title and description
                if (isset($sectionData['title'])) {
                    $content['tarifs'][$sec]['title'] = trim($sectionData['title']);
                }
                if (isset($sectionData['description'])) {
                    $content['tarifs'][$sec]['description'] = trim($sectionData['description']);
                }

                // Items — numeric keys are the row data
                $items = [];
                foreach ($sectionData as $key => $row) {
                    if (!is_numeric($key)) continue;
                    if (!is_array($row)) continue;
                    $label = trim($row['label'] ?? '');
                    $price = trim($row['price'] ?? '');
                    if ($label !== '' || $price !== '') {
                        $items[] = ['label' => $label, 'price' => $price];
                    }
                }
                $content['tarifs'][$sec]['items'] = $items;
            }
        }
        $redirect = 'edit-tarifs.php?success=1';
        break;

    // ====== ACTIVITES ======
    case 'activites':
        // Activities
        if (isset($_POST['activities']) && is_array($_POST['activities'])) {
            $activities = [];
            foreach ($_POST['activities'] as $i => $act) {
                $item = [
                    'title' => trim($act['title'] ?? ''),
                    'description' => trim($act['description'] ?? ''),
                    'image' => trim($act['image'] ?? ''),
                    'category' => trim($act['category'] ?? '')
                ];
                if (!empty($act['price'])) {
                    $item['price'] = trim($act['price']);
                }
                // Handle image upload
                $uploaded = handleUpload('activities_image_' . $i, 'activites');
                if ($uploaded) {
                    $item['image'] = $uploaded;
                }
                if ($item['title'] !== '') {
                    $activities[] = $item;
                }
            }
            $content['activities'] = $activities;
        }
        // Surroundings
        if (isset($_POST['surroundings']) && is_array($_POST['surroundings'])) {
            $surroundings = [];
            foreach ($_POST['surroundings'] as $sur) {
                $item = [
                    'title' => trim($sur['title'] ?? ''),
                    'distance' => trim($sur['distance'] ?? ''),
                    'description' => trim($sur['description'] ?? '')
                ];
                if ($item['title'] !== '') {
                    $surroundings[] = $item;
                }
            }
            $content['surroundings'] = $surroundings;
        }
        $redirect = 'edit-activites.php?success=1';
        break;

    // ====== FAQ ======
    case 'faq':
        if (isset($_POST['faq']) && is_array($_POST['faq'])) {
            $faq = [];
            foreach ($_POST['faq'] as $item) {
                $q = trim($item['question'] ?? '');
                $a = trim($item['answer'] ?? '');
                if ($q !== '' && $a !== '') {
                    $faq[] = ['question' => $q, 'answer' => $a];
                }
            }
            $content['faq'] = $faq;
        }
        $redirect = 'edit-faq.php?success=1';
        break;

    // ====== TEMOIGNAGES ======
    case 'temoignages':
        if (isset($_POST['testimonials']) && is_array($_POST['testimonials'])) {
            $testimonials = [];
            foreach ($_POST['testimonials'] as $t) {
                $text = trim($t['text'] ?? '');
                $author = trim($t['author'] ?? '');
                if ($text !== '' && $author !== '') {
                    $testimonials[] = [
                        'text' => $text,
                        'author' => $author,
                        'origin' => trim($t['origin'] ?? ''),
                        'rating' => max(1, min(5, (int)($t['rating'] ?? 5)))
                    ];
                }
            }
            $content['testimonials'] = $testimonials;
        }
        $redirect = 'edit-temoignages.php?success=1';
        break;

    // ====== IMAGES ======
    case 'images':
        $images = $_POST['images'] ?? [];
        foreach ($images as $key => $meta) {
            $fileKey = 'image_' . $key;
            $category = $meta['category'] ?? 'misc';
            $current = $meta['current'] ?? '';

            $uploaded = handleUpload($fileKey, $category, $key);
            if ($uploaded) {
                // Update content.json references based on category
                if ($category === 'hero') {
                    $content['hero']['image'] = $uploaded;
                } elseif ($category === 'hebergements' && str_starts_with($key, 'hebergement-')) {
                    $accId = substr($key, strlen('hebergement-'));
                    foreach ($content['accommodations'] as &$acc) {
                        if (($acc['id'] ?? '') === $accId) {
                            $acc['image'] = $uploaded;
                            break;
                        }
                    }
                    unset($acc);
                } elseif ($category === 'activites' && str_starts_with($key, 'activite-')) {
                    $idx = (int)substr($key, strlen('activite-'));
                    if (isset($content['activities'][$idx])) {
                        $content['activities'][$idx]['image'] = $uploaded;
                    }
                }
                // Gallery images are stored as files, no JSON reference needed
            }
        }
        $redirect = 'upload-images.php?success=1';
        break;

    default:
        $redirect = 'index.php?error=' . urlencode('Section inconnue.');
        break;
}

// Save content
$json = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($json !== false && file_put_contents($currentPath, $json) !== false) {
    header('Location: ' . $redirect);
} else {
    // Restore backup
    if (file_exists($backupPath)) {
        copy($backupPath, $currentPath);
    }
    $errorRedirect = str_contains($redirect, '?') ? explode('?', $redirect)[0] : $redirect;
    header('Location: ' . $errorRedirect . '?error=' . urlencode('Erreur lors de l\'enregistrement.'));
}
exit;
