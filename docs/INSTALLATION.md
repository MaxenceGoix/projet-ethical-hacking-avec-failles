# Installation

## Prérequis

- Docker Desktop
- Docker Compose v2
- Ports locaux `8080` et `3306` disponibles

## Démarrage

Sous PowerShell :

```powershell
cd chemin\vers\projet-ethical-hacking-maxence-v2
docker compose up --build -d
```

Vérifier :

```powershell
docker compose ps
```

Puis ouvrir :

```text
http://localhost:8080
```

## Voir les logs

```powershell
docker compose logs -f web
docker compose logs -f db
```

## Arrêter

```powershell
docker compose down
```

## Réinitialiser complètement le laboratoire

```powershell
docker compose down -v
docker compose up --build -d
```

Le volume MySQL doit être supprimé pour rejouer `init.sql` après une modification du schéma ou des données initiales.

## Dépannage

Si le navigateur affiche une erreur de connexion à la base juste après le démarrage :

```powershell
docker compose ps
docker compose logs db
```

Le service web attend normalement que le healthcheck MySQL soit valide avant de démarrer.
