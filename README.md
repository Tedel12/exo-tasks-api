# Mon Projet Laravel API: exowtasks-api

## Description

Cette application est une API RESTful développée avec Laravel, qui gère les équipes, les utilisateurs (membres) et les tâches. Elle utilise Sanctum pour l'authentification..

---

## Prérequis

* PHP >= 8.0 minimum
* Composer (peut etre telecharger sur le site officiel)
* PostgreSQL (base de donnes utilisé)
* Laravel 10+ (requis)
* Node.js et npm (facultatif pour assets frontend..)

---

## Installation

1. **Cloner le dépôt**

```bash
git clone https://github.com/Tedel12/exo-tasks-api.git
cd exo-tasks-api
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Copier le fichier .env**

```bash
cp .env.example .env
```

4. **Configurer la base de données**

Modifier le fichier `.env` :

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

5. **Générer la clé de l'application**

```bash
php artisan key:generate (utile)
```

6. **Exécuter les migrations et seeders**

```bash
php artisan migrate --seed (vider la bdd, creer les migrations et les remplir)
```

7. **Lancer le serveur local**

```bash
php artisan serve (obligé)
```


8.
- Backup de la base: `backup/exo_tasks_api_bdd_of`

---

## Utilisation de l'API

Toutes les routes sont préfixées par `/api/v1`.

### Authentification

* `POST /api/v1/register` : inscription
* `POST /api/v1/login` : connexion
* `POST /api/v1/logout` : déconnexion (auth requise)

### Utilisateur connecté

* `GET /api/v1/user` : infos utilisateur actuel (auth requise)

### Équipes

* `GET /api/v1/teams` : lister les équipes (auth requise)
* `GET /api/v1/teams/{id}` : détails équipe
* `POST /api/v1/teams` : créer une équipe
* `PUT /api/v1/teams/{id}` : mettre à jour une équipe
* `DELETE /api/v1/teams/{id}` : supprimer une équipe

### Utilisateurs ( comme membres)

* `GET /api/v1/users` : lister les utilisateurs (auth requise)
* `GET /api/v1/users/{id}` : détails utilisateur
* `POST /api/v1/users` : créer un utilisateur
* `PUT /api/v1/users/{id}` : mettre à jour un utilisateur
* `DELETE /api/v1/users/{id}` : supprimer un utilisateur

### Tâches

* `GET /api/v1/tasks` : lister les tâches (auth requise)
* `GET /api/v1/tasks/{id}` : détails tâche
* `POST /api/v1/tasks` : créer une tâche (manager seulement)
* `PUT /api/v1/tasks/{id}` : mettre à jour une tâche (manager seulement)
* `DELETE /api/v1/tasks/{id}` : supprimer une tâche (manager seulement)

---

## Pagination

Pour toutes les routes d'index (`GET`), vous pouvez ajouter `?per_page=10` pour paginer les résultats.. (pour être dynamique)

Exemple :

```http
GET /api/v1/users?per_page=15
```

---

## Commandes Git de base

```bash
git status          # Voir les modifications
git add .           # Ajouter tous les fichiers
git commit -m "message"    # Enregistrer les modifications
git push origin main        # Envoyer vers GitHub
```

---

## Remarques

* L'API utilise Sanctum pour gérer les tokens d'authentification.
* Le middleware `CheckManager` est utilisé pour restreindre certaines routes aux utilisateurs ayant le rôle `manager`.
* Les tâches sont liées aux utilisateurs créateurs et aux assignés via des relations many-to-many.

---

## Licence

Ce projet est open-source. Utilisation libre avec attribution et droits réservés.