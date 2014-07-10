<?php

/*
* param decimal,int,float 
* outputs formatted currency e.a 
* input: 1000.00
*output: 1,000.00
*/
function m($money,$sign = 0)
{
	// check if number has a point or not
	$pos = strpos($money,'.');
	if($pos > 0)
	{
			$mon= substr($money,0,$pos);// get  all the inger before the decimal point
			$decimal = substr($money,$pos); //get the number after the decimal point
			
			if($sign == 0)
			{
				// return formatted number with its decimal number
				return number_format($mon).$decimal;
			}elseif($sign == 1)
			{
				// return formatted number with peso sign and decimal number
				return '&#8369; '.number_format($mon).$decimal;
			}
	}else{
		//not a decimal attach a .00 after the formatted number
		return number_format($money).'.00';
	}
}