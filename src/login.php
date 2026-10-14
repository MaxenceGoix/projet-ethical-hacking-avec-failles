<?php
require_once __DIR__ . '/partials.php';

if (is_logged_in()) {
    header('Location: ' . (is_admin() ? 'admin.php' : 'user.php'));
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Le login n'est volontairement PAS la cible SQLi : requête préparée.
    $stmt = db()->prepare('SELECT id, username, password, role FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header('Location: ' . ($user['role'] === 'admin' ? 'admin.php' : 'user.php'));
        exit;
    }

    $error = 'Identifiants invalides.';
}

render_header('Connexion');
?>
<main class="section">
    <div class="container narrow">
        <div class="panel form-panel">
            <span class="eyebrow">Authentification</span>
            <h1 class="page-title">Connexion</h1>
            <p class="muted">Connectez-vous avec un compte de démonstration.</p>
            <?php if ($error): ?><div class="flash danger"><?= e($error) ?></div><?php endif; ?>
            <form method="post" class="form-grid" autocomplete="off">
                <label>Nom d'utilisateur
                    <input type="text" name="username" required autofocus>
                </label>
                <label>Mot de passe
                    <input type="password" name="password" required>
                </label>
                <button class="btn" type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</main>
<?php render_footer(); ?>
