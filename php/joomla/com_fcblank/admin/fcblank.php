<?php
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */
 
defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

$controller = JRequest::getCmd('controller', 'all');

switch ($controller)
{
	default:
		$controller = 'all';
	
	case 'all':
		require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
		$controllerName = 'FcblankController'.$controller;
		$controller = new $controllerName();
		$controller->execute( JRequest::getCmd('task') );
		$controller->redirect();
		break;	
}
