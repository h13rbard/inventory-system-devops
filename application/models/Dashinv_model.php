<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashinv_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	public function valor_inventario()
	{
		$query = $this->db->query("SELECT SUM(precio_compra * existencias) AS total, COUNt(*) AS numero ".
		"FROM productos ".
		"WHERE existencias>0");
		return $query;
	}

	public function activos_bajas()
	{
		$query = $this->db->query("SELECT baja, COUNT(*) AS numero, COUNT(if(existencias>0, 1, NULL)) AS exis, COUNT(if(existencias=0, 1, NULL)) AS sin_exis ".
		"FROM productos GROUP BY baja ");
		return $query;
	}

	public function bajas_existencias()
	{
		$query = $this->db->query("SELECT clave_art, descrip, existencias ".
		"FROM productos WHERE existencias>0 AND baja=1 ");
		return $query;
	}

	public function clasif_productos()
	{
		$query = $this->db->query("SELECT clasif, baja, COUNT(if(existencias>0, 1, NULL)) AS exis, COUNT(if(existencias=0, 1, NULL)) AS sin_exis, count(*) AS productos, sum(precio_compra*existencias) AS importe from productos group by clasif, baja order by baja,clasif");
		return $query;
	}

	public function grupos_productos()
	{
		$query = $this->db->query("SELECT grupo_id, nombre, baja, COUNT(if(existencias>0, 1, NULL)) AS exis, COUNT(if(existencias=0, 1, NULL)) AS sin_exis, count(*) AS productos, sum(precio_compra*existencias) AS importe from productos left join grupos on productos.grupo_id=grupos.id group by grupo_id, nombre, baja order by baja,grupo_id");
		return $query;
	}

	public function proveedores_productos()
	{
		$query = $this->db->query("SELECT v.id, v.nombre, baja, COUNT(if(existencias>0, 1, NULL)) AS exis, COUNT(if(existencias=0, 1, NULL)) AS sin_exis, count(*) AS productos, sum(precio_compra*existencias) AS importe from productos p join proveedores v on p.proveedor_id=v.id group by v.id, v.nombre, baja order by v.id");
		return $query;
	}

	public function filtrar($clasificacion, $estado, $existencias)
	{
		$sql = "SELECT clave_art, clasif, baja, descrip, existencias, precio_compra, nombre as grupo FROM productos p LEFT JOIN grupos g ON p.grupo_id=g.id WHERE ";
		$w = " 1=1 ";
		if ($clasificacion == 1) {
			$w .= " AND clasif='A' ";
		} else if ($clasificacion == 2) {
			$w .= " AND clasif='B+' ";
		} else if ($clasificacion == 3) {
			$w .= " AND clasif='B' ";
		} else if ($clasificacion == 4) {
			$w .= " AND clasif='B-' ";
		} else if ($clasificacion == 5) {
			$w .= " AND clasif='C' ";
		} else if ($clasificacion == 6) {
			$w .= " AND clasif='D' ";
		}

		if ($estado == 1) {
			$w .= " AND baja=0 ";
		} else if ($estado == 2) {
			$w .= " AND baja=1 ";
		}

		if ($existencias == 1) {
			$w .= " AND existencias>0 ";
		} else if ($existencias == 2) {
			$w .= " AND existencias<=0 ";
		}

		// echo $sql.''.$w.'<br>';
		$query = $this->db->query($sql.''.$w);
		return $query;
	}

}
