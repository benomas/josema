<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller 
{
	public function __construct()
   {
		parent::__construct();
		$this->load->model('Catalogos_model');

		$this->load->model('Inventario_model');
		$this->load->library('interdata');
		
   }
   
	public function index()
	{
		session_start(); 
		echo 'Test'; die();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */