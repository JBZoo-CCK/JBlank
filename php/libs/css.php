<?php
/**
 * J!Blank Template for Joomla by JBlank.pro (JBZoo.com)
 *
 * @package    JBlank
 * @author     SmetDenis <admin@jbzoo.com>
 * @copyright  Copyright (c) JBlank.pro
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 * @link       http://jblank.pro/ JBlank project page
 */

defined('_JEXEC') or die;


/**
 * Class JBlank
 */
abstract class JBlankCss
{
    /**
     * @var string
     */
    public $type = '';

    /**
     * @var JBlankTemplate
     */
    protected $_tpl = null;

    /**
     * @var mixed
     */
    protected $_processor = null;

    /**
     * @var string
     */
    protected $_filter = '.';

    /**
     * @var string
     */
    protected $_path = null;

    /**
     * @param JBlankTemplate $tpl
     */
    public function __construct(JBlankTemplate $tpl)
    {
        $this->_tpl  = $tpl;
        $this->_path = $tpl->pathFull;

        $this->_processor = $this->_initProcessor($tpl);
    }

    /**
     * @param string $type
     * @param JBlankTemplate $tpl
     * @throws Exception
     * @return JBlankCss
     */
    public static function getProcessor($type = 'less.leafo', JBlankTemplate $tpl)
    {
        $pluginPath = dirname(__FILE__) . '/css.' . $type . '.php';
        if (file_exists($pluginPath)) {
            include_once $pluginPath;
        }

        $type  = str_replace('.', '', $type);
        $class = 'JBlankCss' . $type;

        if (class_exists($class)) {
            $processor       = new $class($tpl);
            $processor->type = $type;
        } else {
            throw new Exception('Undefined CSS processor');
        }

        return $processor;
    }

    /**
     * @param $file
     * @return string
     */
    public function compile($file)
    {
        $debug    = $this->_isDebug();
        $file     = JPath::clean($file);
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $tplName  = $this->_tpl->doc->template;

        $hash      = $this->_getHash($file, $this->_path, $this->_filter);
        $path      = '/cache/' . $tplName . '/styles-' . $filename . '-' . $this->type . ($debug ? '-debug' : '') . '.css';
        $relPath   = rtrim($this->_tpl->baseurl, '/') . $path;
        $cachePath = JPath::clean(JPATH_ROOT . '/' . $path);

        $updateFile = false;
        if (JFile::exists($cachePath)) {

            // quickest way for getting first file line
            $cacheRes  = fopen($cachePath, 'r');
            $firstLine = fgets($cacheRes);
            fclose($cacheRes);

            // check cacheid
            if (!preg_match('#' . $hash . '#i', $firstLine)) {
                $updateFile = true;
            }

        } else {
            $updateFile = true;
        }

        if ($updateFile) {
            $css = $this->_compile($file);
            $css = '/* cacheid:' . $hash . " */\n" . $css;
            $this->_save($cachePath, $css);
        }

        if (filesize($cachePath) > 5) {
            $mtime = substr(filemtime($cachePath), -3);
            return $relPath . '?' . $mtime;
        }

        return null;
    }


    /**
     * @return bool
     */
    protected function _isDebug()
    {
        return $this->_tpl->isDebug();
    }

    /**
     * @param $file
     * @param null $path
     * @param $filter
     * @return string
     */
    protected function _getHash($file, $path = null, $filter = '.')
    {
        $hash = array(
            '_file'   => $file,
            '_type'   => $this->type,
            '_dir'    => $this->_path,
            '_filter' => $this->_filter,
            '_debug'  => $this->_isDebug() ? '1' : '0',
        );

        if ($path) {
            $files = JFolder::files($path, $filter, true, true);
            sort($files);
            foreach ($files as $file) {
                $hash[$file] = md5_file($file);
            }
        }

        $hash = md5(serialize($hash));

        return $hash;
    }

    /**
     * @param $file
     * @param $data
     * @return bool
     */
    protected function _save($file, $data)
    {
        $dir = dirname($file);
        if (!JFolder::exists($dir)) {
            JFolder::create($dir);
        }

        return JFile::write($file, $data);
    }

    /**
     * @return array
     */
    protected function _getCustomVars()
    {
        return array(
            'fontpath' => '"' . $this->_tpl->fonts . '"',
            'imgpath'  => '"' . $this->_tpl->img . '"',
            'basepath' => '"' . $this->_tpl->baseurl . '"',
            'isdebug'  => (int)$this->_isDebug(),
        );
    }

    /**
     * @param string $path
     * @return string
     */
    abstract protected function _compile($path);

    /**
     * @return mixed
     */
    abstract protected function _initProcessor();

}
