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
 * Class JBlankCssLessGpeasy
 */
class JBlankCssLessGpeasy extends JBlankCss
{
    /**
     * @var Less_Parser
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
            $this->_processor->parseFile($path, $this->_tpl->less);
            $resultCss = $this->_processor->getCss();
            return $resultCss;

        } catch (Exception $ex) {
            die ('<strong>Less Error (JBlank):</strong><br/><pre>' . $ex->getMessage() . '</pre>');
        }
    }

    /**
     * @return Less_Parser
     */
    protected function _initProcessor()
    {
        // lazy load
        if (!class_exists('Less_Parser')) {
            require_once dirname(__FILE__) . '/class.less.gpeasy.php';
        }

        $options = array(
            'compress'     => 1, // option - whether to compress
            'strictUnits'  => 0, // whether units need to evaluate correctly
            'strictMath'   => 0, // whether math has to be within parenthesis
            'relativeUrls' => 1, // option - whether to adjust URL's to be relative
            'numPrecision' => 4,
            'cache_method' => 0,
            'sourceMap'    => 0,
        );

        if ($this->_isDebug()) {
            $options['compress']          = 0;
            $options['sourceMap']         = 1;
            $options['sourceMapRootpath'] = $this->_tpl->less;
            $options['sourceMapBasepath'] = $path = JPath::clean($this->_tpl->lessFull, '/');
        }

        $less = new Less_Parser($options);

        // set paths
        $less->SetImportDirs(array(
            $this->_tpl->lessFull => $this->_tpl->less
        ));

        // add custom vars
        $less->ModifyVars($this->_getCustomVars());

        return $less;
    }

}
