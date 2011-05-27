<?php
/**
 * @package      fcblank
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class FcblankViewList extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;
		
		$rows =& $this->get('data');
		
		$params =& $mainframe->getParams();
		$introtext = $params->get('show_introtext', 1);
		
		$this->assignRef('rows', $rows);
		$this->assign('show_introtext', $introtext);
		
		parent::display($tpl);
	}
}
