<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation', 'datatables'));
        $this->form_validation->set_error_delimiters('', '');
		$this->load->helper(array('url'));
		
		$this->lang->load('auth');
        if (!$this->ion_auth->logged_in())
            redirect('auth/login', 'refresh');
    }

	public function index()
	{
		$group_id = $this->ion_auth->user()->row()->group_id;
		$this->load->library('Permisos');
		$this->permisos->check('empresa/index',$group_id);

		$this->load->model('Empresa_model');
        $data['empresa'] = $this->Empresa_model->getById(1);

		$this->load->view('layout/header', ['group_id' => $group_id]);
		$this->load->view('empresa/index', $data);
		$this->load->view('layout/footer');
		$this->load->view('empresa/index-js');
		$this->load->view('layout/close');
	}

    public function ajax_update()
    {
        if (!$this->input->is_ajax_request())
            exit("No es AJAX");

        $this->load->helper(array('form'));
                
        $this->load->model('Empresa_model');
        
        $this->Empresa_model->rules();

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array("status" => FALSE, "mensaje" => validation_errors() ));
        } else {
            $update = $this->Empresa_model->update(1);
            echo json_encode(array("status" => TRUE, "mensaje" => "Registro guardado correctamente."));
        }
	}

	public function logo()
    {
		$id = 1;
        $imagen1 = $this->input->post("imagen1");

        $ruta = './images/'; // Ruta para almacenar el archivo
        $rutaGuardar = 'images/'; // Ruta para guardar en la DB, registro

        $ruta = str_replace("//", "/", $ruta);
        $rutaGuardar = str_replace("//", "/", $rutaGuardar);

        $config['upload_path']   = $ruta;
        $config['allowed_types'] = 'png|jpg|gif';
        $config['file_name']     = 'logo';  //Cambiar el nombre del archivo original al id recibido
        $config['overwrite']     = true;
        $config['max_size']     = 0;


        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');

        // Comprobar si no existe la carpeta, crearla
        if (!is_dir($ruta))
        {
            mkdir($ruta, 0777);
            $fp = fopen($ruta.'index.html', 'w');
            fwrite($fp, '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>');
            fclose($fp);
        }

        if ( ! $this->upload->do_upload('imagen1'))
        {
            $error = array('error' => $this->upload->display_errors('',''));
            echo json_encode(array("status" => FALSE, "mensaje" => $error['error']));
        } else {
            $this->load->model('Empresa_model');
			$this->Empresa_model->updateImagen($id, $rutaGuardar.$this->upload->data('file_name'));
			// echo $rutaGuardar.$this->upload->data('file_name');
			redirect('empresa/index', 'refresh');
        }
    }

	public function ticket($id)
	{
		$this->load->model('Templatetickets_model');
		$template_ticket = $this->Templatetickets_model->getByClave('EDOCT');

		// $this->load->model('Venta_model');
		// $this->load->model('Cobranza_model');
		// $this->load->model('Empresa_model');
        // $enc = $this->Venta_model->getById($id);
		// $part = $this->Cobranza_model->getMovimientos($id);
		// $empresa = $this->Empresa_model->get();

		// $this->load->model('Empresa_model');
        // $empresa = $this->Empresa_model->get();
		// $this->load->model('Desecho_model');
		// $enc = $this->Desecho_model->getById($id);
		// $part = $this->Desecho_model->getPartidas($id);

		$this->load->model('Cobranza_model');
		$saldo = $this->Cobranza_model->doc_saldo_cliente($id);
		$this->load->model('Empresa_model');
		$this->load->model('Cliente_model');
        $enc = $this->Cliente_model->getById($id);
		$partidas_aux = $this->Cobranza_model->estado_cuenta($id);
		$partidas_hoy = $this->Cobranza_model->estado_cuenta_saldado_hoy($id);
		$part = array_merge($partidas_aux->result(), $partidas_hoy->result());
		$empresa = $this->Empresa_model->get();

	$total_cargo = 0;
	$total_abono =0;
	$venta_id = 0;
	$resta_doc=0;
	$partidas = [];
	
	foreach($part as $partida) {
	if ($venta_id != $partida->venta_id && $venta_id!=0) {
		array_push($partidas, ['fecha' => '', 'concepto' => 'Resta', 'importe' => number_format($resta_doc, 2)]);
	$resta_doc = 0;
	}
	if ($partida->movimiento=='C') {
		array_push($partidas, ['fecha' => 'Folio:', 'concepto' => $partida->no_referencia, 'importe' => '']);
	}
	array_push($partidas, ['fecha' => $partida->fecha, 'concepto' => $partida->movimiento.' '.$partida->concepto, 'importe' => number_format($partida->importe, 2)]);
	$total_cargo += $partida->movimiento == 'C' ? $partida->importe : 0;
	$total_abono += $partida->movimiento == 'A' ? $partida->importe : 0;
	$venta_id = $partida->venta_id;
	$resta_doc += $partida->movimiento == 'C' ? $partida->importe : ($partida->importe*-1);
	}
	if ($venta_id!=0) {
		array_push($partidas, ['fecha' => '', 'concepto' => 'Resta', 'importe' => number_format($resta_doc, 2)]);
		$resta_doc = 0;
	}

		$data = array(
				'logo' => base_url().$empresa->logo,
				'nombre' => $empresa->nombre,
				'eslogan' => $empresa->eslogan,
				'direccion' => $empresa->direccion,
				'ciudad' => $empresa->ciudad,
				'correo' => $empresa->correo,
				'cliente' => $enc->nombre,
				'fecha_hora' => date_format(date_create(), 'd/m/Y H:i:s'),
				'partidas' => $partidas,
				'total_cargo' => number_format($total_cargo, 2),
				'total_abono' => number_format($total_abono, 2),
				'saldo' => number_format($total_cargo-$total_abono ,2)
		);

		$this->load->library('parser');
		$this->parser->parse_string($template_ticket->formato, $data);
	}

	private function tt()
	{
		return "<html>
		<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
		<style>
		body {
			margin: 0px; padding: 0;
			padding-bottom: 0px;
			font-size: 11px;
			
		}
		body, td, th {
			font-family: Tahoma;
			font-size:12px;
		
		}
		
		/*------------- Divisiones---------------- */
		.zona_total{
		width:400px;
		float:left;
		margin-left:50px;
		
		
		
		}
		.zona_impresion{
		
		width: 260px;
		padding:0px 0px 0px 0px;
		
		float:left;
		margin-left:00px;
		/*border-style: solid;
		border:1px solid  #999;
		box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4); 
		*/
		}
		</style>
		</head>
		<body onload=\"window.print();\">
		<br>
		<div class=\"zona_impresion\">
		<!-- codigo imprimir -->
		<br>
		<table border=\"0\" align=\"center\" style=\"table-layout: fixed; width: 260px;\">
			<tr>
				<td align=\"center\" style=\"width: 30%\">
					<img src=\"{logo}\" alt=\"\" srcset=\"\" width=\"50\"><br>
				</td>
				<td align=\"center\" style=\"width: 70%; font-size: 120%\">
				<!-- Mostramos los datos de la empresa en el documento HTML -->
				{nombre}<br>
				{slogan}<br>
				</td>
			</tr>
			<tr>
				<td  align=\"center\" colspan=\"2\">
				{direccion}<br>
				{ciudad}<br>
				{correo}
				</td>
			</tr>
			<tr>
				<td align=\"left\" colspan=\"2\" style=\"padding-top: 10px;\">
				CLIENTE: {cliente}<br>
				{folio}
				</td>
			</tr>
			<!-- <tr>
				<td align=\"center\" colspan=\"2\">
				</td>
			</tr> -->
		</table>
		<!-- <br> -->
		<!-- Mostramos los detalles de la venta en el documento HTML -->
		<table align=\"center\" style=\"table-layout: fixed; width: 250px;\">
			<tr>
				<td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\">CANT.</td>
				<td style=\"width: 150px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"center\">DESCRIPCIÓN</td>
				<td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"right\">IMPORTE</td>
			</tr>
			
			<?php echo number_format(34, 2)?>
			<?='asdasd'?>

			{partidas}
				<tr>
					<td align=\"right\" style=\"padding-top: 5px;\">{cantidad}</td>
					<td align=\"center\" style=\"padding-top: 5px;\">{descrip}</td>
					<td align=\"right\" style=\"padding-top: 5px;\">{precio}</td>
				</tr>
			{/partidas}

			<tr>
			  <td colspan=\"3\" style=\"border-top: 1px solid black;\">&nbsp;</td>
			</tr>
		
			<!-- Mostramos los totales de la venta en el documento HTML -->
			<tr>
			<td colspan=\"3\" align=\"center\" style=\"font-size: 100%;\">TOTAL: $ {total}</td>
			</tr>
			<tr>
			  <td colspan=\"3\">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan=\"3\" align=\"center\">
			  {fecha_hora}<br>
			  DESECHO</td>
			</tr>
		</table>
		
		</div>
		
		
		</body>
		</html>
		
		";
	}

}
