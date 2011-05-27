<?php
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */

defined('_JEXEC') or die('Restricted access');

class TableSingle extends JTable
{
	var $id 				= null;  // unique id of the item
	var $title 				= null;  // item title
	var $title_alias		= null;  // secondary title, if first is not for display
	var $introtext 			= null;  // summary text for item
	var $fulltext 			= null;  // full item text
	var $displaydate 		= null;  // date of article to display
	var $displaydate2 		= null;  // displaydate2?
	var $state 				= null;  // state of the item: 1 = published, 0 = unpublished, -1 = archived, -2 = trashed
	var $published 			= null;  // publish the item or not: 1 = published, 0 = not published
	var $sectionid 			= null;  // section id of the item
	var $catid 				= null;  // category id of the item
	var $created 			= null;  // date item was created
	var $created_by 		= null;  // id of the user from `jos_users` who created the item
	var $modified 			= null;  // date item was modified
	var $modified_by 		= null;  // id of the user from `jos_users` who modified the item
	var $checked_out 		= null;  // id of the user from `jos_users` who has the item checked out, 0 if it is not checked out
	var $checked_out_time 	= null;  // time the item was checked out
	var $ordering 			= null;  // ordering of the item

	function __construct(&$db)
	{
		global $option;
		$table = str_replace('com_','#__',$option) . "_tbl";
		
		parent::__construct($table, 'id', $db );
	}
}