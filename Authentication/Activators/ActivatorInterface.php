<?php namespace Adnduweb\Admin\Authentication\Activators;

use CodeIgniter\Entity;

/**
 * Interface ActivatorInterface
 *
 * @package Adnduweb\Admin\Authentication\Activators
 */
interface ActivatorInterface
{
    /**
     * Send activation message to user
     *
     * @param User $user
     *
     * @return mixed
     */
    public function send(Entity $user = null): bool;

    /**
     * Returns the error string that should be displayed to the user.
     *
     * @return string
     */
    public function error(): string;

}
