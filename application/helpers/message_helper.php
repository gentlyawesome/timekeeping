<?php

  // Set flash message if success or error
  // $type(success, error)
  // $message = 'hello world'
  // $url = 'redirect to any url' leave blank if not needed

  function set_flash_message($type,$message, $url)
	{
	  $ci =& get_instance();
	  
	  if (empty($url))
	  {
	    $ci->session->set_flashdata("system_message", "<div class='$type'>$message</div>");
	  }
	  else
	  {
	    $ci->session->set_flashdata("system_message", "<div class='$type'>$message</div>");
	    redirect($url);
	  }
	  
	}
	
	
	// Show flash message
	// show set_flash_message that is set to controllers
	
	function show_flash_message()
	{
	  $ci =& get_instance();
	  return $ci->session->flashdata('system_message');
	}

?>
