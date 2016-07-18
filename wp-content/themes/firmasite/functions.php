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
include ( get_template_directory() . '/scripter/system/libraries/Filtro.php');
include ( get_template_directory() . '/scripter/system/libraries/carro.php');

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
	$carrito = new carro();
	$carrito->reset();
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
	return home_url().'/?page_id='.get_page_by_title( $modulo)->ID;

	/*switch($modulo)
	{
		case 'usuarios': return home_url().'/?page_id=189';
	}
	return home_url();*/
}

function load_ci_template()
{
	$page_navegation=$_GET['page_id'];
	$filtro = new Filtro('filtros_busqueda');
	$filtro->reset();
	switch($page_navegation)
	{
		case get_page_by_title( 'Buscador')->ID:
															$filtro = new Filtro();
															$filtro->set('busqueda',urldecode($_GET['grid_searsh']));
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;
		case get_page_by_title( 'Valvulas IAC')->ID:
															$filtro->multiSet	(
																					array	(
																								'valvulas_iac'	=>	array	(	'nombre_campo'	=>'cri.marca_componente',
																																'condicion'		=>'=',
																																'exprecion'		=>'VALVULA IAC'
																															)
																							)
																				);
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;
		case get_page_by_title( 'Bobinas')->ID:
															$filtro->multiSet	(
																					array	(
																								'bobinas'		=>	array	(	'nombre_campo'	=>'cri.marca_componente',
																																'condicion'		=>'=',
																																'exprecion'		=>'BOBINA'
																															)
																							)
																				);
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;
		case get_page_by_title( 'Sensores')->ID:
															$filtro->multiSet	(
																					array	(
																								'sensores'		=>	array	(	'nombre_campo'	=>'cri.componente',
																																'condicion'		=>'=',
																																'exprecion'		=>'SENSORES'
																															)
																							)
																				);
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;
		case get_page_by_title( 'Pedidos')->ID:
															get_template_part( 'templates/ci_ajax_templates/pedidos');
															break;
		case get_page_by_title( 'Contacto')->ID:
															get_template_part( 'templates/ci_ajax_templates/contacto');
															break;
		case get_page_by_title( 'Login')->ID:
															get_template_part( 'templates/ci_ajax_templates/login');
															break;

		case get_page_by_title( 'INJETECH')->ID:
															$filtro->multiSet	(
																					array	(
																								'bombas_gasolina'		=>	array	(	'nombre_campo'	=>'cri.componente',
																																		'condicion'		=>'=',
																																		'exprecion'		=>'BOMBA DE GASOLINA'
																																	),
																								'intetecj'				=>	array	(	'nombre_campo'	=>'cri.marca_refaccion',
																																		'condicion'		=>'=',
																																		'exprecion'		=>'INJETECH'
																																	)
																							)
																				);
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;

		case get_page_by_title( 'Inyectores de gasolina')->ID:
															$filtro->multiSet	(
																					array	(
																								'inyectores_gasolina'		=>	array	(	'nombre_campo'	=>'cri.componente',
																																		'condicion'		=>'=',
																																		'exprecion'		=>'INYECTORES'
																																	)
																							)
																				);
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;

		case get_page_by_title( 'Promociones')->ID:
															$filtro->multiSet	(
																					array	(
																								'promociones'			=>	array	(	'nombre_campo'	=>'NOT ISNULL(p.id_promocion)',
																																		'condicion'		=>'AND',
																																		'exprecion'		=>'1'
																																	)
																							)
																				);
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;
		case get_page_by_title( 'Logout')->ID:
															get_template_part( 'templates/ci_ajax_templates/logout');
															break;
		case get_page_by_title( 'Usuarios')->ID:
															get_template_part( 'templates/ci_ajax_templates/modulo_usuario');
															break;
		case get_page_by_title( 'Carrito')->ID:
															get_template_part( 'templates/ci_ajax_templates/modulo_carrito');
															break;
		case get_page_by_title( 'INJEKTION')->ID:
															$filtro->multiSet	(
																					array	(
																								'bombas_gasolina'		=>	array	(	'nombre_campo'	=>'cri.componente',
																																		'condicion'		=>'=',
																																		'exprecion'		=>'BOMBA DE GASOLINA'
																																	),
																								'intetecj'				=>	array	(	'nombre_campo'	=>'cri.marca_refaccion',
																																		'condicion'		=>'=',
																																		'exprecion'		=>'INJEKTION'
																																	)
																							)
																				);
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;
		case get_page_by_title( 'Linea electrica')->ID:
															$filtro->multiSet	(
																					array	(
																								'linea_electrica'		=>	array	(	'nombre_campo'	=>'cri.componente',
																																		'condicion'		=>'=',
																																		'exprecion'		=>'SISTEMA ELECTRICO'
																																	)
																							)
																				);
															get_template_part( 'templates/ci_ajax_templates/buscar');
															break;
		default:break;
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