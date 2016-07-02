<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GridManajer extends CI_Controller 
{

	public function __construct()
   {
		parent::__construct();
		$this->load->model('Catalogos_model');
		$this->load->library('interdata');
		if ( $this->is_session_started() === FALSE ) 
			session_start();
   }
   
	public function index()
	{
	}
	
	public function load_cat_Injektion($output = null)
	{
	}
	
	public function cat_injektion($grid_searsh=NULL)
	{	
		$data['collections']=$this->Catalogos_model->cat_injektion();
		$data['aliasCollection']=	array	(	"CODIGO INJEKTION",
												"REF 1",
												"REF 2",
												"REF 3",
												"MARCA",
												"DESCRIPCION",
												"PRECIO INJEKTION 1",
												"PRECIO INJEKTION 2",
												"PRECIO INJEKTION 3"
											);
		$data['logicalStructure']= array	(	
												"beforBoxLogicalContainer"				=>array(	"open"		=>"",
																									"close"		=>""
																								),
												"boxLogicalContainer"					=>array(	"open"		=>"",
																									"close"		=>""
																								),
												"aliasCollectionLogicalContainer"		=>array(	"open"		=>"<tr class=\"success\">",
																									"close"		=>"</tr>"
																								),
												"aliasUnitLogicalContainer"				=>array(	"open"		=>"<td><b>",
																									"close"		=>"</b></td>"
																								),
												"bodyLogicalContainer"					=>array(	"open"		=>"<table class=\"table table-bordered table-striped table-responsive table-hover\">
																														<tr >
																															<td colspan=\"12\">
																																<b>Busqueda simple: <label style=\"color:#772953;\" >".$this->input->post('grid_searsh')."</label></b>
																															</td>
																														</tr>",
																									"close"		=>"</table>"
																								),
												"dataCollectionLogicalContainer"		=>array(	"open"		=>"<tr>",
																									"close"		=>"</tr>"
																								),
												"dataUnitLogicalContainer"				=>array(	"open"		=>"<td>",
																									"close"		=>"</td>"
																								),
												"afterBoxLogicalContainer"				=>array(	"open"		=>"",
																									"close"		=>""
																								)
											);
		$prueba= new Interdata($data);
		$data['dataUniverse'] = str_ireplace( $this->input->post('grid_searsh') , '<label style="color:#772953;" >'.$this->input->post('grid_searsh').'</label>' , $prueba->ensambleStructure() );
		$this->load->view('catalogos/cat_Injektion.php',$data);
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