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


// init $tpl helper
require dirname(__FILE__) . '/php/init.php';

?><?php echo $tpl->renderHTML(); ?>
<head>
    <?php echo $tpl->renderHead(); ?>
</head>
<body class="<?php echo $tpl->getBodyClasses(); ?>" id="page-error">
    <div class="component-wrapper">

        <div class="techinfo">
            <h1><?php echo htmlspecialchars($this->title); ?></h1>
            <?php if (!$tpl->isDebug()) : ?>
                <p><strong><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>
                <ul>
                    <li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
                </ul>
                <p><strong><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>

                <ul>
                    <li>
                        <a href="<?php echo $this->baseurl; ?>/" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">
                            <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>
                    </li>
                </ul>

            <?php else : ?>

                <div class="errorinfo">
                    <pre><?php echo htmlspecialchars($this->error->getMessage()); ?></pre>
                    <?php echo str_replace(JPATH_ROOT, '', $this->renderBacktrace()); ?>
                    <?php
                    if (class_exists('jbdump')) {
                        echo '<hr/>';
                        jbdump::get();
                        jbdump::post();
                        jbdump::cookie();
                        jbdump::session();
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body></html>
