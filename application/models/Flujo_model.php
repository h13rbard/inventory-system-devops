<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flujo_model extends CI_Model {

    protected $table = 'flujo';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
		$this->form_validation->set_rules('tipo', 'Tipo', 'trim|required|max_length[1]');
		$this->form_validation->set_rules('concepto', 'Concepto', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('importe', 'Importe', 'trim|required|numeric');
    }

    public function getData()
    {
        $data = array(
			'tipo' => strtoupper($this->input->post('tipo')),
			'concepto' => mb_strtoupper($this->input->post('concepto')),
			'importe' => strtoupper($this->input->post('importe')),
			'proceso' => strtoupper($this->input->post('proceso')),
        );
        return $data;
    }

    public function insert()
    {
		date_default_timezone_set('America/Mexico_City'); 
		$data = $this->getData();
		$data['fecha'] = date("Y-m-d");
        $this->db->insert($this->table, $data);
	}
	
	public function insert_venta($no_referencia, $importe)
    {
		date_default_timezone_set('America/Mexico_City'); 
		$data = [
			'tipo' => 'I',
			'concepto' => 'VTA '.$no_referencia,
			'importe' => $importe,
			'proceso' => 'VTA',
			'fecha' => date("Y-m-d")
		];
        $this->db->insert($this->table, $data);
	}

	public function insert_abono($no_referencia, $importe)
    {
		date_default_timezone_set('America/Mexico_City'); 
		$data = [
			'tipo' => 'I',
			'concepto' => 'ABONO '.$no_referencia,
			'importe' => $importe,
			'proceso' => 'COB',
			'fecha' => date("Y-m-d")
		];
        $this->db->insert($this->table, $data);
	}
	
	public function insert_dev($no_referencia, $importe)
    {
		date_default_timezone_set('America/Mexico_City'); 
		$data = [
			'tipo' => 'E',
			'concepto' => 'DEV '.$no_referencia,
			'importe' => $importe,
			'proceso' => 'DEV',
			'fecha' => date("Y-m-d")
		];
        $this->db->insert($this->table, $data);
	}
	
	public function insert_inicial($importe)
    {
		date_default_timezone_set('America/Mexico_City'); 
		$data = [
			'tipo' => 'I',
			'concepto' => 'SALDO INICIAL',
			'importe' => $importe,
			'proceso' => 'INI',
			'fecha' => date("Y-m-d")
		];
        $this->db->insert($this->table, $data);
	}

    public function update($id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $this->getData());
	}
	
	public function eliminar($id)
    {
		$data['borrado'] = 1;
		$this->db->where('id', $id);
		$this->db->where('corte_id IS NULL');
        $this->db->update($this->table, $data);
    }

    public function getById($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

	public function movimientos_pendientes()
	{
		$query = $this->db->query("SELECT * 
		FROM flujo  
		WHERE borrado=0 AND corte_id is null");
		return $query;
	}

	public function get_saldo_caja()
	{
		$query = $this->db->query("SELECT tipo, SUM(importe) AS total
		FROM flujo  
		WHERE borrado=0 AND corte_id is null GROUP BY tipo");
		return $query;
	}

	public function movimientos_corte($id)
	{
		$query = $this->db->query("SELECT * 
		FROM flujo  
		WHERE borrado=0 AND corte_id=$id");
		return $query;
	}

	public function getCorteById($id)
    {
        $this->db->from('corte');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

	public function crear_corte($noReferencia)
    {
		date_default_timezone_set('America/Mexico_City'); 
		$data = array(
			'fecha' => date("Y-m-d"),
			'folio' => $noReferencia
        );
		$this->db->insert('corte', $data);
		
		$id = $this->db->insert_id();

		// $folio = array(
		// 	'folio' => str_pad($id, 6, "0", STR_PAD_LEFT)
		// );

		// $this->db->where('id', $id);
		// $this->db->update('corte', $folio);

		$this->actualizar_flujo_corte($id);

		return $id;
	}

	public function get_saldo($corte_id)
	{
		$query = $this->db->query("SELECT SUM(IF(tipo='I', importe, importe*-1)) AS saldo FROM flujo WHERE borrado=0 AND corte_id=$corte_id;");
		return $query->row();
	}
	
	public function actualizar_flujo_corte($id)
	{
		$data = array(
			'corte_id' => $id
		);
		$this->db->where('corte_id IS NULL');
		$this->db->update('flujo', $data);
	}

	public function movimientos_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT * FROM flujo WHERE borrado=0 AND (fecha>='$inicio' AND fecha<='$fin')");
		return $query;
	}

	public function por_periodo_agrupado($inicio, $fin)
	{
		$query = $this->db->query("SELECT tipo, proceso, SUM(importe) As total FROM flujo where fecha>='$inicio' and fecha<='$fin' and borrado=0 group by tipo, proceso order by tipo, proceso");
		return $query;
	}

}
