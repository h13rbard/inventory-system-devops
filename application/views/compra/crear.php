<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<div class="block">

					<h3>Crear Nueva Compra</h3><br>
					<div class="table-responsive">
					<form action="<?=base_url()?>compra/nueva_compra" method="post">
					<table class="table table-sm">
					<tr>
					<td>Proveedor</td>
					<td>
					<select name="proveedor_id" id="proveedor_id" class="form-control form-control-sm">
					<?php foreach($proveedores->result() as $item) :?>
					<option value="<?=$item->id?>"><?=$item->nombre?></option>
					<?php endforeach; ?>
					</select>
					</td>
					</tr>
					<tr>
					<td>Nota/Factura</td>
					<td>
					<input type="text" name="no_referencia" id="" required maxlength="50" autocomplete="off" class="form-control form-control-sm">
					</td>
					</tr>
					<tr>
					<td>Fecha compra</td>
					<td>
					<input type="date" name="fecha_compra" id="" required class="form-control form-control-sm" value="<?=date('Y-m-d')?>">
					</td>
					</tr>
					<tr>
					<td></td>
					<td>
					<!-- <a href="<?=base_url()?>compra" class="btn btn-secondary">Regresar</a> -->
					<button type="submit" class="btn btn-success">Guardar</button>
					</td>
					</tr>
					</table>
					</form>
					</div>
				</div>
		</div>
	</div>
</section>
