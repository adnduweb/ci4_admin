<?php namespace Adnduweb\Ci4Admin\Config;

use CodeIgniter\Model;
use Adnduweb\Ci4Admin\Authorization\FlatAuthorization;
use Adnduweb\Ci4Admin\Models\UserModel;
use Adnduweb\Ci4Admin\Models\LoginModel;
use Adnduweb\Ci4Admin\Authorization\GroupModel;
use Adnduweb\Ci4Admin\Authorization\PermissionModel;
use Adnduweb\Ci4Admin\Authentication\Passwords\PasswordValidator;
use Adnduweb\Ci4Admin\Authentication\Activators\UserActivator;
use Adnduweb\Ci4Admin\Authentication\Resetters\UserResetter;
use Config\Services as BaseService;

class Services extends BaseService
{
    public static function authentication(string $lib = 'local', Model $userModel = null, Model $loginModel = null, bool $getShared = true)
    {
        if ($getShared)
        {
            return self::getSharedInstance('authentication', $lib, $userModel, $loginModel);
        }

        /**
         * config() checks first in app/Config
         *
         * @var \Adnduweb\Ci4Admin\Config\Auth $config
         */
		$config = config('Auth');

        $class = $config->authenticationLibs[$lib];

        $instance = new $class($config);

        if (empty($userModel))
        {
            $userModel = new UserModel();
        }

        if (empty($loginModel))
        {
            $loginModel = new LoginModel();
        }

        return $instance
            ->setUserModel($userModel)
            ->setLoginModel($loginModel);
    }

    public static function authorization(Model $groupModel=null, Model $permissionModel=null, Model $userModel=null, bool $getShared = true)
    {
        if ($getShared)
        {
            return self::getSharedInstance('authorization', $groupModel, $permissionModel, $userModel);
        }

        if (is_null($groupModel))
        {
            $groupModel = new GroupModel();
        }

        if (is_null($permissionModel))
        {
            $permissionModel = new PermissionModel();
        }

        $instance = new FlatAuthorization($groupModel, $permissionModel);

        if (is_null($userModel))
        {
            $userModel = new UserModel();
        }

        return $instance->setUserModel($userModel);
    }

    /**
     * Returns an instance of the password validator.
     *
     * @param null $config
     * @param bool $getShared
     *
     * @return mixed|PasswordValidator
     */
    public static function passwords($config = null, bool $getShared = true)
    {
        if ($getShared)
        {
            return self::getSharedInstance('passwords', $config);
        }

        if (empty($config))
        {
            $config = config(Auth::class);
        }

        return new PasswordValidator($config);
    }

    /**
     * Returns an instance of the activator.
     *
     * @param null $config
     * @param bool $getShared
     *
     * @return mixed|Activator
     */
    public static function activator($config = null, bool $getShared = true)
    {
        if ($getShared)
        {
            return self::getSharedInstance('activator', $config);
        }

        if (empty($config))
        {
            $config = config(Auth::class);
        }

        return new UserActivator($config);
    }

    /**
     * Returns an instance of the resetter.
     *
     * @param null $config
     * @param bool $getShared
     *
     * @return mixed|Activator
     */
    public static function resetter($config = null, bool $getShared = true)
    {
        if ($getShared)
        {
            return self::getSharedInstance('resetter', $config);
        }

        if (empty($config))
        {
            $config = config(Auth::class);
        }

        return new UserResetter($config);
    }
}
