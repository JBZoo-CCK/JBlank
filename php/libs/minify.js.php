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
 * Class JBlankMinifyJs
 */
class JBlankMinifyJs extends JBlankMinify
{
    /**
     * Set compress mode
     *  0 - disabled
     *  1 - only comments by regexp
     *  2 - Google service
     * @var string
     */
    private $_mode = 2;

    /**
     * @var
     */
    protected $_mergeSeparator = ";\n ";

    /**
     * Google url
     * @var string
     */
    private $_url = 'http://closure-compiler.appspot.com/compile';

    /**
     * @param string $code
     * @return string
     */
    protected function _minify($code)
    {
        $code = (string)$code;

        if (1 == $this->_mode) { // remove comments
            $code = $this->_simpleMinify($code);

        } else if (2 == $this->_mode) { // use google service
            $code = $this->_closureCompiler($code);
        }

        $code = JString::trim($code);

        return $code;
    }

    /**
     * @param $code
     * @return mixed
     */
    protected function _simpleMinify($code)
    {
        $code = preg_replace('#/\*[^*]*\*+([^/][^*]*\*+)*/#ius', '', $code);
        return $code;
    }

    /**
     * @param $code
     * @return string
     * @throws Exception
     */
    private function _closureCompiler($code)
    {
        if (JString::strlen($code) > 200000) {
            return $code;
        }

        if (!class_exists('JHttpFactory')) {
            return $code;
        }

        $response = JHttpFactory::getHttp()
            ->post($this->_url, array(
                'js_code'           => $code,
                'output_info'       => 'compiled_code',
                'output_format'     => 'text',
                'compilation_level' => 'WHITESPACE_ONLY' // WHITESPACE_ONLY | SIMPLE_OPTIMIZATIONS | ADVANCED_OPTIMIZATIONS
            ), array(
                'Content-type' => 'application/x-www-form-urlencoded',
                'Connection'   => 'close',
            ), 15);

        $result = $response->body;

        if (preg_match('/^Error\(\d\d?\):/', $result)) {
            throw new Exception('Google JS Minify: ' . $result);
        }

        return $result;
    }

}
