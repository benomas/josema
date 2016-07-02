<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */


// ------------------------------------------------------------------------
/**
 * arrays
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('reditribudeArray'))
{ 
	function reditribudeArray($originArray, $rows=1, $files=1)
	{
		$level0 = array();
		$cont=0;
		foreach($originArray AS $field)
		{
			if($cont < $rows)
			{
				if($cont==0)
					$newLevel = array();
				$newLevel[]=$field;	
				$cont++;
			}
			else
			{
				$level0[]=$newLevel;
				$cont=0;
			}
		}
		if($cont!=0)
		{
			while($cont++ < $rows)
					$newLevel[]='';
			$level0[]=$newLevel;
		}
		return $level0;
	}
}

if ( ! function_exists('replace_array'))
{ 
	function replace_array($originArray, $busqueda,$back_replace='',$front_replace='')
	{
		return $originArray;
		$replaced_array = array();
		$busqueda= '/('.preg_quote($busqueda).')/i';
		//$remplazo=preg_quote($front_replace).' ${1} '.preg_quote($back_replace);
		$remplazo=preg_quote($front_replace).' ${1} '.preg_quote($back_replace);
		$remplazo='\<label\>$1\<\\\/label\>';
		foreach($originArray AS $next_level)
		{
			$level0=array();
			foreach($next_level AS $low_level)
			{
				$level0[]=preg_replace($busqueda,$remplazo,$low_level);
			}
			$replaced_array[]=$level0;
		}
		return $replaced_array;
	}
}

/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */