<?php
require_once __DIR__ . '/partials.php';
render_header('Accueil');
?>
<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Projet Ethical Hacking 1</span>
                <h1>Portail de support et d’administration</h1>
                <p class="lead">Socle PHP/MySQL destiné au laboratoire XSS stocké → compromission de session → accès administrateur → SQL injection.</p>
                <div class="actions">
                    <a class="btn" href="contact.php">Contacter le support</a>
                    <a class="btn secondary" href="login.php">Se connecter</a>
                </div>
            </div>
            <aside class="panel hero-card">
                <h3>Fonctionnalités</h3>
                <div class="feature"><b>01</b><span>Authentification avec rôles utilisateur / administrateur</span></div>
                <div class="feature"><b>02</b><span>Formulaire public de contact stocké en base</span></div>
                <div class="feature"><b>03</b><span>Back-office des messages réservé à l’administrateur</span></div>
                <div class="feature"><b>04</b><span>Recherche d’utilisateurs pour la démonstration SQLi</span></div>
            </aside>
        </div>
    </section>

    <section class="section">
        <div class="container cards">
            <a class="panel clickable" href="contact.php"><h3>Support</h3><p>Envoyer un message sans authentification.</p></a>
            <a class="panel clickable" href="login.php"><h3>Compte utilisateur</h3><p>Accéder à son espace après connexion.</p></a>
            <a class="panel clickable" href="admin.php"><h3>Back-office</h3><p>Consulter les messages et rechercher des utilisateurs.</p></a>
        </div>
    </section>
</main>
<?php render_footer(); ?>
