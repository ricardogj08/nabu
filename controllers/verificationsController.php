<?php

defined('NABU') || exit();

require_once 'models/verificationsModel.php';

// Activa la cuenta de un usuario desde una URL
// de verificación de dirección de e-mail.
class verificationsController {
    public static function verifications() {
        if (empty($_GET['user']) || empty($_GET['key'])) {
            utils::redirect(NABU_ROUTES['home']);
        }

        $verificationsModel = new verificationsModel();

        // Busca los datos de verificación de e-mail del usuario.
        $user = $verificationsModel -> get($_GET['user']);

        if (empty($user['hash']) || empty($user['hash_expiration']) ||
            !empty($user['activated'])) {
            utils::redirect(NABU_ROUTES['home']);
        }

        // Reconstruye el hash con la llave de verificación de la URL.
        $hash = hash_hmac('sha256', $user['email'], $_GET['key']);

        // Valida la autentificación del hash.
        if (!hash_equals($user['hash'], $hash)) {
            utils::redirect(NABU_ROUTES['home']);
        }

        // Valida si el hash de verificación de e-mail está expirado
        // y elimina el usuario.
        if (time() > $user['hash_expiration']) {
            unset($verificationsModel);

            require_once 'models/usersModel.php';

            $usersModel = new usersModel();
            $usersModel -> delete($user['id']);

            messages::add('Tu cuenta ha expirado, por favor vuelva a registrarse');

            utils::redirect(NABU_ROUTES['signup']);
        }

        // Activa la cuenta del usuario y crea su perfil.
        $verificationsModel -> activate($user['id']);

        messages::add('Tu dirección de correo electrónico se ha verificado correctamente');

        utils::redirect(NABU_ROUTES['login']);
    }
}
