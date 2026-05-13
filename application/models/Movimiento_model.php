<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movimiento_model extends CI_Model {

    protected $table = 'movimientos';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
		$this->form_validation->set_rules('fecha', 'Fecha', 'trim|required');
		$this->form_validation->set_rules('total', 'Total', 'trim|required');
		$this->form_validation->set_rules('concepto_id', 'Concepto', 'trim|required');
		$this->form_validation->set_rules('observacion', 'Observación', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('formapago_id', 'Forma de pago', 'trim|required|max_length[100]');
    }

    public function getData()
    {
        $data = array(
			'fecha' => strtoupper($this->input->post('fecha')),
			'total' => $this->input->post('total'),
			'observacion' => strtoupper($this->input->post('observacion')),
			'concepto_id' => $this->input->post('concepto_id'),
			'formapago_id' => $this->input->post('formapago_id'),
        );
        return $data;
    }

    public function insert($tipo, $user_id)
    {
		date_default_timezone_set('America/Mexico_City'); 
		$data = $this->getData();
		$data['tipo'] = $tipo;
		$data['usuario_id'] = $user_id;
		$data['captura'] = date("Y-m-d H:i:s");;
        $this->db->insert($this->table, $data);
    }

    public function eliminar($id)
    {
		$data['borrado'] = 1;
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
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

    public function getList($tipo, $fecha)
    {
        $this->db->select('movimientos.id, movimientos.fecha, movimientos.observacion, movimientos.total, movimientos.tipo, conceptos.nombre');
		$this->db->from($this->table);
		$this->db->join('conceptos','movimientos.concepto_id=conceptos.id');
		$this->db->where('borrado','0');
		$this->db->where('movimientos.tipo',$tipo);
		$this->db->where('movimientos.fecha',$fecha);
        $query = $this->db->get();
        return $query;
	}
	
	public function getMovimientosPorDia($fecha)
    {
        $this->db->select('movimientos.id, movimientos.fecha, movimientos.observacion, movimientos.total, movimientos.tipo, conceptos.nombre AS concepto, categorias.nombre AS categoria, users.username');
		$this->db->from($this->table);
		$this->db->join('conceptos','movimientos.concepto_id=conceptos.id');
		$this->db->join('categorias','conceptos.categoria_id=categorias.id');
		$this->db->join('users','movimientos.usuario_id=users.id');
		$this->db->where('borrado','0');
		$this->db->where('movimientos.fecha',$fecha);
        $query = $this->db->get();
        return $query;
	}
	
	public function getMovimientosPeriodo($inicio, $fin)
	{
		$this->db->select('categorias.nombre AS categoria, conceptos.nombre As concepto, sum(total) AS total, movimientos.tipo ');
		$this->db->from('movimientos');
		$this->db->join('conceptos', 'movimientos.concepto_id=conceptos.id');
		$this->db->join('categorias', 'conceptos.categoria_id=categorias.id');
		$this->db->where('borrado', '0');
		$this->db->where('movimientos.fecha >=',$inicio);
		$this->db->where('movimientos.fecha <=',$fin);
		$this->db->group_by('categorias.nombre, conceptos.nombre, movimientos.tipo');
		$this->db->order_by('movimientos.tipo, categorias.nombre');
		$query = $this->db->get();
        return $query;
	}

}
