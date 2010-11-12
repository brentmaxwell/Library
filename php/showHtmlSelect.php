<?php
/*
	Outputs an HTML select box from an array, ensuring that the selected value
	is marked as selected
	
	@param string $name name and id of select box
	@param array $options array of choices ($value=>$name);
	             optgroups should have the optgroup name as the $value
	             and the $name should be the options
	@param mixed $selected value of selected item
	@param string @first intro item, such as "Select one..."
*/

function showHtmlSelect($name,$options,$selected,$first=null)
{
	echo '<select name="'.$name.'" id="'.$name.'">';
	if($first)
	{
		echo "<option>".$first."</option>";
	}
	foreach($options as $value=>$name)
	{
		if(is_array($name))
		{
			echo '<optgroup label="'.$value.'">';
			foreach($name as $value2=>$name2)
			{
				echo '<option value="'.$value2.'"'.($value=$selected?' selected="selected"':'').'>'.$name2.'</option>';
			}
			echo '</optgroup>';
		}
		echo '<option value="'.$value.'"'.($value=$selected?' selected="selected"':'').'>'.$name.'</option>';
	}
	echo '</select>';
}