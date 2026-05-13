<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {

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
		$this->permisos->check('proveedor/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('proveedor/index');
		$this->load->view('layout/footer');
		$this->load->view('proveedor/index-js');
		$this->load->view('layout/close');
	}

    public function datatable()
    {
        $this->datatables->select('id,clave,nombre')
        ->from('proveedores')
        ->add_column('acciones', '<a href="#" title="Editar" onclick="edit('."'$1'".')" class="btn btn-secondary btn-sm">Editar</a>', 'id');
        echo $this->datatables->generate();
    }

    public function ajax_add()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Proveedor_model');
        
        $this->Proveedor_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Proveedor_model->existeNombre(0, $this->input->post('nombre') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Nombre debe contener un valor único." ));
                exit();
            }
			$this->load->model('Folio_model');
			$folio = $this->Folio_model->getNoReferencia('PRO');
			if ($folio['error']) {
				echo json_encode(array("status" => FALSE, "mensaje" => $folio['mensaje'] ));
				exit(0);
			}
            $insert = $this->Proveedor_model->insert($folio['noReferencia']);
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }

    public function ajax_edit($id)
    {
        $this->load->model('Proveedor_model');
        $data = $this->Proveedor_model->getById($id);
        echo json_encode($data);
    }

    public function ajax_update()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
                
        $this->load->model('Proveedor_model');
        
        $this->Proveedor_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Proveedor_model->existeNombre($this->input->post('id'), $this->input->post('nombre') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Nombre debe contener un valor único." ));
                exit();
            }
            
            $update = $this->Proveedor_model->update($this->input->post('id'));
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
	}

}
