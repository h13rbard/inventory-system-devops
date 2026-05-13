<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor_model extends CI_Model {

    protected $table = 'proveedores';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[50]');
    }

    public function getData()
    {
        $data = array(
			'nombre' => mb_strtoupper($this->input->post('nombre'))
        );
        return $data;
    }

    public function insert($noReferencia)
    {
		$data = $this->getData();
		$data['clave'] =  $noReferencia;
        $this->db->insert($this->table, $data);
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

}
