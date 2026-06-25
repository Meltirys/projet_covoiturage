# PennRide

## Présentation

PennRide est une application de covoiturage destinée aux stagiaires du GRETA-CFA Bretagne Sud.

L'application a pour vocation de simplifier les trajets quotidiens des apprenants en permettant :

- **Mise en relation** — Publier facilement ses trajets ou rechercher des conducteurs effectuant la même route vers le centre de formation.
- **Points de rendez-vous** — Proposer des points de rencontre sur-mesure (arrêts de bus, parkings locaux) lors d'une demande de réservation.
- **Demandes de trajets** — Permettre aux passagers ne trouvant pas de trajet de déposer une demande visible par tous, que d'autres utilisateurs peuvent rejoindre.
- **Sécurité** — Réseau strictement fermé, réservé aux membres du GRETA et modéré par l'administration (validation des comptes, signalements).
- **Éco-mobilité** — Encourager le partage des trajets pour limiter l'impact carbone et réduire les frais de transport.

## Prérequis

- PHP 8 ou plus récent
- MySQL / MariaDB
- Composer
- Un serveur web (Apache ou équivalent)

## Installation

1. **Cloner le dépôt**

```bash
git clone https://github.com/Meltirys/projet_covoiturage.git
cd projet_covoiturage
```

2. **Installer les dépendances**

```bash
composer install
```

3. **Configurer l'environnement**

Copier le fichier `.env` et adapter les valeurs :

```bash
cp env .env
```

Modifier les paramètres suivants dans `.env` :

```
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = 127.0.0.1
database.default.database = PennRide
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

4. **Créer la base de données**

```sql
CREATE DATABASE PennRide;
```

5. **Exécuter les migrations**

```bash
php spark migrate
```

6. **Peupler la base de données (optionnel)**

```bash
php spark db:seed GlobalSeeder
```

7. **Lancer le serveur de développement**

```bash
php spark serve
```

L'application est accessible sur `http://localhost:8080`, auquel cas il faudra ajouter `--port 8080` à la commande précédente.

## Technologies

- **Framework** — CodeIgniter 4.7
- **Langage** — PHP 8.2
- **Base de données** — MySQL
- **Front-end** — Tailwind CSS, JavaScript
- **API externe** — OpenRouteService (calcul d'itinéraires), API Géocodage du gouvernement français (adresses)
- **Mails** — PHPMailer

## Équipe

Projet réalisé dans le cadre de la période de stage au GRETA-CFA Bretagne Sud du 27 Avril 2026 au 26 Juin 2026, pour la formation de Développeur Web Full-Stack.

**Back-end :**
- Johan Le Guennec
- Zadig Mouquet
- Matteo Bourbon

**Front-end :**
- Amélie Bourdin
- Linda Hillairet
