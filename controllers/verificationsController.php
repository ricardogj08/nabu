<?php

defined('NABU') || exit();

require_once 'models/verificationsModel.php';

class verificationsController {
    public static function verifications() {
        if (empty($_GET['user']) || empty($_GET['key'])) {
            utils::redirect(NABU_ROUTES['home']);
        }

        $verificationsModel = new verificationsModel();

        // Busca los datos de verificación del usuario.
        $user = $verificationsModel -> get($_GET['user']);

        if (empty($user['hash']) || empty($user['hash_expiration'])) {
            utils::redirect(NABU_ROUTES['home']);
        }
    }
}
