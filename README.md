# Nabu

Un sistema gestor de contenido (CMS) de artículos en `Markdown` para la [Universidad de Guanajuato](https://www.ugto.mx/) escrito en `HTML`, `CSS`, `JavaScript` y `PHP`.

## Dependencias

## Estructura del proyecto

## Configuración de la base de datos

Por defecto, `Nabu` escanea desde la raíz de la carpeta del programa, el archivo de configuración `config/db.json`

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

Por defecto, `Nabu` escanea desde la raíz de la carpeta del programa, el archivo de configuración `config/email.json`

```json
{
	"smtp":     "smtp.example.com",
	"port":     587,
	"address":  "foo@example.com",
	"password": "xxxxx"
}
```

## Licencia

```text
Nabu - Un sistema gestor de contenido (CMS) de artículos en Markdown para
       la Universidad de Guanajuato escrito en HTML, CSS, JavaScript y PHP.

Copyright (C) 2021 - Ricardo García Jiménez          <ricardogj08@riseup.net>,
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
