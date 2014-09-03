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


// include helper classes
require_once(dirname(__FILE__) . DS . 'template.php');

// init template
$tpl = new JBlankTemplate($this);

// main actions
$tpl->removeMootools();
$tpl->loadJS();
$tpl->loadCSS();
$tpl->loadMeta();


/*********************************************** you php code here ****************************************************/
$tpl->positionData = array(
    'left'      => 0,
    'right'     => 0,
    'component' => 12,
);

if ($this->countModules('left') > 0) {
    $tpl->positionData['component'] -= 2;
    $tpl->positionData['left'] = 2;
}

if ($this->countModules('right') > 0) {
    $tpl->positionData['component'] -= 2;
    $tpl->positionData['right'] = 2;
}

/** only for frontpage **/
if ($tpl->isFront) {

}

/** only if joomla message display **/
if ($tpl->isError) {

}
