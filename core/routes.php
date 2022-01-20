<?php
/*
* Este archivo es parte de Nabu.
*
* Nabu es software libre: puedes redistribuirlo y/o modificarlo
* bajo los términos de la Licencia Pública General de GNU Affero publicada por
* la Free Software Foundation, ya sea la versión 3 de la Licencia, o
* (a su elección) cualquier versión posterior.
*
* Nabu se distribuye con la esperanza de que sea de utilidad,
* pero SIN NINGUNA GARANTÍA; incluso sin la garantía implícita de
* COMERCIABILIDAD o APTITUD PARA UN PROPÓSITO PARTICULAR. Consulte la
* Licencia Pública General de GNU Affero para obtener más detalles.
*
* Debería haber recibido una copia de la Licencia Pública General de GNU Affero
* junto con este programa. De lo contrario, consulte <https://www.gnu.org/licenses/>.
*/

defined('NABU') || exit();

return array(
  'authentication' => array('route' => 'authentication', 'controller' => 'authenticationController', 'view' => 'authentication'),
  'all-articles'   => array('route' => 'all-articles',   'controller' => 'articlesController',       'view' => 'all_articles'),
  'article'        => array('route' => 'article',        'controller' => 'articlesController',       'view' => 'article'),
  'delete-profile' => array('route' => 'delete-profile', 'controller' => 'profilesController',       'view' => 'delete_profile'),
  'edit-profile'   => array('route' => 'edit-profile',   'controller' => 'profilesController',       'view' => 'edit_profile'),
  'errors'         => array('route' => 'errors',         'controller' => 'blogController',           'view' => 'errors'),
  'favorites'      => array('route' => 'favorites',      'controller' => 'profilesController',       'view' => 'favorites'),
  'home'           => array('route' => 'home',           'controller' => 'blogController',           'view' => 'home'),
  'login'          => array('route' => 'login',          'controller' => 'usersController',          'view' => 'login'),
  'logout'         => array('route' => 'logout',         'controller' => 'usersController',          'view' => 'logout'),
  'post-article'   => array('route' => 'post-article',   'controller' => 'articlesController',       'view' => 'post_article'),
  'profile'        => array('route' => 'profile',        'controller' => 'profilesController',       'view' => 'profile'),
  'search'         => array('route' => 'search',         'controller' => 'articlesController',       'view' => 'search'),
  'sent-articles'  => array('route' => 'sent-articles',  'controller' => 'profilesController',       'view' => 'sent_articles'),
  'signup'         => array('route' => 'signup',         'controller' => 'usersController',          'view' => 'signup'),
);
