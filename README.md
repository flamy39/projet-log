# Procédure d'installation 
Afin que le projet fonctionne correctement, vous devez exécuter les étapes suivantes

## Installer les dépendances du projet (le dossier vendor n'est pas versionné)
composer install

## Générer les clés publique et privé pour JWT
symfony console lexik:jwt:generate-keypair

## Inserer un nouvel utitisateur dans la table user
#### Générer un mot de passe (ici "secret")
symfony console security:hash-password secret

Exemple de hash généré : $2y$13$2Q1lpajCXwwj/8KMeY9OS.mL7QnY3xCrg8pzHZUf9JNSh3BP413T.
#### Inserer l'utilisateur 
symfony console doctrine:query:sql "insert into user(email,roles,password) values('jean@symfony.com','[]','$2y$13$2Q1lpajCXwwj/8KMeY9OS.mL7QnY3xCrg8pzHZUf9JNSh3BP413T.')

## Lancer le serveur
symfony serve -d

# Procédure de tests
Utilisation de postman




