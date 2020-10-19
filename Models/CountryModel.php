<?php

namespace Adnduweb\Ci4Admin\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
    use \Adnduweb\Ci4_logs\Traits\AuditsTrait;
    protected $afterInsert = ['auditInsert'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table      = 'countries';
    protected $primaryKey = 'id_country';
    protected $returnType = 'object';
    protected $localizeFile = 'App\Models\CountryModel';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_lang', 'code_iso', 'name'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function getAllCountry()
    {
        return $this->db->table($this->table)->where('id_lang', service('switchlanguage')->getIdLocale())->orderBy('name ASC')->get()->getResult();
    }
}
