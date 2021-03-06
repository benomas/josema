<?php
/* You should use child-themes for customizing FirmaSite theme. 
 * With child-theme usage, you can easily keep FirmaSite up-to-date
 * Detailed info and example child-theme: 
 * http://theme.firmasite.com/child-theme/
 */

/* DONT REMOVE THOSE LINES BELOW */

// If you define this as false, powered by WordPress icon in bottom will not show
if ( !defined('FIRMASITE_POWEREDBY') )
	define('FIRMASITE_POWEREDBY', false);

// If you define this as false, designer info in bottom will not show
if ( !defined('FIRMASITE_DESIGNER') )
	define('FIRMASITE_DESIGNER', true);

/*
 * You can define subset thats limiting google fonts
 * Default: 'latin-ext' means theme will only show fonts that have 'latin-ext' support and will load 'latin-ext' while calling that font.
 * You can use multi subsets with comma seperated. Example: define('FIRMASITE_SUBSETS', 'cyrillic,cyrillic-ext');
 * You dont need to define latin. For latin only you can define as empty: define('FIRMASITE_SUBSETS', '');
 */
if ( !defined('FIRMASITE_SUBSETS') )
	define('FIRMASITE_SUBSETS', 'latin-ext');


// If you define this as false, theme will remove showcase posts from home page loop
if ( !defined('FIRMASITE_SHOWCASE_POST') )
	define('FIRMASITE_SHOWCASE_POST', true);


// If you define this as true, theme will use cdn for bootstrap style, font-awesome icons and jQuery. 
// FirmaSite Theme Enhancer plugin have to activated for work.
if ( !defined('FIRMASITE_CDN') )
	define('FIRMASITE_CDN', false);

	
// If you define this as false, theme will not combine javascript blocks when loading pages
if ( !defined('FIRMASITE_COMBINE_JS') ) {
	if (!empty($GLOBALS['wp_customize'])){
		define('FIRMASITE_COMBINE_JS', false);
	} else {
		define('FIRMASITE_COMBINE_JS', false);
	}
}
define('BASEPATH',true);	
include ( 'scripter/system/libraries/filtro.php');	

function process_menu($menu_items)
{
	if(empty($menu_items))	
		return $menu_items;
	$final_menu=array();
	foreach($menu_items AS $item)
	{
		switch ($item->title)
		{
			case 'Login':if(!$_SESSION['josema'])$final_menu[]=$item;break;
			case 'Logout':if($_SESSION['josema'])$final_menu[]=$item;break;
			case 'Registro':if(0)$final_menu[]=$item;break;
			default:$final_menu[]=$item;
		}
	}
	return $final_menu;
}

function get_rcodeigniter_url($complement='')
{
	return 'wp-content/themes/firmasite/scripter/'.$complement;
}

function get_rcodeigniter_access_url($complement='')
{
	return 'wp-content/themes/firmasite/scripter/index.php/'.$complement;
}

function codeigniter_logout()
{
	require_once ( get_template_directory() . '/functions/phpsession.php');
	$codeigniter_session= new Phpsession();
	$codeigniter_session->clear(null,'josema');
	header( 'Location:'.home_url()) ;
}

function codeigniter_is_login()
{
	require_once ( get_template_directory() . '/functions/phpsession.php');
	$codeigniter_session= new Phpsession();
	if(!$codeigniter_session->get('activo','josema'))
		return FALSE; 
	return TRUE;
}

function login_redirect()
{
	header( 'Location:'.home_url().'/?page_id=133') ;
}

function load_user_panel()
{
	get_template_part( 'templates/user_panel', $firmasite_settings["user_panel"] );
}

function get_codeigniter_session_var($var='')
{
	require_once ( get_template_directory() . '/functions/phpsession.php');
	$codeigniter_session= new Phpsession();
	return $codeigniter_session->get($var,'josema');
}

function modulo_url($modulo)
{	
	switch($modulo)
	{
		case 'usuario': return home_url().'/?page_id=189';
	}
	return home_url();
}

function load_ci_template()
{
	$page_navegation=$_GET['page_id'];
	$filtro = new Filtro('filtros_busqueda');
	$filtro->reset();
	switch($page_navegation)
	{	
		case '23':	
					$filtro = new Filtro();
					$filtro->set('busqueda',urlencode($_GET['grid_searsh']));
					get_template_part( 'templates/ci_ajax_templates/buscar');
					break;
		case '86': 
					$filtro->multiSet	(	array	(	'mc.nombre'=>'VALVULAS IAC'
													)
										);
					get_template_part( 'templates/ci_ajax_templates/buscar');
					break;
		case '88': 
					$filtro->multiSet	(	array	(	'mc.nombre'=>'BOBINAS DE IGNICION'
													)
										);
					get_template_part( 'templates/ci_ajax_templates/buscar');
					break;
		case '90': 
					$filtro->multiSet	(	array	(	'mc.nombre'=>'SENSORES MAF'
													)
										);
					get_template_part( 'templates/ci_ajax_templates/buscar');
					break;
		case '133':	
					get_template_part( 'templates/ci_ajax_templates/login');
					break;
		
		case '175': 
					$filtro->multiSet	(	array	(	'mc.nombre'=>'BOMBAS DE GASOLINA',
														'mr.nombre'=>'INJETECH'
													)
										);
					get_template_part( 'templates/ci_ajax_templates/buscar');
					break;
		case '187':
					get_template_part( 'templates/ci_ajax_templates/logout');
					break;
		case '189': 
					get_template_part( 'templates/ci_ajax_templates/modulo_usuario');
					break;
		case '194': 
					$filtro->multiSet	(	array	(	'mc.nombre'=>'BOMBAS DE GASOLINA',
														'mr.nombre'=>'INJEKTION'
													)
										);
					get_template_part( 'templates/ci_ajax_templates/buscar');
					break;
	}
}

/* filter session funtions*/
function resetFiltros()
{
	$filtro = new Filtro();
	$filtro->reset();
}

function addFiltros($filtroBusqueda=array())
{
	$filtro = new Filtro();
	$filtro->multiSet($filtroBusqueda);
}



include ( get_template_directory() . '/functions/customizer-call.php');			// Customizer functions
require_once ( get_template_directory() . '/functions/init.php');	// Initial theme setup and constants

/* DONT REMOVE THOSE LINES ABOVE */

