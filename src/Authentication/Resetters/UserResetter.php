<?php namespace Adnduweb\Ci4Admin\Authentication\Resetters;

use Adnduweb\Ci4Admin\Config\Auth;
use Adnduweb\Ci4Admin\Entities\User;

class UserResetter
{
    /**
     * @var Auth
     */
    protected $config;

    protected $error;

    public function __construct(Auth $config)
    {
        $this->config = $config;
    }

    /**
     * Sends reset message to the user via specified class
     * in `$activeResetter` setting in Config\Auth.php.
     *
     * @param User $user
     *
     * @return bool
     */
    public function send(User $user = null): bool
    {
        if ($this->config->activeResetter === false)
        {
            return true;
        }

        $className = $this->config->activeResetter;

        $class = new $className();
        $class->setConfig($this->config);

        if ($class->send($user) === false)
        {
            log_message('error', "Failed to send reset messaage to: {$user->email}");
            $this->error = $class->error();

            return false;
        }

        return true;
    }

    /**
     * Returns the current error.
     *
     * @return mixed
     */
    public function error()
    {
        return $this->error;
    }

}
