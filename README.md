
## Cómo instalar el programa

Para instalar el programa, sigue estos pasos:
1. Clona este repositorio en tu máquina local.
2. Abre la carpeta del proyecto en tu terminal.
3. Ejecuta `composer install` para instalar las dependencias.
4. Para la conexion a la base de datos en el archivo .env se dejo de esta forma
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=dbcapi
    DB_USERNAME=root
    DB_PASSWORD=
5. Genera la llave de aplicacion con el siguente comando `php artisan key:generate`
6. Ejecuta el seeder para poblar la base de datos `php artisan db:seed`

## Base de datos

La base de datos se encuentra en la carpeta `schema_db`. Puedes encontrar más información sobre la estructura de la base de datos en ese directorio.

## Seeder

El seeder para generar contactos se llama `contactosSeeder`. Puedes ejecutar este seeder varias veces para generar datos adicionales en tu base de datos.
