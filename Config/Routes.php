<?php

/**
 * Logn route
 */
$routes->group('', ['namespace' => '\Adnduweb\Ci4Admin\Controllers\Admin'], function($routes) {
    //$routes->get(CI_AREA_ADMIN, '\App\Controllers\Admin\Authentication::login', ['as' => 'ci_site_area', 'filter' => 'apiauth']);
    $routes->get(CI_AREA_ADMIN . '/login', 'Authentication::index', ['as' => 'login-area']);
    $routes->post(CI_AREA_ADMIN . '/login', 'Authentication::attemptLogin', ['as' => 'postlogin-area']);
});
