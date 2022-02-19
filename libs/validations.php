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

// Valida los campos de un formulario.
class validations {
  public $route;
  private $field;
  private $value;

  public function __construct(string $route) {
    $this -> route = $route;
  }

  // Muestra errores fatales.
  private function errors(string $error) {
    messages::errors($error, 500);
  }

  // Elimina espacios sobrantes y de principio y fin de un string.
  private function trim_all() {
    $this -> value = trim(preg_replace('/\s+/', ' ', $this -> value));
  }

  // Valida la longitud de un string.
  private function validate_length(int $min, int $max) {
    $length = strlen($this -> value);

    if ($length < $min || $length > $max)
      messages::add('El campo "' . $this -> field . '" no respeta los límites establecidos');
  }

  // Valida si un string contiene espacios.
  private function is_space() {
    $str = $this -> value;

    if (preg_replace('/\s+/', '', $str) !== $str)
      messages::add('El campo "' . $this -> field . '" contiene espacios');
  }

  // Valida si una dirección de correo electrónico pertenece a la Universidad de Guanajuato.
  private function is_email() {
    $email = $this -> value;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      if (!str_ends_with($email, '@ugto.mx'))
        messages::add('Regístrate con tu correo electrónico institucional de la Universidad de Guanajuato');
    }
    else
      messages::add('El campo "' . $this -> field . '" contiene una dirección de correo electrónico no válido');
  }

  // Valida si la información de un archivo proviene de la variable global $_FILE.
  private function is_file() {
    $file = $this -> value;
    return is_array($file) && !empty($file['tmp_name']);
  }

  // Valida si es una imagen.
  private function is_image() {
    $image = $this -> value;

    // Valida el tamaño de la imagen.
    if ($image['size'] > NABU_DEFAULT['image-size'])
      messages::add('Selecciona una imagen de menor peso');

    $formats = explode(',', NABU_DEFAULT['image-formats']);

    // Valida el formato de la imagen.
    foreach ($formats as $format)
      if (trim($format) == $image['type']) {
        $extension = $format;
        break;
      }

    if (empty($extension))
      messages::add('Formato de imagen no válido');
  }

  // Valida si dos datos son iguales.
  private function equal($foo) {
    if ($this -> value !== $foo)
      messages::add('El campo "' . $this -> field . '" no coincide');
  }

  // Valida y selecciona los campos de un formulario,
  // @return un array asociativo con los valores de los campos que son válidos.
  public function validate(array $form, array $params) {
    $data = array();

    foreach ($params as $param) {
      if (empty($param['field']))
        $this -> errors('Define el nombre del campo del formulario en la validación');

      // Nombre del campo.
      $this -> field = $param['field'];

      // Valida si el campo es obligatorio u opcional (default: obligatorio).
      if (empty($form[$this -> field])) {
        if (empty($param['optional']))
          messages::add('El campo "' . $this -> field . '" es obligatorio');

        continue;
      }

      // Define el tipo de dato del campo (default: string).
      $type = empty($param['type']) ? 'string' : $param['type'];

      // Dato del campo.
      $this -> value = $form[$this -> field];

      // Realiza acciones en base a "$type".
      if ($type == 'string' || $type == 'email') {
        // Selecciona el tipo de limpieza de espacios.
        if (isset($param['trim']))
          $this -> value = trim($this -> value);
        elseif (isset($param['trim_all']))
          $this -> trim_all();

        if (isset($param['min_length']) && isset($param['max_length']))
          $this -> validate_length($param['min_length'], $param['max_length']);

        if (isset($param['not_spaces']))
          $this -> is_space();

        if ($type == 'email')
          $this -> is_email();
      }
      elseif ($type == 'image') {
        // Valida si el campo para subir imágenes es obligatorio u opcional.
        if (!$this -> is_file()) {
          if (empty($param['optional']))
            messages::add('El campo "' . $this -> field . '" requiere obligatoriamente de un archivo de imagen');

          continue;
        }

        $this -> is_image();
      }

      if (isset($param['equal']))
        $this -> equal($param['equal']);

      $data[$this -> field] = $this -> value;
    }

    messages::check($this -> route);

    return $data;
  }
}
