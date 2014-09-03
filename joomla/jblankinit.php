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


jimport('joomla.form.formfield');

class JFormFieldJBLankInit extends JFormField
{

    protected $type = 'jblankinit';

    public function getInput()
    {
        JFactory::getLanguage()->load('tpl_jblank', JPATH_THEMES . '/jblank/language');
        return false;
    }

    public function getLabel()
    {
        return false;
    }

}