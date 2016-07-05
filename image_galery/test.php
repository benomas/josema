<?php
include('imagination.php');
	$imgSizes	=	array	(	'original'		=>array(	'width'		=>'100%',
															'height'	=>'100%',
															'quality'	=>'100',
															'option'	=>'exact',
															'alias'		=>'',
															'path'		=>'tmp/'
														),
								'middle_size'		=>array(	'width'		=>'250px',
																'height'	=>'250px',
																'quality'	=>'100',
																'option'	=>'auto',
																'alias'		=>'',
																'path'		=>'tmp/middle_size/'
														),
								'tiny_size'			=>array(	'width'		=>'120px',
																'height'	=>'120px',
																'quality'	=>'100',
																'option'	=>'auto',
																'alias'		=>'',
																'path'		=>'tmp/tiny_size/'
													)
						);
$options=array('imgSizes'=>$imgSizes);
$processImages= new Imagination($options);

$processImages->makeSubImagination();
//$processImages->resetImgFiles();
//$processImages->makeSubImagination();
?>