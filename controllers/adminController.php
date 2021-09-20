<?php

defined('NABU') || exit;

require_once 'models/adminModel.php';

class adminController {
    static public function admin() {
        if (empty($_GET['page'])) {
            self::dashboard();
        }
        else {
            switch ($_GET['page']) {
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
        //
    }

    static private function edit_article() {
        require_once 'views/admin/edit-article.php';
    }

    static private function published_articles() {
        require_once 'views/admin/published-articles.php';
    }
}
