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

// Definición de rutas del sitio web.
return array(
  'all-articles'       => array('route' => 'all-articles',       'controller' => 'articlesController',       'view' => 'all_articles'),
  'approve-articles'   => array('route' => 'approve-articles',   'controller' => 'adminController',          'view' => 'approve_articles'),
  'article'            => array('route' => 'article',            'controller' => 'articlesController',       'view' => 'article'),
  'authentication'     => array('route' => 'authentication',     'controller' => 'authenticationController', 'view' => 'authentication'),
  'authorize-article'  => array('route' => 'authorize-article',  'controller' => 'adminController',          'view' => 'authorize_article'),
  'delete-article'     => array('route' => 'delete-article',     'controller' => 'adminController',          'view' => 'delete_article'),
  'delete-comment'     => array('route' => 'delete-comment',     'controller' => 'communityController',      'view' => 'delete_comment'),
  'delete-profile'     => array('route' => 'delete-profile',     'controller' => 'profilesController',       'view' => 'delete_profile'),
  'delete-user'        => array('route' => 'delete-user',        'controller' => 'adminController',          'view' => 'delete_user'),
  'edit-profile'       => array('route' => 'edit-profile',       'controller' => 'profilesController',       'view' => 'edit_profile'),
  'errors'             => array('route' => 'errors',             'controller' => 'blogController',           'view' => 'errors'),
  'favorites'          => array('route' => 'favorites',          'controller' => 'communityController',      'view' => 'favorites'),
  'home'               => array('route' => 'home',               'controller' => 'blogController',           'view' => 'home'),
  'change-role'        => array('route' => 'change-role',        'controller' => 'adminController',          'view' => 'change_role'),
  'likes'              => array('route' => 'likes',              'controller' => 'communityController',      'view' => 'likes'),
  'login'              => array('route' => 'login',              'controller' => 'usersController',          'view' => 'login'),
  'logout'             => array('route' => 'logout',             'controller' => 'usersController',          'view' => 'logout'),
  'post-article'       => array('route' => 'post-article',       'controller' => 'articlesController',       'view' => 'post_article'),
  'profile'            => array('route' => 'profile',            'controller' => 'profilesController',       'view' => 'profile'),
  'published-articles' => array('route' => 'published-articles', 'controller' => 'adminController',          'view' => 'published_articles'),
  'registered-users'   => array('route' => 'registered-users',   'controller' => 'adminController',          'view' => 'registered_users'),
  'review-article'     => array('route' => 'review-article',     'controller' => 'adminController',          'view' => 'review_article'),
  'signup'             => array('route' => 'signup',             'controller' => 'usersController',          'view' => 'signup'),
  'suscription'        => array('route' => 'suscription',        'controller' => 'communityController',      'view' => 'suscription'),
);
