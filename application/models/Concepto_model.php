<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concepto_model extends CI_Model {

    protected $table = 'conceptos';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('categoria_id', 'Categoria', 'trim|required');
    }

    public function getData()
    {
        $data = array(
            'nombre' => strtoupper($this->input->post('nombre')),
            'categoria_id' => $this->input->post('categoria_id')
        );
        return $data;
    }

    public function insert()
    {
        $this->db->insert($this->table, $this->getData());
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

    public function getListByTipo($tipo)
    {
		$this->db->select('conceptos.id, conceptos.nombre, categorias.nombre AS categoria');
		$this->db->from($this->table);
		$this->db->join('categorias', 'conceptos.categoria_id = categorias.id');
        $this->db->where('tipo', $tipo);
        $this->db->order_by('categorias.id');
        $query = $this->db->get();
        return $query;
    }

}
