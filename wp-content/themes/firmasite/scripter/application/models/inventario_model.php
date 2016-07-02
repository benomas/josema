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
		if($filtro->isEmpty())
		{
			$filtro = new Filtro();
			$busqueda = $filtro->getValue('busqueda');
			if(!empty($busqueda))
				$WHERE="	WHERE	CONCAT(	
											IFNULL(tc.nombre,' '), 
											' ',
											IFNULL(m.nombre,' '),
											' ',
											IFNULL(mc.nombre,' '),
											' ',
											IFNULL(mr.nombre,' '),
											' ',
											IFNULL(i.descripcion,' '),
											' ',
											IFNULL(o.nombre,' '),
											' ',
											IFNULL(i.npc,' '), 
											' ',
											IFNULL(		
														(	
															SELECT	GROUP_CONCAT(ir.codigo SEPARATOR ', ')
															FROM	ci_inventario_referencia AS ir
															WHERE	ir.id_inventario=i.id_inventario						
														),
														' '
													)
											)LIKE '%".$busqueda."%' 
						";
			else
				$WHERE="";
		}
		else
		{
			$filtros=$filtro->getFiltros();
			$WHERE=" WHERE 1 ";
			foreach($filtros AS $filtro=>$params)
			{
				$WHERE.= " AND	".$params['nombre_campo']." ".$params['condicion']." '".$params['exprecion']."' ";
			}
		}
		$consulta=	"	SELECT	i.id_inventario,
								i.npc,
								tc.nombre AS componente,
								m.nombre AS marca,
								mc.nombre AS marca_componente,
								mr.nombre AS marca_refaccion,
								i.descripcion,
								o.nombre AS origen,
								ipv.monto AS precio,
								(	
									SELECT	GROUP_CONCAT(ir.codigo SEPARATOR ', ')
									FROM	ci_inventario_referencia AS ir
									WHERE	ir.id_inventario=i.id_inventario						
								) AS referencias
						FROM ci_inventario AS i
						LEFT JOIN	ci_tipo_componente 			AS	tc 	ON	tc.id_tipo_componente=i.id_tipo_componente
						LEFT JOIN	ci_marca 					AS	m 	ON	m.id_marca=i.id_marca
						LEFT JOIN	ci_marcacomponente 			AS 	mc 	ON	mc.id_marcacomponente=i.id_marcacomponente
						LEFT JOIN	ci_marcarefaccion 			AS 	mr 	ON	mr.id_marcarefaccion=i.id_marcarefaccion
						LEFT JOIN	ci_origen 					AS 	o 	ON	o.id_origen=i.id_origen 
						LEFT JOIN   usuario 					AS 	u 	ON 	u.id_usuario='".$id_usuario."'
						LEFT JOIN	ci_precio_venta 			AS 	pv 	ON 	pv.id_tipo_cliente=u.id_tipo_cliente
						LEFT JOIN	ci_inventario_precio_venta 	AS 	ipv ON 	ipv.id_inventario=i.id_inventario AND ipv.id_precio_venta = pv.id_precio_venta
						LEFT JOIN	ci_promocion				AS	p	ON	p.id_inventario=i.id_inventario AND
																			IF(NOT ISNULL(p.fecha_inicio),IF(NOW() > p.fecha_inicio,1,0),1)	AND
																			IF(NOT ISNULL(p.fecha_fin),IF(NOW() < p.fecha_fin,1,0),1)	
																			
					".$WHERE;
	if($contar)
		return $this->db->query($consulta)->num_rows();
	if($limite )
		$consulta.=' LIMIT '.$posicion.' ,'.$limite.' ';
		
	/*
		promociones
	*/	
		$inventario=$this->db->query($consulta)->result_array();
		foreach($inventario AS $indice=>$producto)
		{
			
			$promocion = $this->getPromocion($producto['id_inventario']);
			if($promocion)
				$inventario[$indice]['promocion']=$promocion;
		}
	return $inventario;
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
		$consulta=	"	SELECT	i.id_inventario,
								i.npc,
								tc.nombre AS componente,
								m.nombre AS marca,
								mc.nombre AS marca_componente,
								mr.nombre AS marca_refaccion,
								i.descripcion,
								o.nombre AS origen,
								ipv.monto AS precio
						FROM ci_inventario AS i
						LEFT JOIN	ci_tipo_componente AS tc ON tc.id_tipo_componente=i.id_tipo_componente
						LEFT JOIN	ci_marca AS m ON m.id_marca=i.id_marca
						LEFT JOIN	ci_marcacomponente AS mc ON mc.id_marcacomponente=i.id_marcacomponente
						LEFT JOIN	ci_marcarefaccion AS mr ON mr.id_marcarefaccion=i.id_marcarefaccion
						LEFT JOIN	ci_origen AS o ON o.id_origen=i.id_origen
						LEFT JOIN   usuario AS u ON u.id_usuario='".$id_usuario."'
						LEFT JOIN	ci_precio_venta AS pv ON pv.id_tipo_cliente=u.id_tipo_cliente
						LEFT JOIN	ci_inventario_precio_venta AS ipv ON ipv.id_inventario=i.id_inventario AND ipv.id_precio_venta = pv.id_precio_venta
						WHERE	i.id_inventario='".$id_producto."'
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
		$consulta=	"	SELECT	i.id_inventario,
								i.npc,
								tc.nombre AS componente,
								m.nombre AS marca,
								mc.nombre AS marca_componente,
								mr.nombre AS marca_refaccion,
								i.descripcion,
								o.nombre AS origen,
								ipv.monto AS precio
						FROM ci_inventario AS i
						LEFT JOIN	ci_tipo_componente AS tc ON tc.id_tipo_componente=i.id_tipo_componente
						LEFT JOIN	ci_marca AS m ON m.id_marca=i.id_marca
						LEFT JOIN	ci_marcacomponente AS mc ON mc.id_marcacomponente=i.id_marcacomponente
						LEFT JOIN	ci_marcarefaccion AS mr ON mr.id_marcarefaccion=i.id_marcarefaccion
						LEFT JOIN	ci_origen AS o ON o.id_origen=i.id_origen
						LEFT JOIN   usuario AS u ON u.id_usuario='".$id_usuario."'
						LEFT JOIN	ci_precio_venta AS pv ON pv.id_tipo_cliente=u.id_tipo_cliente
						LEFT JOIN	ci_inventario_precio_venta AS ipv ON ipv.id_inventario=i.id_inventario AND ipv.id_precio_venta = pv.id_precio_venta
						WHERE	i.npc='".$npc."'
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
}
?>