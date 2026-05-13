<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de kardex -->
				<div class="block">
						<h3>Kardex del producto</h3>
						<div class="table-responsive">
						<table class="table table-sm">
						<tr><td colspan="3"><?=$producto->clave_art.' - '.$producto->codigo_b?></td></tr>
						<tr><td colspan="3"><?=$producto->descrip?></td></tr>
						<tr><td colspan="3">Existencias: <?=number_format($producto->existencias, 2)?> | Costo: <?=number_format($producto->precio_compra, 2)?> | Venta: <?=number_format($producto->precio_venta, 2)?></td></tr>
						<tr>
						<form id="form">
						<input type="hidden" name="id" value="<?=$producto->id?>">
						<td>Almacen:</td>
						<td>
						<select name="almacen_id" id="" class="form-control form-control-sm">
						<?php foreach($almacenes->result() as $v) :?>
						<option value="<?=$v->id?>"><?=$v->clave.' '.$v->nombre?></option>
						<?php endforeach; ?>
						</select>
						</td>
						<td>
						<button type="submit" class="btn btn-sm btn-success">Consultar</button>
						</td>
						</form>
						</tr>
						</table>
						
						</div>
					
				</div>
				<!-- table de kardex -->

				<div class="block table-responsive">
					<div id="resultado"></div>
				</div>

			</div>
		</div>
	</div>
</section>
