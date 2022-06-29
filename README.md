<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="500"></a></p>



# API Rest de Item en Laravel con TDD

## Instalación

1. Clonar el repositorio en el directorio de tu eleccion
```
git clone https://github.com/andresavilasith/api-laravel-item-backend.git
```
2. Ejecutar composer  
```
composer update
```
3. Cambiar el nombre del archivo **.env.example** _(Si esta como **env.example**)_ a **.env**

4. Generar una nueva llave de laravel con el comando:
```
php artisan key:generate
```

5. Generar la migracion y carga de registros
```
php artisan migrate --seed
``````
6. Ejecutar el proyecto
```
php artisan serve
``````
7. Ejecución de tests - TDD
```
php artisan test
``````

## Peticiones de Item

|  Petición  |      URL      |  Descripción |
|----------|:-------------:|------:|
|   GET     |  api/item | Listado de todos los items registrados  |
|   POST    |  api/item | Guardar un nuevo item |
|   GET     |  api/item/{item} | Obtener un item de acuerdo a su id |
|   PUT     |  api/item/{item} | Actualizar un item de acuerdo a su id |
|   DELETE     |  api/item/{item} | Eliminar un item de acuerdo a su id |