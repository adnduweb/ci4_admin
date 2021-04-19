<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use \Adnduweb\Ci4Admin\Libraries\Theme;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class Changelogs extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

   /**
     * name controller
     */
    public $controller = 'changelogs';

     /**
     * Localize slug
     */
    public $pathcontroller  = '/';

    /**
     * name model
     */
    public $tableModel = null;


    public function index($id = null)
    {
        helper('text');

        $this->viewData['now'] = new Time('now');

         parent::index();

         return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\changelogs', $this->viewData);
         
    }

    
}
