<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventario extends CI_Controller
{
	public $limite;
	public $posicion_inicial;
	public function __construct()
   {
		parent::__construct();
		$this->load->model('Catalogos_model');
		$this->load->model('Inventario_model');
		$this->load->library('interdata');
		$this->load->library('phpsession');
		$this->load->library('centinela');
		$this->limite=20;
		$this->posicion_inicial=0;

   }

	public function index()
	{
		session_start();
	}

	function buscar($numero_pagina=false)
	{
		if(!$numero_pagina)
			$numero_pagina = $this->posicion_inicial;
		$inicio_sql= $numero_pagina * $this->limite;
		$filtro=$this->input->post('filtro_busqueda');
		$inventantario_array = $this->Inventario_model->get_inventario(false,$inicio_sql,$this->limite);
		$data['inventantario_array'] = $inventantario_array;
		$data['numero_elementos']=$this->Inventario_model->get_inventario(true,$inicio_sql,$this->limite);
		$data['limite']=$this->limite;
		$data['posicion_inicial']=$numero_pagina;
		$this->load->view('inventario/busquedaInventario',$data);
	}

	function informacionProducto($id_producto)
	{
		if($this->centinela->is_logged_in())
			$data['show_carrito']=TRUE;
		else
			$data['show_carrito']=FALSE;
		$data['producto'] = $this->Inventario_model->getProduct($id_producto);
		$data['referencias'] = $this->Inventario_model->getReferencias($id_producto);
		$this->load->view('inventario/informacionProducto',$data);
	}


	function dialogInformacionProducto($id_producto,$mostrar_carrito=false)
	{
		if($this->centinela->is_logged_in() && $mostrar_carrito)
			$data['show_carrito']=TRUE;
		else
			$data['show_carrito']=FALSE;
		$data['producto'] = $this->Inventario_model->getProduct($id_producto);
		$data['referencias'] = $this->Inventario_model->getReferencias($id_producto);
		$this->load->view('inventario/dialogInformacionProducto',$data);
	}

	function generaSqlImportacionProducto()
	{
		$fila = 1;
		$importArray=array();
		if (($gestor = fopen("import/inventario.csv", "r")) !== FALSE)
		{
		    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE)
		    {
		        $importArray[]=$datos;
		    }
		    fclose($gestor);
		}
		$ImportacionProducto=$this->cargaDatosImportacion($importArray);
		$temp=$this->Inventario_model->generaConsultasImportacionProducto($ImportacionProducto,$importArray);
		//debugg($ImportacionProducto);
		//debugg($importArray);
		echo '<div>'.$temp.'</div>';
	}

	function generaSqlImportacion($scriptImportacion='producto')
	{
		$fila = 1;
		$importArray=array();
		if (($gestor = fopen("import/inventario.csv", "r")) !== FALSE)
		{
		    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE)
		    {
		        $importArray[]=$datos;
		    }
		    fclose($gestor);
		}

		$tipoScript = $this->Inventario_model->tipoScript($scriptImportacion);
		$consultasImportacion='';
		if($tipoScript && COUNT($tipoScript)>0)
		{
			switch($tipoScript[0]['tipo_mecanismo'])
			{
				case 'Simple'	:
									$filasABuscar=$this->Inventario_model->cargaTemplateConfiguracion($tipoScript[0]['nombre']);
									$ImportacionSimple=$this->cargaDatosImportacion($importArray,$filasABuscar,'columna_cvs');
									$consultasImportacion=$this->Inventario_model->generaConsultasImportacion($ImportacionSimple,$importArray,$tipoScript);
									break;
				case 'Dinamico':
									if($tipoScript[0]['nombre']==='referencia_fabricante')
									{
										$fabricantes = $this->Inventario_model->cargaCatalogo('cat_fabricante');
										$fabricantes = $this->cargaDatosImportacion($importArray,$fabricantes,'nombre');
										$filasABuscar=$this->Inventario_model->cargaTemplateConfiguracion($tipoScript[0]['nombre']);

										debugg($fabricantes);
										debugg($filasABuscar);
										foreach ($fabricantes as $key => $value)
										{

										}
									}
									/*
									$dependenciasScript = $this->Inventario_model->cargaDependenciasScript($tipoScript[0]['nombre']);
									foreach ($dependenciasScript as $key => $value)
									{
										$columnasCvsDinamicas = $this->Inventario_model->cargaCatalogo($value['columna_cvs']);
										foreach ($columnasCvsDinamicas as $key => $value)
										{
											$ImportacionSimple=$this->cargaDatosImportacion($importArray,$tipoScript);
											$consultasImportacion=$this->Inventario_model->generaConsultasImportacion($ImportacionSimple,$importArray,$tipoScript);
										}
									}*/

									break;
			}
		}
		echo '<div>'.$consultasImportacion.'</div>';
	}

	function cargaDatosImportacion($rows,$filasABuscar,$columna_referencia)
	{
		foreach ($filasABuscar as $key => $value)
		{
			$tempPosition = $this->buscaPosicionColumnas($value[$columna_referencia],$rows[0]);
			if($tempPosition>=0)
				$filasABuscar[$key]['position']=$tempPosition;
		}
		return $filasABuscar;
	}

	function buscaPosicionColumnas($colToFind,$headers)
	{
		$colsPositions = array();
		foreach($headers AS $position=>$key)
		{
			if($key===$colToFind)
				return $position;
		}
		return -1;
	}
}