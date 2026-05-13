<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Venta_model extends CI_Model {

    protected $table = 'venta';

    function __construct()
    {
        parent::__construct();
    }
    
    public function insert($noReferencia, $usuario_id)
    {
		$data = array(
            'fecha' => date("Y-m-d"),
			'hora' => date("H:i:s"),
			'estado' => 'P',
			'total' => 0,
			'folio' => '',
			'doc' => 'VTA',
			'cliente' => 'PUBLICO EN GENERAL',
			'folio' => $noReferencia,
			'usuario_id' => $usuario_id
        );
		$this->db->insert($this->table, $data);
		
		$id = $this->db->insert_id();

		// $folio = array(
		// 	'folio' => str_pad($id, 6, "0", STR_PAD_LEFT)
		// );

		// $this->db->where('id', $id);
		// $this->db->update($this->table, $folio);
		return $id;
    }

    public function update($id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $this->getData());
    }

    public function existeNombre($id, $valor, $categoria_id)
    {
		$this->db->where('nombre', $valor);
		$this->db->where('categoria_id', $categoria_id);
        $this->db->where('id <>', $id);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getById($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

	public function insert_partida($producto,$venta_id)
	{
		$data = array(
            'producto_id' => $producto->id,
			'cantidad' => 1,
			'precio' => $producto->precio_venta,
			'venta_id' => $venta_id
        );
		$this->db->insert('partventa', $data);
		return $this->db->insert_id();
	}

	public function getPartidas($venta_id)
	{
		$query = $this->db->query("SELECT p.id, p.producto_id, d.clave_art, d.descrip, p.precio, p.cantidad FROM partventa AS p JOIN productos AS d ON p.producto_id=d.id WHERE p.venta_id=".$venta_id);
		return $query;
	}

	public function setTotalVenta($venta_id, $total)
	{
		$data = array(
			'total' => $total
		);

		$this->db->where('id', $venta_id);
		$this->db->update($this->table, $data);
	}

	public function getTotalVenta($venta_id)
	{
		$query = $this->db->query("SELECT SUM(precio*cantidad) AS total FROM partventa WHERE venta_id=".$venta_id);

		$row = $query->row();
		return (float)$row->total;
	}

	public function getEstado($venta_id)
	{
		$query = $this->db->query("SELECT estado FROM venta WHERE id=".$venta_id);

		$row = $query->row();
		return $row->estado;
	}

	public function deletePartida($partida_id, $venta_id)
	{
		$this->db->where('id', $partida_id);
		$this->db->delete('partventa');
	}

	public function updateCantidadPartida($id, $cantidad)
	{
		$data = array(
			'cantidad' => $cantidad
		);

		$this->db->where('id', $id);
		$this->db->update('partventa', $data);
	}

	public function getPartidaByProductoId($id, $producto_id)
    {
        $this->db->from('partventa');
		$this->db->where('producto_id',$producto_id);
		$this->db->where('venta_id',$id);
        $query = $this->db->get();
        return $query->row();
	}
	
	public function CerrarEncabezado($id)
	{
        $this->db->where('id', $id);
        $this->db->update($this->table, array(
			'estado' => 'C',
			'fecha' => date("Y-m-d"),
			'hora' => date("H:i:s"),
		));
	}

	public function DescontarExistencia($venta_id)
	{
		$query = $this->db->query("UPDATE productos as a ".
		"JOIN partventa AS p ON a.id=p.producto_id ".
		"JOIN venta AS v ON p.venta_id=v.id ".
		"SET existencias=(existencias-p.cantidad) ".
		"WHERE v.id=".$venta_id." and estado='P'");
	}

	public function AgregarCosto($venta_id)
	{
		$query = $this->db->query("UPDATE partventa as p ".
		"JOIN productos AS a ON a.id=p.producto_id ".
		"JOIN venta AS v ON p.venta_id=v.id ".
		"SET p.costo=(a.precio_compra) ".
		"WHERE v.id=".$venta_id." and estado='C'");
	}

	public function checarExistencias($venta_id)
	{
		$query = $this->db->query("SELECT p.venta_id, p.id, p.producto_id, a.clave_art, a.descrip, p.cantidad, a.existencias, (a.existencias-p.cantidad) AS sin_exis ".
		"FROM venta AS v JOIN partventa AS p ON v.id=p.venta_id ".
		"JOIN productos AS a ON p.producto_id=a.id ".
		"WHERE v.id=".$venta_id." and estado='P' AND ((a.existencias-p.cantidad))<0 ");
		return $query;
	}

	public function updateCliente($venta_id, $cliente)
	{
		$data = array(
			'cliente' => mb_strtoupper($cliente)
		);

		$this->db->where('id', $venta_id);
		$this->db->where('estado', 'P');
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function cambiarCliente($venta_id, $cliente_id, $nombre)
	{
		if ($cliente_id == 1) {
			$data = array(
				'cliente_id' => $cliente_id,
				'cliente' => $nombre,
				'pago' => 'CON'
			);
		} else {
			$data = array(
				'cliente_id' => $cliente_id,
				'cliente' => $nombre,
			);
		}	 

		$this->db->where('id', $venta_id);
		$this->db->where('estado', 'P');
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function updatePago($venta_id, $pago)
	{
		$data = array(
			'pago' => strtoupper($pago)
		);

		$this->db->where('id', $venta_id);
		$this->db->where('estado', 'P');
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function ventas_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT a.clave_art, a.descrip, a.precio_compra, IF(v.doc='DEV', p.cantidad*-1, p.cantidad) as cantidad, p.precio, p.costo 
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id 
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') ORDER BY a.clave_art DESC;");
		return $query;
	}

	public function ventas_resumen_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT doc, pago, SUM(total) As total
		FROM venta AS v
		WHERE v.doc IN ('VTA', 'DEV', 'DES') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') GROUP BY doc, pago ORDER BY pago");
		return $query;
	}

	public function ventas_marcas_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT 
		pr.nombre AS proveedor, a.marca As marca, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) AS cantidad, 
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.costo, p.cantidad*p.costo)) AS costo,
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.precio, p.cantidad*p.precio)) AS venta
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id join proveedores pr on a.proveedor_id=pr.id
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') 
		GROUP BY pr.nombre, a.marca
		ORDER BY a.clave_art DESC;");
		return $query;
	}

	public function ventas_grupo_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT 
		g.nombre AS grupo, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) AS cantidad, 
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.costo, p.cantidad*p.costo)) AS costo,
		SUM(IF(v.doc='DEV', p.cantidad*-1*p.precio, p.cantidad*p.precio)) AS venta
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id left join grupos g on a.grupo_id=g.id
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') 
		GROUP BY g.nombre 
		ORDER BY a.clave_art DESC;");
		return $query;
	}

	public function productos_vend($inicio, $fin)
	{
		$query = $this->db->query("SELECT a.id, a.clave_art, a.clave_prov, a.codigo_b, a.descrip, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) as cantidad, a.cantidad as cantidad_compra, a.existencias, a.precio_compra
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id 
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') GROUP BY a.id ORDER BY cantidad DESC;");
		return $query;
	}

	public function productos_cant_vend($ini1, $fin1, $ini2, $fin2, $ini3, $fin3)
	{
		$stm = "SELECT T.producto_id, T.cantidad as total, T.clave_art, T.descrip, T.clave_prov, T.codigo_b, T.precio_compra, T.precio_venta, T.existencias, COALESCE(T1.cantidad,0) as c1, COALESCE(T2.cantidad,0) as c2, COALESCE(T3.cantidad,0) as c3  
		FROM 
		(SELECT p.producto_id, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) as cantidad, a.descrip, a.clave_art, a.clave_prov, a.codigo_b, a.precio_compra, a.precio_venta, a.existencias  
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id
		WHERE v.doc IN ('VTA', 'DEV') 
		AND v.estado='C' AND (v.fecha>='$ini1' AND v.fecha<='$fin3') GROUP BY p.producto_id ) AS T
		LEFT JOIN 
		(SELECT p.producto_id, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) as cantidad 
		FROM partventa as p join venta as v on p.venta_id=v.id WHERE v.doc IN ('VTA', 'DEV') 
		AND v.estado='C' AND (v.fecha>='$ini1' AND v.fecha<='$fin1') GROUP BY p.producto_id ) AS T1
		ON T.producto_id = T1.producto_id
		LEFT JOIN
		(SELECT p.producto_id, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) as cantidad 
		FROM partventa as p join venta as v on p.venta_id=v.id WHERE v.doc IN ('VTA', 'DEV') 
		AND v.estado='C' AND (v.fecha>='$ini2' AND v.fecha<='$fin2') GROUP BY p.producto_id ) AS T2
		ON T.producto_id = T2.producto_id
		LEFT JOIN
		(SELECT p.producto_id, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) as cantidad 
		FROM partventa as p join venta as v on p.venta_id=v.id WHERE v.doc IN ('VTA', 'DEV') 
		AND v.estado='C' AND (v.fecha>='$ini3' AND v.fecha<='$fin3') GROUP BY p.producto_id ) AS T3
		ON T.producto_id = T3.producto_id
		ORDER BY T.cantidad DESC";
		$query = $this->db->query($stm);
		return $query;
	}

	public function productos_imp_vend($ini1, $fin1, $ini2, $fin2, $ini3, $fin3)
	{
		$stm = "SELECT T.producto_id, T.cantidad as total, T.clave_art, T.descrip, T.clave_prov, T.codigo_b, T.precio_compra, T.precio_venta, T.existencias, COALESCE(T1.cantidad,0) as c1, COALESCE(T2.cantidad,0) as c2, COALESCE(T3.cantidad,0) as c3  
		FROM 
		(SELECT p.producto_id, SUM(IF(v.doc='DEV', p.cantidad*p.precio*-1, p.cantidad*p.precio)) as cantidad, a.descrip, a.clave_art, a.clave_prov, a.codigo_b, a.precio_compra, a.precio_venta, a.existencias   
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id
		WHERE v.doc IN ('VTA', 'DEV') 
		AND v.estado='C' AND (v.fecha>='$ini1' AND v.fecha<='$fin3') GROUP BY p.producto_id ) AS T
		LEFT JOIN 
		(SELECT p.producto_id, SUM(IF(v.doc='DEV', p.cantidad*p.precio*-1, p.cantidad*p.precio)) as cantidad 
		FROM partventa as p join venta as v on p.venta_id=v.id WHERE v.doc IN ('VTA', 'DEV') 
		AND v.estado='C' AND (v.fecha>='$ini1' AND v.fecha<='$fin1') GROUP BY p.producto_id ) AS T1
		ON T.producto_id = T1.producto_id
		LEFT JOIN
		(SELECT p.producto_id, SUM(IF(v.doc='DEV', p.cantidad*p.precio*-1, p.cantidad*p.precio)) as cantidad 
		FROM partventa as p join venta as v on p.venta_id=v.id WHERE v.doc IN ('VTA', 'DEV') 
		AND v.estado='C' AND (v.fecha>='$ini2' AND v.fecha<='$fin2') GROUP BY p.producto_id ) AS T2
		ON T.producto_id = T2.producto_id
		LEFT JOIN
		(SELECT p.producto_id, SUM(IF(v.doc='DEV', p.cantidad*p.precio*-1, p.cantidad*p.precio)) as cantidad 
		FROM partventa as p join venta as v on p.venta_id=v.id WHERE v.doc IN ('VTA', 'DEV') 
		AND v.estado='C' AND (v.fecha>='$ini3' AND v.fecha<='$fin3') GROUP BY p.producto_id ) AS T3
		ON T.producto_id = T3.producto_id
		ORDER BY T.cantidad DESC";
		$query = $this->db->query($stm);
		return $query;
	}

	public function ventas_cantidad_periodo($inicio, $fin)
	{
		$stm = "SELECT a.id, a.clasif, a.clave_art, a.descrip, SUM(IF(v.doc='DEV', p.cantidad*-1, p.cantidad)) as cantidad
		FROM partventa as p join venta as v on p.venta_id=v.id join productos as a on p.producto_id=a.id 
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin')
		GROUP BY a.id, a.clave_art, a.descrip 
		ORDER BY a.id";
		$query = $this->db->query($stm);
		return $query;
	}

	public function compras_cantidad_periodo($inicio, $fin)
	{
		$stm = "SELECT a.id, a.clasif, a.clave_art, a.descrip, SUM( pc.cantidad) as cantidad
		FROM partcompra as pc join compra as c on pc.compra_id=c.id join productos as a on pc.producto_id=a.id 
		WHERE c.estado='C' AND (c.fecha>='$inicio' AND c.fecha<='$fin') 
		GROUP BY a.id, a.clave_art, a.descrip
		ORDER BY a.id";
		$query = $this->db->query($stm);
		return $query;
	}

}
