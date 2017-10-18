<?php
if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
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


	function getCamposUsuarios($rol)
	{
		$WHERE =' AND usuario.id_rol_usuario >="'.$rol.'"';
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
								) AS activo
					FROM 	usuario AS usuario
					JOIN	rol_usuario AS rol_usuario ON rol_usuario.id_rol_usuario = usuario.id_rol_usuario
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
							usuario.id_tipo_cliente
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
		$domicilio = $this->input->post('domicilio');
		$rfc = $this->input->post('rfc');
		$id_tipo_cliente = $this->input->post('id_tipo_cliente');
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
		$inserted =  $this->db->insert('usuario', $data);
		return $inserted;
	}

	function editUser($id_user,$rol_editor)
	{
		$apellido_materno = $this->input->post('apellido_materno');
		$domicilio = $this->input->post('domicilio');
		$rfc = $this->input->post('rfc');
		$id_tipo_cliente = $this->input->post('id_tipo_cliente');
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

	function get_tipos_cliente_opcions_array()
	{
		$opciones= array();
		$consulta = $this->db->query('SELECT id_tipo_cliente, nombre FROM tipo_cliente WHERE activo="1"');
		foreach ($consulta->result_array() as $fila)
		{
			$opciones += array($fila['id_tipo_cliente']=>$fila['nombre']);

		}
		$opciones += array('-'=>'----');
		return $opciones;;
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
}
?>