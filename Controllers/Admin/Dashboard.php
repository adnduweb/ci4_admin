<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Models\DashboardModel;

class Dashboard extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    
    /**
     * name controller
     */
    public $controller = 'dashboard';

         /**
     * Localize slug
     */
    public $pathcontroller  = '/';

    /**
     * Localize slug
     */
    public $nameController  = '';

    /**
     * name model
     */
    public $tableModel = DashboardModel::class;


    public function index()
    {
      
        //$this->setTag('title', lang('Core.dashboard'));
        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\dashboard\index', $this->viewData);
    }

    public function environment()
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/' . PHP_VERSION],
            ['name' => 'Codeigniter version',   'value' => \CodeIgniter\CodeIgniter::CI_VERSION],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => $this->request->getServer('SERVER_SOFTWARE')],

            ['name' => 'Cache driver',      'value' => env('cache.Handler')],
            ['name' => 'Session driver',    'value' => env('app.sessionDriver')],

            ['name' => 'Timezone',          'value' => env('app.appTimezone')],
            ['name' => 'Locale',            'value' => env('app.defaultLocale')],
            ['name' => 'Env',               'value' => env('CI_ENVIRONMENT')],
            ['name' => 'URL',               'value' => env('app.baseURL')],
        ];
        return $envs;

        //return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/environment', $envs);
    }

    public static function extensions()
    {
        $extensions = [
            'helpers' => [
                'name' => 'laravel-admin-ext/helpers',
                'link' => 'https://github.com/laravel-admin-extensions/helpers',
                'icon' => 'gears',
            ],
            'log-viewer' => [
                'name' => 'laravel-admin-ext/log-viewer',
                'link' => 'https://github.com/laravel-admin-extensions/log-viewer',
                'icon' => 'database',
            ],
            'backup' => [
                'name' => 'laravel-admin-ext/backup',
                'link' => 'https://github.com/laravel-admin-extensions/backup',
                'icon' => 'copy',
            ],
            'config' => [
                'name' => 'laravel-admin-ext/config',
                'link' => 'https://github.com/laravel-admin-extensions/config',
                'icon' => 'toggle-on',
            ],
            'api-tester' => [
                'name' => 'laravel-admin-ext/api-tester',
                'link' => 'https://github.com/laravel-admin-extensions/api-tester',
                'icon' => 'sliders',
            ],
            'media-manager' => [
                'name' => 'laravel-admin-ext/media-manager',
                'link' => 'https://github.com/laravel-admin-extensions/media-manager',
                'icon' => 'file',
            ],
            'scheduling' => [
                'name' => 'laravel-admin-ext/scheduling',
                'link' => 'https://github.com/laravel-admin-extensions/scheduling',
                'icon' => 'clock-o',
            ],
            'reporter' => [
                'name' => 'laravel-admin-ext/reporter',
                'link' => 'https://github.com/laravel-admin-extensions/reporter',
                'icon' => 'bug',
            ],
            'redis-manager' => [
                'name' => 'laravel-admin-ext/redis-manager',
                'link' => 'https://github.com/laravel-admin-extensions/redis-manager',
                'icon' => 'flask',
            ],
        ];

        foreach ($extensions as &$extension) {
            $name = explode('/', $extension['name']);
            $extension['installed'] = array_key_exists(end($name), Admin::$extensions);
        }

        return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/extensions', $extensions);
    }

    public static function dependencies()
    {
        $json = file_get_contents(ROOTPATH . '/composer.json');

        $dependencies = json_decode($json, true)['require'];
        return $dependencies;

        // return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/dependencies', $dependencies);
    }
}
