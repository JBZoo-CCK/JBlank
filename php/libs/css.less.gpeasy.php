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

            $this->_processor->parseFile($path);
            $resultCss = $this->_processor->getCss();

            $this->_cacheMix = $this->_processor->allParsedFiles();

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
            'compress'     => true, // option - whether to compress
            'strictUnits'  => false, // whether units need to evaluate correctly
            'strictMath'   => false, // whether math has to be within parenthesis
            'numPrecision' => 4,
            'cache_method' => false,
        );

        if ($this->_isDebug()) {
            $options['compress'] = false;
        }

        $less = new Less_Parser($options);

        // set paths
        $less->SetImportDirs(array(
            $this->_tpl->lessFull => $this->_tpl->baseurl
        ));

        // add custom vars
        $less->ModifyVars(array(
            //'varname1' => 'value1'
            //'varname2' => 'value2'
        ));

        return $less;
    }

}
