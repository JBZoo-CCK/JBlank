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

$doc             = JFactory::getDocument();
$this->language  = $doc->language;
$this->direction = $doc->direction;

$tpl = new JBlankTemplate($this);
$tpl->loadLanguages();

if (!isset($this->error)) {
    $this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
    $this->debug = false;
}

?><!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7 ie6 error-page" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7 error-page" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8 error-page" lang="<?php echo $tpl->lang;?>"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js error-page" lang="<?php echo $tpl->lang;?>"> <!--<![endif]-->
<head>
    <title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
    <link rel="stylesheet" href="<?php echo $tpl->css; ?>/base.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $tpl->css; ?>/typography.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $tpl->css; ?>/system.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/cms/css/debug.css" type="text/css" />
</head>
<body>
<div class="content container">
    <h1><?php echo $this->title; ?></h1>

    <div id="techinfo">
        <p class="error-message"><?php echo $this->error->getMessage(); ?></p>

        <p><strong><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>
        <ol>
            <li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
            <li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
            <li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
            <li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
            <li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
            <li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
        </ol>
        <p><strong><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>

        <ul>
            <li>
                <a href="<?php echo $this->baseurl; ?>/" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">
                    <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>
            </li>
        </ul>

        <?php if ($this->debug) : ?>
            <p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?>.</p>

        <?php endif; ?>
    </div>
</div>

<?php if ($this->debug) : ?>
    <div class="content">
        <pre><?php echo $this->error->toString(); ?></pre>
        <pre><?php echo $this->error->getTraceAsString(); ?></pre>

        <?php if (class_exists('jbdump')) : ?>
            <?php jbdump::trace(true); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>
