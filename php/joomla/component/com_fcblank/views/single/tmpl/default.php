<?php
/**
 * @package      fcblank
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9
 */
 ?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php jimport('fathom.fcglobals');?>
<?php jimport('fathom.fcutilities');?>

<h2><?php echo htmlspecialchars($this->article->title); ?></h2>
<p class="createdate"><?php echo $this->date; ?></p>
<p><?php echo FcUtilities::getClean($this->article->fulltext); ?>