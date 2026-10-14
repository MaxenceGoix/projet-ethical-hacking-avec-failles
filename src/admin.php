<?php
require_once __DIR__ . '/partials.php';
require_admin();

$pdo = db();
$messages = $pdo->query('SELECT * FROM messages ORDER BY date_envoi DESC, id DESC')->fetchAll();
$userCount = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$messageCount = count($messages);

$search = trim($_GET['search'] ?? '');
$searchRows = [];
$sqlError = null;
$userMessages = [];

if ($search !== '') {
    // -------------------------------------------------------------------------
    // VULNÉRABILITÉ INTENTIONNELLE DU TP : SQLi dans une fonction admin.
    // 4 colonnes sont projetées afin de permettre la démonstration UNION.
    // NE PAS utiliser ce code en production.
    // -------------------------------------------------------------------------
    $query = "SELECT id, username, role, adresse FROM users WHERE username = '$search'";

    try {
        $results = $pdo->query($query);
        if ($results) {
            $searchRows = $results->fetchAll();
        }
    } catch (PDOException $exception) {
        // Affichage d'erreur volontaire pour faciliter l'observation pédagogique.
        $sqlError = $exception->getMessage();
    }

    // Cette seconde requête n'est pas la cible SQLi.
    $stmtMsg = $pdo->prepare('SELECT date_envoi, sujet, message FROM messages WHERE nom = ? ORDER BY date_envoi DESC');
    $stmtMsg->execute([$search]);
    $userMessages = $stmtMsg->fetchAll();
}

render_header('Administration');
?>
<main class="section">
    <div class="container">
        <div class="admin-head">
            <div>
                <span class="eyebrow">Back-office</span>
                <h1 class="page-title">Administration</h1>
                <p class="muted">Messages reçus et recherche interne des utilisateurs.</p>
            </div>
            <span class="badge">Session : <?= e(session_id()) ?></span>
        </div>

        <div class="stats">
            <div class="panel stat"><span>Utilisateurs</span><strong><?= $userCount ?></strong></div>
            <div class="panel stat"><span>Messages</span><strong><?= $messageCount ?></strong></div>
            <div class="panel stat"><span>Rôle actif</span><strong>admin</strong></div>
        </div>

        <section class="panel section-block">
            <div class="section-title-row"><div><span class="eyebrow">Partie 1</span><h2>Boîte de réception globale</h2></div><span class="badge"><?= $messageCount ?> message(s)</span></div>
            <?php if (!$messages): ?>
                <p class="muted">Aucun message.</p>
            <?php else: ?>
                <div class="message-list">
                <?php foreach ($messages as $msg): ?>
                    <article class="message-item">
                        <div class="message-meta">
                            <div><strong><?= e($msg['sujet']) ?></strong><span><?= e($msg['nom']) ?> · <?= e($msg['email']) ?></span></div>
                            <time><?= e($msg['date_envoi']) ?></time>
                        </div>
                        <div class="message-body raw-output">
                            <?php
                            // VULNÉRABILITÉ XSS STOCKÉ INTENTIONNELLE :
                            // le corps du message est rendu sans échappement HTML.
                            echo nl2br($msg['message']);
                            ?>
                        </div>
                    </article>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="panel section-block">
            <div class="section-title-row"><div><span class="eyebrow">Partie 2</span><h2>Recherche d'utilisateur</h2></div><span class="badge warning">Zone SQLi du TP</span></div>
            <form method="get" class="search">
                <input type="text" name="search" placeholder="Nom d'utilisateur" value="<?= e($search) ?>">
                <button class="btn" type="submit">Rechercher</button>
                <?php if ($search !== ''): ?><a class="btn secondary" href="admin.php">Effacer</a><?php endif; ?>
            </form>

            <?php if ($sqlError): ?><div class="flash danger"><strong>Erreur SQL :</strong> <?= e($sqlError) ?></div><?php endif; ?>

            <?php if ($search !== ''): ?>
                <h3 class="result-title">Informations du compte</h3>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>ID</th><th>Nom d'utilisateur</th><th>Rôle</th><th>Adresse</th></tr></thead>
                        <tbody>
                        <?php if (!$searchRows): ?>
                            <tr><td colspan="4">Aucun utilisateur trouvé.</td></tr>
                        <?php else: ?>
                            <?php foreach ($searchRows as $row): ?>
                                <tr>
                                    <td><?= e((string) $row['id']) ?></td>
                                    <td><?= e((string) $row['username']) ?></td>
                                    <td><?= e((string) $row['role']) ?></td>
                                    <td><?= e((string) $row['adresse']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <h3 class="result-title">Messages envoyés par cet utilisateur</h3>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Date</th><th>Sujet</th><th>Message</th></tr></thead>
                        <tbody>
                        <?php if (!$userMessages): ?>
                            <tr><td colspan="3">Aucun message trouvé.</td></tr>
                        <?php else: ?>
                            <?php foreach ($userMessages as $msg): ?>
                                <tr><td><?= e($msg['date_envoi']) ?></td><td><?= e($msg['sujet']) ?></td><td><?= e($msg['message']) ?></td></tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php render_footer(); ?>
