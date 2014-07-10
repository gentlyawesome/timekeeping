<?php
	function check_the_active_menu($controller = false)
	{
		if($controller && $controller != "#")	
		{
			$ci =& get_instance();
			$pass = false;
			$arr_con = explode('/', $controller);
					
			switch(count($arr_con))
			{
				case 1:
					//MEANS METHOD IS INDEX
					if($arr_con[0] == $ci->router->class){ 
						$pass = true; 
					}
				break;
				case 2:
					if($arr_con[0] == $ci->router->class
					&& $arr_con[1] == $ci->router->method){
						$pass = true;
					}
				break;
				case 3:
					if($arr_con[0] == $ci->router->class
					&& $arr_con[1] == $ci->router->method
					&& $arr_con[2] == $ci->uri->segment(3)){
						$pass = true;
					}
				break;
				
			}
		}
		
		return $pass;
	}
?>