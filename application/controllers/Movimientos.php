<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movimientos extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation', 'datatables'));
        $this->form_validation->set_error_delimiters('', '');
        $this->load->helper(array('url'));

        $this->lang->load('auth');

        $this->user = null;
        if ($this->ion_auth->logged_in())
        {
			$this->user = $this->ion_auth->user()->row();
			$this->admin = $this->ion_auth->in_group(array(1, 3));
        }
        else
        {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
    }

	public function index()
	{
		if ($this->input->post('fecha')) {
			$fecha = $this->input->post('fecha');
		} else {
			date_default_timezone_set('America/Mexico_City'); 
			$date = new DateTime();
			$date->modify('-6 hours');
			$fecha = $date->format('Y-m-d');
		}

		$data['fecha'] = $fecha;

		$this->load->model('Movimiento_model');
		$data['movimientos'] = $this->Movimiento_model->getMovimientosPorDia($fecha);
				
		$this->load->view('layout/header', array('user' => $this->user, 'admin' => $this->admin));
		$this->load->view('movimientos/index', $data);
		$this->load->view('layout/footer');
		// $this->load->view('movimientos/index-js', $data);
		$this->load->view('layout/close');
	}

	public function periodo()
	{
		if ($this->input->post('inicio')) {
			$data['inicio'] = $this->input->post('inicio');
			$data['fin'] = $this->input->post('fin');

			$this->load->model('Movimiento_model');
			$data['movimientos'] = $this->Movimiento_model->getMovimientosPeriodo($data['inicio'], $data['fin']);
		} else {
			$data['movimientos'] = null;
		}

		$this->load->view('layout/header', array('user' => $this->user, 'admin' => $this->admin));
		$this->load->view('movimientos/periodo', $data);
		$this->load->view('layout/footer');
		// $this->load->view('movimientos/periodo-js', $data);
		$this->load->view('layout/close');
	}

	public function ventas()
	{
		$this->load->model('Concepto_model');
        $data['conceptos'] = $this->Concepto_model->getListByTipo('I');

		$this->load->model('Formapago_model');
		$data['formaspago'] = $this->Formapago_model->getList();
		
		date_default_timezone_set('America/Mexico_City'); 
		$date = new DateTime();
		$date->modify('-6 hours');
		$data['date'] = $date;

		$this->load->view('layout/header', array('user' => $this->user, 'admin' => $this->admin));
		$this->load->view('movimientos/ventas', $data);
		$this->load->view('layout/footer');
		$this->load->view('movimientos/ventas-js', $data);
		$this->load->view('layout/close');
	}

	public function gastos()
	{
		$this->load->model('Concepto_model');
        $data['conceptos'] = $this->Concepto_model->getListByTipo('E');

		$this->load->model('Formapago_model');
		$data['formaspago'] = $this->Formapago_model->getList();
		
		date_default_timezone_set('America/Mexico_City'); 
		$date = new DateTime();
		$date->modify('-6 hours');
		$data['date'] = $date;

		$this->load->view('layout/header', array('user' => $this->user, 'admin' => $this->admin));
		$this->load->view('movimientos/gastos', $data);
		$this->load->view('layout/footer');
		$this->load->view('movimientos/gastos-js', $data);
		$this->load->view('layout/close');
	}

    public function ajax_add_venta()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Movimiento_model');
        
        $this->Movimiento_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {            
            $insert = $this->Movimiento_model->insert('I', $this->user->id);
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
	}

	public function ajax_add_gasto()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Movimiento_model');
        
        $this->Movimiento_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {            
            $insert = $this->Movimiento_model->insert('E', $this->user->id);
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
	}
	
	public function ventas_por_dia()
	{
		$this->load->model('Movimiento_model');
		$registros = $this->Movimiento_model->getList('I', $this->input->post('fecha'));
        echo json_encode(array("status" => TRUE, "registros" => $registros->result() ));
	}

	public function gastos_por_dia()
	{
		$this->load->model('Movimiento_model');
		$registros = $this->Movimiento_model->getList('E', $this->input->post('fecha'));
        echo json_encode(array("status" => TRUE, "registros" => $registros->result() ));
	}

	public function eliminar()
	{
		$this->load->model('Movimiento_model');
		$insert = $this->Movimiento_model->eliminar($this->input->post('id'));
        echo json_encode(array("status" => TRUE));
	}

}
