<?php 
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9
 */
 
defined('_JEXEC') or die('Restricted access');

class JElementSingle extends JElement{
	function fetchElement($title, $value, &$node, $control_name){
		$db =& JFactory::getDBO();
		
		$table = "#__fcblank_tbl";
		
		$query = "SELECT id, title"
				." FROM " . $table
				." WHERE published='1'"
				." AND `state` >= 0"
				." ORDER BY ordering";		
		
		$db->setQuery($query);
		$options = $db->loadObjectList();

		return JHTML::_('select.genericlist',  $options, $control_name. '[' . $title . ']', 'class="inputbox"', 'id', 'name', $value, $control_name . $title);
	}
}