<?php

defined('NABU') || exit;

require_once 'models/profilesModel.php';

class profilesController {
    static public function profile() {
        if (empty($_GET['page'])) {
            self::view();
        }
        else {
            switch ($_GET['page']) {
                case 'delete':
                    self::delete_profile();
                    break;
                case 'edit':
                    self::edit_profile();
                    break;
                default:
                    utils::redirect(NABU_ROUTES['home']);
            }
        }
    }

    static private function view() {
        //
    }

    static private function delete_profile() {
        //
    }

    static private function edit_profile() {
        //
    }
}
