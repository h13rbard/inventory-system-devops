<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tareas extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation', 'datatables'));
        $this->form_validation->set_error_delimiters('', '');
		$this->load->helper(array('url'));
	}

	// Clasificacion de productos ultimas 12 semanas
	public function prod_cant_vend()
	{
		set_time_limit(600);
		date_default_timezone_set('America/Mexico_City');

		$this->load->model('Venta_model');
		$this->load->model('Producto_model');
		$data = $this->Venta_model->productos_cant_vend(
			date('Y-m-d', strtotime("-83 days")), date('Y-m-d', strtotime("-56 days")),
			date('Y-m-d', strtotime("-55 days")), date('Y-m-d', strtotime("-28 days")),
			date('Y-m-d', strtotime("-27 days")), date('Y-m-d')
		);

		$this->Producto_model->reiniciar_minimos();
		$this->Producto_model->clasif_sin_venta();
		
		echo '<table class="table table-sm table-bordered"';
		echo '<thead><tr>';
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

	public function actualizar_ultima_venta()
	{
		set_time_limit(600);
		date_default_timezone_set('America/Mexico_City');

		$this->load->model('Producto_model');
		$this->Producto_model->actualizarUltimaVenta(date('Y-m-d'));
		echo 'Registros actualizados correctamente.';
	}
	
}
