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
 * Class JBlankCssLessJS
 */
class JBlankCssLessJS extends JBlankCss
{

    /**
     * @var string
     */
    protected $_filter = '\.less';

    /**
     * @param $file
     * @return string
     */
    public function compile($file)
    {
        $this->_compile($file);
        return null;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function _compile($path)
    {
        $params = array(
            'logLevel'        => 0,
            'poll'            => 10000000,
            'async'           => false,
            'fileAsync'       => false,
            'relativeUrls'    => false,
            'env'             => 'production',
            'dumpLineNumbers' => '',
            'rootpath'        => $this->_tpl->baseurl,
            'globalVars'      => $this->_getCustomVars(),
        );

        if ($this->_isDebug()) {
            $params['env']             = 'development';
            $params['logLevel']        = 1;
            $params['poll']            = 2500;
            $params['dumpLineNumbers'] = 'all';
        }

        $basename = pathinfo($path, PATHINFO_BASENAME);

        $html = array(
            '<!-- less.js for "' . $basename . '" -->',
            '<link rel="stylesheet/less" type="text/css" href="' . $this->_tpl->less . '/' . $basename . '" />',
            '<script>var less = ' . json_encode($params) . ';</script>',
            '<script src="' . $this->_tpl->js . '/libs/less.min.js"></script>',
        );

        if ($this->_isDebug()) {
            $html[] = '<script>less.watch();</script>';
        }

        $html[] = '<!-- /less.js -->';

        $this->_tpl->meta($html);
    }

    /**
     * @return lessc
     */
    protected function _initProcessor()
    {
        return true;
    }

}
