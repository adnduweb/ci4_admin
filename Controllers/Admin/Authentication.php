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
    protected $helpers = ['form', 'date', 'Adnduweb\Helpers\detect', 'Adnduweb\Helpers\url'];


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

       return view('Adnduweb\Ci4Admin\themes\/'. $this->setting->setting_theme_admin.'/\templates\authentication\index', ['config' => $this->config, 'data' => $this->data]);
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
                if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
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
                    csrf_token() => csrf_hash(),
                    'status' => "success",
                    'message' => lang('Auth.loginSuccess'),
                    'redirect' => '/' . env('CI_SITE_AREA') . '/change-pass'

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
                        csrf_token() => csrf_hash(),
                        'error' => true,
                        'message' => lang('Core.attention_deja_connexion_unique') ?? lang('Auth.badAttempt')

                    ];
                    return $this->respond($response);
                }
            }

            // ON récupére le groupe principal
            $groupModel = new Adnduweb\Ci4Admin\GroupModel();
            $getGroupsForUser = $groupModel->getGroupsForUser($this->auth->user()->id);
            if (empty($getGroupsForUser[0]['login_destination']))
                $getGroupsForUser[0]['login_destination'] = 'dashboard';


            $redirectURL = session('previous_page') ?? '/' . env('CI_SITE_AREA') . '/' . $getGroupsForUser[0]['login_destination'];;
            unset($_SESSION['previous_page']);
            $response = [
                csrf_token() => csrf_hash(),
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
    public function logout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to('/' . env('CI_SITE_AREA'));
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
        return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
    }

    //--------------------------------------------------------------------
    // Forgot Password
    //--------------------------------------------------------------------

    /**
     * Displays the forgot password form.
     */
    public function forgotPassword()
    {
        //return view($this->config->views['forgot'], ['config' => $this->config]);
        return view($this->get_current_theme_view('forgot-password', 'default'), ['config' => $this->config, 'data' => $this->data]);
    }

    /**
     * Attempts to find a user account with that password
     * and send password reset instructions to them.
     */
    public function attemptForgot()
    {
        if ($this->request->isAJAX()) {
            $users = new UserModel();

            $user = $users->where('email', $this->request->getPost('email'))->first();

            if (is_null($user)) {
                $response = [
                    csrf_token() => csrf_hash(),
                    'error' => true,
                    'message' => lang('Auth.forgotNoUser'),
                ];
                return $this->respond($response);
            }

            // Save the reset hash /
            $user->generateResetHash();
            $users->save($user);

            $email = Services::email();
            $config = new Email();

            $sent = $email->setFrom($config->fromEmail, $config->fromName)
                ->setTo($user->email)
                ->setSubject(lang('Auth.forgotSubject'))
                ->setMessage(view('admin/themes/' . env("app.themeAdmin") . '/emails/' . $this->request->getLocale() . '/forgot', ['hash' => $user->reset_hash]))
                ->setMailType('html')
                ->send();


            if (!$sent) {
                log_message('error', "Failed to send forgotten password email to: {$user->email}");
                $response = [
                    csrf_token() => csrf_hash(),
                    'error' => true,
                    'message' => lang('Auth.unknownError'),
                ];
                return $this->respond($response);
            }

            $response = [
                csrf_token() => csrf_hash(),
                'status' => "success",
                'message' => lang('Auth.forgotEmailSent'),
                'redirect' => '/' . env('CI_SITE_AREA') . '/reset-password'
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
        $token = $this->request->getGet('token');
        return view($this->get_current_theme_view('reset-password', 'default'), ['config' => $this->config, 'data' => $this->data, 'token'  => $token]);
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
            $users = new UserModel();

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
                    csrf_token() => csrf_hash(),
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
                    csrf_token() => csrf_hash(),
                    'error' => true,
                    'message' =>  lang('Auth.forgotNoUser'),
                ];
                return $this->respond($response);
            }

            // Reset token still valid?
            if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
                //return redirect()->back()->withInput()->with('error', lang('Auth.resetTokenExpired'));
                $response = [
                    csrf_token() => csrf_hash(),
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
                csrf_token() => csrf_hash(),
                'status' => "success",
                'message' => lang('Auth.resetSuccess'),
                'redirect' => '/' . env('CI_SITE_AREA')
            ];
            return $this->respond($response);
        }
    }

    public function changePassword()
    {
        if ($this->auth->check()) {
            helper('auth');
            if (user()->force_pass_reset == '1') {
                return view($this->get_current_theme_view('change-pass', 'default'), ['config' => $this->config, 'data' => $this->data]);
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
        helper('auth');

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
                    return $this->respond([csrf_token() => csrf_hash(), 'error' => true, 'message' => $this->validator->listErrors()]);
                }
                $user->password         = $this->request->getPost('password');
                $user->force_pass_reset = '0';
                $users->save($user);
                return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'message' => lang('Auth.passwordChangeSuccess'), 'redirect' => '/' . env('CI_SITE_AREA') . '/dashboard']);
            }
        }
    }
}
