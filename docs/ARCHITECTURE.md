# Architecture — Application vulnérable

## Vue générale

```text
Navigateur visiteur / utilisateur / admin
                |
                v
        Apache + PHP 8.3
        (conteneur web)
                |
                v
            PDO / MySQL
                |
                v
          MySQL 8.0
        (conteneur db)
```

## Pages

| Fichier | Accès | Rôle |
|---|---|---|
| `index.php` | public | accueil |
| `contact.php` | public | formulaire de contact |
| `login.php` | public | authentification |
| `user.php` | utilisateur | espace utilisateur |
| `admin.php` | administrateur | messages + recherche utilisateur |
| `logout.php` | connecté | fin de session |
| `health.php` | public | état technique du lab |

## Authentification et sessions

Le login utilise une requête préparée afin que l'authentification ne soit pas la cible SQLi du projet.

Après connexion, PHP crée une vraie session serveur :

- `user_id`
- `username`
- `role`

Le cookie `PHPSESSID` est volontairement configuré avec `HttpOnly=false` dans la version vulnérable. Cela permet de conserver la chaîne pédagogique demandée : un XSS exécuté dans le navigateur de l'administrateur peut accéder au cookie de session, qui représente réellement une session serveur active.

## Base de données

### `users`

```text
id                  INT PK
username            VARCHAR(50)
password            VARCHAR(255)
role                VARCHAR(20)
adresse              VARCHAR(255)
date_naissance      DATE
num_securite_sociale VARCHAR(32)
```

### `messages`

```text
id          INT PK
nom         VARCHAR(100)
email       VARCHAR(100)
sujet       VARCHAR(150)
message     TEXT
date_envoi  TIMESTAMP
```

## Vulnérabilités intentionnelles

### XSS stocké

Le formulaire de contact stocke le message en base. Dans `admin.php`, les métadonnées sont échappées, mais le corps `message` est volontairement rendu sans échappement HTML.

### SQL injection

La recherche utilisateur dans `admin.php` concatène volontairement le paramètre `search` dans une requête SQL réservée à l'administrateur :

```sql
SELECT id, username, role, adresse
FROM users
WHERE username = '$search'
```

La projection contient quatre colonnes afin de correspondre au travail d'exploitation `UNION` demandé dans le sujet.
