# Instalación

Dentro del directorio principal, instalamos las dependencias del framework

```bash
composer install
```

Luego creamos una base da datos en MySQL, copiamos o renombramos el archivo
`env` a `.env` y configuramos la sección correspondiente a la base de datos
con los datos locales.

Migramos la base de datos y cargamos contenido de prueba con

```bash
php spark migrate
php spark db:seed DbSeeder
```

Finalmente corremos el servidor de prueba con

```bash
php spark serve
```

