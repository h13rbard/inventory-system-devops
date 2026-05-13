<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

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
		$this->permisos->check('clientes/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('clientes/index');
		$this->load->view('layout/footer');
		$this->load->view('clientes/index-js');
		$this->load->view('layout/close');
	}

    public function datatable()
    {
        $this->datatables->select('id,clave,nombre')
        ->from('clientes')
        ->add_column('acciones', '<a href="#" title="Editar" onclick="edit('."'$1'".')" class="btn btn-secondary btn-sm">Editar</a>', 'id');
        echo $this->datatables->generate();
	}
	
	public function busqueda()
    {
        $this->datatables->select('id,clave,nombre')
        ->from('clientes')
        ->add_column('acciones', '<a href="#" title="Seleccionar" onclick="seleccionar('."'$1'".')" class="btn btn-secondary btn-sm">Seleccionar</a>', 'id');
        echo $this->datatables->generate();
    }

    public function ajax_add()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Cliente_model');
        
        $this->Cliente_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Cliente_model->existeNombre(0, $this->input->post('nombre') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Nombre debe contener un valor único." ));
                exit();
            }

			$this->load->model('Folio_model');
			$folio = $this->Folio_model->getNoReferencia('CLI');
			if ($folio['error']) {
				echo json_encode(array("status" => FALSE, "mensaje" => $folio['mensaje'] ));
				exit(0);
			}
            $insert = $this->Cliente_model->insert($folio['noReferencia']);
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }

    public function ajax_edit($id)
    {
        $this->load->model('Cliente_model');
        $data = $this->Cliente_model->getById($id);
        echo json_encode($data);
    }

    public function ajax_update()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
                
        $this->load->model('Cliente_model');
        
        $this->Cliente_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Cliente_model->existeNombre($this->input->post('id'), $this->input->post('nombre') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Nombre debe contener un valor único." ));
                exit();
            }
            
            $update = $this->Cliente_model->update($this->input->post('id'));
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
	}

	public function ventas($id)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('clientes/index',$group_id);

		$this->load->model('Cliente_model');
        $data['cliente'] = $this->Cliente_model->getById($id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('clientes/ventas', $data);
		$this->load->view('layout/footer');
		$this->load->view('clientes/ventas-js');
		$this->load->view('layout/close');
	}

	public function ajax_ventas()
	{
		$this->load->model('Cliente_model');
		$data = $this->Cliente_model->ventas_periodo($this->input->post('id'), $this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>Pago</th><th>Folio</th><th>Fecha</th><th>Venta</th><th>Dev.</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		$ventas = 0;
		$devs = 0;
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->pago.'</td>';
			echo '<td>'.$item->folio.'</td>';
			echo '<td>'.$item->fecha.' '.$item->hora.'</td>';
			echo '<td class="text-right">'.($item->doc=='VTA' ? number_format($item->total,2) : '').'</td>';
			echo '<td class="text-right">'.($item->doc=='DEV' ? number_format($item->total,2) : '').'</td>';
			echo '</tr>';
			$ventas += $item->doc=='VTA' ? $item->total : 0; 
			$devs += $item->doc=='DEV' ? $item->total : 0;
		}
		echo '<tfoot><tr class="bg-dark"><td></td><td></td><td>TOTAL</td><td class="text-right">'.number_format($ventas, 2).'</td><td class="text-right">'.number_format($devs, 2).'</td></tr></tfoot>';
		echo '</tbody>';
		echo '</table>';
	}

}
