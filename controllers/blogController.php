<?php

defined('NABU') || exit;

require_once 'models/blogModel.php';

class blogController {
    static public function errors() {
        require_once 'views/pages/errors.php';
    }

    static public function home() {
        require_once 'views/pages/home.php';
    }
}
