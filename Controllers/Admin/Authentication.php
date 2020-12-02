<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Config\Email;
use Config\Services;
use Adnduweb\Ci4Admin\Entities\User;
use Adnduweb\Ci4Admin\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Authentication extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;


    /**
     * name controller
     */
    public $controller = 'authentication';

     /**
     * Localize slug
     */
    public $pathcontroller  = '/';

    /**
     * Localize slug
     */
    public $nameController  = '';

    /**
     * name model
     */
    public $tableModel = UserModel::class;

     /**
	 * @var Auth
	 */
    protected $page = 'login-back-off';

    /**
	 *
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    //protected $helpers = ['auth', 'inflector', 'html', 'common', 'form', 'url'];
    protected $helpers = ['form', 'date', 'detect', 'url', 'auth'];


    /**
	 * @var Auth
	 */
    protected $setting_theme_admin;

    public function __construct()
    {

        $this->session = service('session');

		$this->config = config('Auth');
        $this->auth = service('authentication');
        $this->setting = service('settings');

    }

    //--------------------------------------------------------------------
    // Login/out
    //--------------------------------------------------------------------

    /**
     * Displays the login form, or redirects
     * the user to their destination/home if
     * they are already logged in.
     */
    public function index()
    {
        // No need to show a login form if the user
        // is already logged in.
        if ($this->auth->check()) {
            $redirectURL = session('redirect_url') ?? '/';
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

       return view('Adnduweb\Ci4Admin\themes\/'. $this->setting->setting_theme_admin.'/\templates\authentication\index', ['config' => $this->config, 'data' => $this->viewData]);
    }

    /**
     * Attempts to verify the user's credentials
     * through a POST request.
     */
    public function attemptLogin()
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'login'    => 'required',
                'password' => 'required',
            ];
            if ($this->config->validFields == ['email']) {
                $rules['login'] .= '|valid_email';
            }


            if (!$this->validate($rules)) {
                return $this->respond(['token' => csrf_hash(), 'error' => true, 'message' => $this->validator->listErrors()]);
            }

            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');
            $remember = (bool) $this->request->getPost('remember');

            // Determine credential type
            $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';


            // Try to log them in...
            if (!$this->auth->attempt([$type => $login, 'password' => $password], $remember)) {  
                $throttler = \Config\Services::throttler();
                if ($throttler->check($this->request->getIPAddress(), 5, MINUTE) === false) {
                    $response = [
                        'token' => csrf_hash(),
                        'error' => true,
                        'message' => lang('Auth.tooManyRequests', [$throttler->getTokentime()])

                    ];
                    return $this->respond($response, 429);
                }
                $response = [
                    'token' => csrf_hash(),
                    'error' => true,
                    'message' => $this->auth->error() ?? lang('Auth.badAttempt')

                ];
                return $this->respond($response);
            }

            // Is the user being forced to reset their password?
            if ($this->auth->user()->force_pass_reset === true) {
                $response = [
                    'token' => csrf_hash(),
                    'status' => "success",
                    'message' => lang('Auth.loginSuccess'),
                    'redirect' => '/' . env('app.areaAdmin') . '/change-pass'

                ];
                return $this->respond($response);
                //return redirect()->to(route_to('reset-password') .'?token='. $this->auth->user()->reset_hash);‡
            }

            $user =  $this->auth->user();
            $users = new UserModel();
            // Success! Save the new password, and cleanup the reset hash.
            $user->password         = $this->request->getPost('password');
            $user->reset_hash       = null;
            $user->reset_at         = date('Y-m-d H:i:s');
            $user->reset_expires    = null;
            $user->force_pass_reset = false;
            $users->save($user);


            //Connexion unique
            if (service('settings')->setting_connexion_unique == '1') {
                // on regarde Si une session est active
                if (count($this->auth->getSessionActive()) > 0) {
                    $this->auth->logout();
                    $response = [
                        'token' => csrf_hash(),
                        'error' => true,
                        'message' => lang('Core.attention_deja_connexion_unique') ?? lang('Auth.badAttempt')

                    ];
                    return $this->respond($response);
                }
            }

            // ON récupére le groupe principal
            $groupModel = new \Adnduweb\Ci4Admin\Models\GroupModel(); 
            $getGroupsForUser = $groupModel->getGroupsForUser($this->auth->user()->id);
            if (empty($getGroupsForUser[0]['login_destination']))
                $getGroupsForUser[0]['login_destination'] = 'dashboard';


            $redirectURL = session('previous_page') ?? '/' . env('app.areaAdmin') . '/' . $getGroupsForUser[0]['login_destination'];;
            unset($_SESSION['previous_page']);
            $response = [
                'token' => csrf_hash(),
                'status' => "success",
                'message' => lang('Auth.loginSuccess'),
                'redirect' => $redirectURL

            ];
            return $this->respond($response);
        }
    }

    /**
     * Log the user out.
     */
    public function doLogout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to(route_to('login-area'));
    }

    //--------------------------------------------------------------------
    // Register
    //--------------------------------------------------------------------

    /**
     * Displays the user registration page.
     */
    public function register()
    {
        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        return view($this->config->views['register'], ['config' => $this->config]);
    }

    /**
     * Attempt to register a new user.
     */
    public function attemptRegister()
    {
        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        $users = new UserModel();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = array_merge($users->getValidationRules(['only' => ['username']]), [
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ]);

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // Save the user
        $user = new User($this->request->getPost());

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // Success!
        return redirect()->route('login-area')->with('message', lang('Auth.registerSuccess'));
    }

    //--------------------------------------------------------------------
    // Forgot Password
    //--------------------------------------------------------------------

    /**
     * Displays the forgot password form.
     */
    public function forgotPassword() 
    {
        if ($this->config->activeResetter === false)
		{
			return redirect()->route('login-area')->with('error', lang('Auth.forgotDisabled'));
        }
        
        return view('Adnduweb\Ci4Admin\themes\/'. $this->setting->setting_theme_admin.'/\templates\authentication\forgot-password', ['config' => $this->config, 'data' => $this->viewData]);
    }

    /**
     * Attempts to find a user account with that password
     * and send password reset instructions to them.
     */
    public function attemptForgot()
    {
        if ($this->request->isAJAX()) {

            if ($this->config->activeResetter === false)
            {
                $response = [
                    'token' => csrf_hash(),
                    'error' => true,
                    'message' => lang('Auth.forgotDisabled'),
                ];
                return $this->respond($response);
            }
        

            $users = model(UserModel::class);

            $user = $users->where('email', $this->request->getPost('email'))->first();

            if (is_null($user)) {
                $response = [
                    'token' => csrf_hash(),
                    'error' => true,
                    'message' => lang('Auth.forgotNoUser'),
                ];
                return $this->respond($response);
            }

            // Save the reset hash /
            $user->generateResetHash();
            $users->save($user);

            $resetter = service('resetter');
		    $sent = $resetter->send($user);

            //fabrice@adnduweb.com
            if (! $sent)
            {
                $response = [
                    'token' => csrf_hash(),
                    'error' => true,
                    'message' => $resetter->error() ?? lang('Auth.unknownError'),
                ];
                return $this->respond($response);
            }

            $response = [
                'token' => csrf_hash(),
                'status' => "success",
                'message' => lang('Auth.forgotEmailSent'),
                'redirect' => '/' . env('app.areaAdmin') . '/reset-password'
            ];
            //return redirect()->route('reset-password')->with('message', lang('Auth.forgotEmailSent'));
            return $this->respond($response);
        }
    }

    /**
     * Displays the Reset Password form.
     */
    public function resetPassword()
    {
        if ($this->config->activeResetter === false)
		{
			return redirect()->route('login-area')->with('error', lang('Auth.forgotDisabled'));
        }
        
        $token = $this->request->getGet('token');

        return view('Adnduweb\Ci4Admin\themes\/'. $this->setting->setting_theme_admin.'/\templates\authentication\reset-password', ['config' => $this->config, 'data' => $this->viewData, 'token'  => $token]);
    }

    /**
     * Verifies the code with the email and saves the new password,
     * if they all pass validation.
     *
     * @return mixed
     */
    public function attemptReset()
    {
        if ($this->request->isAJAX()) {

            if ($this->config->activeResetter === false)
		{
			return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
        }
        
            $users = model(UserModel::class);

            // First things first - log the reset attempt.
            $users->logResetAttempt(
                $this->request->getPost('email'),
                $this->request->getPost('token'),
                $this->request->getIPAddress(),
                (string) $this->request->getUserAgent()
            );

            $rules = [
                'token'        => 'required',
                'email'        => 'required|valid_email',
                'password'     => 'required|strong_password',
                'pass_confirm' => 'required|matches[password]',
            ];

            if (!$this->validate($rules)) {
                // return redirect()->back()->withInput()->with('errors', $users->errors());
                $response = [
                    'token' => csrf_hash(),
                    'error' => true,
                    'message' =>  $this->validator->listErrors(),
                ];
                return $this->respond($response);
            }

            $user = $users->where('email', $this->request->getPost('email'))
                ->where('reset_hash', $this->request->getPost('token'))
                ->first();

            if (is_null($user)) {
                //return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
                $response = [
                    'token' => csrf_hash(),
                    'error' => true,
                    'message' =>  lang('Auth.forgotNoUser'),
                ];
                return $this->respond($response);
            }

            // Reset token still valid?
            if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
                //return redirect()->back()->withInput()->with('error', lang('Auth.resetTokenExpired'));
                $response = [
                    'token' => csrf_hash(),
                    'error' => true,
                    'message' =>  lang('Auth.resetTokenExpired'),
                ];
                return $this->respond($response);
            }

            // Success! Save the new password, and cleanup the reset hash.
            $user->password         = $this->request->getPost('password');
            $user->reset_hash         = null;
            $user->reset_at         = date('Y-m-d H:i:s');
            $user->reset_expires    = null;
            $user->force_pass_reset = false;
            $users->save($user);

            $response = [
                'token' => csrf_hash(),
                'status' => "success",
                'message' => lang('Auth.resetSuccess'),
                'redirect' => '/' . env('app.areaAdmin')
            ];
            return $this->respond($response);
        }
    }

    public function changePassword()
    {
        if ($this->auth->check()) {
            if (user()->force_pass_reset == '1') {
                return view($this->get_current_theme_view('change-pass', 'default'), ['config' => $this->config, 'data' => $this->viewData]);
            } else {
                unset($_SESSION['redirect_url']);
                return redirect()->to('/');
            }
        } else {
            unset($_SESSION['redirect_url']);
            return redirect()->to('/');
        }
    }

    public function attemptChangePass()
    {

        if ($this->request->isAJAX()) {
            if ($this->auth->check()) {
                $user =  user();
                $users = new UserModel();

                $rules = [
                    'email'        => 'required|valid_email',
                    'password'     => 'required|strong_password',
                    'pass_confirm' => 'required|matches[password]',
                ];
                if (!$this->validate($rules)) {
                    return $this->respond(['token' => csrf_hash(), 'error' => true, 'message' => $this->validator->listErrors()]);
                }
                $user->password         = $this->request->getPost('password');
                $user->force_pass_reset = '0';
                $users->save($user);
                return $this->respond(['token' => csrf_hash(), 'error' => false, 'message' => lang('Auth.passwordChangeSuccess'), 'redirect' => '/' . env('app.areaAdmin') . '/dashboard']);
            }
        }
    }

    /**
	 * Activate account.
	 *
	 * @return mixed
	 */
	public function activateAccount()
	{
            $users = model('UserModel');

            // First things first - log the activation attempt.
            $users->logActivationAttempt(
                $this->request->getGet('token'),
                $this->request->getIPAddress(),
                (string) $this->request->getUserAgent()
            );

            $throttler = service('throttler');

            if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
                return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
            }

            $user = $users->where('activate_hash', $this->request->getGet('token'))
                      ->where('active', 0)
                      ->first();

            if (is_null($user)) {
                return redirect()->route('login-area')->with('error', lang('Auth.activationNoUser'));
            }

            $user->activate();

            $users->save($user);

            return redirect()->route('login-area')->with('message', lang('Auth.registerSuccess'));
	}

	/**
	 * Resend activation account.
	 *
	 * @return mixed
	 */
	public function resendActivateAccount()
	{
		if ($this->config->requireActivation === false)
		{
			return redirect()->route('login-area');
		}

		$throttler = service('throttler');

		if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false)
		{
			return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
		}

		$login = urldecode($this->request->getGet('login-area'));
		$type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		$users = model('UserModel');

		$user = $users->where($type, $login)
					  ->where('active', 0)
					  ->first();

		if (is_null($user))
		{
			return redirect()->route('login-area')->with('error', lang('Auth.activationNoUser'));
		}

		$activator = service('activator');
		$sent = $activator->send($user);

		if (! $sent)
		{
			return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
		}

		// Success!
		return redirect()->route('login-area')->with('message', lang('Auth.activationSuccess'));

    }
    
    // /**
	//  * Resend activation account.
	//  *
	//  * @return mixed
	//  */
	// public function resendActivateAccount()
	// {
    //     if ($this->request->isAJAX()) {
    //         if ($this->config->requireActivation === false) {
    //             return redirect()->route('login-area');
    //         }

    //         // $throttler = service('throttler');

    //         // if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
    //         //     return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
    //         // }

    //         $throttler =  service('throttler');
    //         if ($throttler->check($this->request->getIPAddress(), 5, MINUTE) === false) {
    //             $response = [
    //                 'token' => csrf_hash(),
    //                 'error' => true,
    //                 'message' => lang('Auth.tooManyRequests', [$throttler->getTokentime()])

    //             ];
    //             return $this->respond($response, 429);
    //         }


    //         $login = urldecode($this->request->getGet('login-area'));
    //         $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    //         $users = model('UserModel');

    //         $user = $users->where($type, $login)
    //                   ->where('active', 0)
    //                   ->first();

    //         if (is_null($user)) {
    //             //return redirect()->route('login-area')->with('error', lang('Auth.activationNoUser'));
    //             $response = [
    //                 'token' => csrf_hash(),
    //                 'error' => true,
    //                 'message' =>  lang('Auth.activationNoUser'),
    //             ];
    //             return $this->respond($response);
    //         }

    //         $activator = service('activator');
    //         $sent = $activator->send($user);

    //         if (! $sent) {
    //             //return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
    //             $response = [
    //                 'token' => csrf_hash(),
    //                 'error' => true,
    //                 'message' =>  $activator->error() ?? lang('Auth.unknownError'),
    //             ];
    //             return $this->respond($response);
    //         }

    //         // Success!
    //         //return redirect()->route('login-area')->with('message', lang('Auth.activationSuccess'));
    //         $response = [
    //             'token' => csrf_hash(),
    //             'status' => "success",
    //             'message' => lang('Auth.activationSuccess'),
    //             'redirect' => '/' . env('app.areaAdmin')
    //         ];
    //         return $this->respond($response);
    //     }



}
