<?php
	function create_random_string($word = false, $ln = 6)
	{
		$ln = rand(3, 5);
		//FOR CAPTCHA PURPOSE
		if ($word == false)
		{
			$pool = '123456789abcdefhijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
		}
		else
		{
			$pool = $word;
		}

		$str = '';
		
		for ($i = 0; $i < $ln; $i++){
	   
			$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}

		$word = $str;
			
		return $word;
	}
?>