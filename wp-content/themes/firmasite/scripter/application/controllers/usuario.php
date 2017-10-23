<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include "baseController.php";

class Usuario extends baseController
{

	public function __construct()
   {
		parent::__construct();
		$this->load->model('Usuario_model');

		$this->load->library('phpsession');
		$this->load->library('centinela');
		if(! $this->centinela->is_logged_in() ) {
			redirect('/seguridad/login','location');
		}
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

	public function loadGridUser()
	{
		$headers= array(	"Id",
							"Nombre",
							"Apellido paterno",
							"Apellido materno",
							"Nick",
							"Telefono",
							"Email",
							"Rol usuario",
							"Tipo cliente",
							"Vendedor",
							"Activo"
						);
		$data['headers']=$headers;
		$data['usuarios']=$this->Usuario_model->getCamposUsuarios($this->centinela->get('rol'),$this->centinela->get('id_usuario'));
		$data['rolName']=$this->Usuario_model->rolName($this->centinela->get('rol'));
		$this->load->view('usuarioTemplates/usuarioGrid',$data);
	}

	function deactivateUser($id_usuario)
	{
		$this->tiene_permiso();
		$r=$this->Usuario_model->deactivateUser($id_usuario);
		$this->loadGridUser();
	}

	function activateUser($id_usuario)
	{
		$this->tiene_permiso();
		$r=$this->Usuario_model->activateUser($id_usuario);
		$this->loadGridUser();
	}

	function deleteUser($id_usuario)
	{
		$this->tiene_permiso();
		$r=$this->Usuario_model->deleteUser($id_usuario);
		$this->loadGridUser();
	}

	function addUser()
	{
		$this->tiene_permiso();
		$data['roles']=$this->Usuario_model->get_roles_opcions_array($this->centinela->get('rol'));
		$data['tipos_clientes']=$this->clientTypeSelect();
		$this->load->view('usuarioTemplates/addUser',$data);
	}

	function updateUser($id_usuario)
	{
		$this->tiene_permiso();
		$data['roles']=$this->Usuario_model->get_roles_opcions_array($this->centinela->get('rol'));
		$data['tipos_clientes']=$this->clientTypeSelect();
		$data['usuario']=$this->Usuario_model->getCamposUsuario($id_usuario);
		$data['rol_editor']=$this->centinela->get('rol');
		$this->load->view('usuarioTemplates/updateUser',$data);
	}

	function clients(){

	}

	function saveUser()
	{
		$this->tiene_permiso();
		$error_validacion= false;
		$id_usuario=$this->input->post('id_usuario');
		$checkbox = $this->input->post('cambiar_clave');
		if(!empty($id_usuario))
		{
			$this->form_validation->set_rules('id_usuario');
			if( $this->centinela->get('rol') ==1)
			{
				if(isset($checkbox))
				{
					if($checkbox==1)
					{
						$this->form_validation->set_rules('clave', 'Clave', 'required');
					}
				}
			}
		}
		else
			$this->form_validation->set_rules('clave', 'Clave', 'required');

		$this->form_validation->set_rules('email', 'Correo electronico', 'trim|required|valid_email');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellido_paterno', 'Apellido paterno', 'required');
		$this->form_validation->set_rules('apellido_materno');
		$this->form_validation->set_rules('nick', 'Nick', 'required');

		$this->form_validation->set_rules('domicilio');
		$this->form_validation->set_rules('telefono', 'Telefono', 'required');
		$this->form_validation->set_rules('rfc');
		$this->form_validation->set_rules('email', 'Correo electronico', 'trim|required|valid_email');
		$this->form_validation->set_rules('id_rol', 'Rol', 'trim|required|valid_select');
		$this->form_validation->set_rules('id_tipo_cliente');
		$this->form_validation->set_rules('id_vendedor');

		$this->form_validation->set_rules('cambiar_clave');

		$this->form_validation->set_error_delimiters('<tr class="danger"><td colspan="2">', '</td></tr>');

		if ($this->form_validation->run() == FALSE)
		{
			$error_validacion = true;
			if($this->input->is_ajax_request() )
			{
				$data['roles']=$this->Usuario_model->get_roles_opcions_array($this->centinela->get('rol'));
				$data['tipos_clientes']=$this->clientTypeSelect();
				if(!empty($id_usuario))
				{
					$data['usuario']=$this->Usuario_model->getCamposUsuario($id_usuario);
					$data['rol_editor']=$this->centinela->get('rol');
					$this->load->view('usuarioTemplates/updateUser',$data);
				}
				else
					$this->load->view('usuarioTemplates/addUser',$data);
			}
			else
			{
				 if(!empty($id_usuario))
				{
					$data['usuario']=$this->Usuario_model->getCamposUsuario($id_usuario);
					$data['rol_editor']=$this->centinela->get('rol');
					$this->load->view('usuarioTemplates/updateUser',$data,TRUE);
				}
				else
					$this->load->view('usuarioTemplates/addUser',$data,TRUE);
			}
		}
		else
		{
			if(!empty($id_usuario))
				$r = $this->Usuario_model->editUser($id_usuario,$this->centinela->get('rol'));
			else
				$r = $this->Usuario_model->addUser();
			if ($r)
			{
				$this->loadGridUser();
			}
			else
			{
				echo "<div align='center'><img src='" . base_url('images/alert.png') . "' /></div>";
			}

		}

	}

	public function getTest()
	{

		$data['info']=$_POST;

		$userData=$this->Catalogos_model->getUserFirstName($_SESSION['wp_user_info']);
		$userData+=$this->Catalogos_model->getUserLastName($_SESSION['wp_user_info']);
		$userData+=$this->Catalogos_model->getUserNick($_SESSION['wp_user_info']);

		//print_r($userData);die();
		$data['userData']=$userData;
		$data['nombreUsuario']=$userData['firtsName'].' '.$userData['last_name'];
		$temp=$userData['firtsName'].$userData['last_name'];
		if(empty( $temp) )
			$data['nombreUsuario']= $userData['nickname'];

		$data['id_usuario']=$_SESSION['wp_user_info'];
		$mensaje= $this->load->view('correoTemplates/body',$data,true);
		//print_r($mensaje);die();
		$list = array('orlando_m28@yahoo.com.mx','benymeves@hotmail.com');

		//$this->email->initialize($config);
		$this->email->from('josema@systamashii.com', 'JOSEMA');
		$this->email->to($list);
		$this->email->reply_to('benymeves@hotmail.com', 'codeigniter local..');
		$this->email->subject('Pedido electronico JOSEMA');
		$this->email->message($mensaje);

		//$this->email->send();
		if($this->email->send())
			echo 'Pedido registrado';


		/*$list = 'orlando_m28@yahoo.com.mx,benymeves@hotmail.com';
		$cabeceras = '	From: orlando_m28@yahoo.com.mx' . "\r\n" .
						'Reply-To: benymeves@hotmail.com' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
		if(mail($list,'Pedido electronico JOSEMA',$mensaje,$cabeceras))
			echo 'Pedido registrado';
		*/
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

	function tiene_permiso()
	{
		return true;
		redirect('/usuario/loadGridUser','location');
	}

	public function clientTypeSelect(){
		return $this->selectData($this->Usuario_model->clientTypes(),"id_tipo_cliente","nombre");
	}

	public function ajaxClientTypeSelect(){
		echo $this->jsonOptions($this->Usuario_model->clientTypes(),"id_tipo_cliente","nombre");
	}

	public function ajaxClientSelect($vendedor_id=null){
		echo $this->jsonOptions($this->Usuario_model->clients($vendedor_id));
	}

	public function ajaxVendorSelect(){
		echo $this->jsonOptions($this->Usuario_model->vendors());
	}
// Example
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>