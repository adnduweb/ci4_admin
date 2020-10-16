<?php
namespace Adnduweb\Admin\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Psr\Log\LoggerInterface;
use CodeIgniter\Security\Exceptions\SecurityException;
use CodeIgniter\Router\Exceptions\RedirectException;

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
    protected $helpers = [];

    /**
     * Set default directory
     */
    protected $directory = ''; // Set default directory

    /**
     *  Set default yield view
     */
    protected $view = null; // Set default yield view

    /**
     * @var data
     */
    protected $data = []; // Set default data array

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
     * @var \Config\Services::validation();
     */
    protected $validation;



    // protected $userService = 'admin';

    // protected $checkAccess = true;

    // protected $layoutPath = 'BasicApp\Admin';

    // protected $layout = 'layout';

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // if ($this->checkAccess)
        // {
        //     $this->checkAccess();
        // }

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        $this->session      = service('session');

        //--------------------------------------------------------------------
        // Check for flashdata
        //--------------------------------------------------------------------
        $this->data['confirm'] = $this->session->getFlashdata('confirm');
        $this->data['errors'] = $this->session->getFlashdata('errors');


        $this->auth         = service('authentication');
        $this->settings     = service('settings');
        $this->validation   = service('validation');
        $this->db           = Database::connect();


        // Arguments to be used in the callback remap
        $segments = $request->uri->getSegments();
        switch ($segments[0]) {
            case CI_AREA_ADMIN:
               $this->directory = 'admin/themes/' . $this->settings->setting_theme_admin. '/templates';
               $this->isBack = true;
                break;
            case 'Api':
                $this->directory = "api";
                break;
            default:
            $this->directory = 'front/themes/' .  $this->settings->setting_theme_front;
            $this->isFront = true;
        break;
        }

        $this->arguments = array_slice($segments, (($this->directory === '') ? 2 : 3));
        if ($this->directory === '') {
            $this->redirect = $this->request->uri->getSegment(1);
        } else {
            $this->request->uri->getSegment(1) . '/' . $this->request->uri->getSegment(2);
        }




    }


    /**
     * --------------------------------------------------------------------
     *   REMAP AUTOLOAD VIEWS
     * --------------------------------------------------------------------
     */

    // /**
    //  * Remap the CI request, running the method
    //  * and loading the view automagically
    //  * @param string $method The method we're trying to load
    //  */
    // public function _remap($method = null)
    // {
    //     if (!$this->request->isAJAX()) {
    //         $router = service('router');

    //         $controller_full_name = explode('\\', $router->controllerName());
    //         if ($this->isBack == true) {
    //             $controller = str_replace(['Admin', 'Controller'], ['', ''], $controller_full_name);
    //         }

    //         $view_folder = strtolower($this->directory . '/' . end($controller));
    //         //Checks if it's a 404 or not
    //         if (method_exists($this, $method)) {
    //             $redirect = call_user_func_array(array($this, $method), $this->arguments);
    //         } else {
    //             throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    //         }
    //         //Check if it's a redirect or not
    //         if (isset($redirect) && is_object($redirect) && get_class($redirect) === 'CodeIgniter\HTTP\RedirectResponse') {
    //             return $redirect;
    //         }
    //         if ($this->view !== false) {
    //             $this->data['layout'] = (empty($this->layout)) ? 'layouts/nolayout' : $this->layout;
    //             $this->data['yield'] = (!empty($this->view)) ? $this->view : strtolower($view_folder . '/' . $router->methodName());
    //             //print_r($this->data); exit;
    //             return view($this->data['yield'], $this->data);
    //         }
    //         return $redirect;
    //     }
    // }

    protected function checkAccess()
    {
        $userService = service($this->userService);

        if (!$userService->can(static::class))
        {
            if ($userService->getUser())
            {
                throw SecurityException::forDisallowedAction();
            }
            else
            {
                $url = $userService->getLoginUrl();

                throw new RedirectException($url);
            }
        }
    }

}
