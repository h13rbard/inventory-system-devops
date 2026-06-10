<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Dashboard extends CI_Controller {

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
		$this->load->view('dashboard/index');
		$this->load->view('layout/footer');
		$this->load->view('dashboard/index-js');
		$this->load->view('layout/close');
	}

	public function ajax_doc_pendientes()
	{
		$this->load->model('Cobranza_model');
		$doc_pendientes = $this->Cobranza_model->doc_pendientes();
		$pend = 0;
		foreach($doc_pendientes->result() as $item)
		{
			$pend += $item->movimiento == 'C' ? $item->total : $item->total*-1;
		}
		echo '$ '.number_format($pend ,2);
	}

	public function ajax_saldo_caja()
	{
		$this->load->model('Flujo_model');
		$caja = $this->Flujo_model->get_saldo_caja();
		$saldo = 0;
		foreach($caja->result() as $item)
		{
			$saldo += $item->tipo == 'I' ? $item->total : $item->total*-1;
		}
		echo '$ '.number_format($saldo ,2);
	}

	public function ajax_valor_inventario()
	{
		$this->load->model('Producto_model');
		$inv = $this->Producto_model->valor_inventario();
		$num_prod = $this->Producto_model->numero_productos();
		$con_exis = $this->Producto_model->productos_con_existencia();
		echo '<div class="number dashtext-1 text-center">$ ';
		echo number_format($inv->result()[0]->total,2);
		echo '</div>';
		echo '<br>';
		echo '<table class="table table-sm table-striped datatable">';
		echo '<tr><td>Total de productos:</td><td class="text-right"> '.number_format($num_prod->result()[0]->total, 0).'</td></tr>';
		echo '<tr><td>Con existencias:</td><td class="text-right"> '.number_format($con_exis->result()[0]->total, 0).'</td></tr>';
		echo '<tr><td>Sin existencias:</td><td class="text-right"> '.number_format($num_prod->result()[0]->total - $con_exis->result()[0]->total, 0).'</td></tr>';
		echo '</table>';
	}

	public function ajax_ventas()
	{
		$this->load->model('Venta_model');
		$data = $this->Venta_model->ventas_resumen_periodo($this->input->post('inicio'), $this->input->post('fin'));

		$vta_con = 0;
		$vta_cre = 0;
		$dev_con = 0;
		$dev_cre = 0;
		$des = 0;
		foreach($data->result() as $item) {
			$vta_con = $item->doc=='VTA' && $item->pago=='CON' ? $item->total : $vta_con;
			$vta_cre = $item->doc=='VTA' && $item->pago=='CRE' ? $item->total : $vta_cre;
			$dev_con = $item->doc=='DEV' && $item->pago=='CON' ? $item->total : $dev_con;
			$dev_cre = $item->doc=='DEV' && $item->pago=='CRE' ? $item->total : $dev_cre;
			$des = $item->doc=='DES' ? $item->total : $des;
		}
		echo '<div class="number dashtext-2" text-center>$ ';
		echo number_format($vta_cre-$dev_cre+$vta_con-$dev_con, 2);
		echo '</div>';
		echo '<br>';
		echo '<table class="table table-sm table-striped datatable">';
		echo '<tr><td>Ventas credito:</td><td class="text-right"> '.number_format($vta_cre-$dev_cre, 2).'</td></tr>';
		echo '<tr><td>Ventas contado:</td><td class="text-right"> '.number_format($vta_con-$dev_con, 2).'</td></tr>';
		echo '<tr><td>Desecho:</td><td class="text-right"> '.number_format($des, 2).'</td></tr>';
		echo '</table>';
	}

	public function ajax_compras()
	{
		$this->load->model('Compra_model');
		$compras = $this->Compra_model->compras_resumen_periodo($this->input->post('inicio'), $this->input->post('fin'));
		$compras = $compras->result()[0]->total;
		echo '$ '.number_format($compras, 2);
	}

	public function ajax_cobranza()
	{
		$this->load->model('Cobranza_model');
		$abonos = $this->Cobranza_model->abonos_periodo($this->input->post('inicio'), $this->input->post('fin'));
		$total_abonos = 0;
		foreach($abonos->result() as $item)
		{
			$total_abonos = $item->total;
		}
		$total_abonos = $total_abonos;
		echo '$ '.number_format($total_abonos, 2);
	}

	public function ajax_flujo()
	{
		$this->load->model('Flujo_model');
		$data = $this->Flujo_model->por_periodo_agrupado($this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm table-striped">';
		echo '<thead><tr class="bg-dark"><th>Tipo</th><th>Proceso</th><th>Total</th></tr></thead><tbody>';
		
		foreach($data->result() as $item)
		{
			if($item->proceso =='INI') continue;
			echo '<tr>';
			echo '<td>'.$item->tipo.'</td>';
			echo '<td>'.$item->proceso.'</td>';
			echo '<td class="text-right">'.number_format($item->total, 2).'</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}

}
