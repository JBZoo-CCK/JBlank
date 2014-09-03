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

require_once(dirname(__FILE__) . '/php/_code.php');

?><!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7 ie6" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="<?php echo $tpl->lang;?>"> <!--<![endif]-->
<head>
    <jdoc:include type="head" />
</head>
<body>
    <div class="contentpane content">
        <jdoc:include type="message" />
        <jdoc:include type="component" />
    </div>
</body>
</html>
