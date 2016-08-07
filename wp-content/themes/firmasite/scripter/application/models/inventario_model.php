<?php
if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

class Inventario_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->library('Filtro');

    }

	function getUserData($user_id)
	{
		$query = $this->db->query("	SELECT first_name,last_name
									FROM wp_usermeta
									WHERE user_id = '".$user_id."'
									");
		return $query->result_array();
	}

	function get_inventario($contar=false,$posicion='0',$limite='0')
	{
		$id_usuario=0;
		$id_usuario=$this->centinela->get('id_usuario');
		$filtro = new Filtro('filtros_busqueda');
		$consulta='';
		if($filtro->isEmpty())
		{
			$filtro = new Filtro();
			$busqueda = $filtro->getValue('busqueda');
			if(!empty($busqueda))
			{
				$consulta=$this->getConsultaConstante($id_usuario)." WHERE cri.busqueda LIKE '%".$busqueda."%' ";
				$combinacionesTokens=$this->getCombinaciones($busqueda);
				foreach ($combinacionesTokens as $combinacionesTokensKey => $combinacionesTokensValue)
				{
					foreach ($combinacionesTokensValue as $filtrosKey => $filtrosValue)
					{
						$initWere=false;
						$consulta= $consulta." UNION ".$this->getConsultaConstante($id_usuario)." WHERE 1 ";
						foreach ($filtrosValue as $filtroKey => $filtroValue)
						{
							$consulta=$consulta." AND cri.busqueda LIKE '%".$filtroValue."%' ";
						}
					}
				}
			}
			else
				$consulta=$this->getConsultaConstante($id_usuario);
		}
		else
		{
			$filtros=$filtro->getFiltros();
			$WHERE=" WHERE 1 ";
			foreach($filtros AS $filtro=>$params)
			{
				$WHERE.= " AND	".$params['nombre_campo']." ".$params['condicion']." '".$params['expresion']."' ";
			}
			$consulta=	"	SELECT	cri.id_inventario,
								cri.npc,
								cri.componente AS componente,
								cri.marca AS marca,
								cri.marca_componente AS marca_componente,
								cri.marca_refaccion AS marca_refaccion,
								cri.descripcion,
								cri.origen AS origen,
								IF(pv.descuento IS NULL,NULL,IF(pv.descuento>0,(cri.precio_base*pv.descuento) ,cri.precio_base))AS precio,
								cri.referencias
						FROM ci_resumen_inventario AS cri
						LEFT JOIN   usuario 					AS 	u 	ON 	u.id_usuario='".$id_usuario."'
						LEFT JOIN	ci_precio_venta 			AS 	pv 	ON 	pv.id_tipo_cliente=u.id_tipo_cliente
						LEFT JOIN	ci_inventario_precio_venta 	AS 	ipv ON 	ipv.id_inventario=cri.id_inventario
						LEFT JOIN	ci_promocion				AS	p	ON	p.id_inventario=cri.id_inventario AND
																			IF(NOT ISNULL(p.fecha_inicio),IF(NOW() > p.fecha_inicio,1,0),1)	AND
																			IF(NOT ISNULL(p.fecha_fin),IF(NOW() < p.fecha_fin,1,0),1)

					".$WHERE;
		}

	if($contar)
		return $this->db->query($consulta)->num_rows();
	if($limite )
		$consulta.=' LIMIT '.$posicion.' ,'.$limite.' ';

	/*
		promociones
	*/
	$inventario=$this->db->query($consulta)->result_array();
	/*
	foreach($inventario AS $indice=>$producto)
	{

		$promocion = $this->getPromocion($producto['id_inventario']);
		if($promocion)
			$inventario[$indice]['promocion']=$promocion;
	}
	*/
	return $inventario;
	}

	function getConsultaConstante($id_usuario)
	{
		return "	SELECT	cri.id_inventario,
								cri.npc,
								cri.componente AS componente,
								cri.marca AS marca,
								cri.marca_componente AS marca_componente,
								cri.marca_refaccion AS marca_refaccion,
								cri.descripcion,
								cri.origen AS origen,
								IF(pv.descuento IS NULL,NULL,IF(pv.descuento>0,(cri.precio_base*pv.descuento) ,cri.precio_base))AS precio,
								cri.referencias
						FROM ci_resumen_inventario AS cri
						LEFT JOIN   usuario 					AS 	u 	ON 	u.id_usuario='".$id_usuario."'
						LEFT JOIN	ci_precio_venta 			AS 	pv 	ON 	pv.id_tipo_cliente=u.id_tipo_cliente
						LEFT JOIN	ci_inventario_precio_venta 	AS 	ipv ON 	ipv.id_inventario=cri.id_inventario
					";
	}

	function getCombinaciones($sujeto)
	{
		$patrón = '/\w+/';
		preg_match_all($patrón, $sujeto, $coincidencias);
		$recorrido=0;
		$totalTokens=count($coincidencias[0]);
		$combinacionesTokens[$recorrido++]=$coincidencias;
		while($recorrido<$totalTokens)
		{
			$cobinacionTemporal=$this->ignoraUnaPosicion($combinacionesTokens[$recorrido-1]);
			$combinacionesTokens[$recorrido]=$cobinacionTemporal;
			$recorrido++;
		}
		return $combinacionesTokens;
	}

	function ignoraUnaPosicion($combinacionesTokens)
	{
		$subquerys=array();

		if(isset($combinacionesTokens) && is_array($combinacionesTokens))
		{
			foreach ($combinacionesTokens as $iterationKey => $iterationValue)
			{
				if(is_array($iterationValue))
				{
					$begin=0;
					$end=count($iterationValue);
					while($begin<$end)
					{
						$tempArray = $iterationValue;
						unset($tempArray[$end-$begin-1]);
						if(!in_array($tempArray,$combinacionesTokens))
						{
							$alreadyInArray=false;
							foreach ($subquerys as $subquerysKey => $subquerysValue)
							{
								$totalOfSameItems=0;
								foreach ($subquerysValue as $key => $value)
								{
									if(isset($tempArray[$key]) && $value === $tempArray[$key])
										$totalOfSameItems++;
								}
								if($totalOfSameItems === count($tempArray))
									$alreadyInArray = $alreadyInArray || true;
							}
							if(!$alreadyInArray)
								$subquerys[]=$tempArray;
						}
						$begin++;
					}
				}
			}
		}
		return $subquerys;
	}

	function getPromocion($id_inventario)
	{
		$promocion = NULL;
		$consulta1=	"
							SELECT	promo.id_promocion,
									promo.nombre,
									promo.descripcion,
									promo.condicion,
									promo.fecha_inicio,
									promo.fecha_fin,
									t_promo.nombre_tabla_promocion
							FROM	ci_promocion AS promo
							JOIN	ci_tipo_promocion AS t_promo ON t_promo.id_tipo_promocion=promo.id_tipo_promocion
							WHERE	promo.id_inventario='".$id_inventario."'	AND
									promo.activo='1'	AND
									IF( NOT ISNULL(promo.fecha_inicio), now() > promo.fecha_inicio, 1)	AND
									IF( NOT ISNULL(promo.fecha_fin), now() < promo.fecha_fin, 1)
						";
		$resultado1=$this->db->query($consulta1)->result_array();
		if($resultado1)
		{
			$consulta2	=	"
								SELECT	*
								FROM	".$resultado1[0]['nombre_tabla_promocion']."
								WHERE	id_promocion='".$resultado1[0]['id_promocion']."'
							";
			$resultado2=$this->db->query($consulta2)->result_array();
		}
		if($resultado1 && $resultado2)
		{
			$promocion = array_merge($resultado1[0], $resultado2[0]);
		}
		return $promocion;
	}

	function getProduct($id_producto)
	{
		$id_usuario=0;
		$id_usuario=$this->centinela->get('id_usuario');
		$consulta=	"	SELECT	cri.id_inventario,
								cri.npc,
								cri.componente AS componente,
								cri.marca AS marca,
								cri.marca_componente AS marca_componente,
								cri.marca_refaccion AS marca_refaccion,
								cri.descripcion,
								cri.origen AS origen,
								IF(pv.descuento IS NULL,NULL,IF(pv.descuento>0,(cri.precio_base*pv.descuento) ,cri.precio_base))AS precio,
								cri.referencias
						FROM ci_resumen_inventario AS cri
						LEFT JOIN   usuario 					AS 	u 	ON 	u.id_usuario='".$id_usuario."'
						LEFT JOIN	ci_precio_venta 			AS 	pv 	ON 	pv.id_tipo_cliente=u.id_tipo_cliente
						LEFT JOIN	ci_inventario_precio_venta 	AS 	ipv ON 	ipv.id_inventario=cri.id_inventario
						WHERE	cri.id_inventario='".$id_producto."'
					";
		$promocion=$this->getPromocion($id_producto);
		$resultado=$this->db->query($consulta)->row();
		if($promocion)
			$resultado = (object) array_merge( (array)$resultado, array( 'promocion' => $promocion ) );
		return $resultado;
	}

	function getProductByNpc($npc)
	{
		$id_usuario=0;
		$id_usuario=$this->centinela->get('id_usuario');
		$consulta=	"	SELECT	cri.id_inventario,
								cri.npc,
								cri.componente AS componente,
								cri.marca AS marca,
								cri.marca_componente AS marca_componente,
								cri.marca_refaccion AS marca_refaccion,
								cri.descripcion,
								cri.origen AS origen,
								IF(pv.descuento IS NULL,NULL,IF(pv.descuento>0,(cri.precio_base*pv.descuento) ,cri.precio_base))AS precio,
								cri.referencias
						FROM ci_resumen_inventario AS cri
						LEFT JOIN   usuario 					AS 	u 	ON 	u.id_usuario='".$id_usuario."'
						LEFT JOIN	ci_precio_venta 			AS 	pv 	ON 	pv.id_tipo_cliente=u.id_tipo_cliente
						LEFT JOIN	ci_inventario_precio_venta 	AS 	ipv ON 	ipv.id_inventario=cri.id_inventario
						WHERE	cri.npc='".$npc."'
					";


		$resultado=$this->db->query($consulta)->row();
		if($resultado)
		{
			$promocion=$this->getPromocion($resultado->id_inventario);
		}
		if($promocion)
			$resultado = (object) array_merge( (array)$resultado, array( 'promocion' => $promocion ) );
		return $resultado;
	}

	function getReferencias($id_producto)
	{
		$consulta=	"	SELECT	r.nombre,
								ir.codigo
						FROM	ci_inventario_referencia AS ir
						JOIN	ci_referencia AS r ON r.id_referencia = ir.id_referencia
						WHERE	ir.id_inventario ='".$id_producto."'
					";
		return $this->db->query($consulta)->result_array();
	}

	function cat_injektion()
	{
		$WHERE =' WHERE 1 ';
		$searh=$this->input->post('grid_searsh');
		if(!empty($searh))
			$WHERE= $WHERE." AND
							CONCAT(	IFNULL(ci.codigo,' '),' ',
									IFNULL(ci.ref1,' '),' ',
									IFNULL(ci.ref2,' '),' ',
									IFNULL(ci.ref3,' '),' ',
									IFNULL(ci.marca,' '),' ',
									IFNULL(ci.descripcion,' '),' ',
									IFNULL(ci.precio1,' '),' ',
									IFNULL(ci.precio2,' '),' ',
									IFNULL(ci.precio3,' '),' '
								) LIKE '%".$searh."%'";
		$consulta = '	SELECT  ci.codigo,
								ci.ref1,
								ci.ref2,
								ci.ref3,
								ci.marca,
								ci.descripcion,
								ci.precio1,
								ci.precio2,
								ci.precio3
						FROM	cat_injektion AS ci '.$WHERE;
		return $this->db->query($consulta)->result_array();
	}

	function tipoScript($scriptImportacion)
	{
		$query ="
					SELECT 	cm.*,
							ctm.nombre AS tipo_mecanismo
					FROM	cat_mecanismo AS cm
					JOIN 	cat_tipo_mecanismo AS ctm ON ctm.id=cm.cat_tipo_mecanismo_id
					WHERE	cm.nombre = '{$scriptImportacion}'
				";
		return $this->db->query($query)->result_array();
	}

	function cargaDependenciasScript($pasoImportacion)
	{
		$query ="
					SELECT 	it.columna_base_de_datos,
							it.columna_cvs,
							ctc.nombre AS tipo_campo,
							cc.nombre  AS catalogo
					FROM	cat_mecanismo AS cm
					JOIN	importacion_template AS it ON it.cat_mecanismo_id=cm.id
					JOIN	cat_tipo_campo AS ctc ON ctc.id=it.cat_tipo_campo_id
					JOIN	cat_catalogo AS cc ON cc.id=it.cat_catalogo_id
					WHERE	cm.nombre = '{$pasoImportacion}'
				";

		return $this->db->query($query)->result_array();
	}

	function cargaTemplateConfiguracion($pasoImportacion)
	{
		$query ="
					SELECT 	it.columna_base_de_datos,
							it.columna_cvs,
							it.columna_referencia,
							ctc.nombre AS tipo_campo,
							cc.nombre  AS catalogo
					FROM	cat_mecanismo AS cm
					JOIN	importacion_template AS it ON it.cat_mecanismo_id=cm.id
					JOIN	cat_tipo_campo AS ctc ON ctc.id=it.cat_tipo_campo_id
					JOIN	cat_catalogo AS cc ON cc.id=it.cat_catalogo_id
					WHERE	cm.nombre = '{$pasoImportacion}'
				";
		return $this->db->query($query)->result_array();
	}

	function generaConsultasImportacion($ImportacionTabla,$importArray,$tipoScript)
	{
		$consultasImportacion ='';
		foreach ($importArray as $position => $value)
		{
			if($position>0)
			{
				$consultasImportacion=$consultasImportacion.$this->generaConsultaImportacion($value,$ImportacionTabla,$tipoScript[0]['nombre']);
			}
		}
		return $consultasImportacion;
	}

	function generaConsultaImportacion($row,$ImportacionTabla,$tablaObjetivo)
	{
		$consulta = ' INSERT INTO "`{$tablaObjetivo}`" ';
		$estructuraInsert=' ( ';
		$valoresInsert=' VALUES( ';
		$almenosUno=false;
		foreach ($ImportacionTabla as $key => $value)
		{
			if(isset($value['position']))
			{
				switch($value['tipo_campo'])
				{
					case 'texto'	:
										if(	isset($row[$value['position']]) && $row[$value['position']]!=='' && $row[$value['position']]!==NULL )
										{
											if($almenosUno)
											{
												$estructuraInsert 	= $estructuraInsert.',';
												$valoresInsert 		= $valoresInsert.',';
											}
											$estructuraInsert 	= $estructuraInsert.' `'.$value['columna_base_de_datos'].'` ';
											$valoresInsert 		= $valoresInsert.' "'.mysql_real_escape_string($row[$value['position']]).'" ';

											$almenosUno = true;
										}
										break;
					case 'catalogo'	:
										if(	isset($row[$value['position']]) && $row[$value['position']]!=='' && $row[$value['position']]!==NULL )
										{
											$catalogoId = $this->obtenerIdCatalogo($value['catalogo'],$value['columna_referencia'],$row[$value['position']]);

											if($catalogoId>0)
											{
												if($almenosUno)
												{
													$estructuraInsert 	= $estructuraInsert.',';
													$valoresInsert 		= $valoresInsert.',';
												}
												$estructuraInsert 	= $estructuraInsert.' `'.$value['columna_base_de_datos'].'` ';
												$valoresInsert 		= $valoresInsert.' "'.$catalogoId.'" ';

												$almenosUno = true;
											}
										}
										else
										{
											$catalogoId = $this->obtenerIdCatalogo($value['catalogo'],$value['columna_referencia'],'UNDEFINED');

											if($catalogoId>0)
											{
												if($almenosUno)
												{
													$estructuraInsert 	= $estructuraInsert.',';
													$valoresInsert 		= $valoresInsert.',';
												}
												$estructuraInsert 	= $estructuraInsert.' `'.$value['columna_base_de_datos'].'` ';
												$valoresInsert 		= $valoresInsert.' "'.$catalogoId.'" ';

												$almenosUno = true;
											}
										}

										break;
					default 		:	break;
				}
			}
		}
		if($almenosUno)
			return ' INSERT INTO producto '.$estructuraInsert.' ) '.$valoresInsert.' ); <br>';
		return '';
	}

	function obtenerIdCatalogo($catalogo,$columna_referencia,$valor)
	{
		if( mb_detect_encoding($valor) ==='UTF-8')
			$valor=utf8_encode($valor);

		$consulta= 	'
						SELECT 	id
						FROM	'.$catalogo.'
						WHERE	`'.$columna_referencia.'`="'.$valor.'"

					';
		try
		{
			$result = 	$this->db->query($consulta);
			if($result->num_rows()>0)
				return $result->row()->id;
		}
		catch (Exception $e)
		{
		}

		return -1;
	}


	function obtenerIdProducto($npc)
	{
		if( mb_detect_encoding($npc) ==='UTF-8')
			$nombre=utf8_encode($npc);

		$consulta= 	'
						SELECT 	id
						FROM	producto
						WHERE	npc="'.$npc.'"

					';
		try
		{
			$result = 	$this->db->query($consulta);
			if($result->num_rows()>0)
				return $result->row()->id;
		}
		catch (Exception $e)
		{
		}

		return -1;
	}

	function cargaCatalogo($catalogo,$cargaUndefined='false', $cargaInactivos='false')
	{
		$where = ' 1 ';
		if(!$cargaUndefined)
			$where = $where. ' AND cat.nombre!="UNDEFINED" ';
		if(!$cargaInactivos)
			$where = $where. ' AND cat.activo=="1" ';
		$query ='
					SELECT 	cat.*
					FROM	'.$catalogo.'	as cat
				';
		return $this->db->query($query)->result_array();
	}
}
?>