<?php

defined('NABU') || exit();

// Realiza la conexión con la base de datos.
class connection {
    protected $pdo;

    public function __construct() {
        if (!file_exists(NABU_DIRECTORY['database'])) {
            exit('Create a database config file.');
        }

        // Carga el archivo de configuración de la base de datos.
        $config = file_get_contents(NABU_DIRECTORY['database']);

        if ($config === false) {
            exit('The database config file is invalid.');
        }

        $config = json_decode($config, true);

        $keys = array('dbms', 'host', 'database', 'user', 'password', 'charset');

        foreach ($keys as $key) {
            if (empty($config[$key])) {
                exit('Set "' . $key . '" in the database config file.');
            }
        }

        // Parámetros de configuración de la conexión de la base de datos.
        $options = array(
            // Mantiene el nombre de las columnas como en la base de datos.
            PDO::ATTR_CASE               => PDO::CASE_NATURAL,
            // Define el manejador de errores de 'PDO' por excepciones, utiliza el objeto 'PDOException'.
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // Deshabilita las consultas preparadas de 'PDO' y utiliza el sistema nativo del SGBD.
            PDO::ATTR_EMULATE_PREPARES   => false,
            // Define por defecto los resultados de las consultas como arrays asociativos.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        // Origen de la base de datos.
        $dsn = $config['dbms'] . ':host=' . $config['host'] . ';dbname=' . $config['database'];

        try {
            // Configuración y conexión de la base de datos.
            $this -> pdo = new PDO($dsn, $config['user'], $config['password'], $options);

            // Define la codificación de caracteres para el cliente del SGBD y los resultados de las consultas.
            $this -> pdo -> exec('SET CHARSET ' . $config['charset']);
        }
        catch (PDOException $e) {
            exit($e -> getMessage());
        }
    }

    protected function errors(string $exception, string $error) {
        // error_log($exception);

        messages::errors('¡Lo sentimos mucho! &#x1F61E;, ' . $error . ', por favor inténtelo más tarde', 500);
    }

    // @return el alias de un 'id de role'.
    protected function role_format($id) {
        $role = 'user';

        if ($id == 1) {
            $role = 'admin';
        }

        if ($id == 2) {
            $role = 'moderator';
        }

        return $role;
    }

    // Finaliza la conexión con la base de datos.
    public function __destruct() {
        $this -> pdo = null;
    }
}
