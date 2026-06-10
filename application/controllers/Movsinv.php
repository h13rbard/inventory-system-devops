<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movsinv extends CI_Controller {

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
		$this->permisos->check('movsinv/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('movsinv/index');
		$this->load->view('layout/footer');
		$this->load->view('movsinv/index-js');
		$this->load->view('layout/close');
	}

	public function datatable()
    {
        $this->datatables->select('id, clave_art, clave_prov, codigo_b, descrip, precio_venta, localizacion')
        ->from('productos')
        ->add_column('acciones', 
		'<a href="../movsinv/kardex/'."$1".'" target=”_blank” title="Editar" class="btn btn-secondary btn-sm">Kardex</a> '
		, 'id');
		echo $this->datatables->generate();
	}
	
	public function kardex($id)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('movsinv/kardex',$group_id);
		
		$id = (int)$id;
		$this->load->model('Producto_model');
		$data['producto'] = $this->Producto_model->getById($id);
		$this->load->model('Almacen_model');
		$data['almacenes'] = $this->Almacen_model->getAll();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('movsinv/kardex', $data);
		$this->load->view('layout/footer');
		$this->load->view('movsinv/kardex-js');
		$this->load->view('layout/close');
	}

	public function ajax_kardex()
	{
		$this->load->model('Movsinv_model');
		$kardex = $this->Movsinv_model->kardex( intval($this->input->post('id')), intval($this->input->post('almacen_id')) );
		$almacen = $this->input->post('almacen_id');
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead><tr class="bg-dark"><th></th><th>Documento</th><th>Fecha</th><th>Usuario</th><th>Entrada</th><th>Salida</th></tr></thead>';
		$entradas = 0;
		$salidas = 0;
		echo '<tbody>';
		foreach($kardex->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->id.'</td>';
			echo '<td>'.$item->proceso.' '.$item->num_referencia.'</td>';
			echo '<td>'.$item->fecha.' '.$item->hora.'</td>';
			echo '<td>'.$item->username.'</td>';
			echo '<td class="text-right">'.($item->destino_id == $almacen ? $item->cantidad : '').'</td>';
			echo '<td class="text-right">'.($item->origen_id == $almacen ? $item->cantidad : '').'</td>';
			echo '</tr>';
			$entradas += $item->destino_id == $almacen ? $item->cantidad : 0;
			$salidas += $item->origen_id == $almacen ? $item->cantidad : 0;
		}
		echo '<tbody>';
		echo '<tfoot>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td>TOTAL</td><td class="text-right">'.number_format($entradas, 2).'</td><td class="text-right">'.number_format($salidas, 2).'</td></tr>';
		echo '</tfoot>';
		echo '</table>';
	}

	public function conversion()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('movsinv/conversion',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('movsinv/conversion');
		$this->load->view('layout/footer');
		$this->load->view('movsinv/conversion-js');
		$this->load->view('layout/close');
	}

	public function ajax_conversion()
	{
		$clave1 =  $this->input->post('producto1');
		$clave2 =  $this->input->post('producto2');
		$cantidad1 =  floatval( $this->input->post('cantidad1') );
		$cantidad2 =  floatval($this->input->post('cantidad2'));
		$operador =  intval($this->input->post('operador'));

		$this->load->model('Producto_model');

		$prod1 = $this->Producto_model->getByClave($clave1);
		$prod2 = $this->Producto_model->getByClave($clave2);

		if ($cantidad1 <= 0) {
			echo 'La cantidad del producto '.$clave1.' debe ser mayor a 0.';
			exit;
		}
		if ($cantidad2 <= 0) {
			echo 'La cantidad del producto '.$clave1.' debe ser mayor a 0.';
			exit;
		}

		if (is_null($prod1)) {
			echo 'El producto '.$clave1.' no fue encontrado.';
			exit;
		}
		if (is_null($prod2)) {
			echo 'El producto '.$clave2.' no fue encontrado.';
			exit;
		}

		if ($prod1->existencias <= 0) {
			echo 'El producto '.$prod1->clave_art.' no tiene existencias.';
			exit;
		}
		// if ($prod2->existencias <= 0) {
		// 	echo 'El producto '.$prod2->clave_art.' no tiene existencias.';
		// 	exit;
		// }
		
		$nueva_cant1 = 0;
		$nueva_cant2 = ($operador == 1) ?  (($prod1->existencias / $cantidad1) * $cantidad2) : (($prod1->existencias / $cantidad1 ) / $cantidad2);

		$costo1 = ($prod1->precio_compra * $prod1->existencias) / $nueva_cant2;
		$costo2 = $prod2->precio_compra;

		$nuevo_costo = (($costo1 * $nueva_cant2) + ($costo2 *  $prod2->existencias)) / ($prod2->existencias + $nueva_cant2);

		echo '<form action="" id="form-confirmar">'; 
		echo '<input type="hidden" name="producto1" value="'.$clave1.'">';
		echo '<input type="hidden" name="producto2" value="'.$clave2.'">';
		echo '<input type="hidden" name="cantidad1" value="'.$cantidad1.'">';
		echo '<input type="hidden" name="cantidad2" value="'.$cantidad2.'">';
		echo '<input type="hidden" name="operador" value="'.$operador.'">';
		echo '<table class="table table-sm datatable">';
		echo '<tr class="bg-dark"><td>CLAVE</td><td>DESCRIPCION</td><td>EXISTENCIAS</td><td>NUEVA CANTIDAD</td><td>COSTO</td></tr>';
		echo '<tr>';
		echo '<td>'.$prod1->clave_art.'</td><td>'.$prod1->descrip.'</td><td>'.$prod1->existencias.'</td><td>'.number_format($nueva_cant1, 2).'</td><td>'.$prod1->precio_compra.'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>'.$prod2->clave_art.'</td><td>'.$prod2->descrip.'</td><td>'.$prod2->existencias.'</td><td>'.number_format($nueva_cant2 + $prod2->existencias, 2).'</td><td>'.$prod2->precio_compra.'</td>';
		echo '</tr>';
		echo '</tr>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td>Nuevo Costo</td><td>'.number_format($nuevo_costo, 6).'</td></tr>';
		echo '<tr class="bg-dark"><td></td><td colspan="2" class="text-right">Cantidad a convertir</td><td><input type="number" class="form-control form-control-sm" name="cant_conver" required value="'.$prod1->existencias.'"></td><td><button class="btn btn-sm btn-primary" onclick="confirmar()" type="button" id="btnConfirmar">Confirmar</buitton></td></tr>';
		echo '</table>';
		echo '</form>';
	}

	public function ajax_confirmar() 
	{
		$clave1 =  $this->input->post('producto1');
		$clave2 =  $this->input->post('producto2');
		$cantidad1 =  floatval( $this->input->post('cantidad1') );
		$cantidad2 =  floatval($this->input->post('cantidad2'));
		$operador =  intval($this->input->post('operador'));
		$cant_conver =  floatval($this->input->post('cant_conver'));

		$this->load->model('Producto_model');

		$prod1 = $this->Producto_model->getByClave($clave1);
		$prod2 = $this->Producto_model->getByClave($clave2);

		if ($cantidad1 <= 0) {
			echo 'La cantidad del producto '.$clave1.' debe ser mayor a 0.';
			exit;
		}
		if ($cantidad2 <= 0) {
			echo 'La cantidad del producto '.$clave1.' debe ser mayor a 0.';
			exit;
		}

		if (is_null($prod1)) {
			echo 'El producto '.$clave1.' no fue encontrado.';
			exit;
		}
		if (is_null($prod2)) {
			echo 'El producto '.$clave2.' no fue encontrado.';
			exit;
		}

		if ($prod1->existencias <= 0) {
			echo 'El producto '.$prod1->clave_art.' no tiene existencias.';
			exit;
		}
		if ($cant_conver <= 0) {
			echo 'La cantidad a convertir debe de ser mayor 0.';
			exit;
		}
		
		$nueva_cant1 = $prod1->existencias - $cant_conver;
		$nueva_cant2 = ($operador == 1) ?  (($cant_conver / $cantidad1) * $cantidad2) : (($cant_conver / $cantidad1 ) / $cantidad2);

		$costo1 = ($prod1->precio_compra * $cant_conver) / $nueva_cant2;
		$costo2 = $prod2->precio_compra;

		$nuevo_costo = (($costo1 * $nueva_cant2) + ($costo2 *  $prod2->existencias)) / ($prod2->existencias + $nueva_cant2);

		echo '<form action="" id="form-confirmar">'; 
		echo '<input type="hidden" name="producto1" value="'.$clave1.'">';
		echo '<input type="hidden" name="producto1" value="'.$clave2.'">';
		echo '<input type="hidden" name="cantidad1" value="'.$cantidad1.'">';
		echo '<input type="hidden" name="cantidad2" value="'.$cantidad2.'">';
		echo '<input type="hidden" name="operador" value="'.$operador.'">';
		echo '<table class="table table-sm datatable">';
		echo '<tr class="bg-dark"><td>CLAVE</td><td>DESCRIPCION</td><td>EXISTENCIAS</td><td>NUEVA CANTIDAD</td><td>COSTO</td></tr>';
		echo '<tr>';
		echo '<td>'.$prod1->clave_art.'</td><td>'.$prod1->descrip.'</td><td>'.$prod1->existencias.'</td><td>'.number_format($nueva_cant1, 2).'</td><td>'.$prod1->precio_compra.'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>'.$prod2->clave_art.'</td><td>'.$prod2->descrip.'</td><td>'.$prod2->existencias.'</td><td>'.number_format($nueva_cant2 + $prod2->existencias, 2).'</td><td>'.$prod2->precio_compra.'</td>';
		echo '</tr>';
		echo '</tr>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td>Nuevo Costo</td><td>'.number_format($nuevo_costo, 6).'</td></tr>';
		echo '</table>';
		echo '</form>';

		$this->load->model('Movsinv_model');
		$this->Movsinv_model->conversion($prod1->id, $cant_conver, 1, 6, $this->ion_auth->user()->row()->id);
		$this->Movsinv_model->conversion($prod2->id, $nueva_cant2, 6, 1, $this->ion_auth->user()->row()->id);

		$this->Producto_model->updateCantidad($prod1->id, $nueva_cant1);
		$this->Producto_model->updateCostoCantidad($prod2->id, $nuevo_costo, $nueva_cant2 + $prod2->existencias);
		
	}

}
