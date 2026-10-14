<?php
require_once __DIR__ . '/partials.php';

$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = $_POST['message'] ?? '';

    if ($nom === '' || $email === '' || $sujet === '' || $message === '') {
        $error = 'Tous les champs sont obligatoires.';
    } else {
        // Insertion paramétrée : la vulnérabilité XSS est à l'AFFICHAGE dans le back-office.
        $stmt = db()->prepare('INSERT INTO messages (nom, email, sujet, message) VALUES (?, ?, ?, ?)');
        $stmt->execute([$nom, $email, $sujet, $message]);
        $success = 'Votre message a bien été envoyé au support.';
    }
}

$prefillName = is_logged_in() ? $_SESSION['username'] : '';
render_header('Contact');
?>
<main class="section">
    <div class="container narrow-wide">
        <div class="panel form-panel">
            <span class="eyebrow">Support</span>
            <h1 class="page-title">Nous contacter</h1>
            <p class="muted">Ce formulaire est accessible publiquement et les messages sont consultés depuis le back-office.</p>

            <?php if ($success): ?><div class="flash success"><?= e($success) ?></div><?php endif; ?>
            <?php if ($error): ?><div class="flash danger"><?= e($error) ?></div><?php endif; ?>

            <form method="post" class="form-grid">
                <label>Nom
                    <input type="text" name="nom" value="<?= e($prefillName) ?>" required>
                </label>
                <label>Email
                    <input type="email" name="email" placeholder="vous@example.test" required>
                </label>
                <label>Sujet
                    <input type="text" name="sujet" required>
                </label>
                <label>Message
                    <textarea name="message" rows="7" required></textarea>
                </label>
                <button class="btn" type="submit">Envoyer le message</button>
            </form>
        </div>
    </div>
</main>
<?php render_footer(); ?>
