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
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('word_pres_url'))
{ 
	function word_pres_url($uri = '')
	{ 
		return '';
	}
}


if ( ! function_exists('ci_word_pres_url'))
{ 
	function ci_word_pres_url()
	{ 
		$ci_sub_dir='/wp-content/themes/firmasite/scripter/';
		$ci_full_path=base_url();
		$temp = str_replace($ci_sub_dir,'',$ci_full_path);
		return $temp;
	}
}

/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */