<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use \Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Core\Models\LanguageModel;
use Adnduweb\Ci4Core\Models\CurrencyModel;
use Adnduweb\Ci4Core\Models\SettingModel;
use CodeIgniter\API\ResponseTrait;

class Settings extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

    /**
     * name controller
     */
    public $controller = 'settings';

     /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced/settings';

    /**
     * name model
     */
    public $tableModel = SettingModel::class;

    /**
     * Bouton add
     */
    public $add = true;

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

        $this->viewData['getThemesAdmin'] = $this->getThemesAdmin();
        //$this->viewData['getThemesFront'] = $this->getThemes('front');
        $this->viewData['languages']      = (new LanguageModel())->select('id, name, iso_code')->where('active', 1)->get()->getResult();
        $this->viewData['currencies']     = (new CurrencyModel())->select('id, name, iso_code')->where('active', 1)->get()->getResult();
        $this->viewData['countList']      = [];
        $this->viewData['back']           = $this->back;
        $this->viewData['action'] = 'edit';
        $this->viewData['edit_title']  = lang('Core.edit_' . $this->controller);
        $this->viewData['title_detail']  = lang('Core.liste_reglages');

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\settings\index', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        if ($this->request->getPost('user')) {
            $user = $this->request->getPost('user');
            foreach ($user as $k => $v) {
                //$this->tableModel->getExist($k, 'user', $v);
                service('settings')->{$k} = $v;
            }
        }
        if ($this->request->getPost('global')) {

            $global = $this->request->getPost('global');
            // print_r($global);
            //  exit;
            (!isset($global['setting_maintenance'])) ? $global['setting_maintenance'] = false :  $global['setting_maintenance'] = true;
            (!isset($global['setting_activer_front'])) ? $global['setting_activer_front'] = false :  $global['setting_activer_front'] = true;
            (!isset($global['setting_activer_espace_public'])) ? $global['setting_activer_espace_public'] = false :  $global['setting_activer_espace_public'] = true;
            (!isset($global['setting_activer_ecommerce'])) ? $global['setting_activer_ecommerce'] = false :  $global['setting_activer_ecommerce'] = true;
            (!isset($global['setting_add_signature'])) ? $global['setting_add_signature'] = false :  $global['setting_add_signature'] = true;
            (!isset($global['setting_activer_multilangue'])) ? $global['setting_activer_multilangue'] = false :  $global['setting_activer_multilangue'] = true;

            if($global['setting_activer_ecommerce'] == true){
                $global['setting_activer_espace_public'] = true;
            }            


            (!isset($global['setting_rgpd_youtube'])) ? $global['setting_rgpd_youtube'] = false :  $global['setting_rgpd_youtube'] = true;
            (!isset($global['setting_rgpd_facebook'])) ? $global['setting_rgpd_facebook'] = false :  $global['setting_rgpd_facebook'] = true;
            (!isset($global['setting_rgpd_twitter'])) ? $global['setting_rgpd_twitter'] = false :  $global['setting_rgpd_twitter'] = true;
            (!isset($global['setting_rgpd_store_cookie_consent'])) ? $global['setting_rgpd_store_cookie_consent'] = false :  $global['setting_rgpd_store_cookie_consent'] = true;


            foreach ($global as $k => $v) {

                if (is_array($v)) {
                    $v = json_encode($v);

                }

                cache()->delete(config('Cache')->cacheQueryString . 'settings-templates-{$k}');

                $this->tableModel->getExist($k, 'global', $v);
                
                service('settings')->{$k} = $v;

                if ($k == 'setting_defaultLocale') {
                    $item = explode('|', $v);
                    service('settings')->setting_id = $item[0];
                    service('settings')->setting_lang_iso = $item[1];
                }
            }
        }
        cache()->delete(config('Cache')->cacheQueryString . 'admin-'. $this->settings->setting_theme_admin.'-initMenu-' . user()->id);

        // Success!
        Theme::set_message('success', lang('Core.save_data'), lang('Core.cool_success'));
        return redirect()->to('/' . CI_AREA_ADMIN . '/' . $this->pathcontroller);

    }



    public function getThemesAdmin()
    {

        $dirTheme = [];
        foreach (glob(VENDORPATH . '\adnduweb\Ci4_admin\Views\themes\*', GLOB_ONLYDIR) as $dir) {
            $dirTheme[] = basename($dir);
        }
        return $dirTheme;
    }
}
