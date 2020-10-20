<?php

namespace Adnduweb\Ci4Admin\Models;

use Michalsn\Uuid\UuidModel;
use Adnduweb\Ci4Admin\Entities\User;


class UserModel extends UuidModel
{
    use \Tatter\Relations\Traits\ModelTrait, \Adnduweb\Ci4Traits\AuditsTrait, \Adnduweb\Ci4Admin\Models\BaseModel;

    protected $afterInsert = ['auditInsert'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table = 'users';
    protected $with = ['auth_groups_users', 'auth_users_permissions', 'settings'];
    protected $without = [];
    protected $primaryKey = 'id';
    protected $uuidFields = ['uuid'];

    protected $returnType     = User::class;
    protected $localizeFile   = 'App\Models\UserModel';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'uuid', 'company_id', 'id_lang', 'id_country', 'lastname', 'firstname', 'fonction', 'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'phone', 'phone_mobile', 'is_principal', 'deleted_at',
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username'      => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $searchKtDatatable  = ['fonction', 'lastname', 'firstname', 'email', 'created_at'];


    public function __construct()
    {
        parent::__construct();
        $this->builder           = $this->db->table('users');
        $this->auth_groups_users = $this->db->table('auth_groups_users');
        $this->auth_groups       = $this->db->table('auth_groups');
        $this->auth_logins       = $this->db->table('auth_logins');
        $this->companies         = $this->db->table('companies');
    }

    /**
     * Logs a password reset attempt for posterity sake.
     *
     * @param string      $email
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logResetAttempt(string $email, string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_reset_attempts')->insert([
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Logs an activation attempt for posterity sake.
     *
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logActivationAttempt(string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_activation_attempts')->insert([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getAllList($idcompany, int $page, int $perpage, array $sort, array $query)
    {
        $this->builder->select();
        $this->builder->select('users.created_at as date_create_at');

         if (isset($query[0]) && is_array($query)) {

            // On recherche dans les colonnes
            $getLike = implode(',', $this->searchKtDatatable);
            if (count($this->searchKtDatatable) > 1)
                $getLike = $getLike . ',';
            $like = str_replace(',', ' LIKE "%' . trim($query[0]) . '%" OR ', $getLike);

            if ($idcompany == false) {
                $like = '(' . $like . ') ';
                $like = str_replace(' OR )', ')', $like);
                $this->builder->where($like);

            } else {
                $like = ' AND (' . $like . ') ';
                $like = str_replace(' OR )', ')', $like);
                $this->builder->where('(company_id = ' . $idcompany . ' ' .$like.')  AND  id!= 1');
            }

            $this->builder->limit(0, $page);
        } else {
            if ($idcompany == false) {
                $this->builder->where('deleted_at IS NULL');
            } else {
                $this->builder->where(['company_id' => $idcompany]);
                $this->builder->where('deleted_at IS NULL  AND  id!= 1');
            }
            $page = ($page == '1') ? '0' : (($page - 1) * $perpage);
            $this->builder->limit($perpage, $page);
        }


        $this->builder->orderBy('users.' . $sort['field'] . ' ' . $sort['sort']);

        $users = $this->builder->get();
        $usersRow = $users->getResult();
        if (!empty($usersRow)) {
            $i = 0;
            foreach ($usersRow as &$row) {
                $this->auth_groups_users->select();
                $this->auth_groups_users->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
                $this->auth_groups_users->where('user_id', $row->id);
                $auth_groups_users = $this->auth_groups_users->get();
                $row->group = $auth_groups_users->getResult();
                if ($idcompany == true) {
                    if (!empty($row->group)) {
                        foreach ($row->group as $group) {
                            if ($group->group_id == '1') {
                                unset($usersRow[$i]);
                            }
                        }
                    }
                }
                $i++;
            }
        }
        array_splice($usersRow, count($usersRow));
        // print_r($usersRow);
        // exit;
        // echo $this->builder->getCompiledSelect();
        // exit;
        return $usersRow;
    }

    public function getAllCount($idcompany, array $sort, array $query)
    {
        $this->builder->select('id');
         if (isset($query[0]) && is_array($query)) {
            // On recherche dans les colonnes
            $getLike = implode(',', $this->searchKtDatatable);
            if (count($this->searchKtDatatable) > 1)
                $getLike = $getLike . ',';
            $like = str_replace(',', ' LIKE "%' . trim($query[0]) . '%" OR ', $getLike);

            if ($idcompany == false) {
                $like = '(' . $like . ') ';
                $like = str_replace(' OR )', ')', $like);
                $this->builder->where($like);

            } else {
                $like = ' AND (' . $like . ') ';
                $like = str_replace(' OR )', ')', $like);
                $this->builder->where('(company_id = ' . $idcompany . ' ' .$like.')  AND  id!= 1');
            }

        } else {
            if ($idcompany == false) {
                $this->builder->where('deleted_at IS NULL');
            } else {
                $this->builder->where(['company_id' => $idcompany]);
                $this->builder->where('deleted_at IS NULL AND  id!= 1');
            }
        }

        $this->builder->orderBy($sort['field'] . ' ' . $sort['sort']);

        $users = $this->builder->get();
        $usersRow = $users->getResult();
        if (!empty($usersRow)) {
            $i = 0;
            foreach ($usersRow as &$row) {
                $this->auth_groups_users->select();
                $this->auth_groups_users->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
                $this->auth_groups_users->where('user_id', $row->id);
                $auth_groups_users = $this->auth_groups_users->get();
                $row->group = $auth_groups_users->getResult();
                if ($idcompany == true) {
                    if (!empty($row->group)) {
                        foreach ($row->group as $group) {
                            if ($group->group_id == '1') {
                                unset($usersRow[$i]);
                            }
                        }
                    }
                }
                $i++;
            }
        }
        array_splice($usersRow, count($usersRow));
        return $usersRow;
    }

    public function getLastConnexions(int $id, $limit = 100000): array
    {
        $this->auth_logins->select();
        $this->auth_logins->where('user_id', $id);
        $this->auth_logins->orderBy('id', 'DESC');
        $this->auth_logins->limit($limit);
        $auth_logins = $this->auth_logins->get();
        return $auth_logins->getResult();
    }

    public function getGroups()
    {
        return $this->auth_groups->select()->get()->getResult();
    }


    // public static function get_IdUserById(string $id)
    // {
    //     $db = \Config\Database::connect();
    //     $user = $db->table('users')->select('_id')->where(['id' => $id])->get()->getRow();
    //     return $user->_id;
    // }

    public static function isComptePrincipal(int $id)
    {
        $db = \Config\Database::connect();
        $user = $db->table('users')->select('id')->where(['id' => $id, 'id' => '1'])->get()->getRow();
        return (!empty($user)) ? true : false;
    }

    public function deleteAllUser(int $id)
    {
        $this->builder->delete(['id' => $id]);
        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
        $this->db->table('settings_users')->where('user_id', $id)->delete();
    }

    public static function getUserName(int $id)
    {
        $db = \Config\Database::connect();
        $user = $db->table('users')->select('username')->where(['id' => $id])->get()->getRow();
        return $user->username;
    }

    public function getCompany(): array
    {
        $this->companies->select('id, uuid_company, raison_social');
        $this->companies->orderBy('id', 'DESC');
        $company = $this->companies->get();
        return $company->getResult();
    }

    public function deleteSession($sessionId)
    {
        $this->db->table('sessions')->where('id', $sessionId)->delete();
    }

    public function getIdUserByUUID(string $uuid)
    {
        $uuid = $this->uuid->fromString($uuid)->getBytes();
        $this->builder->select('id');
        $this->builder->where('uuid', $uuid);
        return $this->builder->get()->getRow();
    }
}
