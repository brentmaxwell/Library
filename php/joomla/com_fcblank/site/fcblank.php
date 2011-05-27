<?php
/**
 * @package      fcblank
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class FcblankController extends JController
{
	function display()
	{
		$view = JRequest::getVar('view');
		$id = JRequest::getVar('id');
		
		if(!$view)
		{
			JRequest::setVar('view', 'list');
		}
		if(!$view && $id)
		{
			JRequest::setVar('view', 'single');
		}
		
		parent::display();
	}
}

$controller = new FcblankController();
$controller->execute($task);
$controller->redirect();
