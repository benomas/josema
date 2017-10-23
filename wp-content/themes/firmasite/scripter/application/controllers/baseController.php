<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class baseController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function selectData($consulta,$keyIndex=null,$valueIndex=null){
		$keyIndex=$keyIndex?$keyIndex:"keyColumn";
		$valueIndex=$valueIndex?$valueIndex:"valueColumn";
		$opciones=[];
		foreach ($consulta->result_array() as $fila)
			$opciones += [$fila[$valueIndex]=>$fila[$valueIndex]];
		$opciones += array('-'=>'----');
		return $opciones;
	}

	public function jsonOptions($consulta,$keyIndex=null,$valueIndex=null){
		$keyIndex=$keyIndex?$keyIndex:"keyColumn";
		$valueIndex=$valueIndex?$valueIndex:"valueColumn";
		$opciones=[];
		foreach ($consulta->result_array() as $fila)
			$opciones += [$fila[$keyIndex]=>$fila[$valueIndex]];
		$opciones += array('-'=>'----');
		return json_encode($opciones);
	}
}