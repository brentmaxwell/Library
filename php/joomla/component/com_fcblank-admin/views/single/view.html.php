<?php 
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class FcblankViewSingle extends JView{
	function display($tpl = null){
		$row =& JTable::getInstance('single', 'Table');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		$this->assignRef('row', $row);
		
		$editor =& JFactory::getEditor();
		$this->assignRef('editor', $editor);
		
		$this->assignRef('published', JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published));
		$this->assignRef('displaydate', JHTML::_('calendar', $row->displaydate, 'displaydate', 'displaydate'));
		
		parent::display($tpl);
	}
}