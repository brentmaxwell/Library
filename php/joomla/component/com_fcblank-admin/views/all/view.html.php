<?php 
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class FcblankViewAll extends JView{	
	function display($tpl = null){
	
		$rows =& $this->get('data');
		$pagination =& $this->get('pagination');
		$search = $this->get('search');
		
		$this->assignRef('rows', $rows);
		$this->assignRef('pagination', $pagination);
		$this->assign('search', $search);
		
		parent::display($tpl);
	}
}