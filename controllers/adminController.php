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
        //
    }

    static private function authorize_article() {
        //
    }

    static private function delete_article() {
        //
    }

    static private function edit_article() {
        //
    }

    static private function published_articles() {
        //
    }
}
