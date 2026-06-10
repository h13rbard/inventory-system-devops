<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historialproductos extends CI_Controller {

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
		$this->permisos->check('historialproductos/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('productos/historial');
		$this->load->view('layout/footer');
		$this->load->view('productos/historial-js');
		$this->load->view('layout/close');
	}

	public function datatable()
    {
        $this->datatables->select('id, clave_art, clave_prov, codigo_b, descrip, precio_venta, localizacion')
        ->from('productos')
        ->add_column('acciones', '<a href="#" title="Ver" onclick="ver('."'$1'".')" class="btn btn-secondary btn-sm">Ver</a>', 'id');
        echo $this->datatables->generate();
	}
	
	public function ver($id)
	{
		$this->load->model('Producto_model');
		$data = $this->Producto_model->getHistorial( intval($id) );

		echo '<table class="table table-sm table-hovered datatable">';
		echo '<tr class="bg-dark"><th>Campo</th><th>Original</th><th>Nuevo</th><th>Fecha</th><th>Usuario</th></tr>';
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->campo.'</td>';
			echo '<td>'.$item->valor_original.'</td>';
			echo '<td>'.$item->valor_nuevo.'</td>';
			echo '<td>'.$item->fecha.' '.$item->hora.'</td>';
			echo '<td>'.$item->username.'</td>';
			echo '</tr>';
		}
	}

	public function por_dia()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('historialproductos/por_dia',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('productos/historial_por_dia');
		$this->load->view('layout/footer');
		$this->load->view('productos/historial_por_dia-js');
		$this->load->view('layout/close');
	}

	public function ajax_por_dia()
	{
		$this->load->model('Producto_model');
		$data = $this->Producto_model->getHistorialPorDia($this->input->post('fecha'));
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>clave</th><th>Producto</th><th>Campo</th><th>Original</th><th>Nuevo</th><th>Fecha</th><th>Usuario</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td>'.$item->campo.'</td>';
			echo '<td>'.$item->valor_original.'</td>';
			echo '<td>'.$item->valor_nuevo.'</td>';
			echo '<td>'.$item->fecha.' '.$item->hora.'</td>';
			echo '<td>'.$item->username.'</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}

}
