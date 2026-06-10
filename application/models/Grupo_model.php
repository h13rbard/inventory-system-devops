<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo_model extends CI_Model {

    protected $table = 'grupos';

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

    public function insert()
    {
        $this->db->insert($this->table, $this->getData());
    }

    public function update($id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $this->getData());
	}

	public function delete($id)
    {
        $this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	public function eliminar_grupo($id)
	{
        $this->db->where('grupo_id', $id);
        $this->db->update('productos', ['grupo_id' => null]);
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

	public function no_productos()
	{
		// $query = $this->db->query("SELECT g.id, g.nombre, count(p.grupo_id) as no_productos, sum(p.existencias*p.precio_compra) as importe FROM grupos as g left JOIN productos as p ON g.id=p.grupo_id GROUP BY g.id ORDER BY no_productos DESC;");
		$query = $this->db->query("SELECT g.id, g.nombre, t.no_productos, t.importe FROM
		(SELECT p.grupo_id, count(*) as no_productos, sum(p.existencias*p.precio_compra) as importe FROM productos AS p where p.existencias>0 GROUP BY p.grupo_id) t LEFT JOIN grupos as g ON t.grupo_id=g.id  ORDER BY t.importe DESC;");
		return $query;
	}
}
