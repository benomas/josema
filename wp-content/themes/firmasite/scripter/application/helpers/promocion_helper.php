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
if ( ! function_exists('title_promocion'))
{ 
	function title_promocion($promocion = array())
	{ 
		$tittle='';
		if(!empty($promocion))
		{
			$tittle='Producto en promoción: ';
			if(!empty($promocion['descripcion']))
				$tittle.=$promocion['descripcion'];
			if(!empty($promocion['condicion']))
				$tittle.=', '.$promocion['condicion'];
			if(!empty($promocion['fecha_inicio']))
				$tittle.=', Fecha inicio: '.preg_replace('#(.*\s).*#','$1',$promocion['fecha_inicio']);
			if(!empty($promocion['fecha_fin']))
				$tittle.=', Fecha fin: '.preg_replace('#(.*\s).*#','$1',$promocion['fecha_fin']);
		}																					
		return $tittle;
	}
}

/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */