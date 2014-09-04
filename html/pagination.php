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
 * Renders the pagination footer
 * @param  array $list Array containing pagination footer
 * @return string
 */
function pagination_list_footer($list)
{
    $html = array();

    $html[] = '<div class="list-footer">';
    $html[] = '<div class="limit">' . JText::_('JGLOBAL_DISPLAY_NUM') . $list['limitfield'] . '</div>';
    $html[] = $list['pageslinks'];
    $html[] = '<div class="counter">' . $list['pagescounter'] . '</div>';
    $html[] = '<input type="hidden" name="' . $list['prefix'] . 'limitstart" value="' . $list['limitstart'] . '" />';
    $html[] = '</div>';

    return implode("\n ", $html);
}

/**
 * Renders the pagination list
 * @param  array $list Array containing pagination information
 * @return string
 */
function pagination_list_render($list)
{
    $html = array();

    $html[] = '<ul>';
    $html[] = '<li class="pagination-start">' . $list['start']['data'] . '</li>';
    $html[] = '<li class="pagination-prev">' . $list['previous']['data'] . '</li>';

    foreach ($list['pages'] as $page) {
        $html[] = '<li>' . $page['data'] . '</li>';
    }

    $html[] = '<li class="pagination-next">' . $list['next']['data'] . '</li>';
    $html[] = '<li class="pagination-end">' . $list['end']['data'] . '</li>';
    $html[] = '</ul>';

    return implode("\n ", $html);
}

/**
 * Renders an active item in the pagination block
 * @param  JPaginationObject $item The current pagination object
 * @return string
 */
function pagination_item_active(JPaginationObject $item)
{
    return '<a title="' . $item->text . '" href="' . $item->link . '" class="pagenav">' . $item->text . '</a>';
}

/**
 * Renders an inactive item in the pagination block
 * @param  JPaginationObject $item The current pagination object
 * @return string
 */
function pagination_item_inactive(JPaginationObject $item)
{
    return '<span class="pagenav">' . $item->text . '</span>';
}
