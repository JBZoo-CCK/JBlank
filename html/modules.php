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
 * Bootstrap well wrapper
 * @param $module
 * @param $params
 * @param $attribs
 */
function modChrome_well($module, &$params, &$attribs)
{
    if (!$module->content) {
        return;
    }
    echo "<div class=\"well well-sm" . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";

    if ($module->showtitle) {
        echo "<h3>" . $module->title . "</h3>";
    }

    echo $module->content;
    echo "</div>";
}
