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

return '<p>¡Hola ' . $username . '!, espero que estés bien. Para completar tu registro en ' . NABU_DEFAULT['website-name'] .
', por favor confirma tu dirección de correo electrónico con el siguiente enlace:</p>' .
'<div><a href="' . $url . '">Confirmar mi dirección de e-mail</a></div>' .
'<p>Puedes ignorar este mensaje si no realizaste esta solicitud.</p>';
