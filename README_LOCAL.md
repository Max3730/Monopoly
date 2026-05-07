# Monopoly Hot Couple - Version Locale

Cette version utilise localStorage pour simuler le multi-joueur avec codes d'invitation. Aucun serveur n'est requis.

## Comment tester le multi-joueur

### Méthode 1: Deux onglets du même navigateur (recommandé)

1. **Ouvrez le fichier** `monopoly_couple_hot.html` dans votre navigateur
2. **Joueur 1**: Entrez votre prénom et cliquez sur "Créer"
3. **Notez le code d'invitation** (ex: ABC123) qui s'affiche
4. **Ouvrez un nouvel onglet** avec le même fichier
5. **Joueur 2**: Entrez votre prénom, le code d'invitation, et cliquez sur "Rejoindre"
6. La partie démarre automatiquement !

### Méthode 2: Deux navigateurs différents

1. **Ouvrez le fichier** dans Chrome
2. **Joueur 1**: Créez une partie et notez le code
3. **Ouvrez le fichier** dans Firefox/Edge
4. **Joueur 2**: Rejoignez avec le code

### Méthode 3: Mode solo (test)

1. Entrez votre prénom
2. Cliquez "Créer"
3. Le code s'affiche mais vous ne pouvez pas rejoindre seul
4. Pour tester le jeu seul, modifiez temporairement le code pour autoriser 1 joueur

## Fonctionnalités

✅ **Codes d'invitation uniques** - Chaque partie a son propre code de 6 caractères
✅ **Synchronisation automatique** - Le jeu se met à jour en temps réel via polling
✅ **Multi-parties** - Plusieurs parties peuvent coexister simultanément
✅ **Persistance** - Les parties sont sauvegardées dans localStorage
✅ **Design responsive** - Fonctionne sur mobile et PC sans défilement
✅ **Design professionnel** - Gradients, ombres, animations

## Limitations de la version locale

⚠️ **Même appareil uniquement** - Les deux joueurs doivent utiliser le même appareil/navigateur
⚠️ **Pas de multi-appareil** - Impossible de jouer entre différents appareils (téléphone + PC)
⚠️ **Même navigateur** - Fonctionne mieux dans le même navigateur (Chrome + Chrome)

## Pour le vrai multi-joueur en ligne

Si vous voulez un vrai multi-joueur entre appareils différents, vous avez 2 options:

### Option 1: Installer PHP (recommandé pour hébergement)
1. Installez XAMPP, WAMP ou MAMP
2. Utilisez les fichiers `api.php` et `games.json` fournis
3. Suivez le guide `README_PHP.md`

### Option 2: Firebase (recommandé pour facilité)
1. Créez un projet Firebase gratuit
2. Activez Realtime Database
3. Configurez les règles de sécurité
4. Intégrez les clés dans le fichier

## Structure des données

Les parties sont stockées dans localStorage avec la clé:
```
monopoly_game_{CODE_INVITATION}
```

Exemple:
```
monopoly_game_ABC123 = {
  players: ["Alice", "Bob"],
  currentPlayerIndex: 0,
  positions: [5, 12],
  gameStarted: true,
  createdAt: 1234567890
}
```

## Nettoyage

Pour supprimer toutes les parties:
1. Ouvrez la console du navigateur (F12)
2. Tapez: `localStorage.clear()`
3. Rechargez la page

## Dépannage

### Le code ne marche pas
- Vérifiez que vous utilisez le même code exact (majuscules)
- Essayez dans le même navigateur
- Ouvrez la console (F12) pour voir les erreurs

### Les joueurs ne se synchronisent pas
- Le polling se fait toutes les 0.5 secondes
- Assurez-vous que les deux onglets sont ouverts
- Vérifiez le localStorage dans la console

### Le jeu ne démarre pas
- Assurez-vous que les 2 joueurs sont connectés
- Le message "✓ Partie prête !" doit s'afficher
- Le jeu démarre automatiquement quand 2 joueurs sont présents
