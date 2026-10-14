# Livrable Maxence — Application & architecture

## Responsabilités couvertes

- structure du projet ;
- environnement serveur cible via Docker ;
- base MySQL et schéma ;
- tables `users` et `messages` ;
- comptes utilisateur / administrateur ;
- login / logout ;
- vraie gestion de session PHP ;
- pages utilisateur et administrateur ;
- formulaire de contact public ;
- back-office de consultation des messages ;
- jeu de données fictives sensibles ;
- documentation d'installation et d'architecture.

## Choix de conception

La base de Maxence a été conservée : PHP/Apache, MySQL, PDO, pages simples et recherche SQLi dans le back-office.

Les améliorations ajoutées sont surtout :

- vraie session serveur au lieu d'un cookie contenant directement le nom `admin` ;
- interface visuelle cohérente ;
- centralisation de la connexion BDD et des contrôles de rôle ;
- healthcheck MySQL ;
- documentation ;
- structure plus lisible et plus facile à présenter.

## Important

Cette version reste volontairement vulnérable pour les besoins du TP. La version sécurisée devra être réalisée séparément lors de la partie remédiation.
