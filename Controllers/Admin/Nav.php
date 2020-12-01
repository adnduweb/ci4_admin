<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Core\Entities\Tab;
use Adnduweb\Ci4Core\Models\TabModel;
use CodeIgniter\API\ResponseTrait;

class Nav extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

    /**
     * name controller
     */
    public $controller = 'navs';

    /**
     * Localize slug
     */
    public $pathcontroller  = '/settings-advanced';

    /**
     * name model
     */
    public $tableModel = TabModel::class;

    /**
     * Bouton add
     */
    public $add = true;

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

        parent::index();

        ///$this->setTag('title', lang('Core.menu'));
        $navs = $this->tableModel->orderBy('left', 'ACS')->get()->getResult();
        $this->viewData['navs']  = [];
        foreach ($navs as $nav) {
            $this->viewData['navs'][] = new Tab((array) $nav);
        }

        return $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\navs\index', $this->viewData);
    }


    /**
     * Create ressource
     */
    public function create()
    {
        parent::create();

        // Initialize form
        $this->viewData['form'] = new Tab($this->request->getPost());
        $this->viewData['menus'] = $this->tableModel->join('tabs_langs', 'tabs.id = tabs_langs.tab_id')->where('id_lang', 1)->orderBy('left', 'ACS')->get()->getResult();

        return $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\navs\form', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        // validate
        $tabs = new TabModel();
        $this->rules = [
            'class_name'      => 'required|is_unique[tabs.class_name,id,' . $this->request->getPost('id') . ']',
            'slug'            => 'required',
        ];
        if (!$this->validate($this->rules)) {
            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the user
        $tab = new Tab($this->request->getPost());

        $tab_parent = $this->tableModel->where('id', $tab->id_parent)->first();
        $tab->depth = ($tab_parent == false) ? '0' : $tab_parent->depth + 1;

        //Save
        try {

            $tabs->save($tab);
            $tabId = $tabs->insertID();
            $this->tabs_langs = $this->request->getPost('lang');
            $tab->saveLang($this->tabs_langs, $tabId);
        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' . $tabId);
    }



    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        parent::edit($id);

        helper(['Tools']);

        // Initialize form
        $this->viewData['form'] = $this->tableModel->where(['id' => $this->id])->first();
        $this->viewData['title_detail'] = $this->viewData['form']->class_name;
        $this->viewData['menus'] = $this->tableModel->join('tabs_langs', 'tabs.id = tabs_langs.tab_id')->where('id_lang', 1)->orderBy('left', 'ACS')->get()->getResult();

        return $this->_render('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\templates\navs\form', $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        parent::update($id);

        // validate
        $tabs = new TabModel();
        $this->rules = [
            'class_name'      => 'required|is_unique[tabs.class_name,id,' . $this->request->getPost('id') . ']',
            'slug'            => 'required',
        ];
        if (!$this->validate($this->rules)) {
            Theme::set_message('danger', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the user
        $tab = new Tab($this->request->getPost());
        $tab_parent = $this->tableModel->where('id', $tab->id_parent)->first();
        $tab->depth = ($tab_parent == false) ? '0' : $tab_parent->depth + 1;
        $this->tabs_langs = $this->request->getPost('lang');

        //Save
        try {

            $tabs->save($tab);
            $tab->saveLang($this->tabs_langs, $tab->id);
        } catch (\Exception $e) {

            Theme::set_message('danger', $e->getMessage(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return $this->_redirect('/edit/' . $tab->id);
    }



    public function sortMenu()
    {
        if ($this->request->isAJAX()) {
            if ($value = $this->request->getPost('value')) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        $tab = $this->tableModel->find($v['id']);
                        $tab->depth = $v['depth'];
                        $tab->left = $v['left'];
                        $tab->right = $v['right'];
                        $tab->id_parent = (isset($v['parent_id'])) ? $v['parent_id'] : 0;
                        $this->tableModel->save($tab);
                    }
                    //On vide le ccahe du user en cours
                    cache()->delete(config('cache')->cacheQueryString . "admin-" . $this->settings->setting_theme_admin . "-initMenu-" . user_id());

                    $currentUrlSegment = [CI_AREA_ADMIN, user()->company_id, 'settings-advanced', 'tabs'];

                    // On met à jour le menu
                    $htmlNav = view('Adnduweb\Ci4Admin\themes\/' . $this->settings->setting_theme_admin . '/\__partials/kt_aside', ['menu' =>  $this->tableModel->getTab(1), 'currentUrlSegment' => array_flip($currentUrlSegment), 'setting_activer_front' => service('Settings')->setting_activer_front]);
                    //$htmlNav = view($this->get_current_theme_view('__partials/kt_aside', 'default'), ['nav' =>  $this->tableModel->getTab(1), 'currentUrlSegment' => array_flip($currentUrlSegment), 'setting_activer_front' => Service('Settings')->setting_activer_front]);
                    $response = ['success' => ['code' => 200, 'message' => lang('Core.saved_data')], 'htmlNav' => $htmlNav, 'error' => false, csrf_token() => csrf_hash()];
                    return $this->respond($response, 200);
                }
            }
        }
    }

    /**
     * Get all Childrens
     *
     * @param  int $menu_id
     * @param  int $parent_id
     * @param  string $orderBy
     *
     * @return array
     */
    public function getChildrens($parent_id = null, $orderBy = 'asc')
    {
        return $this->tableModel
            ->where(['id_parent' => $parent_id])
            ->orderBy('position', $orderBy)
            ->get()->getResult();
    }

    /**
     * Check Root Parent
     *
     * @param  int $menu_id
     * @param  array $items
     *
     * @return array
     */
    public function checkParents($items)
    {
        foreach ($items as $item) {
            $this->root_depth = 0;
            $depth            = $this->getRootDepth($item->id_tab);

            if ($depth < 3) {
                $this->parents[] = $item;
            }
        }

        return $this->parents;
    }
    /**
     * Get root depth
     *
     * @param  int $id
     *
     * @return int
     */
    public function getRootDepth($id)
    {
        if ($menu = $this->tableModel->find($id)) {
            $this->root_depth++;

            if ($menu->id_parent) {
                $this->getRootDepth($menu->id_parent);
            }
        }

        return $this->root_depth;
    }

    public function trash($id = null)
    {

        // Permission
        if (!has_permission(ucfirst($this->controller) . '::delete', user()->id))
        {
            Theme::set_message('danger', lang('Core.not_acces_permission'), lang('Core.warning_error'));
            return $this->response->redirect(route_to('dashboard'));
         }
         
        if ($this->tableModel->delete($id)) {
            Theme::set_message('success', lang('Core.deletes_data'), lang('Core.cool_success'));
            return redirect()->back();
        }
    }
}
