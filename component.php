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
    <jdoc:include type="head"/>
</head>
<body class="<?php echo $tpl->getBodyClasses(); ?>" id="page-print">

    <div class="component-wrapper">
        <jdoc:include type="message" />
        <jdoc:include type="component" />
    </div>

    <?php if ($tpl->request('print')): ?>
        <script type="text/javascript">window.print();</script>
    <?php endif; ?>

</body></html>
