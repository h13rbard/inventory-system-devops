<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

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
		$this->permisos->check('productos/index',$group_id);

		$this->load->model('Proveedor_model');
		$data['proveedores'] = $this->Proveedor_model->getList();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('productos/index', $data);
		$this->load->view('layout/footer');
		$this->load->view('productos/index-js');
		$this->load->view('layout/close');
	}

	public function datatable()
    {
        $this->datatables->select('id, clave_art, clave_prov, codigo_b, descrip, precio_venta, localizacion, existencias ')
		->from('productos')
		->where('baja',0)
        ->add_column('acciones', '<a href="#" title="Editar" onclick="edit('."'$1'".')" class="btn btn-secondary btn-sm">Editar</a>', 'id');
        echo $this->datatables->generate();
    }

    public function ajax_add()
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
            $r = $this->Producto_model->existeNombre(0, $this->input->post('clave_art'));
            if ($r > 0)
            {
                echo json_encode(array("status" => FALSE, "mensaje" => "El campo Clave debe contener un valor único." ));
                exit();
            }

            $insert = $this->Producto_model->insert();
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
            
            $update = $this->Producto_model->update($this->input->post('id'), $this->ion_auth->user()->row()->id);
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
    }
    
    public function do_upload()
    {
        $id = $this->input->post("id");
        $imagen1 = $this->input->post("imagen1");

        $ruta = './images/'; // Ruta para almacenar el archivo
        $rutaGuardar = 'images/'; // Ruta para guardar en la DB, registro

        $ruta = str_replace("//", "/", $ruta);
        $rutaGuardar = str_replace("//", "/", $rutaGuardar);

        $config['upload_path']   = $ruta;
        $config['allowed_types'] = 'png|jpg|gif';
        $config['file_name']     = $id;  //Cambiar el nombre del archivo original al id recibido
        $config['overwrite']     = true;
        $config['max_size']     = 0;


        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');

        // Comprobar si no existe la carpeta, crearla
        if (!is_dir($ruta))
        {
            mkdir($ruta, 0777);
            $fp = fopen($ruta.'index.html', 'w');
            fwrite($fp, '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>');
            fclose($fp);
        }

        if ( ! $this->upload->do_upload('imagen1'))
        {
            $error = array('error' => $this->upload->display_errors('',''));
            echo json_encode(array("status" => FALSE, "mensaje" => $error['error']));
        }

        else
        {
            $this->load->model('Producto_model');
            $this->Producto_model->updateImagen($id, $rutaGuardar.$this->upload->data('file_name'));
            echo json_encode(array("status" => TRUE, "mensaje" => "Archivo guardado correctamente.", "archivo" => $rutaGuardar.$this->upload->data('file_name') ));
        }
    }


	public function actualiza_precios()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('productos/actualiza_precios',$group_id);

		$this->load->model('Proveedor_model');
		$data['proveedores'] = $this->Proveedor_model->getList();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('productos/actualiza_precios', $data);
		$this->load->view('layout/footer');
		$this->load->view('productos/actualiza_precios-js');
		$this->load->view('layout/close');
	}

	public function ajax_actualiza_precios()
	{
		$this->load->model('Producto_model');
		$data = $this->Producto_model->actualiza_precios($this->input->post('inicio'), $this->input->post('fin'), $this->input->post('proveedor_id'));
		$num = $this->input->post('porcentaje');
		$porcentaje = 1 + ($num/100);
		echo '<table class="table table-sm table-bordered datatable"';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>#</th><th>Clave</th><th>Descripción</th><th>Compra</th><th>Venta</th><th>Nuevo</th>';
		echo '</tr></thead>';
		$i =1;
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			$i++;
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			$precio = 0;
			if( ($item->precio_compra*$porcentaje)-floor($item->precio_compra*$porcentaje) >= 0.5) {
				if ( ($item->precio_compra*$porcentaje)-floor($item->precio_compra*$porcentaje) == 0.5) 
					$precio = $item->precio_compra*$porcentaje;
				else 
					$precio = floor($item->precio_compra*$porcentaje)+1;
			} else {
				if (($item->precio_compra*$porcentaje)-floor($item->precio_compra*$porcentaje) == 0.0)
					$precio =  $item->precio_compra*$porcentaje;
				else
					$precio = floor($item->precio_compra*$porcentaje)+0.5;
			}

			echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_venta,2).'</td>';
			echo '<td class="text-right">'.number_format($precio,2).'</td>';
			echo '</tr>';
		}
		echo '</table>';
		
	}

	public function ajax_actualizar_precios()
	{
		$this->load->model('Producto_model');
		$num = $this->input->post('porcentaje');
		$porcentaje = 1 + ($num/100);
		$data = $this->Producto_model->actualizar_precios($porcentaje, $this->input->post('inicio'), $this->input->post('fin'), $this->input->post('proveedor_id'));

		echo json_encode(array("status" => TRUE, "mensaje" => "Precios actualizados.", "extra" => $data));
	}

	public function consulta()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('productos/consulta',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('productos/consulta');
		$this->load->view('layout/footer');
		$this->load->view('productos/consulta-js');
		$this->load->view('layout/close');
	}

	public function dt_consulta()
    {
        $this->datatables->select('id, clave_art, clave_prov, codigo_b, descrip, precio_venta, localizacion, existencias ')
        ->from('productos')
        ->add_column('acciones', 
        '<a href="#" title="Imagen" onclick="image('."'$1'".')" class="btn btn-secondary btn-sm">Imagen</a>', 'id');
        echo $this->datatables->generate();
	}
	
	public function bajas()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('productos/bajas',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('productos/bajas');
		$this->load->view('layout/footer');
		$this->load->view('productos/bajas-js');
		$this->load->view('layout/close');
	}

	public function dt_bajas()
    {
        $this->datatables->select('id, clave_art, clave_prov, codigo_b, descrip, precio_venta, localizacion')
		->from('productos')
		->where('baja',1)
        ->add_column('acciones', '<a href="reactivar/$1" class="btn btn-secondary btn-sm">Activar</a>', 'id');
        echo $this->datatables->generate();
	}
	
	public function reactivar($id)
	{
		$id = intval($id);
		$this->load->model('Producto_model');
		$this->Producto_model->reactivar($id);
		redirect('productos/bajas', 'refresh');
	}

}
