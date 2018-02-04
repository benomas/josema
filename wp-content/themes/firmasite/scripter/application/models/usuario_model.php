<?php
if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
	public $instance;
	function __construct()
    {
        parent::__construct();
    }

	function get($id_usuario)
	{
		$query=	"	SELECT 	*
					FROM 	usuario
					WHERE 	id_usuario = '".$id_usuario."'
				";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getUsuarios()
	{
		$query=	"	SELECT 	*
					FROM 	usuario'
				";
		$result = $this->db->query($query);
		return $result->result_array();
	}


	function getCamposUsuarios($rol,$id_usuario)
	{
		switch ($this->rolName($rol)) {
			case "Vendedor":
				$WHERE =' AND usuario.id_vendedor ="'.$id_usuario.'"';
				break;
			case "Super Vendedor":
				$WHERE =' AND rol_usuario.nombre ="Cliente" AND usuario.activo="1"';
				break;
			
			default:
				$WHERE =' AND usuario.id_rol_usuario >="'.$rol.'"';
				break;
		}
		$query=	"	SELECT 	usuario.id_usuario,
							usuario.nombre,
							usuario.apellido_paterno,
							usuario.apellido_materno,
							usuario.nick,
							usuario.telefono,
							usuario.email,
							usuario.id_vendedor,
							rol_usuario.nombre AS rol,
							tipo_cliente.nombre AS tipo_negocio,
							CONCAT(usuario2.nombre,' ',usuario2.apellido_paterno,' ',usuario2.apellido_materno) AS vendedor,
							IF(	usuario.activo='1',
								'Si',
								'No'
								) AS activo
					FROM 	usuario AS usuario
					JOIN	rol_usuario AS rol_usuario ON rol_usuario.id_rol_usuario = usuario.id_rol_usuario
					LEFT JOIN	usuario AS usuario2 on usuario2.id_usuario=usuario.id_vendedor
					LEFT JOIN	tipo_cliente AS tipo_cliente ON tipo_cliente.id_tipo_cliente = usuario.id_tipo_cliente
					WHERE 1 ".$WHERE."
				";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getCamposUsuario($id_usuario)
	{
		$WHERE =' AND usuario.id_usuario ="'.$id_usuario.'"';
		$query=	"	SELECT 	usuario.id_usuario,
							usuario.nombre,
							usuario.apellido_paterno,
							usuario.apellido_materno,
							usuario.nick,
							usuario.telefono,
							usuario.email,
							rol_usuario.nombre AS rol,
							tipo_cliente.nombre AS tipo_negocio,
							IF(	usuario.activo='1',
								'Si',
								'No'
								) AS activo,
							usuario.id_rol_usuario,
							usuario.id_tipo_cliente,
							usuario.id_vendedor
					FROM 	usuario AS usuario
					JOIN	rol_usuario AS rol_usuario ON rol_usuario.id_rol_usuario = usuario.id_rol_usuario
					LEFT JOIN	tipo_cliente AS tipo_cliente ON tipo_cliente.id_tipo_cliente = usuario.id_tipo_cliente
					WHERE 1 ".$WHERE."
				";
		$result = $this->db->query($query);
		return $result->row();
	}

	function addUser()
	{
		$apellido_materno = $this->input->post('apellido_materno');
		$domicilio        = $this->input->post('domicilio');
		$rfc              = $this->input->post('rfc');
		$id_tipo_cliente  = $this->input->post('id_tipo_cliente');
		$id_vendedor      = $this->input->post('id_vendedor');
		$data = array	(
							'nombre'						=> $this->input->post('nombre'),
							'apellido_paterno'				=> $this->input->post('apellido_paterno'),
							'nick'							=> $this->input->post('nick'),
							'clave'							=> md5($this->input->post('clave')),
							'telefono'						=> $this->input->post('telefono'),
							'email'							=> $this->input->post('email'),
							'id_rol_usuario'				=> $this->input->post('id_rol'),
							'fecha_registro' 				=> date("Y-m-d H:i:s"),
							'ultima_conexion' 				=> date("Y-m-d H:i:s")
						);
		if(!empty($apellido_materno))
			$data['apellido_materno']=$apellido_materno;
		if(!empty($domicilio))
			$data['domicilio']=$domicilio;
		if(!empty($rfc))
			$data['rfc']=$rfc;
		if(!empty($id_tipo_cliente))
			$data['id_tipo_cliente']=$id_tipo_cliente;
		if(!empty($id_vendedor))
			$data['id_vendedor']=$id_vendedor;
		$inserted =  $this->db->insert('usuario', $data);
		return $inserted;
	}

	function editUser($id_user,$rol_editor)
	{
		$apellido_materno = $this->input->post('apellido_materno');
		$domicilio = $this->input->post('domicilio');
		$rfc = $this->input->post('rfc');
		$id_tipo_cliente = $this->input->post('id_tipo_cliente');
		$id_vendedor      = $this->input->post('id_vendedor');
		$data = array	(
							'nombre'						=> $this->input->post('nombre'),
							'apellido_paterno'				=> $this->input->post('apellido_paterno'),
							'nick'							=> $this->input->post('nick'),
							'telefono'						=> $this->input->post('telefono'),
							'email'							=> $this->input->post('email'),
							'id_rol_usuario'				=> $this->input->post('id_rol'),
							'fecha_registro' 				=> date("Y-m-d H:i:s"),
							'ultima_conexion' 				=> date("Y-m-d H:i:s")
						);
		if(!empty($apellido_materno))
			$data['apellido_materno']=$apellido_materno;
		if(!empty($domicilio))
			$data['domicilio']=$domicilio;
		if(!empty($rfc))
			$data['rfc']=$rfc;
		if(!empty($id_tipo_cliente))
			$data['id_tipo_cliente']=$id_tipo_cliente;
		$data['id_vendedor']=$id_vendedor?$id_vendedor:NULL;

		if($rol_editor==1)
		{
			$checkbox = $this->input->post('cambiar_clave');
			if(isset($checkbox))
			{
				if($checkbox==1)
				{
					$data['clave']=md5($this->input->post('clave'));
				}
			}
		}

		$this->db->where('id_usuario', $id_user);
		$updated = $this->db->update('usuario', $data);
		return $updated;
	}

	function get_roles_opcions_array($id_rol=0)
	{
		$opciones= array();
		$consulta = $this->db->query('SELECT id_rol_usuario, nombre FROM rol_usuario WHERE activo="1" AND id_rol_usuario >="'.$id_rol.'"');
		foreach ($consulta->result_array() as $fila)
		{
			$opciones += array($fila['id_rol_usuario']=>$fila['nombre']);

		}
		$opciones += array('-'=>'----');
		return $opciones;;
	}

	function clientTypes()
	{
		return $this->db->query('SELECT id_tipo_cliente, nombre FROM tipo_cliente WHERE activo="1"');
	}

	function clients($id_vendedor=null)
	{
		if($id_vendedor)
			return $this->db->query('
				SELECT 	u.id_usuario AS keyColumn, CONCAT( u.nombre," ", u.apellido_paterno," ", u.apellido_materno) AS valueColumn 
				FROM 	usuario AS u
				JOIN	rol_usuario AS ru ON ru.id_rol_usuario=u.id_rol_usuario AND ru.nombre="Cliente"
				WHERE 	u.activo="1" AND u.id_vendedor="{$id_vendedor}" 
			');
		
		return $this->db->query('
			SELECT 	u.id_usuario AS keyColumn, CONCAT( u.nombre," ", u.apellido_paterno," ", u.apellido_materno) AS valueColumn 
			FROM 	usuario
			JOIN	rol_usuario AS ru ON ru.id_rol_usuario=u.id_rol_usuario AND ru.nombre="Cliente"
			WHERE 	u.activo="1"
		');
	}

	function vendors()
	{
		return $this->db->query('
			SELECT 	u.id_usuario AS keyColumn, CONCAT( u.nombre," ", u.apellido_paterno," ", u.apellido_materno) AS valueColumn 
			FROM 	usuario AS u
			JOIN	rol_usuario AS ru ON ru.id_rol_usuario=u.id_rol_usuario AND ru.nombre="Vendedor"
			WHERE 	u.activo="1"
		');
	}

	function vendor($id_vendedor=null)
	{
		if(!$id_vendedor)
			return false;
		return $this->db->query('
			SELECT 	u.*
			FROM 	usuario AS u
			JOIN	rol_usuario AS ru ON ru.id_rol_usuario=u.id_rol_usuario AND ru.nombre="Vendedor"
			WHERE 	u.activo="1"  AND u.id_usuario='.$id_vendedor.'
		');
	}

	function deactivateUser($id_usuario)
	{
		$data = array	(
							'activo'						=> '0'
						);

		$this->db->where('id_usuario',$id_usuario);
		return $this->db->update('usuario', $data);
	}

	function activateUser($id_usuario)
	{
		$data = array	(
							'activo'						=> '1'
						);

		$this->db->where('id_usuario',$id_usuario);
		return $this->db->update('usuario', $data);
	}

	function deleteUser($id_usuario)
	{
		return $this->db->delete('usuario', array('id_usuario' => $id_usuario));
	}
	
	public function rolName($rol){
		if($rol && ($currentRole = $this->db->query("SELECT nombre FROM rol_usuario WHERE id_rol_usuario={$rol}")->row()))
			return $currentRole->nombre;
		return "";
	}
}
?>