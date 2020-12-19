<?php

namespace Adnduweb\Ci4Admin\Filters;

use Config\Services;
use Adnduweb\Ci4Admin\Libraries\Theme;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Adnduweb\Ci4Admin\Exceptions\PermissionException;
use CodeIgniter\API\ResponseTrait;

class PermissionFilter implements FilterInterface
{
	use ResponseTrait;

	public $responseAjax;
	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param \CodeIgniter\HTTP\RequestInterface $request
	 * @param array|null                         $params
	 *
	 * @return mixed
	 */
	public function before(RequestInterface $request, $params = null)
	{
		
		if (!function_exists('logged_in')) {
			helper('auth');
		}

		if (empty($params)) {
			return;
		}

		$authenticate = Services::authentication();

		// if no user is logged in then send to the login form
		if (!$authenticate->check()) {
			session()->set('redirect_url', current_url());
			return redirect('login-area');
		}

		$authorize = Services::authorization();
		$result = true;

		// If super admin user
		if (inGroups(1, user()->id))
			return true;

			

		$methodView = false;

		// Check each requested permission
		foreach ($params as $permission) {

			if(stristr($permission, 'view') == true) {
				$methodView = true;
			}

			// Only restrict item
			if(stristr($permission, 'Only') == true) {
				return true;
			}


			$result = $result && $authorize->hasPermission($permission, $authenticate->id());
		}

		// print_r($params); exit;

		if (!$result) {

			if ($request->isAJAX()) {

				$response = Services::response();
				$retour = ['error' => ['code' => 401, 'message' => lang('Auth.notEnoughPrivilege')], 'success' => false, csrf_token() => csrf_hash()];
				$response->setStatusCode(401);
				return $response->setJSON($retour);

			} else {

				if ($authenticate->silent()) {
					if($methodView == true){
						$redirectURL = '/' . CI_AREA_ADMIN . '/dashboard';
					}else{
						$redirectURL = session('_ci_previous_url') ?? '/' . CI_AREA_ADMIN . '/dashboard';
					}

					unset($_SESSION['redirect_url']);
					Theme::set_message('warning',  lang('Auth.notEnoughPrivilege'), lang('Core.warning_error'));
					return redirect()->to($redirectURL);

				} else {

					throw new PermissionException(lang('Auth.notEnoughPrivilege'));
				}

			}
		}
	}

	//--------------------------------------------------------------------

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param \CodeIgniter\HTTP\RequestInterface  $request
	 * @param \CodeIgniter\HTTP\ResponseInterface $response
	 * @param array|null                          $arguments
	 *
	 * @return void
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		
	}

	//--------------------------------------------------------------------
}
