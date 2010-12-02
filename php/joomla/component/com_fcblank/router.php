<?php
/**
 * @package      fcblank
 * @copyright    Copyright (C) 2010 Fathom Creative, Inc. All rights reserved.
 * @author       Anthony D. Paul <apaul@fathomcreative.com>, Brent Maxwell <bmaxwell@fathomcreative.com>
 * @version      0.9
 */
 
defined('_JEXEC') or die('Restricted access');

function FcblankBuildRoute(&$query)
{
	$segments = array();
	if(isset($query['view']))
	{
		$segments[] = $query['view'];
		unset($query['view']);
	}
	if(isset($query['id']))
	{
		$segments[] = $query['id'];
		unset($query['id']);
	}
	return $segments;
}

function FcblankParseRoute($segments)
{
	$vars = array();
	if(isset($segments[0]))
	{
		$vars['view'] = $segments[0];
	}
	if(isset($segments[1]))
	{
		$vars['id'] = $segments[1];
	}
	return $vars;
}
