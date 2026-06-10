<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    protected $table = 'empresa';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('eslogan', 'Eslogan', 'trim|max_length[100]');
		$this->form_validation->set_rules('direccion', 'Dirección', 'trim|max_length[200]');
		$this->form_validation->set_rules('ciudad', 'Ciudad', 'trim|max_length[100]');
		$this->form_validation->set_rules('correo', 'Correo', 'trim|max_length[50]');
    }

    public function getData()
    {
        $data = array(
			'nombre' => ($this->input->post('nombre')),
			'direccion' => ($this->input->post('direccion')),
			'ciudad' => ($this->input->post('ciudad')),
			'correo' => ($this->input->post('correo')),
			'eslogan' => ($this->input->post('eslogan'))
        );
        return $data;
    }

    public function update($id)
    {
			$this->db->where('id', $id);
			$this->db->update($this->table, $this->getData());
    }

    public function getById($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
		}

		public function get()
    {
        $this->db->from($this->table);
        $this->db->where('id',1);
        $query = $this->db->get();
        return $query->row();
		}
	
		public function updateImagen($id, $imagen)
    {
        $data['logo'] = $imagen;
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
		}

}
