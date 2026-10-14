# Registro de equipos

Es la aplicación que hice para el práctico final de Sistemas Operativos. Sirve para anotar los equipos de un centro de cómputos: se pueden agregar, ver en una lista, modificar y eliminar. Está hecha en PHP con MariaDB y corre en Apache, sin Docker. Se abre en http://miproyecto.com.

Qué hay en la carpeta:

- index.php: la página principal, con el formulario y la lista de equipos
- editar.php: para modificar un equipo
- eliminar.php: para borrar un equipo
- conexion.php: la conexión a la base de datos
- config.example.php: un ejemplo del archivo con el usuario y la contraseña de la base
- database.sql: crea la base de datos y la tabla
- estilos.css: los colores y el diseño

Para instalarla en el servidor:

```
git clone https://github.com/BelenRodF18/miproyecto.git /var/www/miproyecto
sudo mysql < /var/www/miproyecto/database.sql
cp config.example.php config.php
```

Después hay que abrir config.php y poner el usuario y la contraseña de la base. Ese archivo no está en GitHub a propósito, para no publicar contraseñas.
