<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desecho extends CI_Controller {

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
		$this->permisos->check('desecho/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('desecho/index');
		$this->load->view('layout/footer');
		$this->load->view('desecho/index-js');
		$this->load->view('layout/close');
	}

	public function datatable()
    {
        $this->datatables->select('id, folio, fecha, cliente, pago, estado, total')
        ->from('venta')
		->add_column('acciones', 
		'<a href="desecho/pedido/'."$1".'" title="Editar" class="btn btn-secondary btn-sm">Editar</a> '.
		'<a href="desecho/ticket/'."$1".'" title="Imprimir" target="_blank" class="btn btn-secondary btn-sm">Imprimir</a>'
		, 'id')
		->where('doc', 'DES');
        echo $this->datatables->generate();
	}
	
	public function nuevo_desecho()
	{
		$this->load->model('Folio_model');
		$folio = $this->Folio_model->getNoReferencia('DES');
		if ($folio['error']) {
			echo $folio['mensaje'];
			exit(0);
		}

		$this->load->model('Desecho_model');
        $id = $this->Desecho_model->insert($folio['noReferencia'], $this->ion_auth->user()->row()->id);

		redirect('/desecho/pedido/'.$id);
	}

	public function pedido($id = 0)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('desecho/pedido',$group_id);

		$this->load->model('Desecho_model');
		$data['pedido'] = $this->Desecho_model->getById($id);
		$data['partidas'] = $this->Desecho_model->getPartidas($id);

		if ($data['pedido']->estado == 'C')
		{
			$this->load->view('layout/header', ['group_id' => $group_id]);
			$this->load->view('desecho/cerrado', $data);
			$this->load->view('layout/footer');
			$this->load->view('layout/close');
		} else {
			$this->load->view('layout/header', ['group_id' => $group_id]);
			$this->load->view('desecho/pedido', $data);
			$this->load->view('layout/footer');
			$this->load->view('desecho/pedido-js', $data);
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
		
		
		$this->load->model('Desecho_model');

		if ($this->Desecho_model->getEstado($venta_id) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$partida = $this->Desecho_model->getPartidaByProductoId($venta_id, $producto_id);

		$nuevo = true;
		$cantidad = 1;
		$importe = 0;
		if (!is_null($partida)) {
			$nuevo = false;
			$partida_id = $partida->id;
			$this->Desecho_model->updateCantidadPartida($partida_id, $partida->cantidad+1);
			$cantidad = $partida->cantidad+1;
			$importe = $cantidad * $partida->precio;
		} else {
			$partida_id = $this->Desecho_model->insert_partida($producto, $venta_id); 
			$importe = $cantidad * $producto->precio_venta;
		}

		$total = $this->Desecho_model->getTotalVenta($venta_id);
		$this->Desecho_model->setTotalVenta($venta_id, $total);

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
		$this->load->model('Desecho_model');
		$this->Desecho_model->deletePartida($partida_id, $venta_id);

		$total = $this->Desecho_model->getTotalVenta($venta_id);
		$this->Desecho_model->setTotalVenta($venta_id, $total);

		redirect('/desecho/pedido/'.$venta_id);
	}

	public function update_partida()
	{
		$this->load->model('Desecho_model');
		if ($this->Desecho_model->getEstado($this->input->post('venta_id')) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$this->Desecho_model->updateCantidadPartida($this->input->post('partida_id'), $this->input->post('cantidad'));

		$total = $this->Desecho_model->getTotalVenta($this->input->post('venta_id'));
		$this->Desecho_model->setTotalVenta($this->input->post('venta_id'), $total);

		echo json_encode(array(
			'status' => true,
			'total' => number_format($total, 2)
		));
	}

	public function ticket($id = 0)
    {
		$this->load->model('Templatetickets_model');
		$template_ticket = $this->Templatetickets_model->getByClave('DES');

		$this->load->model('Empresa_model');
        $empresa = $this->Empresa_model->get();
		$this->load->model('Desecho_model');
		$enc = $this->Desecho_model->getById($id);
		$part = $this->Desecho_model->getPartidas($id);

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
		$this->load->model('Desecho_model');
		$enc = $this->Desecho_model->getById($id);

		if ($enc->estado == 'P')
		{
			$this->Desecho_model->DescontarExistencia($id);
			$this->Desecho_model->CerrarEncabezado($id);
			$this->Desecho_model->AgregarCosto($id);
			$this->load->model('Movsinv_model');
			$this->Movsinv_model->insert($id, 'DES', 1, 5);

			/**
			 * Esto revisar
			 */
			// if ($enc->pago == 'CON') {
			// 	$this->load->model('Flujo_model');
			// 	$this->Flujo_model->insert_dev($enc->folio, $enc->total);
			// }

		}
		redirect('/desecho');
	}

	// public function checar_exis($id = 0)
	// {
	// 	$this->load->model('Desecho_model');
	// 	$data = $this->Desecho_model->checarExistencias($id);

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
		$this->load->model('Desecho_model');
		$r = $this->Desecho_model->updateCliente($this->input->post('venta_id'), $this->input->post('cliente'));

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
				
		$this->load->model('Desecho_model');
		$venta_id = $this->input->post('venta_id');
		$producto_id = $producto->id;

		$partida = $this->Desecho_model->getPartidaByProductoId($venta_id, $producto_id);

		$nuevo = true;
		$cantidad = 1;
		$importe = 0;
		if (!is_null($partida)) {
			$nuevo = false;
			$partida_id = $partida->id;
			$this->Desecho_model->updateCantidadPartida($partida_id, $partida->cantidad+1);
			$cantidad = $partida->cantidad+1;
			$importe = $cantidad * $partida->precio;
		} else {
			$partida_id = $this->Desecho_model->insert_partida($producto, $venta_id); 
			$importe = $cantidad * $producto->precio_venta;
		}

		$total = $this->Desecho_model->getTotalVenta($venta_id);
		$this->Desecho_model->setTotalVenta($venta_id, $total);

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
		$this->load->model('Desecho_model');
		$r = $this->Desecho_model->updatePago($this->input->post('venta_id'), $this->input->post('pago'));

		echo json_encode(array(
			'status' => $r > 0
		));
	}

}
