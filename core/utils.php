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

// Colección de herramientas propias para Nabu.
class utils {
  // Redirecciona a una ruta y termina la ejecución de todos los scripts de PHP.
  static public function redirect(string $route) {
    header('Location: ' . $route);
    exit();
  }

  // Redirecciona a una ruta si existe una sesión de usuario.
  static public function session_exists(string $route) {
    if (isset($_SESSION['user']))
      self::redirect($route);
  }

  // @return un string escapado para HTML.
  static public function escape(string $str) {
    return htmlentities($str, ENT_COMPAT | ENT_HTML5, 'UTF-8');
  }

  // @return la fecha actual.
  static public function current_date() {
    return date('Y-m-d H:i:s');
  }

  // Redirecciona a una ruta si no existe una sesión de usuario.
  static public function check_session(string $route) {
    if (empty($_SESSION['user']))
      self::redirect($route);
  }

  // Genera la URL de un artículo.
  public static function url_slug(string $title) {
    return date('Ymd') . '-' . preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($title));
  }

  // @return la URL completa de una imagen.
  public static function url_image(string $category, $filename) {
    $url = NABU_DEFAULT[$category];

    if (!empty($filename))
      if (file_exists(NABU_DIRECTORY['storage-' . $category . 's'] . '/' . $filename))
        $url = NABU_DIRECTORY[$category . 's'] . '/' . $filename;

    return $url;
  }

  // @return el nombre de una imagen y reemplaza una imagen por otra.
  public static function update_image(string $model, string $category, $original, array $replacement) {
    $extension = explode('/', $replacement['type'])[1];

    if ($extension == 'svg+xml')
      $extension = 'svg';

    require_once 'models/' . $model . '.php';

    $Model = new $model();

    // Valida si el nombre de la imagen es único.
    do
      $filename = bin2hex(random_bytes(32)) . '.' . $extension;
    while(!empty($Model -> find_image($category, $filename)));

    unset($Model);

    $path = NABU_DIRECTORY['storage-' . $category . 's'] . '/';

    $destination = $path . $filename;

    // Mueve la imagen subida a la carpeta de almacenamiento de fotos de perfil.
    if (move_uploaded_file($replacement['tmp_name'], $destination)) {
      // Elimina la imagen anterior.
      if (!empty($original)) {
        $origin = $path . $original;

        if (file_exists($origin))
          unlink($origin);
      }

      return $filename;
    }

    return false;
  }
}
