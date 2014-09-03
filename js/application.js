/**
 * J!Blank Template for Joomla by Joomla-book.ru
 * @category   JBlank
 * @author     smet.denis <admin@joomla-book.ru>
 * @copyright  Copyright (c) 2009-2012, Joomla-book.ru
 * @license    GNU GPL
 * @link       http://joomla-book.ru/projects/jblank JBlank project page
 */

if (typeof jQuery != 'undefined') {
    jQuery.noConflict(); // no conflicts with mootools an other JS libs

    jQuery(function ($) {
        // add class for CSS "event" document.ready
        $('html').addClass('jready').removeClass('no-js');

        // jquery linkExternal
        if (typeof $.fn.linkExternal != 'undefined') {
            $('.content a:not(.content a img)').linkExternal();
        }

        // jquery placeholder
        if (typeof $.fn.placeholder != 'undefined') {
            $('input[placeholder], textarea[placeholder]').placeholder();
        }

        // add zebra to table
        $('.content tr:not(thead tr, tfoot tr):odd, li:odd').addClass('odd');
    });
}
