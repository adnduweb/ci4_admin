<?php

/**
 * Logn route
 */
//$routes->get(CI_AREA_ADMIN, '\Adnduweb\Ci4Admin\Controllers\Admin\Authentication::login', ['as' => 'ci_area_admin', 'filter' => 'loginauth']);
$routes->group(CI_AREA_ADMIN, ['namespace' => '\Adnduweb\Ci4Admin\Controllers\Admin', 'filter' => 'login'], function($routes) {
    //$routes->get(CI_AREA_ADMIN, '\App\Controllers\Admin\Authentication::login', ['as' => 'ci_site_area', 'filter' => 'apiauth']);
    //$routes->get( '/', 'Authentication::index', ['as' => 'login-area']);

    // Login
    $routes->get( 'login', 'Authentication::index', ['as' => 'login-area']);
    $routes->addRedirect('/', 'login-area');
    $routes->post('login', 'Authentication::attemptLogin', ['as' => 'postlogin-area']);

    // Activation
    $routes->get('activate-account', 'Authentication::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'Authentication::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot pâssword
    $routes->get('forgot-password', 'AdminLoginController::forgotPassword', ['as' => 'forgot-password']);
    $routes->post('forgot-password', 'AdminLoginController::attemptForgot');

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index',  ['as' => 'dashboard']);
});
