<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\Permission;
use Adnduweb\Ci4Admin\Models\PermissionModel;
use CodeIgniter\API\ResponseTrait;

class Permissions extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
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
    public $controller = 'permissions';

        /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced';

    /**
     * name model
     */
    public $tableModel = PermissionModel::class;

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
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //Theme::add_js(['/admin/themes/'. $this->settings->setting_theme_admin . '/assets/js/pages/custom/'.$this->dirList.'/page.list.'.$this->dirList.'.js']);
        Theme::add_js('/resources/metronic/js/pages/custom/permissions/page.list.permissions.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\permissions\index', $this->viewData);
    }

    public function ajaxProcessList()
    {
        $parent = parent::ajaxProcessList();
        return $this->respond($parent, 200, lang('Core.liste des permissions'));
    }


    /**
     * Create ressource
     */
    public function create()
    {
        helper('Tools');
        parent::create();

        // Initialize form
        $this->viewData['form'] = new Permission();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\permissions\form', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        // validate
        $permissions = new PermissionModel();
        $this->rules = [
            'name'              => 'required',
            'description'     => 'required',
        ];
        if (!$this->validate($this->rules)) {
            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        $name = $this->request->getPost('name');
        if (!stristr($this->request->getPost('name'), '::')) {
           Theme::set_message('danger', lang('Core.mauvais_formattage_name'), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the user
        $permission = new Permission($this->request->getPost());

         //Save
         try {

            $permissions->save($permission);
            $permissionId = $permissions->insertID();

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

         // Success!
         Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
         return $this->_redirect('/edit/' .$permissionId);

    }



    
    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        parent::edit($id);

        helper(['Tools']);

        // Initialize form
        $this->viewData['form'] = $this->tableModel->where(['id' => $this->id])->first();
        $this->viewData['title_detail'] = $this->viewData['form']->name  . ' - ' . $this->viewData['form']->description;

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\permissions\form', $this->viewData);

    }

     /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        parent::update($id);

        // validate
        $permissions = new PermissionModel();
        $this->rules = [
            'name'              => 'required',
            'description'     => 'required',
        ];
        if (!$this->validate($this->rules)) {
            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        $name = $this->request->getPost('name');
        if (!stristr($this->request->getPost('name'), '::')) {
           Theme::set_message('danger', lang('Core.mauvais_formattage_name'), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the user
        $permission = new Permission($this->request->getPost());

         //Save
         try {

            $permissions->save($permission);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

         // Success!
         Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
         return $this->_redirect('/edit/' .$permission->id);

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
                $isNatif = false;
                foreach ($rawInput['id'] as $key => $id) {

                    $isNatif = PermissionModel::getNatifById($id);

                    if($isNatif == '1'){
                        $isNatif = true;
                        break;
                    }

                    $this->tableModel->delete(['id' => $id]);
                }

                if ($isNatif == true) {
                    $response = [ 'error' =>['code' => 500, 'message' => lang('Core.not_delete_perm_natif')], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200);
                } else {
                    $response = [ 'success' =>['code' => 200, 'message' => lang('Core.your_selected_records_have_been_deleted')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respondDeleted($response);
                }
        
        }
        die(1);
       
    }

}
