<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Producto_model extends CI_Model {

    protected $table = 'productos';

    function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
		$this->form_validation->set_rules('clave_art', 'Clave articulo', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('codigo_b', 'Codigo barras', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('clave_prov', 'Codigo proveedor', 'trim|max_length[50]');
		$this->form_validation->set_rules('marca', 'Marca', 'trim|max_length[25]');
		$this->form_validation->set_rules('unidad', 'Unidad', 'trim|max_length[25]');
        $this->form_validation->set_rules('descrip', 'Descripción', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('precio_compra', 'Precio compra', 'trim|required|numeric');
		$this->form_validation->set_rules('precio_uni', 'Precio ultima compra', 'trim|required|numeric');
		$this->form_validation->set_rules('precio_venta_aux', 'Precio venta publico', 'trim|required|numeric');
		$this->form_validation->set_rules('precio_venta', 'Precio venta', 'trim|required|numeric');
		$this->form_validation->set_rules('existencias', 'Existencias', 'trim|required|numeric');
		$this->form_validation->set_rules('localizacion', 'Localización', 'trim|max_length[25]');
		$this->form_validation->set_rules('minimo', 'Minimo', 'trim|required|numeric');
		$this->form_validation->set_rules('url', 'URL', 'trim|max_length[500]|valid_url');
    }

    public function getData()
    {
        $data = array(
			'clave_art' => strtoupper($this->input->post('clave_art')),
			'codigo_b' => strtoupper($this->input->post('codigo_b')),
			'clave_prov' => strtoupper($this->input->post('clave_prov')),
			'marca' => mb_strtoupper($this->input->post('marca')),
			'descrip' => mb_strtoupper($this->input->post('descrip')),
			'unidad' => strtoupper($this->input->post('unidad')),
			'precio_compra' => $this->input->post('precio_compra'),
			'precio_uni' => $this->input->post('precio_uni'),
			'precio_venta_aux' => $this->input->post('precio_venta_aux'),
			'precio_venta' => $this->input->post('precio_venta'),
			'existencias' => $this->input->post('existencias'),
			'localizacion' => strtoupper($this->input->post('localizacion')),
			'minimo' => $this->input->post('minimo'),
			'proveedor_id' => $this->input->post('proveedor_id'),
			'actualiza' => $this->input->post('actualiza'),
			'url' => $this->input->post('url'),
        );
        return $data;
    }

    public function insert()
    {
		$data = $this->getData();
		$data['act_pre'] = date("Y-m-d");
		$data['fecha_alta'] = date("Y-m-d");
        $this->db->insert($this->table, $data);
    }

    public function update($id, $user_id)
    {
		$obj = $this->getById($id);

		$data = $this->getData();
		if ($obj->precio_venta != $this->input->post('precio_venta')) {
			$data['act_pre'] = date("Y-m-d");
			$this->historialProducto($obj->id, 'precio_venta', number_format($obj->precio_venta, 2), number_format($this->input->post('precio_venta'), 2), $user_id);
		}

		if ($obj->precio_compra != $this->input->post('precio_compra')) {
			$this->historialProducto($obj->id, 'costo', number_format($obj->precio_compra, 2), number_format($this->input->post('precio_compra'), 2), $user_id);
		}

		if ($obj->existencias != $this->input->post('existencias')) {
			$this->historialProducto($obj->id, 'existencias', number_format($obj->existencias, 2), number_format($this->input->post('existencias'), 2), $user_id);
			// AJUSTE
			$this->load->model('Movsinv_model');
			if ($obj->existencias > $this->input->post('existencias')) {
				$this->Movsinv_model->ajuste($id, $obj->existencias - $this->input->post('existencias'), 1, 7, $user_id);
			} else {
				$this->Movsinv_model->ajuste($id, $this->input->post('existencias') - $obj->existencias, 7, 1, $user_id);
			}
		}

		$data['baja'] = $this->input->post('baja');
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function updateImagen($id, $imagen)
    {
        $data['imagen'] = $imagen;
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
	}
	
	public function getByClave($clave)
    {
        $this->db->from($this->table);
        $this->db->where('clave_art',$clave);
        $query = $this->db->get();
        return $query->row();
    }

	public function updateGrupo($id, $grupo_id)
    {
        $data['grupo_id'] = $grupo_id;
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function existeNombre($id, $valor)
    {
		$this->db->where('clave_art', $valor);
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
	
	public function getByCodigoBarras($codigo)
    {
        $this->db->from('productos');
        $this->db->where('codigo_b',$codigo);
        $query = $this->db->get();
        return $query->row();
	}
	
	public function val_inv()
	{
		$query = $this->db->query("SELECT id, clave_art, clave_prov, codigo_b, descrip, precio_compra, precio_venta, existencias ".
		"FROM productos ".
		"WHERE existencias>0 ORDER BY descrip");
		return $query;
	}

	public function valor_inventario()
	{
		$query = $this->db->query("SELECT SUM(precio_compra * existencias) AS total ".
		"FROM productos ".
		"WHERE existencias>0");
		return $query;
	}

	public function numero_productos()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total ".
		"FROM productos ".
		"WHERE baja=0");
		return $query;
	}

	public function productos_con_existencia()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total ".
		"FROM productos ".
		"WHERE baja=0 AND existencias>0");
		return $query;
	}

	public function clasificacion()
	{
		$query = $this->db->query("SELECT id, clave_art, clave_prov, codigo_b, descrip, precio_compra, precio_venta, existencias, clasif, marca ".
		"FROM productos ".
		"ORDER BY clasif ASC, precio_compra DESC;");
		return $query;
	}

	public function por_marcas()
	{
		$query = $this->db->query("SELECT id, clave_art, clave_prov, descrip, precio_compra, precio_venta, marca, url, existencias, act_pre, clasif ".
		"FROM productos ".
		"ORDER BY proveedor_id ASC, marca ASC, descrip ASC;");
		return $query;
	}

	public function por_grupo($grupo)
	{
		$query = $this->db->query("SELECT id, clave_art, clave_prov, descrip, precio_compra, precio_venta, existencias, clasif ".
		"FROM productos ".
		"WHERE grupo_id=$grupo;");
		return $query;
	}

	public function sin_exis()
	{
		$query = $this->db->query("SELECT id, clave_art, clave_prov, codigo_b, descrip, precio_compra, precio_venta, existencias, clasif ".
		"FROM productos ".
		"WHERE existencias=0 AND baja=0 ORDER BY clasif, descrip");
		return $query;
	}

	public function por_debajo($porcentaje)
	{
		$x = ($porcentaje/100) + 1;
		$query = $this->db->query("SELECT id,clave_art, clave_prov, codigo_b, descrip, precio_compra, precio_venta, existencias, (precio_venta/precio_compra) AS utilidad ".
		"FROM productos ".
		"where baja=0 AND existencias > 0 AND (precio_venta/precio_compra) < $x ".
		"order by precio_compra DESC");
		return $query;
	}

	public function stock_bajo()
	{
		$query = $this->db->query("SELECT p.id,p.clave_art, p.clave_prov, p.marca, p.codigo_b, p.descrip, p.precio_compra, p.precio_venta, p.existencias, p.minimo, r.nombre AS proveedor, p.clasif ".
		"FROM productos AS p JOIN proveedores AS r ON p.proveedor_id=r.id ".
		"where p.minimo > 0 AND (p.minimo-p.existencias) > 0 AND p.baja=0 ".
		"order by r.id, p.precio_compra DESC");
		return $query;
	}

	public function sin_stock()
	{
		$query = $this->db->query("SELECT p.id,p.clave_art, p.clave_prov, p.marca, p.codigo_b, p.descrip, p.precio_compra, p.precio_venta, p.existencias, p.minimo, r.nombre AS proveedor, p.clasif ".
		"FROM productos AS p JOIN proveedores AS r ON p.proveedor_id=r.id ".
		"where p.minimo > 0 AND p.existencias = 0 AND baja=0 ".
		"order by r.id ASC, p.precio_compra DESC");
		return $query;
	}

	public function dif_costo_venta($diff)
	{
		$query = $this->db->query("SELECT id,clave_art, clave_prov, marca, codigo_b, descrip, precio_compra, precio_venta, precio_venta_aux, existencias, (precio_venta-precio_compra) AS utilidad ".
		"FROM productos ".
		"where (precio_venta-precio_compra) <= $diff ".
		"order by utilidad DESC");
		return $query;
	}

	public function actualiza_precios($inicio, $fin, $proveedor_id)
	{
		$query = $this->db->query("SELECT id,clave_art, descrip, precio_compra, precio_venta ".
		"FROM productos ".
		"where (precio_compra >= $inicio AND precio_compra <= $fin) AND actualiza = 1 AND proveedor_id=$proveedor_id ORDER BY precio_compra DESC;");
		return $query;
	}

	public function actualizar_precios($porcentaje, $inicio, $fin, $proveedor_id)
	{
		$query = $this->db->query("UPDATE productos SET act_pre = '".date("Y-m-d")."', precio_venta = ".
		"if((precio_compra*$porcentaje)-truncate(precio_compra*$porcentaje, 0) >= .5, ".
			"if ((precio_compra*$porcentaje)-truncate(precio_compra*$porcentaje, 0) =.5, precio_compra*$porcentaje, truncate(precio_compra*$porcentaje, 0)+1), ".
		  "if ((precio_compra*$porcentaje)-truncate(precio_compra*$porcentaje, 0) =.0, precio_compra*$porcentaje, truncate(precio_compra*$porcentaje, 0)+0.5) ".
		  ") WHERE (precio_compra >= $inicio AND precio_compra <= $fin) AND actualiza = 1 AND proveedor_id =$proveedor_id;");
		return $query;
	}

	public function por_proveedor()
	{
		$query = $this->db->query("SELECT p.proveedor_id, r.nombre, count(p.proveedor_id) AS num, sum(p.existencias*p.precio_compra) AS importe FROM productos AS p JOIN proveedores AS r ON p.proveedor_id=r.id WHERE existencias > 0 GROUP BY p.proveedor_id ");
		return $query;
	}

	public function precio_actualizacion($fecha)
	{
		$this->db->select('id, clave_art, descrip, precio_compra, precio_venta, existencias, act_pre');
		$this->db->from($this->table);
        $this->db->where('act_pre >=', $fecha);
        $this->db->order_by('act_pre');
        $query = $this->db->get();
        return $query;
	}

	public function fecha_act()
	{
		$query = $this->db->query("SELECT id, clave_art, clave_prov, codigo_b, descrip, precio_compra, precio_venta, existencias, act_pre ".
		"FROM productos ".
		"ORDER BY act_pre DESC, descrip ASC");
		return $query;
	}

	public function vtas_x_prod($id)
	{
		$query = $this->db->query("SELECT v.doc, v.folio, v.estado, v.fecha, p.precio, p.cantidad FROM partventa AS p JOIN venta AS v ON p.venta_id=v.id WHERE p.producto_id=$id AND v.estado='C';");
		return $query;
	}

	public function compras_x_prod($id)
	{
		$query = $this->db->query("SELECT c.doc, c.folio, c.estado, c.fecha, p.precio, p.cantidad FROM partcompra AS p JOIN compra AS c ON p.compra_id=c.id WHERE p.producto_id=$id AND c.estado='C';");
		return $query;
	}

	public function reiniciar_minimos()
	{
		// minimo=0, 
		$query = $this->db->query("UPDATE productos SET minimo=1, clasif='C';");
		return $query;
	}

	public function clasif_sin_venta()
	{
		// Los q no tienen venta son clasificacioin D
		$query = $this->db->query("UPDATE productos SET clasif='D' WHERE ult_vta IS NULL");
		return $query;
	}

	public function actualizar_minimo($id, $minimo, $clasif)
	{
		$minimo = $minimo == 0 ? 1 : $minimo;
		$query = $this->db->query("UPDATE productos SET minimo=$minimo, clasif='$clasif' WHERE id=$id;");
		return $query;
	}

	public function historialProducto($id, $campo, $original, $nuevo, $user_id)
	{
		$this->db->insert('historial_productos', [
			'producto_id' => $id,
			'campo' => $campo,
			'valor_original' => $original,
			'valor_nuevo' => $nuevo,
			'fecha' => date('Y-m-d'),
			'hora' => date('H:i:s'),
			'user_id' => $user_id
		]);
	}

	public function getHistorial($id)
	{
		$query = $this->db->query("SELECT h.id, h.producto_id, h.campo, h.valor_original, h.valor_nuevo, h.fecha, h.hora, u.username FROM historial_productos AS h JOIN users AS u ON h.user_id=u.id WHERE h.producto_id=$id ORDER BY h.id DESC");
		return $query;
	}

	public function getHistorialPorDia($fecha)
	{
		$query = $this->db->query("SELECT h.id, h.producto_id, p.clave_art, p.descrip, h.campo, h.valor_original, h.valor_nuevo, h.fecha, h.hora, u.username FROM historial_productos AS h JOIN productos p ON h.producto_id=p.id JOIN users AS u ON h.user_id=u.id WHERE h.fecha='$fecha' ORDER BY h.id DESC");
		return $query;
	}

	public function reactivar($id)
	{
		$data['baja'] = 0;
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
	}

	public function updatePrecioCosto($id, $precio)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, [
			'precio_venta' => $precio,
			'act_pre' => date("Y-m-d")
		]);
	}

	public function updateCostoCantidad($id, $costo, $cantidad)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, [
			'precio_compra' => $costo,
			'existencias' => $cantidad
		]);
	}

	public function updateCantidad($id, $cantidad)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, [
			'existencias' => $cantidad,
		]);
	}

	public function actualizarUltimaVenta($fecha)
	{
		// productos que sse vendieron en el dia
		$query = $this->db->query("UPDATE productos AS x 
		JOIN partventa p ON x.id=p.producto_id
		join  venta v on p.venta_id=v.id
		set x.ult_vta=v.fecha 
		where p.producto_id=x.id and v.fecha='$fecha';");
		return $query;
	}

	public function sin_venta()
	{
		$query = $this->db->query("SELECT id, clave_art, descrip, precio_compra, precio_venta, existencias, fecha_alta, (precio_compra*existencias) AS importe FROM productos WHERE ult_vta is null and baja=0 order by importe desc;");
		return $query;
	}

	public function modif_exis_periodo($inicio, $fin)
	{
		$query = $this->db->query("SELECT h.id, p.clave_art, p.descrip, h.valor_original, h.valor_nuevo, h.fecha, h.hora, u.username FROM historial_productos h join productos p on h.producto_id=p.id JOIN users u on h.user_id=u.id where campo='existencias' and (h.fecha>='$inicio' and h.fecha<='$fin');");
		return $query;
	}

	public function ult_venta($fecha)
	{
		$query = $this->db->query("SELECT id, clave_art, descrip, precio_compra, precio_venta, existencias, fecha_alta, (precio_compra*existencias) AS importe, ult_vta FROM productos WHERE (ult_vta is not null and ult_vta<'$fecha') and baja=0 order by importe desc;");
		return $query;
	}

	public function claves_parecidas()
	{
		$query = $this->db->query("SELECT p.id, clave_art, descrip, r.producto2_id, s.producto1_id  FROM productos AS p LEFT JOIN relacionados AS r ON p.id=r.producto1_id LEFT JOIN  relacionados AS s ON p.id=s.producto2_id ORDER BY clave_art");
		return $query;
	}

}
