<?php

namespace Adnduweb\Ci4Admin\Entities;

use Michalsn\Uuid\UuidEntity;
use Adnduweb\Ci4Admin\Models\PermissionsModel;

class User extends UuidEntity
{
    use \Tatter\Relations\Traits\EntityTrait;
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $uuids      = ['uuid'];

    protected $datamap = [];

    /**
     * Define properties that are automatically converted to Time instances.
     */
    protected $dates = ['reset_at', 'reset_expires', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     */
    protected $casts = [
        'active'           => 'boolean',
        'force_pass_reset' => 'boolean',
    ];

    /**
     * Automatically hashes the password when set.
     *
     * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
     *
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $config = config('Auth');

        if (
            (defined('PASSWORD_ARGON2I') && $config->hashAlgorithm == PASSWORD_ARGON2I)
            ||
            (defined('PASSWORD_ARGON2ID') && $config->hashAlgorithm == PASSWORD_ARGON2ID)
        ) {
            $hashOptions = [
                'memory_cost' => $config->hashMemoryCost,
                'time_cost'   => $config->hashTimeCost,
                'threads'     => $config->hashThreads
            ];
        } else {
            $hashOptions = [
                'cost' => $config->hashCost
            ];
        }

        $this->attributes['password_hash'] = password_hash(
            base64_encode(
                hash('sha384', $password, true)
            ),
            $config->hashAlgorithm,
            $hashOptions
        );

        $this->attributes['reset_hash'] = null;
        $this->attributes['reset_at'] = null;
        $this->attributes['reset_expires'] = null;
    }

    /**
     * Generates a secure hash to use for password reset purposes,
     * saves it to the instance.
     *
     * @return $this
     * @throws \Exception
     */
    public function generateResetHash()
    {
        $this->attributes['reset_hash'] = bin2hex(random_bytes(16));
        $this->attributes['reset_expires'] = date('Y-m-d H:i:s', time() + config('Auth')->resetTime);

        return $this;
    }

    /**
     * Force a user to reset their password on next page refresh
     * or login. Checked in the LocalAuthenticator's check() method.
     *
     * @param User $user
     *
     * @return User
     * @throws \Exception
     */
    public function ‡()
    {
        $this->generateResetHash();
        $this->attributes['force_pass_reset'] = 1;

        return $this;
    }


    /**
     * Generates a secure random hash to use for account activation.
     *
     * @return $this
     * @throws \Exception
     */
    public function generateActivateHash()
    {
        $this->attributes['activate_hash'] = bin2hex(random_bytes(16));

        return $this;
    }

    /**
     * Activate user.
     *
     * @return $this
     */
    public function activate()
    {
        $this->attributes['active'] = 1;
        $this->attributes['activate_hash'] = null;

        return $this;
    }

    /**
     * Unactivate user.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->attributes['active'] = 0;

        return $this;
    }

    /**
     * Checks to see if a user is active.
     *
     * @return bool
     */
    public function isActivated(): bool
    {
        return isset($this->attributes['active']) && $this->attributes['active'] == true;
    }

    /**
     * Bans a user.
     *
     * @param string $reason
     *
     * @return $this
     */
    public function ban(string $reason)
    {
        $this->attributes['status'] = 'banned';
        $this->attributes['status_message'] = $reason;

        return $this;
    }

    /**
     * Removes a ban from a user.
     *
     * @return $this
     */
    public function unBan()
    {
        $this->attributes['status'] = $this->status_message = '';

        return $this;
    }

    /**
     * Checks to see if a user has been banned.
     *
     * @return bool
     */
    public function isBanned(): bool
    {
        return isset($this->attributes['status']) && $this->attributes['status'] === 'banned';
    }

    /**
     * Determines whether the user has the appropriate permission,
     * either directly, or through one of it's groups.
     *
     * @param string $permission
     *
     * @return bool
     */
    public function can(string $permission)
    {
        return in_array(strtolower($permission), $this->getPermissions());
    }

    /**
     * Returns the user's permissions, formatted for simple checking:
     *
     * [
     *    id => name,
     *    id=> name,
     * ]
     *
     * @return array|mixed
     */
    public function getPermissions()
    {
        if (empty($this->id)) {
            throw new \RuntimeException('Users must be created before getting permissions.');
        }

        if (empty($this->permissions)) {
            $this->permissions = (new PermissionsModel())->getPermissionsForUser($this->id);
        }

        return $this->permissions;
    }

    /**
     * Warns the developer it won't work, so they don't spend
     * hours tracking stuff down.
     *
     * @param array $permissions
     *
     * @return $this
     */
    public function setPermissions(array $permissions = null)
    {
        throw new \RuntimeException('User entity does not support saving permissions directly.');
    }

    /**
     * recupere le nom et la description du group du user
     *
     */
    public function setAuthGroupsUsers()
    {
        $this->attributes['auth_groups_users'] = $this->auth_groups_users;
        if (!empty($this->attributes['auth_groups_users'])) {
            foreach ($this->attributes['auth_groups_users'] as &$auth_groups_users) {
                $auth_groups_users->group =  (new \Adnduweb\Ci4Admin\Models\GroupModel())->getGroupById($auth_groups_users->group_id);
            }
        }

        return  $this->attributes['auth_groups_users'];
    }

     /**
     * Update With uuid
     */
    public function updateWithUUID($data, string $uuid)
    {
        return in_array(strtolower($permission), $this->getPermissions());
    }

    public function getFullName(){
        return ucfirst($this->attributes['lastname']) . ' ' . ucfirst($this->attributes['firstname']);
    }

}
