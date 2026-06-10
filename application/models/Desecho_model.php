<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Desecho_model extends CI_Model {

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
			'doc' => 'DES',
			'cliente' => 'DES ',
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
			'cliente' => strtoupper($cliente)
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

}
