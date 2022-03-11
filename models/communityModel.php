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

class communityModel extends dbConnection {
  public function __construct() {
    parent::__construct();
  }

  // @return un array asociativo con los datos de un comentario.
  public function get_comment(int $id) {
    $query = 'SELECT c.id, c.user_id, a.slug FROM comments AS c ' .
             'INNER JOIN articles AS a ON c.article_id = a.id ' .
             'WHERE c.id = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($id));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de un comentario');
    }
  }

  // Elimina un comentario.
  public function delete_comment(int $id) {
    $query = 'DELETE FROM comments WHERE id = ?';

    try {
      $this -> pdo -> prepare($query) -> execute(array($id));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para eliminar un comentario');
    }
  }

  // @return un array asociativo con los datos de un artículo.
  public function get_article(string $slug) {
    $query = 'SELECT id, slug FROM articles WHERE slug = ? AND authorized = TRUE LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($slug));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de un artículo');
    }
  }

  // @return un array asociativo con los datos de like de un artículo.
  public function get_like(int $user_id, int $article_id) {
    $query = 'SELECT id FROM favorites WHERE user_id = ? AND article_id = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($user_id, $article_id));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de like de un artículo');
    }
  }

  // Registra el like de un artículo.
  public function save_like(int $user_id, int $article_id) {
    $query = 'INSERT INTO favorites(user_id, article_id) VALUES(?, ?)';

    try {
      $this -> pdo -> prepare($query) -> execute(array($user_id, $article_id));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar el like de un artículo');
    }
  }

  // Elimina el like de un artículo.
  public function delete_like(int $id) {
    $query = 'DELETE FROM favorites WHERE id = ?';

    try {
      $this -> pdo -> prepare($query) -> execute(array($id));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para eliminar el like de un artículo');
    }
  }

  // Obtiene los datos de suscripción de un e-mail.
  public function get_suscription(string $email) {
    $query = 'SELECT * FROM suscriptions WHERE email = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($email));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de una suscripción');
    }
  }

  // Registra una suscripción.
  public function save_suscription(string $email, string $hash) {
    $query = 'INSERT INTO suscriptions(email, hash) VALUES(?, ?)';

    try {
      $this -> pdo -> prepare($query) -> execute(array($email, $hash));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar una suscripción');
    }
  }

  // Elimina una suscripción.
  public function delete_suscription(int $id) {
    $query = 'DELETE FROM suscriptions WHERE id = ?';

    try {
      $this -> pdo -> prepare($query) -> execute(array($id));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para eliminar una suscripción');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
