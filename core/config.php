<?php
/*
* Este archivo es parte de Nabu.
*
* Nabu es software libre: puedes redistribuirlo y/o modificarlo
* bajo los términos de la Licencia Pública General de GNU Affero publicada por
* la Free Software Foundation, ya sea la versión 3 de la Licencia, o
* (a su elección) cualquier versión posterior.
*
* Nabu se distribuye con la esperanza de que sea de utilidad,
* pero SIN NINGUNA GARANTÍA; incluso sin la garantía implícita de
* COMERCIABILIDAD o APTITUD PARA UN PROPÓSITO PARTICULAR. Consulte la
* Licencia Pública General de GNU Affero para obtener más detalles.
*
* Debería haber recibido una copia de la Licencia Pública General de GNU Affero
* junto con este programa. De lo contrario, consulte <https://www.gnu.org/licenses/>.
*/

defined('NABU') || exit();

define('NABU_URL', 'http://localhost:8000');

define('NABU_DIRECTORY', array(
    'avatars'             => NABU_URL . '/storage/avatars',
    'backgrounds'         => NABU_URL . '/storage/backgrounds',
    'covers'              => NABU_URL . '/storage/covers',
    'db'                  => 'config/db.json',
    'email'               => 'config/email.json',
    'icons'               => NABU_URL . '/assets/icons',
    'images'              => NABU_URL . '/assets/images',
    'storage-avatars'     => 'storage/avatars',
    'storage-backgrounds' => 'storage/backgrounds',
    'storage-covers'      => 'storage/covers',
    'scripts'             => NABU_URL . '/assets/scripts',
    'styles'              => NABU_URL . '/assets/styles',
));

define('NABU_DEFAULT', array(
    'website-name'  => 'Nabu',
    'article-size'  => 1048576 * 1, // 1 MB (en bytes).
    'avatar'        => NABU_URL . '/assets/images/avatar.svg',
    'background'    => NABU_URL . '/assets/images/background.svg',
    'cover'         => NABU_URL . '/assets/images/cover.svg',
    'description'   => 'Compartiendo conocimiento...',
    'image-formats' => 'image/gif, image/jpeg, image/png, image/svg+xml',
    'image-size'    => 1048576 * 2, // 2 MB (en bytes).
));

$routes = array();

// Genera la URL completa de todas las rutas.
foreach ($components as $alias => $component)
  $routes[$alias] = NABU_URL . '/index.php?view=' . $component['route'];

define('NABU_ROUTES', $routes);

unset($routes);

// Define la zona horario de todas las funciones de fecha/tiempo.
date_default_timezone_set('America/Mexico_City');

/*
// Establece el nivel de reporte de errores "todos los errores".
ini_set('error_reporting', E_ALL);

// Desactiva en pantalla todos los errores.
ini_set('display_errors', 'Off');

// Desactiva en pantalla todos los errores de inicio de ejecución de PHP.
ini_set('display_startup_errors', false);

// Desactiva el registro de mensajes repetidos sobre la última línea.
ini_set('ignore_repeated_errros', true);

// Habilita el registro de errores desde un archivo externo.
ini_set('log_errors', true);

// Define la ruta del archivo de registro de errores.
ini_set('error_log', 'logs/errors.log');
*/
