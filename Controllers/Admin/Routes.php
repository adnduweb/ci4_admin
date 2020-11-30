<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use \Adnduweb\Ci4Admin\Libraries\Theme;
use CodeIgniter\API\ResponseTrait;

class Routes extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

    /**
     * name controller
     */
    public $controller = 'routes';

     /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced';

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
    public $multilangue = false;

    /**
     * Display Multilangue
     */
    public $back = false;


     /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $this->viewData['form'] =  service('settings');

        parent::index();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\routes\index', $this->viewData);
    }


    public function postProcessEdit()
    {

        $code = $this->request->getPost('code');
        $code = substr($code, 0, -70);
        $code = $code . "\n\n" . '/* write Controller AdminRoutesController : ' . date('d/m/Y H:i:s') . ' */';

        if (!write_file(APPPATH . 'Config/Routes.php', $code)) {
            // Success!
            Tools::set_message('danger', lang('Core.not_save_data'), lang('Core.not_cool_success'));
            return redirect()->to('/' . CI_SITE_AREA .  $this->pathcontroller);
        } else {
            // Success!
            Tools::set_message('success', lang('Core.save_data'), lang('Core.cool_success'));
            return redirect()->to('/' . CI_SITE_AREA . $this->pathcontroller);
        }
    }
}
