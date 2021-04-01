# Laravel

## Récupérer ce projet
Se mettre dans le dossier souhaité, puis utiliser cette commande :
```bash
git clone https://github.com/Kolphren/laravel_dwm14_lionnel .
```
Faire une copie du ```.env.example``` et la nommer ```.env```, puis :
```bash
composer install
php artisan migrate --seed
```


## Lien vers collection Postman

https://www.getpostman.com/collections/9ccec6fe67d55bbf06ae


### Documentation swagger

Commenter les lignes 26 et 32 du fichier api.php pour désactiver l'authentification et  tester avec la doc swagger.