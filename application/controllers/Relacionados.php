<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relacionados extends CI_Controller {

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
		$this->permisos->check('relacionados/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('relacionados/index');
		$this->load->view('layout/footer');
		$this->load->view('relacionados/index-js');
		$this->load->view('layout/close');
	}

    public function datatable()
    {
        $this->datatables->select('A.id, p1.clave_art as clave_art1, p1.descrip AS descrip1, p1.existencias AS existencias1, p2.clave_art AS clave_art2, p2.descrip AS descrip2, p2.existencias AS existencias2 ')
        ->from('relacionados A')
		->join('productos p1', 'A.producto1_id = p1.id')
		->join('productos p2', 'A.producto2_id = p2.id')
        ->add_column('acciones', '<a href="#" title="Editar" onclick="edit('."'$1'".')" class="btn btn-info btn-sm">Editar</a>'.
		'<a href="#" title="Eliminar" onclick="eliminar('."'$1'".')" class="btn btn-danger btn-sm">Eliminar</a>', 'id');
        echo $this->datatables->generate();
	}
	
    public function ajax_add()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Relacionados_model');
		$this->load->model('Producto_model');
        
        $this->Relacionados_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r1 = $this->Producto_model->getByClave($this->input->post('clave1') );
            if (is_null($r1))
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El producto 1 no existe." ));
                exit();
            }

			$r2 = $this->Producto_model->getByClave($this->input->post('clave2') );
            if (is_null($r2))
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El producto 2 no existe." ));
                exit();
            }

            $insert = $this->Relacionados_model->insert($r1->id, $r2->id);
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }

    public function ajax_edit($id)
    {
        $this->load->model('Relacionados_model');
        $data = $this->Relacionados_model->getById($id);
        echo json_encode($data);
    }

    public function ajax_update()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
                
        $this->load->model('Relacionados_model');
        
        $this->Relacionados_model->rules2();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {             
            $update = $this->Relacionados_model->update($this->input->post('id'));
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
	}

	public function ajax_delete()
	{
		if (!$this->input->is_ajax_request())
            exit("No es AJAX");
                
        $this->load->model('Relacionados_model');

		$update = $this->Relacionados_model->delete($this->input->post('id'));
        echo json_encode(array("status" => TRUE, "mensaje" => "Registro eliminado correctamente."));
	}


}
