<?php
require_once __DIR__ . '/partials.php';
require_user();

if (is_admin()) {
    header('Location: admin.php');
    exit;
}

$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = $_POST['message'] ?? '';

    if ($email === '' || $sujet === '' || $message === '') {
        $error = 'Tous les champs sont obligatoires.';
    } else {
        $stmt = db()->prepare('INSERT INTO messages (nom, email, sujet, message) VALUES (?, ?, ?, ?)');
        $stmt->execute([$_SESSION['username'], $email, $sujet, $message]);
        $success = 'Votre message a bien été envoyé au support.';
    }
}

$stmt = db()->prepare('SELECT id, username, role, adresse, date_naissance FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$profile = $stmt->fetch();

render_header('Espace utilisateur');
?>
<main class="section">
    <div class="container">
        <div class="admin-head">
            <div><span class="eyebrow">Utilisateur</span><h1 class="page-title">Bienvenue, <?= e($_SESSION['username']) ?></h1></div>
            <span class="badge">Rôle : <?= e($_SESSION['role']) ?></span>
        </div>

        <div class="split top-align">
            <section class="panel">
                <h3>Mon profil</h3>
                <dl class="profile-list">
                    <div><dt>Identifiant</dt><dd><?= e((string) ($profile['id'] ?? '')) ?></dd></div>
                    <div><dt>Nom d'utilisateur</dt><dd><?= e($profile['username'] ?? '') ?></dd></div>
                    <div><dt>Adresse</dt><dd><?= e($profile['adresse'] ?? '') ?></dd></div>
                    <div><dt>Date de naissance</dt><dd><?= e($profile['date_naissance'] ?? '') ?></dd></div>
                </dl>
            </section>

            <section class="panel form-panel">
                <h3>Contacter le support</h3>
                <?php if ($success): ?><div class="flash success"><?= e($success) ?></div><?php endif; ?>
                <?php if ($error): ?><div class="flash danger"><?= e($error) ?></div><?php endif; ?>
                <form method="post" class="form-grid">
                    <label>Email<input type="email" name="email" required></label>
                    <label>Sujet<input type="text" name="sujet" required></label>
                    <label>Message<textarea name="message" rows="6" required></textarea></label>
                    <button class="btn" type="submit">Envoyer</button>
                </form>
            </section>
        </div>
    </div>
</main>
<?php render_footer(); ?>
