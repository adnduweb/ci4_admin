<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use \Adnduweb\Ci4Admin\Libraries\Theme;
use CodeIgniter\API\ResponseTrait;

class Cache extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

    /**
     * name controller
     */
    public $controller = 'cache';

     /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced/cache';

    /**
     * name model
     */
    public $tableModel = null;


    /**
     * 
     * Construct
     */
    public function __construct()
    {
       // parent::__construct();
    }

    public function delete()
    {
        $cache = \Config\Services::cache();
        if (env('cache.handler') == 'redis') {
            $cache->clean();
        } else {
            $pattern = '/^front:/';
            $i = 0;
            foreach ($cache->getCacheInfo() as $key => $value) {
                preg_match($pattern, $key, $matches);
                if (!empty($matches)) {
                    @unlink($value['server_path']);
                }
                $i++;
            }
            command('cache:clear');
        }
       
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return redirect()->back();
    }



    public function deleteFront()
    {
        $cache = \Config\Services::cache();
        if (env('cache.handler') == 'redis') {
            $cache->clean();
        } else {
            $pattern = '/^front:/';
            $i = 0;
            foreach ($cache->getCacheInfo() as $key => $value) {
                preg_match($pattern, $key, $matches);
                if (!empty($matches)) {
                    @unlink($value['server_path']);
                }
                $i++;
            }
            command('cache:clear');
        }
       
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return redirect()->back();
    }
}
