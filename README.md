# student-management-in-php

Un miniprojet de gestion des étudiants écrit en php

## Mise en place

Renommer le fichier .env.example en .env et modifier son contenu pour utiliser le service mariadb avec docker :

```env
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=yourdb
MYSQL_USER=user
MYSQL_PASSWORD=yourpassword
```
## Lancer le programme

Vous pouvez lancer le serveur web avec :

```bash
docker compose up -d 
docker compose up -d web #Pour démarrer le serveur web uniquement
docker compose up -d db #Pour démarrer le serveur mariadb
```

Si vous utiliser **nix package manager**, vous pouver utiliser les alias défini dans **shell.nix** :
```nix
...
(writeShellScriptBin "apache" "docker compose up -d web")
(writeShellScriptBin "mariadb" "docker compose up -d db")
(writeShellScriptBin "dodo" "docker compose down")
...
```
