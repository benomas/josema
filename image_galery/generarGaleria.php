<?php

if(!isset($_GET['token']) || $_GET['token']!=='4444333221' )
	die();
else
	echo 'Redimiencionando imagenes...<br>';

include('imagination.php');
	$imgSizes	=	array	(	'original'		=>array(	'width'		=>'100%',
															'height'	=>'100%',
															'quality'	=>'100',
															'option'	=>'exact',
															'alias'		=>'',
															'path'		=>'../josema.com.mx/daniel_morales/imagenes/'
														),
								'original_size'		=>array(	'width'		=>'100',
																'height'	=>'100',
																'quality'	=>'100',
																'option'	=>'original',
																'alias'		=>'',
																'path'		=>'../wp-content/themes/firmasite/scripter/images/inventario/original_size/'
														),
								'middle_size'		=>array(	'width'		=>'250',
																'height'	=>'250',
																'quality'	=>'100',
																'option'	=>'auto',
																'alias'		=>'',
																'path'		=>'../wp-content/themes/firmasite/scripter/images/inventario/middle_size/'
														),
								'tiny_size'			=>array(	'width'		=>'120',
																'height'	=>'120',
																'quality'	=>'100',
																'option'	=>'auto',
																'alias'		=>'',
																'path'		=>'../wp-content/themes/firmasite/scripter/images/inventario/tiny_size/'
													)
						);
$options=array('imgSizes'=>$imgSizes);
$processImages= new Imagination($options);

echo 'Cargamdo configuracion...<br>';
$processImages->makeSubImagination();
echo 'Proceso completado';
?>