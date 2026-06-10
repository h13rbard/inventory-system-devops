<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResultadosSemanales_model extends CI_Model {

    protected $table = 'resultados_semanales';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
        $this->form_validation->set_rules('fecha', 'Fecha', 'trim|required');
		$this->form_validation->set_rules('semana', 'Semana', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('costo', 'Costos', 'trim|required|numeric');
		$this->form_validation->set_rules('venta_con', 'Venta contado', 'trim|required|numeric');
		$this->form_validation->set_rules('venta_cre', 'Venta credito', 'trim|required|numeric');
		$this->form_validation->set_rules('venta_total', 'Venta total', 'trim|required|numeric');
		$this->form_validation->set_rules('sueldo', 'Sueldo', 'trim|required|numeric');
		$this->form_validation->set_rules('compras', 'Compras', 'trim|required|numeric');
		$this->form_validation->set_rules('gastos', 'Gastos', 'trim|required|numeric');
		$this->form_validation->set_rules('desecho', 'Desecho', 'trim|required|numeric');
		$this->form_validation->set_rules('cobranza', 'Cobranza', 'trim|required|numeric');
    }

    public function getData()
    {
        $data = array(
			'semana' => mb_strtoupper($this->input->post('semana')),
			'fecha' => $this->input->post('fecha'),
			'costo' => $this->input->post('costo'),
			'venta_con' => $this->input->post('venta_con'),
			'venta_cre' => $this->input->post('venta_cre'),
			'venta_total' => $this->input->post('venta_total'),
			'sueldo' => $this->input->post('sueldo'),
			'compras' => $this->input->post('compras'),
			'gastos' => $this->input->post('gastos'),
			'desecho' => $this->input->post('desecho'),
			'cobranza' => $this->input->post('cobranza'),
        );
        return $data;
    }

    public function insert()
    {
		$data = $this->getData();
        $this->db->insert($this->table, $data);
    }

    public function update($id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $this->getData());
    }

    public function existeFecha($id, $valor)
    {
        $this->db->where('fecha', $valor);
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

    public function getAll()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query;
    }

    public function getList()
    {
        $this->db->select('id, semana');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query;
    }

	public function getPorPeriodo($inicio, $fin, $orden = false)
	{
		$stm = "SELECT * FROM resultados_semanales WHERE fecha>='$inicio' AND fecha<='$fin' ORDER BY fecha ";
		$stm .= !$orden ? 'DESC' : 'ASC'; 
		$query = $this->db->query($stm);
		return $query;
	}
}
