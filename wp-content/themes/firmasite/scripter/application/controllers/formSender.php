<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FormSender extends CI_Controller 
{

	public function __construct()
   {
		parent::__construct();
		$this->load->model('Catalogos_model');
		$this->load->model('Inventario_model');
		
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
		$data['filasDefault']='1';
		$data['numeroFilas']='1';
		$data[]=array();
		$data['userData']=$this->Catalogos_model->getUserData($this->centinela->get('id_usuario'));
		$data['traerCarrito']=$traerCarrito;
		/*if($traerCarrito)
		{*/
			$productos= $this->carro->getProductos();
			if(!empty($productos))
			{
				foreach($productos AS $producto)
				{
					$data['productos'][]=$this->Inventario_model->getProduct($producto);
				}
			}
			if(!empty($productos))
			{
				$data['numeroFilas']=sizeof($productos);
				$this->load->view('formTemplates/pedidoForm',$data);
			}	
			else
				echo '	<div class="contenedor_info">
							<label class="concepto_field" style="font-size:16px;">Debes añadir productos al carrito</label>
						</div>'; 
		
	}
	
	
	public function sendPedido()
	{	
		if(!$this->almenosUna($_POST['numeroFilas']))
		{		
			echo '	<div class="contenedor_info">
						<label class="concepto_field" style="font-size:16px;">Debes indicar almenos una cantidad</label>
					</div>';
			return false;
		}
		$data['info']=$_POST;
		if($data['info']['numeroFilas']>0 && $data['info']['numeroFilas'] < 100)
		for($i=1;$i<=$data['info']['numeroFilas'];$i++)
		{
			if(isset($data['info']['Cantidad'.$i]))
			{
				if($data['info']['Cantidad'.$i]>0)
				{
					$data['info']['row'.$i]=$this->Inventario_model->getProductByNpc($data['info']['NPC'.$i]);
				}
			}
		}
		$data['userData']=$this->Catalogos_model->getUserData($this->centinela->get('id_usuario'));
		$nombre= $data['userData']->nombre.' '.$data['userData']->apellido_paterno.' '.$data['userData']->apellido_materno;
		if(empty($nombre))
			$nombre=$data['userData']->nick;
		$data['nombreUsuario']=	$nombre;
		$data['id_usuario']=$this->centinela->get('id_usuario');
		$mensaje= $this->load->view('correoTemplates/body',$data,true);
		$list=array();
		$list[]='pedidos_josema@hotmail.com';
		$list[]=$data['userData']->email;
		$this->email->from('josema@systamashii.com', 'JOSEMA');
		$this->email->to($list);
		$this->email->reply_to('', 'Este correo a sido generado electronicamente, no responda a este correo');
		$this->email->subject('Pedido electronico JOSEMA');
		$this->email->message($mensaje);
		//$this->email->send();
		if($this->email->send())
		{
			echo '	<div class="contenedor_info">
						<label class="concepto_field" style="font-size:16px;">Pedido enviado</label>
					</div>'; 
			$list=array();
			$array_list=$this->Catalogos_model->getAdminMails();
			foreach($array_list AS $element)
			{
				$list[]=$element['email'];
			}
			$list[]=$data['userData']->email;
			$this->email->from('josema@systamashii.com', 'JOSEMA');
			$this->email->to($list);
			$this->email->reply_to('', 'Este correo a sido generado electronicamente, no responda a este correo');
			$this->email->subject('Pedido electronico JOSEMA');
			$this->email->message($mensaje);
			$this->email->send();
			$this->carro->reset();
		}
		
		
		
	}
	
	function almenosUna($numeroProductos=0)
	{	
		for($i=1;$i<=$numeroProductos;$i++)
		{
			if(isset($_POST['Cantidad'.$i]))
			{
				$cantidad=$_POST['Cantidad'.$i];
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