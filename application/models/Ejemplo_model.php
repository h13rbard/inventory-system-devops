<?php 
class Ejemplo_model extends CI_Model {

	/**
	 * Ventas por mes 
	 */
	public function ventasPorMes()
	{
		$query = $this->db->query("SELECT sum(cantidad*precio) AS total, mes FROM `ventas` group by mes");
		return $query;
	}

	/**
	 * Venta mensual por vendedor
	 */
	public function ventaMensualPorVendedor($mes)
	{
		$query = $this->db->query("SELECT sum(cantidad*precio) AS total, vendedor_id, nombre FROM `ventas` join vendedores on ventas.vendedor_id=vendedores.id where mes=$mes group by vendedor_id order by total DESC");
		return $query;
	}

	public function stockAlto()
	{
		$query = $this->db->query("SELECT nombre, stock, max, stock-max AS dif FROM productos WHERE control=1 and stock > max order by dif DESC LIMIT 5");
		return $query;
	}

	public function stockBajo()
	{
		$query = $this->db->query("SELECT nombre, stock, min, min-stock AS dif FROM productos WHERE control=1 and stock < min order by dif DESC LIMIT 5");
		return $query;
	}

	public function valorInventario()
	{
		$query = $this->db->query("SELECT count(*) AS num, sum(stock*precio) AS valor from productos");
		return $query->result();
	}

	public function productosMasVendidos()
	{
		$query = $this->db->query("SELECT producto_id, SUM(ventas.precio*cantidad) as importe, nombre from ventas join productos on ventas.producto_id=productos.id where mes=12 group by nombre, producto_id order by importe DESC LIMIT 10");
		return $query;
	}

}
