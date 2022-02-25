# Nabu

Un sistema gestor de contenido (CMS) de artículos en `Markdown` para la [Universidad de Guanajuato](https://www.ugto.mx/) escrito en `HTML`, `CSS`, `JavaScript` y `PHP`.

## Dependencias

* [PHP >= 7.0.0](https://www.php.net/)
* [MariaDB >= 10.5.10](https://mariadb.org/)
* Habilita y modifica los siguientes parámetros en el archivo de configuración `php.ini`:
    * `extension=openssl` (Windows).
    * `extension=pdo_mysql`
    * `upload_max_filesize = 2M`

## Estructura del proyecto

```text
nabu/
├── assets
│   ├── icons
│   ├── images
│   ├── scripts
│   └── styles
├── config
├── controllers
├── core
├── db
├── libs
├── models
├── storage
│   ├── avatars
│   ├── backgrounds
│   ├── covers
└── views
    ├── admin
    ├── components
    ├── emails
    └── pages
```

* `assets` - Contiene elementos estáticos.
    * `icons` - Favicon, paquetes de iconos, etc.
    * `images` - Imágenes de banners, logos, etc.
    * `scripts` - Contiene scripts de `JavaScript`.
    * `styles` - Contiene hojas de estilo `CSS`.
* `config` - Contiene archivos de configuración de la base de datos y del cliente de correo electrónico.
* `controllers` - Contiene la lógica de negocio (lo que debe hacer el programa).
* `core` - Contiene herramientas propias de `Nabu`, gestión de mensajes, configuración y sistema de rutas del sitio web.
* `db` - Contiene el script `SQL` y realiza la conexión con la base de datos.
* `libs` - Contiene bibliotecas propias de `Nabu` o de terceros.
* `models` - Representan los datos de la aplicación y el acceso a ellos.
* `storage` - Almacena portadas de los artículos, fotos y fondos de los perfiles.
* `views` - Contiene plantillas que generan páginas web `HTML`. Muestran la interpretación de los datos al cliente.
    * `admin` - Contiene plantillas que construyen el panel de administración del sitio web.
    * `components` - Contiene elementos de una página web (`header`, `navbar`, `footer`, etc.).
    * `emails` - Contiene plantillas de mensajes de correo electrónico.
    * `pages` - Contiene plantillas que construyen el sitio web (página principal, inicio de sesión, registro de usuarios, vista de artículos, etc.).

## Ejecuta Nabu en un servidor local

```shell
$ cd nabu
$ mkdir -p config storage/avatars storage/backgrounds storage/covers
$ php -S localhost:8000
```

Ejecuta el script SQL `db/db.sql` en `MariaDB`, para crear la base de datos de `Nabu`.

Enlace del sitio web:

* <http://localhost:8000/>

```text
* Usuario: root
* Contraseña: 123456
```

## Configuración de la base de datos

Por defecto, `Nabu` escanea desde la raíz de la carpeta del programa el archivo de configuración `config/db.json`:

```json
{
	"dbms":     "mysql",
	"host":     "localhost",
	"database": "nabu",
	"user":     "root",
	"password": "root",
	"charset":  "utf8mb4"
}
```

## Configuración del cliente de correo electrónico

Por defecto, `Nabu` escanea desde la raíz de la carpeta del programa el archivo de configuración `config/email.json`:

```json
{
	"smtp":     "smtp.example.com",
	"port":     587,
	"address":  "foo@example.com",
	"password": "xxxxx"
}
```

## Modifica el correo electrónico del usuario root

```sql
> USE nabu;
> UPDATE users SET email = 'root@example.com' WHERE id = 1;
```

## Licencia

```text
Nabu - Un sistema gestor de contenido (CMS) de artículos en Markdown para
       la Universidad de Guanajuato escrito en HTML, CSS, JavaScript y PHP.

Copyright (C) 2021-2022 - Ricardo García Jiménez          <ricardogj08@riseup.net>,
                          Juan José Ramírez López         <juan.ramirez.j99@gmail.com>,
                          Francisco Solís Martínez        <franciscosolism08@gmail.com>,
                          Fernando Andrés Chávez Gavaldón <fernandochg26@gmail.com>

Este programa es software libre: puedes redistribuirlo y/o modificarlo
bajo los términos de la Licencia Pública General de GNU Affero publicada por
la Free Software Foundation, ya sea la versión 3 de la Licencia, o
(a su elección) cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea de utilidad,
pero SIN NINGUNA GARANTÍA; incluso sin la garantía implícita de
COMERCIABILIDAD o APTITUD PARA UN PROPÓSITO PARTICULAR. Consulte la
Licencia Pública General de GNU Affero para obtener más detalles.

Debería haber recibido una copia de la Licencia Pública General de GNU Affero
junto con este programa. De lo contrario, consulte <https://www.gnu.org/licenses/>.
```
