# Gestion du personnel
#GIT
-> git clone https://github.com/mdioumassi/Personnel.git
#Composer
-> dossier du projet/ composer install

#Database
taper la commande: composer dump-env prod
pour créer un env de production: .env.local.php
 -> Lancer la migration:
-> php bin/console doctrine:migration:migrate

