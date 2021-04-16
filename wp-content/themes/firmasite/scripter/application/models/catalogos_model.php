<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');
	
class Catalogos_model extends CI_Model 
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getUserData($user_id)
	{
		$query = $this->db->query	(	"	SELECT	
													u.id_usuario,
													u.nombre,
													u.apellido_paterno,
													u.apellido_materno,
													u.nick,
													u.domicilio,
													u.telefono,
													u.rfc,
													u.email,
													u.fecha_registro,
													u.ultima_conexion,
													u.ultima_ip,
													u.id_rol_usuario,
													u.id_tipo_cliente,
													u.id_vendedor,
													u.activo,
													u.suspended,
													u.carrito,
													tc.nombre AS tipo_cliente,
													ru.nombre AS rol
											FROM	usuario AS u
											LEFT JOIN	tipo_cliente AS tc ON tc.id_tipo_cliente = u.id_tipo_cliente
											LEFT JOIN	rol_usuario AS ru ON ru.id_rol_usuario = u.id_rol_usuario
											WHERE 	u.id_usuario = '".$user_id."'
										"
									);
		return $query->row();
	}
	
	function getAdminMails()
	{
		$query=	"	SELECT	email
					FROM	usuario
					WHERE	id_rol_usuario IN('1','2') AND
							NOT ISNULL(email)
				";
		return $this->db->query($query)->result_array();
	}
	
	function getUserFirstName($user_id)
	{
		$query = $this->db->query("	SELECT meta_value AS firtsName
									FROM wp_usermeta
									WHERE user_id = '".$user_id."' AND meta_key='first_name'
									");
		$temp=	$query->result_array();
		return $temp[0];
	}
	
	function getUserLastName($user_id)
	{
		$query = $this->db->query("	SELECT meta_value AS last_name
									FROM wp_usermeta
									WHERE user_id = '".$user_id."' AND meta_key='last_name'
									");
		$temp=	$query->result_array();
		return $temp[0];
	}
	
	function getUserNick($user_id)
	{
		$query = $this->db->query("	SELECT meta_value AS nickname
									FROM wp_usermeta
									WHERE user_id = '".$user_id."' AND meta_key='nickname'
									");
		$temp=	$query->result_array();
		return $temp[0];
	}
	
	
	function get_aromas_opcions_array()
	{
		$opciones= array();
		$consulta = $this->db->query('SELECT id, descripcion FROM aroma');
		foreach ($consulta->result_array() as $fila)
		{
			$opciones += array($fila['id']=>$fila['descripcion']);
			
		}
		$opciones += array('-'=>'----');
		return $opciones;;
	}
	
	function get_fabricantes_opcions_array()
	{
		$opciones= array();
		$consulta = $this->db->query('SELECT id, nombre FROM fabricante');
		foreach ($consulta->result_array() as $fila)
		{
			$opciones += array($fila['id']=>$fila['nombre']);
			
		}
		$opciones += array('-'=>'----');
		return $opciones;;
	}
	
	
	function cat_injektion()
	{
		$WHERE =' WHERE 1 ';
		$searh=$this->input->post('grid_searsh');
		if(!empty($searh))
			$WHERE= $WHERE." AND 
							CONCAT(	IFNULL(ci.codigo,' '),' ',
									IFNULL(ci.ref1,' '),' ',
									IFNULL(ci.ref2,' '),' ',
									IFNULL(ci.ref3,' '),' ',
									IFNULL(ci.marca,' '),' ',
									IFNULL(ci.descripcion,' '),' ',
									IFNULL(ci.precio1,' '),' ',
									IFNULL(ci.precio2,' '),' ',
									IFNULL(ci.precio3,' '),' '
								) LIKE '%".$searh."%'";
		$consulta = '	SELECT  ci.codigo,
								ci.ref1,
								ci.ref2,
								ci.ref3,
								ci.marca,
								ci.descripcion,
								ci.precio1,
								ci.precio2,
								ci.precio3
						FROM	cat_injektion AS ci '.$WHERE;
		return $this->db->query($consulta)->result_array();
	}
}
?>