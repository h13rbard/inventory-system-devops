<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relacionados_model extends CI_Model {

    protected $table = 'relacionados';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
		$this->form_validation->set_rules('clave1', 'Clave 1', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('clave2', 'Clave 2', 'trim|required|max_length[50]');
    }

	public function rules2()
	{
		$this->form_validation->set_rules('comentario', 'Comentario', 'trim|max_length[250]');
	}

    public function getData()
    {
        $data = array(
			'comentario' => mb_strtoupper($this->input->post('comentario'))
        );
        return $data;
    }

    public function insert($prod1, $prod2)
    {
		$this->db->insert($this->table, [
			'producto1_id' => $prod1,
			'producto2_id' => $prod2
		]);
		
		$id = $this->db->insert_id();

		return $id;
    }

    public function update($id)
    {
		$this->db->where('id', $id);
		$this->db->update($this->table, $this->getData());
    }

   
    public function getById($id)
    {
		$query = $this->db->query("SELECT r.id, p1.descrip AS prod1, p2.descrip AS prod2, p1.clave_art AS clave1, p2.clave_art AS clave2, r.comentario 
		FROM relacionados r JOIN productos p1 ON r.producto1_id=p1.id 
		JOIN productos p2 ON r.producto2_id=p2.id
		WHERE r.id = $id
		");
        return $query->result()[0];
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

	public function delete($id)
    {
        $this->db->where('id', $id);
		$this->db->delete($this->table);
	}

}
