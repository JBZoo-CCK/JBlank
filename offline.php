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

// add CSS
$app = $tpl->app;

// check Joomla auth method
require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';
if (method_exists('UsersHelper','getTwoFactorMethods')) {
    $twoFactors = UsersHelper::getTwoFactorMethods();
}

?><?php echo $tpl->renderHTML(); ?>
<head>
    <jdoc:include type="head" />
</head>
<body class="<?php echo $tpl->getBodyClasses(); ?>" id="page-offline">

    <jdoc:include type="message" />

    <div id="frame" class="outline component-wrapper">

        <?php if ($app->get('offline_image') && file_exists($app->get('offline_image'))) : ?>
            <img src="<?php echo $app->get('offline_image'); ?>" alt="<?php echo htmlspecialchars($app->get('sitename')); ?>" />
        <?php endif; ?>

        <h1><?php echo htmlspecialchars($app->get('sitename')); ?></h1>

        <?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) != '') : ?>
            <p><?php echo $app->get('offline_message'); ?></p>
        <?php elseif ($app->get('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != '') : ?>
            <p><?php echo JText::_('JOFFLINE_MESSAGE'); ?></p>
        <?php endif; ?>

        <form action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login">
            <fieldset class="input">
                <p id="form-login-username">
                    <label for="username"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label>
                    <input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" size="18" />
                </p>

                <p id="form-login-password">
                    <label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
                    <input type="password" name="password" class="inputbox" size="18" alt="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" id="passwd" />
                </p>

                <?php if (isset($twoFactors) && count($twoFactors) > 1) : ?>
                    <p id="form-login-secretkey">
                        <label for="secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
                        <input type="text" name="secretkey" class="inputbox" size="18" alt="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" id="secretkey" />
                    </p>
                <?php endif; ?>

                <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                    <p id="form-login-remember">
                        <label for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME'); ?></label>
                        <input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME'); ?>" id="remember" />
                    </p>
                <?php endif; ?>

                <p id="submit-buton">
                    <label>&nbsp;</label>
                    <input type="submit" name="Submit" class="button login" value="<?php echo JText::_('JLOGIN'); ?>" />
                </p>

                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="user.login" />
                <input type="hidden" name="return" value="<?php echo base64_encode(JUri::base()); ?>" />
                <?php echo JHtml::_('form.token'); ?>

            </fieldset>
        </form>

    </div>
</body></html>