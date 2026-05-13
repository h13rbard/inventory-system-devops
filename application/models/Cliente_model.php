<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    protected $table = 'clientes';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('direccion', 'Dirección', 'trim|max_length[100]');
		$this->form_validation->set_rules('telefono', 'Telefono', 'trim|max_length[20]');
		$this->form_validation->set_rules('correo', 'Correo', 'trim|max_length[50]');
    }

    public function getData()
    {
        $data = array(
			'nombre' => mb_strtoupper($this->input->post('nombre')),
			'direccion' => mb_strtoupper($this->input->post('direccion')),
			'telefono' => strtoupper($this->input->post('telefono')),
			'correo' => strtoupper($this->input->post('correo'))
        );
        return $data;
    }

    public function insert($noReferencia)
    {
		$this->db->insert($this->table, $this->getData());
		
		$id = $this->db->insert_id();

		$folio = array(
			'clave' => $noReferencia //str_pad($id-1, 5, "0", STR_PAD_LEFT)
		);

		$this->db->where('id', $id);
		$this->db->update($this->table, $folio);
		return $id;
    }

    public function update($id)
    {
		if ($id > 1) {
			$this->db->where('id', $id);
			$this->db->update($this->table, $this->getData());
		}
    }

    public function existeNombre($id, $valor)
    {
        $this->db->where('nombre', $valor);
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
        $this->db->select('id, nombre');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query;
    }

	public function ventas_periodo($id, $inicio, $fin)
	{
		$query = $this->db->query("SELECT id, doc, folio, total, fecha, hora, pago
		FROM venta AS v
		WHERE v.doc IN ('VTA', 'DEV') AND v.estado='C' AND (v.fecha>='$inicio' AND v.fecha<='$fin') AND v.cliente_id=$id");
		return $query;
	}

}
