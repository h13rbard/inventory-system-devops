<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Folio_model extends CI_Model {

    protected $table = 'folios';

    function __construct()
    {
        parent::__construct();
    } 

    public function rules()
    {
        $this->form_validation->set_rules('serie', 'Serie', 'trim|required|max_length[10]');
        $this->form_validation->set_rules('consecutivo', 'Consecutivo', 'trim|required');
        $this->form_validation->set_rules('longitud', 'Longitud', 'trim|required');
        $this->form_validation->set_rules('clave_proceso', 'Clave proceso', 'trim|required|max_length[3]');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('tipo', 'Tipo', 'trim|max_length[50]');
		$this->form_validation->set_rules('tipo_id', 'Id del tipo', 'trim|required');
		$this->form_validation->set_rules('activo', 'Activo', 'trim|required');
    }

    public function getData()
    {
        return $dataDepartamento = array(
            'serie' => strtoupper($this->input->post('serie')),
            'consecutivo' => strtoupper($this->input->post('consecutivo')),
            'longitud' => strtoupper($this->input->post('longitud')),
            'clave_proceso' => strtoupper($this->input->post('clave_proceso')),
            'descripcion' => strtoupper($this->input->post('descripcion')),
            'tipo' => strtoupper($this->input->post('tipo')),
            'tipo_id' => strtoupper($this->input->post('tipo_id')),
            'activo' => $this->input->post('activo')
        );
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

    public function getById($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getNoReferencia($proceso, $tipo = '', $tipoId = 0)
    {
        $this->db->from($this->table);
        $this->db->where('clave_proceso', $proceso);
        $this->db->where('tipo', $tipo);
        $this->db->where('tipo_id', $tipoId);
        $this->db->where('activo', 1);
        $folio = $this->db->get()->row();

        if (is_null($folio) )
            return ["noReferencia" => "", "error" => true, "mensaje" => "El tipo ".$tipo." no fue encontrado en el proceso ".$proceso."."];

        $longitudAux = $folio->longitud - strlen($folio->serie);
        if ($longitudAux < 0 )
            return ["noReferencia" => "", "error" => true, "mensaje" => "La serie es de mayor longitud que el tamaño del folio que se desea generar."];
        
        if (strlen($folio->consecutivo.'') > $longitudAux)
            return ["noReferencia" => "", "error" => true, "mensaje" => "El consecutivo ".$folio->consecutivo." del folio ".$folio->serie." se ha terminado le sugerimos cambiar de serie."];

        $noReferencia = $folio->serie.str_pad($folio->consecutivo, $longitudAux, "0", STR_PAD_LEFT);
        $this->incrementarConsecutivo($folio->consecutivo, $folio->id);
        return ["noReferencia" => $noReferencia, "error" => false, "mensaje" => ""];
    }

    private function incrementarConsecutivo($consecutivo, $id)
    {
        $this->consecutivo = $consecutivo + 1;
        $this->db->update($this->table, $this, array('id' => $id));
	}
	
	// public static function generar($proceso, $tipo = '', $tipo_id = 0)
    // {
    //     $folio = DB::table('sis_folios')
    //     ->where('clave_proceso', $proceso)
    //     ->where('tipo', $tipo)
    //     ->where('tipo_id', $tipo_id)
    //     ->where('activo', 1)
    //     ->first();

    //     if (is_null($folio) )
    //         $resultado = ["noReferencia" => "", "error" => true, "mensaje" => "El tipo ".$tipo." no fue encontrado en el proceso ".$proceso."."];

    //     $longitudAux = $folio->longitud - strlen($folio->serie);
    //     if ($longitudAux < 0 )
    //         $resultado = ["noReferencia" => "", "error" => true, "mensaje" => "La serie es de mayor longitud que el tamaño del folio que se desea generar."];

    //     if (strlen($folio->consecutivo.'') > $longitudAux)
    //         $resultado = ["noReferencia" => "", "error" => true, "mensaje" => "El consecutivo ".$folio->consecutivo." del folio ".$folio->serie." se ha terminado le sugerimos cambiar de serie."];

    //     $noReferencia = $folio->serie.str_pad($folio->consecutivo, $longitudAux, "0", STR_PAD_LEFT);
    //     self::incrementarConsecutivo($folio->consecutivo, $folio->id);
    //     $resultado = ["noReferencia" => $noReferencia, "error" => false, "mensaje" => ""];

    //     return $resultado;
    // }


}
