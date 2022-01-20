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

// Valida formularios contra ataques CSRF.
class csrf {
  private const size       = 32;
  private const hash       = 'sha256';
  private const secret     = 'YyL$62x*qXtl';
  private const expiration = 4; // Horas.

  // Genera un token en base a bytes aleatorios.
  public static function generate() {
    $key = bin2hex(random_bytes(self::size));

    $_SESSION['csrf'] = array(
      'token'      => hash_hmac(self::hash, self::secret, $key),
      'expiration' => time() + (60 * 60 * self::expiration)
    );

    return $_SESSION['csrf']['token'];
  }

  // Elimina la variable de sesión.
  private static function destroy() {
    unset($_SESSION['csrf']);
  }

  private static function errors(string $error) {
    self::destroy();
    messages::errors($error, 400);
  }

  // Valida si un token no está expirado y es igual al generado.
  public static function validate($token2) {
    if (empty($_SESSION['csrf']) || empty($token2))
      self::errors('El token del formulario no es válido');

    if (time() > $_SESSION['csrf']['expiration'])
      self::errors('El formulario ha expirado');

    if (!hash_equals($_SESSION['csrf']['token'], $token2))
      self::errors('Los tokens del formulario no coinciden');

    self::destroy();
  }
}
