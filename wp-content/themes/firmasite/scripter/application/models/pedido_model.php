<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');
	
class Pedido_model extends CI_Model {
	function __construct(){
        parent::__construct();
    }
	
    function creaPedido($data,$products)
    {
		$clienteId 	= isset($data['id_usuario'])?
			$data['id_usuario']:
			null;
			
		$cliente	= isset($data['userData']) ?
			"{$data['userData']->nombre} {$data['userData']->apellido_paterno} {$data['userData']->apellido_materno}":
			null;

		$vendedorId = isset($data['userData'])?
			$data['userData']->id_vendedor:
			null;

		$vendedor = null;
		if($vendedorId){
			$vendedorData = $this->Catalogos_model->getUserData($vendedorId);

			if(!empty($vendedorData))
				$vendedor = "{$vendedorData->nombre} {$vendedorData->apellido_paterno} {$vendedorData->apellido_materno}";
		}

		$generadorId = isset($data['vendedor'])?
			$data['vendedor']['id_usuario']:
			$clienteId;

		$generador = isset($data['vendedor'])?
			$vendedor:
			$cliente;

		$formaEntrega = isset($data['info']['tipo_envio']) && $data['info']['tipo_envio'] === 'sucursal'? 
			'Recoger en sucursal':
			'Envío a domicilio';

		$tipoPedido = $data['info']['envio'] == 2? 
			'Urgente':
			'Normal';

		$subtotal = array_reduce ($products,function($last,$producto){
			return $last + (round($producto->precio,2) * $producto->cantidad);
		},0);

		$subtotalDescuento = array_reduce ($products,function($last,$producto){
			return $last + (round($producto->precio_descuento,2) * $producto->cantidad);
		},0);

		$descuento 	= $subtotal - $subtotalDescuento;
		$iva 		= ($subtotal - $descuento) * .16; 
		$total 		= ($subtotal - $descuento) + $iva; 
		$folio      = uniqid();
		
		$pedidoData = [
			'folio'			=>$folio,
			'cliente_id'	=>$clienteId,
			'cliente'		=>$cliente,
			'vendedor_id'	=>$vendedorId,
			'vendedor'		=>$vendedor,
			'generador_id'	=>$generadorId,
			'generador'		=>$generador,
			'forma_entrega'	=>$formaEntrega,
			'tipo_pedido'	=>$tipoPedido,
			'subtotal'		=>$subtotal,
			'descuento'		=>$descuento,
			'iva'			=>$iva,
			'total'			=>$total,
			'observaciones'	=>$data['info']['Observaciones'],
			'estatus' 		=>'Borrador pedido'
		];
		$this->db->trans_start();
		$this->db->insert('pedidos', $pedidoData);
		$pedido = $this->db->from('pedidos')->where('folio', $folio)->get()->row();
		$this->db->from('pedidos')->where('id', $pedido->id);
		$folio = "JM{$pedido->id}";
		$this->db->update('pedidos', ['folio'=>$folio]);
		
		foreach($products as $product){
			$this->creaProductosPedido($pedido->id,$product);
		}

        $this->db->trans_complete();

        return $this->db->trans_status() ? $folio : null;
	}

	function creaProductosPedido($pedidoId,$product){
		$this->db->insert('productos_pedido', [
			'pedido_id'				=>$pedidoId,
			'id_inventario'			=>$product->id_inventario,
			'npc'					=>$product->npc,
			'componente'			=>$product->componente,
			'marca'					=>$product->marca,
			'marca_componente'		=>$product->marca_componente,
			'marca_refaccion'		=>$product->marca_refaccion,
			'descripcion'			=>$product->descripcion,
			'origen'				=>$product->origen,
			'precio'				=>$product->precio,
			'precio_promocion'		=>$product->precio_promocion,
			'referencias'			=>$product->referencias,
			'descuento_10_cliente'	=>$product->descuento_10_cliente,
			'esPromocion'			=>$product->esPromocion,
			'precio_descuento'		=>$product->precio_descuento,
			'cantidad'				=>$product->cantidad
		]);
	}

	function pedidoSolicitado($folio){
		$this->db->from('pedidos')->where('folio', $folio);
		$this->db->update('pedidos', ['estatus'=>'Solicitado']);
	}
}
?>