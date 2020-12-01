<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use CodeIgniter\API\ResponseTrait;

class Translate extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

    /**
     * name controller
     */
    public $controller = 'translate';

    /**
     * Localize slug
     */
    public $pathcontroller  = '/international';

    /**
     * name model
     */
    public $tableModel = null;

    /**
     * Bouton add
     */
    public $add = false;

    /**
     * Update Listing
     */
    public $toolbarUpdate = false;

    /**
     * Display Multilangue
     */
    public $multilangue = false;

    /**
     * Display Multilangue
     */
    public $back = false;


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        $this->copyFile();

        Theme::add_js('/resources/metronic/js/pages/custom/translate/app.translate.js');
        helper(['Lang', 'Array']);
        parent::index();

        $filesCore = array();
        $filesThemesFront = array();
        $charge  = array();

        foreach (glob(APPPATH . "Language/en/*.php") as $filename) {

            if (!preg_match('/^Front_/', basename($filename))) {
                $filesCore[] = basename($filename);
                $charge[strtolower(str_replace('.php', '', basename($filename)))] = include($filename);
            } else {
                $filesThemesFront[] = basename($filename);
                $charge[strtolower(str_replace('.php', '', basename($filename)))] = include($filename);
            }
        }

        $this->viewData['filesCore'] = $filesCore;
        $this->viewData['filesThemesFront'] = $filesThemesFront;
        $this->viewData['toolbarExport'] = $this->toolbarExport;
        $this->viewData['add'] = $this->add;

        return $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\translate\index', $this->viewData);
    }

    public function getFile()
    {
        
        if ($this->request->isAJAX()) {
            helper(['Lang', 'Array']);
            if ($value = $this->request->getPost('value')) {
                $traitement = arrayToArray($value);
                if (!empty($traitement['fileCore'])) {
                    if (file_exists(ROOTPATH . "app/Language/" . $traitement['lang'] . "/" . $traitement['fileCore'])) {
                        $this->viewData['langue']   = include(APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileCore']);
                        $this->viewData['file']     = APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileCore'];
                        $this->viewData['lang']     = $traitement['lang'];
                        $viewLangue             = $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\translate\viewLangue', $this->viewData);
                        return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'html' => $viewLangue]);
                    } else {
                        if (file_exists(ROOTPATH . "app/Language/fr/" . $traitement['fileCore'])) {
                            copy(ROOTPATH . "app/Language/fr/" . $traitement['fileCore'], ROOTPATH . "app/Language/" . $traitement['lang'] . "/" . $traitement['fileCore']);
                        }
                        if (file_exists(ROOTPATH . "app/Language/en/" . $traitement['fileCore'])) {
                            copy(ROOTPATH . "app/Language/en/" . $traitement['fileCore'], ROOTPATH . "app/Language/" . $traitement['lang'] . "/" . $traitement['fileCore']);
                        }
                        $this->viewData['langue']   = include(APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileCore']);
                        $this->viewData['file']     = APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileCore'];
                        $this->viewData['lang']     = $traitement['lang'];
                        $viewLangue             = $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\translate\viewLangue', $this->viewData);
                        return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'html' => $viewLangue]);
                    }
                } else if (!empty($traitement['fileTheme'])) {
                    if (file_exists(APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileTheme'])) {
                        $this->viewData['langue']   = include(APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileTheme']);
                        $this->viewData['file']     = APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileTheme'];
                        $this->viewData['lang']     = $traitement['lang'];
                        $viewLangue             = $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\translate\viewLangue', $this->viewData);
                        return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'html' => $viewLangue]);
                    } else {
                        if (file_exists(ROOTPATH . "app/Language/fr/" . $traitement['fileTheme'])) {
                            copy(ROOTPATH . "app/Language/fr/" . $traitement['fileTheme'], ROOTPATH . "app/Language/" . $traitement['lang'] . "/" . $traitement['fileTheme']);
                        }
                        if (file_exists(ROOTPATH . "app/Language/en/" . $traitement['fileTheme'])) {
                            copy(ROOTPATH . "app/Language/en/" . $traitement['fileTheme'], ROOTPATH . "app/Language/" . $traitement['lang'] . "/" . $traitement['fileTheme']);
                        }
                        $this->viewData['langue']   = include(APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileTheme']);
                        $this->viewData['file']     = APPPATH . "Language/" . $traitement['lang'] . "/" . $traitement['fileTheme'];
                        $this->viewData['lang']     = $traitement['lang'];
                        $viewLangue             = $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\translate\viewLangue', $this->viewData);
                        return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'html' => $viewLangue]);
                    }
                }
            }
        }
    }

    /**
     * Save file
     * 
     */
    public function savefile()
    {

        if ($this->request->isAJAX()) {
            helper(['Lang', 'Array']);
            if ($value = $this->request->getPost('value')) {

                $newTraitement = $this->traitement($value);

                try {

                    save_all_lang_file($newTraitement['file'], $newTraitement['lang'], $newTraitement['trad'], false, true);

                    $response = ['success' => ['code' => 200, 'message' => lang('Core.success_update')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200, 'Update translate');
                } catch (\Exception $e) {

                    $response = ['error' => ['code' => 500, 'message' => lang('Core.error_saved_data') ?? $e->getMessage()], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 500);
                }
            }
        }
    }

    /**
     * Delete texte in file
     * 
     */
    public function deleteTexte()
    {
        if ($this->request->isAJAX()) {
            helper(['Lang', 'Array']);
            if ($value = $this->request->getPost('value')) {

                $newTraitement = $this->traitement($value);

                try {

                    save_all_lang_file($newTraitement['file'], $newTraitement['lang'], $newTraitement['trad'], false, true);

                    $response = ['success' => ['code' => 200, 'message' => lang('Core.success_update')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200, 'Update translate');
                } catch (\Exception $e) {

                    $response = ['error' => ['code' => 500, 'message' => lang('Core.error_deleted_data') ?? $e->getMessage()], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 500);
                }
            }
        }
    }

    /**
     * Seach texte in files
     * 
     */
    public function searchTexte()
    {
        if ($this->request->isAJAX()) {
            helper(['Lang', 'Array']);
            if ($value = $this->request->getPost('value')) {

                $newTraitement = $this->traitement($value);

                if (isset($newTraitement['searchDirect'])) {
                    // SEARCH
                    $this->viewData['searchTextLang'] = search_text_lang($newTraitement['searchDirect'], $newTraitement['lang']);
                    if ($this->viewData['searchTextLang'] == true) {

                        $viewSearchDirect = $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\translate\viewSearchDirect', $this->viewData);
                        $response = ['success' => ['code' => 200, 'message' => lang('Core.success_update')], 'error' => false, csrf_token() => csrf_hash(), 'html' => $viewSearchDirect];
                        return $this->respond($response, 200, 'search translate');
                    } else {
                        $response = ['error' => ['code' => 500, 'message' => lang('Core.no_data_search') ?? $e->getMessage()], 'success' => false, csrf_token() => csrf_hash()];
                        return $this->respond($response, 500);
                    }
                }
            }
        }
    }

    /**
     * Save texte in file
     * 
     */
    public function saveTextfile()
    {
        if ($this->request->isAJAX()) {
            helper(['Lang', 'Array']);
            if ($value = $this->request->getPost('value')) {

                $newTraitement = $this->traitement($value);
                $firstKey = array_key_first($newTraitement['trad']);
                $fileOrigin = include($newTraitement['file']);
                $oldValue = $fileOrigin[$firstKey];

                helper(['String']);
                if (replaceInfile($newTraitement['file'], $firstKey, $oldValue, $newTraitement['trad'][$firstKey])) {
                    $response = ['success' => ['code' => 200, 'message' => lang('Core.success_update')], 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200, 'Update translate');
                } else {
                    $response = ['error' => ['code' => 500, 'message' => lang('Core.error_saved_data') ?? $e->getMessage()], 'success' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 500);
                }
            }
        }
    }


    public function traitement(array $value)
    {
        helper(['Lang', 'Array']);

        $newTraitement = [];
        $file = '';
        $lang = '';
        if (!is_array($value)) {
            return false;
        }
        foreach ($value as $k => $v) {

            if (preg_match('`\[(.+)\]`', $v['name'], $intro)) {
                if (preg_match("/texte/", $intro[1], $intro2)) {
                    $num = str_replace('][texte', '', $intro[1]);
                    $newTraitement['addTrad'][$num]['texte'] =  $v['value'];
                }
                if (preg_match("/value/", $intro[1], $intro2)) {
                    $num = str_replace('][value', '', $intro[1]);
                    $newTraitement['addTrad'][$num]['value'] =  $v['value'];
                }
                unset($v['name']);
            } else {
                if ($v['name'] != 'file' && $v['name'] != 'lang' && $v['name'] != 'searchDirect') {

                    // On verifie que le token n'est pas dedans
                    if (csrf_token() != $v['name']) {
                        // Récupére le name
                        $v['name'] = str_replace('name|', '', $v['name']);
                        $newTraitement['trad'][$v['name']] = $v['value'];
                    }
                } else {
                    if ($v['name'] == 'file') {
                        $newTraitement['file'] = $v['value'];
                    } else if ($v['name'] == 'lang') {
                        $newTraitement['lang'] = $v['value'];
                    } else {
                        $newTraitement['searchDirect'] = $v['value'];
                    }
                }
            }
        }
        if (isset($newTraitement['addTrad'])) {
            foreach ($newTraitement['addTrad'] as $k  => $v) {
                if (!empty($v['texte'])) {
                    $newTraitement['trad'][$v['texte']] = $v['value'];
                }
            }
        }
        return $newTraitement;
    }

    /**
     * Search path natif
     */
    protected function getCoreNatif($lang)
    {

        $loader  = service('autoloader');
        $locator = service('locator');

        $translate = [];

        // Get each namespace
        foreach ($loader->getNamespace() as $namespace => $path) {
            // print_r($namespace); exit;
            if ($namespace != 'Translations' && $namespace != 'CodeIgniter') {

                // Get files under this namespace's "/translate" path
                foreach ($locator->listNamespaceFiles($namespace, '/Language/' . $lang . '/') as $file) {
                    //$translate[] = $file;
                    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                        $pathinfo = (pathinfo($file));
                        // Load the file
                        $translate[$pathinfo['filename']] = $file;
                        //require_once $file;
                    }
                }
            }
        }

        return $translate;
    }


    /**
     * Copy files
     */
    protected function copyFile()
    {

        $temp = [];
        $this->isDir();

        foreach (Config('App')->supportedLocales as $lang) {
            $temp[$lang] = $files = $this->getCoreNatif($lang);

            foreach ($files  as $k => $v) {
                if (!is_file(APPPATH . '/Language/' . $lang . '/' . $k . '.php')) {
                    if (!copy($v, APPPATH . '/Language/' . $lang . '/' . $k . '.php')) {
                        throw new \RuntimeException(lang('Core.noCopyFile', [$k, $lang])  . ' ' . $lang);
                    }
                }
            }
        }

        return true;
    }

    /**
     * Search Dir
     */
    protected function isDir()
    {
        foreach (Config('App')->supportedLocales as $lang) {

            if (!is_dir(APPPATH . '/Language/' . $lang)) {
                mkdir(APPPATH . '/Language/' . $lang, 0777, true);
                //create the index.html file
                if (!is_file(APPPATH . '/Language/' . $lang . '/index.html')) {
                    $file = fopen(APPPATH . '/Language/' . $lang . '/index.html', 'x+');
                    fclose($file);
                }
            }
        }
    }
}
