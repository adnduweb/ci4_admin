<?php namespace Adnduweb\Ci4Admin\Authentication\Passwords;

class BaseValidator
{
    protected $config;

    /**
     * Allows for setting a config file on the Validator.
     *
     * @param $config
     *
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

}
