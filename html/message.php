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


$msgList = $displayData['msgList'];

?>

<div id="system-message-container">
    <?php if (is_array($msgList) && !empty($msgList)) : ?>

        <div id="system-message">
            <?php foreach ($msgList as $type => $msgs) : ?>

                <div class="alert alert-<?php echo $type; ?>">

                    <a class="close" data-dismiss="alert">×</a>

                    <?php if (!empty($msgs)) : ?>
                        <h4 class="alert-heading"><?php echo JText::_($type); ?></h4>
                        <div>
                            <?php foreach ($msgs as $msg) : ?>
                                <p><?php echo $msg; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
