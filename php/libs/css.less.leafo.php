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
 * Class JBlankCssLessLeafo
 */
class JBlankCssLessLeafo extends JBlankCss
{
    /**
     * @var lessc
     */
    protected $_processor;

    /**
     * @var string
     */
    protected $_filter = '\.less';

    /**
     * @param JBlankTemplate $tpl
     */
    public function __construct(JBlankTemplate $tpl)
    {
        parent::__construct($tpl);
        $this->_path = $this->_tpl->lessFull;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function _compile($path)
    {
        try {
            return $this->_processor->compileFile($path);
        } catch (Exception $ex) {
            die ('<strong>Less Error (JBlank):</strong><br/><pre>' . $ex->getMessage() . '</pre>');
        }
    }

    /**
     * @return lessc
     */
    protected function _initProcessor()
    {
        // lazy load
        if (!class_exists('lessc')) {
            require_once dirname(__FILE__) . '/class.less.leafo.php';
        }

        $less = new lessc();

        if ($this->_isDebug()) {
            $formatter = new lessc_formatter_lessjs();

            // configurate css view
            $formatter->openSingle        = " { ";
            $formatter->closeSingle       = "}\n";
            $formatter->close             = "}\n";
            $formatter->indentChar        = "    ";
            $formatter->disableSingle     = true;
            $formatter->breakSelectors    = true;
            $formatter->assignSeparator   = ": ";
            $formatter->selectorSeparator = ", ";
        } else {
            // compress mode
            $formatter              = new lessc_formatter_compressed();
            //$formatter->closeSingle = "}\n";
            //$formatter->close       = "}\n";
        }

        // set formatter
        $less->setFormatter($formatter);
        $less->setPreserveComments(false);

        // add paths for imports
        $less->addImportDir($this->_tpl->lessFull);
        $less->addImportDir(JPATH_ROOT);

        // from php
        $less->setVariables($this->_getCustomVars());

        // add custom functions
        $less->registerFunction('data-uri', array($this, 'lib_dataUri'));

        return $less;
    }

    /**
     * Convert image file to base64 string for CSS files
     * @param $args
     * @return string
     * @throws Exception
     */
    public static function lib_dataUri($args)
    {
        if (!isset($args[2])) {
            return '';
        }

        $tpl   = JBlankTemplate::getInstance();
        $image = $args[2][0];

        if (!empty($image)) {
            $filePath = $tpl->lessFull . '/' . $image;
        } else {
            throw new Exception('data-uri: undefined argument ' . print_r($args, true));
        }

        $filePath = realpath(JPath::clean($filePath));
        if (empty($filePath) || !JFile::exists($filePath)) {
            throw new Exception('data-uri: file "' . $filePath . '" is not exists');
        }

        $kbSize = filesize($filePath) / 1024;

        if ($tpl->isDebug() || $kbSize > 32) {
            $relPath = str_replace(array(JPATH_ROOT, $tpl->imgFull), '', $filePath);
            $relPath = str_replace("\\", '/', $relPath);
            $result  = 'url("' . $tpl->img . '/' . ltrim($relPath, '/') . '")';

        } else {
            $imgData = getimagesize($filePath);
            $imgBin  = fread(fopen($filePath, 'r'), filesize($filePath));
            $imgStr  = base64_encode($imgBin);
            $result  = 'url("data:' . $imgData['mime'] . ';base64,' . $imgStr . '"\'")';
        }

        return $result;
    }

}
