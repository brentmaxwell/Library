<?php
/**
 * @package      fcblank
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */
 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fcblank'.DS.'tables');

class FcblankViewSingle extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;
		$params =& $mainframe->getParams();
		
		$id = (int) JRequest::getVar('id', 0);
		
		$article =& JTable::getInstance('single', 'Table');
		$article->load($id);
		
		if($article->published == 0)
		{
			JError::raiseError(404, 'The article you requested is not available.');
		}
		
		$date = JHTML::Date($article->displaydate);
		$backlink = JRoute::_('blank/');

		$this->assignRef('article', $article);
		$this->assignRef('date', $date);
		$this->assignRef('backlink', $backlink);
		
		$document =& JFactory::getDocument();
		$document->addScript(JURI::base() . 'templates/script.js');
		$document->addStylesheet(JURI::base() . 'templates/main.css');
		$document->setTitle('Single View');
		parent::display($tpl);
	}
}
