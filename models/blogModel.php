<?php

defined('NABU') || exit;

class blogModel extends connection {
    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
        $this -> pdo = null;
    }
}
