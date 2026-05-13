<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

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
		$this->load->view('layout/header', array('user' => $this->user, 'admin' => $this->admin));
		$this->load->view('categorias/index', $data);
		$this->load->view('layout/footer');
		$this->load->view('categorias/index-js', $data);
		$this->load->view('layout/close');
	}

    public function datatable()
    {
        $this->datatables->select('id,nombre, tipo')
        ->from('categorias')
        ->add_column('acciones', '<a href="#" title="Editar" onclick="edit('."'$1'".')" class="btn btn-secondary btn-sm">Editar</a>', 'id');
        echo $this->datatables->generate();
    }

    public function ajax_add()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Categoria_model');
        
        $this->Categoria_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Categoria_model->existeNombre(0, $this->input->post('nombre') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Nombre debe contener un valor único." ));
                exit();
            }

            $insert = $this->Categoria_model->insert();
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }

    public function ajax_edit($id)
    {
        $this->load->model('Categoria_model');
        $data = $this->Categoria_model->getById($id);
        echo json_encode($data);
    }

    public function ajax_update()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
                
        $this->load->model('Categoria_model');
        
        $this->Categoria_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Categoria_model->existeNombre($this->input->post('id'), $this->input->post('nombre') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Nombre debe contener un valor único." ));
                exit();
            }
            
            $update = $this->Categoria_model->update($this->input->post('id'));
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }

}
