<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Reportes extends CI_Controller {

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
		$this->permisos->check('reportes/index',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/index');
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function calc()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/calc',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/calc');
		$this->load->view('layout/footer');
		$this->load->view('reportes/calc-js');
		$this->load->view('layout/close');
	}

	public function val_inv()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/val_inv',$group_id);

		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->val_inv();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/val_inv', $data);
		$this->load->view('layout/footer');
		$this->load->view('reportes/val_inv-js');
		$this->load->view('layout/close');
	}

	public function clasificacion()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/clasificacion',$group_id);

		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->clasificacion();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/clasificacion', $data);
		$this->load->view('layout/footer');
		$this->load->view('reportes/clasificacion-js');
		$this->load->view('layout/close');
	}

	public function prod_marcas()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/prod_marcas',$group_id);

		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->por_marcas();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/marcas', $data);
		$this->load->view('layout/footer');
		$this->load->view('reportes/marcas-js');
		$this->load->view('layout/close');
	}

	public function sin_exis()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/sin_exis',$group_id);

		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->sin_exis();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/sin_exis', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function por_debajo()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/por_debajo',$group_id);
		
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/por_debajo');
		$this->load->view('layout/footer');
		$this->load->view('reportes/por_debajo-js');
		$this->load->view('layout/close');
	}

	public function ajax_por_debajo()
	{
		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->por_debajo( intval($this->input->post('porcentaje')) );

		$this->load->view('reportes/por_debajo_resultado', $data);
	}

	public function ventas()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/ventas',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/ventas');
		$this->load->view('layout/footer');
		$this->load->view('reportes/ventas-js');
		$this->load->view('layout/close');
	}

	public function ajax_ventas()
	{
		$this->load->model('Venta_model');
		$data = $this->Venta_model->ventas_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead><tr class="bg-dark"><th></th><th></th><th></th><th colspan="2" class="text-center">Costo</th><th class="text-center" colspan="2">Venta</th></tr>';
		echo '<tr class="bg-dark"><th>Clave</th><th>Descripción</th><th>Cantidad</th><th>Unitario</th><th>Importe</th>';
		echo '<th>Unitario</th><th>Importe</th></tr></thead>';
		echo '<tbody>';
		$costo_total = 0;
		$venta_total = 0;
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->cantidad,2).'</td>';
			// echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			// echo '<td class="text-right">'.number_format($item->precio_compra * $item->cantidad,2).'</td>';
			echo '<td class="text-right">'.number_format($item->costo,2).'</td>';
			echo '<td class="text-right">'.number_format($item->costo * $item->cantidad,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio * $item->cantidad,2).'</td>';
			echo '</tr>';
			$costo_total += $item->precio_compra * $item->cantidad;
			// $costo_total += $item->costo * $item->cantidad;
			$venta_total += $item->precio * $item->cantidad;
		}
		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td class="text-right" colspan="2">'.number_format($costo_total,2).'</td>';
		echo '<td class="text-right" colspan="2">'.number_format($venta_total, 2).'</td></tr>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td colspan="2">Utilidad</td><td class="text-right" colspan="2">'.number_format($venta_total - $costo_total, 2).'</td></tr>';
		echo '</tfoot>';
		echo '</table>';
	}

	public function ventas_marcas()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/ventas_marcas',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/ventas_marcas');
		$this->load->view('layout/footer');
		$this->load->view('reportes/ventas_marcas-js');
		$this->load->view('layout/close');
	}

	public function ajax_ventas_marcas()
	{
		$this->load->model('Venta_model');
		$data = $this->Venta_model->ventas_marcas_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>Proveedor</th><th>Marca</th><th>Cantidad</th><th>Costo</th><th>Venta</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		$costo_total = 0;
		$venta_total = 0;
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->proveedor.'</td>';
			echo '<td>'.$item->marca.'</td>';
			echo '<td class="text-right">'.number_format($item->cantidad,2).'</td>';
			echo '<td class="text-right">'.number_format($item->costo,2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta,2).'</td>';
			echo '</tr>';
			$costo_total += $item->costo;
			$venta_total += $item->venta;
		}
		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td class="text-right">'.number_format($costo_total,2).'</td>';
		echo '<td class="text-right">'.number_format($venta_total, 2).'</td></tr>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td>Utilidad</td><td class="text-right">'.number_format($venta_total - $costo_total, 2).'</td></tr>';
		echo '</tfoot>';
		echo '</table>';
	}

	public function ventas_grupo()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/ventas_marcas',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/ventas_grupo');
		$this->load->view('layout/footer');
		$this->load->view('reportes/ventas_grupo-js');
		$this->load->view('layout/close');
	}

	public function ajax_ventas_grupo()
	{
		$this->load->model('Venta_model');
		$data = $this->Venta_model->ventas_grupo_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>Grupo</th><th>Cantidad</th><th>Costo</th><th>Venta</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		$costo_total = 0;
		$venta_total = 0;
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->grupo.'</td>';
			echo '<td class="text-right">'.number_format($item->cantidad,2).'</td>';
			echo '<td class="text-right">'.number_format($item->costo,2).'</td>';
			echo '<td class="text-right">'.number_format($item->venta,2).'</td>';
			echo '</tr>';
			$costo_total += $item->costo;
			$venta_total += $item->venta;
		}
		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr class="bg-dark"><td></td><td></td><td class="text-right">'.number_format($costo_total,2).'</td>';
		echo '<td class="text-right">'.number_format($venta_total, 2).'</td></tr>';
		echo '<tr class="bg-dark"><td></td><td></td><td>Utilidad</td><td class="text-right">'.number_format($venta_total - $costo_total, 2).'</td></tr>';
		echo '</tfoot>';
		echo '</table>';
	}

	public function productos_vend()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/productos_vend',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/productos_vend');
		$this->load->view('layout/footer');
		$this->load->view('reportes/productos_vend-js');
		$this->load->view('layout/close');
	}

	public function ajax_productos_vend()
	{
		$this->load->model('Venta_model');
		$data = $this->Venta_model->productos_vend($this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm table-bordered table-hover datatable"';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>#</th><th>Clave</th><th>Cod. Prov.</th><th>Cod. Bar.</th><th>Descripción</th><th>Cantidad Venta</th><th>Cantidad compra</th><th>Existencias</th><th>Precio compra</th></tr></thead>';
		$i = 0;
		foreach($data->result() as $item) {
			$i++;
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->clave_prov.'</td>';
			echo '<td>'.$item->codigo_b.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->cantidad,2).'</td>';
			echo '<td class="text-right">'.number_format($item->cantidad_compra,2).'</td>';
			echo '<td class="text-right">'.number_format($item->existencias,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			echo '</tr>';
		}
		echo '</table>';

	}

	public function diff()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/diff',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/diff');
		$this->load->view('layout/footer');
		$this->load->view('reportes/diff-js');
		$this->load->view('layout/close');
	}

	public function ajax_diff()
	{
		$this->load->model('Producto_model');
		$data = $this->Producto_model->dif_costo_venta($this->input->post('diff'));
		
		echo '<table class="table table-sm table-bordered table-hover datatable"';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>#</th><th>Clave</th><th>Cod. Prov.</th><th>Cod. Bar.</th><th>Descripción</th><th>Costo</th><th>Venta</th><th>Utilidad</th></tr></thead>';
		$i = 0;
		foreach($data->result() as $item) {
			$i++;
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->clave_prov.'</td>';
			echo '<td>'.$item->codigo_b.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_venta,2).'</td>';
			echo '<td class="text-right">'.number_format($item->utilidad,2).'</td>';
			echo '</tr>';
		}
		echo '</table>';

	}


	public function prod_cant_vend()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/prod_cant_vend',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/prod_cant_vend');
		$this->load->view('layout/footer');
		$this->load->view('reportes/prod_cant_vend-js');
		$this->load->view('layout/close');
	}

	public function ajax_prod_cant_vend()
	{
		set_time_limit(600);
		date_default_timezone_set('America/Mexico_City');

		$this->load->model('Venta_model');
		$this->load->model('Producto_model');
		$data = $this->Venta_model->productos_cant_vend(
			$this->input->post('inicio1'), $this->input->post('fin1'),
			$this->input->post('inicio2'), $this->input->post('fin2'),
			$this->input->post('inicio3'), $this->input->post('fin3')
		);

		$this->Producto_model->reiniciar_minimos();
		$this->Producto_model->clasif_sin_venta();
		
		echo '<table class="table table-sm table-bordered datatable"';
		echo '<thead><tr class="bg-dark">';
		echo '<th>#</th>';
		echo '<th>Clave</th>';
		echo '<th>Clave Prov</th>';
		echo '<th>Descripción</th>';
		echo '<th>Cod-Barras</th>';
		echo '<th>Compra</th>';
		echo '<th>Venta</th>';
		echo '<th>Exis</th>';
		echo '<th>Total</th>';
		echo '<th>Cant1</th>';
		echo '<th>Cant2</th>';
		echo '<th>Cant3</th>';
		echo '<th>Clas</th>';
		echo '<th>Min</th>';
		echo '</tr></thead>';
		$n = 1;
		$clasificacion = [
			'A' => 0,
			'B' => 0,
			'BMAS' => 0,
			'BMENOS' => 0,
			'C' => 0,
			'D' => 0,
		];
		foreach($data->result() as $item) {
			$clasif = 'C';
			$class = '';
			if ($item->c1 > 0 && $item->c2 > 0 && $item->c3 > 0 ) 
			$class = 'table-primary';
			else if (($item->c1 > 0 && $item->c2 > 0) || ($item->c1 > 0 && $item->c3 > 0) || ($item->c2 > 0 && $item->c3 > 0))
			$class = 'table-success';

			if ($item->c1 > 0 && $item->c2 > 0 && $item->c3 > 0 ) 
			{ $clasif = 'A'; $clasificacion['A']++; }
			else if ($item->c1 > 0 && $item->c2 > 0 && $item->c3 <= 0 )
			{ $clasif = 'B-'; $clasificacion['BMENOS']++; }
			else if ($item->c1 <= 0 && $item->c2 > 0 && $item->c3 > 0 )
			{ $clasif = 'B+'; $clasificacion['BMAS']++; }
			else if ($item->c1 > 0 || $item->c2 > 0 || $item->c3 > 0 )
			{ $clasif = 'B'; $clasificacion['B']++; }
			else 
			{ $clasif = 'C'; $clasificacion['C']++; }

			$min = ceil(($item->c1 + $item->c2 + $item->c3)/3);

			$this->Producto_model->actualizar_minimo($item->producto_id, $min, $clasif);

			echo '<tr clasS="'.$class.'">';
			echo '<td>'.$n.'</td>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->clave_prov.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td>'.$item->codigo_b.'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_venta,2).'</td>';
			echo '<td class="text-right">'.number_format($item->existencias,2).'</td>';
			echo '<td class="text-right">'.number_format($item->total,2).'</td>';
			echo '<td class="text-right">'.number_format($item->c1,2).'</td>';
			echo '<td class="text-right">'.number_format($item->c2,2).'</td>';
			echo '<td class="text-right">'.number_format($item->c3,2).'</td>';
			echo '<td>'.$clasif.'</td>';
			echo '<td class="text-right">'.number_format($min,0).'</td>';
			echo '</tr>';
			$n++;
		}
		echo '</table>';

		echo '<br>';
		echo '<table class="table table-sm table-bordered">';
		echo '<tr><td>CLASIFICACION</td><td>ARTICULOS</td></tr>';
		echo '<tr><td>A</td><td>'.$clasificacion['A'].'</td></tr>';
		echo '<tr><td>B+</td><td>'.$clasificacion['BMAS'].'</td></tr>';
		echo '<tr><td>B-</td><td>'.$clasificacion['BMENOS'].'</td></tr>';
		echo '<tr><td>B</td><td>'.$clasificacion['B'].'</td></tr>';
		echo '<tr><td>C</td><td>'.$clasificacion['C'].'</td></tr>';
		echo '<tr><td>D</td><td>'.$clasificacion['D'].'</td></tr>';
		echo '</table>';
		// var_dump($clasificacion);
	}

	public function prod_imp_vend()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/prod_imp_vend',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/prod_imp_vend');
		$this->load->view('layout/footer');
		$this->load->view('reportes/prod_imp_vend-js');
		$this->load->view('layout/close');
	}

	public function ajax_prod_imp_vend()
	{
		$this->load->model('Venta_model');
		$data = $this->Venta_model->productos_imp_vend(
			$this->input->post('inicio1'), $this->input->post('fin1'),
			$this->input->post('inicio2'), $this->input->post('fin2'),
			$this->input->post('inicio3'), $this->input->post('fin3')
		);
		
		echo '<table class="table table-sm table-bordered datatable"';
		echo '<thead><tr class="bg-dark">';
		echo '<th>#</th>';
		echo '<th>Clave</th>';
		echo '<th>Clave Prov</th>';
		echo '<th>Descripción</th>';
		echo '<th>Cod-Barras</th>';
		echo '<th>Compra</th>';
		echo '<th>Venta</th>';
		echo '<th>Exis</th>';
		echo '<th>Total</th>';
		echo '<th>Cant1</th>';
		echo '<th>Cant2</th>';
		echo '<th>Cant3</th>';
		echo '</tr></thead>';
		$n = 1;
		foreach($data->result() as $item) {
			$class = '';
			if ($item->c1 > 0 && $item->c2 > 0 && $item->c3 > 0 ) 
			$class = 'table-primary';
			else if (($item->c1 > 0 && $item->c2 > 0) || ($item->c1 > 0 && $item->c3 > 0) || ($item->c2 > 0 && $item->c3 > 0))
			$class = 'table-success';

			echo '<tr clasS="'.$class.'">';
			echo '<td>'.$n.'</td>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->clave_prov.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td>'.$item->codigo_b.'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_venta,2).'</td>';
			echo '<td class="text-right">'.number_format($item->existencias,2).'</td>';
			echo '<td class="text-right">'.number_format($item->total,2).'</td>';
			echo '<td class="text-right">'.number_format($item->c1,2).'</td>';
			echo '<td class="text-right">'.number_format($item->c2,2).'</td>';
			echo '<td class="text-right">'.number_format($item->c3,2).'</td>';
			echo '</tr>';
			$n++;
		}
		echo '</table>';

	}

	function stock_bajo() 
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/stock_bajo',$group_id);

		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->stock_bajo();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/stock_bajo', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	function sin_stock()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/sin_stock',$group_id);

		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->sin_stock();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/sin_stock', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function por_proveedor()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/por_proveedor',$group_id);

		$this->load->model('Producto_model');
		$data['proveedores'] = $this->Producto_model->por_proveedor();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/por_proveedor', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function prec_act()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/prec_act',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/prec_act');
		$this->load->view('layout/footer');
		$this->load->view('reportes/prec_act-js');
		$this->load->view('layout/close');
	}

	public function ajax_prec_act()
	{
		$this->load->model('Producto_model');
		$data = $this->Producto_model->precio_actualizacion($this->input->post('fecha'));
		
		echo '<table class="table table-sm table-bordered datatable"';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>#</th><th>Clave</th><th>Descripción</th><th>Cantidad</th><th>Compra</th><th>Venta</th>';
		echo '<th>Actualización</th></tr></thead>';
		$i = 0;
		foreach($data->result() as $item) {
			$i++;
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->existencias,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_venta,2).'</td>';
			echo '<td class="text-right">'.$item->act_pre.'</td>';
			echo '</tr>';
		}
		echo '</table>';
	}

	public function prod_act_prec()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/prod_act_prec',$group_id);

		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->fecha_act();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/fecha_act', $data);
		$this->load->view('layout/footer');
		$this->load->view('reportes/fecha_act-js');
		$this->load->view('layout/close');
	}

	public function vtas_x_prod($id)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		
		$id = (int)$id;
		$this->load->model('Producto_model');
		$data['producto'] = $this->Producto_model->getById($id);
		$data['ventas'] = $this->Producto_model->vtas_x_prod($id);
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/vtas_x_prod', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function compras_x_prod($id)
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		
		$id = (int)$id;
		$this->load->model('Producto_model');
		$data['producto'] = $this->Producto_model->getById($id);
		$data['ventas'] = $this->Producto_model->compras_x_prod($id);
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/compras_x_prod', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function ventacobranza()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/ventacobranza',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/ventacobranza');
		$this->load->view('layout/footer');
		$this->load->view('reportes/ventacobranza-js');
		$this->load->view('layout/close');
	}

	public function ajax_ventacobranza()
	{
		$this->load->model('Venta_model');
		$data = $this->Venta_model->ventas_resumen_periodo($this->input->post('inicio'), $this->input->post('fin'));

		$this->load->model('Cobranza_model');
		$abonos = $this->Cobranza_model->abonos_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		$doc_pendientes = $this->Cobranza_model->doc_pendientes();

		$vta_con = 0;
		$vta_cre = 0;
		$dev_con = 0;
		$dev_cre = 0;
		$des = 0;
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>Doc</th><th>Tipo</th><th>Total</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->doc.'</td>';
			echo '<td>'.$item->pago.'</td>';
			echo '<td class="text-right">'.number_format($item->total,2).'</td>';
			echo '</tr>';
			$vta_con = $item->doc=='VTA' && $item->pago=='CON' ? $item->total : $vta_con;
			$vta_cre = $item->doc=='VTA' && $item->pago=='CRE' ? $item->total : $vta_cre;
			$dev_con = $item->doc=='DEV' && $item->pago=='CON' ? $item->total : $dev_con;
			$dev_cre = $item->doc=='DEV' && $item->pago=='CRE' ? $item->total : $dev_cre;
			$des = $item->doc=='DES' ? $item->total : $des;
		}
		echo '</tbody>';
		echo '</table>';
		$row = $abonos->row();
		$total_abonos = isset($row) ? $row->total : 0;
		echo '<br>';
		echo '<p><strong>Total de abonos:</strong> $ '.number_format($total_abonos, 2).'</p>';
		echo '<p><strong>Total de ventas credito:</strong> $ '.number_format($vta_cre-$dev_cre, 2).'</p>';
		echo '<p><strong>Total de ventas contado:</strong> $ '.number_format($vta_con-$dev_con, 2).'</p>';
		echo '<p><strong>Total de desecho:</strong> $ '.number_format($des, 2).'</p>';
		echo '<br>';
		// echo '<p><strong>Total en caja:</strong> $ '.number_format($total_abonos+$vta_con-$dev_con, 2).'</p>';
		
		$pend = 0;
		foreach($doc_pendientes->result() as $item)
		{
			$pend += $item->movimiento == 'C' ? $item->total : $item->total*-1;
		}
		echo '<br>';
		echo '<p><strong>Doc. pendientes:</strong> $ '.number_format($pend, 2).'</p>';
	}

	public function inventario()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/inventario',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/inventario');
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function config()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/config',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/config');
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function compras()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/ventas',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/compras');
		$this->load->view('layout/footer');
		$this->load->view('reportes/compras-js');
		$this->load->view('layout/close');
	}

	public function ajax_compras()
	{
		$this->load->model('Compra_model');
		$data = $this->Compra_model->compras_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>Clasif</th><th>Clave</th><th>Relacionado</th><th>Descripción</th><th>Cantidad</th><th>Unitario</th>';
		echo '<th>Importe</th></tr></thead>';
		echo '<tbody>';
		$compra_total = 0;
		$clasif = [
			'A' => 0,
			'B+' => 0,
			'B' => 0,
			'B-' => 0,
			'C' => 0,
			'D' => 0,
			'Otro' => 0
		];
		$n = 0;
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->clasif.'</td>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->clave_art2.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->cantidad,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio * $item->cantidad,2).'</td>';
			echo '</tr>';
			$compra_total += $item->precio * $item->cantidad;

			if (in_array( $item->clasif, ['A','B+','B','B-','C','D']) ) {
				$clasif[$item->clasif]++;
			} else {
				$clasif['Otro']++;
			}
			$n++;
		}
		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr class="bg-dark"><td></td><td></td><td></td><td></td><td></td><td></td>';
		echo '<td class="text-right">'.number_format($compra_total, 2).'</td></tr>';
		echo '</tfoot>';
		echo '</table>';
		echo '<br>';
		echo '<table class="table datatable">';
		echo '<tr class="bg-dark"><th>Clasif.</th><th>No. Productos</th><th>%</th></tr>';
		foreach($clasif as $k => $v) {
			if($n > 0) {
				echo '<tr><td>'.$k.'</td><td>'.$v.'</td><td>'.number_format(($v/$n)*100, 0).'</td></tr>';
			} else {
				echo '<tr><td>'.$k.'</td><td>'.$v.'</td><td>'.number_format(0, 0).'</td></tr>';
			}
		}
		echo '</table>';
	}

	public function sin_venta()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/sin_exis',$group_id);

		$this->load->model('Producto_model');
		$data['productos'] = $this->Producto_model->sin_venta();
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/sin_venta', $data);
		$this->load->view('layout/footer');
		$this->load->view('layout/close');
	}

	public function ult_venta()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/sin_exis',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/ult_venta');
		$this->load->view('layout/footer');
		$this->load->view('reportes/ult_venta-js');
		$this->load->view('layout/close');
	}

	public function ajax_ult_venta()
	{
		$this->load->model('Producto_model');
		$data = $this->Producto_model->ult_venta($this->input->post('fecha'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>Clave</th><th>Descripción</th><th>Costo</th><th>Venta</th><th>Existencias</th><th>Importe</th><th>Ult. Venta</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->precio_compra,2).'</td>';
			echo '<td class="text-right">'.number_format($item->precio_venta,2).'</td>';
			echo '<td class="text-right">'.number_format($item->existencias,2).'</td>';
			echo '<td class="text-right">'.number_format($item->importe,2).'</td>';
			// echo '<td>'.$item->fecha_alta.'</td>';
			echo '<td>'.$item->ult_vta.'</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}

	public function modificacion_exis()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/ventas',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/modificacion_exis');
		$this->load->view('layout/footer');
		$this->load->view('reportes/modificacion_exis-js');
		$this->load->view('layout/close');
	}

	public function ajax_modificacion_exis()
	{
		$this->load->model('Producto_model');
		$data = $this->Producto_model->modif_exis_periodo($this->input->post('inicio'), $this->input->post('fin'));
		
		echo '<table class="table table-sm datatable" id="example">';
		echo '<thead>';
		echo '<tr class="bg-dark"><th>Clave</th><th>Descripción</th><th>Original</th><th>Nuevo</th><th>Fecha</th><th>Usuario</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		
		foreach($data->result() as $item) {
			echo '<tr>';
			echo '<td>'.$item->fecha.' '.$item->hora.'</td>';
			echo '<td>'.$item->clave_art.'</td>';
			echo '<td>'.$item->descrip.'</td>';
			echo '<td class="text-right">'.number_format($item->valor_original,2).'</td>';
			echo '<td class="text-right">'.number_format($item->valor_nuevo,2).'</td>';
			echo '<td>'.$item->username.'</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}

	public function ventas_vs_compras()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/ventas',$group_id);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/ventas_vs_compras');
		$this->load->view('layout/footer');
		$this->load->view('reportes/ventas_vs_compras-js');
		$this->load->view('layout/close');
	}

	public function ajax_ventas_vs_compras()
	{
		$this->load->model('Venta_model');
		$ventas = $this->Venta_model->ventas_cantidad_periodo($this->input->post('inicio'), $this->input->post('fin'))->result_array();
		$compras = $this->Venta_model->compras_cantidad_periodo($this->input->post('inicio'), $this->input->post('fin'))->result_array();

		
		$pv = array_column($ventas, 'id');
		$pc = array_column($compras, 'id');

		$r = array_merge($pv, $pc);
		$r = array_unique($r);

		$clasifVta = ['A'=>0, 'B'=>0, 'B-'=>0, 'B+'=>0, 'C'=>0, 'D'=>0,'NA'=>0];
		$clasifCompra = ['A'=>0, 'B'=>0, 'B-'=>0, 'B+'=>0, 'C'=>0, 'D'=>0, 'NA'=>0];

		echo '<table class="table table-sm table-hover datatable" id="example">';
		echo '<thead><tr class="bg-dark"><th>id</th><th>Clasif</th><th>Clave</th><th>Descipción</th><th>Venta</th><th>Compra</th></tr></thead>';
		$s_v_c = 0;
		echo '<tbody>';
		foreach($r as $item) {
			$clave = null;
			$descrip = null;
			$cantvta = null;
			$cantcompra = null;
			$clasif =null;
			$iv = array_search($item, $pv);
			if(!is_bool($iv)) {
				$clave = $ventas[$iv]['clave_art'];
				$descrip = $ventas[$iv]['descrip'];
				$cantvta = $ventas[$iv]['cantidad'];
				$clasif = $ventas[$iv]['clasif'];
				if(array_key_exists($clasif, $clasifVta))
					$clasifVta[$clasif]++;
				else
					$clasifVta['NA']++;
			}

			$ic = array_search($item, $pc);
			if(!is_bool($ic)){
				// echo 'compra -'.$ic;
				if(is_null($clave)) {
					$clave = $compras[$ic]['clave_art'];
					$descrip = $compras[$ic]['descrip'];
					$clasif = $compras[$ic]['clasif'];
				}
				if(array_key_exists($clasif, $clasifCompra))
					$clasifCompra[$clasif]++;
				else
					$clasifVta['NA']++;
				$cantcompra = $compras[$ic]['cantidad'];
			}

			if(!is_null($cantvta) && !is_null($cantcompra))
				$s_v_c++;

			echo '<tr>';
			echo '<td>'.$item.'</td>';
			echo '<td>'.$clasif.'</td>';
			echo '<td>'.$clave.'</td>';
			echo '<td>'.$descrip.'</td>';
			echo '<td>'.(!is_null($cantvta) ? number_format($cantvta, 2) : '').'</td>';
			echo '<td>'.(!is_null($cantcompra) ? number_format($cantcompra, 2) : '').'</td>';
			echo '</tr>';
		}
		echo '<tbody>';
		echo '</table>';
		echo '<br>';
		echo 'Productos Vendidos: '.count($pv);
		echo '<br>';
		echo 'Productos Comprados: '.count($pc);
		echo '<br>';
		echo 'Total de Productos: '.count($r);
		echo '<br>';
		echo 'Productos con Venta y Compra: '.($s_v_c);
		echo '<br>';
		echo '<br>';
		echo '<table class="table table-sm table-hover table-bordered datatable">';
		$tcv = 0; $tcc = 0;
		echo '<tr class="bg-dark"><th>Clasif</th><th>Venta</th><th>Compra</th></tr>';
		foreach($clasifVta as $k=>$item) {
			echo '<tr>';
			echo '<td>'.$k.'</td>';
			echo '<td class="text-right">'.$clasifVta[$k].'</td>';
			echo '<td class="text-right">'.$clasifCompra[$k].'</td>';
			echo '</tr>';
			$tcv += $clasifVta[$k];
			$tcc += $clasifCompra[$k];
		}
		echo '<tr class="bg-dark"><td>Total</td><td class="text-right">'.$tcv.'</td><td class="text-right">'.$tcc.'</td></tr>';
		echo '</table>';

	}

	public function parecidas()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('reportes/index',$group_id);
		
		$this->load->model('Producto_model');
		$data = $this->Producto_model->claves_parecidas();
		
		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('reportes/parecidas',['data' => $data]);
		$this->load->view('layout/footer');
		$this->load->view('reportes/parecidas-js');
		$this->load->view('layout/close');
	}

}
