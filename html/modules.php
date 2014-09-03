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


/**
 * Chrome callback function for "header" style
 * @param $module
 * @param $params
 * @param $attribs
 */
function modChrome_header($module, &$params, &$attribs)
{
    // default value for headerLevel attribute
    if (!isset($attribs['headerLevel'])) {
        $attribs['headerLevel'] = '3';
    }

    // class names
    $wrapperClass   = array();
    $wrapperClass[] = 'module';
    $wrapperClass[] = 'module-' . $attribs['name'];
    $wrapperClass[] = 'module-' . $attribs['style'];
    $wrapperClass[] = htmlspecialchars($params->get('moduleclass_sfx'));

    $html = '';

    if (!empty ($module->content)) {

        $html .= '<div class="' . implode(' ', $wrapperClass) . '">';

        if ($module->showtitle != 0) {
            $html .= '<h' . (int)$attribs['headerLevel'] . ' class="module-header">';
            $html .= $module->title;
            $html .= '</h' . (int)$attribs['headerLevel'] . '>';
        }

        $html .= '<div class="module-content">' . $module->content . '</div>';
        $html .= '</div>';

    }

    echo $html;

}

/**
 * Chrome callback function for "grid" style
 * @param $module
 * @param $params
 * @param $attribs
 */
function modChrome_grid($module, $params, $attribs)
{

    $gridNum = 12;
    !isset($attribs['countModules']) && $attribs['countModules'] = '3';
    (int)$attribs['countModules'] && $gridNum = 12 / (int)$attribs['countModules'];

    // default value for headerLevel attribute
    !isset($attribs['headerLevel']) && $attribs['headerLevel'] = '3';

    // class names
    $wrapperClass   = array();
    $wrapperClass[] = 'module';
    $wrapperClass[] = 'module-' . $attribs['name'];
    $wrapperClass[] = 'module-' . $attribs['style'];
    $wrapperClass[] = 'grid_' . $gridNum;
    $wrapperClass[] = htmlspecialchars($params->get('moduleclass_sfx'));

    $html = '';

    if (!empty ($module->content)) {

        $html .= '<div class="' . implode(' ', $wrapperClass) . '">';

        if ($module->showtitle != 0) {
            $html .= '<h' . (int)$attribs['headerLevel'] . ' class="module-header">';
            $html .= $module->title;
            $html .= '</h' . (int)$attribs['headerLevel'] . '>';
        }

        $html .= '<div class="module-content">' . $module->content . '</div>';
        $html .= '</div>';

    }

    echo $html;
}
