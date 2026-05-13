<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Compra extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation', 'datatables'));
        $this->form_validation->set_error_delimiters('', '');
        $this->load->helper(array('url'));

        $this->lang->load('auth');
		if (!$this->ion_auth->logged_in())
            redirect('auth/login', 'refresh');
    }

	public function index()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('compra/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('compra/index');
		$this->load->view('layout/footer');
		$this->load->view('compra/index-js');
		$this->load->view('layout/close');
	}

	public function datatable()
    {
        $this->datatables->select('id, folio, fecha, proveedor, pago, estado, total')
        ->from('compra')
		->add_column('acciones', 
		'<a href="compra/pedido/'."$1".'" title="Editar" class="btn btn-secondary btn-sm">Editar</a> '
		, 'id')
		->where('doc', 'COM');
        echo $this->datatables->generate();
	}

	public function crear_compra()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('compra/crear_compra',$group_id);

		$this->load->model('Proveedor_model');
		$data['proveedores'] = $this->Proveedor_model->getList();

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('compra/crear', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}
	
	public function nueva_compra()
	{
		$this->load->model('Folio_model');
		$folio = $this->Folio_model->getNoReferencia('COM');
		if ($folio['error']) {
			echo $folio['mensaje'];
			exit(0);
		}

		$this->load->model('Proveedor_model');
		$proveedor = $this->Proveedor_model->getById($this->input->post('proveedor_id'));

		$this->load->model('Compra_model');
        $id = $this->Compra_model->insert($folio['noReferencia'], $this->input->post('proveedor_id'), $proveedor->nombre, $this->input->post('fecha_compra'), $this->input->post('no_referencia'), $this->ion_auth->user()->row()->id);

		redirect('/compra/pedido/'.$id);
	}

	public function pedido($id = 0)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('compra/pedido',$group_id);

		$this->load->model('Compra_model');
		$data['pedido'] = $this->Compra_model->getById($id);
		$data['partidas'] = $this->Compra_model->getPartidas($id);

		if ($data['pedido']->estado == 'C')
		{
			$this->load->view('layout/header', ['group_id' => $group_id]);
			$this->load->view('compra/cerrado', $data);
			$this->load->view('layout/footer');
			$this->load->view('layout/close');
		} else {
			$this->load->view('layout/header', ['group_id' => $group_id]);
			$this->load->view('compra/pedido', $data);
			$this->load->view('layout/footer');
			$this->load->view('compra/pedido-js', $data);
			$this->load->view('layout/close');
		}
	}

	public function productos()
    {
        $this->datatables->select('id, clave_art, clave_prov, codigo_b, descrip, precio_compra, localizacion, existencias')
		->from('productos')
		->where('baja', '0')
        ->add_column('acciones', '<a href="#" title="Agregar" onclick="agregar('."'$1'".')" class="btn btn-secondary btn-sm">Agregar</a>', 'id');
        echo $this->datatables->generate();
	}
	
	public function add_partida($compra_id, $producto_id)
	{
		$this->load->model('Producto_model');
        $producto = $this->Producto_model->getById($producto_id);
		
		
		$this->load->model('Compra_model');

		if ($this->Compra_model->getEstado($compra_id) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$partida = $this->Compra_model->getPartidaByProductoId($compra_id, $producto_id);

		$nuevo = true;
		$cantidad = 1;
		$importe = 0;
		if (!is_null($partida)) {
			$nuevo = false;
			$partida_id = $partida->id;
			$this->Compra_model->updateCantidadPartida($partida_id, $partida->cantidad+1);
			$cantidad = $partida->cantidad+1;
			$importe = $cantidad * $partida->precio;
		} else {
			$partida_id = $this->Compra_model->insert_partida($producto, $compra_id); 
			$importe = $cantidad * $producto->precio_compra;
		}

		$total = $this->Compra_model->getTotalCompra($compra_id);
		$this->Compra_model->setTotalCompra($compra_id, $total);

		echo json_encode(array(
			'status' => true,
			'producto' => $producto,
			'total'=> number_format($total,2), 
			'partida_id' => $partida_id,
			'nuevo' => $nuevo,
			'cantidad' => $cantidad,
			'importe' => number_format($importe, 2),
			'partida' => $partida
		));
	}

	public function del_partida($compra_id, $partida_id)
	{
		$this->load->model('Compra_model');
		$this->Compra_model->deletePartida($partida_id, $compra_id);

		$total = $this->Compra_model->getTotalCompra($compra_id);
		$this->Compra_model->setTotalCompra($compra_id, $total);

		redirect('/compra/pedido/'.$compra_id);
	}

	public function update_partida()
	{
		$this->load->model('Compra_model');
		if ($this->Compra_model->getEstado($this->input->post('compra_id')) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$this->Compra_model->updateCantidadPartida($this->input->post('partida_id'), $this->input->post('cantidad'));

		$total = $this->Compra_model->getTotalCompra($this->input->post('compra_id'));
		$this->Compra_model->setTotalCompra($this->input->post('compra_id'), $total);

		echo json_encode(array(
			'status' => true,
			'total' => number_format($total, 2)
		));
	}

	public function update_partida_precio()
	{
		$this->load->model('Compra_model');
		if ($this->Compra_model->getEstado($this->input->post('compra_id')) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$this->Compra_model->updatePrecioPartida($this->input->post('partida_id'), $this->input->post('precio'));

		$total = $this->Compra_model->getTotalCompra($this->input->post('compra_id'));
		$this->Compra_model->setTotalCompra($this->input->post('compra_id'), $total);

		echo json_encode(array(
			'status' => true,
			'total' => number_format($total, 2)
		));
	}

	public function ticket($id = 0)
    {
		$this->load->model('Compra_model');
		$this->load->model('Empresa_model');
        $data['enc'] = $this->Compra_model->getById($id);
		$data['partidas'] = $this->Compra_model->getPartidas($id);
		$data['empresa'] = $this->Empresa_model->get();
        $this->load->view('compra/ticket', $data);
	}
	
	public function confirmar($id = 0)
	{
		set_time_limit(300);
		$this->load->model('Compra_model');
		$enc = $this->Compra_model->getById($id);

		if ($enc->estado == 'P')
		{
			$this->Compra_model->SumarExistencia($id);
			$this->Compra_model->CerrarEncabezado($id);
			$this->load->model('Movsinv_model');
			$this->Movsinv_model->insert_compra($id, 'COM', 3, 1);

			// if ($enc->pago == 'CON') {
			// 	$this->load->model('Flujo_model');
			// 	$this->Flujo_model->insert_dev($enc->folio, $enc->total);
			// }

		}
		redirect('/compra/index');
	}

	// public function checar_exis($id = 0)
	// {
	// 	$this->load->model('Compra_model');
	// 	$data = $this->Compra_model->checarExistencias($id);

	// 	$salida = '';
	// 	foreach($data->result() as $item)
	// 	{
	// 		$salida .= $item->clave_art.' '.$item->descrip.'<br>';
	// 		$salida .= 'Exis.: '.number_format($item->existencias,2).'<br>Sol.: '.number_format($item->cantidad,2).'<br>';
	// 	}

	// 	echo json_encode(array(
	// 		'resultado' => $data->num_rows() == 0,
	// 		'salida' => $salida
	// 	));
	// }

	public function update_proveedor()
	{
		$this->load->model('Compra_model');
		$r = $this->Compra_model->updateProveedor($this->input->post('compra_id'), $this->input->post('proveedor'));

		echo json_encode(array(
			'status' => $r > 0,
		));
	}

	public function update_no_referencia()
	{
		$this->load->model('Compra_model');
		$r = $this->Compra_model->updateNoReferencia($this->input->post('compra_id'), $this->input->post('no_referencia'));

		echo json_encode(array(
			'status' => $r > 0,
		));
	}

	public function update_fecha_compra()
	{
		$this->load->model('Compra_model');
		$r = $this->Compra_model->updateFechaCompra($this->input->post('compra_id'), $this->input->post('fecha_compra'));

		echo json_encode(array(
			'status' => $r > 0,
		));
	}

	public function add_codigo()
	{
		$this->load->model('Producto_model');
		$producto = $this->Producto_model->getByCodigoBarras($this->input->post('codigo_b'));
		
		if (is_null($producto))
		{
			echo json_encode(array(
				'status' => false,
				'producto' => $producto
			));
			return;
		}
				
		$this->load->model('Compra_model');
		$compra_id = $this->input->post('compra_id');
		$producto_id = $producto->id;

		$partida = $this->Compra_model->getPartidaByProductoId($compra_id, $producto_id);

		$nuevo = true;
		$cantidad = 1;
		$importe = 0;
		if (!is_null($partida)) {
			$nuevo = false;
			$partida_id = $partida->id;
			$this->Compra_model->updateCantidadPartida($partida_id, $partida->cantidad+1);
			$cantidad = $partida->cantidad+1;
			$importe = $cantidad * $partida->precio;
		} else {
			$partida_id = $this->Compra_model->insert_partida($producto, $compra_id); 
			$importe = $cantidad * $producto->precio_venta;
		}

		$total = $this->Compra_model->getTotalCompra($compra_id);
		$this->Compra_model->setTotalCompra($compra_id, $total);

		echo json_encode(array(
			'status' => true,
			'producto' => $producto,
			'total'=> number_format($total,2), 
			'partida_id' => $partida_id,
			'nuevo' => $nuevo,
			'cantidad' => $cantidad,
			'importe' => number_format($importe, 2),
			'partida' => $partida
		));

	}

	public function update_pago()
	{
		$this->load->model('Compra_model');
		$r = $this->Compra_model->updatePago($this->input->post('compra_id'), $this->input->post('pago'));

		echo json_encode(array(
			'status' => $r > 0
		));
	}


	public function actualizar_precios()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('compra/crear_compra',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('compra/act_pre');
		$this->load->view('layout/footer');
		$this->load->view('compra/act_pre-js');
		$this->load->view('layout/close');
	}

	public function actualizar_precios_compra()
	{
		$this->load->model('Compra_model');
		$this->load->model('Producto_model');
		$enc = $this->Compra_model->getByFolio( $this->input->post('folio') );
		$partidas = $this->Compra_model->getPartidasActualizar($enc->id);

		echo '<table class="table table-sm datatable">';
		echo '<tr class="bg-dark"><td>CLAVE</td><td>DESCRIPCION</td><td>COMPRA</td><td>COSTO</td><td>DIFERENCIA</td><td>VENTA ANT.</td><td>VENTA NUEVO</td></tr>';
		foreach($partidas->result() as $item) {
			// $precio_venta = $item->precio_compra * 1.2;
			$inc = ($item->iva_uni > 0) ? $item->precio_uni - $item->iva_uni : 0;
			$precio_venta = $item->precio_venta + $inc;
			$dif = $precio_venta - (int)$precio_venta;

			if ($dif == 0)
				$precio_venta = $precio_venta;
			else if ($dif > 0 && $dif <= .50)
				$precio_venta = (int)$precio_venta + 0.50;
			else if ($dif > .50 && $dif < 1)
				$precio_venta = (int)$precio_venta + 1;

			$this->Producto_model->updatePrecioCosto($item->producto_id, $precio_venta);
			
			echo '<tr>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td>'.number_format($item->precio, 2).'</td>';
			echo '<td>'.number_format($item->precio_compra, 2).'</td>';
			echo '<td>'.number_format($item->precio_uni, 2).'-'.number_format($item->iva_uni, 2).'='.number_format($inc, 2).'</td>';
			echo '<td>'.number_format($item->precio_venta, 2).'</td>';
			echo '<td>'.number_format($precio_venta, 2).'</td>';
			echo '</tr>';
		}
		echo '</table>';
	}

}
