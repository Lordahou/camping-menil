<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Already logged in?
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

// Handle login attempt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (!validateCSRF($_POST[CSRF_TOKEN_NAME] ?? '')) {
        $error = 'Session expirée. Veuillez réessayer.';
    } else {
        // Brute-force protection
        $now = time();
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }
        // Remove attempts older than lockout window
        $_SESSION['login_attempts'] = array_filter($_SESSION['login_attempts'], function ($ts) use ($now) {
            return ($now - $ts) < LOGIN_LOCKOUT_TIME;
        });

        if (count($_SESSION['login_attempts']) >= MAX_LOGIN_ATTEMPTS) {
            $wait = LOGIN_LOCKOUT_TIME - ($now - min($_SESSION['login_attempts']));
            $error = 'Trop de tentatives. Réessayez dans ' . ceil($wait / 60) . ' minute(s).';
        } else {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === ADMIN_EMAIL && password_verify($password, ADMIN_PASSWORD_HASH)) {
                // Success
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_email'] = $email;
                $_SESSION['login_attempts'] = [];
                session_regenerate_id(true);
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['login_attempts'][] = $now;
                $error = 'Email ou mot de passe incorrect.';
            }
        }
    }
}

$csrf = generateCSRF();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Administration Camping du Bac</title>
    <link rel="stylesheet" href="assets/admin.css">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="login-page">
    <div class="login-box">
        <h1>Camping du Bac</h1>
        <p class="login-subtitle">Administration du site</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" autocomplete="off">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= e($csrf) ?>">

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" required autofocus
                       value="<?= e($_POST['email'] ?? '') ?>"
                       placeholder="votre@email.fr">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required
                       placeholder="Mot de passe">
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</div>
</body>
</html>
