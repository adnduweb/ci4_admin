<?php 

namespace Adnduweb\Ci4Admin\Config;

use CodeIgniter\Config\BaseConfig;

class Admin extends BaseConfig
{

	/**
	 * Directory to store files (with trailing slash)
	 *
	 * @var string
	 */
	public $resourcesPath = ROOTPATH . 'public/admin/themes/';

    // Tables to ignore when creating the schema
	public $ignoredTables = ['migrations'];
	
	// Namespaces to ignore (mostly for ModelHandler)
	public $ignoredNamespaces = [
		'Tests\Support',
		'CodeIgniter\Commands\Generators',
    ];
    
}

