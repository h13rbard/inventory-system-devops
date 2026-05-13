<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
<body onload="window.print();">
<br>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" style="table-layout: fixed; width: 260px;">
	<tr>
        <td align="center" style="width: 30%">
            <img src="<?=base_url().$empresa->logo?>" alt="" srcset="" width="50"><br>
        </td>
        <td align="center" style="width: 70%; font-size: 120%">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        <?=$empresa->nombre?><br>
        <?=$empresa->eslogan?><br>
        </td>
    </tr>
    <tr>
        <td  align="center" colspan="2">
		<?=$empresa->direccion?><br>
		<?=$empresa->ciudad?><br>
		<?=$empresa->correo?>
        </td>
    </tr>
	<tr>
        <td align="left" colspan="2" style="padding-top: 10px;">
		CLIENTE: <?=$enc->cliente?><br>
		<?php echo 'TICKET: '.$enc->folio; ?>
        </td>
    </tr>
	<!-- <tr>
        <td align="center" colspan="2">
        </td>
    </tr> -->
</table>
<!-- <br> -->
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table align="center" style="table-layout: fixed; width: 250px;">
    <tr>
        <td style="width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;">CANT.</td>
        <td style="width: 150px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;" align="center">DESCRIPCIÓN</td>
        <td style="width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;" align="right">IMPORTE</td>
    </tr>
    <?php foreach($partidas->result() as $partida): ?>
    <tr>
        <td align="right" style="padding-top: 5px;"><?= number_format($partida->cantidad, 2) ?></td>
        <td align="center" style="padding-top: 5px;"><?= $partida->descrip ?></td>
        <td align="right" style="padding-top: 5px;"><?= number_format($partida->cantidad*$partida->precio, 2) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="3" style="border-top: 1px solid black;">&nbsp;</td>
    </tr>
    


    <!-- Mostramos los totales de la venta en el documento HTML -->
    <tr>
    <td colspan="3" align="center" style="font-size: 100%;">TOTAL: $ <?php echo number_format($enc->total,2);  ?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center">
      <?php echo date_format(date_create($enc->fecha), 'd/m/Y').' '.$enc->hora; ?><br>
      DEVOLUCIÓN</td>
    </tr>
</table>

</div>


</body>
</html>

