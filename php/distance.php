<?php

function distance2($lat1, $lon1, $lat2, $lon2, $unit)
{ 
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	
	if ($unit == "K")
	{
		return ($miles * 1.609344);
	}
	else if ($unit == "N")
	{
		return ($miles * 0.8684);
	}
	else
	{
		return $miles;
	}
}

function distance($lat1,$lng1,$lat2,$lng2)
{
	define("RADIUS_OF_EARTH",6378);

	$p1x = RADIUS_OF_EARTH * cos(deg2rad($lat1)) * cos(deg2rad($lng1));
	$p1y = RADIUS_OF_EARTH * cos(deg2rad($lat1)) * sin(deg2rad($lng1));
	$p1z = RADIUS_OF_EARTH * sin(deg2rad($lat1));
	
	$p2x = RADIUS_OF_EARTH * cos(deg2rad($lat2)) * cos(deg2rad($lng2));
	$p2y = RADIUS_OF_EARTH * cos(deg2rad($lat2)) * sin(deg2rad($lng2));
	$p2z = RADIUS_OF_EARTH * sin(deg2rad($lat2));
	
	$dx = $p2x - $p1x;
	$dy = $p2y - $p1y;
	$dz = $p2z - $p1z;

	$d = sqrt(($dx * $dx) + ($dy * $dy) + ($dz * $dz));

	return 2 * RADIUS_OF_EARTH * asin($d / 2 / RADIUS_OF_EARTH);
}

echo distance(38.880886,-77.108735,38.890774,-77.072085);

?>