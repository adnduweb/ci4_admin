<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Core\Entities\Currency;
use Adnduweb\Ci4Core\Models\CurrencyModel;
use CodeIgniter\API\ResponseTrait;

class Currencies extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;


    /**
     * name controller
     */
    public $controller = 'currencies';

    /**
     * Localize slug
     */
    public $pathcontroller  = '/international';

    /**
     * name model
     */
    public $tableModel = CurrencyModel::class;

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
    public $groupIdRestriction = [1, 2];



    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //Theme::add_js(['/admin/themes/'. $this->settings->setting_theme_admin . '/assets/js/pages/custom/'.$this->dirList.'/page.list.'.$this->dirList.'.js']);
        $this->viewData['paramJs']['restrictionItem'] = implode('|', $this->groupIdRestriction);
        Theme::add_js('/resources/metronic/js/pages/custom/currencies/page.list.currencies.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\currencies\index', $this->viewData);
    }

    /**
     * Display a listing of the resource in Ajax.
     *
     */
    public function ajaxProcessList()
    {
        $parent = parent::ajaxProcessList();
        return $this->respond($parent, 200, lang('Core.list of currencies'));
    }

    /**
     * Create ressource
     */
    public function create()
    {
        helper('tools');
        parent::create();

       // Initialize form
        $this->viewData['form'] = new Currency();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\currencies\form', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
      
        $currency = new currencyModel();

        $this->rules = [
            'name'            => 'required|is_unique[currencies.name,id,' . $this->request->getPost('id') . ']',
            'iso_code'        => 'max_length[255]',
            'conversion_rate' => 'required',
        ];

        if (!$this->validate($this->rules)) {

            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Try to create the user
        $currencyBase = new Currency($this->request->getPost());

        //Save
        try {

            $currency->save($currencyBase);
            $currencyBaseId = $currency->insertID();

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' .$currencyBaseId);
    }



    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        parent::edit($id);

        // Initialize form
        $this->viewData['form'] =  $this->tableModel->where('id', $id)->first();
        $this->viewData['title_detail'] = $this->viewData['form']->name ;

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\currencies\form', $this->viewData);

    }

     /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        parent::update($id);

        $currency = new currencyModel();

        $this->rules = [
            'name'            => 'required|is_unique[currencies.name,id,' . $this->request->getPost('id') . ']',
            'iso_code'        => 'max_length[255]',
            'conversion_rate' => 'required',
        ];

        if (!$this->validate($this->rules)) {

            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Try to create the user
        $currencyBase = new Currency($this->request->getPost());

       //Save
        try {

            $currency->save($currencyBase);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' .$currencyBase->id);


    }


    /**
     * Update the specified resource in storage.
     */
    public function ajaxUpdate($params = null)
    {
        if ($this->request->isAJAX()) {

            $currencies = [];
            $i = 0;

            $comptePrincipal = false;
            foreach ($this->request->getPost('value') as $master => $array) {
                if (is_array($array)) {
                    foreach ($array as $key => $value) {

                        if ($key == 'id') {
                            $currencyObject = $this->tableModel->find($value);
                        }

                        $currencyObject->{$key} =  $value;
                        $currencies[$currencyObject->id] = $currencyObject;

                        $i++;
                    }
                } else
                    throw new \Exception("Some message goes here");
            }


            try {

                $this->tableModel->updateBatch($currencies, 'id');
                $response = ['success' => ['code' => 200, 'message' => lang('Core.success_update')], 'error' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 200, 'Update currencies');
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


    /**
     * get Currency API
     */
    public function ajaxProcessUpdateCurrencyrate()
    {
        if ($this->request->isAJAX()) {

            $throttler = \Config\Services::throttler();

            if ($throttler->check($this->request->getIPAddress() . ':' . user()->id . ':currency', 2, MINUTE) === false) {
                $response = ['error' => ['code' => 429, 'message' =>  lang('Auth.tooManyRequests', [$throttler->getTokentime()])], 'success' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 429);
            }

            if (Service('currency')->save()) {
                $response = ['success' => ['code' => 200, 'message' => lang('Core.sccess_update_currency_rate')], 'error' => false, csrf_token() => csrf_hash()];
                return $this->respond($response, 200, 'Save currencies API');
            } else {
                return $this->respond(['status' => false, 'database' => true, 'display' => 'modal', 'message' => lang('Js.aucun_enregistrement_effectue')], 200);
            }
        }
    }
}


// d98138f2-271c-4975-87d4-85945bc11c2f
