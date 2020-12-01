<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\Company;
use Adnduweb\Ci4Admin\Models\CompanyModel;
use Adnduweb\Ci4Core\Models\CountryModel;
use CodeIgniter\API\ResponseTrait;

class Companies extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait,  \Adnduweb\Ci4Core\Traits\LibphoneTraits;

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
    public $controller = 'companies';

        /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced';

    /**
     * name model
     */
    public $tableModel = CompanyModel::class;

    /**
     * Attachement company
     */
    public $fieldIdcompany = false;

    /** 
     * Display default list column
     */
    public $fieldList = 'raison_social';

    /**
     * Array id not deleted
     */
    public $groupIdRestriction = [1];


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //Theme::add_js(['/admin/themes/'. $this->settings->setting_theme_admin . '/assets/js/pages/custom/'.$this->dirList.'/page.list.'.$this->dirList.'.js']);
        $this->viewData['paramJs']['restrictionItem'] = implode('|', $this->groupIdRestriction);
        Theme::add_js('/resources/metronic/js/pages/custom/companies/page.list.companies.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\companies\index', $this->viewData);
    }

    /**
     * Display a listing of the resource in Ajax.
     *
     */
    public function ajaxProcessList()
    {
        parent::ajaxProcessList();
        return $this->respond($this->listDatatable, 200, 'Display companies');
    }

    /**
     * Create ressource
     */
    public function create()
    {
        helper('tools');
        parent::create();

        Theme::add_js(
            [
                '/resources/metronic/js/pages/custom/companies/outils.companies.js'
            ]
        );

       // Initialize form
        $this->viewData['form'] = new Company();

        // List of company Type
        $this->viewData['form']->companyType = $this->tableModel->getCompanyType();

        // List of country
        $this->viewData['countries'] = (new CountryModel())->getAllCountry();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\companies\form', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
      
        $companies = new CompanyModel();

        $this->rules = [
            'raison_social' => 'required|is_unique[companies.raison_social,id,' . $this->request->getPost($this->tableModel->primaryKey) . ']',
            'email'    => 'required|valid_email',
        ];

        if (!$this->validate($this->rules)) {

            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Try to create the user
        $company = new Company($this->request->getPost());

        // Format Phone
        if(($response =  $this->sanitizePhone($company)) == true){
            Theme::set_message('danger', $response['error']['message'], lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }
               
        $company->active = 1;
        $company->uuid_company = $this->uuid->uuid4()->toString();

        //Save
        try {

            $companies->save($company);
            $company_id = $companies->insertID();
            $this->lang = $this->request->getPost('lang');
            $company->saveLang($this->lang, $company_id);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' .$company->uuid_company);
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

        helper(['form', 'tools', 'time']);

        Theme::add_js(
            [
                '/resources/metronic/js/pages/custom/companies/outils.companies.js'
            ]
        );

        // Initialize form
        $this->viewData['form'] = $this->tableModel->where(['uuid_company' => $this->id])->first();
        $this->viewData['title_detail'] = $this->viewData['form']->raison_social ;

        // List of company Type
        $this->viewData['form']->companyType = $this->tableModel->getCompanyType();

        // List of country
        $this->viewData['countries'] = (new CountryModel())->getAllCountry();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\companies\form', $this->viewData);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $uuid)
    {
        $company_id = $this->tableModel->getIdCompanyByUUID($uuid);

        parent::update($uuid);

        $companies = new CompanyModel();

        $this->rules = [
            'raison_social' => 'required|is_unique[companies.raison_social,id,' . $company_id . ']',
            'email'    => 'required|valid_email',
        ];

        if (!$this->validate($this->rules)) {

            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Try to create the user
        $company = new Company($this->request->getPost());
        $this->lang = $this->request->getPost('lang');

        // Format Phone
        if(($response =  $this->sanitizePhone($company)) == true){
            Theme::set_message('danger', $response['error']['message'], lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }
        
        $company->id = $company_id;

       //Save
        try {

            $companies->save($company);
            $company->saveLang($this->lang, $company->id);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' .$company->uuid_company);


    }

    /**
     * Update the specified resource in storage.
     */
    public function ajaxUpdate($params = null)
    {
        if ($this->request->isAJAX()) {

            $companies = [];
            $i = 0;

            $comptePrincipal = false;
            foreach($this->request->getPost('value') as $master => $array){
                if(is_array($array)){
                    foreach ($array as $key => $value) {

                        if ($key == 'uuid_company') {
                            $companyObject = $this->tableModel->getCompanyByUUID($value, true);
                        }
                        //print_r($companiesTemp); exit;
                        $companyObject->{$key} =  $value;
                        $companies['uuid_company'] = $companyObject;

                        if ($key == 'active') {
                            if(($response = $this->getPermissionsListFilter($companyObject)) == true){
                                return $this->respond($response, 401, 'Update company');
                           }
                        }


                        $i++;
                    }
                }else
                 throw new \Exception("Some message goes here");
            }


            try{

                if ($comptePrincipal == true) {
                    $response = [ 'error' =>['code' => 500, 'message' => lang('Core.not_update_principal_compte')], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200);
                }  else {
                    $this->tableModel->updateBatch($companies, 'uuid_company');
                    $response = [ 'success' =>['code' => 200, 'message' => lang('Core.success_update')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200, 'Update companies');
                }
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

            $rawInput = $this->request->getRawInput('uuid_company');
            if(!is_array($rawInput['uuid_company']))
                return false; 

                $comptePrincipal = false;
                foreach ($rawInput['uuid_company'] as $uuid_company) {

                   $companyObject = $this->tableModel->getCompanyByUUID($uuid_company);
        
                   if(($response = $this->getPermissionsListFilter($companyObject)) == true){
                        return $this->respond($response, 401, 'Update company');
                   }
        
                    $this->tableModel->deleteAllCompany($companyObject->id);
                }
               if ($comptePrincipal == true) {
                    $response = [ 'error' =>['code' => 500, 'message' => lang('Core.not_delete_principal_compte')], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200);
                }  else {
                    $response = [ 'success' =>['code' => 200, 'message' => lang('Core.your_selected_records_have_been_deleted')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respondDeleted($response);
                }
        
        }
        die(1);
       
    }

    /***
     * ---------------------------------------------------------------
     * Class Protected User
     * ---------------------------------------------------------------
     */

    protected function getPermissionsListFilter(object $object){
        // C'est le compte principal
        if(in_array($object->id, $this->groupIdRestriction)){
           return [ 'error' =>['code' => 401, 'message' => lang('Core.notAuthorized')], 'success' => false, csrf_token() => csrf_hash()];
       }

       return false;

   }

}
