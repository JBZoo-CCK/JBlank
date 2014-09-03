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
 * This is a file to add template specific chrome to pagination rendering.
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override \n both
 */


/**
 *Input variable $list is an array with offsets:
 *  $list[prefix]        : string
 *    $list[limit]        : int
 *    $list[limitstart]    : int
 *    $list[total]        : int
 *    $list[limitfield]    : string
 *    $list[pagescounter]    : string
 *    $list[pageslinks]    : string
 * @param $list
 * @return string
 */
function pagination_list_footer($list)
{
    $html   = array();
    $html[] = "<div class=\"list-footer\">";
    $html[] = "<div class=\"limit\">" . JText::_('JGLOBAL_DISPLAY_NUM') . $list['limitfield'] . "</div>";
    $html[] = $list['pageslinks'];
    $html[] = "<div class=\"counter\">" . $list['pagescounter'] . "</div>";
    $html[] =
        "<input type=\"hidden\" name=\"" . $list['prefix'] . "limitstart\" value=\"" . $list['limitstart'] . "\" />";
    $html[] = "</div>";

    return implode("\n", $html);
}

/**
 *Input variable $list is an array with offsets:
 *    $list[all]
 *        [data]      : string
 *        [active]    : boolean
 *    $list[start]
 *        [data]      : string
 *        [active]    : boolean
 *    $list[previous]
 *        [data]      : string
 *        [active]    : boolean
 *    $list[next]
 *      [data]        : string
 *        [active]    : boolean
 *    $list[end]
 *        [data]      : string
 *        [active]    : boolean
 *    $list[pages]
 *        [{PAGE}][data]   : string
 *        [{PAGE}][active] : boolean
 * @param $list
 * @return string
 */
function pagination_list_render($list)
{
    // Reverse output rendering for right-to-left display.
    $html = '<ul class="pagination">';
    $html .= '<li class="pagination-start">' . $list['start']['data'] . '</li>';
    $html .= '<li class="pagination-prev">' . $list['previous']['data'] . '</li>';

    foreach ($list['pages'] as $page) {
        $html .= '<li>' . $page['data'] . '</li>';
    }

    $html .= '<li class="pagination-next">' . $list['next']['data'] . '</li>';
    $html .= '<li class="pagination-end">' . $list['end']['data'] . '</li>';
    $html .= '</ul>';

    return $html;
}

/**
 * Input variable $item is an object with fields:
 *    $item->base    : integer
 *    $item->prefix  : string
 *    $item->link    : string
 *    $item->text    : string
 * @param $item
 * @return string
 */
function pagination_item_active($item)
{
    return "<a title=\"" . $item->text . "\" href=\"" . $item->link . "\" class=\"pagenav\">" . $item->text . "</a>";
}

/**
 * Input variable $item is an object with fields:
 *    $item->base    : integer
 *    $item->prefix  : string
 *    $item->link    : string
 *    $item->text    : string
 * @param $item
 * @return string
 */
function pagination_item_inactive($item)
{
    return "<span class=\"pagenav\">" . $item->text . "</span>";
}
