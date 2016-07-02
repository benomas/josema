<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventario extends CI_Controller 
{
	public $limite;
	public $posicion_inicial;
	public function __construct()
   {
		parent::__construct();
		$this->load->model('Catalogos_model');
		$this->load->model('Inventario_model');
		$this->load->library('interdata');
		$this->load->library('phpsession');
		$this->load->library('centinela');
		$this->limite=20;
		$this->posicion_inicial=0;
		
   }
   
	public function index()
	{
		session_start();
	}
	
	function buscar($numero_pagina=false)
	{
		if(!$numero_pagina)
			$numero_pagina = $this->posicion_inicial;
		$inicio_sql= $numero_pagina * $this->limite;
		$filtro=$this->input->post('filtro_busqueda');
		$inventantario_array = $this->Inventario_model->get_inventario(false,$inicio_sql,$this->limite);
		$data['inventantario_array'] = $inventantario_array;
		$data['numero_elementos']=$this->Inventario_model->get_inventario(true,$inicio_sql,$this->limite);
		$data['limite']=$this->limite;
		$data['posicion_inicial']=$numero_pagina;
		$this->load->view('inventario/busquedaInventario',$data);
	}
	
	function informacionProducto($id_producto)
	{
		if($this->centinela->is_logged_in())
			$data['show_carrito']=TRUE;
		else
			$data['show_carrito']=FALSE;
		$data['producto'] = $this->Inventario_model->getProduct($id_producto);
		$data['referencias'] = $this->Inventario_model->getReferencias($id_producto);
		$this->load->view('inventario/informacionProducto',$data);
	}
	
	
	function dialogInformacionProducto($id_producto,$mostrar_carrito=false)
	{
		if($this->centinela->is_logged_in() && $mostrar_carrito)
			$data['show_carrito']=TRUE;
		else
			$data['show_carrito']=FALSE;
		$data['producto'] = $this->Inventario_model->getProduct($id_producto);
		$data['referencias'] = $this->Inventario_model->getReferencias($id_producto);
		$this->load->view('inventario/dialogInformacionProducto',$data);
	}
}