<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\Group;
use Adnduweb\Ci4Admin\Models\GroupModel;
use CodeIgniter\API\ResponseTrait;

class Groups extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

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
    public $controller = 'groups';

        /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced';

    /**
     * name model
     */
    public $tableModel = GroupModel::class;

    /**
     * Attachement company
     */
    public $fieldIdcompany = false;

    /** 
     * Display default list column
     */
    public $fieldList = 'name';

    /**
    *  Bool Update
    */
   public $toolbarUpdate = false;

    /**
     * Array id not deleted
     */
    public $groupIdRestriction = [1, 2, 3];


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $this->viewData['paramJs']['restrictionItem'] = implode('|', $this->groupIdRestriction);
        //Theme::add_js(['/admin/themes/'. $this->settings->setting_theme_admin . '/assets/js/pages/custom/'.$this->dirList.'/page.list.'.$this->dirList.'.js']);
        Theme::add_js('/resources/metronic/js/pages/custom/groups/page.list.groups.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\groups\index', $this->viewData);
    }

    public function ajaxProcessList()
    {
        $parent = parent::ajaxProcessList();
        return $this->respond($parent, 200, lang('Core.liste des roles'));
    }


    /**
     * Create ressource
     */
    public function create()
    {
        helper('tools');
        parent::create();

        // Initialize form
        $this->viewData['form'] = new Group();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\groups\form', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        // validate
        $groups = new GroupModel();
        $this->rules = [
            'name'              => 'required',
            'description'     => 'required',
        ];
        if (!$this->validate($this->rules)) {
            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the user
        $group = new Group($this->request->getPost());

         //Save
         try {

            $groups->save($group);
            $groupId = $groups->insertID();

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

         // Success!
         Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
         return $this->_redirect('/edit/' .$groupId);

    }



    
    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        parent::edit($id);

        helper(['tools']);

        Theme::add_js(
            [
                '/resources/metronic/js/pages/custom/groups/permission.groups.js'
            ]
        );

        // Initialize form
        $this->viewData['form'] = $this->tableModel->where(['id' => $this->id])->first();
        $this->viewData['title_detail'] = $this->viewData['form']->name  . ' : ' . $this->viewData['form']->description;

         // Super Admin Whououuuu
         if ($id == '1') {
            $this->viewData['permissions'] = '';
        } else {
             //Get Permissions Group
            $permissionModel               = new \Adnduweb\Ci4Admin\Models\PermissionModel();
            $permissionByIdGroupGroup       = $permissionModel->getPermissionsByIdGroup($id);
            $this->viewData['permissionByIdGroupGroup'] = [];
            if (!empty($permissionByIdGroupGroup)) {
                foreach ($permissionByIdGroupGroup as $permissions) {
                    $this->viewData['permissionByIdGroupGroup'][$permissions->group_id][$permissions->permission_id] = $permissions->permission_id;
                }
            }
            $this->viewData['permissions'] = $permissionModel->getPermission();
        }

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\groups\form', $this->viewData);

    }

     /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        parent::update($id);

        // validate
        $groups = new GroupModel();
        $this->rules = [
            'name'              => 'required',
            'description'     => 'required',
        ];
        if (!$this->validate($this->rules)) {
            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the user
        $group = new Group($this->request->getPost());

         //Save
         try {

            $groups->save($group);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

         // Success!
         Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
         return $this->_redirect('/edit/' .$group->id);

    }

  /**
     * Remove the specified resource from storage.
     */
    public function delete()
    {

        if ($this->request->isAJAX()) {

            $rawInput = $this->request->getRawInput('id');
            if(!is_array($rawInput['id']))
                return false; 

                //print_r($rawInput['id']); exit;
                $comptePrincipal = false;
                foreach ($rawInput['id'] as $key => $id) {

                    if(in_array($id, $this->groupIdRestriction)){
                        $comptePrincipal = true;
                        break;
                    }

                    $this->tableModel->delete(['id' => $id]);
                }

                if ($comptePrincipal == true) {
                    $response = [ 'error' =>['code' => 500, 'message' => lang('Core.not_delete_principal_compte')], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200);
                } else {
                    $response = [ 'success' =>['code' => 200, 'message' => lang('Core.your_selected_records_have_been_deleted')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respondDeleted($response);
                }
        
        }
        die(1);
       
    }

    public function savePermissions()
    {
        if ($this->request->isAJAX()) 
        {
            
            if ($value = $this->request->getPost('value'))
             {
                $details = explode('|', $value);
                if ($this->request->getPost('crud') == 'add') 
                {
                    $this->tableModel->addPermissionToGroup($details[1], $details[0]);

                } 
                else 
                {
                    $this->tableModel->removePermissionFromGroup($details[1], $details[0]);
                }

                $response = [ 'success' =>['code' => 200, 'message' => lang('Core.saved_data')], 'error' => false, csrf_token() => csrf_hash()];
                return $this->respondDeleted($response);
            }
        }
    }

    public function saveAllPermissions()
    {
        if ($this->request->isAJAX()) {
            if ($value = $this->request->getPost('value')) {
                if ($this->request->getPost('crud') == 'add') {
                    $add = false;
                    foreach ($value as $val) {
                        $details = explode('|', $val);
                        $this->tableModel->addPermissionToGroup($details[1], $details[0]);
                        if (!isset($this->tableModel->resultID->num_rows)) {
                            $add = true;
                        }
                        //print_r( $this->tableModel->resultID); exit;
                    }
                    if ($add == true) {
                        $response = [ 'success' =>['code' => 200, 'message' => lang('Core.saved_data')], 'error' => false, csrf_token() => csrf_hash()];
                        return $this->respondDeleted($response);
                    }
                } else {
                    foreach ($value as $val) {
                        $details = explode('|', $val);
                        $this->tableModel->removePermissionFromGroup($details[1], $details[0]);
                    }
                    $response = [ 'success' =>['code' => 200, 'message' => lang('Core.saved_data')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respondDeleted($response);
                }
            }
        }
    }

}
