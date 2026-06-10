<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Cobranza_model extends CI_Model {

    protected $table = 'cobranza';

    function __construct()
    {
        parent::__construct();
	}
	
	public function rules()
    {
		$this->form_validation->set_rules('movimiento', 'Movimiento', 'trim|required|max_length[1]');
		$this->form_validation->set_rules('cliente', 'cliente', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('importe', 'Importe', 'trim|required|numeric');
    }

    public function getData()
    {
        $data = array(
			'movimiento' => strtoupper($this->input->post('movimiento')),
			'cliente' => mb_strtoupper($this->input->post('cliente')),
			'concepto' => mb_strtoupper($this->input->post('concepto')),
			'importe' => strtoupper($this->input->post('importe')),
			'venta_id' => strtoupper($this->input->post('venta_id')),
			'cliente_id' => strtoupper($this->input->post('cliente_id')),
			'fecha' => date("Y-m-d"),
			'hora' => date("H:i:s"),
			'no_referencia' => 'EF',
			'estado' => 'P'
        );
        return $data;
    }

	public function insert($importe, $venta_id, $no_referencia, $cliente, $cliente_id)
    {
		$data = array(
            'fecha' => date("Y-m-d"),
			'hora' => date("H:i:s"),
			'estado' => 'P',
			'importe' => $importe,
			'saldo' => $importe,
			'no_referencia' => $no_referencia,
			'movimiento' => 'C',
			'venta_id' => $venta_id,
			'cliente' => $cliente,
			'cliente_id' => $cliente_id,
			'concepto' => 'VTA'
        );
		$this->db->insert($this->table, $data);		
	}
	
	public function getMovimientos($venta_id)
	{
		$query = $this->db->query("SELECT * FROM cobranza WHERE venta_id=".$venta_id);
		return $query;
	}

	public function insertMovimiento()
    {
		$data = $this->getData();
        $this->db->insert($this->table, $data);
	}

	public function insertMovimiento2($cliente, $importe, $venta_id, $cliente_id)
    {
		$data = array(
			'movimiento' => strtoupper('A'),
			'cliente' => strtoupper($cliente),
			'concepto' => strtoupper('EFE'),
			'importe' => strtoupper($importe),
			'venta_id' => strtoupper($venta_id),
			'cliente_id' => strtoupper($cliente_id),
			'fecha' => date("Y-m-d"),
			'hora' => date("H:i:s"),
			'no_referencia' => 'EF',
			'estado' => 'P'
        );
        $this->db->insert($this->table, $data);
	}
	
	public function getSaldo($venta_id)
	{
		$query = $this->db->query("SELECT SUM(IF(movimiento='C', importe, importe*-1)) AS saldo FROM cobranza WHERE VENTA_ID=$venta_id GROUP BY VENTA_ID");
		return $query->row();
	}

	public function updateEstado($venta_id, $estado, $saldo)
    {
        $this->db->where('venta_id', $venta_id);
        $this->db->update($this->table, ['estado' => $estado, 'saldo' => $saldo]);
	}

	public function abonos_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT movimiento, SUM(importe) As total
		FROM cobranza AS v
		WHERE v.movimiento = 'A' AND (v.fecha>='$inicio' AND v.fecha<='$fin') GROUP BY movimiento");
		return $query;
	}

	public function doc_pendientes()
	{
		$query = $this->db->query("SELECT movimiento, SUM(importe) As total
		FROM cobranza AS v
		WHERE v.estado = 'P' GROUP BY movimiento");
		return $query;
	}

	public function estado_cuenta($id)
	{
		$query = $this->db->query("SELECT movimiento, id, no_referencia, concepto,  estado, cliente, importe, fecha, saldo, venta_id
		FROM cobranza 
		WHERE estado = 'P' AND cliente_id=$id ORDER BY venta_id, id ASC");
		return $query;
	}

	public function estado_cuenta_saldado_hoy($id)
	{
		$dia =date("Y-m-d");
		$query = $this->db->query("SELECT movimiento, id, no_referencia, concepto,  estado, cliente, importe, fecha, saldo, venta_id 
		FROM cobranza 
		WHERE venta_id in (SELECT DISTINCT venta_id FROM cobranza where fecha='$dia' AND estado='S' AND  cliente_id=$id) 
		ORDER BY venta_id, id ASC");
		return $query;
	}

	public function doc_saldo_cliente($id)
	{
		$query = $this->db->query("SELECT  SUM(saldo) As resta, SUM(importe) AS total
		FROM cobranza AS v
		WHERE v.estado = 'P' AND v.cliente_id=$id AND v.movimiento='C';");
		return $query->row();
	}

	public function getClienteByVentaId($id)
	{
		$query = $this->db->query("SELECT l.id, l.nombre FROM cobranza AS c JOIN clientes AS l ON c.cliente_id=l.id WHERE c.venta_id=$id AND c.movimiento='C'; ");
		return $query->row();
	}

	public function getDocPendientes()
	{
		$fecha = date('Y-m-d', strtotime("-30 days"));
		$query = $this->db->query("SELECT * FROM cobranza WHERE movimiento='C' and estado='P' and fecha>='$fecha';");
		return $query;
	}

	public function getDocAntiguos()
	{
		$fecha = date('Y-m-d', strtotime("-30 days"));
		$query = $this->db->query("SELECT * FROM cobranza WHERE movimiento='C' and estado='P' and fecha<'$fecha';");
		return $query;
	}

}
