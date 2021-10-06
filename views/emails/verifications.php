<?php

defined('NABU') || exit();

return '<p>¡Hola ' . $username . '!, espero que estés bien. Para completar tu registro en ' . NABU_DEFAULT['website-name'] .
', por favor confirma tu dirección de correo electrónico con el siguiente enlace:</p>' .
'<div><a href="' . $url . '">Confirmar mi dirección de e-mail</a></div>' .
'<p>Puedes ignorar este mensaje si no realizaste esta solicitud.</p>';
