<?php

defined('NABU') || exit;

class csrf {
    private const size       = 32;
    private const hash       = 'sha256';
    private const secret     = 'rWO!KJ9&*Wk@';
    private const expiration = 4; // Horas.

    // Elimina la variable de sesión.
    private static function destroy() {
        unset($_SESSION['csrf']);
    }

    private static function errors(string $error) {
        self::destroy();
        messages::errors($error, 400);
    }

    // Genera un token en base a bytes aleatorios.
    public static function generate() {
        $key = bin2hex(random_bytes(self::size));

        $_SESSION['csrf'] = array(
            'token'      => hash_hmac(self::hash, self::secret, $key),
            'expiration' => time() + (60 * 60 * self::expiration)
        );

        return $_SESSION['csrf']['token'];
    }

    // Valida si un token no está expirado y es igual al generado.
    public static function validate($token2) {
        if (empty($_SESSION['csrf']) || empty($token2)) {
            self::errors('Token inválido');
        }

        if (time() > $_SESSION['csrf']['expiration']) {
            self::errors('El formulario ha expirado, por favor recargue la página web');
        }

        if (!hash_equals($_SESSION['csrf']['token'], $token2)) {
            self::errors('Los tokens no coinciden');
        }

        self::destroy();
    }
}
