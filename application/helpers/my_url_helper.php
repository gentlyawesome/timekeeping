<?php

if ( ! function_exists('badge_link'))
{
	function badge_link($uri = '', $type='', $value='Default Title', $attr = '', $confirm = false)
	{
		$CI =& get_instance();
		$url_to = $CI->config->base_url($uri);
		$value = ucwords($value);
		$delete = $confirm ? 'confirm' : ''; 
		$html = "<a href='{$url_to}' {$attr} class='{$delete} badge btn-${type}'>{$value}</a>";
		
		
		return $html;
	}
}

