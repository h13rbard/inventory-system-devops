<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo extends CI_Controller {

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

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('grupo/index');
		$this->load->view('layout/footer');
		$this->load->view('grupo/index-js');
		$this->load->view('layout/close');
	}

    public function datatable()
    {
        $this->datatables->select('id,nombre')
        ->from('grupos')
        ->add_column('acciones', '<a href="#" title="Editar" onclick="edit('."'$1'".')" class="btn btn-secondary btn-sm">Editar</a> <button onclick="eliminar('."'$1'".')" class="btn btn-sm btn-danger" >Eliminar</button>', 'id');
        echo $this->datatables->generate();
    }

    public function ajax_add()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
        
        $this->load->model('Grupo_model');
        
        $this->Grupo_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Grupo_model->existeNombre(0, $this->input->post('nombre') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Nombre debe contener un valor único." ));
                exit();
            }

            $insert = $this->Grupo_model->insert();
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }

    public function ajax_edit($id)
    {
        $this->load->model('Grupo_model');
        $data = $this->Grupo_model->getById($id);
        echo json_encode($data);
	}
	
	public function ajax_delete()
    {
        $this->load->model('Grupo_model');
		$this->Grupo_model->delete($this->input->post('id'));
		$this->Grupo_model->eliminar_grupo($this->input->post('id'));
        echo json_encode(array("status" => TRUE, "mensaje" => "Registro eliminado correctamente."));
    }

    public function ajax_update()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
                
        $this->load->model('Grupo_model');
        
        $this->Grupo_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        }
        else
        {    
            $r = $this->Grupo_model->existeNombre($this->input->post('id'), $this->input->post('nombre') );
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Nombre debe contener un valor único." ));
                exit();
            }
            
            $update = $this->Grupo_model->update($this->input->post('id'));
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
	}

	public function asignar()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');

		$this->load->model('Grupo_model');
		$data['grupos'] = $this->Grupo_model->getAll();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('grupo/asignar', $data);
		$this->load->view('layout/footer');
		$this->load->view('grupo/asignar-js');
		$this->load->view('layout/close');
	}

	public function ajax_asignar()
	{
		if (!$this->input->is_ajax_request())
			exit("No es AJAX");

		$this->load->model('Producto_model');

		$producto = $this->Producto_model->getByClave($this->input->post('clave'));

		if ($producto == null) {
			echo json_encode(array("status" => FALSE, "mensaje" => "El producto no fue encontrado."));
			return;	
		}
		
		$this->Producto_model->updateGrupo($producto->id, $this->input->post('grupo'));
		echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
	}

	public function consulta()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');

		$this->load->model('Grupo_model');
		$data['grupos'] = $this->Grupo_model->getAll();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('grupo/consulta', $data);
		$this->load->view('layout/footer');
		$this->load->view('grupo/consulta-js');
		$this->load->view('layout/close');
	}

	public function ajax_consulta($tipo)
	{
		$this->load->model('Producto_model');
		$data = $this->Producto_model->por_grupo($this->input->post('grupo'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>#</th><th>Clave</th><th>Cod Prov</th><th>Descripcion</th><th>Costo</th><th>Precio</th><th>Cantidad</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		$costo_total = 0;
		$cantidad_total =0;
		foreach($data->result() as $item) {
			if ($tipo==2 && $item->existencias <= 0) continue;
			echo '<tr>';
			echo '<td>'.$item->clasif.'</td>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->clave_prov.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_venta,2).'</td>';
			echo '<td class="text-right">'.number_format($item->existencias,2).'</td>';
			echo '</tr>';
			$costo_total += ($item->precio_compra*$item->existencias);
			$cantidad_total += $item->existencias;
		}
		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr><td></td><td></td><td></td><td></td><td class="text-right">'.number_format($costo_total,2).'</td>';
		echo '<td></td><td class="text-right">'.number_format($cantidad_total, 2).'</td></tr>';
		echo '</tfoot>';
		echo '</table>';
	}

	public function sin_asignar()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('grupo/sin_asignar');
		$this->load->view('layout/footer');
		$this->load->view('grupo/sin_asignar-js');
		$this->load->view('layout/close');
	}

	public function dt_sin_asignar()
    {
        $this->datatables->select('id, clave_art, clave_prov, codigo_b, descrip, precio_venta, localizacion')
        ->from('productos')
        ->where('grupo_id IS NULL', null, false);
        echo $this->datatables->generate();
	}
	
	public function no_productos()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		
		$this->load->model('Grupo_model');
		$data['grupos'] = $this->Grupo_model->no_productos();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('grupo/no_productos', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function todos()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('grupo/todos');
		$this->load->view('layout/footer');
		$this->load->view('grupo/todos-js');
		$this->load->view('layout/close');
	}

    public function dt_todos()
    {
        $this->datatables->select('p.id, p.clave_art, p.clave_prov, p.clasif, p.descrip, p.precio_venta, p.localizacion, g.nombre as grupo')
		->from('productos p')
		->join('grupos g', 'p.grupo_id=g.id', 'left');
        echo $this->datatables->generate();
    }

}
