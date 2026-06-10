<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejemplo extends CI_Controller {

	public function index()
	{
		$this->load->model('Ejemplo_model');

		$ventasPorMes = $this->Ejemplo_model->ventasPorMes();

		$ventasMes = '';
		$total = 0;
		foreach($ventasPorMes->result() as $row) {
			$ventasMes.=$row->total.', ';
			$total += $row->total;
		}
		$data['ventasMes'] = $ventasMes;
		$data['ventaMensualPromedio'] = round( $total / 12, 2);
		$data['ventasDic'] = $ventasPorMes->result()[11]->total;

		$data['ventasPorVendedor'] = $this->Ejemplo_model->ventaMensualPorVendedor(12);
		$data['metaVendedor'] = 80000;

		$data['vchrPie'] = '';
		foreach($data['ventasPorVendedor']->result() as $row) {
			$data['vchrPie'] .= "{name: '$row->nombre', y: $row->total},";
		}

		$this->load->view('layout/header');
		$this->load->view('ejemplo/ventas', $data);
		$this->load->view('layout/footer');
		$this->load->view('ejemplo/ventas-js', $data);
		$this->load->view('layout/close');
	}

	public function inventario()
	{
		$this->load->model('Ejemplo_model');
		$data['inv'] = $this->Ejemplo_model->valorInventario();

		$ventasPorMes = $this->Ejemplo_model->productosMasVendidos();

		$ventasMes = '';
		$productos = '';
		foreach($ventasPorMes->result() as $row) {
			$ventasMes.=$row->importe.', ';
			$productos.="'".$row->nombre."'".', ';
		}
		$data['ventasMes'] = $ventasMes;
		$data['productos'] = $productos;

		$this->load->view('layout/header');
		$this->load->view('ejemplo/inventario', $data);
		$this->load->view('layout/footer');
		$this->load->view('ejemplo/inventario-js');
		$this->load->view('layout/close');
	}

	public function dt_productos()
	{
		$this->load->library('Datatables');
		$this->datatables->select('nombre, precio, stock');
		$this->datatables->from('productos');
		echo $this->datatables->generate('json', 'ISO-8859-1');
	}

	public function stock_bajo()
	{
		$this->load->model('Ejemplo_model');
		$productos = $this->Ejemplo_model->stockBajo();
		echo json_encode($productos->result());
	}

	public function stock_alto()
	{
		$this->load->model('Ejemplo_model');
		$productos = $this->Ejemplo_model->stockAlto();
		echo json_encode($productos->result());
	}

}
