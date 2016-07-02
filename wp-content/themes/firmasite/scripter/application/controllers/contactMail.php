<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContactMail extends CI_Controller 
{

	public function __construct()
   {
		parent::__construct();
		$this->load->helper("form");
		$this->load->model('Catalogos_model');
		$this->load->model('Inventario_model');
		
		$this->load->library('phpsession');
		$this->load->library('centinela');
		$this->load->library('carro');
		$this->load->library('controlform');
   }
   
	public function index()
	{
	}
	
	public function loadContactForm()
	{	
		$this->controlform->generarCaptcha('contact-form');
		if($this->input->is_ajax_request() ) 
			echo ( $this->load->view('formTemplates/contactForm', NULL,TRUE));
		else 
			$this->load->view('formTemplates/contactForm', NULL,$data);
		
	}
	
	function printCaptcha()
	{
		if($this->input->is_ajax_request() ) 
			echo '<div class="table" >666</div>';
		else
			echo '<div class="table" >'.$this->controlform->consumirCaptcha('contact-form').'</div>';
	}
	
	public function sendContactForm()
	{	
		
		$this->form_validation->set_rules('nombre','Nombre','trim|required');
		$this->form_validation->set_rules('telefono','Telefono','trim|required');
		$this->form_validation->set_rules('correo','Correo','trim|required|valid_email');
		$this->form_validation->set_rules('asunto','Asunto','trim|required');
		$this->form_validation->set_rules('captcha','Captcha','trim|required|callback_validaCaptcha');
		$this->form_validation->set_error_delimiters('<div class="error_form" >', '</div>');
		if ($this->form_validation->run() == FALSE)
		{
			$this->loadContactForm();
		}
		else
		{
			$data['nombre']=$this->input->post('nombre');
			$data['telefono']=$this->input->post('telefono');
			$data['correo']=$this->input->post('correo');
			$data['asunto']=$this->input->post('asunto');
			$this->controlform->destruirCaptcha('contact-form');
			
			$mensaje= $this->load->view('correoTemplates/contacto',$data,true);
			$list=array();
			$list[]='ventas_josema@hotmail.com';
			$this->email->from('josema@systamashii.com', 'JOSEMA');
			$this->email->to($list);
			$this->email->reply_to($data['correo'], 'Solicitud de contacto enviada desde Sistema JOSEMA');
			$this->email->subject('Solicitud de contacto JOSEMA');
			$this->email->message($mensaje);
			if($this->email->send())
			{
				echo '	<div class="contenedor_info">
							<label class="concepto_field" style="font-size:16px;">Solicitud de contacto enviada</label>
						</div>'; 
				$list=array();
				$array_list=$this->Catalogos_model->getAdminMails();
				foreach($array_list AS $element)
				{
					$list[]=$element['email'];
				}
				$this->email->from('josema@systamashii.com', 'JOSEMA');
				$this->email->to($list);
				$this->email->reply_to($data['correo'], 'Este correo a sido generado electronicamente, no responda a este correo');
				$this->email->subject('Solicitud de contacto JOSEMA');
				$this->email->message($mensaje);
				$this->email->send();
				$this->carro->reset();
			}
		}
		
	}
	
	
	function validaCaptcha($str)
	{		
		if($this->controlform->matchCaptcha('contact-form'))
			return TRUE;
		$this->form_validation->set_message('validaCaptcha', 'El <strong>%s</strong> es incorrecto');
		return FALSE;
	}
	
}
?>