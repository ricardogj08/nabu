<?php

defined('NABU') || exit();

require_once 'models/adminModel.php';

class adminController {
    static public function admin() {
        if (empty($_GET['section'])) {
            self::dashboard();
        }
        else {
            switch ($_GET['section']) {
                case 'authorize':
                    self::authorize_article();
                    break;
                case 'delete':
                    self::delete_article();
                    break;
                case 'edit':
                    self::edit_article();
                    break;
                case 'published':
                    self::published_articles();
                    break;
                case 'users':
                    self::users();
                    break;
                default:
                    utils::redirect(NABU_ROUTES['admin']);
            }
        }
    }

    static private function dashboard() {
        require_once 'views/admin/dashboard.php';
    }

    static private function authorize_article() {
        require_once 'views/pages/confirm-password.php';
    }

    static private function delete_article() {
        require_once 'views/pages/confirm-password.php';
    }

    static private function edit_article() {
        require_once 'views/admin/edit-article.php';
    }

    static private function published_articles() {
        require_once 'views/admin/published-articles.php';
    }

    static private function users() {
        require_once 'views/admin/users.php';
    }
}
