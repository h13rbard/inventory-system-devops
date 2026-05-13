<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$data['user'] = $this->user;
		date_default_timezone_set('America/Mexico_City'); 
		$date = new DateTime();
		$date->modify('-6 hours');
		$data['date'] = $date;

		$this->load->model('Movimiento_model');
		$data['movimientos'] = $this->Movimiento_model->getMovimientosPorDia($date->format('Y-m-d'));

		$this->load->view('layout/header', array('user' => $this->user, 'admin' => $this->admin));
		$this->load->view('home/index', $data);
		$this->load->view('layout/footer');
		
		$this->load->view('layout/close');
	}

}
