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

require_once(dirname(__FILE__) . '/php/template.php');

$tpl = new JBlankTemplate($this);
$tpl->includeCSS('base.css');
$tpl->includeCSS('typography.css');
$tpl->includeCSS('system.css');

//$tpl->removeMootools(true);
$tpl->loadLanguages();

?><!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7 ie6 offline-page" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7 offline-page" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8 offline-page" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js offline-page" lang="<?php echo $tpl->lang;?>"> <!--<![endif]-->
<head>
    <jdoc:include type="head" />
</head>
<body>

    <div class="content container">
        <h1><?php echo $tpl->app->getCfg('sitename'); ?></h1>

        <?php if ($tpl->app->getCfg('offline_image')) : ?>
            <div class="offline-image-wrapper"><img src="<?php echo $tpl->app->getCfg('offline_image'); ?>" alt="<?php echo $tpl->app->getCfg('sitename'); ?>" class="offline-image" /></div>
        <?php endif; ?>

        <?php if ($tpl->app->getCfg('display_offline_message', 1) == 1 && str_replace(' ', '', $tpl->app->getCfg('offline_message')) != ''): ?>
       		<p><?php echo $tpl->app->getCfg('offline_message'); ?></p>

       	<?php elseif ($tpl->app->getCfg('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JBLANK_OFFLINE_MESSAGE')) != ''): ?>
       		<p><?php echo JText::_('JBLANK_OFFLINE_MESSAGE'); ?></p>
       	<?php  endif; ?>

        <form action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login">
            <fieldset>

                <legend><?php echo JText::_('JBLANK_OFFLINE_AUTH') ?></legend>

                <div class="row">
                    <input name="username" id="username" type="text" alt="<?php echo JText::_('JBLANK_OFFLINE_USERNAME') ?>" size="18" />
                    <label for="username"><?php echo JText::_('JBLANK_OFFLINE_USERNAME') ?></label>
                </div>

                <div class="row">
                    <input type="password" name="password" size="18" alt="<?php echo JText::_('JBLANK_OFFLINE_PASSWORD') ?>" id="passwd" />
                    <label for="passwd"><?php echo JText::_('JBLANK_OFFLINE_PASSWORD') ?></label>
                </div>

                <div class="row">
                    <input type="checkbox" name="remember" value="yes" alt="<?php echo JText::_('JBLANK_OFFLINE_REMEMBER_ME') ?>" id="remember" />
                    <label for="remember"><?php echo JText::_('JBLANK_OFFLINE_REMEMBER_ME') ?></label>
                </div>

                <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JBLANK_OFFLINE_LOGIN') ?>" />
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="user.login" />
                <input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
                <?php echo JHtml::_('form.token'); ?>

            </fieldset>
       	</form>

    </div>

</body>
