<?php

defined('NABU') || exit();

require_once 'models/searchModel.php';

class searchController {
    static public function search() {
        require_once 'views/pages/search.php';
    }
}
