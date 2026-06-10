<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashvta_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	public function ventas_grupo_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT 
		g.nombre AS grupo, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) AS cantidad, 
		-- SUM(IF(v.doc='DEV', p.cantidad*-1*a.precio_compra, p.cantidad*a.precio_compra)) AS costo,
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.costo, p.cantidad*p.costo)) AS costo,
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.precio, p.cantidad*p.precio)) AS venta
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id left join grupos g on a.grupo_id=g.id
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') 
		GROUP BY g.nombre 
		ORDER BY a.clave_art DESC;");
		return $query;
	}

	public function ventas_clientes_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT 
		c.clave, c.nombre, SUM(IF(v.doc='DEV', -1, 1)) AS partidas, 
		SUM(IF(v.doc='DEV', p.cantidad*-1*a.precio_compra, p.cantidad*a.precio_compra)) AS costo,
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.precio, p.cantidad*p.precio)) AS venta
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id 
		left join clientes as c on v.cliente_id=c.id 
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') 
		GROUP BY c.clave, c.nombre
		ORDER BY a.clave_art DESC;");
		return $query;
	}

	public function ventas_formapago_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT 
		v.pago, SUM(IF(v.doc='DEV', -1, 1)) AS partidas, 
		SUM(IF(v.doc='DEV', p.cantidad*-1*a.precio_compra, p.cantidad*a.precio_compra)) AS costo,
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.precio, p.cantidad*p.precio)) AS venta
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id 
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') 
		GROUP BY v.pago
		ORDER BY a.clave_art DESC;");
		return $query;
	}

	public function ventas_productos_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT 
		a.clave_art, a.descrip, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) AS cantidad, 
		SUM(IF(v.doc='DEV', p.cantidad*-1*a.precio_compra, p.cantidad*a.precio_compra)) AS costo,
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.precio, p.cantidad*p.precio)) AS venta
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id 
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') 
		GROUP BY a.clave_art, a.descrip 
		ORDER BY a.clave_art DESC;");
		return $query;
	}

	public function horas($inicio, $fin)
	{
		$query = $this->db->query("SELECT fecha, HOUR(hora) as h, count(*) AS num FROM venta WHERE estado='C' AND doc='VTA' AND FECHA >='$inicio' and fecha <= '$fin' group by fecha, hour(hora)");
		return $query;
	}

}
