<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\User;
use Adnduweb\Ci4Admin\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Users extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait, \Adnduweb\Ci4Core\Traits\LibphoneTraits;

    /**
     * 
     */
    public $supportedResponseFormats = [
        'application/json'
    ];

    public $formatters = [
        'application/json' => \CodeIgniter\Format\JSONFormatter::class
    ];

    /**
     *  UUID unique User
     */
    protected $uuidUser;

    /**
     * name controller
     */
    public $controller = 'users';

        /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced';

    /**
     * name model
     */
    public $tableModel = UserModel::class;

    /**
     * Attachement company
     */
    public $fieldIdcompany = false;

    /** 
     * Display default list column
     */
    public $fieldList = 'username';


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //Theme::add_js(['/admin/themes/'. $this->settings->setting_theme_admin . '/assets/js/pages/custom/'.$this->dirList.'/page.list.'.$this->dirList.'.js']);
        Theme::add_js('/resources/metronic/js/pages/custom/users/page.list.users.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\users\index', $this->viewData);
    }

    /**
     * Display a listing of the resource in Ajax.
     *
     */
    public function ajaxProcessList()
    {
        parent::ajaxProcessList();
        return $this->respond($this->listDatatable, 200, 'Display user');
    }

    /**
     * Create ressource
     */
    public function create()
    {
        helper('Tools');
        parent::create();
        Theme::add_js('/resources/metronic/js/pages/custom/users/outils.users.js');

        // Initialize form
        $this->viewData['form'] = new User();

        // liste des groupes
        $this->viewData['groups'] = $this->tableModel->getGroups();

        //Liste des company
        $this->viewData['form']->company = $this->tableModel->getCompany();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\users\form', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
      
        $users = new UserModel();

        $this->rules = [
            'username'  	=> 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
			'email'			=> 'required|valid_email|is_unique[users.email]',
			'password'	 	=> 'required|strong_password',
			'pass_confirm' 	=> 'required|matches[password]',
        ];

        if (!$this->validate($this->rules)) {

            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Try to create the user
        $user = new User($this->request->getPost());

        // Format Phone
        if(($response =  $this->sanitizePhone($user)) == true){
            Theme::set_message('danger', $response['error']['message'], lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        //$user->company_id = user()->company_id;
        $user->username = ucfirst(trim(strtolower($user->firstname))) . ucfirst($user->lastname[0]) . time();
        $user->force_pass_reset = ($user->force_pass_reset == '1') ? $user->force_pass_reset : '0';
        $user->uuid = $this->uuid->uuid4()->toString();

        //Save
        try {

            $users->save($user);
            $userId = $users->insertID();

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

       // Save groups
        $groupModel = new \Adnduweb\Ci4Admin\Models\GroupModel();
        $idGroupCurrent = array_flip($this->request->getPost('id_group'));
        foreach ($idGroupCurrent as $k => $v) {
            $groupModel->addUserToGroup($userId, $k);
        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' .$user->uuid);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        parent::edit($uuid);
        //

        if ($this->request->isAJAX()) {
        }
                $this->data['user'] = $this->tableModel->where(['uuid' => $this->id])->first();
                if (empty($this->data['user'])) {
                    throw new \RuntimeException(lang('Admin.object_not_exit'), 404);
                }

                $this->data['getLastConnexions'] = $this->tableModel->getLastConnexions($this->data['user']->id, 5);
    
                $modal = view('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\users\__modals\view', $this->data);
                $response = [ 'success' =>['code' => 200, 'message' => $modal], 'error' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 200, 'display user');
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $uuid)
    {
        parent::edit($uuid);

        helper(['Tools', 'Time']);

        Theme::add_js(
            [
                '/resources/metronic/js/pages/custom/users/outils.users.js',
                '/resources/metronic/js/pages/custom/users/permission.users.js'
            ]
        );

        // Initialize form
        $this->viewData['form'] = $this->tableModel->where(['uuid' => $this->id])->first();
        $this->viewData['title_detail'] = $this->viewData['form']->lastname  . ' ' . $this->viewData['form']->fistname;

        //Get Permissions User
        $this->getPermissions($this->viewData['form']->id);

        // List of groups
        $this->viewData['groups'] = $this->tableModel->getGroups();
        //print_r($this->viewData['form']->auth_groups_users); exit;

        //List Of Company 
        $this->viewData['form']->company = $this->tableModel->getCompany();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\users\form', $this->viewData);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $uuid)
    {
        $user_id = $this->tableModel->getIdUserByUUID($uuid);
        parent::update($uuid);
        

        $users = new UserModel();

        $this->rules = [
            'email'    => 'required|valid_email|is_unique[users.email,id,' . $user_id . ']',
            'id_group' => 'required',
        ];

        if (!$this->validate($this->rules)) {

            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Try to create the user
        $user = new User($this->request->getPost());

        //Vérification du mot de passe
        $password = $this->request->getPost('password');
        $pass_confirm = $this->request->getPost('pass_confirm');
        if (empty($password)) {
            unset($user->password);
            unset($user->pass_confirm);
            unset($user->password_hash);
        } else {
            if ($password != $pass_confirm) {
                Theme::set_message('danger', lang('Core.not_concordance_mote_de_passe'), lang('Core.warning_error'));
                return redirect()->back()->withInput();
            }
        }

        // Format Phone
        if(($response =  $this->sanitizePhone($user)) == true){
            Theme::set_message('danger', $response['error']['message'], lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }
        
        $user->id = $user_id;
        //$user->username = ucfirst(trim(strtolower($user->firstname))) . ucfirst($user->lastname[0]) . time();
        $user->force_pass_reset = ($user->force_pass_reset == '1') ? $user->force_pass_reset : '0';
        $workCrudGroup = $this->workCrudGroup($user);
        if ($workCrudGroup != true) {
            if ($workCrudGroup['status'] == 406) {
                Theme::set_message('danger', $workCrudGroup['message'], lang('Core.warning_error'));
                return redirect()->back()->withInput();
            }
        }

        //Si le connecté n'est égal au user
        if (user()->id != $user->id) {
            $active = $this->request->getPost('active');
            if (!$active) {
                $user->active = '0';
            }
        }

        //Save
        try {

            $users->save($user);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        //Si le connecté est égal au user
        if (user()->id == $user->id) {
            $this->saveSettings($this->request->getPost());
        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' .$user->uuid);


    }

    /**
     * Update the specified resource in storage.
     */
    public function ajaxUpdate($params = null)
    {
        if ($this->request->isAJAX()) {

            $users = [];
            $i = 0;
            foreach($this->request->getPost('value') as $master => $array){
                if(is_array($array)){
                    foreach ($array as $key => $value) {

                        if ($key == 'uuid') {
                            $usersTemp = $this->tableModel->getUserByUUID($value);
                        }
                       if(($response = $this->getPermissionsListFilter($usersTemp)) == true){
                            return $this->respond($response, 401, 'Update user');
                       }
                        $usersTemp->{$key} =  $value;
                        $users['uuid'] = $usersTemp;

                       
                    }
                }else
                 throw new \Exception("Some message goes here");

                 $i++;
            }

            try{

                $this->tableModel->updateBatch($users, 'uuid');
                $response = [ 'success' =>['code' => 200, 'message' => lang('Core.success_update')], 'error' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 200, 'Update user');
            }
            catch (\Exception $e)
            {
                $response = [ 'error' =>['code' => 500, 'message' => $this->tableModel->error() ?? $e->getMessage()], 'success' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete()
    {

        //print_r($this->request->getRawInput()); exit;

        if ($this->request->isAJAX()) {

            $rawInput = $this->request->getRawInput('uuid');
            if(!is_array($rawInput['uuid']))
                return false; 

                $itsme = false;
                $comptePrincipal = false;
                $notAccesSuperUser = false;
                foreach ($rawInput['uuid'] as $uuid) {

                    $idUser = $this->tableModel->getIdUserByUUID($uuid);
        
                    // C'est moi
                    if ($idUser == user()->id) {
                        $itsme = true;
                        break;
                    }
        
                    // C'est le compte principal
                    if ($idUser == "1") {
                        $comptePrincipal = true;
                        break;
                    }
        
                    // si c'est un super user et que l'on est pas super user
                    if (inGroups(1, $idUser) &&  !inGroups(1, user()->id)) {
                        $notAccesSuperUser = true;
                        break;
                    }
        
                    $this->tableModel->deleteAllUser($idUser);
                }
                if ($itsme == true) {
                    $response = [ 'error' =>['code' => 500, 'message' => lang('Core.not_delete_propre_compte')], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200);
                } elseif ($comptePrincipal == true) {
                    $response = [ 'error' =>['code' => 500, 'message' => lang('Core.not_delete_principal_compte')], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200);
                } elseif ($notAccesSuperUser == true) {
                    $response = [ 'error' =>['code' => 500, 'message' => lang('Core.not_delete_superuser_compte')], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200);
                } else {
                    $response = [ 'success' =>['code' => 200, 'message' => lang('Core.your_selected_records_have_been_deleted')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respondDeleted($response);
                }
        
        }
        die(1);
       
    }

    public function getPassword()
    {
        if ($this->request->isAJAX())
        {
            helper('Tools');

            $throttler = \Config\Services::throttler();

            if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) 
            {
                $response = [ 'error' =>['code' => 429, 'message' =>  lang('Auth.tooManyRequests', [$throttler->getTokentime()])], 'success' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 429);
            }

            $response = [ 'success' =>['code' => 200, 'message' => lang('Core.Good!!'), 'password' => generer_mot_de_passe(15)], 'error' => false, csrf_token() => csrf_hash()];
            return $this->respond($response, 200, 'génération de mot de passe');
        }
    }

    public function savePermissions(){
        if ($this->request->isAJAX())
        {
            $value  = $this->request->getPost('value');
            $crud  = $this->request->getPost('crud');

            $this->permissionModel  = new \Adnduweb\Ci4Admin\Models\PermissionModel();
            $details = explode('|', $value);
            if ($crud == 'add') {
                $this->permissionModel->addPermissionToUser($details[1], $details[0]);
            } else {
                $this->permissionModel->removePermissionFromUser($details[1], $details[0]);
            }
            $response = [ 'success' =>['code' => 200, 'message' => lang('Core.data_save')], 'error' => false, csrf_token() => csrf_hash()];
            return $this->respond($response, 200, 'Save permissisons users');
        }
        die(1);
    }

    /***
     * ---------------------------------------------------------------
     * Class Protected User
     * ---------------------------------------------------------------
     */

    protected function getPermissionsListFilter(object $usersTemp){
         // C'est le compte principal
         if ($usersTemp->id == "1") {
            return [ 'error' =>['code' => 401, 'message' => lang('Core.notAuthorized')], 'success' => false, csrf_token() => csrf_hash()];
        }

        // C'est moi
        if ($usersTemp->id == user()->id) {
            return [ 'error' =>['code' => 401, 'message' => lang('Core.notAuthorized')], 'success' => false, csrf_token() => csrf_hash()];
        }

            // si c'est un super user et que l'on est pas super user
        if (inGroups(1, $usersTemp->id) &&  !inGroups(1, user()->id)) {
            return [ 'error' =>['code' => 401, 'message' => lang('Core.notAuthorized')], 'success' => false, csrf_token() => csrf_hash()];
        }

        return false;

    }

    protected function getPermissions($user_id = null){
        
        $permissionModel = new \Adnduweb\Ci4Admin\Models\PermissionModel();

        // On récupére les permissions du groupe ou des groupes
        foreach ($this->viewData['form']->auth_groups_users as $groups) {
            $permissionByIdGroupGroup       = $permissionModel->getPermissionsByIdGroup($groups->group_id);
            $this->viewData['permissionByIdGroupGroup'][$groups->group_id] = [];
            if (!empty($permissionByIdGroupGroup)) {
                foreach ($permissionByIdGroupGroup as $permissions) {
                    $this->viewData['permissionByIdGroupGroup'][$permissions->group_id][$permissions->permission_id] = $permissions->permission_id;
                }
            }
            $permissionByIdGroupGroupUser       = $permissionModel->permissionByIdGroupGroupUser($groups->group_id);
            $this->viewData['permissionByIdGroupGroupUser'][$groups->group_id] = [];
            if (!empty($permissionByIdGroupGroupUser)) {
                foreach ($permissionByIdGroupGroupUser as $permissions) {
                    $this->viewData['permissionByIdGroupGroupUser'][$groups->group_id][$permissions->permission_id] = $permissions->permission_id;
                }
            }
        }

        if(!is_null($user_id)){
             // on recupere la liste des dernières connexions au BO
            $this->viewData['getLastConnexions'] = $this->tableModel->getLastConnexions($user_id, 10);
            $this->viewData['getSessionsActive'] = $this->auth->getSessionActive($user_id);
        }

        // On récupérer les permissions
        $this->viewData['permissions']   = $permissionModel->getPermission();

        // Si je ne suis pas un super user et que je modifie mon compte
        if (!inGroups(1, user()->id) && user()->id == $this->viewData['form']->id) {
            foreach ($this->data['form']->auth_groups_users as $auth_groups_users) {
                $this->viewData['id_group'] = $auth_groups_users->group_id;
            }
        }
    }

    public function workCrudGroup($user)
    {
        $groupModel = new  \Adnduweb\Ci4Admin\Models\GroupModel();
        $user->groups =  $groupModel->getGroupsForUserLight($user->id);

        //it's me je suis sur mon compte
        if (user()->id == $user->id) {

            // Si je suis super admin et je dois rester super admin.
            $idGroupCurrent = array_flip($this->request->getPost('id_group'));
            $firstKey = array_key_first($user->groups);

            if (!isset($idGroupCurrent[$firstKey])) {
                return ['status' => 406, 'message' => lang('Core.not_change_group_principal')];
            }

            foreach ($user->groups as $k => $v) {
                if (!isset($idGroupCurrent[$k])) {
                    $groupModel->removeUserFromGroup($user->id, $k);
                }
            }

            foreach ($idGroupCurrent as $k => $v) {
                if (!isset($user->groups[$k])) {
                    $groupModel->addUserToGroup($user->id, $k);
                }
            }

        } else {

            //ce n'est pas moi
            $idGroupCurrent = array_flip($this->request->getPost('id_group'));
            $firstKey = array_key_first($user->groups);
            foreach ($user->groups as $k => $v) {
                if (!isset($idGroupCurrent[$k])) {
                    $groupModel->removeUserFromGroup($user->id, $k);
                }
            }
            foreach ($idGroupCurrent as $k => $v) {
                if (!isset($user->groups[$k])) {
                    $groupModel->addUserToGroup($user->id, $k);
                }
            }

        }
        return true;
    }

    protected function saveSettings(array $posts)
    {

        $setting_notification_email = (!isset($posts['setting_notification_email'])) ? false : true;
        $setting_notification_sms = (!isset($posts['setting_notification_sms'])) ? false : true;
        $setting_connexion_unique = (!isset($posts['setting_connexion_unique'])) ? false : true;
        cache()->delete(config('Cache')->cacheQueryString . "settings:contents:{$setting_notification_email}:{user()->id}");
        cache()->delete(config('Cache')->cacheQueryString . "settings:contents:{$setting_notification_sms}:{user()->id}");
        cache()->delete(config('Cache')->cacheQueryString . "settings:contents:{$setting_connexion_unique}:{user()->id}");
        service('Settings')->setting_notification_email = $setting_notification_email;
        service('Settings')->setting_notification_sms = $setting_notification_sms;
        service('Settings')->setting_connexion_unique = $setting_connexion_unique;
    }

}
