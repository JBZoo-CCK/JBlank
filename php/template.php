<?php
/**
 * J!Blank Template for Joomla by Joomla-book.ru
 * @category   JBlank
 * @author     smet.denis <admin@joomla-book.ru>
 * @copyright  Copyright (c) 2009-2012, Joomla-book.ru
 * @license    GNU GPL
 * @link       http://joomla-book.ru/projects/jblank JBlank project page
 */
defined('_JEXEC') or die('Restricted access');


jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class JBlankTemplate
{
    /**
     * Others
     */
    const FILE_SIZE_MIN     = 10;
    const JS_JQUERY_VERSION = '1.7.1';

    /**
     *  Default params values
     */
    const PARAM_DEFAULT_FILES_MDATE    = 3;
    const PARAM_DEFAULT_META_GENERATOR = 'J!Blank Template by Joomla-book.ru';

    /**
     * Joomla mootools scripts that need to be disabled
     */
    private $_mootoolsScripts = array(
        '/media/system/js/core.js',
        '/media/system/js/core-uncompressed.js',
        '/media/system/js/mootools-core.js',
        '/media/system/js/mootools-core-uncompressed.js',
        '/media/system/js/caption.js',
        '/media/system/js/caption-uncompressed.js',
        '/media/system/js/mootools-more.js',
        '/media/system/js/mootools-more-uncompressed.js'
    );

    /**
     * @var JDocumentHTML
     */
    public $_document = null;

    /**
     * @var JRegistry
     */
    public $config = null;

    /**
     * @var JURI
     */
    public $url;

    /**
     * @var JApplication
     */
    public $app;

    /**
     * @var JMenu
     */
    public $menu;

    /**
     * @var JRegistry
     */
    public $params;

    /**
     * @var JUser
     */
    public $user;

    public $path;
    public $flash;
    public $img;
    public $css;
    public $js;
    public $pathFull;
    public $flashFull;
    public $imgFull;
    public $cssFull;
    public $jsFull;
    public $date;
    public $langDefault;
    public $lang;
    public $itemidDefault;
    public $itemidCurrent;
    public $isFront;
    public $title;
    public $sitename;
    public $req;
    public $isError;
    public $baseurl;
    public $dir;
    public $positionData = array();

    /**
     * @var array
     */
    private $_scriptList = array();

    /**
     * @var array
     */
    private $_scriptDeclarationsList = array();


    /**
     * JBlankTemplate constructor
     * Initialization internal vars
     * @param JDocument $thisTemplate
     */
    public function __construct(JDocument $thisTemplate)
    {
        // get links to global vars
        $this->_document = $thisTemplate;
        $this->config    = JFactory::getConfig();
        $this->url       = JFactory::getURI();
        $this->app       = JFactory::getApplication();
        $this->menu      = $this->app->getMenu();
        $this->params    = $this->app->getTemplate(true)->params;
        $this->user      = JFactory::getUser();

        // relative paths
        $this->path  = $this->_getTemplatePath();
        $this->flash = $this->path . '/flash';
        $this->img   = $this->path . '/images';
        $this->css   = $this->path . '/css';
        $this->js    = $this->path . '/js';

        // absolute paths
        $this->pathFull  = $this->_getTemplatePathFull();
        $this->flashFull = $this->pathFull . DS . 'flash';
        $this->imgFull   = $this->pathFull . DS . 'images';
        $this->cssFull   = $this->pathFull . DS . 'css';
        $this->jsFull    = $this->pathFull . DS . 'js';

        // init template vars
        $this->langDefault   = $this->_getLangDefault();
        $this->lang          = $this->_getLangCurrent();
        $this->itemidDefault = $this->_getItemidDefault();
        $this->itemidCurrent = $this->_getItemidCurrent();
        $this->isFront       = $this->_isFront();
        $this->title         = $this->_getTitle();
        $this->sitename      = $this->_getSitename();
        $this->req           = $this->_getRequest();
        $this->isError       = $this->_isErrors();
        $this->baseurl       = $this->_document->baseurl;
        $this->dir           = $this->_document->getDirection();
    }

    /**
     * Load all enabled CSS files
     */
    public function loadCSS()
    {
        if ($this->params->get('css_base', 0)) {
            $this->includeCSS('base.css');
        }

        if ($this->params->get('css_typography', 0)) {
            $this->includeCSS('typography.css');
        }

        if ($this->params->get('css_grid', 0)) {
            $this->includeCSS('grid.css');
        }

        if ($this->params->get('css_styles', 0)) {
            $this->includeCSS('_styles.css');
        }

        // css autodetect
        if ($this->params->get('css_auto', 0)) {
            $this->includeCSS($this->req->tmpl . '.css', 'tmpl');
            $this->includeCSS($this->req->option . '.css');
            $this->includeIEHacks();
        }

        if ($this->isError) {
            $this->includeCSS('system.css');
        }
    }

    /**
     * Load all enabled Metatags
     */
    public function loadMeta()
    {
        $generator = $this->params->get('meta_generator', self::PARAM_DEFAULT_META_GENERATOR);
        if ($generator) {
            $this->_document->setGenerator($generator);
        }

        $this->_addCustomTag('<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />');
        $this->_addCustomTag('<meta name="viewport" content="width=device-width" />');
    }

    /**
     * Include JS in Top
     * @param $jsPath
     */
    public function includeTopJS($jsPath)
    {
        $this->_document->_scripts = $this->_array_unshift_assoc(
            $this->_document->_scripts, $jsPath, array(
                'mime'  => 'text/javascript',
                'defer' => false,
                'async' => false,
            )
        );

    }

    /**
     * Load all enabled JS files
     */
    public function loadJS()
    {
        if ((int)$this->params->get('js_modernizr', 0)) {
            $this->includeJS('libs/modernizr.min.js');
        }

        // jQuery Framework
        $jqueryCore   = false;
        $jsJqueryCore = (int)$this->params->get('js_jquery_core', 0);
        if ($jsJqueryCore != '0') {
            if ($jsJqueryCore == '1') {
                $jqueryCore = $this->js . '/libs/jquery.core.min.js?v=' . self::JS_JQUERY_VERSION;

            } elseif ($jsJqueryCore == '2') {
                $jqueryCore = 'http://yandex.st/jquery/' . self::JS_JQUERY_VERSION . '/jquery.min.js';

            } elseif ($jsJqueryCore == '3') {
                $jqueryCore =
                    'http://ajax.googleapis.com/ajax/libs/jquery/' . self::JS_JQUERY_VERSION . '/jquery.min.js';
            }

            if ((int)$this->params->get('js_jquery_tools', 0)) {
                $this->includeJS('libs/jquery.tools.js');
            }

            if ((int)$this->params->get('js_jquery_validate', 0)) {
                $this->includeJS('libs/jquery.validate.min.js');
                $this->includeJS('libs/jquery.validate-methods.min.js');
            }

            if ((int)$this->params->get('js_jquery_meiomask', 0)) {
                $this->includeJS('libs/jquery.meiomask.min.js');
            }

        }

        if ((int)$this->params->get('js_script', 1)) {
            $this->includeJS('functions.js');
            $this->includeJS('application.js');
        }

        if ((int)$this->params->get('js_bottom', 1)) {
            $this->_scriptList             = $this->_document->_scripts;
            $this->_scriptDeclarationsList = $this->_document->_script;
            $this->_document->_scripts     = array();
            $this->_document->_script      = array();
        }

        $jqueryCore && $this->includeTopJS($jqueryCore);
    }

    /**
     * Include IE Hacks CSS (autosearch)
     * @return bool
     */
    public function includeIEHacks()
    {
        $cssFiles   = JFolder::files($this->cssFull, 'msie');
        $conditions = array('lt', 'lte', 'gt', 'gte');
        $mdate      = $this->params->get('files_mdate', self::PARAM_DEFAULT_FILES_MDATE);

        if (count($cssFiles)) {
            foreach ($cssFiles as $cssFile) {
                $version = $condition = $not = '';
                $cssFile = JFile::stripExt($cssFile);
                $cssInfo = explode('-', $cssFile);

                if (strpos($cssFile, 'msie') !== false) {

                    foreach ($conditions as $cond) {
                        if (in_array($cond, $cssInfo) !== false) {
                            $condition = $cond . ' ';
                            break;
                        }
                    }

                    if (count($cssInfo) > 0) {
                        foreach ($cssInfo as $info) {
                            if ((int)$info > 5) {
                                $version = $info;
                                break;
                            }
                        }
                    }

                    $cssPath = $this->cssFull . DS . $cssFile . '.css';
                    if ($filemtime = $this->_checkFile($cssPath)) {
                        $filePath = $this->css . '/' . $cssFile . '.css';
                        if ($mdate == '2' || $mdate == '3') {
                            $filePath .= '?' . $filemtime;
                        }
                        $this->_addStylesheetIE($filePath, $version, $condition);
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Don't load Mootools framework (experimental!)
     * @param $force
     */
    public function removeMootools($force = false)
    {
        if (!(int)$this->params->get('js_joomla', 1) || $force) {

            foreach ($this->_mootoolsScripts as $path) {
                if (isset($this->_document->_scripts[$path])) {
                    unset($this->_document->_scripts[$path]);
                }
            }

            // experimental remove "JCaption init"
            $reg = "#window\.addEvent\('load',\s*function\(\)\s*\{\s*new\s*JCaption\(.*\);\s*}\)\s*;#ius";
            foreach ($this->_document->_script as $key=> $script) {

                $script = preg_replace($reg, " ", $script);
                if (!JString::trim($script)) {
                    unset($this->_document->_script[$key]);
                } else {
                    $this->_document->_script[$key] = $script;
                }
            }

        }
    }

    /**
     * Load template language files
     * @return bool
     */
    public function loadLanguages()
    {
        return JFactory::getLanguage()->load('tpl_jblank', JPATH_THEMES . '/jblank/language');
    }

    /**
     * Internal method for add Custom tag in <head />
     * @param $metaHTML
     * @return mixed
     */
    private function _addCustomTag($metaHTML)
    {
        return $this->_document->addCustomTag($metaHTML);
    }

    /**
     * Are there any errors on this page?
     * @return bool
     */
    private function _isErrors()
    {
        $buffer = $this->_document->getBuffer('message');

        if (is_array($buffer)) {
            $bufferWords = JString::trim(strip_tags(current($buffer['message'])));
        } else {
            $bufferWords = JString::trim(strip_tags($buffer));
        }

        return !empty($bufferWords);
    }

    /**
     * Internal method for add Stylesheet (IE)
     * @param string $src
     * @param string $version
     * @param string $condition
     * @return mixed
     */
    private function _addStylesheetIE($src, $version, $condition = '')
    {
        $metaHTML = '<!--[if ' . $condition . 'IE ' . $version . ']>'
            . '<link href="' . $src . '" type="text/css" rel="stylesheet" media="all" />'
            . '<![endif]-->';
        return $this->_addCustomTag($metaHTML);
    }

    /**
     * Include CSS file in Joomla template
     * @param string $filename CSS file name
     * @param string $prefix   CSS prefix file name
     * @param string $type     CSS type
     * @return bool
     */
    public function includeCSS($filename, $prefix = '', $type = 'all')
    {
        $mdate   = $this->params->get('files_mdate', self::PARAM_DEFAULT_FILES_MDATE);
        $prefix  = (!empty($prefix) ? $prefix . '_' : '');
        $CSSPath = $this->cssFull . DS . $prefix . $filename;

        if ($filemtime = $this->_checkFile($CSSPath)) {
            $filePath = $this->css . '/' . $prefix . $filename;
            if ($mdate == '2' || $mdate == '3') {
                $filePath .= '?' . $filemtime;
            }
            $this->_addStylesheet($filePath, $type);
            return true;
        }

        return false;
    }

    /**
     * Internal method for add Stylesheet
     * @param $filePath
     * @param $type
     * @return JDocument
     */
    private function _addStylesheet($filePath, $type)
    {
        return $this->_document->addStylesheet($filePath, 'text/css', $type);
    }

    /**
     * Include JS file in Joomla template
     * @param string $filename JS file name
     * @param string $prefix   JS prefix file name
     * @return bool
     */
    public function includeJS($filename, $prefix = '')
    {
        $mdate  = $this->params->get('files_mdate', self::PARAM_DEFAULT_FILES_MDATE);
        $prefix = (strlen($prefix) ? $prefix . '_' : '');
        $JSPath = $this->jsFull . DS . $prefix . $filename;

        if ($filemtime = $this->_checkFile($JSPath)) {
            $filePath = $this->js . '/' . $prefix . $filename;
            if ($mdate == '1' || $mdate == '3') {
                $filePath .= '?' . $filemtime;
            }
            $this->_addScript($filePath);
            return true;
        }

        return false;
    }


    public function renderJS()
    {
        $output = array();
        foreach ($this->_scriptList as $path=> $script) {
            $output[] = '<script src="' . $path . '" type="text/javascript"></script>';
        }

        $lnEnd  = $this->_document->_getLineEnd();
        $tab    = $this->_document->_getTab();
        $tagEnd = ' />';
        $buffer = '';

        // Generate script file links
        foreach ($this->_scriptList as $strSrc => $strAttr) {
            $buffer .= $tab . '<script src="' . $strSrc . '"';
            if (!is_null($strAttr['mime'])) {
                $buffer .= ' type="' . $strAttr['mime'] . '"';
            }
            if ($strAttr['defer']) {
                $buffer .= ' defer="defer"';
            }
            if ($strAttr['async']) {
                $buffer .= ' async="async"';
            }
            $buffer .= '></script>' . $lnEnd;
        }

        // Generate script declarations
        foreach ($this->_scriptDeclarationsList as $type => $content) {

            $buffer .= $tab . '<script type="' . $type . '">' . $lnEnd;

            if ($this->_document->_mime != 'text/html') {
                $buffer .= $tab . $tab . '<![CDATA[' . $lnEnd;
            }

            $buffer .= $content . $lnEnd;

            if ($this->_document->_mime != 'text/html') {
                $buffer .= $tab . $tab . ']]>' . $lnEnd;
            }
            $buffer .= $tab . '</script>' . $lnEnd;
        }

        return $buffer;
    }

    /**
     * Get the site name from configuration.php
     * @return string
     */
    private function _getSitename()
    {
        $sitename = $this->config->get('sitename', '');
        return $sitename;
    }

    /**
     * Get vars from request
     * @return stdClass
     */
    private function _getRequest()
    {
        $request         = new stdClass();
        $request->option = JRequest::getVar('option', '');
        $request->view   = JRequest::getVar('view', '');
        $request->layout = JRequest::getVar('layout', '');
        $request->tmpl   = JRequest::getVar('tmpl', 'index');
        $request->lang   = $this->lang;
        $request->Itemid = $this->itemidCurrent;
        return $request;
    }

    /**
     * Get relative template path (for browser)
     * @return string
     */
    private function _getTemplatePath()
    {
        $path = 'templates/' . $this->_document->template;
        return $path;
    }

    /**
     * Get absolute template path (filesystem)
     * @return string
     */
    private function _getTemplatePathFull()
    {
        $path = JPATH_THEMES . DS . $this->_document->template;
        return $path;
    }

    /**
     * Get default menu item
     * @return int
     */
    private function _getItemidDefault()
    {
        return $this->menu->getDefault()->id;
    }

    /**
     * Get current menu itemId
     * @return int
     */
    private function _getItemidCurrent()
    {
        if (isset($this->menu->getActive()->id)) {
            return $this->menu->getActive()->id;
        }

        return 0;
    }

    /**
     * Add JavaScript in document head
     * @param $src
     * @return JDocument
     */
    private function _addScript($src)
    {
        return $this->_document->addScript($src);
    }

    /**
     * Is current url homepage
     * @return bool
     */
    private function _isFront()
    {
        $isFront = ($this->itemidDefault == $this->itemidCurrent) ? true : false;
        return $isFront;
    }

    /**
     * Get current date
     * @param string $format
     * @return string
     */
    private function _getDateCurrent($format)
    {
        return $this->getDate($format);
    }

    /**
     * Get a date for a given format
     * @param string $format
     * @param string $time
     * @return string
     */
    public function getDate($format, $time = 'now')
    {
        $date       = JFactory::getDate('now', $this->config->get('offset'));
        $dateString = $date->toFormat($format);
        return $dateString;
    }

    /**
     * Get site language
     * @return string
     */
    private function _getLangDefault()
    {
        $lang = explode('-', $this->_document->getLanguage());
        return $lang[0];
    }

    /**
     * Get current site language
     * @return string
     */
    private function _getLangCurrent()
    {
        $lang = JRequest::getVar('lang', $this->langDefault);
        return $lang;
    }

    /**
     * Get current document title
     * @return string
     */
    private function _getTitle()
    {
        $title = $this->_document->getTitle();
        return $title;
    }

    /**
     * Check file exists and return last modified
     * @param $path
     * @return int|null
     */
    private function _checkFile($path)
    {
        if (JFile::exists($path) && filesize($path) > self::FILE_SIZE_MIN) {
            $mdate = filemtime($path);
            return $mdate;
        }

        return null;
    }

    /**
     * Unshift assoc array
     * @param array  $arr
     * @param string $key
     * @param mixed  $val
     * @return array
     */
    private function _array_unshift_assoc($arr, $key, $val)
    {
        $arr       = array_reverse($arr, true);
        $arr[$key] = $val;
        $arr       = array_reverse($arr, true);
        return $arr;
    }
}
