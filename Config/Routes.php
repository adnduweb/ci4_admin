<?php

/**
 * --------------------------------------------------------------------------------------
 * Route Backend
 * --------------------------------------------------------------------------------------
 */

$routes->group(CI_AREA_ADMIN, ['namespace' => '\Adnduweb\Ci4Admin\Controllers\Admin', 'filter' => 'login'], function($routes) {

    // Login
    $routes->get( 'login', 'Authentication::index', ['as' => 'login-area']);
    $routes->addRedirect('/', 'login-area');
    $routes->post('login', 'Authentication::attemptLogin', ['as' => 'postlogin-area']);
    $routes->get('logout', 'Authentication::doLogout', ['as' => 'doLogout']);

    // Activation
    $routes->get('activate-account', 'Authentication::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'Authentication::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot password
    $routes->get('forgot-password', 'AdminLoginController::forgotPassword', ['as' => 'forgot-password']);
    $routes->post('forgot-password', 'AdminLoginController::attemptForgot');

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index',  ['as' => 'dashboard']);
    $routes->get('cache/(:any)', 'Cache::$1',  ['as' => 'cache-$1']);

    // Réglages système
    $routes->group('(:any)/settings', function($routes) {
        $routes->get('/', 'Settings::index', ['as' => 'settings']);
        $routes->post('/', 'Settings::store');
    });


    // Users
    $routes->group('(:any)/users', function($routes) {

        $routes->get('/','Users::index', ['as' => 'users']);
        $routes->get('list', 'Users::ajaxProcessList', ['as' => 'users-listajax']);

        $routes->get("create", "Users::create", ['as' => 'user-create']);
        $routes->post('create','Users::store', ['as' => 'users-store']);

        $routes->get("show/(:any)", "Users::show/$2", ['as' => 'user-show']);

        $routes->get('edit/(:any)','Users::edit/$2', ['as' => 'user-edit']);
        $routes->post('edit/(:any)','Users::update/$2', ['as' => 'user-update']);
        $routes->post('ajaxUpdate','Users::ajaxUpdate', ['as' => 'user-ajaxUpdate']);

        $routes->delete('delete','Users::delete', ['as' => 'user-delete']);

        $routes->post('getPassword','Users::getPassword', ['as' => 'user-getpassword']);
        $routes->post('savePermissions','Users::savePermissions', ['as' => 'user-savepermissions']);
        
    });

    //Groups
    $routes->group('(:any)/groups', function($routes) {

        $routes->get('/','Groups::index', ['as' => 'groups']);
        $routes->get('list', 'Groups::ajaxProcessList', ['as' => 'groups-listajax']);

        $routes->get("create", "Groups::create", ['as' => 'group-create']);
        $routes->post('create','Groups::store', ['as' => 'groups-store']);

        $routes->get('edit/(:any)','Groups::edit/$2', ['as' => 'group-edit']);
        $routes->post('edit/(:any)','Groups::update/$2', ['as' => 'group-update']);

        $routes->delete('delete','Groups::delete', ['as' => 'group-delete']);

        $routes->post('savePermissions','Groups::savePermissions');
        $routes->post('saveAllPermissions','Groups::saveAllPermissions');
        
    });

     // Permissions
     $routes->group('(:any)/permissions', function($routes) {

        $routes->get('/','Permissions::index', ['as' => 'permissions']);
        $routes->get('list', 'Permissions::ajaxProcessList', ['as' => 'permissions-listajax']);

        $routes->get("create", "Permissions::create", ['as' => 'permission-create']);
        $routes->post('create','Permissions::store', ['as' => 'permissions-store']);

        $routes->get("show/(:any)", "Permissions::show/$2", ['as' => 'permission-show']);

        $routes->get('edit/(:any)','Permissions::edit/$2', ['as' => 'permission-edit']);
        $routes->post('edit/(:any)','Permissions::update/$2', ['as' => 'permission-update']);
        $routes->post('ajaxUpdate','Permissions::ajaxUpdate', ['as' => 'permission-ajaxUpdate']);

        $routes->delete('delete','Permissions::delete', ['as' => 'permission-delete']);

        $routes->post('getPassword','Permissions::getPassword', ['as' => 'permission-getpassword']);
        $routes->post('savePermissions','Permissions::savePermissions', ['as' => 'permission-savepermissions']);
        
    });

    // Companies
    $routes->group('(:any)/companies', function($routes) {

        $routes->get('/','Companies::index', ['as' => 'companies']);
        $routes->get('list', 'Companies::ajaxProcessList', ['as' => 'companies-listajax']);

        $routes->get("create", "Companies::create", ['as' => 'company-create']);
        $routes->post('create','Companies::store', ['as' => 'companies-store']);

        $routes->get("show/(:any)", "Companies::show/$2", ['as' => 'company-show']);

        $routes->get('edit/(:any)','Companies::edit/$2', ['as' => 'company-edit']);
        $routes->post('edit/(:any)','Companies::update/$2', ['as' => 'company-update']);
        $routes->post('ajaxUpdate','Companies::ajaxUpdate', ['as' => 'company-ajaxUpdate']);

        $routes->delete('delete','Companies::delete', ['as' => 'company-delete']);

        $routes->post('getPassword','Companies::getPassword', ['as' => 'company-getpassword']);
        $routes->post('savePermissions','Companies::savePermissions', ['as' => 'company-savepermissions']);
        
    });

     // Logs
     $routes->group('(:any)/logs', function($routes) {

        $routes->get('/','Logs::index', ['as' => 'logs']);
        $routes->get('list', 'Logs::ajaxProcessList', ['as' => 'logs-listajax']);
        $routes->delete('delete','Logs::delete', ['as' => 'logs-delete']);

        $routes->get('traffics','Logs::indexTraffic', ['as' => 'logs-traffics']);
        $routes->get('traffics/list', 'Logs::ajaxProcessList', ['as' => 'logs-traffics-listajax']);
        $routes->delete('traffics/delete','Logs::deleteTraffic', ['as' => 'logs-traffic-delete']);

        $routes->get('connexions','Logs::indexConnexions', ['as' => 'logs-connexions']);
        $routes->get('connexions/list', 'Logs::ajaxProcessList', ['as' => 'logs-connexions-listajax']);
        $routes->delete('connexions/deleteConnexions','Logs::deleteConnexions', ['as' => 'connexions-delete']);
        
    });

     // Translate
     $routes->group('(:any)/translate', function($routes) {

        $routes->get('/','Translate::index', ['as' => 'translate']);
        $routes->post('getfile','Translate::getFile', ['as' => 'translate-getfile']);
        $routes->post('savefile','Translate::saveFile', ['as' => 'translate-savefile']);
        $routes->post('deleteTexte','Translate::deleteTexte', ['as' => 'translate-deletetexte']);
        $routes->post('searchTexte','Translate::searchTexte', ['as' => 'translate-searchtexte']);
        $routes->post('saveTextfile','Translate::saveTextfile', ['as' => 'translate-savetextfile']);
        
    });


    // Informations
    $routes->get('(:any)/informations', 'Informations::index',  ['as' => 'informations']);
});

/**
 * --------------------------------------------------------------------------------------
 * API
 * --------------------------------------------------------------------------------------
 */

// $routes->group('api', ['filter' => 'api-auth'], function($routes)
// {
//     $routes->resource('users');
// });

//$routes->resource('api/user');
// $routes->resource('api/user', ['controller' =>'\Adnduweb\Ci4Admin\Controllers\Api\Users']);
// $routes->post('api/user/list', '\Adnduweb\Ci4Admin\Controllers\Api\Users::list');

//print_r($routes); exit;
