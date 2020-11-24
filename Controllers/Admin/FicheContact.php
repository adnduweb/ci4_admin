
<?php


namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\Company;
use Adnduweb\Ci4Admin\Models\CompanyModel;
use App\Entities\User;
use App\Models\UserModel;
use Adnduweb\Ci4Core\Models\CountryModel;
use CodeIgniter\API\ResponseTrait;

class FicheContactController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    use ResponseTrait;

    /**
     *  uuidUser Object
     */
    protected $uuidCompany;

    /**
     *  uuidUser Object
     */
    protected $uuidUser;

    /**
     *  Module Object
     */
    public $module = false;

    /**
     * name controller
     */
    public $controller = 'fiche';

    /**
     * Localize slug
     */
    public $pathcontroller  = '/fiche-contact';

    /**
     * Display Multilangue
     */
    public $multilangue = false;

    /**
     * Event fake data
     */
    public $fake = false;

    /**
     * Update item List
     */
    public $toolbarUpdate = false;

    /**
     * @var \App\Models\FormModel
     */
    public $tableModel;



    public function __construct()
    {
        parent::__construct();
        $this->tableModel  = new CompanyModel();
        $this->tableUserModel  = new UserModel();
        $this->tableSettingsModel  = new SettingModel();
    }

    public function getCompteEntreprise()
    {
        if (!has_permission(ucfirst($this->controller) . '::views', user()->id)) {
            Tools::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
            return redirect()->to('/' . CI_SITE_AREA . '/dashboard');
        }
        AssetsBO::add_js([$this->get_current_theme_view('controllers/company/js/outils.js', 'default')]);
        $this->data['aside_active'] = 'compte-entreprise';
        $this->data['company'] =  $this->tableModel->where([$this->tableModel->primaryKey => company()->{$this->tableModel->primaryKey}])->first();
        $this->data['company']->companyType = $this->tableModel->getCompanyType();
        $this->data['countries'] = (new CountryModel())->getAllCountry();

        return view($this->get_current_theme_view('controllers/' . $this->controller . '/index', 'default'), $this->data);
    }

    public function getComptePersonnel()
    {
        if (!has_permission(ucfirst($this->controller) . '::views', user()->id)) {
            Tools::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
            return redirect()->to('/' . CI_SITE_AREA . '/dashboard');
        }
        AssetsBO::add_js([$this->get_current_theme_view('controllers/users/js/outils.js', 'default')]);
        $this->data['aside_active'] = 'compte-personnel';
        $this->data['action'] = 'edit';
        $this->data['form'] = $this->tableUserModel->where([$this->tableModel->primaryKeyLang => user()->company_id, 'is_principal' => true])->first();
        // Si je ne suis pas un super user et que je modifie mon compte

        foreach ($this->data['form']->auth_groups_users as $auth_groups_users) {
            $this->data['id_group'] = $auth_groups_users->group_id;
        }

        $this->data['company'] = $this->data['form']->company =  $this->tableModel->where([$this->tableModel->primaryKey => company()->id])->first();
        $this->data['groups'] = $this->tableUserModel->getGroups();


        return view($this->get_current_theme_view('controllers/' . $this->controller . '/index', 'default'), $this->data);
    }

    public function postProcessEditEntreprise()
    {
        // Je recupére l'id Company
        $this->uuidCompany =  $this->request->getPost('uuid_company');
        $uuidCompany = $this->getIdCompanyByUUID();
        //echo $uuidCompany;

        // validate
        $companyList = new CompanyModel();
        $rules = [
            'raison_social' => 'required|is_unique[companies.raison_social,id,' . $uuidCompany . ']',
        ];
        // print_r($rules);
        // exit;
        if (!$this->validate($rules)) {
            Tools::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the Company
        $company = new Company($this->request->getPost());
        $this->lang = $this->request->getPost('lang');

        // Format Phone
        if (!empty($company->full_phone_fixe)) {
            $phoneInternationalPhone = Tools::phoneInternational($company->full_phone_fixe);
            if ($phoneInternationalPhone['status'] == 200) {
                $company->telephone_fixe = $phoneInternationalPhone['message'];
            } else {
                Tools::set_message('danger', lang('Core.' . $phoneInternationalPhone['message'] . ': phone'), lang('Core.warning_error'));
                return redirect()->back()->withInput();
            }
        }
        if (!empty($company->full_phone_mobile)) {
            //print_r($company); exit;
            $phoneInternationalPhone = Tools::phoneInternational($company->full_phone_mobile);
            if ($phoneInternationalPhone['status'] == 200) {
                $company->telephone_mobile = $phoneInternationalPhone['message'];
            } else {
                Tools::set_message('danger', lang('Core.' . $phoneInternationalPhone['message'] . ': phone'), lang('Core.warning_error'));
                return redirect()->back()->withInput();
            }
        }

        $company->id = $uuidCompany;

        // On sauvegarde
        if (!$companyList->save($company)) {
            Tools::set_message('danger', $companyList->errors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }
        $company->saveLang($this->lang, $company->id);

        // On regenere le cache
        cache()->delete('front:getCompany');

        Tools::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return redirect()->back();
    }

    public function postProcessEditPersonnel()
    {

        // Je recupére l'id user
        $this->uuidUser = $this->request->getPost('uuid');
        $idUser = $this->getIdUserByUUID();

        // validate
        $users = new UserModel();
        $rules = [
            'email'    => 'required|valid_email|is_unique[users.email,id,' . $idUser . ']',
            'id_group' => 'required',
        ];
        if (!$this->validate($rules)) {
            Tools::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
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
                Tools::set_message('danger', lang('Core.not_concordance_mote_de_passe'), lang('Core.warning_error'));
                return redirect()->back()->withInput();
            }
        }

        // Format Phone
        $phoneInternationalMobile = Tools::phoneInternational($user->full_phone_mobile);
        if ($phoneInternationalMobile['status'] == 200) {
            $user->phone_mobile = $phoneInternationalMobile['message'];
        } else {
            Tools::set_message('danger', lang('Core.' . $phoneInternationalMobile['message'] . ': mobile'), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }
        if (!empty($user->full_phone)) {
            $phoneInternationalPhone = Tools::phoneInternational($user->full_phone);
            if ($phoneInternationalPhone['status'] == 200) {
                $user->phone = $phoneInternationalPhone['message'];
            } else {
                Tools::set_message('danger', lang('Core.' . $phoneInternationalPhone['message'] . ': phone'), lang('Core.warning_error'));
                return redirect()->back()->withInput();
            }
        }
        $user->id = $idUser;
        $user->force_pass_reset = ($user->force_pass_reset == '1') ? $user->force_pass_reset : '0';

        // On sauvegarde
        if (!$users->save($user)) {
            Tools::set_message('danger', $users->errors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Success!
        Tools::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return redirect()->back();
    }

    public function getResauxSociaux()
    {
        if (!has_permission(ucfirst($this->controller) . '::views', user()->id)) {
            Tools::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
            return redirect()->to('/' . CI_SITE_AREA . '/dashboard');
        }
        $this->data['aside_active'] = 'reseaux-sociaux';
        $this->data['action'] = 'edit';
        $this->data['form'] =  $this->tableUserModel->where([$this->tableModel->primaryKeyLang => user()->company_id, 'is_principal' => true])->first();
        $this->data['company'] = $this->data['form']->company = $this->tableModel->where([$this->tableModel->primaryKey => company()->id])->first();

        return view($this->get_current_theme_view('controllers/' . $this->controller . '/index', 'default'), $this->data);
    }

    public function postProcessEditReseauxSociaux()
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
                $this->tableSettingsModel->getExist($k, 'global', $v);
                service('settings')->{$k} = $v;
            }
        }

        // Success!
        Tools::set_message('success', lang('Core.save_data'), lang('Core.cool_success'));
        return redirect()->back();
    }
}
