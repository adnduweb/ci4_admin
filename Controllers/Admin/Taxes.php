<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Core\Entities\Taxe;
use Adnduweb\Ci4Core\Models\TaxeModel;
use CodeIgniter\API\ResponseTrait;

class Taxes extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

    /**
     * name controller
     */
    public $controller = 'taxes';

    /**
     * Localize slug
     */
    public $pathcontroller  = '/international';

    /**
     * name model
     */
    public $tableModel = TaxeModel::class;

    /**
     * Attachement company
     */
    public $fieldIdcompany = false;

    /** 
     * Display default list column
     */
    public $fieldList = 'name';

        /**
     * Array id not deleted
     */
    public $groupIdRestriction = [];


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //Theme::add_js(['/admin/themes/'. $this->settings->setting_theme_admin . '/assets/js/pages/custom/'.$this->dirList.'/page.list.'.$this->dirList.'.js']);
        $this->viewData['paramJs']['restrictionItem'] = implode('|', $this->groupIdRestriction);
        Theme::add_js('/resources/metronic/js/pages/custom/taxes/page.list.taxes.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\taxes\index', $this->viewData);
    }

    /**
     * Display a listing of the resource in Ajax.
     *
     */
    public function ajaxProcessList()
    {
        $parent = parent::ajaxProcessList();
        return $this->respond($parent, 200, lang('Core.list of taxes'));
    }


/**
     * Create ressource
     */
    public function create()
    {
        helper('tools');
        parent::create();

       // Initialize form
        $this->viewData['form'] = new Taxe($this->request->getPost());

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\taxes\form', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
      
        $taxe = new TaxeModel();

        $this->rules = [
            'rate' => 'required',
        ];

        if (!$this->validate($this->rules)) {

            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Try to create the user
        $taxeBase = new Taxe($this->request->getPost());

        //Save
        try {

            $taxe->save($taxeBase);
            $taxeBaseId = $taxe->insertID();
            $this->lang = $this->request->getPost('lang');
            $taxeBase->saveLang($this->lang, $taxeBaseId);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' .$taxeBaseId);
    }


     /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        parent::edit($id);

        // Initialize form
        $this->viewData['form'] = $this->tableModel->where($this->tableModel->primaryKey, $id)->first();
        $this->viewData['title_detail'] = $this->viewData['form']->name ;

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\taxes\form', $this->viewData);

    }

     /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        parent::update($id);

        $taxe = new TaxeModel();

        $this->rules = [
            'rate' => 'required',
        ];

        if (!$this->validate($this->rules)) {

            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Try to create the user
        $taxeBase = new Taxe($this->request->getPost());
        $this->lang = $this->request->getPost('lang');

       //Save
        try {

            $taxe->save($taxeBase);
            $taxeBase->saveLang($this->lang, $taxeBase->id);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' .$taxeBase->id);


    }

      /**
     * Update the specified resource in storage.
     */
    public function ajaxUpdate($params = null)
    {
        if ($this->request->isAJAX()) {

            $taxes = [];
            $i = 0;

            $comptePrincipal = false;
            foreach ($this->request->getPost('value') as $master => $array) {
                if (is_array($array)) {
                    foreach ($array as $key => $value) {

                        if ($key == 'id') {
                            $taxeObject = $this->tableModel->find($value);
                        }

                        $taxeObject->{$key} =  $value;
                        $taxes[$taxeObject->id] = $taxeObject;

                        $i++;
                    }
                } else
                    throw new \Exception("Some message goes here");
            }


            try {

                $this->tableModel->updateBatch($taxes, 'id');
                $response = ['success' => ['code' => 200, 'message' => lang('Core.success_update')], 'error' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 200, 'Update taxes');
                
            } catch (\Exception $e) {
                $response = ['error' => ['code' => 500, 'message' => $this->tableModel->error() ?? $e->getMessage()], 'success' => false, csrf_token() => csrf_hash()];
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

            $rawInput = $this->request->getRawInput('id');
            if (!is_array($rawInput['id']))
                return false;

            $comptePrincipal = false;
            foreach ($rawInput['id'] as $id) {

                if(in_array($id, $this->groupIdRestriction)){
                    $comptePrincipal = true;
                    break;
                }
                $this->tableModel->delete($id);
            }
            if ($comptePrincipal == true) {
                $response = ['error' => ['code' => 500, 'message' => lang('Core.not_delete_principal_compte')], 'success' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 200);
            } else {
                $response = ['success' => ['code' => 200, 'message' => lang('Core.your_selected_records_have_been_deleted')], 'error' => false, csrf_token() => csrf_hash()];
                return $this->respondDeleted($response);
            }
        }
        die(1);
    }

}
