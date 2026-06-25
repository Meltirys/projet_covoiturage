# Protocole de test — PennRide

**URL de test :** https://kercode10.greta-bretagne-sud.org/johan-leguennec/projet_covoiturage/public/  
**Date :** À compléter  
**Testeur :** À compléter  

---

## Légende

| Statut | Signification |
|--------|---------------|
| ✅ | Fonctionnel |
| ❌ | Erreur critique |
| ⚠️ | Comportement inattendu |
| — | Non testé |

---

## 1. Authentification

### 1.1 Inscription

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 1.1.1 | Soumettre le formulaire avec tous les champs valides | Compte créé, email de confirmation reçu, redirection vers page d'attente | — | |
| 1.1.2 | Soumettre avec un email non autorisé | Message d'erreur indiquant que l'email n'est pas autorisé | — | |
| 1.1.3 | Soumettre avec un email déjà utilisé | Message d'erreur indiquant que l'email est déjà associé à un compte | — | |
| 1.1.4 | Soumettre avec des champs manquants | Message d'erreur sur chaque champ manquant | — | |
| 1.1.5 | Soumettre avec une date de naissance invalide | Message d'erreur sur le champ date | — | |
| 1.1.6 | Soumettre avec un mot de passe trop court | Message d'erreur sur le champ mot de passe | — | |

### 1.2 Connexion

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 1.2.1 | Se connecter avec des identifiants valides (andr.sapk@test.com / password) | Redirection vers la page d'accueil, session active | — | |
| 1.2.2 | Se connecter avec un mauvais mot de passe | Message d'erreur | — | |
| 1.2.3 | Se connecter avec un email inexistant | Message d'erreur | — | |
| 1.2.4 | Accéder à une page protégée sans être connecté | Redirection vers la page de connexion | — | |

### 1.3 Déconnexion

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 1.3.1 | Cliquer sur "Déconnexion" | Session détruite, redirection vers la page d'accueil | — | |
| 1.3.2 | Accéder à une page protégée après déconnexion | Redirection vers la page de connexion | — | |

---

## 2. Gestion du profil

### 2.1 Consultation

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 2.1.1 | Accéder à "Mon profil" | Affichage des informations de l'utilisateur connecté | — | |
| 2.1.2 | Consulter le profil d'un autre utilisateur depuis une fiche de trajet | Affichage du profil de l'utilisateur cible | — | |
| 2.1.3 | Accéder au profil d'un utilisateur en modifiant l'URL directement | Redirection ou message d'erreur (accès non autorisé) | — | |

### 2.2 Modification

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 2.2.1 | Modifier ses informations avec des données valides | Profil mis à jour, message de confirmation | — | |
| 2.2.2 | Modifier avec des champs invalides | Messages d'erreur par champ | — | |
| 2.2.3 | Modifier l'email avec un email déjà utilisé par un autre compte | Message d'erreur | — | |
| 2.2.4 | Modifier l'email avec son propre email actuel | Mise à jour réussie sans erreur d'unicité | — | |
| 2.2.5 | Vérifier que les valeurs actuelles sont pré-remplies dans le formulaire | Champs pré-remplis avec les données actuelles | — | |

### 2.3 Changement de mot de passe

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 2.3.1 | Changer le mot de passe avec des données valides | Mot de passe mis à jour, message de confirmation | — | |
| 2.3.2 | Saisir un ancien mot de passe incorrect | Message d'erreur | — | |
| 2.3.3 | Saisir un nouveau mot de passe différent de la confirmation | Message d'erreur | — | |
| 2.3.4 | Saisir un nouveau mot de passe identique à l'ancien | Message d'erreur (differs) | — | |

### 2.4 Suppression du compte

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 2.4.1 | Supprimer son compte et confirmer | Compte supprimé, déconnexion, redirection | — | |
| 2.4.2 | Annuler la suppression | Compte conservé | — | |

---

## 3. Gestion des véhicules

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 3.1 | Ajouter une voiture avec des données valides | Voiture ajoutée, visible dans le profil | — | |
| 3.2 | Ajouter une voiture avec des données invalides (ex: année 1800) | Messages d'erreur par champ | — | |
| 3.3 | Ajouter une voiture avec plus de 8 places | Message d'erreur sur le champ nombre de places | — | |
| 3.4 | Modifier une voiture avec des données valides | Voiture mise à jour | — | |
| 3.5 | Supprimer une voiture | Voiture supprimée, disparaît du profil | — | |

---

## 4. Trajets

### 4.1 Création d'un trajet

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 4.1.1 | Créer un trajet avec des données valides | Trajet créé, visible dans la liste | — | |
| 4.1.2 | Créer un trajet sans voiture associée | Message d'erreur | — | |
| 4.1.3 | Créer un trajet avec une adresse invalide | Message d'erreur sur le champ adresse | — | |
| 4.1.4 | Créer un trajet récurrent en cochant plusieurs jours | Plusieurs occurrences créées | — | |
| 4.1.5 | Vérifier que le track est bien généré via OpenRouteService | Trajet visible sur la carte | — | |

### 4.2 Recherche de trajets

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 4.2.1 | Rechercher un trajet avec une adresse valide | Liste des trajets proches affichée | — | |
| 4.2.2 | Rechercher avec une adresse sans résultat | Message indiquant qu'aucun trajet n'est disponible | — | |
| 4.2.3 | Rechercher avec une adresse contenant des accents | Résultats corrects, pas d'erreur 404 | — | |
| 4.2.4 | Rechercher avec une adresse contenant un espace | Résultats corrects, pas d'erreur 404 | — | |
| 4.2.5 | Vérifier la pagination si plus de 20 résultats | Pagination fonctionnelle, navigation entre pages | — | |

### 4.3 Consultation d'un trajet

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 4.3.1 | Accéder à la fiche d'un trajet | Affichage des détails (départ, arrivée, conducteur, voiture) | — | |
| 4.3.2 | Accéder à un trajet inexistant | Page 404 ou redirection | — | |
| 4.3.3 | Vérifier l'affichage du trajet sur la carte | Polyligne du trajet visible | — | |

### 4.4 Annulation d'un trajet

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 4.4.1 | Annuler un trajet en tant que conducteur | Trajet marqué comme annulé, passagers notifiés par email | — | |
| 4.4.2 | Tenter d'annuler un trajet dont on n'est pas le conducteur | Accès refusé | — | |

---

## 5. Réservations

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 5.1 | Réserver une place sur un trajet disponible | Demande envoyée, email de confirmation reçu par le passager, email de notification reçu par le conducteur | — | |
| 5.2 | Réserver un trajet complet (plus de places disponibles) | Message d'erreur ou bouton désactivé | — | |
| 5.3 | Réserver son propre trajet | Accès refusé ou message d'erreur | — | |
| 5.4 | Accepter une réservation en tant que conducteur | Passager notifié par email, réservation confirmée | — | |
| 5.5 | Refuser une réservation en tant que conducteur | Passager notifié par email, réservation annulée | — | |
| 5.6 | Annuler sa participation à un trajet | Conducteur notifié par email, place libérée | — | |
| 5.7 | Consulter l'historique de ses trajets passés | Liste des trajets passés affichée | — | |
| 5.8 | Consulter l'historique de ses trajets à venir | Liste des trajets futurs affichée | — | |

---

## 6. Signalement d'un utilisateur

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 6.1 | Signaler un utilisateur depuis sa fiche profil | Signalement enregistré, message de confirmation | — | |
| 6.2 | Tenter de signaler en modifiant le champ id dans le formulaire | Accès refusé (vérification session) | — | |
| 6.3 | Tenter de se signaler soi-même | Message d'erreur | — | |

---

## 7. Contact

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 7.1 | Envoyer un message de contact avec des données valides | Email reçu par l'administrateur, message de confirmation affiché | — | |
| 7.2 | Envoyer sans remplir tous les champs | Messages d'erreur par champ | — | |
| 7.3 | Envoyer sans être connecté | Formulaire accessible et fonctionnel | — | |

---

## 8. Back-office administrateur

> Utiliser le compte admin : add.mine@admin.fr / password

### 8.1 Validation des comptes

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 8.1.1 | Accéder au dashboard admin | Accès autorisé, liste des utilisateurs en attente visible | — | |
| 8.1.2 | Accéder au dashboard avec un compte utilisateur standard | Accès refusé | — | |
| 8.1.3 | Valider un compte en attente | Compte activé, email de confirmation envoyé à l'utilisateur | — | |
| 8.1.4 | Refuser un compte en attente | Compte refusé, email de refus envoyé à l'utilisateur | — | |

### 8.2 Gestion des utilisateurs

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 8.2.1 | Rechercher un utilisateur par nom | Résultats filtrés affichés | — | |
| 8.2.2 | Rechercher avec un nom contenant des accents | Résultats corrects | — | |
| 8.2.3 | Modifier le rôle d'un utilisateur | Rôle mis à jour | — | |
| 8.2.4 | Supprimer un utilisateur | Utilisateur supprimé, ses voitures également | — | |
| 8.2.5 | Vérifier la pagination si plus de 10 résultats | Pagination fonctionnelle | — | |

### 8.3 Gestion des signalements

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 8.3.1 | Consulter la liste des signalements non résolus | Liste affichée | — | |
| 8.3.2 | Marquer un signalement comme résolu | Signalement retiré de la liste | — | |

---

## 9. Sécurité

| # | Action | Résultat attendu | Statut | Remarque |
|---|--------|-----------------|--------|----------|
| 9.1 | Soumettre un formulaire sans token CSRF | Erreur 403 | — | |
| 9.2 | Accéder à une route admin sans être admin | Redirection ou erreur 403 | — | |
| 9.3 | Modifier l'id dans l'URL pour accéder aux données d'un autre utilisateur | Accès refusé | — | |
| 9.4 | Injecter du HTML dans un champ de formulaire | HTML échappé, pas d'injection | — | |

---

## 10. Emails transactionnels

| # | Email | Déclencheur | Statut | Remarque |
|---|-------|------------|--------|----------|
| 10.1 | Création de compte | Inscription | — | |
| 10.2 | Compte validé | Validation admin | — | |
| 10.3 | Compte refusé | Refus admin | — | |
| 10.4 | Demande de réservation reçue (passager) | Demande de réservation | — | |
| 10.5 | Nouvelle demande (conducteur) | Demande de réservation | — | |
| 10.6 | Réservation acceptée | Acceptation conducteur | — | |
| 10.7 | Réservation refusée | Refus conducteur | — | |
| 10.8 | Trajet annulé | Annulation conducteur | — | |
| 10.9 | Message de contact | Formulaire de contact | — | |

---

## 11. Compatibilité et accessibilité

| # | Test | Résultat attendu | Statut | Remarque |
|---|------|-----------------|--------|----------|
| 11.1 | Tester sur Chrome | Affichage correct | — | |
| 11.2 | Tester sur Firefox | Affichage correct | — | |
| 11.3 | Tester sur mobile (responsive) | Affichage adapté, menu burger fonctionnel | — | |
| 11.4 | Valider le HTML avec W3C Validator | Aucune erreur critique | — | |
| 11.5 | Navigation au clavier (Tab) | Tous les éléments interactifs accessibles | — | |

---

## Résumé des tests

| Catégorie | Total | ✅ | ❌ | ⚠️ |
|-----------|-------|----|----|-----|
| 1. Authentification | 10 | | | |
| 2. Profil | 13 | | | |
| 3. Véhicules | 5 | | | |
| 4. Trajets | 13 | | | |
| 5. Réservations | 8 | | | |
| 6. Signalement | 3 | | | |
| 7. Contact | 3 | | | |
| 8. Back-office | 9 | | | |
| 9. Sécurité | 4 | | | |
| 10. Emails | 9 | | | |
| 11. Compatibilité | 5 | | | |
| **Total** | **82** | | | |