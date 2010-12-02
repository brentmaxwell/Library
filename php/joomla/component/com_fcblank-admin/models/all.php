<?php 
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class FcblankModelAll extends JModel{
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	var $_search = null;
	var $_query = null;
	
	function &getData(){
		$pagination =& $this->getPagination();
		
		if(empty($this->_data)){
			$query = $this->buildSearch();
			$this->_data = $this->_getList($query, $pagination->limitstart, $pagination->limit);
		}
		
		return $this->_data;
	}
	
	function buildSearch(){
		global $mainframe;
		global $option;
		$filter_order = JRequest::getCmd( 'filter_order','t.ordering','post');
//		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'ASC',	'word' );
		
		if(!$this->_query){
		
			$search = $this->getSearch();
			$table = str_replace("com_","#__",$option) . "_tbl";
			
			$this->_query = "SELECT
			                   `t`.*,
			                   `c`.`name` AS created_name,
			                   `c`.`username` AS created_username,
			                   `m`.`name` AS modified_name,
			                   `m`.`username` AS modified_username
			                   FROM " . $table . " t
			                   LEFT OUTER JOIN #__users c ON c.id = t.created_by
			                   LEFT OUTER JOIN #__users m ON m.id = t.modified_by
			                   WHERE `t`.`state` >= 0";

			if($search != ''){
				$fields = array('title', 'introtext', 'fulltext');

				$where = array();

				$search = $this->_db->getEscaped( $search, true );

				foreach ($fields as $field){
					$where[] = $field . " LIKE '%{$search}%'";
				}

				$this->_query .= ' AND ' . implode(' OR ', $where);
			}
			$this->_query .= " ORDER BY " . $filter_order;// .' '. $filter_order_Dir;
		}

		return $this->_query;
	}
	
	function getTotal(){
		if(!$this->_total){
			$query = $this->buildSearch();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	
	function &getPagination(){
		if(!$this->_pagination){
			jimport('joomla.html.pagination');
			global $mainframe;
			$this->_pagination = new JPagination($this->getTotal(), JRequest::getVar('limitstart', 0), JRequest::getVar('limit', $mainframe->getCfg('list_limit')));
		}

		return $this->_pagination;
	}
	
	function getSearch(){
		if(!$this->_search){
			global $mainframe, $option;

			$search = $mainframe->getUserStateFromRequest("$option.search", 'search', '', 'string');
			$this->_search = JString::strtolower($search);
		}

		return $this->_search;
	}
}