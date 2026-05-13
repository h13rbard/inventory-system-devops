<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devolucion extends CI_Controller {

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
		$this->permisos->check('devolucion/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('devolucion/index');
		$this->load->view('layout/footer');
		$this->load->view('devolucion/index-js');
		$this->load->view('layout/close');
	}

	public function datatable()
    {
        $this->datatables->select('id, folio, fecha, cliente, pago, estado, total')
        ->from('venta')
		->add_column('acciones', 
		'<a href="devolucion/pedido/'."$1".'" title="Editar" class="btn btn-secondary btn-sm">Editar</a> '.
		'<a href="devolucion/ticket/'."$1".'" title="Imprimir" target="_blank" class="btn btn-secondary btn-sm">Imprimir</a>'
		, 'id')
		->where('doc', 'DEV');
        echo $this->datatables->generate();
	}
	
	public function nueva_devolucion()
	{
		$this->load->model('Folio_model');
		$folio = $this->Folio_model->getNoReferencia('DEV');
		if ($folio['error']) {
			echo $folio['mensaje'];
			exit(0);
		}

		$this->load->model('Devolucion_model');
        $id = $this->Devolucion_model->insert($folio['noReferencia'], $this->ion_auth->user()->row()->id);

		redirect('/devolucion/pedido/'.$id);
	}

	public function pedido($id = 0)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('devolucion/pedido',$group_id);

		$this->load->model('Devolucion_model');
		$data['pedido'] = $this->Devolucion_model->getById($id);
		$data['partidas'] = $this->Devolucion_model->getPartidas($id);

		if ($data['pedido']->estado == 'C')
		{
			$this->load->view('layout/header', ['group_id' => $group_id]);
			$this->load->view('devolucion/cerrado', $data);
			$this->load->view('layout/footer');
			$this->load->view('layout/close');
		} else {
			$this->load->view('layout/header', ['group_id' => $group_id]);
			$this->load->view('devolucion/pedido', $data);
			$this->load->view('layout/footer');
			$this->load->view('devolucion/pedido-js', $data);
			$this->load->view('layout/close');
		}
	}

	public function productos()
    {
        $this->datatables->select('id, clave_art, clave_prov, codigo_b, descrip, precio_venta, localizacion, existencias')
		->from('productos')
		->where('baja', '0')
        ->add_column('acciones', '<a href="#" title="Agregar" onclick="agregar('."'$1'".')" class="btn btn-secondary btn-sm">Agregar</a>', 'id');
        echo $this->datatables->generate();
	}
	
	public function add_partida($venta_id, $producto_id)
	{
		$this->load->model('Producto_model');
        $producto = $this->Producto_model->getById($producto_id);
		
		
		$this->load->model('Devolucion_model');

		if ($this->Devolucion_model->getEstado($venta_id) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$partida = $this->Devolucion_model->getPartidaByProductoId($venta_id, $producto_id);

		$nuevo = true;
		$cantidad = 1;
		$importe = 0;
		if (!is_null($partida)) {
			$nuevo = false;
			$partida_id = $partida->id;
			$this->Devolucion_model->updateCantidadPartida($partida_id, $partida->cantidad+1);
			$cantidad = $partida->cantidad+1;
			$importe = $cantidad * $partida->precio;
		} else {
			$partida_id = $this->Devolucion_model->insert_partida($producto, $venta_id); 
			$importe = $cantidad * $producto->precio_venta;
		}

		$total = $this->Devolucion_model->getTotalVenta($venta_id);
		$this->Devolucion_model->setTotalVenta($venta_id, $total);

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

	public function del_partida($venta_id, $partida_id)
	{
		$this->load->model('Devolucion_model');
		$this->Devolucion_model->deletePartida($partida_id, $venta_id);

		$total = $this->Devolucion_model->getTotalVenta($venta_id);
		$this->Devolucion_model->setTotalVenta($venta_id, $total);

		redirect('/devolucion/pedido/'.$venta_id);
	}

	public function update_partida()
	{
		$this->load->model('Devolucion_model');
		if ($this->Devolucion_model->getEstado($this->input->post('venta_id')) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$this->Devolucion_model->updateCantidadPartida($this->input->post('partida_id'), $this->input->post('cantidad'));

		$total = $this->Devolucion_model->getTotalVenta($this->input->post('venta_id'));
		$this->Devolucion_model->setTotalVenta($this->input->post('venta_id'), $total);

		echo json_encode(array(
			'status' => true,
			'total' => number_format($total, 2)
		));
	}

	public function ticket($id = 0)
    {
		$this->load->model('Templatetickets_model');
		$template_ticket = $this->Templatetickets_model->getByClave('DEV');

		$this->load->model('Empresa_model');
        $empresa = $this->Empresa_model->get();
		$this->load->model('Devolucion_model');
		$enc = $this->Devolucion_model->getById($id);
		$part = $this->Devolucion_model->getPartidas($id);

		$partidas = [];
		foreach($part->result() as $item) {
			array_push($partidas, [
				'clave_art' => $item->clave_art,
				'descrip' => $item->descrip,
				'precio' => number_format($item->precio, 2),
				'cantidad' => number_format($item->cantidad, 2),
				'importe' => number_format($item->cantidad*$item->precio, 2)
			]);
		}

		$data = array(
				'logo' => base_url().$empresa->logo,
				'nombre' => $empresa->nombre,
				'eslogan' => $empresa->eslogan,
				'direccion' => $empresa->direccion,
				'ciudad' => $empresa->ciudad,
				'correo' => $empresa->correo,
				'cliente' => $enc->cliente,
				'folio' => 'TICKET: '.$enc->folio,
				'total' => number_format($enc->total,2),
				'fecha_hora' => date_format(date_create($enc->fecha), 'd/m/Y').' '.$enc->hora,
				'tipo_venta' => $enc->pago=='CON' ? 'VENTA DE CONTADO' : 'VENTA A CREDITO',
				'partidas' => $partidas
		);

		$this->load->library('parser');
		$this->parser->parse_string($template_ticket->formato, $data);
	}
	
	public function confirmar($id = 0)
	{
		$this->load->model('Devolucion_model');
		$enc = $this->Devolucion_model->getById($id);

		if ($enc->estado == 'P')
		{
			$this->Devolucion_model->SumarExistencia($id);
			$this->Devolucion_model->CerrarEncabezado($id);
			$this->Devolucion_model->AgregarCosto($id);

			if ($enc->pago == 'CON') {
				$this->load->model('Flujo_model');
				$this->Flujo_model->insert_dev($enc->folio, $enc->total);
			}

			$this->load->model('Movsinv_model');
			$this->Movsinv_model->insert($id, 'DEV', 2, 1);
		}
		redirect('/devolucion');
	}

	// public function checar_exis($id = 0)
	// {
	// 	$this->load->model('Devolucion_model');
	// 	$data = $this->Devolucion_model->checarExistencias($id);

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

	public function update_cliente()
	{
		$this->load->model('Devolucion_model');
		$r = $this->Devolucion_model->updateCliente($this->input->post('venta_id'), $this->input->post('cliente'));

		echo json_encode(array(
			'status' => $r > 0
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
				
		$this->load->model('Devolucion_model');
		$venta_id = $this->input->post('venta_id');
		$producto_id = $producto->id;

		$partida = $this->Devolucion_model->getPartidaByProductoId($venta_id, $producto_id);

		$nuevo = true;
		$cantidad = 1;
		$importe = 0;
		if (!is_null($partida)) {
			$nuevo = false;
			$partida_id = $partida->id;
			$this->Devolucion_model->updateCantidadPartida($partida_id, $partida->cantidad+1);
			$cantidad = $partida->cantidad+1;
			$importe = $cantidad * $partida->precio;
		} else {
			$partida_id = $this->Devolucion_model->insert_partida($producto, $venta_id); 
			$importe = $cantidad * $producto->precio_venta;
		}

		$total = $this->Devolucion_model->getTotalVenta($venta_id);
		$this->Devolucion_model->setTotalVenta($venta_id, $total);

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
		$this->load->model('Devolucion_model');
		$r = $this->Devolucion_model->updatePago($this->input->post('venta_id'), $this->input->post('pago'));

		echo json_encode(array(
			'status' => $r > 0
		));
	}

}
