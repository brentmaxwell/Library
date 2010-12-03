<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Index of <?php echo $_SERVER['REQUEST_URI'] ?></title>
	</head>
	<body>
		<h1>Index of <?php echo $_SERVER['REQUEST_URI']?></h1>
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Last modified</th>
					<th>Size</th>
				</tr>
			</thead>
			<tbody>
			
<?
	$dir = '.';
	$files = scandir($dir);
	foreach($files as $file)
	{
		if(!($file == '.' || $file == '..' || $file == 'index.php'))
		{
			echo "\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t<td><a href=\"$file\">$file</a></td>\n";
			echo "\t\t\t\t\t<td>" . filemtime($file) . "</td>\n";
			echo "\t\t\t\t\t<td>" . filesize($file) . "</td>\n";
			echo "\t\t\t\t</tr>\n";
		}
	}
?>
			</tbody>
		</table>
	</body>
</html>
