<?php
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class FcblankControllerAll extends JController
{
	
	function __construct($config = array())
	{
		parent::__construct($config);
				
		$this->registerTask('add',       'addItem'     );
		$this->registerTask('edit',      'editItem'    );
		$this->registerTask('save',      'saveItem'    );
	 	$this->registerTask('apply',     'saveItem'    );
		$this->registerTask('publish',   'setPublished');
		$this->registerTask('unpublish', 'setPublished');
		$this->registerTask('remove',    'removeItem'  );

	}
	
	// adds a new item
 	function addItem()
 	{
 		JRequest::setVar('view', 'single'); 		
 		$this->display();
 	}
 	
	// edits the item selected
 	function editItem()
 	{
 		global $option;
 		JRequest::setVar('view', 'single');
 		$row =& JTable::getInstance('single', 'Table');
 		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
 		JArrayHelper::toInteger($cid, array(0));
 		$id = JRequest::getVar( 'id', $cid[0], '', 'int' );
 		$row->load($id);
 		
 		// get current user in order to check out the item
 		$user = & JFactory::getUser();
 		
 		// check out the item
 		if ( JTable::isCheckedOut($user->get ('id'), $row->checked_out ))
 		{
 			$msg = JText::sprintf('DESCBEINGEDITTED', JText::_('The item'), $row->title);
 			$mainframe->redirect('index.php?option=' . $option, $msg);
 		}

 		$this->display();
 	}
 	
 	// saves the edited/new item
	function saveItem()
	{
		global $option;

		$row =& JTable::getInstance('single', 'Table');

		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}

		$row->introtext = JRequest::getVar('introtext', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$row->fulltext = JRequest::getVar('fulltext', '', 'post', 'string', JREQUEST_ALLOWRAW );

		if(!$row->displaydate)
		{
			$row->displaydate = date('Y-m-d H:i:s');
		}

		//Brent's additions - copied from content component
		$user		= & JFactory::getUser();
		// modified and modified by
		// sanitise id field
		$row->id = (int) $row->id;

		$config =& JFactory::getConfig();
		$tzOffset = $config->getValue('config.offset');
		$datenow =& JFactory::getDate(date('Y-m-d H:i:s'), $tzOffset);

		$isNew = true;
		// Are we saving from an item edit?
		if ($row->id)
		{
			$isNew = false;
			$row->modified 		= $datenow->toMySQL();
			$row->modified_by 	= $user->get('id');
		}
		else
		{
			$row->created 		= $datenow->toMySQL();
			$row->created_by	= $user->get('id');
		}
		if(!$row->store())
		{
			JError::raiseError(500, $row->getError() );
		}

		//state info
			$row->state	= JRequest::getVar( 'state', 0, '', 'int' );
		
		//checkin
			$row->checkin();
		
		// only reorders stuff in the right category
		//$row->reorder('catid = '.(int) $row->catid.' AND state >= 0');
		$row->reorder('state >= 0');
		
		
		//End Brent's additions
		
		if($this->getTask() == 'apply')
		{
			$this->setRedirect('index.php?option=' . $option . '&task=edit&cid[]=' . $row->id, 'Changes Applied');
		}
		else
		{
			$this->setRedirect('index.php?option=' . $option, 'Article Saved');
		}
	}
	
	
	// toggle published
	function setPublished()
	{
		global $option;
		JRequest::checkToken() or jexit('Invalid Token');

		$cid = JRequest::getVar('cid', array());

		$row =& JTable::getInstance('single', 'Table');

		$publish = 1;

		if($this->getTask() == 'unpublish')
		{
			$publish = 0;
		}

		if(!$row->publish($cid, $publish))
		{
			JError::raiseError(500, $row->getError() );
		}

		$s = '';

		if(count($cid) > 1)
		{
			$s = 's';
		}

		$msg = 'Article' . $s;

		if($this->getTask() == 'unpublish')
		{
			$msg .= ' unpublished';
		} else{
			$msg .= ' published';
		}

		$this->setRedirect('index.php?option=' . $option, $msg);
	}
	
	/* old remove - deletes article
		
	function remove(){
		JRequest::checkToken() or jexit('Invalid Token');

		global $option;

		$cid = JRequest::getVar('cid', array(0));

		$row =& JTable::getInstance('single', 'Table');

		foreach ($cid as $id){
			$id = (int) $id;

			if(!$row->delete($id)){
				JError::raiseError(500, $row->getError() );
			}
		}

		$s = '';

		if(count($cid) > 1){
			$s = 's';
		}

		$this->setRedirect('index.php?option=' . $option, 'Article' . $s . ' deleted.');
	}*/
	
	// new remove - sets state to -2
	function removeItem()
	{
		global $mainframe;
		global $option;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db			= & JFactory::getDBO();

		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$return		= JRequest::getCmd( 'returntask', '', 'post' );
		$nullDate	= $db->getNullDate();

		JArrayHelper::toInteger($cid);

		if (count($cid) < 1) {
			$msg =  JText::_('Select an item to delete');
			$mainframe->redirect('index.php?option='.$option, $msg, 'error');
		}

		// Removed content gets put in the trash [state = -2] and ordering is always set to 0
		$state		= '-2';
		$ordering	= '0';

		// Get the list of content id numbers to send to trash.
		$cids = implode(',', $cid);

		//get the table name based on the component name
		$table = str_replace("com_","#__",$option) . "_tbl";
		
		// Update articles in the database
		$query = 'UPDATE ' . $table .
				' SET state = '.(int) $state .
				', ordering = '.(int) $ordering .
				', checked_out = 0, checked_out_time = '.$db->Quote($nullDate).
				' WHERE id IN ( '. $cids. ' )';
				
		$db->setQuery($query);
		if (!$db->query())
		{
			JError::raiseError( 500, $db->getErrorMsg() );
			return false;
		}

		$cache = & JFactory::getCache($option);
		$cache->clean();

		$msg = JText::sprintf('Item(s) sent to the Trash', count($cid));
		$mainframe->redirect('index.php?option='.$option.'&task='.$return, $msg);
	}
	
	
	function cancel()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		global $option;
		
		// Check the article in if checked out
		$row =& JTable::getInstance('single', 'Table');
		$row->bind(JRequest::get('post'));
		$row->checkin();

		$this->setRedirect('index.php?option=' . $option,"No changes saved");
	}
	
	
	// order up
	function orderup()
	{
		$this->orderContent(-1);
	}
	
	// order down
	function orderdown()
	{
		$this->orderContent(1);
	}
		
	/**
	* Moves the order of a record
	* @param integer The increment to reorder by
	*/
	function orderContent($direction)
	{
		global $option;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db		= & JFactory::getDBO();

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if (isset( $cid[0] ))
		{
			$row =& JTable::getInstance('single', 'Table');
			$row->load( (int) $cid[0] );
			$row->move($direction, 'catid = ' . (int) $row->catid . ' AND state >= 0' );

			$cache = & JFactory::getCache($option);
			$cache->clean();
		}

		$this->setRedirect('index.php?option='.$option);
	}
	
	
	// saves the changed order 
	function saveorder()
	{
		global $mainframe;
		global $option;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db			=& JFactory::getDBO();

		$cid		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$order		= JRequest::getVar( 'order', array (0), 'post', 'array' );
		$redirect	= JRequest::getVar( 'redirect', 0, 'post', 'int' );
		$rettask	= JRequest::getVar( 'returntask', '', 'post', 'cmd' );
		$total		= count($cid);
		$conditions	= array();

		JArrayHelper::toInteger($cid, array(0));
		JArrayHelper::toInteger($order, array(0));

		// Instantiate an article table object
		$row =& JTable::getInstance('single', 'Table');

		// Update the ordering for items in the cid array
		for ($i = 0; $i < $total; $i ++)
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store())
				{
					JError::raiseError( 500, $db->getErrorMsg() );
					return false;
				}
				// remember to updateOrder this group
				$condition = 'published >= 0';
				$found = false;
				foreach ($conditions as $cond)
				{
					if ($cond[1] == $condition)
					{
						$found = true;
						break;
					}
				}
				if (!$found)
				{
					$conditions[] = array ($row->id, $condition);
				}
			}
		}

		// execute updateOrder for each group
		foreach ($conditions as $cond)
		{
			$row->load($cond[0]);
			$row->reorder($cond[1]);
		}

		$cache = & JFactory::getCache($option);
		$cache->clean();

		$msg = JText::_('New ordering saved');
		switch ($rettask)
		{
			case 'showarchive' :
				$mainframe->redirect('index.php?option=' . $option . '&task=showarchive&sectionid='.$redirect, $msg);
				break;

			default :
				$mainframe->redirect('index.php?option=' . $option . '&sectionid='.$redirect, $msg);
				break;
		}
	}
	
	
	// displays the item
	function display()
	{
		global $mainframe;
		
		$view = JRequest::getVar('view');
		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		'',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		
		if(!$view)
		{
			$task = $this->getTask();
			if($task == 'add' || $task == 'edit')
			{
				$row =& JTable::getInstance('single', 'Table');
	 			$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
				JArrayHelper::toInteger($cid, array(0));
		 		$id				= JRequest::getVar( 'id', $cid[0], '', 'int' );
				$row->load($id);
				$user = & JFactory::getUser();
				if (JTable::isCheckedOut($user->get ('id'), $row->checked_out ))
				{
					$msg = JText::sprintf('DESCBEINGEDITTED', JText::_('The item'), $row->title);
		 			$mainframe->redirect('index.php?option=' . $option, $msg);
 				}
 				if(!$row->checkout($user->get('id')))
		 		{
					exit("OH NO!");
				}
 				JRequest::setVar('view', 'single');
			}
			else
			{
				JRequest::setVar('view', 'all');
			}
		}

		parent::display();
	}
}