<?php
require_once __DIR__ . '/bootstrap.php';

function render_header(string $title): void
{
    $user = is_logged_in() ? e($_SESSION['username']) : null;
    $admin = is_admin();
    ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> — Ethical Hacking Lab</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
    <div class="container nav-wrap">
        <a class="brand" href="index.php"><span class="brand-mark">EH</span><span>Ethical Hacking Lab</span></a>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="contact.php">Contact</a>
            <?php if ($admin): ?>
                <a href="admin.php">Administration</a>
            <?php elseif ($user): ?>
                <a href="user.php">Mon espace</a>
            <?php endif; ?>
            <?php if ($user): ?>
                <span class="nav-user"><?= $user ?></span>
                <a class="ghost" href="logout.php">Déconnexion</a>
            <?php else: ?>
                <a class="ghost" href="login.php">Connexion</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<?php
}

function render_footer(): void
{
    ?>
<footer class="footer">
    <div class="container">Application volontairement vulnérable — usage pédagogique local uniquement.</div>
</footer>
</body>
</html>
<?php
}
