<?php

/**
 * @author Beny
 * @copyright 2014
 */

class Seguridad_model extends CI_Model {
		var $ci; 

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->ci =& get_instance();
    }
	
	function is_banned($id)
	{
		$query = $this->db->get_where( 'usuario' , array('id_usuario' => $id) );
		return  $query->row()->activo;
	}
	
	function log($user,$pass)
	{
		$query = $this->db->get_where( 'usuario', array( 'nick' => $user , 'clave' => $pass )  );
		return $query;
	}
    
    function getUsuario($id){
		$query = $this->db->query("SELECT *	FROM usuario WHERE id = ? " , array( $id ));
		return $query->row();
	}
	
	function get_by_nick($nick){
		$query = $this->db->query("SELECT *	FROM usuario WHERE nick = ? " , array( $nick));
		return $query;
	}
	
	function get_id_by_email($email)
	{
		$this->db->select('id_usuario');
		$this->db->from('usuario');
		$this->db->where('email',$email);
		$query = $this->db->get();
		if($query->num_rows() == 1)
			return $query->row()->id;
		return false;
	}
	
	function get_by_rol($id_rol_usuario)
	{
		$this->db->select('*');
		$this->db->from('usuario');
		$this->db->where('id_rol_usuario',$id_rol_usuario);
		return $this->db->get();
	}
	
	function get_by_code($code)
	{
		$this->db->select('*');
		$this->db->from('usuario');
		$this->db->where('codigo_confirmacion',$code);
		$query = $this->db->get();
		if($query->num_rows() == 1)
			return $query->row();
		return false;
	}
	
	function getAll($init,$offset)
	{
		$query = $this->db->query('SELECT * FROM usuario  LIMIT '.$init.' , '.$offset);
		return $query;
	}
    
	function insert_registro_proveedor()
	{
		$data = array(
		'id_rol_usuario' => 5,
		'idEstado' => $this->input->post('estado'), //aqui no le tomamos importancia
		'nombre' =>  $this->input->post('nombre'),
		'nick' =>  strtoupper($this->input->post('rfc')) ,
		'clave' =>  md5( rand() ),	//temporal
		'email' =>  $this->input->post('correo') ,
		'activo' =>  0,	//por primeravez no es activo.
		'created' =>  date('Y-m-d H:i:s'),
		'modified' =>  date('Y-m-d H:i:s'),
		'lastlogin' =>  date('Y-m-d H:i:s'),
		'lastip' =>  $this->ci->input->ip_address()
		);
		if(	$this->db->insert('usuario', $data) )
			return $this->db->insert_id();
		return 0;
	}
	
    function insert_registro_admon()
    {
		$data = array(
		'id_usuario'=> 0 ,
		'nombre' =>  $this->input->post('nombre'),
		'nick' =>  $this->input->post('nick') ,
		'clave' =>  md5($this->input->post('clave') ),
		'email' =>  $this->input->post('email') ,
		'activo' =>   $this->input->post('activo') ? 1 : 0,
		'created' =>  date('Y-m-d H:i:s'),
		'modified' =>  date('Y-m-d H:i:s'),
		'lastlogin' =>  date('Y-m-d H:i:s'),
		'lastip' =>  $this->ci->input->ip_address()
		);
		return  $this->db->insert('usuario', $data);
	}
	
	
	//Actualiza datos usuario
	function update_entry($id, $data){
		$this->db->where('id_usuario', $id);
		return $this->db->update('usuario', $data); 
	}
	
	function update_pass($id, $new_pass)
	{
		$data = array( 'clave' => $new_pass );
		$this->db->where('id_usuario', $id);
		return $this->db->update('usuario', $data); 
	}
	
	function update_last($id)
	{
		$data = array(
			'modified' =>  date('Y-m-d H:i:s'),
			'lastip' =>  $this->ci->input->ip_address()
		);
		$this->db->where('id_usuario', $id);
		return  $this->db->update('usuario', $data);
	}
  
	function update_codigo_confirmacion($mail,$codigo_confirmacion)
	{
		$data = array(
			'codigo_confirmacion' => $codigo_confirmacion,
			'modified' =>  date('Y-m-d H:i:s'),
			'lastip' =>  $this->ci->input->ip_address()
		);
		$this->db->where('email', $mail);
		return  $this->db->update('usuario', $data);
	}
	
	function update_c_c_reset($id)
	{
		return $this->db->query('UPDATE usuario SET codigo_confirmacion = NULL WHERE id = 52 LIMIT 1;');
	}
	
	
    function delete($id)
    {
		$this->db->where('id_usuario',$id );
		$this->db->delete('usuario');
	}

	//Regresa -1 si no existe Usuario, 0 si el password es incorrecto. 
	//	1 si ingresa correctamente
	//Registra la session.
	function login()
	{
		$nick = $this->input->post('nick');
		$password = md5($this->input->post('password'));
		
		if( $this->nickExist($nick))
		{
			$query = $this->db->query("SELECT * FROM usuario WHERE nick LIKE ? AND clave LIKE ? ",	array($nick ,$password) );
			if($query->num_rows()>0)
			{
				//Existe Usuario y Password 
				// REGISTRAMOS SESSION
				$this->phpsession->save('logged',true);
				$this->phpsession->save('usuario',$nick);
				$this->phpsession->save('rol',$query->row()->nivel);
				$this->phpsession->save('email',$query->row()->mail);
				return 1;
			}else
				return 0; //Password incorrecto
		}
		else
			return -1; //No existe usuario
	}
	

	
	
	//Return 1 if exist / 0 if not exist
	function nickExist($nick)
    {	
		$sql = "SELECT nick FROM usuario WHERE nick LIKE ?";
		$result = $this->db->query($sql, array( $nick ));
		if($result->num_rows() == 0)
			return 0;
		return 1;
	}
	
	function mailExist($mail){
		$sql = "SELECT mail FROM usuario WHERE mail LIKE ?";
		$result = $this->db->query($sql, array( $mail));
		if($result->num_rows() == 0)
			return 0;
		return 1;
	}
}
?>