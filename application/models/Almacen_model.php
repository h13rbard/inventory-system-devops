<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Almacen_model extends CI_Model {

    protected $table = 'almacenes';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[25]');
		$this->form_validation->set_rules('clave', 'Clave', 'trim|max_length[3]');
		$this->form_validation->set_rules('tipo', 'Tipo', 'trim|max_length[25]');
    }

    public function getData()
    {
        $data = array(
			'nombre' => mb_strtoupper($this->input->post('nombre')),
			'clave' => mb_strtoupper($this->input->post('clave')),
			'tipo' => strtoupper($this->input->post('tipo')),
        );
        return $data;
    }

    public function insert()
    {
		$this->db->insert($this->table, $this->getData());
		
		$id = $this->db->insert_id();

		return $id;
    }

    public function update($id)
    {
		$this->db->where('id', $id);
		$this->db->update($this->table, $this->getData());
    }

    public function existeNombre($id, $valor)
    {
        $this->db->where('nombre', $valor);
        $this->db->where('id <>', $id);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->num_rows();
    }

	public function existeClave($id, $valor)
    {
        $this->db->where('clave', $valor);
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
        $this->db->select('id, clave, nombre');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query;
    }

}
