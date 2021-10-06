<?php

defined('NABU') || exit();

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
        require_once 'views/pages/profile.php';
    }

    static private function delete_profile() {
        require_once 'views/pages/confirm-password.php';
    }

    static private function edit_profile() {
        require_once 'views/pages/edit-profile.php';
    }
}
