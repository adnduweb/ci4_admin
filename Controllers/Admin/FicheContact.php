<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\Company;
use Adnduweb\Ci4Admin\Models\CompanyModel;
use Adnduweb\Ci4Admin\Entities\User;
use Adnduweb\Ci4Admin\Models\UserModel;
use Adnduweb\Ci4Core\Models\CountryModel;
use Adnduweb\Ci4Core\Models\SettingModel;
use CodeIgniter\API\ResponseTrait;

class FicheContact extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    use ResponseTrait, \Adnduweb\Ci4Core\Traits\LibphoneTraits;

    /**
     * name controller
     */
    public $controller = 'fiche-contact';

     /**
     * Localize slug
     */
    public $pathcontroller  = '/';

    /**
     * name model
     */
    public $tableModel = CompanyModel::class;

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
        Theme::add_js('/resources/metronic/js/pages/custom/companies/outils.companies.js');

        parent::index();

        $this->viewData['aside_active'] = 'compte-entreprise';
        $this->viewData['company'] =  $this->tableModel->where([$this->tableModel->primaryKey => company()->{$this->tableModel->primaryKey}])->first();
        $this->viewData['company']->companyType = $this->tableModel->getCompanyType();
        $this->viewData['countries'] = (new CountryModel())->getAllCountry();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\fiche\index', $this->viewData);
    }


     /**
     * Update the specified resource in storage.
     */
    public function updateEntreprise()
    {
        $company_id = $this->tableModel->getIdCompanyByUUID($this->request->getPost('uuid_company'));
        parent::update($this->request->getPost('uuid_company'));

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
        return $this->_redirect('/compte-entreprise');

    }



    /**
     * Display a listing of the resource.
     *
     */

    public function indexPersonnel()
    {

        Theme::add_js('/resources/metronic/js/pages/custom/users/outils.users.js');

        parent::index();
        helper('tools');

        $this->viewData['aside_active'] = 'compte-personnel';
        $this->viewData['action'] = 'edit';
        $this->viewData['form'] = (new UserModel())->where([$this->tableModel->primaryKeyLang => user()->company_id, 'is_principal' => true])->first();
        // Si je ne suis pas un super user et que je modifie mon compte

        foreach ($this->viewData['form']->auth_groups_users as $auth_groups_users) {
            $this->viewData['id_group'] = $auth_groups_users->group_id;
        }

        $this->viewData['company'] = $this->viewData['form']->company =  $this->tableModel->where([$this->tableModel->primaryKey => company()->id])->first();
        $this->viewData['groups'] = (new UserModel())->getGroups();

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\fiche\index', $this->viewData);

    }


     /**
     * Update the specified resource in storage.
     */
    public function updatePersonnel()
    {
        $users = new UserModel();

        $user_id = $users->getIdUserByUUID($this->request->getPost('uuid'));

        parent::update($this->request->getPost('uuid'));

        

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

        //Save
        try {

            $users->save($user);

        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();

        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/compte-personnel');

    }


 /**
     * Display a listing of the resource.
     *
     */

    public function indexResauxSociaux()
    {

        parent::index();

        $this->viewData['aside_active'] = 'reseaux-sociaux';
        $this->viewData['action'] = 'edit';
        $this->viewData['form'] = (new UserModel())->where([$this->tableModel->primaryKeyLang => user()->company_id, 'is_principal' => true])->first();
        $this->viewData['company'] = $this->viewData['form']->company = $this->tableModel->where([$this->tableModel->primaryKey => company()->id])->first();


        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\fiche\index', $this->viewData);

    }


    public function updateResauxSociaux()
    {
        // print_r($_POST);
        // exit;
        if ($this->request->getPost('global')) {

            $global = $this->request->getPost('global');
            foreach ($global as $k => $v) {
                if (is_array($v)) {
                    $v = serialize($v);
                }
                cache()->delete('settings:templates:{$k}');
                (new SettingModel())->getExist($k, 'global', $v);
                service('settings')->{$k} = $v;
            }
        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return redirect()->back();
    }

    public function getPassword()
    {
        if ($this->request->isAJAX())
        {
            helper('tools');

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
}
