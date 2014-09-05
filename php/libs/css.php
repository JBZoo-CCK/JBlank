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
     * @return JBlankCss
     */
    public static function getProcessor($type = 'native', JBlankTemplate $tpl)
    {
        $class = 'JBlankCss' . $type;

        if (class_exists($class)) {
            $processor       = new $class($tpl);
            $processor->type = $type;
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

        $hash      = (($debug) ? ('debug-' . $filename) : $this->_getHash($file, $this->_path, $this->_filter));
        $path      = '/cache/jblank/styles-' . $hash . '-' . $this->type . '.css';
        $relPath   = rtrim($this->_tpl->baseurl, '/') . $path;
        $cachePath = JPath::clean(JPATH_ROOT . '/' . $path);

        if ($debug) {
            // build it always
            $css = $this->_compile($file);
            $this->_save($cachePath, $css);
            $relPath .= '?' . substr(filemtime($cachePath), -3); // forced disable browser cache

        } else {
            // check is cached fils exists
            if (!JFile::exists($cachePath) && $css = $this->_compile($file)) {
                $this->_save($cachePath, $css);
            }
        }

        return $relPath;
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
            '_dir'    => $this->_path,
            '_filter' => $this->_filter,
            '_debug'  => $this->_isDebug(),
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
     * @param string $path
     * @return string
     */
    abstract protected function _compile($path);

    /**
     * @return mixed
     */
    abstract protected function _initProcessor();

}
