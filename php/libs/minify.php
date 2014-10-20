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
 * Class JBlankMinify
 */
abstract class JBlankMinify
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
     * @var string
     */
    protected $_mergeSeparator = "\n";

    /**
     * @param JBlankTemplate $tpl
     */
    public function __construct(JBlankTemplate $tpl)
    {
        $this->_tpl  = $tpl;
        $this->_path = $tpl->pathFull;
    }

    /**
     * @param string $type
     * @param JBlankTemplate $tpl
     * @throws Exception
     * @return JBlankMinify
     */
    public static function getProcessor($type = 'css', JBlankTemplate $tpl)
    {
        $pluginPath = dirname(__FILE__) . '/minify.' . $type . '.php';
        if (file_exists($pluginPath)) {
            include_once $pluginPath;
        }

        $type  = str_replace('.', '', $type);
        $class = 'JBlankMinify' . $type;

        if (class_exists($class)) {
            $processor       = new $class($tpl);
            $processor->type = $type;
        } else {
            throw new Exception('Undefined minify processor');
        }

        return $processor;
    }

    /**
     * @param $files
     * @param bool $isCompress
     * @return null|string
     */
    public function minify($files, $isCompress = false)
    {
        $hash = $this->_getHash($files, $isCompress);

        $path      = '/cache/jblank/minify-' . $hash . '.' . $this->type;
        $relPath   = rtrim($this->_tpl->baseurl, '/') . $path;
        $cachePath = JPath::clean(JPATH_ROOT . '/' . $path);

        if (!JFile::exists($cachePath)) {
            $codeList = $this->_merge($files);

            if ($isCompress) {
                try {
                    $codeList = $this->_minify($codeList);
                } catch (Exception $ex) {
                    die ('<strong>Minify Error (JBlank):</strong><br/><pre>' . $ex->getMessage() . '</pre>');
                }
            }

            $this->_save($cachePath, $codeList);
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
     * @param $files
     * @param bool $isCompress
     * @return array|string
     */
    protected function _getHash($files, $isCompress = false)
    {
        $hash = array(
            '_type'       => $this->type,
            '_isCompress' => (int)$isCompress,
            '_debug'      => $this->_isDebug() ? '1' : '0',
        );

        foreach ($files as $file) {
            $hash[$file] = md5_file($file);
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
     * File merger
     * @param array $files
     * @return string
     */
    protected function _merge(array $files)
    {
        $buffer = array();

        foreach ($files as $file) {
            $relPath = str_replace(JPATH_ROOT, '', $file);
            if (JFile::exists($file)) {
                $buffer[] = "/* file: $relPath */\n" . file_get_contents($file);
            }
        }

        return implode($this->_mergeSeparator, $buffer);
    }

    /**
     * @param string $code
     * @return string
     */
    abstract protected function _minify($code);

}
