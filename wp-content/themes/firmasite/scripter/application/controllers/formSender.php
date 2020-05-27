<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FormSender extends CI_Controller
{

	public function __construct()
   {
		parent::__construct();
		$this->load->model('Catalogos_model');
		$this->load->model('Inventario_model');
		$this->load->model('Usuario_model');

		$this->load->library('phpsession');
		$this->load->library('centinela');
		if(! $this->centinela->is_logged_in() ) {
			redirect('/seguridad/login','location');
		}
		$this->load->library('carro');
   }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function loadForm($traerCarrito=true)
	{
		$data['filasDefault']            = '1';
		$data['numeroFilas']             = '1';
		$data[]                          = array();
		$data["vendedor"]                = in_array($this->centinela->get("rolName"),["Super Vendedor","Vendedor"])?$this->centinela->get_usuario():null;
		$data['userData']                = $this->Catalogos_model->getUserData($this->centinela->getDinamicIdUser());
		$data['promociones_habilitadas'] = true;
		
		if($data["vendedor"] && $data["vendedor"]->id_usuario === $data['userData']->id_usuario)
			$data['clientSelected'] = false;
		else
			$data['clientSelected'] = true;

		$data['traerCarrito']            = $traerCarrito;
		$data['carrito']                 = $productos = $this->carro->getProductos();
		$data['productosValidosCarrito'] = [];
		if(!empty($productos))
		{
			foreach($productos AS $idProducto=>$quantity)
			{
				if($quantity){
					$data['productos'][$idProducto]    = $this->Inventario_model->getProduct($idProducto);
					$data['productosValidosCarrito'][] = $idProducto;
				}
			}
		}
		if(!empty($data['productos']))
		{
			$data['numeroFilas']=count($data['productos']);
			$this->load->view('formTemplates/pedidoForm',$data);
		}
		else
			echo '	<div class="contenedor_info">
						<label class="concepto_field" style="font-size:16px;">Debes añadir productos al carrito</label>
					</div>';

	}


	public function sendPedido()
	{
		$productIds = json_decode(stripslashes($_POST["productIds"]));
		if(!$this->almenosUna($_POST['numeroFilas'],$productIds))
		{
			echo '	<div class="contenedor_info">
						<label class="concepto_field" style="font-size:16px;">Debes indicar almenos una cantidad</label>
					</div>';
			return false;
		}
		$data['info']               = $_POST;
		$data['info']["productIds"] = $productIds;
		if($data['info']['numeroFilas']>0 && $data['info']['numeroFilas'] < 100)
		for($i=0;$i<$data['info']['numeroFilas'];$i++)
		{
			$productId=$data['info']["productIds"][$i];
			if(isset($data['info']['Cantidad'.$productId]))
			{
				if($data['info']['Cantidad'.$productId]>0)
				{
					$data['info']['row'.$productId]=$this->Inventario_model->getProductByNpc($data['info']['NPC'.$productId]);
					$data['info']['row'.$productId]->esPromocion = false;
					if(isset($data['info']["precio_promocion_$productId"]) && in_array($this->centinela->get("rolName"),["Super Vendedor","Vendedor"])){
						$data['info']['row'.$productId]->precio = $data['info']['row'.$productId]->precio_promocion;
						$data['info']['row'.$productId]->esPromocion = true;
					}
				}
			}
		}
		$data["vendedor"]=in_array($this->centinela->get("rolName"),["Super Vendedor","Vendedor"])?$this->centinela->get_usuario():null;
		$data['userData']=$this->Catalogos_model->getUserData($this->centinela->getDinamicIdUser());
		$nombre= $data['userData']->nombre.' '.$data['userData']->apellido_paterno.' '.$data['userData']->apellido_materno;
		if(empty($nombre))
			$nombre=$data['userData']->nick;
		$data['nombreUsuario']=	$nombre;
		$data['id_usuario']=$this->centinela->getDinamicIdUser();
		$mensaje= $this->load->view('correoTemplates/body',$data,true);
		$list=array();
		$list[]=$data['userData']->email;
		$this->email->from('pedidos@josema.com.mx', 'JOSEMA');
		$this->email->to($list);
		$this->email->reply_to('', 'Este correo a sido generado electronicamente, no responda a este correo');
		$this->email->subject('Pedido electronico JOSEMA');
		$this->email->message($mensaje);
		if($this->email->send())
		{
			echo '	<div class="contenedor_info">
						<label class="concepto_field" style="font-size:16px;">Pedido enviado</label>
					</div>';
			$list=array();
			if(is_array($this->config->item('pedidos_emails')))
				$list = $this->config->item('pedidos_emails');
			else
			{
				$array_list=$this->Catalogos_model->getAdminMails();
				foreach($array_list AS $element)
				{
					$list[]=$element['email'];
				}
				$list[]=$data['userData']->email;
			}
			if(!$data["vendedor"]){
				$vendedor = $this->Usuario_model->vendor($data['userData']->id_vendedor);
				if($vendedor && $vendedor->row())
					$list[]=$data["vendedor"]["email"];
			}
			else
				$list[]=$data["vendedor"]->email;
			$this->email->from('pedidos@josema.com.mx', 'JOSEMA');
			$this->email->to($list);
			$this->email->reply_to('', 'Este correo a sido generado electronicamente, no responda a este correo');
			$this->email->subject('Pedido electronico JOSEMA');
			$this->email->message($mensaje);
			$this->email->send();
			$this->carro->reset();
			$this->Usuario_model->setCar($this->centinela->get("id_usuario"),$this->carro->getProductos());
		}
	}
	
	function almenosUna($numeroProductos=0,$productIds)
	{
		for($i=0;$i<$numeroProductos;$i++)
		{
			if(isset($_POST['Cantidad'.$productIds[$i]]))
			{
				$cantidad=$_POST['Cantidad'.$productIds[$i]];
				if($cantidad>0)
					return true;
			}
		}
		return false;
	}

	function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}

// Example
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>