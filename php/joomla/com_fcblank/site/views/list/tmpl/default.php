<?php
/**
 * @package      fcblank
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9.1
 */
 ?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php jimport('fathom.fcglobals');?>
<?php jimport('fathom.fcutilities');?>

<h2>Component Title</h2>
<ul>
	<?php foreach ($this->rows as $row):?>
		<?php $link = JRoute::_('blank/' . $row->id . '/'); ?>
		<li><a href="<?php echo $link;?>"><?php echo htmlspecialchars($row->title);?></a>
		<?php if($this->show_introtext): ?>
			<p><?php echo FcUtilities::getClean($row->introtext);?></p>
		<?php endif;?>
		</li>
	<?php endforeach;?>
<ul>