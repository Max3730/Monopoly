# Monopoly Hot Couple - Système PHP

Ce jeu utilise PHP pour le multi-joueur en temps réel avec codes d'invitation.

## Prérequis

Vous devez avoir un serveur PHP installé sur votre machine:
- **Windows**: XAMPP, WAMP, ou php built-in server
- **Mac**: MAMP ou php built-in server
- **Linux**: Apache + PHP ou php built-in server

## Installation

### Option 1: Serveur PHP intégré (le plus simple)

1. Ouvrez un terminal dans le dossier `d:\Monopoly`
2. Lancez la commande:
   ```bash
   php -S localhost:8000
   ```
3. Ouvrez votre navigateur sur: `http://localhost:8000/monopoly_couple_hot.html`

### Option 2: XAMPP/WAMP (Windows)

1. Installez XAMPP ou WAMP
2. Copiez le dossier `Monopoly` dans `htdocs` (XAMPP) ou `www` (WAMP)
3. Démarrez Apache
4. Ouvrez: `http://localhost/Monopoly/monopoly_couple_hot.html`

## Fonctionnement

### Créer une partie
1. Entrez votre prénom
2. Cliquez sur "Créer"
3. Un code d'invitation s'affiche (ex: ABC123)
4. Partagez ce code avec votre partenaire

### Rejoindre une partie
1. Entrez votre prénom
2. Entrez le code d'invitation
3. Cliquez sur "Rejoindre"
4. La partie démarre automatiquement quand les 2 joueurs sont connectés

## Structure des fichiers

- `monopoly_couple_hot.html` - Le jeu complet (HTML/CSS/JS)
- `api.php` - API pour gérer les parties
- `games.json` - Stockage des parties (créé automatiquement)

## API Endpoints

L'API PHP expose les endpoints suivants:

- `POST api.php?action=create` - Créer une nouvelle partie
- `POST api.php?action=join` - Rejoindre une partie avec un code
- `GET api.php?action=get&code=CODE` - Récupérer l'état d'une partie
- `POST api.php?action=update` - Mettre à jour l'état d'une partie
- `POST api.php?action=delete` - Supprimer une partie

## Synchronisation

Le jeu utilise un système de polling (interrogation chaque seconde) pour:
- Synchroniser l'état du jeu entre les joueurs
- Détecter quand le second joueur rejoint
- Mettre à jour les positions des pions en temps réel

## Nettoyage automatique

Les parties sont automatiquement supprimées après 24 heures pour éviter d'accumuler des données inutiles.

## Déploiement en ligne

Pour mettre le jeu en ligne:

### Option 1: Hébergement PHP standard
- Hébergeur: OVH, Hostinger, Ionos, etc.
- Upload les fichiers sur le serveur
- Assurez-vous que le dossier a les permissions d'écriture pour `games.json`

### Option 2: Hébergement gratuit
- 000webhost.com
- InfinityFree
- AwardSpace

## Sécurité

Pour un environnement de production, vous devriez:
- Ajouter une authentification
- Limiter le taux de requêtes (rate limiting)
- Valider toutes les entrées
- Utiliser HTTPS

## Dépannage

### Erreur "Erreur de connexion"
- Vérifiez que le serveur PHP fonctionne
- Vérifiez que `api.php` est accessible
- Ouvrez la console du navigateur (F12) pour voir les erreurs

### Le code ne fonctionne pas
- Vérifiez que vous n'ouvrez pas le fichier directement (file://)
- Utilisez http://localhost ou votre domaine
- Vérifiez les permissions d'écriture sur `games.json`

### Les joueurs ne se synchronisent pas
- Le polling se fait chaque seconde
- Vérifiez que les deux joueurs utilisent le même code
- Ouvrez la console pour voir les erreurs réseau
