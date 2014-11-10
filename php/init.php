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


// load libs
!version_compare(PHP_VERSION, '5.3.10', '=>') or die('Your host needs to use PHP 5.3.10 or higher to run JBlank Template');
require_once dirname(__FILE__) . '/libs/template.php';

/************************* runtime configurations *********************************************************************/
$tpl = JBlankTemplate::getInstance();
$tpl
    // enable or disable debug mode. Default in Joomla configuration.php
    //->debug(true)

    // include CSS files if it's not empty
    // compile less *.file to CSS and cache it
    // compile scss *.file to CSS and cache it (experimental!)
    ->css(array(
        // 'template.css', // from jblank/css folder
        'template.less', // from jblank/less folder
        // 'template.scss',// from jblank/scss folder
        // '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', // any external lib (you can use http:// or https:// urls)
    ))

    // include JavaScript files
    ->js(array(
        // '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', // any external lib (you can use http:// or https:// urls)
        // 'libs/jquery-1.x.min.js', // your own local lib
        'template.js',
    ))

    // exclude css files from system or components (experimental!)
    ->excludeCSS(array(
        // 'regex pattern or filename',
        // 'jbzoo\.css',
    ))

    // exclude JS files from system or components (experimental!)
    ->excludeJS(array(
        // 'regex pattern or filename',
        // 'mootools',             // remove Mootools lib
        // 'media\/jui\/js',       // remove jQuery lib
        // 'media\/system\/js',    // remove system libs
    ))

    // set custom generator
    ->generator('J!Blank.pro Joomla Template')// null for disable

    // set HTML5 mode (for <head> tag)
    ->html5(true)

    // add custom meta tags
    ->meta(array(
        // template customization
        '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
        '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">',

        // apple icons
        '<link rel="apple-touch-icon-precomposed" href="' . $tpl->img . '/icons/apple-touch-iphone.png">',
        '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . $tpl->img . '/icons/apple-touch-ipad.png">',
        '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . $tpl->img . '/icons/apple-touch-iphone4.png">',
        '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . $tpl->img . '/icons/apple-touch-ipad-retina.png">',

        // site verification examples
        '<meta name="google-site-verification" content="... google verification hash ..." />',
        '<meta name="yandex-verification" content="... yandex verification hash ..." />',
    ));

/************************* your php code below this line **************************************************************/

// mobile detect using (just for example!)
if ($tpl->isMobile()) {
    $tpl->css('media-mobile.less'); // css only for mobiles

} elseif ($tpl->isTablet()) {
    $tpl->css('media-tablet.less'); // css only for tablets
}

// USE IT ON YOUR OWN --> RISK <-- THIS IS EXPERIMENTAL FEATURES!
// After that all assets files will be included
/*
$tpl
    // merge css with compress (second arg)
    ->merge('css', true)
    // merge js with compress (second arg)
    ->merge('js', true);
*/
