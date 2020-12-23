<?php

namespace Adnduweb\Ci4Admin\Libraries;


class Theme
{
    public static $attrs;

    public static $classes;

    protected static $ignore_session = false;

    protected static $message;

    protected static $message_template = "
    <script type='text/javascript'>
    $(document).ready(function(){
        $.notify({
            title: '{title}',
            message: '{message}'
        },{
            type: '{type}',
            delay: 5000,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
    });</script>";

    public static $custom = 'app.js';

    protected static $scripts = array('external' => array(), 'inline' => array(), 'module' => array(), 'controller' => array(), 'vueJs' => array());

    protected static $styles = array('css' => array(), 'module' => array(), 'controller' => array());

    private static $debug = true;

    /**
     * The URI to use for matching routed assets.
     * Defaults to uri_string()
     *
     * @var string
     */
    protected $route;

    /**
     * Whether the route has been sanitized
     * Prevents re-processing on multiple display calls
     *
     * @var bool
     */
    protected $sanitized = false;

    /**
     * Route collection used to determine the default route (if needed).
     *
     * @var CodeIgniter\Router\RouteCollectionInterface
     */
    protected $collection;

    public static function addAttr($scope, $name, $value)
    {
        self::$attrs[$scope][$name] = $value;
    }

    public static function addClass($scope, $class)
    {
        self::$classes[$scope][] = $class;
    }

    public static function printAttrs($scope)
    {
        $attrs = [];

        if (isset(self::$attrs[$scope]) && !empty(self::$attrs[$scope])) {
            foreach (self::$attrs[$scope] as $name => $value) {
                $attrs[] = $name . '="' . $value . '"';
            }
            echo ' ' . implode(' ', $attrs) . ' ';
        }
        echo '';
    }

    public static function printClasses($scope, $full = true)
    {
        helper('auth');

        $controller = \Config\Services::router();
        $controllerName = explode('\\',  $controller->controllerName());

        if ($scope == 'body') {
            $setting_aside_back = (service('settings')->setting_aside_back == '1') ? 'aside-fixed aside-minimize' : 'aside-fixed';
            self::$classes[$scope][] = 'ps_back-office html controller_' . strtolower(end($controllerName)) . ' method_' . strtolower($controller->methodName()) . ' lang-' . service('request')->getLocale() . ' header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled page-loading-enabled page-loading ' . $setting_aside_back;
        }

        if (service('settings')->setting_aside_back == '1'){ 
            self::$classes[$scope][] .= 'aside--fixed kt-aside--minimize kt-aside-minimize-hoverable';
        }else{
          
            self::$classes[$scope][] .= 'kaside--fixed';
        } 

        if (isset(self::$classes[$scope]) && !empty(self::$classes[$scope])) {
            $classes = implode(' ', self::$classes[$scope]);
            if ($full) {
                if (logged_in()) {
                    echo 'class="' . $classes . '" onload="StartTimers();" onmousemove="ResetTimers();"';
                } else {
                    echo 'class="' . $classes . '"';
                }
            } else {
                if (logged_in()) {
                    echo $classes . ' " onload="StartTimers();" onmousemove="ResetTimers();"';
                } else {
                    echo ' class="' . $classes . '"';
                }
                echo $classes . ' ';
            }
        } else {
            echo '';
        }
    }

    /**
     * Prints Google Fonts
     */
    public static function getGoogleFontsInclude()
    {
        if (config('Theme')->layout['resources']['fonts']['google']['families']) {
            $fonts = config('Theme')->layout['resources']['fonts']['google']['families'];
            echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . implode('|', $fonts) . '">';
        }
        echo '';
    }

    /**
     * Walk recursive array with callback
     * @param array    $array
     * @param callable $callback
     * @return array
     */
    public static function arrayWalkCallback(array &$array, callable $callback)
    {
        foreach ($array as $k => &$v) {
            if (is_array($v)) {
                $callback($k, $v, $array);
                self::arrayWalkCallback($v, $callback);
            }
        }

        return $array;
    }

    /**
     * Convert css file path to RTL file
     */
    public static function rtlCssPath($css_path)
    {
        $css_path = substr_replace($css_path, '.rtl.css', -4);

        return $css_path;
    }

    /**
     * Initialize theme CSS files
     */
    public static function initThemes()
    {
        $themes = [];

        $themes[] = 'css/themes/layout/header/base/' . config('Theme')->layout['header']['self']['theme'] . '.css';
        $themes[] = 'css/themes/layout/header/menu/' . config('Theme')->layout['header']['menu']['desktop']['submenu']['theme'] . '.css';
        $themes[] = 'css/themes/layout/aside/' . config('Theme')->layout['aside']['self']['theme'] . '.css';

        if (config('Theme')->layout['aside']['self']['display']) {
            $themes[] = 'css/themes/layout/brand/' . config('Theme')->layout['brand']['self']['theme'] . '.css';
        } else {
            $themes[] = 'css/themes/layout/brand/' . config('Theme')->layout['brand']['self']['theme'] . '.css';
        }

        return $themes;
    }

    /**
     * Get SVG content
     * @param string $filepath
     * @param string $class
     *
     * @return string|string[]|null
     */
    public static function getSVG($filepath, $class = '', $nav = false)
    {
        $filepath = ROOTPATH . '/public/admin/themes/' . service('settings')->setting_theme_admin . '/' . $filepath;
        if (!is_string($filepath) || !file_exists($filepath)) {
            return '';
        }

        $svg_content = file_get_contents($filepath);

        $dom = new \DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }
        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }
        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }
        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }
        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }
        $path = $dom->getElementsByTagName('path');
        foreach ($path as $el) {
            $el->removeAttribute('id');
        }
        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }
        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }
        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }
        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = array('svg-icon');
        if (!empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        //echo '<span class="' . implode(' ', $cls) . '"><!--begin::Svg Icon | path:' . $filepath . '-->' . $string . '<!--end::Svg Icon--></span>';;
        if ($nav == true) {
            echo '<span class="nav-icon"><span class="' . implode(' ', $cls) . '"><!--begin::Svg Icon | path:' . $filepath . '-->' . $string . '<!--end::Svg Icon--></span></span>';
        } else {
            echo '<span class="' . implode(' ', $cls) . '"><!--begin::Svg Icon | path:' . $filepath . '-->' . $string . '<!--end::Svg Icon--></span>';
        }
    }

    /**
     * Check if $path provided is SVG
     */
    public static function isSVG($path)
    {
        if (is_string($path)) {
            return substr(strrchr($path, '.'), 1) === 'svg';
        }

        return false;
    }

    /**
     * --------------------------------------------------------------------------------------------------------------
     * Get message Toast on application
     * --------------------------------------------------------------------------------------------------------------
     */

    public static function set_message($type = 'info', $message = '', $title = 'info')
    {
        if (empty($message)) {
            return;
        }
        $session = \Config\Services::session();

        if (!self::$ignore_session && isset($session)) {
            //echo serialize($message); exit;
            $message = serialize($message);
            $session->setFlashdata('message', "{$type}::{$message}::{$title}");
        }

        self::$message = array(
            'type' => $type,
            'message' => $message,
            'title' => $title
        );
    }

    public static function message($type = 'information', $message = '', $title = 'standard')
    {
        helper('html');
        // Does session data exist?
        $session = \Config\Services::session();

        if (empty($message) && !self::$ignore_session) {
            $message = $session->getFlashdata('message');
            if (!empty($message)) {
                // Split out the message parts
                $temp_message = explode('::', $message);
                if (count($temp_message) > 3) {
                    $type = $temp_message[0];
                    $message = $temp_message[1];
                    $title = $temp_message[2];
                } else {
                    $type = $temp_message[0];
                    $message = $temp_message[1];
                    $title = $temp_message[2];
                }

                unset($temp_message);
            }
        }



        // If message is empty, check the $message property.
        if (empty($message)) {
            if (empty(self::$message['message'])) {
                return '';
            }
            $message = unserialize(self::$message['message']);
            $type = self::$message['type'];
            $title = self::$message['title'];
        }
        $message = unserialize($message);
        $templateVarMessage = '';
        if (is_array($message) && !empty($message)) {
            $templateVarMessage .= '<ul>';
            foreach ($message as $k => $v) {
                $templateVarMessage .= '<li>' . addslashes($v) . '</li>';
            }
            $templateVarMessage .= '</ul>';
        } else {
            $templateVarMessage = addslashes($message);
        }

        $template = str_replace(
            array('{title}', '{type}', '{message}', '{title}'),
            array($title, $type, minify_html($templateVarMessage)),
            self::$message_template
        );

        return $template;
    }

    /**
     * --------------------------------------------------------------------------------------------------------------
     * Assets management js*, css*, media*
     * --------------------------------------------------------------------------------------------------------------
     */

    public static function add_js($script = null, $type = 'external', $prepend = false, $vueJs = false)
    {
        $themeCurrent = service('settings')->setting_theme_admin;

        if (is_array($script) && count($script)) {
           
            foreach ($script as &$scrip) {
                //Dectect url
                $retour = strstr($scrip, '://', true);
                if (!$retour) {
                    if (env('CI_WEBPACK_MIX') == 'true') {
                        $scrip = str_replace("/resources/" . $themeCurrent, '/' . ENVIRONMENT, $scrip);
                        $scrip = '/admin/themes/' . $themeCurrent . $scrip;
                    } else {
                        $scrip = '/admin/themes/' . $themeCurrent . $scrip;
                    }
                }
            }
        } else {
            $retour = strstr($script, '://', true);
            //print_r($script); exit;
            if (!$retour) {
                if (env('CI_WEBPACK_MIX') == 'true') {
                    $script = str_replace("/resources/" . $themeCurrent, '/' . ENVIRONMENT, $script);
                    $script = '/admin/themes/' . $themeCurrent . $script;
                } else {
                    $script = '/admin/themes/' . $themeCurrent . $script;
                }
            }
        }


        if (empty($script)) {
            return;
        }
        if (is_string($script)) {
            $script = array(
                $script
            );
        }
        $scriptsToAdd = array();
        if (is_array($script) && count($script)) {
            foreach ($script as $s) {
                if (!in_array($s, self::$scripts[$type])) {
                    $scriptsToAdd[] = $s;
                }
            }
        }
        if ($prepend) {
            self::$scripts[$type] = array_merge($scriptsToAdd, self::$scripts[$type]);
        } else {
            self::$scripts[$type] = array_merge(self::$scripts[$type], $scriptsToAdd);
        }
    }

    public static function add_module_js($module = '', $file = '')
    {
        if (empty($file)) {
            return;
        }
        if (is_string($file)) {
            $file = array(
                $file
            );
        }
        if (is_array($file) && count($file)) {
            foreach ($file as $s) {
                self::$scripts['module'][] = array(
                    'module' => $module,
                    'file' => $s
                );
            }
        }
    }

    public static function js($script = null, $type = 'external')
    {
        if (!empty($script)) {
            if (is_string($script) && $type == 'external') {
                return self::external_js($script);
            }
            self::add_js($script, $type);
        }


        $output = '<!-- Local JS files -->' . PHP_EOL;
        helper('auth');
        if (logged_in() == true) {
            $url = '\admin\themes\/'. service('settings')->setting_theme_admin .'\/' . ENVIRONMENT . '\js\app.js';
            if (is_file(env('DOCUMENT_ROOT') . $url)) {
                $output .=  self::buildScriptElement($url, 'text/javascript') . "\n";
            } else {
            }
        }

        $output .= self::external_js();
        $output .= self::module_js();
        $output .= self::vue_js();
        $output .= self::inline_js();
        return $output;
    }

    public static function external_js($extJs = null, $list = false, $addExtension = true, $bypassGlobals = false, $bypassInheritance = false)
    {

        $return             = '';
        $scripts            = array();
        $renderSingleScript = false;
        if (empty($extJs)) {
            $scripts = self::$scripts['external'];
        } elseif (is_string($extJs)) {
            $scripts[]          = $extJs;
            $renderSingleScript = true;
        } elseif (is_array($extJs)) {
            $scripts = $extJs;
        }


        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                $return .= self::buildScriptElement($script, 'text/javascript') . "\n";
            }
        }

        return trim($return, ', ');
    }

    public static function vue_js($extJs = null, $list = false, $addExtension = true, $bypassGlobals = false, $bypassInheritance = false)
    {

        $return             = '';
        $scripts            = array();
        $renderSingleScript = false;
        if (empty($extJs)) {
            $scripts = self::$scripts['vueJs'];
        } elseif (is_string($extJs)) {
            $scripts[]          = $extJs;
            $renderSingleScript = true;
        } elseif (is_array($extJs)) {
            $scripts = $extJs;
        }



        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                $return .= self::buildScriptElement($script, 'module') . "\n";
            }
        }

        return trim($return, ', ');
    }

    public static function module_js($list = false, $cached = false)
    {
        if (empty(self::$scripts['module']) || !is_array(self::$scripts['module'])) {
            return '';
        }
        $scripts = self::find_files(self::$scripts['module'], 'js');
        $src     = self::combine_js($scripts, 'module') . ($cached ? '' : '?_dt=' . time());
        if ($list) {
            return '"' . $src . '"';
        }
        return self::buildScriptElement($src, 'text/javascript') . "\n";
    }

    public static function inline_js()
    {
        if (empty(self::$scripts['inline'])) {
            return;
        }
        $content = self::$ci->config->item('assets.js_opener') . "\n";
        $content .= implode("\n", self::$scripts['inline']);
        $content .= "\n" . self::$ci->config->item('assets.js_closer');
        return self::buildScriptElement('', 'text/javascript', $content);
    }

    protected static function buildScriptElement($src = '', $type = '', $content = '')
    {
        if (!file_exists(env('DOCUMENT_ROOT') . $src) && !strstr($src, '://', true)) {
            return '<div class="red-not-script" style="position: absolute; z-index: 99999;background: #c32d00; width: 100%; color: #fff;  padding: 10px;"> le lien n\'existe pas : ' . $src . '</div>';
        }
        if (empty($src) && empty($content)) {
            return '';
        }
        $return = '<script';
        if (!empty($type)) {
            $return .= ' type="' . htmlspecialchars($type, ENT_QUOTES) . '"';
        }
        if (!empty($src) && !strstr($src, '://', true)) {
            $return .= ' src="' . htmlspecialchars(base_url($src), ENT_QUOTES) . '?v=' . filemtime(env('DOCUMENT_ROOT') . $src) . '"';
        }
        if (!empty($src) && strstr($src, '://', true)) {
            $return .= ' src="' . htmlspecialchars(base_url($src), ENT_QUOTES) . '"';
        }
        $return .= '>';
        if (!empty($content)) {
            $return .= "\n{$content}\n";
        }
        return "{$return}</script>";
    }
    protected static function buildStyleLink(array $style)
    {
        $default    = array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'href' => '',
            'media' => 'all'
        );
        $styleToAdd = array_merge($default, $style);
        $final      = '<link';
        foreach ($default as $key => $value) {
            $final .= " {$key}='" . htmlspecialchars($styleToAdd[$key], ENT_QUOTES) . "'";
        }
        $style =  "{$final} />";
        echo $style  . "\n";
    }

    public function assets_url($path = null) 
    {
        return $path;
    }

    // Cleans up the route and expands implicit segments
    protected function sanitizeRoute()
    {
        if ($this->sanitized) {
            return;
        }

        // If no route was specified then load the current URI string
        if (is_null($this->route)) {
            $this->route = uri_string();
        }

        // If no collection was specified then load the default shared
        if (is_null($this->collection)) {
            $this->collection = Services::routes();
        }

        // Sanitize characters
        $this->route = filter_var($this->route, FILTER_SANITIZE_URL);

        // Clean up slashes
        $this->route = trim($this->route, '/');

        // Verify for {locale}
        if (Config::get('App')->negotiateLocale) {
            $route = explode('/', $this->route);
            if (count($route) && $route[0] == Services::request()->getLocale()) {
                unset($route[0]);
            }
            $this->route = implode('/', $route);
        }

        // If the route is empty then assume the default controller

        if (empty($this->route)) {
            $this->route = strtolower($this->collection->getDefaultController());
        }

        // Always check the default method in case the route is implicit
        $defaultMethod = $this->collection->getDefaultMethod();
        if (!preg_match('/' . $defaultMethod . '$/', $this->route)) {
            $this->route .= '/' . $defaultMethod;
        }

        $this->sanitized = true;
    }
}
