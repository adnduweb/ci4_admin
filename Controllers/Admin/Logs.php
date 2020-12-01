<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use App\Models\UserModel;
use Adnduweb\Ci4Core\Models\AuditModel;
use Adnduweb\Ci4Core\Models\LogModel;
use CodeIgniter\API\ResponseTrait;

class Logs extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
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
    public $controller = 'logs';

        /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced';

    /**
     * name model
     */
    public $tableModel = AuditModel::class;

    /**
     * Attachement company
     */
    public $fieldIdcompany = false;

    /**
     * Update Listing
     */
    public $toolbarUpdate = false;

    /** 
     * Display default list column
     */
    public $fieldList = 'created_at';


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        Theme::add_js('/resources/metronic/js/pages/custom/logs/page.list.logs.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\logs\index', $this->viewData);
    }


   /**
     * Display a listing of the resource in Ajax.
     *
     */
    public function ajaxProcessList()
    {
        parent::ajaxProcessList();
        return $this->respond($this->listDatatable, 200, 'Display logs');
    }

    public function delete()
    {
        $rawInput = $this->request->getRawInput('uuid');
        if ($this->request->isAJAX()) {

            if ($ids = $rawInput['id']) 
            {
                if (!empty($ids)) 
                {
                    foreach ($ids as $id) 
                    {
                        $this->tableModel->delete($id);
                    }
                    $response = [ 'success' =>['code' => 200, 'message' => lang('Core.your_selected_records_have_been_deleted')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respondDeleted($response);
                }
            }
           
        }
        die(1);
    }


    /**
     * Display a listing of the resource.
     *
     */
    public function indexTraffic()
    {
        Theme::add_js('/resources/metronic/js/pages/custom/logs/page.list.traffics.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\logs\traffic', $this->viewData);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function indexConnexions()
    {
        Theme::add_js('/resources/metronic/js/pages/custom/logs/page.list.connexions.js');

        parent::index();

        $this->viewData['countList'] = $this->tableModel->getAllCount(['field' => $this->fieldList, 'sort' => 'ASC'], [], $this->tableModel->searchKtDatatable);

        return $this->_render('Adnduweb\Ci4Admin\themes\/'. $this->settings->setting_theme_admin.'/\templates\logs\connexions', $this->viewData);
    }


    public function deleteConnexions()
    {
        $rawInput = $this->request->getRawInput('uuid');
        if ($this->request->isAJAX()) {

            if ($ids = $rawInput['id']) 
            {
                if (!empty($ids)) 
                {
                    foreach ($ids as $id) 
                    {
                        (new LogModel())->deleteConnexions($id);
                    }
                    $response = [ 'success' =>['code' => 200, 'message' => lang('Core.your_selected_records_have_been_deleted')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respondDeleted($response);
                }
            }
           
        }
        die(1);
    }
}
