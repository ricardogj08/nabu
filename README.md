# Nabu

Un sistema gestor de contenido (CMS) para artículos en `Markdown`, escrito en `HTML`, `CSS`, `JavaScript` y `PHP`.

## Archivo de configuración de la base de datos

Por defecto, `Nabu` escanea el archivo `database-config.json` dentro de la carpeta raíz del proyecto.

Estructura del archivo de configuración:

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

## Licencia

```text
Nabu - Un sistema gestor de contenido (CMS) para artículos en Markdown, escrito en HTML, CSS, JavaScript y PHP.

Copyright (C) 2021  Ricardo García Jiménez          <ricardogj08@riseup.net>,
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
