<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Dashvta extends CI_Controller {

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
		$this->permisos->check('dashboard/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('dashvta/index');
		$this->load->view('layout/footer');
		$this->load->view('dashvta/index-js');
		$this->load->view('layout/close');
	}

	public function ajax_grupos()
	{
		$this->load->model('Dashvta_model');
		$data = $this->Dashvta_model->ventas_grupo_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		// echo '<pre>';
		// print_r($data->result());
		// echo '</pre>';
		// return;
		
		$total_vta = 0;
		$total_costo = 0;
		echo '<table class="table table-sm datatable" id="table-grupos">';
		echo '<thead><tr class="bg-dark">';
		echo '<th>Grupo</th>';
		echo '<th>Cantidad</th>';
		echo '<th>costo</th>';
		echo '<th>Venta</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->grupo.'</td>';
			echo '<td class="text-right">'.number_format($item->cantidad, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->costo, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta, 2).'</td>';
			echo '</tr>';

			$total_costo += $item->costo;
			$total_vta += $item->venta;
		}
		echo '</tbody>';
		echo '<tfoot><tr><th></th><th></th><th class="text-right">'.number_format($total_costo, 2).'</th><th class="text-right">'.number_format($total_vta, 2).'</th></tr></tfoot>';
		echo '</table>';
	}

	public function ajax_clientes()
	{
		$this->load->model('Dashvta_model');
		$data = $this->Dashvta_model->ventas_clientes_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		// echo '<pre>';
		// print_r($data->result());
		// echo '</pre>';
		// return;
		
		$total_vta = 0;
		$total_costo = 0;
		$total = 0;
		echo '<table class="table table-sm datatable" id="table-clientes">';
		echo '<thead><tr class="bg-dark">';
		echo '<th>Clave</th>';
		echo '<th>Nombre</th>';
		echo '<th>No. Partidas</th>';
		echo '<th>Costo</th>';
		echo '<th>Venta</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->clave.'</td>';
			echo '<td>'.$item->nombre.'</td>';
			echo '<td class="text-right">'.number_format($item->partidas).'</td>';
			echo '<td class="text-right">'.number_format($item->costo, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta, 2).'</td>';
			echo '</tr>';
			$total += $item->partidas;
			$total_costo += $item->costo;
			$total_vta += $item->venta;
		}
		echo '</tbody>';
		echo '<tfoot><tr class="bg-dark"><th></th><th></th><th class="text-right">'.number_format($total).'</th><th class="text-right">'.number_format($total_costo, 2).'</th><th class="text-right">'.number_format($total_vta, 2).'</th></tr></tfoot>';
		echo '</table>';
	}

	public function ajax_formapago()
	{
		$this->load->model('Dashvta_model');
		$data = $this->Dashvta_model->ventas_formapago_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		// echo '<pre>';
		// print_r($data->result());
		// echo '</pre>';
		// return;
		
		$total_vta = 0;
		$total_costo = 0;
		$total = 0;
		echo '<table class="table table-sm datatable" id="table-formapago">';
		echo '<thead><tr class="bg-dark">';
		echo '<th>Pago</th>';
		echo '<th>Partidas</th>';
		echo '<th>Costo</th>';
		echo '<th>Venta</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->pago.'</td>';
			echo '<td class="text-right">'.number_format($item->partidas).'</td>';
			echo '<td class="text-right">'.number_format($item->costo, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta, 2).'</td>';
			echo '</tr>';
			$total += $item->partidas;
			$total_costo += $item->costo;
			$total_vta += $item->venta;
		}
		echo '</tbody>';
		echo '<tfoot><tr class="bg-dark"><th></th><th class="text-right">'.number_format($total).'</th><th class="text-right">'.number_format($total_costo, 2).'</th><th class="text-right">'.number_format($total_vta, 2).'</th></tr></tfoot>';
		echo '</table>';
	}

	public function ajax_productos()
	{
		$this->load->model('Dashvta_model');
		$data = $this->Dashvta_model->ventas_productos_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		// echo '<pre>';
		// print_r($data->result());
		// echo '</pre>';
		// return;
		
		$total_vta = 0;
		$total_costo = 0;
		echo '<table class="table table-sm datatable" id="table-productos">';
		echo '<thead><tr class="bg-dark">';
		echo '<th>Clave</th>';
		echo '<th>Descripcion</th>';
		echo '<th>Cantidad</th>';
		echo '<th>Costo</th>';
		echo '<th>Venta</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->cantidad, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->costo, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta, 2).'</td>';
			echo '</tr>';

			$total_costo += $item->costo;
			$total_vta += $item->venta;
		}
		echo '</tbody>';
		echo '<tfoot><tr class="bg-dark"><th></th><th></th><th></th><th class="text-right">'.number_format($total_costo, 2).'</th><th class="text-right">'.number_format($total_vta, 2).'</th></tr></tfoot>';
		echo '</table>';
	}

	public function dashboard()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('dashboard/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('dashvta/dashboard');
		$this->load->view('layout/footer');
		$this->load->view('dashvta/dashboard-js');
		$this->load->view('layout/close');
	}

	public function resultados_datos()
	{
		$this->load->model('ResultadosSemanales_model');
		$data = $this->ResultadosSemanales_model->getPorPeriodo($this->input->post('inicio'), $this->input->post('fin'));
		$costo = 0; $credito = 0; $contado = 0; $ventas = 0; $sueldo = 0; $compras = 0; $gastos = 0; $desecho=0; $cobranza = 0;
		$utilidad =0; $ganancia =0;
		echo '<div class="table-responsive">'; 
		echo '<table class="table table-sm table-striped datatable" id="table-resultados">';
		echo '<thead><tr class="bg-dark">';
		echo '<th>fecha</th>';
		echo '<th style="width:200px;">Semana</th>';
		echo '<th style="width:100px;">Costo</th>';
		echo '<th style="width:100px;">Contado</th>';
		echo '<th style="width:100px;">Credito</th>';
		echo '<th style="width:100px;">Venta</th>';
		echo '<th style="width:100px;">Utilidad</th>';
		echo '<th style="width:100px;">Sueldo</th>';
		echo '<th style="width:100px;">Ganancia</th>';
		echo '<th style="width:100px;">Compras</th>';
		echo '<th style="width:100px;">Gastos</th>';
		echo '<th style="width:100px;">Desecho</th>';
		echo '<th style="width:100px;">Cobranza</th>';
		echo '</tr></thead>';
		echo '<tbody>'; 
		foreach($data->result() as $item) {
			echo '<tr>'; 
			echo '<td>'.$item->fecha.'</td>';
			echo '<td>'.$item->semana.'</td>';
			echo '<td class="text-right">'.number_format($item->costo, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta_con, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta_cre, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta_total, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta_total-$item->costo-$item->desecho, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->sueldo, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta_total-$item->costo-$item->desecho-$item->sueldo-$item->gastos, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->compras, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->gastos, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->desecho, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->cobranza, 2).'</td>';
			echo '</tr>';
			$costo += $item->costo;
			$credito += $item->venta_cre;
			$contado += $item->venta_con; 
			$ventas += $item->venta_total;
			$sueldo += $item->sueldo;
			$compras += $item->compras;
			$gastos += $item->gastos;
			$desecho += $item->desecho;
			$cobranza += $item->cobranza;
			$utilidad += ($item->venta_total-$item->costo-$item->gastos);
			$ganancia += ($item->venta_total-$item->costo-$item->gastos-$item->sueldo);

		}
		echo '</tbody>';
		echo '<tfoot><tr class="bg-dark">';
		echo '<th></th>';
		echo '<th>TOTALES</th>';
		echo '<th class="text-right">'.number_format($costo, 2).'</th>';
		echo '<th class="text-right">'.number_format($contado, 2).'</th>';
		echo '<th class="text-right">'.number_format($credito, 2).'</th>';
		echo '<th class="text-right">'.number_format($ventas, 2).'</th>';
		echo '<th class="text-right">'.number_format($utilidad, 2).'</th>';
		echo '<th class="text-right">'.number_format($sueldo, 2).'</th>';
		echo '<th class="text-right">'.number_format($ganancia, 2).'</th>';
		echo '<th class="text-right">'.number_format($compras, 2).'</th>';
		echo '<th class="text-right">'.number_format($gastos, 2).'</th>';
		echo '<th class="text-right">'.number_format($desecho, 2).'</th>';
		echo '<th class="text-right">'.number_format($cobranza, 2).'</th>';
		echo '</tr></tfoot>';
		echo '</table>';
		echo '</div>';
	}

	public function resultados_grafica() {
		$this->load->model('ResultadosSemanales_model');
		$data = $this->ResultadosSemanales_model->getPorPeriodo($this->input->post('inicio'), $this->input->post('fin'), true);

		$semanas = [];
		$ventas = [];
		$contado = [];
		$credito = [];
		$cobranza = [];
		$compras = [];
		$totales = [
			'ventas' => 0,
			'contado' => 0,
			'credito' => 0,
			'cobranza' => 0,
			'compras' => 0,
		];
		foreach($data->result() as $item) {
			array_push($semanas, $item->semana);
			array_push($ventas, number_format($item->venta_total, 2,'.',''));
			array_push($contado, number_format($item->venta_con, 2,'.',''));
			array_push($credito, number_format($item->venta_cre, 2,'.',''));
			array_push($cobranza, number_format($item->cobranza, 2,'.',''));
			array_push($compras, number_format($item->compras, 2,'.',''));
			$totales['ventas'] += $item->venta_total;
			$totales['contado'] += $item->venta_con;
			$totales['credito'] += $item->venta_cre;
			$totales['cobranza'] += $item->cobranza;
			$totales['compras'] += $item->compras;
		}

		$totales['ventas'] = number_format($totales['ventas'] , 2,'.','');
		$totales['contado'] = number_format($totales['contado'], 2,'.','');
		$totales['credito'] = number_format($totales['credito'], 2,'.','');
		$totales['cobranza'] = number_format($totales['cobranza'], 2,'.','');
		$totales['compras'] = number_format($totales['compras'], 2,'.','');

		echo json_encode([
			'semanas' => $semanas,
			'ventas' => $ventas,
			'contado' => $contado,
			'credito' => $credito,
			'cobranza' => $cobranza,
			'compras' => $compras,
			'totales' => $totales
		]);
	}

	public function horas()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('dashboard/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('dashvta/horas');
		$this->load->view('layout/footer');
		$this->load->view('dashvta/horas-js');
		$this->load->view('layout/close');
	}

	public function ajax_horas()
	{
		$inicio = $this->input->post('fecha');
		$date = new DateTime($inicio);
		$interval = new DateInterval('P6D');
		$date->add($interval);
		$fin = $date->format("Y-m-d");

		$this->load->model('Dashvta_model');
		$data = $this->Dashvta_model->horas($inicio, $fin);

		$dias = [];
		array_push($dias, $inicio);
		$horas_vtas = [
			0 => [],
			1 => [],
			2 => [],
			3 => [],
			4 => [],
			5 => [],
			6 => [],
			7 => [],
			8 => [],
			9 => [],
			10 => [],
			11 => [],
			12 => [],
			13 => [],
			14 => [],
			15 => [],
			16 => [],
			17 => [],
			18 => [],
			19 => [],
			20 => [],
			21 => [],
			22 => [],
			23 => [],
		];

		$fecha = new DateTime($inicio);
		for($i =0; $i<6; $i++) {
			$interval = new DateInterval('P1D');
			$fecha->add($interval);
			array_push($dias, $fecha->format("Y-m-d"));
		}

		$mayor = 0;
		foreach($data->result() as $item) {
			$horas_vtas[$item->h][$item->fecha] = $item->num;
			$mayor =$item->num > $mayor ? $item->num : $mayor; 
		}

		
		echo '<table class="table table-sm">';
		echo '<thead><tr>';
		echo '<th>Hora / Dia</th>';
		echo '<th>'.$dias[0].'</th>';
		echo '<th>'.$dias[1].'</th>';
		echo '<th>'.$dias[2].'</th>';
		echo '<th>'.$dias[3].'</th>';
		echo '<th>'.$dias[4].'</th>';
		echo '<th>'.$dias[5].'</th>';
		echo '<th>'.$dias[6].'</th>';
		echo '</tr></thead> ';
		echo '<tbody>'; 
		for($i =0; $i<24; $i++){
			echo '<tr">';
			echo '<td style="padding: 0;">'.$i.':00</td>';

			$valor = (array_key_exists($dias[0], $horas_vtas[$i]) ? $horas_vtas[$i][$dias[0]] :  0);
			$color = $this->getColor($mayor, $valor);
			echo '<td '.($color == '' ? '' : ' style="background: #'.$color.';" ').'>'.($valor > 0 ? $valor : '').'</td>';
			$valor = (array_key_exists($dias[1], $horas_vtas[$i]) ? $horas_vtas[$i][$dias[1]] :  0);
			$color = $this->getColor($mayor, $valor);
			echo '<td '.($color == '' ? '' : ' style="background: #'.$color.';" ').'>'.($valor > 0 ? $valor : '').'</td>';
			$valor = (array_key_exists($dias[2], $horas_vtas[$i]) ? $horas_vtas[$i][$dias[2]] :  0);
			$color = $this->getColor($mayor, $valor);
			echo '<td '.($color == '' ? '' : ' style="background: #'.$color.';" ').'>'.($valor > 0 ? $valor : '').'</td>';
			$valor = (array_key_exists($dias[3], $horas_vtas[$i]) ? $horas_vtas[$i][$dias[3]] :  0);
			$color = $this->getColor($mayor, $valor);
			echo '<td '.($color == '' ? '' : ' style="background: #'.$color.';" ').'>'.($valor > 0 ? $valor : '').'</td>';
			$valor = (array_key_exists($dias[4], $horas_vtas[$i]) ? $horas_vtas[$i][$dias[4]] :  0);
			$color = $this->getColor($mayor, $valor);
			echo '<td '.($color == '' ? '' : ' style="background: #'.$color.';" ').'>'.($valor > 0 ? $valor : '').'</td>';
			$valor = (array_key_exists($dias[5], $horas_vtas[$i]) ? $horas_vtas[$i][$dias[5]] :  0);
			$color = $this->getColor($mayor, $valor);
			echo '<td '.($color == '' ? '' : ' style="background: #'.$color.';" ').'>'.($valor > 0 ? $valor : '').'</td>';
			$valor = (array_key_exists($dias[6], $horas_vtas[$i]) ? $horas_vtas[$i][$dias[6]] :  0);
			$color = $this->getColor($mayor, $valor);
			echo '<td '.($color == '' ? '' : ' style="background: #'.$color.';" ').'>'.($valor > 0 ? $valor : '').'</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}

	private function getColor($mayor, $num)
	{
		if ($num <= 0) return '';
		if($num <= intval($mayor*0.2))
			return 'FF9999';
		if($num <= intval($mayor*0.4))
			return 'FFCC99';
		if($num <= intval($mayor*0.6))
			return 'FFFF99';
		if($num <= intval($mayor*0.8))
			return 'CCFF99';
		if($num <= intval($mayor*1))
			return '99FF99';
	}

}
