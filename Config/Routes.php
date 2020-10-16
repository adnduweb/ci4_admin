<?php

/**
 * Logn route
 */
//$routes->get(CI_AREA_ADMIN, '\App\Controllers\Admin\Authentication::login', ['as' => 'ci_site_area', 'filter' => 'apiauth']);
$routes->get(CI_AREA_ADMIN . '/login', '\Adnduweb\Admin\Controllers\Admin\Authentication::index', ['as' => 'login']);
$routes->post(CI_AREA_ADMIN . '/login', '\Adnduweb\Admin\Controllers\Admin\Authentication::attemptLogin', ['as' => 'postlogin']);
