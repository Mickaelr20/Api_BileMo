[![LinkedIn][linkedin-shield]][linkedin-url]
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/279d1b95605240d8b018b1ab1345cbcc)](https://www.codacy.com/gh/Mickaelr20/Api_BileMo/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Mickaelr20/Api_BileMo&amp;utm_campaign=Badge_Grade)

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Sommaire</summary>
  <ol>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#demarrage">Démarrage</a></li>
    <li><a href="#documentation">Documentation</a></li>
    <li><a href="#license">Licence</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

<!-- INSTALLATION -->

## Installation

Clonez ce repo sur votre machine avec la commande suivante:
```sh
git clone https://github.com/Mickaelr20/Api_BileMo.git
```

### Dépendances composer :

Pour installer les dépendances composer, exécutez la commande suivante dans le répertoire du projet :
```sh
composer install
```

### Fichier de configuration: .env.local

L'application nécéssite un accès a une base de données.

Créez le fichier .env.local à la racine du projet dans lequel vous ajouterez une ligne "DATABASE_URL" comme ci - dessous:

```sh
# L'url vers la base de données
DATABASE_URL="mysql://<db_user>:<db_password>@<bd_host>/<db_name>"
```

## Démarrage :

Une fois toutes les étapes précédentes effectuées, vous pouvez executer les commandes suivantes depuis le repertoire d'installation du projet:

```sh
# Créer la base de données:
php bin/console doctrine:database:create

# Créer les tables:
php bin/console doctrine:migration:migrate

# Créer le jeu de données initiale:
php bin/console doctrine:fixtures:load
```

<!-- DOCUMENTATION -->

## Documentation

La documentation se trouve à l'url <a href="https://mickaelr20.github.io/Api_BileMo/">https://mickaelr20.github.io/Api_BileMo/</a>

Ou en local, une fois le projet lancé, accédez à la documentation via: "/api/doc"

<!-- LICENSE -->

## License

Distribué sous GNU GENERAL PUBLIC LICENSE V2. Voir https://github.com/Mickaelr20/Api_BileMo//blob/main/license pour plus d'informations.

<!-- CONTACT -->

## Contact

Rivière Mickael - mickaelr20@gmail.com - [Mon LinkedIn][linkedin-url]

Lien du projet : [https://github.com/Mickaelr20/Api_BileMo](https://github.com/Mickaelr20/Api_BileMo/)

<!-- MARKDOWN LINKS & IMAGES -->
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/mickael-riviere-s/

