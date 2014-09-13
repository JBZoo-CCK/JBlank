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
 * Class JBlankCssScssLeafo
 */
class JBlankCssScssLeafo extends JBlankCss
{
    /**
     * @var scssc
     */
    protected $_processor;

    /**
     * @var string
     */
    protected $_filter = '\.scss';

    /**
     * @param JBlankTemplate $tpl
     */
    public function __construct(JBlankTemplate $tpl)
    {
        parent::__construct($tpl);
        $this->_path = $this->_tpl->scssFull;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function _compile($path)
    {
        $code = file_get_contents($path);
        return $this->_processor->compile($code);
    }

    /**
     * @return scssc
     */
    protected function _initProcessor()
    {
        // lazy load
        if (!class_exists('scssc')) {
            include dirname(__FILE__) . '/class.scssc.leafo.php';
        }

        $sass = new scssc();
        return $sass;
    }

}
