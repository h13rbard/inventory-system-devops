<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Dashinv extends CI_Controller {

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
		$this->load->view('dashinv/index');
		$this->load->view('layout/footer');
		$this->load->view('dashinv/index-js');
		$this->load->view('layout/close');
	}

	public function ajax_valor_inventario()
	{
		$this->load->model('Dashinv_model');
		$data = $this->Dashinv_model->valor_inventario();
	
		echo '<div class="number dashtext-1" >$ '.number_format($data->result()[0]->total, 2).'</div>';
		echo '<div class="number dashtext-1" >'.number_format($data->result()[0]->numero, 0).' productos</div>';

		$data = $this->Dashinv_model->activos_bajas();
		echo '<br>';
		
		echo '<table class="table table-sm">';
		echo '<tr><td>Productos</td><td>Con existencias</td><td>Sin existencias</td><td>Total</td></tr>';
		foreach($data->result() as $item) {
			echo '<tr><td>'.($item->baja==0 ? 'Activos' : 'Baja').'</td><td>'.$item->exis.'</td><td>'.$item->sin_exis.'</td><td>'.$item->numero.'</td></tr>';
		}
		echo '</table>';
		echo '<br>';
		$data = $this->Dashinv_model->bajas_existencias();
		echo '<table class="table table-sm">';
		echo '<tr><td>Clave</td><td>Descripción</td><td>Existencias</td></tr>';
		foreach($data->result() as $item) {
			echo '<tr><td>'.$item->clave_art.'</td><td>'.$item->descrip.'</td><td >'.$item->existencias.'</td></tr>';
		}
		echo '</table>';
	}

	public function ajax_clasificacion()
	{
		$this->load->model('Dashinv_model');
		$data = $this->Dashinv_model->clasif_productos();
		$total = 0;
		$total_importe = 0;
		echo '<table class="table table-sm datatable" id="table-clasif">';
		echo '<thead><tr class="bg-dark"><th>Clasificacion</th><th>Con existencias</th><th>Sin existencias</th><th>Productos</th><th>Importe</th></tr></thead>';
		echo '<tbody>';
		foreach($data->result() as $item) {
			echo '<tr><td>'.$item->clasif.($item->baja==1 ? ' *baja' :'').'</td><td>'.number_format($item->exis).'</td><td>'.number_format($item->sin_exis).'</td>';
			echo '<td class="text-right">'.number_format($item->productos).'</td><td class="text-right">'.number_format($item->importe, 2).'</td></tr>';
			$total += $item->productos;
			$total_importe += $item->importe;
		}
		echo '</tbody>';
		echo '<tfoot><tr class="bg-dark"><th></th><th></th><th>Total</th><th class="text-right">'.number_format($total).'</th><th class="text-right">'.number_format($total_importe, 2).'</th></tr></tfoot>';
		echo '</table>';
	}

	public function ajax_grupos()
	{
		$this->load->model('Dashinv_model');
		$data = $this->Dashinv_model->grupos_productos();
		$total = 0;
		$total_importe = 0;
		echo '<table class="table table-sm datatable" id="table-grupos">';
		echo '<thead><tr class="bg-dark"><th>Grupo</th><th>Con existencias</th><th>Sin existencias</th><th>Productos</th><th>Importe</th></tr></thead>';
		echo '<tbody>';
		foreach($data->result() as $item) {
			echo '<tr><td>'.$item->nombre.($item->baja==1 ? ' *baja' :'').'</td><td>'.number_format($item->exis).'</td><td>'.number_format($item->sin_exis).'</td><td class="text-right">'.number_format($item->productos).'</td><td class="text-right">'.number_format($item->importe, 2).'</td></tr>';
			$total += $item->productos;
			$total_importe += $item->importe;
		}
		echo '</tbody>';
		echo '<tfoot><tr class="bg-dark"><th></th><th></th><th>Total</th><th class="text-right">'.number_format($total).'</th><th class="text-right">'.number_format($total_importe, 2).'</th></tr></tfoot>';
		echo '</table>';
	}

	public function ajax_filtrar()
	{
		$this->load->model('Dashinv_model');
		$data = $this->Dashinv_model->filtrar(
			$this->input->post('clasificacion'),
			$this->input->post('estado'),
			$this->input->post('existencias')
		);

		echo '<table class="table table-sm datatable" id="table-filtrar">';
		echo '<thead><tr class="bg-dark"><th>Clave</th>
		<th>Descripción</th>
		<th>Clasificación</th>
		<th>Estado</th>
		<th>Grupo</th>
		<th>Existencias</th>
		<th>Costo</th>
		<th>Importe</th>
		</tr></thead>';
		echo '<tbody>';
		$total = 0;
		foreach($data->result() as $item) {
			echo '<tr>'; 
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td>'.$item->clasif.'</td>';
			echo '<td>'.($item->baja==1 ? 'BAJA' : 'ACTIVO').'</td>';
			echo '<td>'.$item->grupo.'</td>';
			echo '<td class="text-right">'.number_format($item->existencias, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra, 2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra * $item->existencias, 2).'</td>';
			echo '</tr>';
			$total += ($item->precio_compra * $item->existencias);
		}
		echo '</tbody>';
		echo '<tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th class="text-right">Total:</th><th class="text-right">'.number_format($total, 2).'</th></tr></tfoot>';
		echo '</table>';
	}

	public function dashboard()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('dashboard/index',$group_id);

		$this->load->model('Dashinv_model');
		$data = $this->Dashinv_model->grupos_productos()->result();

		$data_clasif = $this->Dashinv_model->clasif_productos()->result();
		$data_proveedores = $this->Dashinv_model->proveedores_productos()->result();

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('dashinv/grafica', ['data' => $data, 
							'data_clasif' => $data_clasif,
							'data_proveedores' => $data_proveedores
							,]);
		$this->load->view('layout/footer');
		$this->load->view('dashinv/grafica-js', ['data' => $data]);
		$this->load->view('layout/close');
	}

}
