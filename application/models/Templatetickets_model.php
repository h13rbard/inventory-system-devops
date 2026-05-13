<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templatetickets_model extends CI_Model {

    protected $table = 'template_tickets';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
		$this->form_validation->set_rules('formato', 'Formato', 'trim|required');
		$this->form_validation->set_rules('clave', 'Clave', 'trim|max_length[5]');
    }

    public function getData()
    {
        $data = array(
			'formato' => $this->input->post('formato'),
			'clave' => mb_strtoupper($this->input->post('clave')),
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

    public function getByClave($clave)
    {
        $this->db->from($this->table);
        $this->db->where('clave',$clave);
        $query = $this->db->get();
        return $query->row();
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
        $this->db->select('id, clave');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query;
    }

}
