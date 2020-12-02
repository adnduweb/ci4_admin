<?php namespace Adnduweb\Ci4Admin\Authentication\Resetters;

use Config\Email;
use CodeIgniter\Entity;
use CodeIgniter\Config\Services;

/**
 * Class EmailResetter
 *
 * Sends a reset password email to user.
 *
 * @package Adnduweb\Ci4Admin\Authentication\Resetters
 */
class EmailResetter extends BaseResetter implements ResetterInterface
{
    /**
     * @var string
     */
    protected $error;

    /**
     * Sends a reset email
     *
     * @param User $user
     *
     * @return mixed
     */
    public function send(Entity $user = null): bool
    {
        $email = Services::email();
        $config = new Email();

        $settings = $this->getResetterSettings();
        $templateEmailForgot = str_replace('metronic', service('settings')->setting_theme_admin, $this->config->views['emailForgot']);

        $sent = $email->setFrom(service('settings')->setting_email_fromEmail, service('settings')->setting_email_fromName)
              ->setTo($user->email)
              ->setSubject(lang('Auth.forgotSubject'))
              ->setMessage(view($templateEmailForgot, ['hash' => $user->reset_hash]))
              ->setMailType('html')
              ->send();

        if (! $sent)
        {
            $this->error = lang('Auth.errorEmailSent', [$user->email]);
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
