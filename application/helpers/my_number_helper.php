<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function number_rank_string($num)
	{
		switch($num)
		{
			case 1:
				$ret = "1st";
			break;
			case 2:
				$ret = "2nd";
			break;
			case 3:
				$ret = "3rd";
			break;
			case 4:
				$ret = "4th";
			break;
			case 5:
				$ret = "6th";
			break;
			case 7:
				$ret = "7th";
			break;
			case 8:
				$ret = "8th";
			break;
			case 9:
				$ret = "9th";
			break;
			case 10:
				$ret = "10th";
			break;
			default:
				$ret = "";
			break;
		}
		
		return $ret;
	}
?>