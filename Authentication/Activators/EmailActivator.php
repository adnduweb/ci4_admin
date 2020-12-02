<?php namespace Adnduweb\Ci4Admin\Authentication\Activators;

use Config\Email;
use CodeIgniter\Entity;
use CodeIgniter\Config\Services;

/**
 * Class EmailActivator
 *
 * Sends an activation email to user.
 *
 * @package Adnduweb\Ci4Admin\Authentication\Activators
 */
class EmailActivator extends BaseActivator implements ActivatorInterface
{
    /**
     * @var string
     */
    protected $error;

    /**
     * Sends an activation email
     *
     * @param User $user
     *
     * @return mixed
     */
    public function send(Entity $user = null): bool
    {
        $email = Services::email();
        $config = new Email();

        $settings = $this->getActivatorSettings();

        $templateEmailActivation = str_replace('metronic', service('settings')->setting_theme_admin, $this->config->views['emailActivation']);

        $sent = $email->setFrom(service('settings')->setting_email_fromEmail, service('settings')->setting_email_fromName)
              ->setTo($user->email)
              ->setSubject(lang('Auth.activationSubject'))
              ->setMessage(view($templateEmailActivation, ['hash' => $user->activate_hash])) 
              ->setMailType('html')
              ->send();

        if (! $sent)
        {
            $this->error = lang('Auth.errorSendingActivation', [$user->email]);
            return false;
        }

        return true;
    }

    /**
     * Returns the error string that should be displayed to the user.
     *
     * @return string
     */
    public function error(): string
    {
        return $this->error ?? '';
    }

}
