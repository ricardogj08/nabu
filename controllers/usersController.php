<?php

defined('NABU') || exit;

require_once 'models/usersModel.php';

class usersController {
    static public function login() {
        require_once 'views/pages/login.php';
    }

    static public function logout() {
        //
    }

    static public function signup() {
        require_once 'views/pages/signup.php';
    }
}
