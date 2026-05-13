<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta extends CI_Controller {

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
		$this->permisos->check('venta/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('venta/index');
		$this->load->view('layout/footer');
		$this->load->view('venta/index-js');
		$this->load->view('layout/close');
	}

	public function datatable()
    {
        $this->datatables->select('id, folio, fecha, estado, cliente, pago, total')
        ->from('venta')
		->add_column('acciones', 
		'<a href="venta/pedido/'."$1".'" title="Editar" class="btn btn-secondary btn-sm">Editar</a> '.
		'<a href="venta/ticket/'."$1".'" title="Imprimir" target="_blank" class="btn btn-secondary btn-sm">Imprimir</a>'
		, 'id')
		->where('doc', 'VTA');
        echo $this->datatables->generate();
	}
	
	public function nueva_venta()
	{
		$this->load->model('Folio_model');
		$folio = $this->Folio_model->getNoReferencia('VTA');
		if ($folio['error']) {
			echo $folio['mensaje'];
			exit(0);
		}

		$this->load->model('Venta_model');
        $id = $this->Venta_model->insert($folio['noReferencia'],$this->ion_auth->user()->row()->id);

		redirect('/venta/pedido/'.$id);
	}

	public function pedido($id = 0)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('venta/pedido',$group_id);

		$this->load->model('Venta_model');
		$data['pedido'] = $this->Venta_model->getById($id);
		$data['partidas'] = $this->Venta_model->getPartidas($id);

		if ($data['pedido']->estado == 'C')
		{
			$this->load->view('layout/header', ['group_id' => $group_id]);
			$this->load->view('venta/cerrado', $data);
			$this->load->view('layout/footer');
			$this->load->view('layout/close');
		} else {
			$this->load->view('layout/header', ['group_id' => $group_id]);
			$this->load->view('venta/pedido', $data);
			$this->load->view('layout/footer');
			$this->load->view('venta/pedido-js', $data);
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
		
		
		$this->load->model('Venta_model');

		if ($this->Venta_model->getEstado($venta_id) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$partida = $this->Venta_model->getPartidaByProductoId($venta_id, $producto_id);

		$nuevo = true;
		$cantidad = 1;
		$importe = 0;
		if (!is_null($partida)) {
			$nuevo = false;
			$partida_id = $partida->id;
			$this->Venta_model->updateCantidadPartida($partida_id, $partida->cantidad+1);
			$cantidad = $partida->cantidad+1;
			$importe = $cantidad * $partida->precio;
		} else {
			$partida_id = $this->Venta_model->insert_partida($producto, $venta_id); 
			$importe = $cantidad * $producto->precio_venta;
		}

		$total = $this->Venta_model->getTotalVenta($venta_id);
		$this->Venta_model->setTotalVenta($venta_id, $total);

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
		$this->load->model('Venta_model');

		if ($this->Venta_model->getEstado($venta_id) == 'C') {
			redirect('/venta/pedido/'.$venta_id);
		}

		$this->Venta_model->deletePartida($partida_id, $venta_id);

		$total = $this->Venta_model->getTotalVenta($venta_id);
		$this->Venta_model->setTotalVenta($venta_id, $total);

		redirect('/venta/pedido/'.$venta_id);
	}

	public function update_partida()
	{
		$this->load->model('Venta_model');

		if ($this->Venta_model->getEstado($this->input->post('venta_id')) == 'C') {
			echo json_encode(array(
				'status' => false
			));
			return;
		}

		$this->Venta_model->updateCantidadPartida($this->input->post('partida_id'), $this->input->post('cantidad'));

		$total = $this->Venta_model->getTotalVenta($this->input->post('venta_id'));
		$this->Venta_model->setTotalVenta($this->input->post('venta_id'), $total);

		echo json_encode(array(
			'status' => true,
			'total' => number_format($total, 2)
		));
	}

	public function ticket($id = 0)
    {
		$this->load->model('Templatetickets_model');
		$template_ticket = $this->Templatetickets_model->getByClave('VTA');

		$this->load->model('Empresa_model');
        $empresa = $this->Empresa_model->get();
		$this->load->model('Venta_model');
		$enc = $this->Venta_model->getById($id);
		$part = $this->Venta_model->getPartidas($id);

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
		$this->load->model('Venta_model');
		$enc = $this->Venta_model->getById($id);

		if ($enc->estado == 'P')
		{
			$this->Venta_model->DescontarExistencia($id);
			$this->Venta_model->CerrarEncabezado($id);
			$this->Venta_model->AgregarCosto($id);

			if ($enc->pago == 'CON') {
				$this->load->model('Flujo_model');
				$this->Flujo_model->insert_venta($enc->folio, $enc->total);
			}

			if ($enc->pago == 'CRE') {
				// crear encabezado de cobranza el cargo
				$this->load->model('Cobranza_model');
				$enc = $this->Cobranza_model->insert($enc->total, $enc->id, $enc->folio, $enc->cliente,$enc->cliente_id);
			}

			$this->load->model('Movsinv_model');
			$this->Movsinv_model->insert($id, 'VTA', 1, 2);
		}
		redirect('/venta');
	}

	public function checar_exis($id = 0)
	{
		$this->load->model('Venta_model');
		$data = $this->Venta_model->checarExistencias($id);

		$salida = '';
		foreach($data->result() as $item)
		{
			$salida .= $item->clave_art.' '.$item->descrip.'<br>';
			$salida .= 'Exis.: '.number_format($item->existencias,2).'<br>Sol.: '.number_format($item->cantidad,2).'<br>';
		}

		echo json_encode(array(
			'resultado' => $data->num_rows() == 0,
			'salida' => $salida
		));
	}

	public function update_cliente()
	{
		$this->load->model('Venta_model');
		$r = $this->Venta_model->updateCliente($this->input->post('venta_id'), $this->input->post('cliente'));

		echo json_encode(array(
			'status' => $r > 0
		));
	}

	public function update_pago()
	{
		$this->load->model('Venta_model');
		$r = $this->Venta_model->updatePago($this->input->post('venta_id'), $this->input->post('pago'));

		echo json_encode(array(
			'status' => $r > 0
		));
	}

	public function add_codigo()
	{
		// agregar normal
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
				
		$this->load->model('Venta_model');
		$venta_id = $this->input->post('venta_id');
		$producto_id = $producto->id;

		$partida = $this->Venta_model->getPartidaByProductoId($venta_id, $producto_id);

		$nuevo = true;
		$cantidad = 1;
		$importe = 0;
		if (!is_null($partida)) {
			$nuevo = false;
			$partida_id = $partida->id;
			$this->Venta_model->updateCantidadPartida($partida_id, $partida->cantidad+1);
			$cantidad = $partida->cantidad+1;
			$importe = $cantidad * $partida->precio;
		} else {
			$partida_id = $this->Venta_model->insert_partida($producto, $venta_id); 
			$importe = $cantidad * $producto->precio_venta;
		}

		$total = $this->Venta_model->getTotalVenta($venta_id);
		$this->Venta_model->setTotalVenta($venta_id, $total);

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

	public function cambiar_cliente()
	{
		$this->load->model('Cliente_model');
		$obj = $this->Cliente_model->getById($this->input->post('cliente_id'));

		$this->load->model('Venta_model');
		$r = $this->Venta_model->cambiarCliente($this->input->post('venta_id'), $this->input->post('cliente_id'), $obj->nombre);

		echo json_encode(array(
			'status' => $r > 0,
			'nombre' => $obj->nombre,
			'cliente_id' => $obj->id
		));
	}

}
