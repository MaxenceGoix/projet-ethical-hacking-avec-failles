<?php
declare(strict_types=1);

const DB_HOST = 'db';
const DB_NAME = 'hacking_db';
const DB_USER = 'app_user';
const DB_PASS = 'app_password';

// Version volontairement vulnérable pour le TP : le cookie de session n'est pas HttpOnly.
// Cela permet de démontrer le vol de session via XSS stocké dans un environnement local contrôlé.
ini_set('session.use_strict_mode', '1');
ini_set('session.gc_maxlifetime', '3600');
session_name('PHPSESSID');
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'secure' => false,
    'httponly' => false,
    'samesite' => 'Lax',
]);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['role']);
}

function is_admin(): bool
{
    return is_logged_in() && $_SESSION['role'] === 'admin';
}

function require_user(): void
{
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_admin(): void
{
    if (!is_admin()) {
        http_response_code(403);
        echo '<!doctype html><html lang="fr"><meta charset="utf-8"><link rel="stylesheet" href="assets/style.css"><body><main class="container section"><div class="panel"><h1>Accès refusé</h1><p>Cette page est réservée à l’administrateur.</p><a class="btn" href="index.php">Retour à l’accueil</a></div></main></body></html>';
        exit;
    }
}
