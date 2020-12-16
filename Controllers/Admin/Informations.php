<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\API\ResponseTrait;

class Informations extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;


    /**
     *  Module Object
     */
    public $module = false;

    /**
     * name controller
     */
    public $controller = 'informations';

     /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced/informations';

    /**
     * name model
     */
    public $tableModel = null;

    /**
     * Bouton add
     */
    public $add = false;

     /**
     * Update Listing
     */
    public $toolbarUpdate = false;

        /**
     * Display Multilangue
     */
    public $back = false;


    /**
     * Update Listing
     */
    public $toolbarExport = true;

    public function index($id = null)
    {
        helper(['time', 'text']);

        parent::index();

        $this->viewData['countList']      = [];
        $this->viewData['back']           = $this->back;
        $this->viewData['action'] = 'edit';
        $this->viewData['edit_title']  = lang('Core.edit_' . $this->controller);
        $this->viewData['title_detail']  = lang('Core.liste_reglages');

        $this->viewData['envs'] = $this->environment();
        $this->viewData['extenions'] = $this->extensions();
        $this->viewData['dependencies'] = $this->dependencies();


        // return view($this->get_current_theme_view('controllers/informations/index', 'default'), $this->viewData);
        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\informations\index', $this->viewData);
    }

    public function environment()
    {
        $cache = \Config\Services::cache();

        ///print_r($cache->getCacheInfo()); exit;


        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/' . PHP_VERSION],
            ['name' => 'App version',       'value' => service('settings')->setting_latestRelease],
            ['name' => 'Codeigniter version',   'value' => \CodeIgniter\CodeIgniter::CI_VERSION],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => $this->request->getServer('SERVER_SOFTWARE')],

            ['name' => 'Cache driver',      'value' => [env('cache.handler'),  $cache->getCacheInfo()]],
            ['name' => 'Durée du Cache',    'value' => ConvertisseurTime(env('cache.CacheDuration'))],
            ['name' => 'Cache path',        'value' =>  config('Cache')->storePath],
            ['name' => 'Session driver',    'value' => env('app.sessionDriver')],

            ['name' => 'Timezone',          'value' => env('app.appTimezone')],
            ['name' => 'Locale',            'value' => service('request')->getLocale()],
            ['name' => 'Env',               'value' => env('CI_ENVIRONMENT')],
            ['name' => 'URL',               'value' => env('app.baseURL')],

            ['name' => 'Version Core',      'value' => config('Core')->version],

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
            // $extension['installed'] = array_key_exists(end($name), Admin::$extensions);
        }

        //return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/extensions', $extensions);
    }

    public static function dependencies()
    {
        $json = file_get_contents(ROOTPATH . 'composer.json');

        $dependencies = json_decode($json, true)['require'];
        return $dependencies;

        // return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/dependencies', $dependencies);
    }
}
