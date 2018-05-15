<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carrito extends CI_Controller {

	public function __construct()
   {
		parent::__construct();
		$this->load->model('Catalogos_model');
		$this->load->model('Inventario_model');
		$this->load->model('Usuario_model');

		$this->load->library('phpsession');
		$this->load->library('centinela');

		if(! $this->centinela->is_logged_in() )
		{
			redirect('/seguridad/login','location');
		}
		$this->load->library('carro');
   }

	public function index()
	{

	}

	public function vistaCarrito()
	{
		$productos= $this->carro->getProductos();

		if(!empty($productos))
		{
			foreach($productos AS $producto)
			{
				$data['productos'][]=$this->Inventario_model->getProduct($producto);
			}
		}
		if(!isset($data))
			$data[]=array();
		$data['show_carrito']=FALSE;
		$this->load->view('carrito/productos',$data);
	}

	function add_carrito($id_producto)
	{
		$producto = $this->Inventario_model->getProduct($id_producto);
		if(empty($producto))
		{
			echo 'error';
			return false;
		}

		$result=$this->carro->addProduct($id_producto);
		$this->Usuario_model->setCar($this->centinela->get("id_usuario"),$this->carro->getProductos());

		if($result==1)
			echo 'error';
		if($result==2)
			echo 'correcto';
		if($result==3)
			echo 'already';
		return true;
	}


	function informacionProducto($id_producto)
	{
		$data['show_carrito']=FALSE;
		$data['producto'] = $this->Inventario_model->getProduct($id_producto);
		$data['referencias'] = $this->Inventario_model->getReferencias($id_producto);
		$this->load->view('inventario/informacionProducto',$data);
	}

	function remove_carrito($id_producto)
	{
		$result=$this->carro->remove($id_producto);
		$this->Usuario_model->setCar($this->centinela->get("id_usuario"),$this->carro->getProductos());
		$this->vistaCarrito();
	}

	function vaciar_carrito()
	{
		$this->carro->reset();
		$this->Usuario_model->setCar($this->centinela->get("id_usuario"),$this->carro->getProductos());
		$this->vistaCarrito();
	}
}