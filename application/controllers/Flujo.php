<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Flujo extends CI_Controller {

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
		$this->permisos->check('flujo/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('flujo/index');
		$this->load->view('layout/footer');
		$this->load->view('flujo/index-js');
		$this->load->view('layout/close');
	}

	public function datatable()
    {
		$url = base_url();
        $this->datatables->select('id, folio, fecha')
        ->from('corte')
        ->add_column('acciones', '<a href="'.$url.'flujo/corte/$1" title="Consultar"  class="btn btn-secondary btn-sm">Consultar</a>', 'id');
        echo $this->datatables->generate();
	}
	
	public function cortes()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('flujo/cortes',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('flujo/cortes');
		$this->load->view('layout/footer');
		$this->load->view('flujo/cortes-js');
		$this->load->view('layout/close');
	}

    public function ajax_add()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Flujo_model');
        
        $this->Flujo_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $this->Flujo_model->insert();
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }

    public function ajax_edit($id)
    {
        $this->load->model('Producto_model');
        $data = $this->Producto_model->getById($id);
        echo json_encode($data);
    }

    public function ajax_update()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
                
        $this->load->model('Producto_model');
        
        $this->Producto_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Producto_model->existeNombre($this->input->post('id'), $this->input->post('clave_art') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Clave debe contener un valor único." ));
                exit();
            }
            
            $update = $this->Producto_model->update($this->input->post('id'));
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }

	function movimientos()
	{
		$this->load->model('Flujo_model');
        
		$data = $this->Flujo_model->movimientos_pendientes();
		echo '<table class="table table-sm  table-hover datatable" id="example">';
		echo '<thead><tr class="bg-dark"><th></th><th>Fecha</th><th>Concepto</th><th>Ingreso</th><th>Egreso</th><th>Acciones</th></tr></thead>';
		$total_ingreso = 0;
		$total_egreso = 0;
		$i = 0;
		echo '<tbody>';
		foreach($data->result() as $item)
		{
			$i++;
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$item->fecha.'</td>';
			echo '<td>'.$item->concepto.'</td>';
			echo '<td class="text-right">'.($item->tipo == 'I' ? number_format($item->importe, 2) : '0.00').'</td>';
			echo '<td class="text-right">'.($item->tipo == 'E' ? number_format($item->importe, 2) : '0.00').'</td>';
			if($item->proceso == 'OTR' || $item->proceso == 'COM' || $item->proceso == 'GTS' || $item->proceso == 'RET')
				echo '<td class="text-center"><button class="btn btn-sm btn-danger" onclick="eliminar('.$item->id.')">Eliminar</button></td>';
			else
				echo '<td></td>';
			echo '</tr>';
			if ($item->tipo == 'E')
			$total_egreso += $item->importe;
			if ($item->tipo == 'I')
			$total_ingreso += $item->importe;
		}
		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td class="text-right">'.number_format($total_ingreso,2).'</td><td class="text-right">'.number_format($total_egreso,2).'</td><td></td></tr>';
		echo '<tr class="bg-dark"><td></td><td></td><td class="text-center">SALDO</td><td class="text-center" colspan="2">'.number_format($total_ingreso-$total_egreso,2).'</td><td class="text-center">';
		echo '<a class="btn btn-block btn-secondary" href="'.base_url().'flujo/crear_corte">Corte</a>';
		echo '</td></tr>';
		echo '</tfoot>';
		echo '</table>';
		echo '<br>';
	}

	function ajax_delete()
	{
		$this->load->model('Flujo_model');
		$this->Flujo_model->eliminar($this->input->post('id'));
        echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
	}


	function crear_corte()
	{
		$this->load->model('Folio_model');
		$folio = $this->Folio_model->getNoReferencia('CCJ');
		if ($folio['error']) {
			echo $folio['mensaje'];
			exit(0);
		}

		$this->load->model('Flujo_model');
		$id = $this->Flujo_model->crear_corte($folio['noReferencia']);
		$saldo = $this->Flujo_model->get_saldo($id);
		$this->Flujo_model->insert_inicial($saldo->saldo);
		redirect('/flujo/corte/'.$id);
	}

	function corte($id)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('flujo/corte',$group_id);

		$this->load->model('Flujo_model');
		$data['movimientos'] = $this->Flujo_model->movimientos_corte($id);
		$data['corte'] = $this->Flujo_model->getCorteById($id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('flujo/corte', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	function reporte()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('flujo/reporte',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('flujo/reporte');
		$this->load->view('layout/footer');
		$this->load->view('flujo/reporte-js');
		$this->load->view('layout/close');
	}

	function ajax_reporte()
	{
		$this->load->model('Flujo_model');
		$data = $this->Flujo_model->movimientos_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>Proceso</th><th>Concepto</th><th>Fecha</th><th>Ingreso</th><th>Egreso</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		$ingresos = 0;
		$egresos = 0;
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->proceso.'</td>';
			echo '<td>'.$item->concepto.'</td>';
			echo '<td>'.$item->fecha.'</td>';
			echo '<td class="text-right">'.($item->tipo=='I' ? number_format($item->importe,2) : '0.00').'</td>';
			echo '<td class="text-right">'.($item->tipo=='E' ? number_format($item->importe,2) : '0.00').'</td>';
			echo '</tr>';
			$ingresos += $item->tipo=='I' ? $item->importe : 0; 
			$egresos += $item->tipo=='E' ? $item->importe : 0;
		}
		echo '</tbody>';
		echo '</table>';
	}

}
