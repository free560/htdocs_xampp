# Architecture — Deux applications PHP/MySQL communiquant via une API

## Vue d'ensemble

```
projet/
├── app1_universite/     → Application 1 (port/dossier web n°1)
│   ├── config/db.php    → connexion directe à univ_gestion (pour formations/inscriptions)
│   ├── api_client.php   → fonction callApi() pour parler à l'API
│   ├── index.php / formations.php / etudiants.php / inscriptions.php / voir_stages.php
│   └── sql/schema.sql   → base univ_gestion (etudiants, formations, inscriptions)
│
├── app2_stages/         → Application 2 (port/dossier web n°2)
│   ├── config/db.php    → connexion directe à stages_gestion
│   ├── api_client.php
│   ├── index.php / entreprises.php / encadreurs.php / stages.php / evaluations.php
│   └── sql/schema.sql   → base stages_gestion (entreprises, stages, encadreurs, evaluations)
│
└── api/                 → L'API : le pont entre les deux applications
    ├── config_db.php    → connexion aux DEUX bases + helpers JSON
    ├── etudiants_api.php → GET (lire les étudiants) / POST (créer un étudiant)
    └── stages_api.php    → GET (lire les stages) / POST (créer un stage)
```

## Comment ça communique (le point important de l'exercice)

1. **App1 → API → MySQL** : le formulaire `etudiants.php` de l'application 1 n'écrit **jamais** directement
   dans la base. Il envoie les données en JSON, en HTTP POST, vers `api/etudiants_api.php`, qui lui
   fait l'insertion dans `univ_gestion.etudiants`.
2. **App2 → API (GET)** : quand on crée un stage dans `app2_stages/stages.php`, le formulaire a besoin
   de la liste des étudiants. Il ne va pas la chercher dans sa propre base (elle n'y est pas) — il
   appelle `api/etudiants_api.php` en GET, qui retourne le JSON des étudiants issus de l'autre base.
3. **App2 → API → MySQL** : la création d'un stage passe aussi par l'API (`api/stages_api.php` en POST),
   qui écrit dans `stages_gestion.stages`.
4. **App1 → API (GET) → données de App2** : dans `app1_universite/voir_stages.php`, l'application 1
   appelle `api/stages_api.php?matricule=...` pour afficher les stages d'un étudiant, alors que
   cette donnée vit uniquement dans la base de l'application 2.

C'est exactement le schéma demandé :
> App1 envoie à l'API → l'API écrit dans MySQL → App2 demande les infos étudiants à l'API →
> App1 peut aussi récupérer les infos venant de App2.

## Installation (XAMPP / WAMP / Laragon)

1. Copier le dossier `projet/` dans `htdocs/` (XAMPP) ou `www/` (WAMP), en le renommant si besoin.
2. Dans phpMyAdmin, importer :
   - `app1_universite/sql/schema.sql` (crée la base `univ_gestion`)
   - `app2_stages/sql/schema.sql` (crée la base `stages_gestion`)
3. Vérifier les identifiants MySQL dans les 3 fichiers `config/db.php` / `config_db.php`
   (par défaut : `root` sans mot de passe, comme sur un XAMPP classique).
4. **Important** : `api/` doit être accessible via une URL du type `http://localhost/api/...`
   — c'est pourquoi `API_BASE_URL` vaut `http://localhost/projet/api` ou `http://localhost/api`
   selon l'endroit où vous placez le dossier `projet`. **Adaptez cette constante dans
   `app1_universite/api_client.php` ET `app2_stages/api_client.php`** si votre chemin diffère.
5. Ouvrir :
   - `http://localhost/projet/app1_universite/` (Application 1)
   - `http://localhost/projet/app2_stages/` (Application 2)

## Pourquoi certaines tables passent par l'API et d'autres non

- `etudiants` (App1) et `stages` (App2) sont les données que **l'autre application a besoin de
  lire ou d'influencer** → elles passent par l'API.
- `formations`, `inscriptions` (App1) et `entreprises`, `encadreurs`, `evaluations` (App2) sont des
  données **purement internes** à chaque application → formulaires classiques en accès direct à
  leur propre base (pas besoin de passer par l'API, ce serait une complexité inutile).

Cette séparation est un vrai choix d'architecture à expliquer si on vous le demande à l'oral :
on n'expose via l'API que ce qui doit réellement être partagé entre les deux systèmes.
