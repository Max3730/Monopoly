# Configuration Firebase pour Monopoly Hot Couple

Ce jeu utilise Firebase Realtime Database pour permettre le multi-joueur en temps réel sur différents appareils.

## Étapes de configuration

### 1. Créer un projet Firebase

1. Allez sur [https://console.firebase.google.com/](https://console.firebase.google.com/)
2. Cliquez sur "Ajouter un projet"
3. Donnez un nom à votre projet (ex: "monopoly-hot-couple")
4. Suivez les étapes de création

### 2. Activer Realtime Database

1. Dans le console Firebase, cliquez sur "Realtime Database" dans le menu de gauche
2. Cliquez sur "Créer une base de données"
3. Choisissez un emplacement (ex: europe-west1)
4. Sélectionnez "Mode test" pour commencer (ou configurez les règles de sécurité plus tard)
5. Cliquez sur "Activer"

### 3. Obtenir les clés de configuration

1. Cliquez sur l'icône d'engrenage ⚙️ à côté de "Vue d'ensemble du projet"
2. Sélectionnez "Paramètres du projet"
3. Faites défiler jusqu'à la section "Vos applications"
4. Cliquez sur l'icône web (</>)
5. Donnez un nom à votre app (ex: "Monopoly Web")
6. **NE COCHEZ PAS** "Firebase Hosting" pour l'instant
7. Cliquez sur "Enregistrer l'application"
8. Copiez le bloc de configuration `firebaseConfig`

### 4. Mettre à jour le fichier HTML

Ouvrez `monopoly_couple_hot.html` et remplacez les valeurs dans la configuration Firebase (lignes 601-608) par vos propres clés:

```javascript
const firebaseConfig = {
  apiKey: "VOTRE_API_KEY",
  authDomain: "VOTRE_PROJET.firebaseapp.com",
  databaseURL: "https://VOTRE_PROJET-default-rtdb.firebaseio.com",
  projectId: "VOTRE_PROJET",
  storageBucket: "VOTRE_PROJET.appspot.com",
  messagingSenderId: "VOTRE_SENDER_ID"
};
```

### 5. Règles de sécurité (optionnel mais recommandé)

Dans la console Firebase, allez dans Realtime Database > Règles et remplacez par:

```json
{
  "rules": {
    "games": {
      ".read": true,
      ".write": true,
      "$gameId": {
        ".validate": "newData.hasChildren(['players', 'currentPlayerIndex', 'positions', 'gameStarted'])"
      }
    }
  }
}
```

⚠️ **Attention**: Ces règles permettent à tout le monde de lire et écrire. Pour un jeu public, vous devriez ajouter une authentification Firebase pour plus de sécurité.

**Structure des données:**
- Chaque partie est stockée sous `/games/{CODE_INVITATION}`
- Le code d'invitation est une chaîne de 6 caractères alphanumériques (ex: ABC123)
- Plusieurs parties peuvent coexister simultanément

## Mode LocalStorage (Fallback)

Si Firebase n'est pas configuré, le jeu utilisera automatiquement le localStorage du navigateur. Cela fonctionne parfaitement pour:
- Tester le jeu localement
- Jouer sur le même appareil/navigateur
- Développement

## Déploiement

Pour mettre le jeu en ligne:

### Option 1: Firebase Hosting (Recommandé)

1. Installez Firebase CLI: `npm install -g firebase-tools`
2. Connectez-vous: `firebase login`
3. Initialisez: `firebase init` (choisissez Hosting)
4. Copiez `monopoly_couple_hot.html` dans le dossier `public`
5. Déployez: `firebase deploy`

### Option 2: Autre hébergement

Vous pouvez héberger le fichier HTML sur n'importe quel hébergeur statique:
- Netlify
- Vercel
- GitHub Pages
- Votre propre serveur

## Support

Si vous avez des problèmes:
1. Vérifiez que les clés Firebase sont correctes
2. Vérifiez que Realtime Database est activée
3. Ouvrez la console du navigateur (F12) pour voir les erreurs
