<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cobranza extends CI_Controller {

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
	
	public function clientes()
	{		
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('cobranza/clientes',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('cobranza/clientes');
		$this->load->view('layout/footer');
		$this->load->view('cobranza/clientes-js');
		$this->load->view('layout/close');
	}

    public function dt_clientes()
    {
        $this->datatables->select('id,clave,nombre')
        ->from('clientes')
        ->add_column('acciones', '<a href="index/$1" title="Editar" onclick="docs('."'$1'".')" class="btn btn-secondary btn-sm">Documentos</a>', 'id');
        echo $this->datatables->generate();
	}

	public function index($id = 0)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('cobranza/index',$group_id);

		$this->load->model('Cobranza_model');
		$saldo = $this->Cobranza_model->doc_saldo_cliente($id);
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('cobranza/index', ['saldo' => $saldo,'cliente_id' => $id]);
		$this->load->view('layout/footer');
		$this->load->view('cobranza/index-js', ['cliente_id' => $id]);
		$this->load->view('layout/close');
	}

	public function ticket_estado($id = 0)
	{
		$this->load->model('Cobranza_model');
		$saldo = $this->Cobranza_model->doc_saldo_cliente($id);
		$this->load->model('Empresa_model');
		$this->load->model('Cliente_model');
        $data['enc'] = $this->Cliente_model->getById($id);
		$partidas = $this->Cobranza_model->estado_cuenta($id);
		$partidas_hoy = $this->Cobranza_model->estado_cuenta_saldado_hoy($id);
		$data['partidas'] = array_merge($partidas->result(), $partidas_hoy->result());
		$data['empresa'] = $this->Empresa_model->get();
        $this->load->view('cobranza/ticket_estado', $data);
	}

	public function ticket_estado2($id = 0)
	{
		$this->load->model('Templatetickets_model');
		$template_ticket = $this->Templatetickets_model->getByClave('EDOCT');

		$this->load->model('Cobranza_model');
		$saldo = $this->Cobranza_model->doc_saldo_cliente($id);
		$this->load->model('Empresa_model');
		$this->load->model('Cliente_model');
        $enc = $this->Cliente_model->getById($id);
		$partidas_aux = $this->Cobranza_model->estado_cuenta($id);
		$partidas_hoy = $this->Cobranza_model->estado_cuenta_saldado_hoy($id);
		$part = array_merge($partidas_aux->result(), $partidas_hoy->result());
		$empresa = $this->Empresa_model->get();

		$total_cargo = 0;
		$total_abono =0;
		$venta_id = 0;
		$resta_doc=0;
		$partidas = [];
		
		foreach($part as $partida) {
		if ($venta_id != $partida->venta_id && $venta_id!=0) {
			array_push($partidas, ['fecha' => '', 'concepto' => 'Resta', 'importe' => number_format($resta_doc, 2)]);
		$resta_doc = 0;
		}
		if ($partida->movimiento=='C') {
			array_push($partidas, ['fecha' => 'Folio:', 'concepto' => $partida->no_referencia, 'importe' => '']);
		}
		array_push($partidas, ['fecha' => $partida->fecha, 'concepto' => $partida->movimiento.' '.$partida->concepto, 'importe' => number_format($partida->importe, 2)]);
		$total_cargo += $partida->movimiento == 'C' ? $partida->importe : 0;
		$total_abono += $partida->movimiento == 'A' ? $partida->importe : 0;
		$venta_id = $partida->venta_id;
		$resta_doc += $partida->movimiento == 'C' ? $partida->importe : ($partida->importe*-1);
		}
		if ($venta_id!=0) {
			array_push($partidas, ['fecha' => '', 'concepto' => 'Resta', 'importe' => number_format($resta_doc, 2)]);
			$resta_doc = 0;
		}

		$data = array(
				'logo' => base_url().$empresa->logo,
				'nombre' => $empresa->nombre,
				'eslogan' => $empresa->eslogan,
				'direccion' => $empresa->direccion,
				'ciudad' => $empresa->ciudad,
				'correo' => $empresa->correo,
				'cliente' => $enc->nombre,
				'fecha_hora' => date_format(date_create(), 'd/m/Y H:i:s'),
				'partidas' => $partidas,
				'total_cargo' => number_format($total_cargo, 2),
				'total_abono' => number_format($total_abono, 2),
				'saldo' => number_format($total_cargo-$total_abono ,2)
		);

		$this->load->library('parser');
		$this->parser->parse_string($template_ticket->formato, $data);
	}

	public function datatable($id = 0)
    {
        $this->datatables->select('id, no_referencia, estado, cliente, importe, fecha, saldo, venta_id')
        ->from('cobranza')
		->add_column('acciones', 
		'<a href="../abonos/'."$1".'" title="Abonar" class="btn btn-secondary btn-sm">Abonar</a> '.
		'<a href="../ticket/'."$1".'" title="Imprimir" target="_blank" class="btn btn-secondary btn-sm">Imprimir</a> '.
		'<a href="../../venta/ticket/'."$1".'" title="Imprimir" target="_blank" class="btn btn-secondary btn-sm">Venta</a>'
		, 'venta_id')
		->where('movimiento', 'C')->where('cliente_id', $id);
        echo $this->datatables->generate();
	}

	public function abonos($id)
	{	
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('cobranza/abonos',$group_id);

		$this->load->model('Cobranza_model');
		$obj = $this->Cobranza_model->getClienteByVentaId($id);
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('cobranza/abonos', ['venta_id' => $id, 'cliente' => $obj]);
		$this->load->view('layout/footer');
		$this->load->view('cobranza/abonos-js', ['venta_id' => $id]);
		$this->load->view('layout/close');
	}

	public function movimientos($id)
	{
		$this->load->model('Cobranza_model');
		$data = $this->Cobranza_model->getMovimientos($id);
		
		echo '<table class="table table-sm table-bordered datatable">';
		echo '<tr class="bg-dark"><th>Estado</th><th>Fecha</th><th>Concepto</th><th>No. Referencia</th><th>Cliente</th><th>Cargo</th><th>Abono</th></tr>';
		$total_cargo = 0;
		$total_abono = 0;
		foreach($data->result() as $item)
		{
			echo '<tr>';
			echo '<td>'.$item->estado.'</td>';
			echo '<td>'.$item->fecha.'</td>';
			echo '<td>'.$item->concepto.'</td>';
			echo '<td>'.$item->no_referencia.'</td>';
			echo '<td>'.$item->cliente.'</td>';
			echo '<td class="text-right">'.($item->movimiento == 'C' ? number_format($item->importe, 2) : '0.00').'</td>';
			echo '<td class="text-right">'.($item->movimiento == 'A' ? number_format($item->importe, 2) : '0.00').'</td>';
			echo '</tr>';
			if ($item->movimiento == 'C')
			$total_cargo += $item->importe;
			if ($item->movimiento == 'A')
			$total_abono += $item->importe;
		}
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td></td><td></td><td class="text-right">'.number_format($total_cargo,2).'</td><td class="text-right">'.number_format($total_abono,2).'</td></tr>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td colspan="2" class="text-center">SALDO</td><td class="text-center" colspan="2">'.number_format($total_abono-$total_cargo,2).'</td>';
		echo '</tr>';
		echo '</table>';
		echo '<br>';
	}

	public function ajax_add()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Cobranza_model');
        
        $this->Cobranza_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {   
			if($this->input->post('importe') <= 0) {
				echo json_encode(array("status" => FALSE, "mensaje" => "El abono debe ser mayor a 0."));
				return;
			}

			$saldo = $this->Cobranza_model->getSaldo($this->input->post('venta_id'));

			if($this->input->post('importe') > $saldo->saldo) {
				echo json_encode(array("status" => FALSE, "mensaje" => "El abono no puede ser mayor al cargo."));
				return;
			}

			$this->Cobranza_model->insertMovimiento();
			
			if (strtoupper($this->input->post('concepto')) == 'EFE') {
				$this->load->model('Flujo_model');
				$this->Flujo_model->insert_abono(strtoupper($this->input->post('cliente')), $this->input->post('importe'));
			}

			$saldo = $this->Cobranza_model->getSaldo($this->input->post('venta_id'));
			if ($saldo->saldo == 0)
				$this->Cobranza_model->updateEstado($this->input->post('venta_id'), 'S', $saldo->saldo);
			else
				$this->Cobranza_model->updateEstado($this->input->post('venta_id'), 'P', $saldo->saldo);

            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
	}
	
	public function ticket($id = 0)
    {
		$this->load->model('Templatetickets_model');
		$template_ticket = $this->Templatetickets_model->getByClave('COB');

		$this->load->model('Venta_model');
		$this->load->model('Cobranza_model');
		$this->load->model('Empresa_model');
        $enc = $this->Venta_model->getById($id);
		$part = $this->Cobranza_model->getMovimientos($id);
		$empresa = $this->Empresa_model->get();

		$partidas = [];
		$total_cargo = 0;
		$total_abono =0;
		foreach($part->result() as $item) {
			array_push($partidas, [
				'movimiento' => $item->movimiento,
				'fecha' => $item->fecha,
				'cliente' => $item->cliente,
				'importe' => number_format($item->importe, 2)
			]);
			$total_cargo += $item->movimiento == 'C' ? $item->importe : 0;
			$total_abono += $item->movimiento == 'A' ? $item->importe : 0;
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
				'fecha_hora' => date_format(date_create(), 'd/m/Y H:i:s'),
				'partidas' => $partidas,
				'total_cargo' => number_format($total_cargo, 2),
				'total_abono' => number_format($total_abono, 2),
				'saldo' => number_format($total_cargo-$total_abono ,2)
		);

		$this->load->library('parser');
		$this->parser->parse_string($template_ticket->formato, $data);
	}

	public function abonar($id)
	{
		$this->load->model('Cobranza_model');
		// $saldo = $this->Cobranza_model->doc_saldo_cliente($id);

		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('cobranza/index',$group_id);

		$this->load->model('Cliente_model');
        $data['cliente'] = $this->Cliente_model->getById($id);
		$data['partidas'] = $this->Cobranza_model->estado_cuenta($id);
		
		
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('cobranza/abonar', $data);
		$this->load->view('layout/footer');
		$this->load->view('cobranza/abonar-js');
		$this->load->view('layout/close');
	}

	public function guardar_abono()
	{
		$this->load->model('Cobranza_model');
		
		$cliente = $this->input->post('cliente');
		$cliente_id = $this->input->post('cliente_id');

		$cargos = $this->input->post('cargo');
		$abonos = $this->input->post('abono');
		if($cargos != null && $abonos != null) {
		foreach($cargos as $k=>$item){
			echo $cargos[$k].' '.$abonos[$k].'<br>';
			$importe = $abonos[$k];
			$venta_id = $cargos[$k];

			if($importe > 0) {

			$saldo = $this->Cobranza_model->getSaldo($venta_id);

			if($importe > $saldo->saldo) {
				continue;
			}
			echo $cliente.' - '.$importe.' - '.$venta_id.' - '.$cliente_id.'<br>';
			$this->Cobranza_model->insertMovimiento2($cliente, $importe, $venta_id, $cliente_id);
			
			$this->load->model('Flujo_model');
			$this->Flujo_model->insert_abono(strtoupper($cliente), $importe);

			$saldo = $this->Cobranza_model->getSaldo($venta_id);
			if ($saldo->saldo == 0)
				$this->Cobranza_model->updateEstado($venta_id, 'S', $saldo->saldo);
			else
				$this->Cobranza_model->updateEstado($venta_id, 'P', $saldo->saldo);

			}
		}
		}
		redirect('cobranza/index/'.$cliente_id, 'refresh');
	}

	function doc_pendientes()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('cobranza/doc_pendientes',$group_id);

		$this->load->model('Cobranza_model');
        $data['pendientes'] = $this->Cobranza_model->getDocPendientes();
		$data['antiguos'] = $this->Cobranza_model->getDocAntiguos();

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('cobranza/doc_pendientes', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}
	
}
