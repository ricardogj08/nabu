<?php

defined('NABU') || exit;

// Valida los campos de un formulario.
class validations {
    private $route;
    private $field;
    private $value;

    // Define la ruta de redirección para mostrar mensajes sobre campos inválidos.
    public function __construct(string $route) {
        $this -> route = $route;
    }

    // Muestra errores fatales.
    private function errors(string $error) {
        messages::errors($error, 400);
    }

    // Valida si la información de un archivo proviene
    // de la variable global '$_FILE'.
    private function is_file() {
        $file = $this -> value;
        return is_array($file) && !empty($file['tmp_name']);
    }

    // Elimina espacios sobrantes y de principio y fin de un string.
    private function trim_all() {
        return trim(preg_replace('/\s+/', ' ', $this -> value));
    }

    // Valida la longitud de un string.
    private function string_lenght(int $min, int $max) {
        $length = strlen($this -> value);

        if ($length < $min || $length > $max) {
            messages::add('El campo "' . $this -> field . '" no respeta los límites establecidos');
        }
    }

    // Valida si un string contiene espacios.
    private function is_space() {
        $str = $this -> value;

        if (preg_replace('/\s+/', '', $str) !== $str) {
            messages::add('El campo "' . $this -> field . '" contiene espacios');
        }
    }

    // Valida si una dirección de correo electrónico es de la Universidad de Guanajuato.
    private function is_email() {
        $email = $this -> value;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (!str_ends_with($email, '@ugto.mx')) {
                messages::add('Registrate con tu dirección de correo electrónico institucional de la Universidad de Guanajuato');
            }
        }
        else {
            messages::add('El campo "' . $this -> field . '" contiene una dirección de correo electrónico no válido');
        }
    }

    // Valida el tamaño y el formato de una imagen.
    private function is_image() {
        $size = $this -> value['size'];

        if ($size > NABU_DEFAULT['image-size']) {
            messages::add('Por favor elija una imagen de diferente peso');
        }

        $formats = explode(',', NABU_DEFAULT['image-formats']);

        foreach ($formats as $format) {
            if (trim($format) == $this -> value['type']) {
                $extension = $format;
            }
        }

        if (empty($extension)) {
            messages::add('Formato de imagen inválido');
        }
    }

    // Valida si dos datos son iguales.
    private function equal($foo) {
        if ($this -> value !== $foo) {
            messages::add('El campo "' . $this -> field . '" no coincide');
        }
    }

    // Valida y selecciona los campos de un formulario;
    // @return un array asociativo con los valores de los campos que son válidos.
    public function validate_form(array $form, array $options) {
        $data = array();

        foreach ($options as $option) {
            if (!is_array($option))
                $this -> errors('The validation options are not an array');

            if (empty($option[0]) || !is_string($option[0]))
                $this -> errors('Not found field name');

            $type = 'string';

            // Define el tipo de dato del campo (dafault: string).
            if (!empty($option['is_email'])) {
                $type = 'is_email';
            }
            elseif (!empty($option['is_image'])) {
                $type = 'is_image';
            }

            // Nombre del campo.
            $this -> field = $option[0];

            // Valida si un campo es obligatorio u opcional.
            if (empty($form[$this -> field])) {
                if (!empty($option['exists'])) {
                    messages::add('El campo "' . $this -> field . '" es obligatorio');
                }
                continue;
            }

            // Dato del campo.
            $this -> value = $form[$this -> field];

            // Valida si un campo es un archivo y si es obligatorio u opcional.
            if ($type == 'is_image') {
                if (!$this -> is_file()) {
                    if (!empty($option['exists'])) {
                        messages::add('El campo "' . $this -> field . '" require obligatoriamente de un archivo de imagen');
                    }
                    continue;
                }
            }

            // Realiza acciones en base a '$type'.
            if ($type == 'string' || $type == 'is_email') {
                // Selecciona el tipo de limpieza de espacios.
                if (!empty($option['trim_all'])) {
                    $this -> value = $this -> trim_all();
                }
                elseif (!empty($option['trim'])) {
                    $this -> value = trim($this -> value);
                }

                if (!empty($option['min_lenght']) && !empty($option['max_lenght'])) {
                    $this -> string_lenght($option['min_lenght'], $option['max_lenght']);
                }

                if (!empty($option['not_spaces'])) {
                    $this -> is_space();
                }
            }

            if ($type == 'is_email') {
                $this -> is_email();
            }

            if ($type == 'is_image') {
                $this -> is_image();
            }

            if (array_key_exists('equal', $option)) {
                $this -> equal($option['equal']);
            }

            $data[$this -> field] = $this -> value;
        }

        messages::exist($this -> route);

        return $data;
    }
}
