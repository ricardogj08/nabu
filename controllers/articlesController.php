<?php

defined('NABU') || exit();

require_once 'models/articlesModel.php';

class articlesController {
    static public function all_articles() {
        require_once 'views/pages/all-articles.php';
    }

    static public function article() {
        require_once 'views/pages/article.php';
    }

    static public function category() {
        require_once 'views/pages/category.php';
    }

    static public function post_article() {
        require_once 'views/pages/post-article.php';
    }

    static public function sent_articles() {
        require_once 'views/pages/sent-articles.php';
    }
}
