<?php

defined('NABU') || exit();

return array(
    'admin'              => array('route' => 'admin',                   'controller' => 'adminController',         'view' => 'admin'),
    'all-articles'       => array('route' => 'all-articles',            'controller' => 'articlesController',      'view' => 'all_articles'),
    'article'            => array('route' => 'article',                 'controller' => 'articlesController',      'view' => 'article'),
    'authorize-article'  => array('route' => 'admin&section=authorize', 'controller' => 'adminController',         'view' => 'admin'),
    'category'           => array('route' => 'category',                'controller' => 'articlesController',      'view' => 'category'),
    'comment'            => array('route' => 'comment',                 'controller' => 'communityController',     'view' => 'comment'),
    'delete-profile'     => array('route' => 'profile&page=delete',     'controller' => 'profilesController',      'view' => 'profile'),
    'delete-article'     => array('route' => 'admin&section=delete',    'controller' => 'adminController',         'view' => 'delete_article'),
    'edit-article'       => array('route' => 'admin&section=edit',      'controller' => 'adminController',         'view' => 'edit_article'),
    'edit-profile'       => array('route' => 'profile&page=edit',       'controller' => 'profilesController',      'view' => 'edit_profile'),
    'errors'             => array('route' => 'errors',                  'controller' => 'blogController',          'view' => 'errors'),
    'home'               => array('route' => 'home',                    'controller' => 'blogController',          'view' => 'home'),
    'favorites'          => array('route' => 'favorites',               'controller' => 'communityController',     'view' => 'favorites'),
    'like'               => array('route' => 'like',                    'controller' => 'communityController',     'view' => 'like'),
    'login'              => array('route' => 'login',                   'controller' => 'usersController',         'view' => 'login'),
    'logout'             => array('route' => 'logout',                  'controller' => 'usersController',         'view' => 'logout'),
    'post-article'       => array('route' => 'post-article',            'controller' => 'articlesController',      'view' => 'post_article'),
    'profile'            => array('route' => 'profile',                 'controller' => 'profilesController',      'view' => 'profile'),
    'published-articles' => array('route' => 'admin&section=published', 'controller' => 'adminController',         'view' => 'admin'),
    'search'             => array('route' => 'search',                  'controller' => 'searchController',        'view' => 'search'),
    'sent-articles'      => array('route' => 'sent-articles',           'controller' => 'articlesController',      'view' => 'sent_articles'),
    'signup'             => array('route' => 'signup',                  'controller' => 'usersController',         'view' => 'signup'),
    'users'              => array('route' => 'admin&section=users',     'controller' => 'adminController',         'view' => 'admin'),
    'verifications'      => array('route' => 'verifications',           'controller' => 'verificationsController', 'view' => 'verifications'),
);
