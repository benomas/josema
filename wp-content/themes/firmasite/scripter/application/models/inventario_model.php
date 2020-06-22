<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventario_model extends CI_Model
{
	function __construct()
    {
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

	function getNpcs()
	{
		$query = $this->db->query("	SELECT npc FROM ci_resumen_inventario ");
		return $query->result_array();
	}


	function get_inventario($contar=false,$posicion='0',$limite='0')
	{
		$id_usuario=$this->centinela->getDinamicIdUser();
		$filtro = new Filtro('filtros_busqueda');
		$consulta='';
		if($filtro->isEmpty())
		{
			$filtro = new Filtro();
			$busqueda = $filtro->getValue('busqueda');
			if(!empty($busqueda))
			{ 
				$consulta=$this->getConsultaConstante($id_usuario)." WHERE cri.busqueda LIKE '%".$busqueda."%' ";

				for($i=1;$i<5;$i++)
					if(!empty($_GET["basic_filter_name$i"]) && !empty($_GET["basic_filter_value$i"]))
						$consulta=$consulta." AND ".$_GET["basic_filter_name$i"]."='".$_GET["basic_filter_value$i"]."'";

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
						for($i=1;$i<5;$i++)
							if(!empty($_GET["basic_filter_name$i"]) && !empty($_GET["basic_filter_value$i"]))
								$consulta=$consulta." AND ".$_GET["basic_filter_name$i"]."='".$_GET["basic_filter_value$i"]."'";
					}
				}
			}
			else{
				$consulta=$this->getConsultaConstante($id_usuario).'WHERE 1';
				for($i=1;$i<5;$i++)
					if(!empty($_GET["basic_filter_name$i"]) && !empty($_GET["basic_filter_value$i"]))
						$consulta=$consulta." AND ".$_GET["basic_filter_name$i"]."='".$_GET["basic_filter_value$i"]."'";
			}
		}
		else
		{
			$filtros=$filtro->getFiltros();
			$WHERE=" WHERE 1 ";
			foreach($filtros AS $filtro=>$params)
			{
				$WHERE.= " AND	".$params['nombre_campo']." ".$params['condicion']." '".$params['expresion']."' ";
			}
			$tarifas = $this->db->query(" SELECT tc.nombre FROM usuario AS u JOIN tipo_cliente AS tc ON tc.id_tipo_cliente = u.id_tipo_cliente WHERE  u.id_usuario='".$id_usuario."'")
						->result_array();
			if(count($tarifas)>0)
				$tarifa=$tarifas[0]['nombre'];
			else $tarifa = 'precio_lista';

			$consulta=	"	SELECT	cri.id_resumen_inventario AS id_inventario,
									cri.npc,
									cri.componente AS componente,
									cri.marca AS marca,
									cri.marca_componente AS marca_componente,
									cri.marca_refaccion AS marca_refaccion,
									cri.descripcion,
									'' AS origen,
									IF( '".$tarifa."'!='precio_lista', REPLACE(cri.".$tarifa.", '$', ''),NULL)AS precio,
									cri.referencias
						FROM ci_resumen_inventario AS cri

					".$WHERE;
		}
		
		if($contar)
			return $this->db->query($consulta)->num_rows();
		if($limite )
			$consulta.=' LIMIT '.$posicion.' ,'.$limite.' ';
		$inventario=$this->db->query($consulta)->result_array();

		return $inventario;
	}

	function getConsultaConstante($id_usuario)
	{
		$tarifas = $this->db->query(" SELECT tc.nombre FROM usuario AS u JOIN tipo_cliente AS tc ON tc.id_tipo_cliente = u.id_tipo_cliente WHERE  u.id_usuario='".$id_usuario."'")
						->result_array();
			if(count($tarifas)>0)
				$tarifa=$tarifas[0]['nombre'];
			else $tarifa = 'precio_lista';

		return "	SELECT	cri.id_resumen_inventario AS id_inventario,
								cri.npc,
								cri.componente AS componente,
								cri.marca AS marca,
								cri.marca_componente AS marca_componente,
								cri.marca_refaccion AS marca_refaccion,
								cri.descripcion,
								'' AS origen,
								IF( '".$tarifa."'!='precio_lista', REPLACE(cri.".$tarifa.", '$', ''),NULL)AS precio,
								cri.referencias
						FROM ci_resumen_inventario AS cri
					";
	}

	function getCombinaciones($sujeto)
	{
		$patrón = '/\w+/';
		preg_match_all($patrón, $sujeto, $coincidencias);
		$recorrido=0;
		$totalTokens=count($coincidencias[0]);
		$combinacionesTokens[$recorrido++]=$coincidencias;
		if($totalTokens > 8)
			return $combinacionesTokens;
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
		$id_usuario=$this->centinela->getDinamicIdUser();
		$tarifas = $this->db->query(" SELECT tc.nombre FROM usuario AS u JOIN tipo_cliente AS tc ON tc.id_tipo_cliente = u.id_tipo_cliente WHERE  u.id_usuario='".$id_usuario."'")
						->result_array();
			if(count($tarifas)>0)
				$tarifa=$tarifas[0]['nombre'];
			else $tarifa = 'precio_lista';

		$consulta=	"	SELECT	cri.id_resumen_inventario AS id_inventario,
								cri.npc,
								cri.componente AS componente,
								cri.marca AS marca,
								cri.marca_componente AS marca_componente,
								cri.marca_refaccion AS marca_refaccion,
								cri.descripcion,
								'' AS origen,
								IF( '".$tarifa."'!='precio_lista', REPLACE(cri.".$tarifa.", '$', ''),NULL)AS precio,
								cri.k AS precio_promocion,
								cri.referencias
						FROM ci_resumen_inventario AS cri
						WHERE	cri.id_resumen_inventario='".$id_producto."'
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
		$id_usuario=$this->centinela->getDinamicIdUser();

		$tarifas = $this->db->query(" SELECT tc.nombre FROM usuario AS u JOIN tipo_cliente AS tc ON tc.id_tipo_cliente = u.id_tipo_cliente WHERE  u.id_usuario='".$id_usuario."'")
						->result_array();
			if(count($tarifas)>0)
				$tarifa=$tarifas[0]['nombre'];
			else $tarifa = 'precio_lista';

		$consulta=	"	SELECT	cri.id_resumen_inventario AS id_inventario,
								cri.npc,
								cri.componente AS componente,
								cri.marca AS marca,
								cri.marca_componente AS marca_componente,
								cri.marca_refaccion AS marca_refaccion,
								cri.descripcion,
								'' AS origen,
								IF( '".$tarifa."'!='precio_lista', REPLACE(cri.".$tarifa.", '$', ''),NULL)AS precio,
								cri.k AS precio_promocion,
								cri.referencias
						FROM ci_resumen_inventario AS cri
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

	function cargaFilasImportacion($filasImportacion,$posicionColumnaCondicional)
	{
		$this->db_backup();
		$mapa_db_cvs = array();
        $mapa_db_cvs['npc']=array('cvs_nombre_columna'=>'NPC','cvs_posicion_columna'=>'');
        $mapa_db_cvs['numero']=array('cvs_nombre_columna'=>'NUMERO','cvs_posicion_columna'=>'');
        $mapa_db_cvs['presentacion']=array('cvs_nombre_columna'=>'PRESENTACION','cvs_posicion_columna'=>'');
        $mapa_db_cvs['tipo']=array('cvs_nombre_columna'=>'TIPO','cvs_posicion_columna'=>'');
        $mapa_db_cvs['sub_tipo']=array('cvs_nombre_columna'=>'SUB TIPO','cvs_posicion_columna'=>'');
        $mapa_db_cvs['embalaje']=array('cvs_nombre_columna'=>'EMBALAJE','cvs_posicion_columna'=>'');
        $mapa_db_cvs['marca_componente']=array('cvs_nombre_columna'=>'TIPO DE COMPONENTE','cvs_posicion_columna'=>'');
        $mapa_db_cvs['componente']=array('cvs_nombre_columna'=>'LINEA','cvs_posicion_columna'=>'');
        $mapa_db_cvs['marca']=array('cvs_nombre_columna'=>'ARMADORA','cvs_posicion_columna'=>'');
        $mapa_db_cvs['marca_refaccion']=array('cvs_nombre_columna'=>'','cvs_posicion_columna'=>'27');
        $mapa_db_cvs['proveedor']=array('cvs_nombre_columna'=>'PROVEEDOR','cvs_posicion_columna'=>'');
        $mapa_db_cvs['descripcion']=array('cvs_nombre_columna'=>'DESCRIPCION','cvs_posicion_columna'=>'');
        //$mapa_db_cvs['precio_lista']=array('cvs_nombre_columna'=>'PRECIO DE LISTA','cvs_posicion_columna'=>'');
        //$mapa_db_cvs['precio_compra']=array('cvs_nombre_columna'=>'','cvs_posicion_columna'=>'34');
        $mapa_db_cvs['a']=array('cvs_nombre_columna'=>'A','cvs_posicion_columna'=>'');
        $mapa_db_cvs['b']=array('cvs_nombre_columna'=>'B 10%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['c']=array('cvs_nombre_columna'=>'C 15%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['d']=array('cvs_nombre_columna'=>'D 17.55%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['e']=array('cvs_nombre_columna'=>'E 18.4%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['f']=array('cvs_nombre_columna'=>'F 19.25%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['g']=array('cvs_nombre_columna'=>'G 20%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['h']=array('cvs_nombre_columna'=>'H 25%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['i']=array('cvs_nombre_columna'=>'I 30%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['j']=array('cvs_nombre_columna'=>'J 32.5%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['k']=array('cvs_nombre_columna'=>'K 35%','cvs_posicion_columna'=>'');
        $mapa_db_cvs['precio_promocion1']=array('cvs_nombre_columna'=>'PRECIO PROMOCION','cvs_posicion_columna'=>'');
        $mapa_db_cvs['precio_promocion2']=array('cvs_nombre_columna'=>'PRECIO PROMOCION','cvs_posicion_columna'=>'');
        $mapa_db_cvs['condicion_compra']=array('cvs_nombre_columna'=>'CONDICION DE COMPRA','cvs_posicion_columna'=>'');
        $mapa_db_cvs['codigo']=array('cvs_nombre_columna'=>'CODIGO','cvs_posicion_columna'=>'');
        $mapa_db_cvs['original']=array('cvs_nombre_columna'=>'ORIGINAL','cvs_posicion_columna'=>'');
        $mapa_db_cvs['airtex']=array('cvs_nombre_columna'=>'AIRTEX','cvs_posicion_columna'=>'');
        $mapa_db_cvs['carter']=array('cvs_nombre_columna'=>'CARTER','cvs_posicion_columna'=>'');
        $mapa_db_cvs['kem']=array('cvs_nombre_columna'=>'KEM','cvs_posicion_columna'=>'');
        $mapa_db_cvs['walbro']=array('cvs_nombre_columna'=>'WALBRO','cvs_posicion_columna'=>'');
        $mapa_db_cvs['pfp']=array('cvs_nombre_columna'=>'PFP','cvs_posicion_columna'=>'');
        $mapa_db_cvs['delphi']=array('cvs_nombre_columna'=>'DELPHI','cvs_posicion_columna'=>'');
        $mapa_db_cvs['std']=array('cvs_nombre_columna'=>'STD','cvs_posicion_columna'=>'');
        $mapa_db_cvs['wells']=array('cvs_nombre_columna'=>'WELLS','cvs_posicion_columna'=>'');
        $mapa_db_cvs['tomco']=array('cvs_nombre_columna'=>'TOMCO','cvs_posicion_columna'=>'');
        $mapa_db_cvs['transpo']=array('cvs_nombre_columna'=>'TRANSPO','cvs_posicion_columna'=>'');
        $mapa_db_cvs['wai']=array('cvs_nombre_columna'=>'WAI','cvs_posicion_columna'=>'');
        $mapa_db_cvs['bosch']=array('cvs_nombre_columna'=>'BOSCH','cvs_posicion_columna'=>'');
        $mapa_db_cvs['unipoint']=array('cvs_nombre_columna'=>'UNIPOINT','cvs_posicion_columna'=>'');
        $mapa_db_cvs['interfil']=array('cvs_nombre_columna'=>'INTERFIL','cvs_posicion_columna'=>'');
        $mapa_db_cvs['valeo']=array('cvs_nombre_columna'=>'VALEO','cvs_posicion_columna'=>'');
        $mapa_db_cvs['oe_otro']=array('cvs_nombre_columna'=>'OE / OTRO','cvs_posicion_columna'=>'');

		$this->db->trans_start();
		$this->db->query('TRUNCATE `ci_resumen_inventario`;');
		$query='';
		$query_insert='';
		$filasPorQuery = 30;
		$contadorFilas = 0;
		$mapa_db_cvs=$this->complementaMapa($mapa_db_cvs,$filasImportacion[0]);
		unset($filasImportacion[0]);
		$db_preparacion=array();
		foreach ($filasImportacion as $filaCvs)
		{
			$db_preparacion_temporal=array();
			foreach ($mapa_db_cvs as $db_indice_columna => $db_configuracion_columna)
			{
				if(	isset($db_configuracion_columna) &&
					isset($db_configuracion_columna['cvs_posicion_columna'])&&
					isset($filaCvs[$db_configuracion_columna['cvs_posicion_columna']])
				)
				$db_preparacion_temporal[$db_indice_columna] = $filaCvs[$db_configuracion_columna[
					'cvs_posicion_columna']
					];
					else
						$db_preparacion_temporal[$db_indice_columna] = '';
			}

			if(count($db_preparacion_temporal)>0)
			{
				$db_preparacion_temporal['referencias'] 	= $this->generaReferencias($mapa_db_cvs,$filaCvs);
				$db_preparacion_temporal['busqueda'] 		= $this->generaBusqueda($mapa_db_cvs,$filaCvs);
				$db_preparacion[]=$db_preparacion_temporal;
			}
		}
		foreach ($db_preparacion[0] as $db_preparacion_indice => $db_preparacion_valor)
		{
			if($query_insert !=='')
				$query_insert = $query_insert.' , ';
			else
				$query_insert = $query_insert. 	'	INSERT INTO ci_resumen_inventario
																(
												';
				$query_insert = $query_insert. 	'
													`'.$db_preparacion_indice.'`
												';
		}
		$query_insert = $query_insert. 	' 			)
											VALUES
										';

		foreach ($db_preparacion as $db_preparacion_posicion_fila => $db_preparacion_fila)
		{
			try{
				$queryValues='';
				if($query !=='')
					$query = $query.' , ';
				foreach ($db_preparacion_fila as $db_preparacion_indice => $db_preparacion_valor)
				{
					if($queryValues !=='')
						$queryValues = $queryValues.' , ';
					else
						$queryValues = $queryValues.' ( ';

						$queryValues = $queryValues. 	'
															"'.mysql_real_escape_string($db_preparacion_valor).'"
														';
				}
				$queryValues = $queryValues.' ) ';
				$query=$query.$queryValues;
				$contadorFilas++;

				if($contadorFilas ===$filasPorQuery)
				{
					$this->db->query($query_insert.$query);
					$contadorFilas=0;
					$query ='';
				}
			} catch (Exception $e) {

			}
		}
		if($contadorFilas > 0 )
		{
			$this->db->query($query_insert.$query);
		}
        $this->db->trans_complete();
        return $this->db->trans_status();
	}

	function complementaMapa($mapa_db_cvs,$cvs_cabecera)
	{
		foreach ($mapa_db_cvs as $db_indice_columna => $db_configuracion_columna)
		{
			if(
					(
						!isset($db_configuracion_columna['cvs_posicion_columna']) ||
						$db_configuracion_columna['cvs_posicion_columna'] ===''
					) &&
					(
						isset($db_configuracion_columna['cvs_nombre_columna']) &&
						$db_configuracion_columna['cvs_nombre_columna'] !==''
					)
				)
			{
				foreach ($cvs_cabecera as $cvs_posicion_columna => $cvs_valor_columna)
				{

					if($db_configuracion_columna['cvs_nombre_columna'] === $cvs_valor_columna)
					{
						$mapa_db_cvs[$db_indice_columna]['cvs_posicion_columna']=$cvs_posicion_columna;
						unset($cvs_cabecera[$cvs_posicion_columna]);
						break;
					}
				}
			}
			else
			{
				if(
					(
						!isset($db_configuracion_columna['cvs_posicion_columna']) ||
						$db_configuracion_columna['cvs_posicion_columna'] ===''
					) &&
					(
						!isset($db_configuracion_columna['cvs_nombre_columna']) ||
						$db_configuracion_columna['cvs_nombre_columna'] ===''
					)
				)
					unset($mapa_db_cvs[$db_indice_columna]);
			}

		}
		return $mapa_db_cvs;
	}

	function resuelveFila($db_columna,$cvs_cabecera,$cvs_fila)
	{
		if(
			isset($db_columna['cvs_posicion_columna']) &&
			$db_columna['cvs_posicion_columna']!=='' &&
			isset($cvs_fila[$db_columna['cvs_nombre_columna']]) &&
			$cvs_fila[$db_columna['cvs_nombre_columna']]!==''
			)
				return $cvs_fila[$db_columna['cvs_nombre_columna']];

		if(
			isset($db_columna['cvs_nombre_columna']) &&
			$db_columna['cvs_nombre_columna']!==''
			)
			foreach ($cvs_cabecera as $key => $value)
			{
				if($value === $db_columna['cvs_nombre_columna'])
					return $cvs_fila[$key];
			}

		if(isset($cvs_fila[$db_columna['cvs_nombre_columna']]) && $cvs_fila[$db_columna['cvs_nombre_columna']]!=='')
			return $cvs_fila[$db_columna['cvs_nombre_columna']];

		if(isset($cvs_fila[$db_columna['cvs_nombre_columna']]) && $cvs_fila[$db_columna['cvs_nombre_columna']]!=='')
			return $cvs_fila[$db_columna['cvs_nombre_columna']];
        $mapa_db_cvs['npc']=array('cvs_nombre_columna'=>'NPC','cvs_posicion_columna'=>'');
	}

	function generaReferencias($mapa_db_cvs,$filaCvs)
	{
		$referencias = array('codigo','original','airtex','carter','kem','walbro','pfp','delphi','std','wells','tomco','transpo','wai','bosch','unipoint','valeo','interfil','oe_otro');
		$referenciasConcatenadas='';
		foreach ($referencias as $referencia)
		{
			if(isset($mapa_db_cvs[$referencia]))
			{
				$referenciasConcatenadas=$referenciasConcatenadas.' '.$filaCvs[$mapa_db_cvs[$referencia]['cvs_posicion_columna']].' ';
			}
		}
		return $referenciasConcatenadas;
	}

	function generaBusqueda($mapa_db_cvs,$filaCvs)
	{
		$camposBusqueda = array(	'npc','numero','presentacion','tipo','sub_tipo','embalaje','marca_componente','componente','marca','marca_refaccion','proveedor','descripcion',
									'codigo','original','airtex','carter','kem','walbro','pfp','delphi','std','wells','tomco','transpo','wai','bosch','unipoint','valeo','interfil','oe_otro'
									);
		$busquedaConcatenada='';
		foreach ($camposBusqueda as $referencia)
		{
			if(
				isset($mapa_db_cvs) &&
				isset($mapa_db_cvs[$referencia]) &&
				isset($mapa_db_cvs[$referencia]['cvs_posicion_columna'])
			)
			{
				$partial='';
				if(isset($filaCvs[$mapa_db_cvs[$referencia]['cvs_posicion_columna']]))
					$partial = $filaCvs[$mapa_db_cvs[$referencia]['cvs_posicion_columna']];
				$busquedaConcatenada=$busquedaConcatenada.' '.$partial.' ';
			}
		}
		return $busquedaConcatenada;
	}

	private function db_backup()
	{
	       $this->load->dbutil();
	       $backup =& $this->dbutil->backup();
	       $this->load->helper('file');
	       write_file('dumps/josemaco_wp_store_'.microtime().'.zip', $backup);
	}

	//columna tipo componente, y de excel
	public function getCatalog($column){
		$query=	"	SELECT DISTINCT(".$column.") 
					FROM ci_resumen_inventario
					WHERE 
						NOT ".$column." IS NULL AND
						".$column." <> '0' AND
						".$column." <> '' AND
						".$column." <> '-'
					ORDER BY ".$column." ASC
				";
		return $this->db->query($query)->result_array();
	}

	//columna tipo componente, y de excel
	public function catMarcaComponente(){
		return $this->getCatalog("marca_componente");
	}

	//columna linea, z de excel
	public function catComponente(){
		return $this->getCatalog("componente");
	}

	//columna armadora, aa de excel
	public function catMarca(){
		return $this->getCatalog("marca");
	}

	//columna armadora, aa de excel
	public function catMarcaRefaccion(){
		return $this->getCatalog("marca_refaccion");
	}
}