<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movsinv_model extends CI_Model {

    protected $table = 'movsinv';

    function __construct()
    {
        parent::__construct();
    }


    public function insert($venta_id, $proceso, $origen, $destino)
    {
		$query = $this->db->query("INSERT INTO movsinv (fecha, hora, producto_id, cantidad, proceso, num_referencia, origen_id, destino_id, usuario_id)
		SELECT v.fecha, v.hora, p.producto_id, p.cantidad, '$proceso', v.folio, $origen, $destino, v.usuario_id  FROM venta AS v JOIN partventa AS p ON v.id=p.venta_id WHERE v.id=$venta_id");

		return $query;
    }

	public function insert_compra($compra_id, $proceso, $origen, $destino)
    {
		$query = $this->db->query("INSERT INTO movsinv (fecha, hora, producto_id, cantidad, proceso, num_referencia, origen_id, destino_id, usuario_id)
		SELECT v.fecha, v.hora, p.producto_id, p.cantidad, '$proceso', v.folio, $origen, $destino, v.usuario_id  FROM compra AS v JOIN partcompra AS p ON v.id=p.compra_id WHERE v.id=$compra_id");

		return $query;
    }

	public function kardex($producto_id, $almacen_id) 
	{
			$query = $this->db->query("SELECT m.id,  m.fecha, m.hora, m.fecha, m.cantidad, m.proceso, m.num_referencia, m.origen_id, m.destino_id, u.username FROM movsinv AS m JOIN users AS u ON m.usuario_id=u.id WHERE producto_id=$producto_id AND (origen_id = $almacen_id OR destino_id = $almacen_id)");
			return $query;
	}

	public function ajuste($producto, $cantidad, $origen, $destino, $usuario_id)
	{
		$data = [
			'fecha' => date('Y-m-d'),
			'hora' => date('H:i:s'),
			'producto_id' => $producto,
			'cantidad' => $cantidad,
			'proceso' => 'AJT',
			'num_referencia' => 'X00000',
			'origen_id' => $origen,
			'destino_id' => $destino,
			'usuario_id' => $usuario_id,
		];
		$this->db->insert('movsinv', $data);
	}

	public function conversion($producto, $cantidad, $origen, $destino, $usuario_id)
	{
		$data = [
			'fecha' => date('Y-m-d'),
			'hora' => date('H:i:s'),
			'producto_id' => $producto,
			'cantidad' => $cantidad,
			'proceso' => 'CON',
			'num_referencia' => 'X00000',
			'origen_id' => $origen,
			'destino_id' => $destino,
			'usuario_id' => $usuario_id,
		];
		$this->db->insert('movsinv', $data);
	}

}
