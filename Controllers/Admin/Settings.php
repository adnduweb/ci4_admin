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
        $this->viewData['title_detail']  = '';

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
            (!isset($global['setting_maintenance']))           ? $global['setting_maintenance']           = false :  $global['setting_maintenance']           = true;
            (!isset($global['setting_activer_front']))         ? $global['setting_activer_front']         = false :  $global['setting_activer_front']         = true;
            (!isset($global['setting_activer_espace_public'])) ? $global['setting_activer_espace_public'] = false :  $global['setting_activer_espace_public'] = true;
            (!isset($global['setting_activer_ecommerce']))     ? $global['setting_activer_ecommerce']     = false :  $global['setting_activer_ecommerce']     = true;
            (!isset($global['setting_add_signature']))         ? $global['setting_add_signature']         = false :  $global['setting_add_signature']         = true;
            (!isset($global['setting_activer_multilangue']))   ? $global['setting_activer_multilangue']   = false :  $global['setting_activer_multilangue']   = true;
            (!isset($global['activer_manifest']))              ? $global['activer_manifest']              = false :  $global['activer_manifest']              = true;
            (!isset($global['activer_services_workers']))      ? $global['activer_services_workers']      = false :  $global['activer_services_workers']      = true;

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

                cache()->delete(config('Cache')->prefix . 'settings-templates-{$k}');

                $this->tableModel->getExist($k, 'global', $v);
                
                service('settings')->{$k} = $v;

                if ($k == 'setting_defaultLocale') {
                    $item = explode('|', $v);
                    service('settings')->setting_id = $item[0];
                    service('settings')->setting_lang_iso = $item[1];
                }
            }
        }
        cache()->delete(config('Cache')->prefix . 'admin-'. $this->settings->setting_theme_admin.'-initMenu-' . user()->id);

        $this->activateManifest(); // activate manifest
        $this->activateServicesWorkers(); // Activate Service Workers

        // Success!
        Theme::set_message('success', lang('Core.save_data'), lang('Core.cool_success'));
        return redirect()->to('/' . CI_AREA_ADMIN . '/' . $this->pathcontroller);

    }



    public function getThemesAdmin()
    {

        $dirTheme = [];
        foreach (glob(VENDORPATH . '/adnduweb/ci4_admin/Views/themes/*', GLOB_ONLYDIR) as $dir) {
            $dirTheme[] = basename($dir);
        }
        return $dirTheme;
    }

    protected function activateManifest(){

        if(service('settings')->activer_manifest == true){
         
            if ( ! write_file(ROOTPATH . 'public/admin/themes/' . $this->settings->setting_theme_admin . '/favicons/manifest.json', $this->getManifest())){
                    throw new \Exception(lang('Core.Unable to write the file'));
            }

        }else{
            @unlink(ROOTPATH . 'public/admin/themes/' . $this->settings->setting_theme_admin . '/favicons/manifest.json');
        }
        
    }

    protected function getManifest(){
        return '{
            "name": "'.service('settings')->setting_naneApp.'",
            "short_name": "'.service('settings')->setting_naneShortApp.'",
            "description": "'.service('settings')->setting_descApp.'",
            "icons": [{
                    "src": "/admin/themes/' . $this->settings->setting_theme_admin . '/favicons/android-icon-36x36.png",
                    "sizes": "36x36",
                    "type": "image\/png",
                    "density": "0.75"
                },
                {
                    "src": "/admin/themes/' . $this->settings->setting_theme_admin . '/favicons/android-icon-48x48.png",
                    "sizes": "48x48",
                    "type": "image\/png",
                    "density": "1.0"
                },
                {
                    "src": "/admin/themes/' . $this->settings->setting_theme_admin . '/favicons/android-icon-72x72.png",
                    "sizes": "72x72",
                    "type": "image\/png",
                    "density": "1.5"
                },
                {
                    "src": "/admin/themes/' . $this->settings->setting_theme_admin . '/favicons/android-icon-96x96.png",
                    "sizes": "96x96",
                    "type": "image\/png",
                    "density": "2.0"
                },
                {
                    "src": "/admin/themes/' . $this->settings->setting_theme_admin . '/favicons/android-icon-144x144.png",
                    "sizes": "144x144",
                    "type": "image\/png",
                    "density": "3.0"
                },
                {
                    "src": "/admin/themes/' . $this->settings->setting_theme_admin . '/favicons/android-icon-192x192.png",
                    "sizes": "192x192",
                    "type": "image\/png",
                    "density": "4.0"
                }
            ],
            "start_url": "'.base_url().'",
            "theme_color": "#1B1B28",
            "background_color": "#F1F2F7",
            "scope": "'.base_url().'",
            "display": "standalone"
        }';
    }

    protected function activateServicesWorkers(){
        if(service('settings')->activer_services_workers == true){
         
            if ( ! write_file(ROOTPATH . 'public/service-worker.js', $this->getServicesWorkers())){
                    throw new \Exception(lang('Core.Unable to write the file'));
            }
        }else{
            @unlink(ROOTPATH . 'public/service-worker.js');
        }
    }

    protected function getServicesWorkers(){

        return "
                var cacheName = 'spreadaurora_prod-v1';
                var appShellFiles = [
                    '/',
                    '/admin/themes/". $this->settings->setting_theme_admin ."/".ENVIRONMENT."/plugins/global/plugins.bundle.js',
                    '/admin/themes/". $this->settings->setting_theme_admin ."/".ENVIRONMENT."/plugins/custom/prismjs/prismjs.bundle.js',
                    '/admin/themes/". $this->settings->setting_theme_admin ."/".ENVIRONMENT."/plugins/custom/fullcalendar/fullcalendar.bundle.css',
                    '/admin/themes/". $this->settings->setting_theme_admin ."/".ENVIRONMENT."/plugins/global/plugins.bundle.css',
                    '/admin/themes/". $this->settings->setting_theme_admin ."/".ENVIRONMENT."/plugins/custom/prismjs/prismjs.bundle.css',
                    '/admin/themes/". $this->settings->setting_theme_admin ."/".ENVIRONMENT."/css/style.bundle.css',
                    '/admin/themes/". $this->settings->setting_theme_admin ."/language/lang_fr.js',
                    '/admin/themes/". $this->settings->setting_theme_admin ."/favicons/favicon.ico'
                ];

                self.addEventListener('install', (e) => {
                    console.log('[Service Worker] Installation');
                    e.waitUntil(
                        caches.open(cacheName).then((cache) => {
                            console.log('[Service Worker] Mise en cache globale: app shell et contenu');
                            return cache.addAll(appShellFiles);
                        })
                    );
                });

                self.addEventListener('fetch', (e) => {
                    e.respondWith(
                        caches.match(e.request).then((r) => {
                            console.log('[Service Worker] Récupération de la ressource: ' + e.request.url);
                            return r || fetch(e.request).then((response) => {
                                return caches.open(cacheName).then((cache) => {
                                    console.log('[Service Worker] Mise en cache de la nouvelle ressource: ' + e.request.url);
                                    cache.put(e.request, response.clone());
                                    return response;
                                });
                            });
                        })
                    );
                });

                //Delete cache 
                self.addEventListener('activate', (e) => {
                    e.waitUntil(
                        caches.keys().then((keyList) => {
                            return Promise.all(keyList.map((key) => {
                                if (cacheName.indexOf(key) === -1) {
                                    return caches.delete(key);
                                }
                            }));
                        })
                    );
                });";


    }
}
