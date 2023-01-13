<?php

function friendly_ordinal_display($value)
{
	$baseValue = $value % 10;
	switch($baseValue)
	{
		case 1:
			$value .= 'st';
			break;
		case 2:
			$value .= 'nd';
			break;
		case 3:
			$value .= 'rd';
			break;
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
		case 10:
			$value .= 'th';
			break;
	}

	return $value;
}