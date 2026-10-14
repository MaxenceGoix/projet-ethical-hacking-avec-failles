# Projet Ethical Hacking 1 — Socle Maxence V2

Application web **volontairement vulnérable** conçue pour le projet de cours :

`formulaire de contact → XSS stocké → compromission de session admin → accès admin → SQLi → extraction`

> **Usage pédagogique local uniquement.** Ne pas exposer cette version sur Internet et ne pas réutiliser ses mécanismes vulnérables en production.

## Stack

- PHP 8.3 + Apache
- MySQL 8.0
- PDO
- Docker Compose

## Lancer le projet

Depuis le dossier :

```powershell
docker compose up --build -d
```

Puis ouvrir :

- Application : http://localhost:8080
- Healthcheck : http://localhost:8080/health.php

## Comptes de démonstration

| Rôle | Utilisateur | Mot de passe |
|---|---|---|
| Administrateur | `admin` | `admin_super_secret` |
| Utilisateur | `user` | `motdepasse` |
| Utilisateur | `maxence` | `User123!` |

Toutes les données sont fictives.

## Réinitialiser la base

```powershell
docker compose down -v
docker compose up --build -d
```

Le `-v` supprime le volume MySQL afin que `init.sql` soit rejoué.


## Documentation

- `docs/ARCHITECTURE.md`
- `docs/MAXENCE_LIVRABLE.md`
