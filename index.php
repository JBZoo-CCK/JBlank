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

    <div class="container_12">

        <div class="grid_6"><jdoc:include type="modules" name="logo" /></div>
        <div class="grid_6 content"><jdoc:include type="modules" name="top-block" /></div>
        <div class="clear"></div>

        <?php if ($this->countModules('top')) : ?>
            <div class="grid_12 content"><jdoc:include type="modules" name="top" /></div>
            <div class="clear"></div>
        <?php endif; ?>


        <?php if ($this->countModules('header')) : ?>
            <div class="modules-header content">
                <jdoc:include type="modules" name="header" style="grid" countModules="<?=$this->countModules('header');?>" />
                <div class="clear"></div>
            </div>
        <?php endif; ?>


        <?php if ($this->countModules('mainmenu')) : ?>
            <div class="grid_12 mainmenu">
                <jdoc:include type="modules" name="mainmenu" />
            </div>
            <div class="clear"></div>
        <?php endif;?>


        <?php if (!$tpl->isFront && $this->countModules('breadcrumbs')) : ?>
            <div class="grid_12 content" id="breadcrumbs">
                <jdoc:include type="modules" name="breadcrumbs" />
            </div>
            <div class="clear"></div>
        <?php endif;?>


        <div class="grid_<?=$tpl->positionData['left'];?> content">
            <jdoc:include type="modules" name="left" style="header" />
        </div>
        <div class="grid_<?=$tpl->positionData['component'];?>">
            <?php if ($tpl->isError) : ?>
                <div id="joomla-message"><jdoc:include type="message" /></div>
            <?php endif; ?>
            &nbsp;
            <div class="component content">
                <jdoc:include type="modules" name="pre_component" />
                <jdoc:include type="component" />
                <jdoc:include type="modules" name="post_component" />
            </div>
        </div>
        <div class="grid_<?=$tpl->positionData['right'];?> content">
            <jdoc:include type="modules" name="right" style="header" />
        </div>
        <div class="clear"></div>


        <?php if ($this->countModules('bottom')) : ?>
            <div class="modules-bottom content">
                <jdoc:include type="modules" name="bottom" style="grid" countModules="<?=$this->countModules('bottom');?>" />
                <div class="clear"></div>
            </div>
        <?php endif; ?>


        <?php
        if ($this->countModules('footer-2-1')
                && $this->countModules('footer-2-2')
                && $this->countModules('footer-2-3')
        ) : ?>
            <div class="modules-footer-2 content grid_3">
                <jdoc:include type="modules" name="footer-2-1" style="header" />
            </div>
            <div class="modules-footer-2 content grid_3">
                <jdoc:include type="modules" name="footer-2-2" style="header" />
            </div>
            <div class="modules-footer-2 content grid_6">
                <jdoc:include type="modules" name="footer-2-3" style="header" />
            </div>
            <div class="clear"></div>
        <?php endif; ?>


        <?php if ($this->countModules('footer')) : ?>
            <div class="modules-footer content grid_12">
                <jdoc:include type="modules" name="footer" style="header" />
            </div>
            <div class="clear"></div>
        <?php endif; ?>


        <div class="content grid_12">
            <!-- remove me! -->
            <div class="copyrights"><p>&copy; <?php echo $tpl->getDate('%Y');?> <a href="http://joomla-book.ru/" target="_blank">Joomla-book.ru</a> - чистый шаблон для Joomla</p> </div>
        </div>

    </div>

    <?php echo $tpl->renderJS(); ?>

    <?php if ($this->countModules('counters')) : ?>
        <div style="display: none;"><jdoc:include type="modules" name="counters" /></div>
    <?php endif; ?>

</body>
</html>
