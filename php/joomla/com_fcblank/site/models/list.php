<?php
/**
 * @package      fcblank
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class FcblankModelList extends JModel
{
	var $_data = null;
	
	function &getData()
	{
		global $option;
		$table = str_replace('com_','#__',$option) . '_tbl';
		
		if(empty($this->_data))
		{
			$query = "SELECT * FROM " . $table . " WHERE published='1' ORDER BY displaydate DESC";
			$this->_data = $this->_getList($query);
		}
		
		return $this->_data;
	}
}
