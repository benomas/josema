<?php
class Seguridad extends CI_Controller
{
	// Used for registering and changing password form validation
	var $min_username = 4;
	var $max_username = 100;
	var $min_password = 4;
	var $max_password = 20;
	var $homepage = ''; //'/admin/dashboard';
	var $homepage_user = '/inicio';
	var $login_view = '/seguridad/login';
	var $logged_in_view = '/seguridad/loged';
	var $forgot_password_view = '/seguridad/forgot';
	var $forgot_password_success_view = '/seguridad/forgot_success';
	

	function __construct()
	{
		parent::__construct();
		$this->load->library('Form_validation');
		$this->load->library('centinela');			
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->homepage=word_pres_url();
		$this->load->model('Usuario_model');
		$this->load->library('carro');
	}
	
	function index()
	{
		$this->login();
	}
	
	function login()
	{
		if(! $this->centinela->is_logged_in() ) //Si esta activa la seguridad, pide acceso
		{
			$val = $this->form_validation;
			// Set form validation rules
			$val->set_rules('username', 'Usuario', 'trim|required|xss_clean');
			$val->set_rules('password', 'Contraseña', 'trim|required|xss_clean');
			$val->set_error_delimiters('<div class="error">', '</div>');
			//if ($val->run() AND $this->centinela->login( $val->set_value('username'), $val->set_value('password')) )
			if ( $val->run() )
			{
				if( $this->loginLocal($val->set_value('username'), $val->set_value('password')) ){
					$carrito = $this->Usuario_model->getCar($this->centinela->get("id_usuario"));
					$this->carro->setProducts($carrito);
					$this->_redirect_to_homepage();
				}
				else
					$this->_redirect_to_homepage();
			} else
				 $this->pantallaLogin($this->centinela->get_error());	
		}
		else
		{
			// Redirect to homepage
			$this->_redirect_to_homepage();
		}
	}
	
	function loginLocal($user, $password)
	{
		return $this->centinela->login( $user, $password);	
	}
	
	
	function pantallaLogin( $mensaje=NULL )
	{
		$data["errores"] = $mensaje;
		if($this->input->is_ajax_request() ) 
			echo $this->load->view('seguridad/loginForm' , $data  ); 
		else 
			$this->load->view( 'seguridad/loginForm' , $data , TRUE);
		/*$data["errores"] = $mensaje;
		$this->load->view(  'seguridad/loginForm' , $data );
		*/
		//redirect('../../?page_id=133','location');
		/*
		$data["errores"] = $mensaje;
		
		if($mensaje)
			$this->load->view(  'cabecera_admin' , $data );
		else
			$this->load->view(  'cabecera_admin' , NULL );
		$folio = $this->input->post('folio');
		$data['folio'] = empty($folio)? '': $folio;
		$this->load->view(  $this->login_view, $data, FALSE);
		//$this->load->view(  'pie_view'  );
		*/
	}
	
	function loadLoginForm()
	{
		
	}
	
	function logout()
	{
		$this->carro->reset();
		$this->centinela->logout();
		$this->_redirect_to_homepage();
		/*redirect( $this->login_view   ,'location');*/
	}

	
	function _redirect_to_homepage()
	{
		$this->homepage = word_pres_url();
		switch ( $this->centinela->get('rol') )
		{
			case 1: //SuperAdmin
			case 2: //admin
					if($this->input->is_ajax_request() )
						echo 'correcto';
					else
						redirect($this->homepage, 'location');
					break;
			default: if($this->input->is_ajax_request() )
						echo 'correcto';
					else
						redirect($this->homepage, 'location');
					break;
		}
		
	}
	
	//Recordar password con email
	function forgot_password()
	{
		$val = $this->form_validation;
		
		// Set form validation rules
		$val->set_rules('login', 'Correo', 'trim|required|xss_clean|callback_revisaEstatus');
		$val->set_error_delimiters('<div class="error">', '</div>');
		
		// Validate rules and call forgot password function
		if( $val->run() AND $this->centinela->forgot_password($val->set_value('login')) )
		{
			//'An email has been sent to your email with instructions with how to activate your new password.';
			$d['title'] = lang('titulo');
			$d['breadcrumb'] = 'Módulo de Administración > Recuperar password';
			$d['menu_sel']	= 'acceso';
			$this->load->view(  'cabecera' ,$d );
			$data['auth_message'] = '<p class="ok">
			Un e-mail ha sido enviado a tu cuenta, con las instrucciones de como cambiar la contraseña.</p>';
			$this->load->view($this->forgot_password_success_view, $data);
			$this->load->view(  'pie' ,$d );
		}
		else
		{
			// Redirect to banned uri
			$d['title'] = lang('titulo');
			$d['breadcrumb'] = 'Módulo de Administración > Recuperar contraseña';
			$d['menu_sel']	= 'acceso';
			$this->load->view(  'cabecera' ,$d );
			$this->load->view($this->forgot_password_view);
			$this->load->view(  'pie' ,$d );
		}
	}

	
	function reset_password($code)
	{
		$row = $this->seguridad_model->get_by_code($code);
		if($row!=FALSE)
		{
			$this->centinela->confirmar_cambio($row);	
			$data['auth_message'] = '<p class="ok">
				Un e-mail ha sido enviado a tu cuenta, con la contraseña nueva. 
				Te recomendamos ingresar y cambiarla por una más facil para recordar.
			</p>';
			
		}
		else
		{
			$data['auth_message'] = '<p class="error">Código invalido. <br />Ir Recuperar contraseña.</p>';
		}
		
		
		$d['title'] = lang('titulo');
		$d['breadcrumb'] = 'Módulo de Administración > Recuperar password';
		$d['menu_sel']	= 'acceso';
		$this->load->view(  'cabecera' ,$d );
		$this->load->view($this->forgot_password_success_view, $data);
		$this->load->view(  'pie' ,$d );
		
	}
	
	
	//Callback para formvalidation
	function revisaEstatus($correo)
	{
		$id_proveedor = $this->seguridad_model->get_id_by_email($correo);
		if($id_proveedor == FALSE)
		{
			$this->form_validation->set_message('revisaEstatus', ' Su cuenta ha sido inhabilitada. ' );
			return FALSE;
		}

		$this->load->model('proveedores_model');
		$estatus = $this->proveedores_model->get_estatus_by_id($id_proveedor);
		if( $estatus != 'Habilitado')
		{
			if($estatus == 'Revisión' )
				$this->form_validation->set_message('revisaEstatus', ' Los datos de su registro estan en <b>'.$estatus.'</b>. Debera esperar a que sean confirmados y se le enviaran sus datos de acceso.' );
			else
				$this->form_validation->set_message('revisaEstatus', ' Su cuenta ha sido inhabilitada. ' );
			return FALSE;
		}
		return TRUE;
	}

	
	/*Funciones no depuradas*/	
	
	function register()
	{		
		if ( ! $this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration)
		{	
			$val = $this->form_validation;
			
			// Set form validation rules			
			$val->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->min_username.']|max_length['.$this->max_username.']|callback_username_check|alpha_dash');
			$val->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_password]');
			$val->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
			$val->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');
			
			if ($this->dx_auth->captcha_registration)
			{
				$val->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback_captcha_check');
			}

			// Run form validation and register user if it's pass the validation
			if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email')))
			{	
				// Set success message accordingly
				if ($this->dx_auth->email_activation)
				{
					$data['auth_message'] = 'You have successfully registered. Check your email address to activate your account.';
				}
				else
				{					
					$data['auth_message'] = 'You have successfully registered. '.anchor(site_url($this->dx_auth->login_uri), 'Login');
				}
				
				// Load registration success page
				$this->load->view($this->dx_auth->register_success_view, $data);
			}
			else
			{
				// Is registration using captcha
				if ($this->dx_auth->captcha_registration)
				{
					$this->dx_auth->captcha();										
				}

				// Load registration page
				$this->load->view($this->dx_auth->register_view);
			}
		}
		elseif ( ! $this->dx_auth->allow_registration)
		{
			$data['auth_message'] = 'Registration has been disabled.';
			$this->load->view($this->dx_auth->register_disabled_view, $data);
		}
		else
		{
			$data['auth_message'] = 'You have to logout first, before registering.';
			$this->load->view($this->dx_auth->logged_in_view, $data);
		}
	}
	
	
	function activate()
	{
		// Get username and key
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);

		// Activate user
		if ($this->dx_auth->activate($username, $key)) 
		{
			$data['auth_message'] = 'Your account have been successfully activated. '.anchor(site_url($this->dx_auth->login_uri), 'Login');
			$this->load->view($this->dx_auth->activate_success_view, $data);
		}
		else
		{
			$data['auth_message'] = 'The activation code you entered was incorrect. Please check your email again.';
			$this->load->view($this->dx_auth->activate_failed_view, $data);
		}
	}
	

	function change_password()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation
			$val->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']');
			$val->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_new_password]');
			$val->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean');
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password')))
			{
				$data['auth_message'] = 'Your password has successfully been changed.';
				$this->load->view($this->dx_auth->change_password_success_view, $data);
			}
			else
			{
				$this->load->view($this->dx_auth->change_password_view);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}	
	
	function cancel_account()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_rules('password', 'Password', "trim|required|xss_clean");
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->cancel_account($val->set_value('password')))
			{
				// Redirect to homepage
				redirect('', 'location');
			}
			else
			{
				$this->load->view($this->dx_auth->cancel_account_view);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}

	
}
?>
