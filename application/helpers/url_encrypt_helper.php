<?php

//Generates keys taken from the config file encryption key with your very own key
function __key()
{
	$ci =& get_instance();
	$key = 'JHNjhu^H&687^YUIYbgfVYTrg786*&6587U^*&hyuiJHhgbhFGCgfdREws423!W#$215453GJHgjhGjh';
	$date = date('y-M-F-Dd',time());
	return $ci->config->item('encryption_key').sha1($key).sha1($date);
}

// hashes things with key
function __hash($x)
{	
	$date = date('y-M-F-Dd',time());
	return sha1($x.md5($x).__key().sha1($date)).sha1($date);
}

/*
*	encrypts the link
*	returns the encrypted string and hash value
*/
function _se($link_id)
{
	$link_id = _clean($link_id);
	$ci =& get_instance();
	$ci->load->library('encrypt');
	$key = __key();
	return (object)array('link'=>urlencode($ci->encrypt->encode($link_id,$key)),'hash'=>__hash($link_id));
}


/*
* Decrypts the link key and checks the hash value
* @param string encrypted string
* @param string hashed string for checking
* 
*/
function _sd($cyp,$hash)
{
	$cyp = _clean($cyp);
	$hash = _clean($hash);
	$ci =& get_instance();
	$ci->load->library('encrypt');
	$key = __key();
	$link_id = $ci->encrypt->decode($cyp,$key);
	$hash_from_key = __hash($link_id);
	if($hash == $hash_from_key)
	{
		return (object)array('link'=>$link_id,'status'=>'TRUE');
	}else{
		return (object)array('link'=>NULL,'status'=>'FALSE');
	}
}

function _e($link_id)
{
	$link_id = _clean($link_id);
	$ci =& get_instance();
	$ci->load->library('encrypt');
	$key = __key();
	return urlencode($ci->encrypt->encode($link_id,$key));
}

function _d($cyp)
{
	$cyp = _clean($cyp);
	$ci =& get_instance();
	$ci->load->library('encrypt');
	$key = __key();
	$link_id = $ci->encrypt->decode($cyp,$key);
	return $link_id;
}


function _clean($string)
{
	return trim(strip_tags($string));
}