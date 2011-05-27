<?php
/**
 * @package      fcblank-admin
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('fathom.fcadmin');

JHTML::_('behavior.calendar');
$editor =& JFactory::getEditor();

if($this->row->id)
{
	JToolBarHelper::title( JText::_('Edit Article'), 'addedit.png');
}
else
{
	JToolBarHelper::title( JText::_('Add Article'), 'addedit.png');
}

JToolBarHelper::save();
JToolBarHelper::apply();
if($this->row->id)
{
	JToolBarHelper::cancel('cancel', 'Close');
}
else
{
	JToolBarHelper::cancel();
}

?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton){
	if(pressbutton == 'save' || pressbutton == 'apply')
	{
		var introtext = <?php echo $editor->getContent('introtext'); ?>
		if(document.adminForm.title.value == '')
		{
			alert("Please enter the title of the article.");
		}
		else if(introtext == '' && document.adminForm.introtext.value == '')
		{
			alert("Please enter intro text for the article.");
		}
		else
		{
			submitform(pressbutton);
		}
	}
	else
	{
		submitform(pressbutton);
	}
}
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<fieldset class="adminform">
		<legend>Details</legend>
		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key">
					Title:
				</td>
				<td>
					<input class="text_area" type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $this->row->title; ?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					Intro text:
					<br/>
					<?php FcAdmin::showRichTextKey();?>
				</td>
				<td>
					<?php echo $this->editor->display('introtext',  $this->row->introtext, '100%', '150', '40', '5'); ?>
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					More text:
					<br/>
					<?php FcAdmin::showRichTextKey();?>
				</td>
				<td>
					<?php echo $this->editor->display('fulltext',  $this->row->fulltext, '100%', '250', '40', '10'); ?>
				</td>
			</tr>
			<?php if(!empty($this->displaydate)):?>
			<tr>
				<td width="100" align="right" class="key">
					Article Date:
				</td>
				<td>
					<?php echo $this->displaydate; ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td width="100" align="right" class="key">
					Published:
				</td>
				<td>
					<?php echo $this->published; ?>
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_('form.token'); ?>
</form>