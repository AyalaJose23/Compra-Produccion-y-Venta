🔌 Conexión a la Base de Datos
Este proyecto utiliza PHP y PostgreSQL dentro de un entorno local proporcionado por XAMPP.

🧩 Requisitos
Antes de ejecutar el sistema, asegurate de tener instalados y configurados los siguientes componentes:

✅ XAMPP (incluye Apache y PHP)

🐘 PostgreSQL (como motor de base de datos)

⚙️ Extensión pgsql habilitada en PHP (ver más abajo)

🌐 Navegador web

⚙️ Configuración de la Conexión
El archivo conexion.php contiene la clase conexion que maneja la conexión a la base de datos.

📌 Parámetros de Conexión
php
host     = 'localhost';      // Dirección del servidor PostgreSQL
port     = '5432';           // Puerto del servidor PostgreSQL
dbname   = 'cpv';        // Nombre de la base de datos
user     = 'postgres';       // Usuario de PostgreSQL
password = '123';            // Contraseña del usuario
Puedes modificar estos valores según tu entorno local o de producción.

🛠️ Habilitar Extensión pgsql en XAMPP
Para que PHP se conecte correctamente a PostgreSQL, necesitás habilitar la extensión pgsql en tu instalación de XAMPP:

Abre el archivo php.ini (ubicado en xampp/php/php.ini).

Buscá estas líneas y quitá el ; (punto y coma) al inicio si lo tienen:

ini
;extension=pgsql
;extension=pdo_pgsql
➡️ Deberían quedar así:

ini
extension=pgsql
extension=pdo_pgsql

Guardá el archivo y reiniciá Apache desde el panel de control de XAMPP.

