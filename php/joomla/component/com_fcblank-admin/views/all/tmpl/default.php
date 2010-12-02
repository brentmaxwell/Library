<?php
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9
 */
 
defined('_JEXEC') or die('Restricted access');

JToolBarHelper::title( JText::_('Article Listing'), 'generic.png');
JToolBarHelper::publishList();
JToolBarHelper::unpublishList();
JToolBarHelper::preferences($option);
JToolBarHelper::editList();
JToolBarHelper::deleteList('Are you sure you want to delete these articles?');
JToolBarHelper::addNew();

$user	=& JFactory::getUser();
?>
<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td align="left">
		Search: 
		<input type="text" name="search" value="<?php echo $this->search ?>" id="search" />
		<button type="submit">Go</button>
		</td>
	</tr>
</table>	
<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->rows ); ?>);" />
			</th>
			<th width="5%" nowrap="nowrap"><?php echo JText::_('Published'); ?></th>
			<th class="title">
				<?php echo JHTML::_('grid.sort',   'Title', 't.title', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="8%">
				<?php echo JHTML::_('grid.sort',   'Order', 't.ordering', @$lists['order_Dir'], @$lists['order'] ); ?>
				<?php echo JHTML::_('grid.order',  $this->rows ); ?>
			</th>
			<th align="center" width="10">
				<?php echo JHTML::_('grid.sort',   'Created', 't.created', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th  class="title" width="8%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Created By', 'c.created_name', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th align="center" width="10">
				<?php echo JHTML::_('grid.sort',   'Modified', 't.modified', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th  class="title" width="8%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Modified By', 'm.modified_name', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="2%" class="title">
				<?php echo JHTML::_('grid.sort',   'ID', 't.id', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
		</tr>
	</thead>

<?php
jimport('joomla.filter.output');
$k = 0;
for ($i=0, $n=count( $this->rows ); $i < $n; $i++){
	$row = &$this->rows[$i];
	$access 	= JHTML::_('grid.access',   $row, $i, $row->state );
	$checked 	= JHTML::_('grid.checkedout',   $row, $i );
	$published = JHTML::_('grid.published', $row, $i );
	$created_date	= $row->created == '0000-00-00 00:00:00' ? 'N/A' : JHTML::_('date',  $row->created, JText::_('DATE_FORMAT_LC4') );
	$modified_date	= $row->modified == '0000-00-00 00:00:00' ? 'N/A' : JHTML::_('date',  $row->modified, JText::_('DATE_FORMAT_LC4') );
	$link = JFilterOutput::ampReplace('index.php?option=' . $option . '&task=edit&cid[]='. $row->id );
	
	$author = $row->author ? $row->author : $row->created_name;
	$modifier = $row->modifier ? $row->modifier : $row->modified_name;
	
	if ( $user->authorize( 'com_users', 'manage' ) ) {
		$linkA 	= 'index.php?option=com_users&task=edit&cid[]='. $row->created_by;
		$author = '<a href="'. JRoute::_( $linkA ) .'" title="'. JText::_( 'Edit User' ) .'">'. $author .'</a>';
		
		$linkA 	= 'index.php?option=com_users&task=edit&cid[]='. $row->modified_by;
		$modifier = '<a href="'. JRoute::_( $linkA ) .'" title="'. JText::_( 'Edit User' ) .'">'. $modifier .'</a>';
	}
	
	?>
	<tr class="<?php echo "row$k"; ?>">
		<td>
			<?php echo $this->pagination->getRowOffset( $i ); ?>
		</td>
		<td>
			<?php echo $checked; ?>
		</td>
		<td align="center">
			<?php echo $published; ?>
		</td>
		<td>
		<?php
			if (JTable::isCheckedOut($user->get('id'), $row->checked_out))
			{
				echo $row->title;
			}
			else if ($row->published == -1)
			{
				echo htmlspecialchars($row->title, ENT_QUOTES, 'UTF-8');
				echo ' [ '. JText::_( 'Archived' ) .' ]';
			}
			else
			{
				?>
				<a href="<?php echo JRoute::_( $link ); ?>">
					<?php echo htmlspecialchars($row->title, ENT_QUOTES); ?></a>
				<?php
			}
			?>
		</td>
		<td class="order">
			<span><?php echo $this->pagination->orderUpIcon( $i, true, 'orderup', 'Move Up'); ?></span>
			<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down'); ?></span>
			<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
		</td>
		<td nowrap="nowrap">
			<?php echo $created_date; ?>
		</td>
		<td>
			<?php echo $author; ?>
		</td>
		<td nowrap="nowrap">
			<?php echo $modified_date; ?>
		</td>
		<td>
			<?php echo $modifier; ?>
		</td>
		<td>
			<?php echo $row->id; ?>
		</td>
	</tr>
	<?php
	$k = 1 - $k;
}
?>
	<tfoot>
		<tr>
			<td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
</table>
<?php echo JHTML::_('form.token'); ?>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
</form>