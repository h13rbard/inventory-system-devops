<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Compra_model extends CI_Model {

    protected $table = 'compra';

    function __construct()
    {
        parent::__construct();
    }
    
    public function insert($folio, $proveedor_id, $proveedor, $fecha_compra, $no_referencia, $usuario_id)
    {
		$data = array(
            'fecha' => date("Y-m-d"),
			'hora' => date("H:i:s"),
			'estado' => 'P',
			'total' => 0,
			'folio' => '',
			'doc' => 'COM',
			'proveedor' => $proveedor,
			'proveedor_id' => $proveedor_id,
			'folio' => $folio,
			'no_referencia' => $no_referencia,
			'fecha_compra' => $fecha_compra,
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

    public function getById($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

	public function getByFolio($folio)
    {
        $this->db->from($this->table);
        $this->db->where('folio',$folio);
        $query = $this->db->get();
        return $query->row();
    }

	public function insert_partida($producto,$compra_id)
	{
		$data = array(
            'producto_id' => $producto->id,
			'cantidad' => 1,
			'precio' => $producto->precio_compra, // precio q captura el usuario de compra
			'compra_id' => $compra_id
        );
		$this->db->insert('partcompra', $data);
		return $this->db->insert_id();
	}

	public function getPartidas($compra_id)
	{
		$query = $this->db->query("SELECT p.id, p.producto_id, d.clave_art, d.descrip, p.precio, p.cantidad FROM partcompra AS p JOIN productos AS d ON p.producto_id=d.id WHERE p.compra_id=".$compra_id);
		return $query;
	}

	public function setTotalCompra($compra_id, $total)
	{
		$data = array(
			'total' => $total
		);

		$this->db->where('id', $compra_id);
		$this->db->update($this->table, $data);
	}

	public function getTotalCompra($compra_id)
	{
		$query = $this->db->query("SELECT SUM(precio*cantidad) AS total FROM partcompra WHERE compra_id=".$compra_id);

		$row = $query->row();
		return (float)$row->total;
	}

	public function getEstado($compra_id)
	{
		$query = $this->db->query("SELECT estado FROM compra WHERE id=".$compra_id);

		$row = $query->row();
		return $row->estado;
	}

	public function deletePartida($partida_id, $compra_id)
	{
		$this->db->where('id', $partida_id);
		$this->db->delete('partcompra');
	}

	public function updateCantidadPartida($id, $cantidad)
	{
		$data = array(
			'cantidad' => $cantidad
		);

		$this->db->where('id', $id);
		$this->db->update('partcompra', $data);
	}

	public function updatePrecioPartida($id, $precio)
	{
		$data = array(
			'precio' => $precio
		);

		$this->db->where('id', $id);
		$this->db->update('partcompra', $data);
	}

	public function getPartidaByProductoId($id, $producto_id)
    {
        $this->db->from('partcompra');
		$this->db->where('producto_id',$producto_id);
		$this->db->where('compra_id',$id);
        $query = $this->db->get();
        return $query->row();
	}
	
	public function CerrarEncabezado($id)
	{
        $this->db->where('id', $id);
        $this->db->update($this->table, array(
			'estado' => 'C',
			'fecha_confirmacion' => date("Y-m-d")
		));
	}

	public function SumarExistencia($compra_id)
	{
		$query = $this->db->query("UPDATE productos as a ".
		"JOIN partcompra AS p ON a.id=p.producto_id ".
		"JOIN compra AS v ON p.compra_id=v.id ".
		"SET existencias=(existencias+p.cantidad), a.precio_compra=((a.existencias*a.precio_compra)+(p.precio*p.cantidad))/(a.existencias+p.cantidad), a.iva_uni=a.precio_uni, a.precio_uni=p.precio ".
		"WHERE v.id=".$compra_id." and estado='P'");
	}

	public function checarExistencias($compra_id)
	{
		$query = $this->db->query("SELECT p.compra_id, p.id, p.producto_id, a.clave_art, a.descrip, p.cantidad, a.existencias, (a.existencias-p.cantidad) AS sin_exis ".
		"FROM compra AS v JOIN partcompra AS p ON v.id=p.compra_id ".
		"JOIN productos AS a ON p.producto_id=a.id ".
		"WHERE v.id=".$compra_id." and estado='P' AND ((a.existencias-p.cantidad))<0 ");
		return $query;
	}

	public function updateProveedor($compra_id, $proveedor)
	{
		$data = array(
			'proveedor' => strtoupper($proveedor)
		);

		$this->db->where('id', $compra_id);
		$this->db->where('estado', 'P');
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function updateNoReferencia($compra_id, $no_referencia)
	{
		$data = array(
			'no_referencia' => strtoupper($no_referencia)
		);

		$this->db->where('id', $compra_id);
		$this->db->where('estado', 'P');
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function updateFechacompra($compra_id, $fecha_compra)
	{
		$data = array(
			'fecha_compra' => strtoupper($fecha_compra)
		);

		$this->db->where('id', $compra_id);
		$this->db->where('estado', 'P');
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function cambiarProveedor($compra_id, $proveedor_id, $nombre)
	{
		if ($proveedor_id == 1) {
			$data = array(
				'proveedor_id' => $proveedor_id,
				'proveedor' => $nombre,
				'pago' => 'CON'
			);
		} else {
			$data = array(
				'proveedor_id' => $proveedor_id,
				'proveedor' => $nombre,
			);
		}	 

		$this->db->where('id', $compra_id);
		$this->db->where('estado', 'P');
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function updatePago($compra_id, $pago)
	{
		$data = array(
			'pago' => strtoupper($pago)
		);

		$this->db->where('id', $compra_id);
		$this->db->where('estado', 'P');
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function getPartidasActualizar($compra_id)
	{
		$query = $this->db->query("SELECT p.id, p.producto_id, d.clave_art, d.descrip, p.precio, p.cantidad, d.precio_compra, d.precio_uni, d.iva_uni, d.precio_venta FROM partcompra AS p JOIN productos AS d ON p.producto_id=d.id WHERE p.compra_id=".$compra_id);
		return $query;
	}

	public function compras_resumen_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT SUM(total) AS total FROM compra WHERE estado='C' AND (fecha_confirmacion>='$inicio' AND fecha_confirmacion<='$fin')");
		return $query;
	}

	public function compras_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT a.clave_art, b.clave_art as clave_art2, a.descrip, p.precio, p.cantidad, v.folio, a.clasif  
		FROM partcompra as p join compra as v on p.compra_id=v.id join productos as a on p.producto_id=a.id
		left join relacionados r on a.id=r.producto1_id
		left join productos b on r.producto2_id=b.id 
		WHERE v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') ORDER BY a.clave_art DESC;");
		return $query;
	}

}
