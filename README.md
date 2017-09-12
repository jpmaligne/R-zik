# R-zik

## Routing (pour l'instant)

|        Nom        |         URL        |  Verbe |           Description             |
|:-----------------:|:------------------:|:------:|:---------------------------------:|
| get_users         |  /users            |  GET   |    List tous les users            |
| get_user          |  /users/{id}       |  GET   |    List un user                   |
| post_users        |  /users            |  POST  |    Créé un user                   |
| update_user       |  /users/{id}       |  PUT   |    Modifie un user                |
| patch_user        |  /users/{id}       | PATCH  |    Modifie un user                |
| remove_user       |  /users/{id}       | DELETE |    Delete un user                 |
| post_auth_tokens  |  /auth-tokens      |  POST  |    Créé un token de connexion     |
| remove_auth_token |  /auth-tokens/{id} | DELETE |    Delete un token de connexion   |
| get_auth_tokens   |  /auth-tokens      |  GET   |    List tous les tokens           |

## Commandes Git

### Installation

`git clone https://github.com/jpmaligne/R-zik.git`

`npm install`

`composer install`

Verifier à tous moment l'état de votre git local : `git status`

### Gestion des branch

De base on se trouve sur la branch Master -> pour checker toutes les branches : `git branch`

Nouvelle fonctionnalité = nouvelle branche :

`git checkout -b ma_branch`

Pour revenir au master : `git checkout master` pour retourner sur ma_branch : `git checkout ma_branch`

__Pensez à toujours pull sur le master avant de créer une branche afin d'avoir votre branch à jour avec les dernieres modifications.__

### Ajout de modifications

Une fois les modifications et ajouts de fichiers :

`git add <fichier_simple>` ou `git add .` pour ajouter toutes les modifications

`git commit -m "<message de description>"`

Puis on pull le master :

`git checkout master` puis `git pull`

Enfin, retournez sur votre branch et poussez sur master :

`git checkout ma_branch`

`git push origin ma_branch`

### Annuler les modif sur un fichier

Pour annuler toutes les mofifications sur un fichier réalisées depuis le dernier pull :

`git checkout -- <nom_du_fichier>`


### Commentaires

Il est recommandé de taffer sur une branch par personne.

En suivant le schema suivant on évitera les conflits :


    Pull le master
    Creer une nouvelle branch
    Add les fichiers
    commit -m
    Aller sur master et le Pull (encore)
    Retourner sur la branch de travail et push sur master


Force & Honneur
May the force be with you