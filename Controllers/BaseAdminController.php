<?php
namespace Adnduweb\Ci4Admin\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Psr\Log\LoggerInterface;
use \Adnduweb\Ci4Admin\Libraries\Theme;

abstract class BaseAdminController extends \CodeIgniter\Controller
{


      /**
     * @var back
     */
    protected $isBack = false;

         /**
     * @var back
     */
    protected $isFront = false;

    /**
     * @var helpers
     */

    /**
     * @var helpers
     */
    protected $helpers = ['detect', 'auth'];

    /**
     * Set default directory
     */
    protected $directory = ''; // Set default directory

    /**
     *  Set default yield view
     */
    protected $view = null; // Set default yield view

    /**
    * Refactored class-wide data array variable
    * 
    * @var array
    */
    protected $viewData = [];

    /**
     *  Service UUID
     */
    protected $uuid;

    /**
     *  Id ressource 
     */
    protected $id;

    /**
     * @var Authorize
     */
    protected $authorize;
    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Db
     */
    protected $db;

    /**
     * @var Pager
     */
    protected $pager;

    public $locale;

    /**
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

        /**
     * @var \CodeIgniter\Services\encrypter
     */
    protected $encrypter;

    /**
     * @var \Config\Services::validation();
     */
    protected $validation;

     /**
     * @array array ;
     */
    protected $rules;

    /**
     * Display Data datatable
     */
    public $listDatatable = [];

    /**
     * Bouton add
     */
    public $add = true;

    /**
     *  Bool Update
     */
    public $toolbarUpdate = true;

    /**
     *  Bool Change Categorie
     */
    public $changeCategorie = false;

    /**
     *  Bool Export
     */
    public $toolbarExport = false;

    /**
     *  Bool Fake
     */
    public $fakeData = false;

    /**
     * Retour
     */
    public $toolbarBack = true;

    /**
     *  Bool Multilangue
     */
    public $multilangue     = false;

    /**
     *  Bool FolderList
     */
    public    $folderList      = false;


    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        $this->session   = service('session');
        $this->encrypter = service('encrypter');
        $this->uuid      = service('uuid');

        //Check language
        $this->langue = service('LanguageOverride');
        setlocale(LC_TIME, service('request')->getLocale() . '_' .  service('request')->getLocale());

        //--------------------------------------------------------------------
        // Check for flashdata
        //--------------------------------------------------------------------
        $this->viewData['confirm'] = $this->session->getFlashdata('confirm');
        $this->viewData['errors']  = $this->session->getFlashdata('errors');
        $this->viewData['html']    = detectBrowser(true);


        $this->auth       = service('authentication');
        $this->settings   = service('settings');
        $this->validation = service('validation');
        $this->db         = Database::connect();
        $this->tableModel = (!is_null( $this->tableModel)) ? new $this->tableModel : null;

        // Display theme information
        $this->viewData['theme_admin'] = $this->settings->setting_theme_admin;
        $this->viewData['metatitle']   = $this->controller;

        // Display param js
        $this->initParamJs();

        //Display menu
        $this->initMenu();

    }

    protected function _render(string $view, array $data = [])
	{
		return view($view, $data);
    }

    protected function _redirect(string $url)
	{
        if($this->request->getMethod() == 'post'){
            
            $submithandler = $this->request->getPost('submithandler');

            switch ($submithandler) {
                case 'save_continue':
                    return redirect()->to('/' . CI_AREA_ADMIN . $this->pathcontroller . '/' .  $this->controller . $url);
                    break;
                case 'save_and_new':
                    return redirect()->to('/' . CI_AREA_ADMIN . $this->pathcontroller . '/' .  $this->controller . '/create');
                    break;
                case 'save_and_exit':
                    return redirect()->to('/' . CI_AREA_ADMIN . $this->pathcontroller . '/' .  $this->controller);
                    break;
                default:
                    return redirect()->to('/' . CI_AREA_ADMIN . $this->pathcontroller . '/' .  $this->controller);
            }
        }

		return redirect()->to('/' . CI_AREA_ADMIN . $this->pathcontroller . '/' .  $this->controller . $url);
    }

     // try to cache a setting and pass it back
     protected function cache($key, $content)
     {
         if ($content === null) {
             return cache()->delete($key);
         }
 
         if ($duration = env('cache.CacheDuration')) {
             cache()->save($key, $content, $duration);
         }
         return $content;
     }


    protected function initMenu()
    {
        $this->viewData['currentUrlSegment'] = array_flip($this->request->uri->getSegments());

        if ($this->viewData['menu'] = cache(config('cache')->cacheQueryString . "admin-" . $this->settings->setting_theme_admin . "-initMenu-" . user_id())) {
            return $this->viewData['menu'];
        }

        helper('array');
        $tab                 = new \Adnduweb\Ci4Core\Models\TabModel();
        $menus               = $tab->getTab();
        $this->viewData['menu']              = [];
        
        if (!empty($menus)) {
            $i = 0;
            foreach ($menus as $menu) {
                $this->viewData['menu'][$i] = $menu;
                if ($this->settings->setting_activer_front == false && $menu->id == 17) {
                    unset($this->viewData['menu'][$i]);
                } elseif ($this->settings->setting_activer_ecommerce == false && $menu->id == 20) {
                    unset($this->viewData['menu'][$i]);
                } elseif ($this->settings->setting_activer_espace_public == false && $menu->id == 29) {
                    unset($this->viewData['menu'][$i]);
                }

                $i++;
            }
        }
        $this->cache(config('cache')->cacheQueryString . "admin-" . $this->settings->setting_theme_admin . "-initMenu-" . user_id(), $this->viewData['menu']);
    }
    
    protected function initParamJs()
    {

        $this->viewData['paramJs'] =  [
            'base_url'       => site_url(),
            'current_url'    => current_url(),
            'uri'            => $this->request->uri->getPath(),
            'basePath'       => '\/',
            'baseController' => base_url('/' . env('app.areaAdmin') . $this->pathcontroller . '/'. $this->controller),
            'segementAdmin'  => env('app.areaAdmin'),
            'startUrl'       => '\/' . env('app.areaAdmin'),
            'lang_iso'       => $this->settings->setting_lang_iso,
            'id_lang'        => $this->settings->setting_id_lang,
            'env'            => ENVIRONMENT,
            'SP_VERSION'     => config('Core')->version
        ];

        if(logged_in() == true){

            $user = new   \Adnduweb\Ci4Admin\Entities\User(array('id' => user()->id));
            $id_group = [];
            foreach ($user->auth_groups_users as $auth_groups_users) {
                $id_group[] = $auth_groups_users->group_id;
            }

            $this->viewData['paramJs']['user_uuid']           = $user->uuid;
            $this->viewData['paramJs']['id_group']            = json_encode($id_group);
            $this->viewData['paramJs']['activer_multilangue'] = $this->settings->setting_activer_multilangue;
            $this->viewData['paramJs']['supportedLocales']    = implode('|', $this->langue->supportedLocales());
            $this->viewData['paramJs']['crsftoken']           = csrf_token();
            $this->viewData['paramJs']['tokenHash']           = md5($user->uuid.$this->controller);
        }
        return $this->viewData['paramJs'];
    }


    /**
     * 
     * --------------------------------------------------------------------------
     * CRUD
     * --------------------------------------------------------------------------
     */

    /**
    * Display view only
    *
    */
    public function index(){
       
        helper('form');

        if (!has_permission(ucfirst($this->controller) . '::view', user()->id)) {
            Theme::set_message('danger', lang('Core.not_acces_permissions'), lang('Core.warning_error'));
            return redirect()->to(route_to('dashboard'));
        }

        $this->getToolbar();
        $this->viewData['addPathController'] = $this->pathcontroller . '/'. $this->controller .  '/create';

        if (isset($this->add) && $this->add == true)
            $this->viewData['add'] = lang('Core.add_' . $this->controller);
     }

    

    /**
     * Store a newly created resource in storage in ajax.
     *
     */
    public function storeAjax($params = null)
    {
        
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(string $id)
    {
       // Permission
       if (!has_permission(ucfirst($this->controller) . '::view', user()->id))
       {
           Theme::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
           return $this->response->redirect(route_to('dashboard'));
        }


       if($this->uuid->isValid($id))
       {
           $this->id = $this->uuid->fromString($id)->getBytes();
       }
       else
       {
           $this->id = (int) $id; 
       }
       
    }

    /**
     *
     */
    public function create()
    { 
        helper('form');

        $this->getToolbar();
        $this->viewData['action'] = 'create';
        $this->viewData['create_title']  = lang('Core.create_' . $this->controller);

        if (!has_permission(ucfirst($this->controller) . '::create', user()->id)) {
            Theme::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
            return $this->response->redirect(route_to('dashboard'));
         }

    }

     /**
     * Store a newly created resource in storage.
     *
     */
    public function store(){

        helper('form');
    }


    public function edit(string $id)
    {
        helper('form');

        if (!has_permission(ucfirst($this->controller) . '::edit', user()->id)) {
            Theme::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
            return $this->response->redirect(route_to('dashboard'));
         }

        if($this->uuid->isValid($id))
        {
            $this->id = $this->uuid->fromString($id)->getBytes();
        }
        else
        {
            $this->id = (int) $id; 
        }
        

        $this->getToolbar();
        $this->viewData['action'] = 'edit';
        $this->viewData['edit_title']  = lang('Core.edit_' . $this->controller);

        
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {

        // Permission
        if (!has_permission(ucfirst($this->controller) . '::update', user()->id))
        {
            Theme::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
            return $this->response->redirect(route_to('dashboard'));
         }

        

        if($this->uuid->isValid($id))
        {
            $this->id = $this->uuid->fromString($id)->getBytes();
        }
        else
        {
            $this->id = (int) $id; 
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete()
    {
        // Permission
        if (!has_permission(ucfirst($this->controller) . '::delete', user()->id))
        {
            Theme::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
            return $this->response->redirect(route_to('dashboard'));
         }
    }

    protected function getToolbar(){

        $this->viewData['controller'] = lang('Core.' . $this->controller);
        $this->viewData['addPathController'] = $this->pathcontroller . '/create';
        $this->viewData['toolbarBack'] = $this->toolbarBack;
        $this->viewData['fakedata'] = $this->fakeData;
        $this->viewData['toolbarUpdate'] = $this->toolbarUpdate;
        $this->viewData['toolbarExport'] = $this->toolbarExport;
        $this->viewData['changeCategorie'] = $this->changeCategorie;
        $this->viewData['backPathController'] = $this->pathcontroller . '/' . $this->controller;
        $this->viewData['multilangue'] = (isset($this->multilangue)) ? $this->multilangue : false;
    }

    public function ajaxProcessList()
    {
        $list                        = $this->request->getVar();
        (isset($list['model'])) ? $this->tableModel =  new $list['model']() : $this->tableModel = $this->tableModel;
        (isset($list['handle'])) ? $getAllCount =  'getAll'.ucfirst($list['handle']).'Count' : $getAllCount = 'getAllCount';
        (isset($list['handle'])) ? $getAllList =  'getAll'.ucfirst($list['handle']).'List' : $getAllList = 'getAllList';
        (!isset($list['sort']['field'])) ? $fieldList = $this->fieldList : $fieldList = $list['sort']['field'];
        (!isset($list['sort']['sort'])) ? $fieldListSort = 'DESC' : $fieldListSort = $list['sort']['sort'];

        // Quand pas de résulats
        $page = !empty($list['pagination']['page']) ? (int) $list['pagination']['page'] : 1;
        $page = ($page < 0) ? 1 : $page;
        $list['pagination']['page'] = ($page < 0) ? 1 : $page;

        $list['page']                = $page;
        $list['pagination']['sort']  = (isset($list['pagination']['sort'])) ? $list['pagination']['sort'] : $list['sort'] = ['field' => $fieldList,  'sort' => $fieldListSort];
        $list['pagination']['query'] = (!empty($list['query'])) ? $list['query'] : [];
        $list['perpage']             = !empty($list['pagination']['perpage']) ? (int) $list['pagination']['perpage'] : -1;

        $getInfosAllCount = $this->tableModel->{$getAllCount}($list['pagination']['sort'], $list['pagination']['query'], $this->tableModel->searchKtDatatable);
        $getInfosAllPaginations = $this->tableModel->{$getAllList}($list['page'], $list['perpage'], $list['pagination']['sort'], $list['pagination']['query']);

        if (!empty($getInfosAllPaginations)) {
            $i = 0;
            foreach ($getInfosAllPaginations as $getInfosAllPagination) {
                if (isset($getInfosAllPagination->date_create_at)) {
                    $getInfosAllPaginations[$i]->date_create_format = date('d/m/Y', strtotime($getInfosAllPagination->date_create_at));
                    $getInfosAllPaginations[$i]->date_create_format_full = date('d/m/Y H:i:s', strtotime($getInfosAllPagination->date_create_at));
                }
                
                // GESTION DES UUID
                if (isset($this->tableModel->uuidFields) && is_array($this->tableModel->uuidFields)) {
                    foreach ($this->tableModel->uuidFields as $key => $value) {
                        $getInfosAllPaginations[$i]->{$value} = $this->uuid->fromBytes($getInfosAllPagination->{$value});
                    }
                }

                /// LOGS
                if (isset($getInfosAllPagination->user_id) && $getInfosAllPagination->user_id != '0') {
                    $userModel =  new \Adnduweb\Ci4Admin\Models\UserModel();
                    $getInfosAllPaginations[$i]->username = $userModel::getUserName($getInfosAllPagination->user_id);
                } else {
                    $getInfosAllPaginations[$i]->username = lang('Core.non_connu');
                }
                $i++;
            }
        }

        $total = count($getInfosAllCount);
        if ($list['perpage']  > 0) {
            $pages  = ceil($total / $list['perpage']); // calculate total pages
            $list['page']   = max($list['page'], 1); // get 1 page when $_REQUEST['page'] <= 0
            $list['page']   = min($list['page'], $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($list['page'] - 1) * $list['perpage'];
            if ($offset < 0) {
                $offset = 0;
            }
        }
        $meta   = [
            'page'    => $list['page'],
            'pages'   => $pages,
            'perpage' => $list['perpage'],
            'total'   => $total,
        ];
        $this->listDatatable = [
            'meta' => $meta + [
                'sort'  => (isset($list['pagination']['sort']['sort'])) ? $list['pagination']['sort']['sort'] : 'ASC',
                'field' => $list['sort']['field'],
            ],
            'data' => $getInfosAllPaginations,
            csrf_token() => csrf_hash()

        ];

        return $this->listDatatable;
    }

    protected function sanitizePhone(object $object){
       
        if(isset($object->full_phone) && !empty($object->full_phone)){
            $phoneInternationalPhone = $this->phoneInternational($object->full_phone);
            if ($phoneInternationalPhone['status'] == 200) {
               
                $object->phone = $phoneInternationalPhone['message'];

            } else {
                return [ 'error' =>['code' => 400, 'message' => lang('Core.' . $phoneInternationalPhone['message'] . ': phone')], 'success' => false, csrf_token() => csrf_hash()];
            }
        }

        if(isset($object->full_phone_mobile) && !empty($object->full_phone_mobile)){
            $phoneInternationalMobile = $this->phoneInternational($object->full_phone_mobile);
            if ($phoneInternationalMobile['status'] == 200) {

                $object->phone_mobile = $phoneInternationalMobile['message'];

            } else {
                return [ 'error' =>['code' => 400, 'message' => lang('Core.' . $phoneInternationalMobile['message'] . ': phone_mobile')], 'success' => false, csrf_token() => csrf_hash()];
            }
        }

        //return $object;

    }

}
